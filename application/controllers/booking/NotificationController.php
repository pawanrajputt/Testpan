<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class NotificationController extends MY_Controller
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


    public function centerAllNotification()
    {
        $owner_id = $this->session->userdata('owner_id');
        $center_id = $this->session->userdata('exam_center_id');

        $this->load->library('pagination');

        // Base query
        $this->db->from('notifications');
        $this->db->where([
            'admin_user_id' => $owner_id,
            'type'          => 'center',
            'is_remove'     => 0
        ]);

        if (!empty($center_id)) {
            $this->db->where('notifications.center_id', $center_id);
        }

        $config['base_url'] = base_url('owner-all-notifications');
        $config['per_page'] = 20;
        $config['total_rows'] = $this->db->count_all_results('', false);

        $this->db->select('notifications.*, centers.center_name');
        $this->db->join('tt_center as centers', 'centers.id = notifications.center_id', 'left');
        $this->db->order_by('notifications.created_at', 'DESC');
        $this->db->limit($config['per_page'], $this->uri->segment(2));

        $data['notifications'] = $this->db->get()->result();

        $data['selected_center'] = $center_id;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('booking/common/all_notifications', $data);
        $this->load->view('layouts/footer');
    }


    public function markAllRead()
    {
        $owner_id  = $this->session->userdata('owner_id');
        $center_id = $this->session->userdata('exam_center_id');

        $this->db->where([
            'admin_user_id' => $owner_id,
            'type'          => 'center',
            'is_remove'     => 0
        ]);

        if (!empty($center_id)) {
            $this->db->where('center_id', $center_id);
        }

        $this->db->update('notifications', ['is_read' => 1]);

        redirect($_SERVER['HTTP_REFERER']);
    }


    public function removeNotification($id)
    {
        $owner_id = $this->session->userdata('owner_id');

        $this->db->where([
            'id'            => $id,
            'admin_user_id' => $owner_id
        ]);

        $this->db->update('notifications', [
            'is_remove' => 1
        ]);

        redirect($_SERVER['HTTP_REFERER']);
    }
}
