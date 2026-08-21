<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');
ini_set('display_errors', 1);

class AuthController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);
    }
    
    public function index()
    {
        // echo password_hash('', PASSWORD_BCRYPT);
        $settings = $this->Common_model->getdata_array('custom_settings', '');

        $data['settings'] = [];
        foreach ($settings as $row) {
            $data['settings'][$row['setting_key']] = $row['setting_value'];
        }
        
        $data['page_title'] = 'Login';
        $data['cmsData'] = $this->Common_model->getdata_array('cms',array('status' => 1));

        $this->load->view('layouts/auth/header',$data);
        $this->load->view('auth/login', $data);
        $this->load->view('layouts/auth/footer');
    }

    /**
     * AJAX Admin Login
     */
    public function doLogin()
    {
        // Force JSON response
        $this->output->set_content_type('application/json');

        // Validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'status'  => false,
                'message' => strip_tags(validation_errors())
            ]);
            return;
        }

        $email    = $this->input->post('email', true);
        $password = $this->input->post('password', true);

        // Authenticate user
        $user = $this->Common_model->authenticateAdmin($email, $password);

        if ($user === 'invalid') {
            echo json_encode([
                'status'  => false,
                'message' => 'Invalid email or password'
            ]);
            return;
        }

        if ($user === 'blocked') {
            echo json_encode([
                'status'  => false,
                'message' => 'Your account is blocked. Contact admin.'
            ]);
            return;
        }

        // Session data in SINGLE ARRAY (Industry standard)
        $sessionData = [
            'is_admin_logged_in' => true,
            'admin_user' => [
                'id'        => $user['id'],
                'username'      => $user['username'],
                'email'     => $user['email'],
                'role_id'   => $user['role_id'],
                'role_name' => $user['role_name']
            ]
        ];

        $this->session->set_userdata($sessionData);
        session_write_close();

        $this->session->set_flashdata('success', 'Login successfully...!!');

        echo json_encode([
            'status'       => true,
            'message'      => 'Login successful',
            'redirect_url' => base_url('admin/dashboard')
        ]);
    }


    public function logout()
    {
        // Destroy only admin session data (safe way)
        $this->session->unset_userdata([
            'is_admin_logged_in',
            'admin_user'
        ]);

        // Regenerate session ID (security best practice)
        $this->session->sess_regenerate(TRUE);

        // Optional flash message
        // $this->session->set_flashdata('success', 'You have been logged out successfully.');

        // Redirect to login page
        redirect('login');
    }


    public function viewCms($slug)
    {
        $cms = $this->db->where('slug', $slug)
                        ->where('status', 1)
                        ->get('cms')
                        ->row();

        if (!$cms) {
            show_404();
        }

        $data['cms'] = $cms;
        $data['page_title'] = $slug;

        $this->load->view('layouts/auth/header',$data);
        $this->load->view('auth/cms_view', $data);
        $this->load->view('layouts/auth/footer');
    }

}
