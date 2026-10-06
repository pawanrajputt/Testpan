<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class SettingController extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->helper('project_status');

        if (empty($this->session->userdata('exam_center_id'))) {
            return redirect('signup');
        }

        if (
            !$this->session->userdata('is_owner_logged_in') ||
            !$this->session->userdata('selected_center_id')
        ) {
            redirect('/');
        }
    }


    public function helpSupport()
    {
        $data['result'] = $this->Common_model->getdata_array('custom_settings', '');

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/support', $data);
        $this->load->view('layouts/footer');
    }

    public function settings()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $data['center_data'] = $this->Common_model->getdata('tt_center', array('center_id' => $center_id));
        $data['result'] = $this->Common_model->getdata('tt_admin_users', array('id' => $data['center_data']->owner_user_id));


        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/setting', $data);
        $this->load->view('layouts/footer');
    }


    public function updateSetting()
    {
        $center_id = $this->session->userdata('exam_center_id');
        $data['center_data'] = $this->Common_model->getdata('tt_center', array('center_id' => $center_id));

        $updated_at = date('Y-m-d H:i:s');
        $name = $this->input->post('name');

        // Split the name into parts
        $name_parts = explode(' ', trim($name));

        // Assign first and last names
        $first_name = isset($name_parts[0]) ? $name_parts[0] : '';
        $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

        $examCenterdata = [
            'username'     => $name,
            'email'        => $this->input->post('email'),
            'mobile_phone' => $this->input->post('mobile_phone'),
            'updated' => $updated_at,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ];

        $result = $this->Common_model->UpdateRecord('tt_admin_users', $examCenterdata, ['id' => $data['center_data']->owner_user_id]);

        if ($result) {
            $this->session->set_flashdata('success', 'Data updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update data');
        }

        redirect('settings');

        exit;
    }


    public function deleteAccount()
    {
        $center_id = $this->session->userdata('exam_center_id');

        if (empty($center_id)) {
            return redirect()->back()->with('error', 'Invalid center.');
        }

        // Booking protection
        if ($this->Common_model->has_any_booking($center_id)) {
            return redirect()->back()->with(
                'error',
                'Account cannot be deleted because self or assigned bookings exist.'
            );
        }

        $data = ['deleted' => 1];

        $this->Common_model->UpdateRecord(
            'tt_center',
            $data,
            ['center_id' => $center_id]
        );

        return redirect('/center-owner-dashboard')->with('success', 'Account deleted successfully.');
    }


    public function updateCenterLogo()
    {
        $updated_at   = date('Y-m-d H:i:s');
        $examCenterId = $this->session->userdata('exam_center_id');

        // Upload logo
        $logoPath = 'uploads/center_logo/';
        if (!is_dir($logoPath)) {
            mkdir($logoPath, 0777, true);
        }

        $updateData = [
            'last_modified_on' => $updated_at
        ];

        if (!empty($_FILES['logo']['name'])) {
            $logoFileName   = time() . '_' . basename($_FILES['logo']['name']);
            $logoTargetPath = $logoPath . $logoFileName;

            if (move_uploaded_file($_FILES['logo']['tmp_name'], $logoTargetPath)) {
                $updateData['logo'] = $logoTargetPath;
            }
        }

        // Update only if we have data
        if (!empty($updateData)) {
            $this->Common_model->UpdateRecord('tt_center', $updateData, ['center_id' => $examCenterId]);
        }

        // Send response
        echo json_encode([
            'success' => true,
            'message' => 'Logo updated successfully!',
        ]);
        exit;
    }
}
