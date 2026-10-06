<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationsController extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Notification_model');
        $this->load->model('Common_model');
        $this->load->database();

        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }
    }

    public function mark_read()
    {
        $id = $this->input->post('id');
        $this->Notification_model->mark_as_read($id);
        echo json_encode(['status' => true]);
    }

    public function remove()
    {
        $id = $this->input->post('id');
        $this->Notification_model->remove_notification($id);
        echo json_encode(['status' => true]);
    }

    public function mark_all()
	{
	    $this->Notification_model->mark_all_as_read();
	    echo json_encode(['status' => true]);
	}


    public function allNotificationList()
    {
        $data['page_title'] = 'Notification List';
        $data['admin']      = $this->session->userdata('admin_user');
        $data['centerData'] = $this->Common_model->getdata_array('tt_center','');
        $data['notificationData'] = $this->Common_model->getdata_array('notifications',array('type' => 'admin'));

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/notification/index');
        $this->load->view('layouts/footer');
    }

}
