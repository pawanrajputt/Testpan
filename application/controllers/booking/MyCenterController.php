<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class MyCenterController extends MY_Controller
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


    public function myCenter()
    {
        $center_id = $this->session->userdata('exam_center_id');

        $data['countries'] = $this->Common_model->getdata_array('tt_countries', ['is_active' => 1]);
        $data['center_type'] = $this->Common_model->getdata_array('tt_center_type', ['deleted' => 0]);
        $data['bank_name'] = $this->Common_model->getdata_array('tt_bank_name', ['deleted' => 0]);
        $data['result'] = $this->Common_model->getdata('tt_center', ['center_id' => $center_id]);
        $data['labs'] = $this->Common_model->getdata_array('tt_lab', ['center_id' => $center_id]);
        $data['documents'] = $this->Common_model->getdata_array('tt_center_document', ['center_id' => $center_id]);
        $data['walkthrough_video'] = $this->Common_model->getdata_array('tt_center_video', ['center_id' => $center_id, 'deleted' => 0]);
        $data['center_entrances'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'center_entrance']);
        $data['lab_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'lab_photo']);
        $data['gate_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'gate_image']);
        $data['server_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'server_image']);
        $data['observer_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'observer_image']);
        $data['ups_images'] = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0, 'image_type' => 'ups_image']);

        $ownerUserId = $data['result']->owner_user_id ?? 0;

        $data['editRequest']    = $this->getProfileEditRequest($center_id, $ownerUserId);
        $data['editPermission'] = $this->getEditPermission($center_id);

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/my-center', $data);
        $this->load->view('layouts/footer');
    }


    public function getProfileEditRequest($centerId, $ownerUserId)
    {
        return $this->db
            ->where('center_id', $centerId)
            ->where('owner_user_id', $ownerUserId)
            ->where('is_active', 1)
            ->order_by('id', 'DESC')
            ->get('profile_edit_requests')
            ->row();
    }

    public function getEditPermission($centerId)
    {
        return $this->db
            ->where('center_id', $centerId)
            ->where('is_edit_allowed', 1)
            ->get('center_edit_permissions')
            ->row();
    }

    public function requestProfileEdit()
    {
        $center_id = $this->session->userdata('exam_center_id');

        $center = $this->Common_model->getdata(
            'tt_center',
            ['center_id' => $center_id]
        );

        $ownerUserId = $center->owner_user_id ?? 0;

        // deactivate old pending requests
        $this->db->where('center_id', $center_id)
            ->where('status', 'pending')
            ->update('profile_edit_requests', ['is_active' => 0]);

        $data = [
            'center_id'       => $center_id,
            'owner_user_id'   => $ownerUserId,
            'request_message' => $this->input->post('request_message'),
            'status'          => 'pending',
            'is_active'       => 1
        ];

        $this->db->insert('profile_edit_requests', $data);


        $this->db->select('c.center_name, c.address, au.email, au.mobile_phone');
        $this->db->from('tt_center c');
        $this->db->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left');
        $this->db->where('c.center_id', $center_id);
        $result = $this->db->get()->row();

        $owner_email  = $result->email;
        $owner_mobile = $result->mobile_phone;

        $email_subject = "Profile Edit Request Submitted – " . $center->center_name;

        $email_content = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color:#333; }
                    .header { color: #2c3e50; }
                    .content { margin: 20px 0; }
                    .details { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom:15px; }
                    .highlight { background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
                    .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
                </style>
            </head>
            <body>

                <h2 class="header">Profile Edit Request Notification</h2>
                
                <div class="content">
                    <p>Dear Admin,</p>
                    
                    <p>
                        A profile edit request has been submitted by the following center. 
                        Kindly review and take the necessary action.
                    </p>

                    <div class="highlight">
                        <strong>Status:</strong> Pending Approval<br>
                        Please login to the admin panel to review the requested changes.
                    </div>

                    <div class="details">
                        <h3>Center Details:</h3>
                        <p><strong>Center Name:</strong> ' . htmlspecialchars($center->center_name) . '</p>
                        <p><strong>Registered Email:</strong> ' . htmlspecialchars($owner_email) . '</p>
                        <p><strong>Contact Number:</strong> ' . htmlspecialchars($owner_mobile) . '</p>
                        <p><strong>Address:</strong> ' . htmlspecialchars($center->address) . '</p>
                    </div>

                    <div class="details">
                        <h3>Request Message:</h3>
                        <p>' . nl2br(htmlspecialchars($this->input->post('request_message'))) . '</p>
                    </div>

                    <p>
                        Please review the request at your earliest convenience.
                    </p>
                </div>

            </body>
            </html>
            ';


        $send = send_email(
            $email_content,
            $email_subject,
            "admin@testpanindia.com",
            "centerbooking@bookmytestcenter.com"
        );

        $this->session->set_flashdata('success', 'Edit request submitted successfully.');
        redirect('my-center');
    }

}