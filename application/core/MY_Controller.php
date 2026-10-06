<?php

class MY_Controller extends CI_Controller {

    public $admin_notifications = [];
    public $admin_unread_count = 0;
    public $admin_total_count = 0;
    public $header_logo;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_model');
        $this->header_logo = $this->Common_model->getdata('custom_settings', [
            'setting_key' => 'header_logo'
        ]);
        $this->load->vars([
            'header_logo' => $this->header_logo
        ]);

        if ($this->session->userdata('admin_user')) {

            $this->load->model('Notification_model');

            $admin = $this->session->userdata('admin_user');
            $admin_id = $admin['id'];

            $this->admin_notifications = 
			    $this->Notification_model->get_admin_notifications();

			$this->admin_unread_count = 
			    $this->Notification_model->get_unread_count();

			$this->admin_total_count = 
			    $this->Notification_model->get_total_count();
        }
    }


    protected function check_permission($permission_slug)
    {
        if (!has_permission($permission_slug)) {
            show_error("You don't have permission to access this page", 403);
            exit;
        }
    }
}