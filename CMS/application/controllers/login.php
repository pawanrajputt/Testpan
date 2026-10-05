<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author : Joyonto Roy
 * 	30th July, 2014
 * 	Creative Item
 * 	www.creativeitem.com
 * 	http://codecanyon.net/user/joyontaroy
 */

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    //Default function, redirects to logged in user area
    public function index() {

        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
			$this->load->view('backend/login');
    }

    //Ajax login function 
    function ajax_login() {
        $response = array();

        //Recieving post input of email, password from ajax request
        $email = $_POST["email"];
        $password = $_POST["password"];
        $response['submitted_data'] = $_POST;

        //Validating login
        $login_status = $this->validate_login($email, $password);
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {
            //$response['redirect_url'] = $this->session->userdata('last_page');
			$response['redirect_url'] = base_url()."index.php?admin/dashboard";
        }

        //Replying ajax request with validation response
        echo json_encode($response);
    }

    //Validating login from ajax request
    function validate_login($email = '', $password = '') {
        $credential = array('email' => $email, 'password' => sha1($password),'log_status' => 1);
        // Checking login credential for admin
        $query = $this->db->get_where('tt_admin_users', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
			if($row->status=="blocked"){
				return "blocked";
			}
			$role_name = $this->db->query("SELECT title FROM  tt_roles where 1=1 and id='".$row->role_id."'")->row()->title;
			$this->session->set_userdata(array(
											"admin_login" => '1',
											"login_user_id" => $row->id,
											"name" => ucwords($row->first_name),
											"login_type" => "admin",
											"email" => $row->email,
											"role_name" => $role_name,
											"role_id" => $row->role_id									
										)			
									);
									
			$user_id=$row->id;						
			$ip = $_SERVER['REMOTE_ADDR'];		
			
		//$check_qry = $this->db->query("select * from  tt_admin_users_login_logs where 1=1 and user_id='".$user_id."'");
		//if($check_qry->num_rows()>0){
		$save_data = array(
						"user_id" => $user_id,
						"ip_address" => $_SERVER['REMOTE_ADDR'],
						"last_login_date" => date("Y-m-d h:i:s"),
						"log_date" => date("Y/m/d"),
						"log_time" => date('H:i:s'),
						"log_status" => "1",
						);
		
		$result = $this->db->insert('tt_admin_users_login_logs',$save_data);
        
	//	} 
	//	else
	//	{
		
	/*	$save_data = array(
						"user_id" => $user_id,
						"ip_address" => $ip,
						"last_login_date" => date("Y-m-d h:i:s"),
						"log_date" => date("Y/m/d"),
						"log_time" => date('H:i:s'),
						"log_status" => "1",
						);
		
		$result = $this->db->insert('tt_admin_users_login_logs',$save_data);
		}   */
            
            return 'success';
        }

        return 'invalid';
    }


    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

   

    /*     * *DEFAULT NOR FOUND PAGE**** */

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    /*     * *RESET AND SEND PASSWORD TO REQUESTED EMAIL*** */

   
    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
	
	$user_id=$this->session->userdata('login_user_id');
		$save_date = array(
						"user_id" => $user_id,
						"log_status" =>'0',
						);
		
		$this->db->where('user_id',$user_id);
        $result = $this->db->update('tt_admin_users_login_logs',$save_date);
	
	
        $this->session->unset_userdata();
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
       // redirect(base_url(), 'refresh');
	   redirect('https://www.bookmytestcenter.com/', 'refresh');
    }

}
