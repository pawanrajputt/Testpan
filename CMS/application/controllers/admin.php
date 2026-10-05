<?php
include_once '.base_url()webservices/tp_services/push_notify_function.php';
//sleep(8); 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*	
 *	@author : Aditya Anurag
 *	date	: 9 August, 2018
 *	
 *	
 */

class Admin extends CI_Controller
{    
    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library("common_options");	
		$this->load->library('zip');
		//$this->load->helper('url');
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		if ($this->session->userdata('admin_login') != 1){
		   redirect(base_url());	
		}	
		
    }
    
    /***default function, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
			
		$directory = 'download';
  		$data["images"] = glob($directory . "/*.jpg");
 		$this->load->view('zip_file', $data);	
    }
    
    /***ADMIN DASHBOARD***/
    function dashboard()
    {       
	  
		/*echo "<pre>";
		print_r($this->session->all_userdata());*/
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		 
		
	    $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
		if($this->session->userdata('role_id')!=0){
			$m_query = $this->db->query("SELECT COUNT(vendor_id) as total_val FROM tt_vendor");
			$page_data['m_total'] = $m_query->row()->total_val;
			
			$d_query = $this->db->query("SELECT COUNT(id) as total_val FROM tt_admin_users");
			$page_data['d_total'] = $d_query->row()->total_val;		
			
			$c_query = $this->db->query("SELECT COUNT(id) as total_val FROM tt_center where deleted=0");
			$page_data['c_total'] = $c_query->row()->total_val;
			
			$cl_query = $this->db->query("SELECT COUNT(id) as total_val FROM tt_client where deleted=0");
			$page_data['cl_total'] = $cl_query->row()->total_val;
			
			$fd_year = date('2024-04-01'); 
            $ld_year  = date('2025-03-31');
			
			$cprj_query = $this->db->query("SELECT COUNT(DISTINCT project_id) as total_val FROM tt_project_detail where start_date BETWEEN '$fd_year' AND '$ld_year' AND deleted=0");
			$page_data['cprj_total'] = $cprj_query->row()->total_val;
			
            $fd_month = date('Y-m-01'); 
            $ld_month  = date('Y-m-t');

	
			$cprjm_query = $this->db->query("SELECT COUNT(DISTINCT project_id) as total_val FROM tt_project_detail where start_date BETWEEN '$fd_month' AND '$ld_month' AND deleted=0");
			$page_data['cprj_monthly'] = $cprjm_query->row()->total_val;
			
			$city_query = $this->db->query("SELECT COUNT(Distinct city_id) as total_val FROM tt_center where deleted=0");
			$page_data['city_total'] = $city_query->row()->total_val;
			
			//$candi_year = date('2022-04-01'); 
            //$candy_year  = date('2023-03-31');
			
			$candi_year = date('2023-04-01'); 
            $candy_year  = date('2024-03-31');
			
			$total_query = $this->db->query("SELECT sum(req_book_seat) as total_val FROM tt_exam_booking_detail where exam_date BETWEEN '$candi_year' AND '$candy_year' AND status=1 AND deleted=0");
			$page_data['totals_seat'] = $total_query->row()->total_val;
			//echo $this->db->last_query();
			$seat_query = $this->db->query("SELECT sum(total_no_system) as total_val FROM tt_center where deleted=0");
			$page_data['seat_total'] = $seat_query->row()->total_val;
			
			$mp_query = $this->db->query("SELECT COUNT(id) as total_val FROM tt_manpower where deleted=0");
			$page_data['mp_total'] = $mp_query->row()->total_val;
			
			
			$app_query = $this->db->query("SELECT COUNT(id) as total_val FROM tt_admin_users where role_id=9 and deleted=0");
			$page_data['app_query'] = $app_query->row()->total_val;		
			
			
			$intr_query = $this->db->query("SELECT COUNT(Distinct country_id) as total_val FROM tt_center where deleted=0");
			$page_data['intr_query'] = $intr_query->row()->total_val;
			
			$mpower_query = $this->db->query("SELECT COUNT(id) as total_val FROM tt_manpower_project where deleted=0");
			$page_data['mpower_total'] = $mpower_query->row()->total_val;
			
		}else{
						
		}
		
		//echo "<pre>";
	   	//echo $this->session->userdata('login_user_id');exit;
        $this->load->view('backend/index', $page_data);
    }
	
	
	function bookmytestcenter()
    {       
	  
		/*echo "<pre>";
		print_r($this->session->all_userdata());*/
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		 
		
	    $page_data['page_name']  = 'bookmytestcenter';
        $page_data['page_title'] = 'BookMyTestCenter';
		if($this->session->userdata('role_id')!=0){
			$m_query = $this->db->query("SELECT COUNT(vendor_id) as total_val FROM tt_vendor");
			$page_data['m_total'] = $m_query->row()->total_val;
			
			$d_query = $this->db->query("SELECT COUNT(id) as total_val FROM tt_admin_users");
			$page_data['d_total'] = $d_query->row()->total_val;		
			
			$c_query = $this->db->query("SELECT COUNT(id) as total_val FROM tt_center where center_owner >0 AND deleted=0");
			$page_data['c_total'] = $c_query->row()->total_val;
			
			$cl_query = $this->db->query("SELECT COUNT(id) as total_val FROM tt_client where deleted=0");
			$page_data['cl_total'] = $cl_query->row()->total_val;
			
			//$fd_year = date('2020-04-01'); 
           // $ld_year  = date('2021-03-31');
			$fd_year = date('2023-04-01'); 
            $ld_year  = date('2024-03-31');
			
			$cprj_query = $this->db->query("SELECT COUNT(DISTINCT project_id) as total_val FROM tt_project_detail where start_date BETWEEN '$fd_year' AND '$ld_year' AND deleted=0");
			$page_data['cprj_total'] = $cprj_query->row()->total_val;
			
            $fd_month = date('Y-m-01'); 
            $ld_month  = date('Y-m-t');

			$cprjm_query = $this->db->query("SELECT COUNT(DISTINCT project_id) as total_val FROM tt_project_detail where start_date BETWEEN '$fd_month' AND '$ld_month' AND deleted=0");
			$page_data['cprj_monthly'] = $cprjm_query->row()->total_val;
			
			$city_query = $this->db->query("SELECT COUNT(Distinct city_id) as total_val FROM tt_center where deleted=0");
			$page_data['city_total'] = $city_query->row()->total_val;
			
			//$candi_year = date('2020-04-01'); 
            //$candy_year  = date('2021-03-31');
			$candi_year = date('2023-04-01'); 
            $candy_year  = date('2024-03-31');
			
			$total_query = $this->db->query("SELECT sum(total_seat) as total_val FROM tt_exam_booking_detail where exam_date BETWEEN '$candi_year' AND '$candy_year' AND status=1 AND deleted=0");
			$page_data['totals_seat'] = $total_query->row()->total_val;
			
			$seat_query = $this->db->query("SELECT sum(total_no_system) as total_val FROM tt_center where deleted=0");
			$page_data['seat_total'] = $seat_query->row()->total_val;			
			
		}else{
						
		}
		
		//echo "<pre>";
	   	//echo $this->session->userdata('login_user_id');exit;
        $this->load->view('backend/index', $page_data);
    }
	////////////////////////////////////////////////////////
	
	
	
	
	
	function admin_users($task = ""){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		
		if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}   
		$data['admin_user_info']    = $this->crud_model->select_admin_users();
		$data['page_name']          = 'admin_users';
		$data['page_title']         = "Admin Users";
		$this->load->view('backend/index', $data);
	}
	function add_admin_user(){			
		if(!hasPageAuthorize('add_admin_user')){
			redirect(base_url(), 'refresh');exit;
		} 
		$data['page_name']          = 'add_admin_user';
		$data['page_title']         = "Add Admin Users";
		$this->load->view('backend/index', $data);
	}
	
	function usr_control_process(){
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		$access = $this->input->post('access');
		
		if(!hasPageAuthorize('add_admin_user')){
			$ar = array("status" => "fail", "error" => "You do not have permission to control user", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
				
		$ipaddress=$_SERVER['REMOTE_ADDR'];
		
		
		if(empty($access))						{
			$ar = array("status" => "fail", "error" => "Please select Access Control.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		$status='active';
		
		$c_details = $this->db->query("SELECT id FROM tt_admin_users where 1=1 and status='".$status."' and id!=1")->result_array();
		foreach($c_details as $roquser)
		{
			$useractv.=$roquser['id'].',';
		}
		$userid_array=substr($useractv,0,-1);
		$user_array=explode(',',$userid_array);
			
		foreach($user_array as $uid)
		{
			$save_data = array(
			"log_status" => $this->input->post('access')
			);	
			$this->db->where_in ('id', $uid); 	
       		 $result = $this->db->update('tt_admin_users',$save_data);
		}
			
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			//$redirect_url = base_url()."index.php?c=admin&m=add_new_id_card_step_one&bundle_id=".$last_insert_id;
			$redirect_url = base_url()."index.php?admin/admin_users";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
    function add_admin_user_process(){
		/*echo "<pre>";
		print_r($_POST);exit;*/
		$role_id = trim($this->input->post('role_id'));
		$status = trim($this->input->post('status'));
		$first_name = str_replace("'","&#8217;",trim($this->input->post('first_name')));
		$last_name = str_replace("'","&#8217;",trim($this->input->post('last_name')));
		$email = trim($this->input->post('email'));
		$password = trim($this->input->post('password'));		
		$birthdate = trim($this->input->post('birthdate'));
		$gender = trim($this->input->post('gender'));
		$mobile_country_code = trim($this->input->post('mobile_country_code'));
		$mobile_phone = trim($this->input->post('mobile_phone'));
		$alternate_number = trim($this->input->post('alternate_number'));
		$ll_country_code = trim($this->input->post('ll_country_code'));
		$ll_area_code = trim($this->input->post('ll_area_code'));
		$land_line_number = trim($this->input->post('land_line_number'));
		$land_line_extension = trim($this->input->post('land_line_extension'));
		$country_id = trim($this->input->post('country_id'));
		$state_id = trim($this->input->post('state_id'));
		$city = trim($this->input->post('city_name'));
		$zip_code = trim($this->input->post('zip_code'));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		$ipaddress=$_SERVER['REMOTE_ADDR'];
		//$state_id_second = trim($this->input->post('state_id_second'));
		//$city_id_second = trim($this->input->post('city_id_second'));
		//$zip_code_second = trim($this->input->post('zip_code_second'));
		//$is_active = trim($this->input->post('is_active'));
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(!hasPageAuthorize('add_admin_user')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add admin user", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
		
		if(empty($role_id))						{
			$ar = array("status" => "fail", "error" => "Please select role.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($role_id == "1")						{
			$ar = array("status" => "fail", "error" => "Role id not accepted", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		if(empty($first_name)){
			$ar = array("status" => "fail", "error" => "First Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
		
		$check_qry = $this->db->query("select id from  tt_admin_users where 1=1 and email='".$email."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "User email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
				
		if(empty($password)){
			$ar = array("status" => "fail", "error" => "Password is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
				
		$birthdate = trim($this->input->post('birthdate'));
		if($birthdate){
			//d/m/y
			$birthdate_ar = explode("/", $birthdate);
			$birthdate = $birthdate_ar[2]."-".$birthdate_ar[1]."-".$birthdate_ar[0];
		}
		
		$enc_pass = sha1($password);
		$save_data = array(
			"role_id" => trim($this->input->post('role_id')),
			"email" => $email,
			"password" => $enc_pass,
			"first_name" => $first_name,
			"last_name" => $last_name,
			"birthdate" => $birthdate,
			"gender" => trim($this->input->post('gender')),	
			"mobile_country_code" => trim($this->input->post('mobile_country_code')),		
			"mobile_phone" => trim($this->input->post('mobile_phone')),
			"alternate_number" => trim($this->input->post('alternate_number')),
			"ip_address" => $ipaddress,
			"ll_country_code" => trim($this->input->post('ll_country_code')),
			"ll_area_code" => trim($this->input->post('ll_area_code')),
			"land_line_number" => trim($this->input->post('land_line_number')),
			"land_line_extension" => trim($this->input->post('land_line_extension')),
			"status" => trim($this->input->post('status')),
			"created_by" => $this->session->userdata('login_user_id'),
			"country_id" => $country_id,
			"state_id" => $state_id,
			"city" => $city,
			"zip_code" => $zip_code,
			"address" => $address,
			"address_second" => $address_second		
		);	
		
		$result = $this->db->insert('tt_admin_users',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/admin_users";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	//edit admin user
	function edit_admin_user($id = NULL){			
		if(!hasPageAuthorize('edit_admin_user')){
			redirect(base_url(), 'refresh');exit;
		} 
		//1: Super Admin can not be updated
		if(empty($id) or !is_numeric($id) or $id<=1){
			redirect(base_url(), 'refresh');exit;
		}		
		$this->session->set_userdata(array("edit_user_id" => $id));
		$user_details = $this->db->query("SELECT * FROM tt_admin_users where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$user_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['user_details'] = $user_details;
		$data['page_name']          = 'edit_admin_user';
		$data['page_title']         = "Edit Admin User";
		$this->load->view('backend/index', $data);
	}
	
	function edit_admin_user_process(){
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(!hasPageAuthorize('add_admin_user')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add admin user", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
				
		$edit_user_id  = $this->session->userdata('edit_user_id');
		if(empty($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		if(!is_numeric($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		$role_id = trim($this->input->post('role_id'));
		$status = trim($this->input->post('status'));
		if($this->input->post('status')=='blocked'){
			$log_status=3;
		}
		if($this->input->post('status')=='active'){
			$log_status=1;
		}
		
		$first_name = str_replace("'","&#8217;",trim($this->input->post('first_name')));
		$last_name = str_replace("'","&#8217;",trim($this->input->post('last_name')));
		$email = trim($this->input->post('email'));
		//$password = trim($this->input->post('password'));		
		$birthdate = trim($this->input->post('birthdate'));
		$gender = trim($this->input->post('gender'));
		$mobile_country_code = trim($this->input->post('mobile_country_code'));
		$mobile_phone = trim($this->input->post('mobile_phone'));
		$alternate_number = trim($this->input->post('alternate_number'));
		$ll_country_code = trim($this->input->post('ll_country_code'));
		$ll_area_code = trim($this->input->post('ll_area_code'));
		$land_line_number = trim($this->input->post('land_line_number'));
		$land_line_extension = trim($this->input->post('land_line_extension'));
		$country_id = trim($this->input->post('country_id'));
		$state_id = trim($this->input->post('state_id'));
		$city = trim($this->input->post('city_name'));
		$zip_code = trim($this->input->post('zip_code'));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		$ipaddress=$_SERVER['REMOTE_ADDR'];
		
		
		if(empty($role_id))						{
			$ar = array("status" => "fail", "error" => "Please select role.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($role_id == "1")						{
			$ar = array("status" => "fail", "error" => "Role id not accepted", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($first_name)){
			$ar = array("status" => "fail", "error" => "First Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
				
		$check_qry = $this->db->query("select * from  tt_admin_users where 1=1 and id<>'".$edit_user_id."' and email='".$email."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "User email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$birthdate = trim($this->input->post('birthdate'));
		if($birthdate){
			//d/m/y
			$birthdate_ar = explode("/", $birthdate);
			$birthdate = $birthdate_ar[2]."-".$birthdate_ar[1]."-".$birthdate_ar[0];
		}
		
			
		$save_data = array(
			"role_id" => trim($this->input->post('role_id')),
			"email" => $email,
			//"password" => $enc_pass,
			"first_name" => $first_name,
			"last_name" => $last_name,
			"birthdate" => $birthdate,
			"gender" => trim($this->input->post('gender')),	
			"mobile_country_code" => trim($this->input->post('mobile_country_code')),		
			"mobile_phone" => trim($this->input->post('mobile_phone')),
			"alternate_number" => trim($this->input->post('alternate_number')),
			"ip_address" => $ipaddress,
			"ll_country_code" => trim($this->input->post('ll_country_code')),
			"ll_area_code" => trim($this->input->post('ll_area_code')),
			"land_line_number" => trim($this->input->post('land_line_number')),
			"land_line_extension" => trim($this->input->post('land_line_extension')),
			"status" => trim($this->input->post('status')),
			"log_status" => $log_status,
			"updated_by" => $this->session->userdata('login_user_id'),
			"updated" =>date('Y-m-d H:i:s'),
			"country_id" => $country_id,
			"state_id" => $state_id,
			"city" => $city,
			"zip_code" => $zip_code,
			"address" => $address,
			"address_second" => $address_second
		);	
		
		/*if($enc_pass){
			$save_data["password"] = $enc_pass;
		}*/
		$this->db->where('id',$edit_user_id);
        $result = $this->db->update('tt_admin_users',$save_data);
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			//$redirect_url = base_url()."index.php?c=admin&m=add_new_id_card_step_one&bundle_id=".$last_insert_id;
			$redirect_url = base_url()."index.php?admin/admin_users";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function vendor_listing(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}  */   
		if(trim($this->input->post('button'))){
		$action = trim($this->input->post('button'));
		$vendor_id = $_POST['vendor_ids'];
		$check_all_vendor = $_POST['check_all_vendor'];
	    $vendor_array=implode(',',$vendor_id);
		
		for($i=0;$i<sizeof($vendor_id); $i++)
		{	
			if(trim($this->input->post('button'))=='Inactive')
			{
				$result[] = $this->db->query("update tt_vendor set deleted=1 where vendor_id='".$this->db->escape_str($_POST['vendor_ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Activate')
			{
				$result[] = $this->db->query("update tt_vendor set deleted=0 where vendor_id='".$this->db->escape_str($_POST['vendor_ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Delete')
			{
				$result[] = $this->db->query("update tt_vendor set deleted=2 where vendor_id='".$this->db->escape_str($_POST['vendor_ids'][$i])."'");	
			}
		}
		
		}
		
		if(trim($this->input->post('button'))=='Download')
		{
				set_time_limit(10000);
		
						
		$this->load->library('export');
		$this->db->select(" @a:=@a+1 'Serial No', s.title as 'State id', ru.vendor_name as 'Vendor Name', ru.co_ordinator_name as 'Coordinator NAME', ru.vendor_mobile as 'Mobile', ru.vendor_email as 'Email', ru.location as 'Location', ru.pan as 'Pan No.', ru.gst_no as 'GST', ru.bank_name as 'Bank Name.', ru.bank_account_number as 'Bank Account No.', ru.bank_account_ifsc as 'Bank IFSC'", false);		
		
		
		
		$this->db->from('tt_vendor ru, (SELECT @a:= 0) AS a')->join('tt_states s', 'ru.state_id=s.id', 'left');
			
		$this->db->where_in ('ru.vendor_id', $vendor_id); 		
		$this->db->order_by("ru.vendor_id", "asc"); 
		$query = $this->db->get();
		$e_data = $query->result_array();
		$aa=date('Y-m-d H:i:s');
		//echo $this->db->last_query();exit;
		$file_name = "vendor_data_".$aa.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		}
		//($vendor_id);
		/*echo "<pre>";
		print_r($_POST);exit;*/

		
		$data['admin_user_info']    = $this->crud_model->select_all_vendor();
		//echo $this->db->last_query();exit;
		$data['page_name']          = 'vendor_listing';
		$data['page_title']         = "Vendor Listing";
		$this->load->view('backend/index', $data);
	}

	function add_vendor(){			
		/*if(!hasPageAuthorize('add_vendor')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['page_name']          = 'add_vendor';
		$data['page_title']         = "Register New Vendor";
		$this->load->view('backend/index', $data);
	}
	
	function add_vendor_process(){
		$country_id = trim($this->input->post('country_id'));
		$state_id = trim($this->input->post('state_id'));
		$vendor_name = str_replace("'","&#8217;",trim($this->input->post('vendor_name')));
		$co_oreinator_name = str_replace("'","&#8217;",trim($this->input->post('co_oreinator_name')));
		$country_code = trim($this->input->post('country_code'));
		$mobile_phone = trim($this->input->post('mobile_phone'));
		$alternate_mobile = trim($this->input->post('alternate_mobile'));
		$ll_country_code = trim($this->input->post('ll_country_code'));
		$ll_area_code = trim($this->input->post('ll_area_code'));
		$ll_number = trim($this->input->post('ll_number'));
		$ll_extension = trim($this->input->post('ll_extension'));
		
		$email = trim($this->input->post('email'));
		$pancard_number = trim($this->input->post('pancard_number'));
				
		$gst_number = trim($this->input->post('gst_number'));		
		$bank_name = trim($this->input->post('bank_name'));
		$bank_ac_number = trim($this->input->post('bank_ac_number'));
		
		$bank_ac_ifsc = trim($this->input->post('bank_ac_ifsc'));
		$mapped_center = trim($this->input->post('mapped_center'));
		$mapped_c_history = trim($this->input->post('mapped_c_history'));
		
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		$city = $this->input->post('city_name');
		$pincode = trim($this->input->post('pincode'));
		$udyam_number = str_replace("'","&#8217;",trim($this->input->post('udyam_number')));
		
		$today_date=date('Y-m-d H:i:s');
				
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_vendor')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new vendor", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		
	
		if(empty($vendor_name)){
			$ar = array("status" => "fail", "error" => "Vendor Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($co_oreinator_name)){
			$ar = array("status" => "fail", "error" => "Vendor Co-Ordinator Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($mobile_phone)){
			$ar = array("status" => "fail", "error" => "Mobile no is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
			if(empty($state_id)){
			$ar = array("status" => "fail", "error" => "Vendor State is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($pancard_number)){
			$ar = array("status" => "fail", "error" => "Pancard no is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($gst_number)){
			$ar = array("status" => "fail", "error" => "GST no is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($address)){
			$ar = array("status" => "fail", "error" => "Address is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
				
		$check_qry = $this->db->query("select vendor_id from tt_vendor where 1=1 and vendor_email='".$email."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Vendor email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		////DOCUMENT UPLOAD SECTION START
		$upload_dir_doc = 'uploads/vendor_document/';
	//	$doc1 = NULL;
		if(isset($_FILES['doc1']) and !empty($_FILES['doc1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc2 = NULL;
		if(isset($_FILES['doc2']) and !empty($_FILES['doc2']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc2')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc2 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc3 = NULL;
		if(isset($_FILES['doc3']) and !empty($_FILES['doc3']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc3')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc3 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc4 = NULL;
		if(isset($_FILES['doc4']) and !empty($_FILES['doc4']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc4')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc4 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		if(isset($_FILES['doc5']) and !empty($_FILES['doc5']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc5')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc5 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		$save_data = array(
			"country_id" => $country_id,
			"state_id" => $state_id,
			"vendor_name" => $vendor_name,
			"co_ordinator_name"=> $co_oreinator_name,
			"country_code" => $country_code,
			"vendor_mobile" => $mobile_phone,
			"alternate_mobile" => $alternate_mobile,
			"ll_country_code" => $ll_country_code,
			"ll_area_code" => $ll_area_code,
			"ll_number" => $ll_number,
			"ll_extension" => $ll_extension,
			"vendor_email" => $email,
			"pan" => $pancard_number,
			"location" => $state_id,
			"gst_no" => trim($gst_number),
			"gst_document" => trim($doc1),			
			"bank_name" => trim($bank_name),
			"bank_account_number" => trim($bank_ac_number),
			"bank_account_ifsc" => trim($bank_ac_ifsc),
			"bank_doc" => trim($doc2),
			"mapped_center" => trim($mapped_center),
			"mapped_center_history" => trim($mapped_c_history),
			"address" => trim($address),
			"address_second" => trim($address_second),
			"city" => $city,
			"pincode" => trim($pincode),
			"udyam_number" => trim($udyam_number),
			"agreement_doc" => trim($doc3),
			"mou_doc" => trim($doc4),
			"udyam_doc" => trim($doc5),
			"created_by" => $this->session->userdata('login_user_id'),
			"created_on" => date('Y-m-d H:i:s')
		);	
		
		$result = $this->db->insert('tt_vendor',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/vendor_listing";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
		function edit_vendor($id = NULL){			
		/* if(!hasPageAuthorize('edit_vendor')){
			redirect(base_url(), 'refresh');exit;
		} */

		'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$vendor_details = $this->db->query("SELECT * FROM tt_vendor where 1=1 AND vendor_id='".$this->db->escape_str($id)."'")->row();
		if(!$vendor_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['vendor_details'] = $vendor_details;
		$data['page_name']          = 'edit_vendor';
		$data['page_title']         = "Edit Vendor";
		$this->load->view('backend/index', $data);
	}

	function edit_vendor_process(){
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/* if(!hasPageAuthorize('edit_vendor')){
			$ar = array("status" => "fail", "error" => "You do not have permission to edit", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
				
		$edit_user_id  = $this->session->userdata('edit_user_id');
		if(empty($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		if(!is_numeric($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		
		$vendor_name = str_replace("'","&#8217;",trim($this->input->post('vendor_name')));
		$co_oreinator_name = str_replace("'","&#8217;",trim($this->input->post('co_oreinator_name')));
		
		$country_code = trim($this->input->post('country_code'));
		$mobile_phone = trim($this->input->post('mobile_phone'));
		$alternate_mobile = trim($this->input->post('alternate_mobile'));
		$ll_country_code = trim($this->input->post('ll_country_code'));
		$ll_area_code = trim($this->input->post('ll_area_code'));
		$ll_number = trim($this->input->post('ll_number'));
		$ll_extension = trim($this->input->post('ll_extension'));		
		$email = trim($this->input->post('email'));
		$country_id = trim($this->input->post('country_id'));
		$state_id = trim($this->input->post('state_id'));
		$pancard_number = trim($this->input->post('pancard_number'));		
		$gst_number = trim($this->input->post('gst_number'));
		$bank_name = trim($this->input->post('bank_name'));
		$bank_ac_number = trim($this->input->post('bank_ac_number'));
		
		$bank_ac_ifsc = trim($this->input->post('bank_ac_ifsc'));
		$mapped_center = trim($this->input->post('mapped_center'));
		$mapped_c_history = trim($this->input->post('mapped_c_history'));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		$city = trim($this->input->post('city_name'));
		$pincode = trim($this->input->post('pincode'));
		$udyam_number = str_replace("'","&#8217;",trim($this->input->post('udyam_number')));
		if(empty($vendor_name)){
			$ar = array("status" => "fail", "error" => "Please enter vender name.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($co_oreinator_name)){
			$ar = array("status" => "fail", "error" => "Please enter Vendor Co-ordinator name.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($mobile_phone)){
			$ar = array("status" => "fail", "error" => "Mobile number is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
		
			$check_qry = $this->db->query("select * from  tt_vendor where 1=1 and vendor_id<>'".$edit_user_id."' and vendor_email='".$email."'");
			if($check_qry->num_rows()>0){
				$ar = array("status" => "fail", "error" => "User email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		/*	if(empty($gst_number)){
			$ar = array("status" => "fail", "error" => "GST no is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}*/
		if(empty($address)){
			$ar = array("status" => "fail", "error" => "Address is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$upload_dir_doc = 'uploads/vendor_document/';
	//	$doc1 = NULL;
		if(isset($_FILES['doc1']) and !empty($_FILES['doc1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc2 = NULL;
		if(isset($_FILES['doc2']) and !empty($_FILES['doc2']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc2')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc2 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc3 = NULL;
		if(isset($_FILES['doc3']) and !empty($_FILES['doc3']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc3')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc3 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc4 = NULL;
		if(isset($_FILES['doc4']) and !empty($_FILES['doc4']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc4')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc4 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		if(isset($_FILES['doc5']) and !empty($_FILES['doc5']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc5')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc5 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		$save_data = array(
			"state_id" => $state_id,
			"vendor_name" => $vendor_name,	
			"co_ordinator_name" => $co_oreinator_name,
			"country_code" => $country_code,
			"vendor_mobile" => $mobile_phone,
			"alternate_mobile" => $alternate_mobile,
			"ll_country_code" => $ll_country_code,
			"ll_area_code" => $ll_area_code,
			"ll_number" => $ll_number,
			"ll_extension" => $ll_extension,
			"vendor_email" => $email,
			"pan" => $pancard_number,
			"country_id" => $country_id,
			"location" => $state_id,  
			"gst_no" => trim($this->input->post('gst_number')),			
			"bank_name" => trim($this->input->post('bank_name')),
			"bank_account_number" => trim($this->input->post('bank_ac_number')),
			"bank_account_ifsc" => $bank_ac_ifsc,
			"mapped_center" => $mapped_center,
			"mapped_center_history" => $mapped_c_history,	
			"address" => trim($address),
			"address_second" => trim($address_second),
			"city" => $city,
			"pincode" => trim($pincode),	
			"udyam_number" => trim($udyam_number),
			"last_modified_on" => date("Y-m-d H:i:s")
		);	
		
		$this->db->where('vendor_id',$edit_user_id);
        $result = $this->db->update('tt_vendor',$save_data);
		
		if($doc1){ 	$save_doc1 = array(
									"gst_document" => $doc1
					);	
					$this->db->where('vendor_id',$edit_user_id);
					$resultd1 = $this->db->update('tt_vendor',$save_doc1);
		}
		if($doc2){ 	$save_doc2 = array(
									"bank_doc" => $doc2
					);	
					$this->db->where('vendor_id',$edit_user_id);
					$resultd2 = $this->db->update('tt_vendor',$save_doc2);
		}
		if($doc3){ 	$save_doc3 = array(
									"agreement_doc" => $doc3
					);	
					$this->db->where('vendor_id',$edit_user_id);
					$resultd3 = $this->db->update('tt_vendor',$save_doc3);
		}
		if($doc4){ 	$save_doc4 = array(
									"mou_doc" => $doc4
					);	
					$this->db->where('vendor_id',$edit_user_id);
					$resultd3 = $this->db->update('tt_vendor',$save_doc4);
		}
		if($doc5){ 	$save_doc5 = array(
									"udyam_doc" => $doc5
					);	
					$this->db->where('vendor_id',$edit_user_id);
					$resultd3 = $this->db->update('tt_vendor',$save_doc5);
		}
		
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			$redirect_url = base_url()."index.php?admin/vendor_listing";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	
	
	}
	
	function view_vendor($id = NULL){			
		/*if(!hasPageAuthorize('edit_vendor')){
				redirect(base_url(), 'refresh');exit;
		} */

		'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$vendor_details = $this->db->query("SELECT * FROM tt_vendor where 1=1 AND vendor_id='".$this->db->escape_str($id)."'")->row();
		if(!$vendor_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['vendor_details'] = $vendor_details;
		$data['page_name']          = 'view_vendor';
		$data['page_title']         = "View Vendor Detail";
		$this->load->view('backend/index', $data);
	}
	
	
	
	
	
/*	function center_listing(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 

		
		if(trim($this->input->post('button'))){
		$action = trim($this->input->post('button'));
		$center_id = $_POST['center_ids'];
		for($i=0;$i<sizeof($center_id); $i++)
		{	
			if(trim($this->input->post('button'))=='Inactive')
			{
				$result[] = $this->db->query("update tt_center set deleted=1 where id='".$this->db->escape_str($_POST['center_ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Activate')
			{
				$result[] = $this->db->query("update tt_center set deleted=0 where id='".$this->db->escape_str($_POST['center_ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Delete')
			{
				$result[] = $this->db->query("update tt_center set deleted=2 where id='".$this->db->escape_str($_POST['center_ids'][$i])."'");	
			}
		
		}
		
		}
		
		if(trim($this->input->post('button'))=='Download')
		{
				set_time_limit(10000);
						
		$this->load->library('export');
		
		
		 
		
		
		$this->db->select(" @a:=@a+1 'Serial No', CONCAT(ru.region_code,'-', ru.state_code,'-', ru.city_code,'-', ru.center_id) as 'Center Code', v.vendor_name as 'Vendor Name', ru.center_name as 'Center Name', ru.address as 'Center Address', ru.landmark as 'Landmark', ru.city as 'City', s.title as 'State', ru.pin_code as 'Pin Code', ru.address_lat as 'Center Latitude.', ru.address_long as 'Center Longitude', ru.nearest_railway_station as 'Nearest Railway Station', ru.station_lat as 'Railway Station Latitude', ru.station_long as 'Railway Station Longitude', ru.distance_from_station as 'Distance from Railway Station', ru.nearest_bus_stop as 'Nearest Bus Station Name', ru.bus_lat as 'Bus Station Latitude', ru.bus_long as 'Bus Station Longitude', ru.distance_from_bus_stop as 'Distance from Station', ru.parking_facility as 'Parking Facility', ru.entry_point as 'Entry Point', ru.candidates_waiting_hall as 'Candidate Waiting Room Facility', ru.parents_waiting_hall	 as 'Parent Waiting Room Facility', ru.security_guard_male as 'Security Guard Male', ru.security_guard_female as 'Security Guard Female', ru.drinking_water_facility as 'Drinking Water Facility', ru.locker_facility as 'Locker Facility', ru.exit_point as 'Exit Point', ru.fire_extinguisher as 'Fire Extinguisher each lab', ru.network_printer as 'Network Printer', ru.cctv_dvr as 'DVR Facility', ru.projector_sound_system as 'Projector and Sound System', ru.onsite_engineer as 'Onsite Electrician', ru.cs_name as 'Center Superintendent Name', ru.cs_contact_number as 'Center Superintendent Contact No', ru.cs_email as 'Center Superintendent Email', ru.am_name as 'Assistance Manager Name', ru.am_contact_no as 'Assistance Manager Contact No', ru.am_email as 'Assistance Manager Email', ru.poc_name as 'Point of Contact Name', ru.poc_contact_no as 'Point of Contact Mobile', ru.poc_email as 'Point of Contact Email', ru.emergency_contact_no as 'Emergency Contact Number', ru.landline_number as 'Landline Number', ru.td_name as 'Technical Department Name', ru.td_contact_no as 'Technical Department Contact No', ru.td_email as 'Technical Department Email', ru.power_backup_generator_kv as 'Power Backup Generator (KVA)', ru.power_back_ups_kv as 'Power Backup UPS (KVA)', ru.power_backup_hour as 'Power Backup Duration', ru.primary_isp_name as 'Primary ISP Name', ru.primary_isp_bband_or_lease as 'Primary ISP Type', ru.primary_isp_speed as 'Primary ISP Speed', ru.secondary_isp_name as 'Secondary ISP Name', ru.secondary_isp_bband_or_lease as 'Secondary ISP Type', ru.secondary_isp_speed as 'Secondary ISP Speed', ru.total_no_lab as 'Total Number of Lab', ru.total_no_system as 'Total Number of System'", false);		
		
		
		
		$this->db->from('tt_center ru, (SELECT @a:= 0) AS a')->join('tt_states s', 'ru.state_id=s.id', 'left')->join('tt_vendor v', 'ru.vendor_id=v.vendor_id', 'left');
			
		$this->db->where_in ('ru.id', $center_id); 		
		$this->db->order_by("ru.id", "asc"); 
		$query = $this->db->get();
		$e_data = $query->result_array();
		$aa=date('Y-m-d H:i:s');
		$file_name = "Center_data_".$aa.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		}
		
		if(trim($this->input->post('button'))){
			 $state_id = $_POST['state_id'];
			 $city = $_POST['city'];
			 $seat_from = $_POST['seat_from'];
			 $seat_to = $_POST['seat_to'];
		}
		
		$data['admin_user_info']    = $this->crud_model->select_all_center();
		$data['page_name']          = 'center_listing';
		$data['page_title']         = "Center Listing";
		$this->load->view('backend/index', $data);
	}*/
	function add_center(){			
		
		$data['page_name']          = 'add_center';
		$data['page_title']         = "Add New Center";
		$this->load->view('backend/index', $data);
	}
	
	function add_center_process(){
		
		
		$centertype = trim($this->input->post('centertype'));
		$vendor_id = trim($this->input->post('vendor_id'));
		$center_name = str_replace("'","&#8217;",trim($this->input->post('center_name')));
		$country_id = trim($this->input->post('country_id'));
		$state_id = trim($this->input->post('state_id'));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		$landmark = str_replace("'","&#8217;",trim($this->input->post('landmark')));
		$c_lat = trim($this->input->post('c_lat'));
		$c_long = trim($this->input->post('c_long'));
		$city_id = trim($this->input->post('city_name'));	
		$city_name = get_city_name($city_id);	
		$city_code = str_replace("'","&#8217;",trim($this->input->post('city_code')));
		$pincode = trim($this->input->post('pincode'));
		
		$landline_country_code = trim($this->input->post('landline_country_code'));
		$landline_area_code = trim($this->input->post('landline_area_code'));
		$landline_number = trim($this->input->post('landline_number'));
		$landline_extension = trim($this->input->post('landline_extension'));
		
		$railway_station = str_replace("'","&#8217;",trim($this->input->post('railway_station')));
		$rail_long = trim($this->input->post('rail_long'));
		$rail_lat = trim($this->input->post('rail_lat'));
		$distance_from_station = trim($this->input->post('rail_distance'));
		
		$bus_stop = str_replace("'","&#8217;",trim($this->input->post('bus_stop')));
		$bus_long = trim($this->input->post('bus_long'));
		$bus_lat = trim($this->input->post('bus_lat'));
		$bus_distance = trim($this->input->post('bus_distance'));
		
		$parking_facility = trim($this->input->post('parking_facility'));
		$ph_facility = trim($this->input->post('ph_facility'));
		if($ph_facility=='yes')
		{
			$phydical_handicapped = trim($this->input->post('phydical_handicapped'));
		}
		else
		{
			$phydical_handicapped = '';
		}
		
		$doc_signed = trim($this->input->post('doc_signed'));
		$photographs = trim($this->input->post('photographs'));
		$gst_number = trim($this->input->post('gst_number'));
		$gst_state_code = trim($this->input->post('gst_state_code'));
		$pan_number = trim($this->input->post('pan_number'));
		$bank_name = str_replace("'","&#8217;",trim($this->input->post('bank_name')));
		$bank_account_no = str_replace("'","&#8217;",trim($this->input->post('bank_account_no')));
		$bank_ifsc_code = str_replace("'","&#8217;",trim($this->input->post('bank_ifsc_code')));
		$beneficiary_name = str_replace("'","&#8217;",trim($this->input->post('benf_name')));
		
		$sec_bank_option = str_replace("'","&#8217;",trim($this->input->post('sec_bank_option')));
		if($sec_bank_option=='yes'){
			$secondary_pan_no = str_replace("'","&#8217;",trim($this->input->post('secondary_pan_no')));
			$secondary_bank_name = str_replace("'","&#8217;",trim($this->input->post('secondary_bank_name')));
			$secondary_bank_account_no = str_replace("'","&#8217;",trim($this->input->post('secondary_bank_account_no')));
			$secondary_bank_ifsc_code = str_replace("'","&#8217;",trim($this->input->post('secondary_bank_ifsc_code')));
			$secondary_beneficiary_name = str_replace("'","&#8217;",trim($this->input->post('secondary_beneficiary_name')));
		}
		else
		{
			$secondary_pan_no = '';
			$secondary_bank_name = '';
			$secondary_bank_account_no = '';
			$secondary_bank_ifsc_code = '';
			$secondary_beneficiary_name = '';
		}
		$cs_name = str_replace("'","&#8217;",trim($this->input->post('cs_name')));
		$cs_email = trim($this->input->post('cs_email'));
		$cs_country_code = trim($this->input->post('cs_country_code'));
		$cs_contact_number = trim($this->input->post('cs_contact_number'));
		$cs_phone_alternate = trim($this->input->post('cs_phone_alternate'));
		
		$am_name = str_replace("'","&#8217;",trim($this->input->post('am_name')));
		$am_email = trim($this->input->post('am_email'));
		$am_country_code = trim($this->input->post('am_country_code'));
		$am_contact_no = trim($this->input->post('am_contact_no'));
		$am_phone_alternate = trim($this->input->post('am_phone_alternate'));
		
		$poc_name = str_replace("'","&#8217;",trim($this->input->post('poc_name')));
		$poc_email = trim($this->input->post('poc_email'));
		$poc_country_code = trim($this->input->post('poc_country_code'));
		$poc_contact_no = trim($this->input->post('poc_contact_no'));
		$poc_mobile_alternate = trim($this->input->post('poc_mobile_alternate'));
		$emergency_counter_code = trim($this->input->post('emergency_counter_code'));
		$emergency_contact_no = trim($this->input->post('emergency_contact_no'));
		$emergency_number_alternate = trim($this->input->post('emergency_number_alternate'));
		
		$td_name = str_replace("'","&#8217;",trim($this->input->post('td_name')));
		$td_email = trim($this->input->post('td_email'));
		$td_country_code = trim($this->input->post('td_country_code'));
		$td_contact_no = trim($this->input->post('td_contact_no'));
		$td_phone_alternate = trim($this->input->post('td_phone_alternate'));
		
		$total_no_system = trim($this->input->post('total_no_system'));
		
		if($centertype=='online')
		{
			$total_no_lab = trim($this->input->post('total_no_lab'));
		}
		else
		{
			$total_no_lab = '';
		}
		$partitaion_each_lab = trim($this->input->post('partitaion_each_lab'));
		$connected_single_network = trim($this->input->post('sngl_ntwk'));
		if($connected_single_network=='no')
		{
			$how_many_network = str_replace("'","&#8217;",trim($this->input->post('network_count')));
		}
		else
		{
			$how_many_network = '';
		}
		$lab_ac = trim($this->input->post('lab_ac'));
		$lan_company_name = str_replace("'","&#8217;",trim($this->input->post('lan_company_name')));	
		$lan_model_number = str_replace("'","&#8217;",trim($this->input->post('lan_model_number')));	
		$lan_speed = str_replace("'","&#8217;",trim($this->input->post('lan_speed')));	
		
		$lan_managed = trim($this->input->post('lan_managed'));
		$primary_isp_name = trim($this->input->post('primary_isp_name'));
		$primary_isp_bband_or_lease = trim($this->input->post('primary_isp_bband_or_lease'));
		
		$primary_isp_speed = trim($this->input->post('primary_isp_speed'));
		$secondary_isp_name = str_replace("'","&#8217;",trim($this->input->post('secondary_isp_name')));	
		$secondary_isp_bband_or_lease = trim($this->input->post('secondary_isp_bband_or_lease'));
		$secondary_isp_speed = trim($this->input->post('secondary_isp_speed'));
		
		$power_backup_generator_kv = trim($this->input->post('power_backup_generator_kv'));
		$power_back_ups_kv = trim($this->input->post('power_back_ups_kv'));
		$power_backup_hour = trim($this->input->post('power_backup_hour'));
		$power_duration_unit = trim($this->input->post('power_duration_unit'));
		
		
		$cctv_dvr = trim($this->input->post('cctv_dvr'));
		$network_printer = trim($this->input->post('network_printer'));
		$projector_sound_system = trim($this->input->post('projector_sound_system'));
		
		$fire_extinguisher = trim($this->input->post('fire_extinguisher'));
		$security_guard_male = trim($this->input->post('security_guard_male'));
		$security_guard_female = trim($this->input->post('security_guard_female'));
		
		$entry_point = trim($this->input->post('entry_point'));
		$exit_point = trim($this->input->post('exit_point'));
		$locker_facility = trim($this->input->post('locker_facility'));
		$drinking_water_facility = trim($this->input->post('drinking_water_facility'));
		$onsite_engineer = trim($this->input->post('onsite_engineer'));
		$parents_waiting_hall = trim($this->input->post('parents_waiting_hall'));
		$candidates_waiting_hall = trim($this->input->post('candidates_waiting_hall'));
		$availability_of_engineers = trim($this->input->post('availability_of_engineers'));
		
		$type_of_center = trim($this->input->post('type_of_center'));
		$center_approved_by = trim($this->input->post('center_approved_by'));
		$center_affiliation_by = trim($this->input->post('center_affiliation_by'));
		$center_client_name = trim($this->input->post('center_client_name'));
		$center_prev_exam_name = trim($this->input->post('center_prev_exam_name'));
		$center_lab_establish_yr = trim($this->input->post('center_lab_establish_year'));
		if($center_lab_establish_yr){
			//d/m/y
			$birthdate_ar = explode("/", $center_lab_establish_yr);
			$center_lab_establish_year = $birthdate_ar[2]."-".$birthdate_ar[1]."-".$birthdate_ar[0];
		}
		
		
		$feedback = trim($this->input->post('feedback'));
	
		$today_date=date('Y-m-d H:i:s');
		
		$upload_dir = 'uploads/center_image/';
		$upload_dir_doc = 'uploads/center_document/';
		
		
		
		/*$image1 = NULL;
		if(isset($_FILES['image1']) and !empty($_FILES['image1']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image1')){	
							//echo $this->image_lib->display_errors();
				
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}*/
		/*$image2 = NULL;
		if(isset($_FILES['image2']) and !empty($_FILES['image2']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image2')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image2 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image3 = NULL;
		if(isset($_FILES['image3']) and !empty($_FILES['image3']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image3')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image3 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image4 = NULL;
		if(isset($_FILES['image4']) and !empty($_FILES['image4']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image4')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image4 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image5 = NULL;
		if(isset($_FILES['image5']) and !empty($_FILES['image5']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image5')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image5 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image6 = NULL;
		if(isset($_FILES['image6']) and !empty($_FILES['image6']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image6')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image6 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}	
		$image7 = NULL;
		if(isset($_FILES['image7']) and !empty($_FILES['image7']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image7')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image7 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}	
		$image8 = NULL;
		if(isset($_FILES['image8']) and !empty($_FILES['image8']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image8')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image8 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}*/
		$doc1 = NULL;
		if(isset($_FILES['doc1']) and !empty($_FILES['doc1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$doc2 = NULL;
		if(isset($_FILES['doc2']) and !empty($_FILES['doc2']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc2')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc2 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$doc3 = NULL;
		if(isset($_FILES['doc3']) and !empty($_FILES['doc3']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc3')){					
			$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc3 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$doc4 = NULL;
		if(isset($_FILES['doc4']) and !empty($_FILES['doc4']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc4')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc4 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_center')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new center", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		
		if(empty($center_name)){
			$ar = array("status" => "fail", "error" => "Center Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($vendor_id)){
			$ar = array("status" => "fail", "error" => "Vendor is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($state_id)){
			$ar = array("status" => "fail", "error" => "State is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($city_name)){
			$ar = array("status" => "fail", "error" => "City is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($city_code)){
			$ar = array("status" => "fail", "error" => "City Code is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($pincode)){
			$ar = array("status" => "fail", "error" => "Pincode is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($address)){
			$ar = array("status" => "fail", "error" => "Address is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if($cs_email){
			if (!filter_var($cs_email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}	
		if($am_email){
			if (!filter_var($am_email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}		
		if($poc_email){
			if (!filter_var($poc_email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}	
		if($td_email){
			if (!filter_var($td_email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}		
		/*if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}	*/	
				
		//get zone,state and city code
			$loc_code = $this->db->query("SELECT * from tt_states WHERE 1=1 AND id='".$state_id."'")->row();
			$zonal_id= $loc_code->zone_code;	
			$state_code= $loc_code->state_code;
		//Get Last id
			$cent_id_qry = $this->db->query("SELECT id,center_id from tt_center WHERE 1=1 AND state_id='".$state_id."' order by id desc limit 1")->row();
			$last_center_id= $cent_id_qry->center_id;
			$new_center_id=$last_center_id+1;
			
				
		$check_qry = $this->db->query("select vendor_id,center_name,city_id from tt_center where 1=1 and vendor_id='".$vendor_id."' and center_name='".$center_name."' and city_id='".$city_id."' and deleted=0");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Center with selected vendot exist in selected city.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$save_data = array(
			"center_type" => $centertype,
			"center_id" => $new_center_id,
			"vendor_id" => $vendor_id,
			"center_name" => trim($center_name),
			"center_name" => trim($center_name),
			"country_id" => $country_id,
			"state_id" => $state_id,
			"city_id" => $city_id,
			"region_code" => $zonal_id,
			"state_code" => $state_code,
			"city_code" => $city_code,
			"address" => $address,
			"address_second" => $address_second,
			"address_lat" => $c_lat,
			"address_long" =>$c_long,
			"landmark" => $landmark,
			"city" => trim($city_name),			
			"pin_code" => trim($pincode),
			"landline_country_code" => trim($landline_country_code),
			"landline_area_code" => trim($landline_area_code),
			"landline_number" => trim($landline_number),
			"landline_extension" => trim($landline_extension),
			"pan_no" => $pan_number,	
			"gst_no" => $gst_number,
			"gst_state_code" => $gst_state_code,
			"bank_name" => $bank_name,
			"bank_account_number" => $bank_account_no,
			"bank_ifsc_code" => $bank_ifsc_code,
			"beneficiary_name" => $beneficiary_name,
			"sec_bank_option" => $sec_bank_option,
			"secondary_pan_no" => $secondary_pan_no,
			"secondary_bank_name" => $secondary_bank_name,
			"secondary_bank_account_no" => $secondary_bank_account_no,
			"secondary_bank_ifsc_code" => $secondary_bank_ifsc_code,
			"secondary_beneficiary_name" => $secondary_beneficiary_name,
			"nearest_railway_station" => trim($railway_station),
			"station_lat" => trim($rail_lat),
			"station_long" => trim($rail_long),
			"distance_from_station" => trim($distance_from_station),
			"nearest_bus_stop" => trim($bus_stop),
			"bus_lat" => trim($bus_lat),
			"bus_long" => trim($bus_long),
			"distance_from_bus_stop" => trim($bus_distance),
			"for_ph_candidate" => trim($ph_facility),
			"phydical_handicapped" => trim($phydical_handicapped),
			"document_sign" => trim($doc_signed),
			"photographs" => trim($photographs),
			"cs_name" => trim($cs_name),
			"cs_country_code" => trim($cs_country_code),
			"cs_contact_number" => trim($cs_contact_number),
			"cs_phone_alternate" => trim($cs_phone_alternate),
			"cs_email" => trim($cs_email),
			"am_name" => trim($am_name),
			"am_country_code" => trim($am_country_code),
			"am_contact_no" => trim($am_contact_no),
			"am_phone_alternate" => trim($am_phone_alternate),
			"am_email" => trim($am_email),
			"poc_name" => trim($poc_name),
			"poc_country_code" => trim($poc_country_code),
			"poc_contact_no" => trim($poc_contact_no),
			"poc_mobile_alternate" => trim($poc_mobile_alternate),
			"poc_email" => trim($poc_email),
			"emergency_counter_code" => trim($emergency_counter_code),
			"emergency_contact_no" => trim($emergency_contact_no),
			"emergency_number_alternate" => trim($emergency_number_alternate),
			"td_name" => trim($td_name),
			"td_country_code" => trim($td_country_code),
			"td_contact_no" => trim($td_contact_no),
			"td_phone_alternate" => trim($td_phone_alternate),
			"td_email" => trim($td_email),
			"total_no_system" => $total_no_system,
			"total_no_lab" => trim($total_no_lab),
			"partitaion_each_lab" => $partitaion_each_lab,
			"connected_single_network" => $connected_single_network,
			"how_many_network" => $how_many_network,
			"ac_in_each_lab" => $lab_ac,
			"lan_company_name" => $lan_company_name,
			"lan_model_number" => trim($lan_model_number),			
			"lan_speed" => trim($lan_speed),
			"lan_managed" => trim($lan_managed),
			"primary_isp_name" => trim($primary_isp_name),
			"primary_isp_bband_or_lease" => trim($primary_isp_bband_or_lease),
			"primary_isp_speed" => trim($primary_isp_speed),
			"primary_isp_bband_or_lease" => trim($primary_isp_bband_or_lease),
			"primary_isp_speed" => trim($primary_isp_speed),
			"secondary_isp_name" => trim($secondary_isp_name),
			"secondary_isp_bband_or_lease" => trim($secondary_isp_bband_or_lease),
			"secondary_isp_speed" => trim($secondary_isp_speed),
			"power_backup_generator_kv" => trim($power_backup_generator_kv),
			"power_back_ups_kv" => trim($power_back_ups_kv),
			"power_backup_hour" => trim($power_backup_hour),
			"power_backup_unit" => trim($power_duration_unit),
			"cctv_dvr" => trim($cctv_dvr),
			"network_printer" => trim($network_printer),
			"projector_sound_system" => trim($projector_sound_system),
			"fire_extinguisher" => trim($fire_extinguisher),
			"parking_facility" => trim($parking_facility),
			"security_guard_male" => trim($security_guard_male),
			"security_guard_female" => trim($security_guard_female),
			"entry_point" => trim($entry_point),
			"exit_point" => trim($exit_point),
			"locker_facility" => trim($locker_facility),
			"drinking_water_facility" => trim($drinking_water_facility),
			"onsite_engineer" => trim($onsite_engineer),
			"parents_waiting_hall" => trim($parents_waiting_hall),
			"candidates_waiting_hall" => trim($candidates_waiting_hall),
			"availability_of_engineers" => trim($availability_of_engineers),
			"type_of_center" => trim($type_of_center),
			"center_approved_by" => trim($center_approved_by),
			"center_affiliation_by" => trim($center_affiliation_by),
			"center_lab_establish_year" => trim($center_lab_establish_year),
			"center_client_name" => trim($center_client_name),
			"center_prev_exam_name" => trim($center_prev_exam_name),
			"feedback" => trim($feedback),
			"created_by" => $this->session->userdata('login_user_id'),
			"created_on" => date('Y-m-d H:i:s')
		);	
		
		$result = $this->db->insert('tt_center',$save_data);
		$last_insert_id = $this->db->insert_id();
		$centerId=$last_insert_id;
		
		if($image1){
		$save_img1 = array(
			"center_id" => $centerId,
			"center_image" => trim($image1),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result1 = $this->db->insert('tt_center_images',$save_img1);
		}
		if($image2){
		$save_img2 = array(
			"center_id" => $centerId,
			"center_image" => trim($image2),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result2 = $this->db->insert('tt_center_images',$save_img2);
		}
		if($image3){
		$save_img3 = array(
			"center_id" => $centerId,
			"center_image" => trim($image3),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result3 = $this->db->insert('tt_center_images',$save_img3);
		}
		if($image4){
		$save_img4 = array(
			"center_id" => $centerId,
			"center_image" => trim($image4),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result4 = $this->db->insert('tt_center_images',$save_img4);
		}
		if($image5){
		$save_img5 = array(
			"center_id" => $centerId,
			"center_image" => trim($image5),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result5 = $this->db->insert('tt_center_images',$save_img5);
		}
		if($image6){
		$save_img6 = array(
			"center_id" => $centerId,
			"center_image" => trim($image6),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result6 = $this->db->insert('tt_center_images',$save_img6);
		}
		if($image7){
		$save_img7 = array(
			"center_id" => $centerId,
			"center_image" => trim($image7),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result7 = $this->db->insert('tt_center_images',$save_img7);
		}
		if($image8){
		$save_img8 = array(
			"center_id" => $centerId,
			"center_image" => trim($image8),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result8 = $this->db->insert('tt_center_images',$save_img8);
		}
		if($doc1){
		$save_doc1 = array(
			"center_id" => $centerId,
			"doc_name" => trim($doc1),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$resultd1 = $this->db->insert('tt_center_document',$save_doc1);
		}
		if($doc2){
		$save_doc2 = array(
			"center_id" => $centerId,
			"doc_name" => trim($doc2),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$resultd2 = $this->db->insert('tt_center_document',$save_doc2);
		}
		if($doc3){
		$save_doc3 = array(
			"center_id" => $centerId,
			"doc_name" => trim($doc3),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$resultd3 = $this->db->insert('tt_center_document',$save_doc3);
		}
		if($doc4){
		$save_doc4 = array(
			"center_id" => $centerId,
			"doc_name" => trim($doc4),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$resultd4 = $this->db->insert('tt_center_document',$save_doc4);
		}
		$cid=base64_encode($centerId);
		if($result){
			$redirect_url = base_url()."index.php?admin/center_listing";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	
	
	}
	
		function edit_center($id = NULL){			
		/*if(!hasPageAuthorize('edit_center')){
			redirect(base_url(), 'refresh');exit;
		} */

		'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$center_details = $this->db->query("SELECT * FROM tt_center where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		
		$center_images = $this->db->query("SELECT id,center_image FROM tt_center_images where 1=1 AND center_id='".$this->db->escape_str($id)."'")->result_array();
		$data['center_images'] = $center_images;
		
		$center_doc = $this->db->query("SELECT id,doc_name	FROM tt_center_document where 1=1 AND center_id='".$this->db->escape_str($id)."'")->result_array();
		$data['center_doc'] = $center_doc;
		
		
		if(!$center_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['center_details'] = $center_details;
		$data['page_name']          = 'edit_center';
		$data['page_title']         = "Edit Center";
		$this->load->view('backend/index', $data);
	}



	function edit_center_process($id = NULL){
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
		/*if(!hasPageAuthorize('edit_center')){
			$ar = array("status" => "fail", "error" => "You do not have permission to edit", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
				
		//$edit_user_id  = $this->session->userdata('edit_user_id');
		$edit_user_id  = trim($this->input->post('id'));
		
		if(empty($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		if(!is_numeric($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		$centertype = trim($this->input->post('centertype'));
		$vendor_id = trim($this->input->post('vendor_id'));
		$center_name = str_replace("'","&#8217;",trim($this->input->post('center_name')));
		$state_id = trim($this->input->post('state_id'));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		$landmark = str_replace("'","&#8217;",trim($this->input->post('landmark')));
		$udyam_number = str_replace("'","&#8217;",trim($this->input->post('udyam_number')));
		$c_lat = str_replace("'","&#8217;",trim($this->input->post('c_lat')));
		$c_long = str_replace("'","&#8217;",trim($this->input->post('c_long')));
		$city_id = trim($this->input->post('city'));
		$city_name = get_city_name($this->input->post('cityids'));   
		$city_code = trim($this->input->post('city_code'));	
		$pincode = trim($this->input->post('pincode'));
		$landline_country_code = trim($this->input->post('landline_country_code'));
		$landline_area_code = trim($this->input->post('landline_area_code'));
		$landline_number = trim($this->input->post('landline_number'));
		$landline_extension = trim($this->input->post('landline_extension'));
		$railway_station = str_replace("'","&#8217;",trim($this->input->post('railway_station')));
		$rail_long = str_replace("'","&#8217;",trim($this->input->post('rail_long')));
		$rail_lat = str_replace("'","&#8217;",trim($this->input->post('rail_lat')));
		$distance_from_station = trim($this->input->post('rail_distance'));
		$bus_stop = str_replace("'","&#8217;",trim($this->input->post('bus_stop')));
		$bus_long = str_replace("'","&#8217;",trim($this->input->post('bus_long')));
		$bus_lat = str_replace("'","&#8217;",trim($this->input->post('bus_lat')));
		$bus_distance = trim($this->input->post('bus_distance'));
		$parking_facility = trim($this->input->post('parking_facility'));
		$ph_facility = trim($this->input->post('ph_facility'));
		if($ph_facility=='yes')
		{
			$phydical_handicapped = trim($this->input->post('phydical_handicapped'));
		}
		else
		{
			$phydical_handicapped = '';
		}
		$doc_signed = trim($this->input->post('doc_signed'));
		$photographs = trim($this->input->post('photographs'));
		$pan_number = str_replace("'","&#8217;",trim($this->input->post('pan_number')));
		$gst_number = str_replace("'","&#8217;",trim($this->input->post('gst_number')));
		$gst_state_code = trim($this->input->post('gst_state_code'));
		$bank_name = str_replace("'","&#8217;",trim($this->input->post('bank_name')));
		$bank_account_no = str_replace("'","&#8217;",trim($this->input->post('bank_account_no')));
		$bank_ifsc_code = str_replace("'","&#8217;",trim($this->input->post('bank_ifsc_code')));
		$beneficiary_name = str_replace("'","&#8217;",trim($this->input->post('beneficiary_name')));
		$sec_bank_option = $this->input->post('secondary_banking');
		
		if($sec_bank_option=='yes'){
			$secondary_pan_no = str_replace("'","&#8217;",trim($this->input->post('secondary_pan_number')));
			$secondary_bank_name = str_replace("'","&#8217;",trim($this->input->post('secondary_bank_name')));
			$secondary_bank_account_no = str_replace("'","&#8217;",trim($this->input->post('secondary_bank_account_no')));
			$secondary_bank_ifsc_code = str_replace("'","&#8217;",trim($this->input->post('secondary_bank_ifsc_code')));
			$secondary_beneficiary_name = str_replace("'","&#8217;",trim($this->input->post('secondary_beneficiary_name')));
		}
		if($sec_bank_option=='no' or $sec_bank_option=='')
		{
			$secondary_pan_no = '';
			$secondary_bank_name = '';
			$secondary_bank_account_no = '';
			$secondary_bank_ifsc_code = '';
			$secondary_beneficiary_name = '';
		}
		
		$cs_name = str_replace("'","&#8217;",trim($this->input->post('cs_name')));
		$cs_email = trim($this->input->post('cs_email'));
		$cs_country_code = trim($this->input->post('cs_country_code'));
		$cs_contact_number = trim($this->input->post('cs_contact_number'));
		$cs_phone_alternate = trim($this->input->post('cs_phone_alternate'));		
		$am_name = str_replace("'","&#8217;",trim($this->input->post('am_name')));
		$am_email = trim($this->input->post('am_email'));
		$am_country_code = trim($this->input->post('am_country_code'));
		$am_contact_no = trim($this->input->post('am_contact_no'));
		$am_phone_alternate = trim($this->input->post('am_phone_alternate'));
		$poc_name = str_replace("'","&#8217;",trim($this->input->post('poc_name')));
		$poc_email = trim($this->input->post('poc_email'));
		$poc_country_code = trim($this->input->post('poc_country_code'));
		$poc_contact_no = trim($this->input->post('poc_contact_no'));
		$poc_mobile_alternate = trim($this->input->post('poc_mobile_alternate'));
		$emergency_counter_code = trim($this->input->post('emergency_counter_code'));
		$emergency_contact_no = trim($this->input->post('emergency_contact_no'));
		$emergency_number_alternate = trim($this->input->post('emergency_number_alternate'));

		$td_name = str_replace("'","&#8217;",trim($this->input->post('td_name')));
		$td_email = trim($this->input->post('td_email'));
		$td_country_code = trim($this->input->post('td_country_code'));
		$td_contact_no = trim($this->input->post('td_contact_no'));
		$td_phone_alternate = trim($this->input->post('td_phone_alternate'));
		$total_no_system = trim($this->input->post('total_no_system'));
		
		if($centertype=='online'){
			$total_no_lab = trim($this->input->post('total_no_lab'));
		}
		if($centertype=='offline'){
			$total_no_lab = '';
		}
		$partitaion_each_lab = trim($this->input->post('partitaion_each_lab'));
		$connected_single_network = trim($this->input->post('connected_single_network'));
		$connected_single_network = trim($this->input->post('sngl_ntwk'));
		if($connected_single_network=='no')
		{
			$how_many_network = str_replace("'","&#8217;",trim($this->input->post('how_many_network')));
		}
		else
		{
			$how_many_network = '';
		}
		$lab_ac = trim($this->input->post('lab_ac'));
		$lan_company_name = str_replace("'","&#8217;",trim($this->input->post('lan_company_name')));	
		$lan_model_number = str_replace("'","&#8217;",trim($this->input->post('lan_model_number')));	
		$lan_speed = str_replace("'","&#8217;",trim($this->input->post('lan_speed')));	
	//	$lan_company_name = trim($this->input->post('lan_company_name'));		
	//	$lan_model_number = trim($this->input->post('lan_model_number'));
	//	$lan_speed = trim($this->input->post('lan_speed'));
		
		$lan_managed = trim($this->input->post('lan_managed'));
		$primary_isp_name = str_replace("'","&#8217;",trim($this->input->post('primary_isp_name')));
		$primary_isp_bband_or_lease = trim($this->input->post('primary_isp_bband_or_lease'));
		
		$primary_isp_speed = trim($this->input->post('primary_isp_speed'));
		$secondary_isp_name = str_replace("'","&#8217;",trim($this->input->post('secondary_isp_name')));

		$secondary_isp_bband_or_lease = trim($this->input->post('secondary_isp_bband_or_lease'));
		$secondary_isp_speed = trim($this->input->post('secondary_isp_speed'));
		
		$power_backup_generator_kv = trim($this->input->post('power_backup_generator_kv'));
		$power_back_ups_kv = trim($this->input->post('power_back_ups_kv'));
		$power_backup_hour = trim($this->input->post('power_backup_hour'));
		$power_backup_unit = trim($this->input->post('power_backup_unit'));
		
		$cctv_dvr = trim($this->input->post('cctv_dvr'));
		$network_printer = trim($this->input->post('network_printer'));
		$projector_sound_system = trim($this->input->post('projector_sound_system'));
		
		$fire_extinguisher = trim($this->input->post('fire_extinguisher'));
		$parking_facility = trim($this->input->post('parking_facility'));
		$security_guard_male = trim($this->input->post('security_guard_male'));
		$security_guard_female = trim($this->input->post('security_guard_female'));
		
		$entry_point = trim($this->input->post('entry_point'));
		$exit_point = trim($this->input->post('exit_point'));
		$locker_facility = trim($this->input->post('locker_facility'));
		$drinking_water_facility = trim($this->input->post('drinking_water_facility'));
		$onsite_engineer = trim($this->input->post('onsite_engineer'));
		
		$parents_waiting_hall = trim($this->input->post('parents_waiting_hall'));
		$candidates_waiting_hall = trim($this->input->post('candidates_waiting_hall'));
		$availability_of_engineers = trim($this->input->post('availability_of_engineers'));
		$type_of_center = trim($this->input->post('type_of_center'));
		$center_approved_by = trim($this->input->post('center_approved_by'));
		$center_affiliation_by = trim($this->input->post('center_affiliation_by'));
		$center_client_name = trim($this->input->post('center_client_name'));
		$center_prev_exam_name = trim($this->input->post('center_prev_exam_name'));
		$center_lab_establish_year = trim($this->input->post('center_lab_establish_year'));
		
		if($center_lab_establish_year){
			//d/m/y
			$birthdate_ar = explode("/", $center_lab_establish_year);
			$center_lab_establish_yr = $birthdate_ar[2]."-".$birthdate_ar[1]."-".$birthdate_ar[0];
		}
		
		
		
		
		$feedback = trim($this->input->post('feedback'));
		$delimg = $this->input->post('delimg');
		$iimg=count($delimg);
		
		$deldoc = $this->input->post('deldoc');
		$idoc=count($deldoc);
		
		$today_date=date('Y-m-d H:i:s');
		$upload_dir = 'uploads/center_image/';
		$upload_dir_doc = 'uploads/center_document/';
		
		$image1 = NULL;
		if(isset($_FILES['image1']) and !empty($_FILES['image1']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image1')){	
							//echo $this->image_lib->display_errors();
				
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image2 = NULL;
		if(isset($_FILES['image2']) and !empty($_FILES['image2']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image2')){	
							//echo $this->image_lib->display_errors();
				
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image2 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image3 = NULL;
		if(isset($_FILES['image3']) and !empty($_FILES['image3']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image3')){	
							//echo $this->image_lib->display_errors();
				
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image3 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image4 = NULL;
		if(isset($_FILES['image4']) and !empty($_FILES['image4']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image4')){	
							//echo $this->image_lib->display_errors();
				
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image4 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image5 = NULL;
		if(isset($_FILES['image5']) and !empty($_FILES['image5']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image5')){	
							//echo $this->image_lib->display_errors();
				
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image5 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image6 = NULL;
		if(isset($_FILES['image6']) and !empty($_FILES['image6']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image6')){	
							//echo $this->image_lib->display_errors();
				
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image6 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image7 = NULL;
		if(isset($_FILES['image7']) and !empty($_FILES['image7']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image7')){	
							//echo $this->image_lib->display_errors();
				
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image7 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$image8 = NULL;
		if(isset($_FILES['image8']) and !empty($_FILES['image8']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('image8')){	
							//echo $this->image_lib->display_errors();
				
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$image8 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		$doc1 = NULL;
		if(isset($_FILES['doc1']) and !empty($_FILES['doc1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'pdf';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$doc2 = NULL;
		if(isset($_FILES['doc2']) and !empty($_FILES['doc2']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'pdf';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc2')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc2 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$doc3 = NULL;
		if(isset($_FILES['doc3']) and !empty($_FILES['doc3']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'pdf';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc3')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc3 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$doc4 = NULL;
		if(isset($_FILES['doc4']) and !empty($_FILES['doc4']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'pdf';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc4')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc4 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		$docudm = NULL;
		if(isset($_FILES['docudm']) and !empty($_FILES['docudm']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|pdf|doc|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('docudm')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$docudm = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
				
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_center')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new center", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		
		if(empty($center_name)){
			$ar = array("status" => "fail", "error" => "Center Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($vendor_id)){
			$ar = array("status" => "fail", "error" => "Vendor is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		
		if(empty($address)){
			$ar = array("status" => "fail", "error" => "Address is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if($cs_email){
			if (!filter_var($cs_email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}	
		if($am_email){
			if (!filter_var($am_email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}		
		if($poc_email){
			if (!filter_var($poc_email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}	
		if($td_email){
			if (!filter_var($td_email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}		
		
				
		//get zone,state and city code
		//	$loc_code = $this->db->query("SELECT * from tt_states WHERE 1=1 AND id='".$state_id."'")->row();
		//	$zonal_id= $loc_code->zone_code;	
		//	$state_code= $loc_code->state_code;
		//Get Last id
		//	$cent_id_qry = $this->db->query("SELECT center_id from tt_center WHERE 1=1 AND 	state_id='".$state_id."'")->row();
		//	$last_center_id= $cent_id_qry->center_id;
		//	$new_center_id=$last_center_id+1;
			
				
		$check_qry = $this->db->query("select vendor_id,center_name	 from tt_center where 1=1 and vendor_id<>'".$vendor_id."' and center_name='".$center_name."' and id!='".$edit_user_id."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Center with selected vendot exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		for ($k = 0 ; $k < $iimg; $k++)
		{
				$result[] = $this->db->query("DELETE FROM `tt_center_images` WHERE id='".$delimg[$k]."'");	
		}
		
		
		for ($l = 0 ; $l < $idoc; $l++)
		{
				$result[] = $this->db->query("DELETE FROM `tt_center_document` WHERE id='".$deldoc[$l]."'");	
		}
		
		$save_data = array(
			"center_type" => $centertype,
			"vendor_id" => $vendor_id,
			"center_name" => trim($center_name),
			//"state_id" => $state_id,
			//"city_id" => $city_id,
			//"region_code" => $zonal_id,
			//"state_code" => $state_code,
			//"city_code" => $city_code,
			"address" => $address,
			"address_second" => $address_second,
			"address_lat" => $c_lat,
			"address_long" =>$c_long,
			"landmark" => $landmark,
			"city" => trim($city_name),			
			"pin_code" => trim($pincode),
			"landline_country_code" => trim($landline_country_code),
			"landline_area_code" => trim($landline_area_code),
			"landline_number" => trim($landline_number),
			"landline_extension" => trim($landline_extension),
			"nearest_railway_station" => trim($railway_station),
			"station_lat" => trim($rail_lat),
			"station_long" => trim($rail_long),
			"distance_from_station" => trim($distance_from_station),
			"nearest_bus_stop" => trim($bus_stop),
			"bus_lat" => trim($bus_lat),
			"bus_long" => trim($bus_long),
			"distance_from_bus_stop" => trim($bus_distance),
			"for_ph_candidate" => trim($ph_facility),
			"phydical_handicapped" => trim($phydical_handicapped),
			"document_sign" => trim($doc_signed),
			"photographs" => trim($photographs),
			"udyam_number" => trim($udyam_number),
			"pan_no" => $pan_number,
			"gst_no" => trim($gst_number),
			"gst_state_code" => trim($gst_state_code),
			"bank_name" => trim($bank_name),
			"bank_account_number" => trim($bank_account_no),
			"bank_ifsc_code" => trim($bank_ifsc_code),
			"beneficiary_name" => $beneficiary_name,
			"sec_bank_option" => $sec_bank_option,
			"secondary_pan_no" => $secondary_pan_no,
			"secondary_bank_name" => $secondary_bank_name,
			"secondary_bank_account_no" => $secondary_bank_account_no,
			"secondary_bank_ifsc_code" => $secondary_bank_ifsc_code,
			"secondary_beneficiary_name" => $secondary_beneficiary_name,
			"cs_name" => trim($cs_name),
			"cs_country_code" => trim($cs_country_code),
			"cs_contact_number" => trim($cs_contact_number),
			"cs_phone_alternate" => trim($cs_phone_alternate),
			"cs_email" => trim($cs_email),
			"am_name" => trim($am_name),
			"am_country_code" => trim($am_country_code),
			"am_contact_no" => trim($am_contact_no),
			"am_phone_alternate" => trim($am_phone_alternate),
			"am_email" => trim($am_email),
			"poc_name" => trim($poc_name),
			"poc_country_code" => trim($poc_country_code),
			"poc_contact_no" => trim($poc_contact_no),
			"poc_mobile_alternate" => trim($poc_mobile_alternate),
			"poc_email" => trim($poc_email),
			"emergency_counter_code" => trim($emergency_counter_code),
			"emergency_contact_no" => trim($emergency_contact_no),
			"emergency_number_alternate" => trim($emergency_number_alternate),
			"td_name" => trim($td_name),
			"td_country_code" => trim($td_country_code),
			"td_contact_no" => trim($td_contact_no),
			"td_phone_alternate" => trim($td_phone_alternate),
			"td_email" => trim($td_email),
			"total_no_system" => $total_no_system,
			"total_no_lab" => trim($total_no_lab),
			"partitaion_each_lab" => $partitaion_each_lab,
			"connected_single_network" => $connected_single_network,
			"how_many_network" => $how_many_network,
			"ac_in_each_lab" => $lab_ac,
			"lan_company_name" => $lan_company_name,
			"lan_model_number" => trim($lan_model_number),			
			"lan_speed" => trim($lan_speed),
			"lan_managed" => trim($lan_managed),
			"primary_isp_name" => trim($primary_isp_name),
			"primary_isp_bband_or_lease" => trim($primary_isp_bband_or_lease),
			"primary_isp_speed" => trim($primary_isp_speed),
			"primary_isp_bband_or_lease" => trim($primary_isp_bband_or_lease),
			"primary_isp_speed" => trim($primary_isp_speed),
			"secondary_isp_name" => trim($secondary_isp_name),
			"secondary_isp_bband_or_lease" => trim($secondary_isp_bband_or_lease),
			"secondary_isp_speed" => trim($secondary_isp_speed),
			"power_backup_generator_kv" => trim($power_backup_generator_kv),
			"power_back_ups_kv" => trim($power_back_ups_kv),
			"power_backup_hour" => trim($power_backup_hour),
			"power_backup_unit" => trim($power_backup_unit),
			"cctv_dvr" => trim($cctv_dvr),
			"network_printer" => trim($network_printer),
			"projector_sound_system" => trim($projector_sound_system),
			"fire_extinguisher" => trim($fire_extinguisher),
			"parking_facility" => trim($parking_facility),
			"security_guard_male" => trim($security_guard_male),
			"security_guard_female" => trim($security_guard_female),
			"entry_point" => trim($entry_point),
			"exit_point" => trim($exit_point),
			"locker_facility" => trim($locker_facility),
			"drinking_water_facility" => trim($drinking_water_facility),
			"onsite_engineer" => trim($onsite_engineer),
			"parents_waiting_hall" => trim($parents_waiting_hall),
			"candidates_waiting_hall" => trim($candidates_waiting_hall),
			"availability_of_engineers" => trim($availability_of_engineers),
			"type_of_center" => trim($type_of_center),
			"center_approved_by" => trim($center_approved_by),
			"center_affiliation_by" => trim($center_affiliation_by),
			"center_lab_establish_year" => trim($center_lab_establish_yr),
			"center_client_name" => trim($center_client_name),
			"center_prev_exam_name" => trim($center_prev_exam_name),
			"feedback" => trim($feedback),
			"last_modified_by" => $this->session->userdata('login_user_id'),
			"last_modified_on" => date('Y-m-d H:i:s')
		);	
		
		$this->db->where('id',$edit_user_id);
        $result = $this->db->update('tt_center',$save_data);
		//echo $this->db->last_query();exit;
		if($image1){
		$save_img1 = array(
			"center_id" => $edit_user_id,
			"center_image" => trim($image1),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result1 = $this->db->insert('tt_center_images',$save_img1);
		}
		
		if($image2){
		$save_img2 = array(
			"center_id" => $edit_user_id,
			"center_image" => trim($image2),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result2 = $this->db->insert('tt_center_images',$save_img2);
		}

		if($image3){
		$save_img3 = array(
			"center_id" => $edit_user_id,
			"center_image" => trim($image3),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result3 = $this->db->insert('tt_center_images',$save_img3);
		}
		
		if($image4){
		$save_img4 = array(
			"center_id" => $edit_user_id,
			"center_image" => trim($image4),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result4 = $this->db->insert('tt_center_images',$save_img4);
		}
		
		if($image5){
		$save_img5 = array(
			"center_id" => $edit_user_id,
			"center_image" => trim($image5),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result5 = $this->db->insert('tt_center_images',$save_img5);
		}
		
		if($image6){
		$save_img6 = array(
			"center_id" => $edit_user_id,
			"center_image" => trim($image6),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result6 = $this->db->insert('tt_center_images',$save_img6);
		}
		
		if($image7){
		$save_img7 = array(
			"center_id" => $edit_user_id,
			"center_image" => trim($image7),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result7 = $this->db->insert('tt_center_images',$save_img7);
		}
		
		if($image8){
		$save_img8 = array(
			"center_id" => $edit_user_id,
			"center_image" => trim($image8),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result8 = $this->db->insert('tt_center_images',$save_img8);
		}
		
		if($doc1){
		$save_doc1 = array(
			"center_id" => $edit_user_id,
			"doc_name" => trim($doc1),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$resultd1 = $this->db->insert('tt_center_document',$save_doc1);
		}

		if($doc2){
		$save_doc2 = array(
			"center_id" => $edit_user_id,
			"doc_name" => trim($doc2),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$resultd2 = $this->db->insert('tt_center_document',$save_doc2);
		}
		
		if($doc3){
		$save_doc3 = array(
			"center_id" => $edit_user_id,
			"doc_name" => trim($doc3),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$resultd3 = $this->db->insert('tt_center_document',$save_doc3);
		}
		
		if($doc4){
		$save_doc4 = array(
			"center_id" => $edit_user_id,
			"doc_name" => trim($doc4),
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$resultd4 = $this->db->insert('tt_center_document',$save_doc4);
		}
		
		
		if($docudm){
		$save_docudm = array(
			"udyam_document" => trim($docudm)
		);	
		$this->db->where('id',$edit_user_id);
        $result = $this->db->update('tt_center',$save_docudm);
		}
		
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			$redirect_url = base_url()."index.php?admin/edit_center/$edit_user_id";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	
	function view_center($id = NULL){			
		/*if(!hasPageAuthorize('view_center')){
				redirect(base_url(), 'refresh');exit;
		} */
		$directory = 'download';
  		$data["images"] = glob($directory . "/*.jpg");
		 
		'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$center_details = $this->db->query("SELECT * FROM tt_center where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$center_details){
			redirect(base_url(), 'refresh');exit;
		}
		
		$lab_details1 = $this->db->query("SELECT * FROM tt_lab where 1=1 and center_id='".$this->db->escape_str($id)."' and deleted=0 ORDER BY id asc")->result_array();
		$data['labDetail'] = $lab_details1;
		
		
		//echo '<br>S='.$aa="SELECT center_image FROM tt_center_images where 1=1 AND center_id='".$this->db->escape_str($id)."'";
		$center_images = $this->db->query("SELECT center_image FROM tt_center_images where 1=1 AND center_id='".$this->db->escape_str($id)."'")->result_array();
		$data['center_images'] = $center_images;
		
		$center_doc = $this->db->query("SELECT doc_name	FROM tt_center_document where 1=1 AND center_id='".$this->db->escape_str($id)."'")->result_array();
		$data['center_doc'] = $center_doc;
		
		$center_video = $this->db->query("SELECT about_video, center_video FROM tt_center_video where 1=1 AND center_id='".$this->db->escape_str($id)."'")->result_array();
		$data['center_video'] = $center_video;
		
		$id=$this->db->escape_str($id);
		
		
		
		
		$data['center_details'] = $center_details;
		$data['page_name']= 'view_center';
		$data['page_title']= "View Center Detail";
		$this->load->view('backend/index', $data);
	}
	
		function add_lab($id = NULL){			
		/*if(!hasPageAuthorize('add_lab')){
			redirect(base_url(), 'refresh');exit;
		} */

		'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$lab_details = $this->db->query("SELECT * FROM tt_center where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$lab_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['lab_details'] = $lab_details;
		$data['page_name'] = 'add_lab';
		$data['page_title'] = "Add Lab";
		$this->load->view('backend/index', $data);
	}
	
	function add_lab_process(){

		$center_id = $_POST['center_id'];
		$no_of_lab = $_POST['no_of_lab'];
		$lab_name = $_POST['lab_name'];
		$floor_name = $_POST['floor_name'];
		$no_of_computer = $_POST['no_of_computer'];
		$monitor_type = $_POST['monitor_type'];
		$operating_system = $_POST['operating_system'];
		$processor = $_POST['processor'];
		$ram = $_POST['ram'];
		$hard_disk = $_POST['hard_disk'];
		$model_no = $_POST['model_no'];
		$no_of_ethernet_switch = $_POST['no_of_ethernet_switch'];
		$no_of_port_eth_switch = $_POST['no_of_port_eth_switch'];
		$switch_manage_status = $_POST['switch_manage_status'];
		$ehternet_swtch_company = $_POST['ehternet_swtch_company'];
		$model_no_etherbet_swtch = $_POST['model_no_etherbet_swtch'];
		
		$lan_speed = $_POST['lan_speed'];
		$no_of_cctv_each_lab = $_POST['no_of_cctv_each_lab'];
		$no_of_acs = $_POST['no_of_acs'];
		$no_of_fan = $_POST['no_of_fan'];
		$ups_connected = $_POST['ups_connected'];
		$partitation = $_POST['partitation'];
		$fire_extinguisher = $_POST['fire_extinguisher'];
		
		 $submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_center')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new center", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		//exit;
		
		for ($k = 0 ; $k < $no_of_lab; $k++)
		{
			if($lab_name[$k])
			{
				$save_data = array(
				"center_id" => $center_id,
				"lab_name" => str_replace("'","&#8217;",trim($lab_name[$k])),
				"floor_name" => str_replace("'","&#8217;",trim($floor_name[$k])),
				"no_of_computer" => str_replace("'","&#8217;",trim($no_of_computer[$k])),
				"no_of_ac" => str_replace("'","&#8217;",trim($no_of_acs[$k])),
				"monitor_type" => $monitor_type[$k],
				"operating_system" => $operating_system[$k],
				"processor" => $processor[$k],
				"ram" => $ram[$k],
				"hard_disk" => $hard_disk[$k],
				"model_no" => str_replace("'","&#8217;",trim($model_no[$k])),
				"no_of_ethernet_switch" => str_replace("'","&#8217;",trim($no_of_ethernet_switch[$k])), 
				"no_of_port_eth_switch" => str_replace("'","&#8217;",trim($no_of_port_eth_switch[$k])), 
				"switch_manage_status" => $switch_manage_status[$k], 
				"lan_speed" => $lan_speed[$k], 
				"ehternet_swtch_company" => str_replace("'","&#8217;",trim($ehternet_swtch_company[$k])),  
				"model_no_etherbet_swtch" => str_replace("'","&#8217;",trim($model_no_etherbet_swtch[$k])),
				"ups_connected" => $ups_connected[$k], 
				"partitation" => $partitation[$k], 
				"no_of_cctv_each_lab" => str_replace("'","&#8217;",trim($no_of_cctv_each_lab[$k])),
				"no_of_fan" => str_replace("'","&#8217;",trim($no_of_fan[$k])), 
				"fire_extinguisher" => $fire_extinguisher[$k], 
				"created_by" => $this->session->userdata('login_user_id'),
				"created_on" => date('Y-m-d H:i:s')
			);	
				$result = $this->db->insert('tt_lab',$save_data);
			}
		}
		
		$last_insert_id = $this->db->insert_id();
		if($result){
			$redirect_url = base_url()."index.php?admin/center_listing";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Lab Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	
	}
	
	
	function lab_listing($id=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');
		} */
		
		if(trim($this->input->post('button'))=='Download')
		{
			$action = trim($this->input->post('button'));
			$cid = $_POST['centerId'];
			$cnt_name1 = $this->db->query("SELECT center_name FROM tt_center where 1=1 AND id='".$cid."'")->row();
			$centerName1 = ucwords($cnt_name1->center_name);
			
			
				set_time_limit(10000);
						
		$this->load->library('export');
		
		
		
		
		$this->db->select(" @a:=@a+1 'Serial No', c.center_name as 'Center Name', CONCAT(c.region_code,'-',c.state_code,'-', c.city_code,'-',c.center_id) as 'Center Code', ru.lab_name as 'Lab Name', ru.floor_name as 'Floor Name', ru.no_of_computer as 'Number of Computers', ru.no_of_ac as 'Number of ACs.', ru.monitor_type as 'Monitor Type', ru.operating_system as 'Operating System', ru.processor as 'Processor', ru.ram as 'RAM', ru.hard_disk as 'Hard Disk', ru.model_no as 'Model Number', ru.no_of_ethernet_switch as 'Number of Ethernet Switch', ru.no_of_port_eth_switch as 'No of Port Ethernet Switch', ru.switch_manage_status as 'Switch Manage Status', ru.lan_speed as 'LAN Speed', ru.ehternet_swtch_company as 'Ethernet Switch Company', ru.model_no_etherbet_swtch as 'Model No of Ehternet Switch', ru.ups_connected	 as 'UPS Connected', ru.partitation as 'Partitation', ru.no_of_cctv_each_lab as 'Number of CCTV in each Lab', ru.fire_extinguisher as 'Fire Extinguisher each lab', ru.no_of_fan as 'Number of Fan', ru.no_of_ac as 'Number of AC', ru.fire_extinguisher as 'Fire Extinguisher'", false);		
		
		$this->db->from('tt_lab ru, (SELECT @a:= 0) AS a')->join('tt_center c', 'ru.center_id=c.id', 'left');
			
		$this->db->where ('ru.center_id', $cid); 
		$this->db->where ('ru.verified', 0);
		$this->db->where ('ru.deleted', 0);		
		$this->db->order_by("ru.id", "asc"); 
		$query = $this->db->get();
		$e_data = $query->result_array();
		$aa=date('Y-m-d H:i:s');
		//echo $this->db->last_query();exit;
		$file_name = "Lab_data_".$centerName1.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		}  
		
		$cnt_name = $this->db->query("SELECT center_name FROM tt_center where 1=1 AND id='".$id."'")->row();
		$centerName = ucwords($cnt_name->center_name);
		$data['admin_user_info']    = $this->crud_model->select_all_lab($id);
		
		$data['page_name']          = 'lab_listing';
		$data['page_title']         = "Lab Listing for $centerName";
		$this->load->view('backend/index', $data);
	}
	
	function edit_lab_info(){
		/*if(!hasPageAuthorize('edit_lab_info')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		/*echo "<pre>";
		print_r($_POST);exit;*/
		$id = $this->db->escape_str(trim($this->input->post('id')));
		$centerId = trim($this->input->post('centerId'));
		$lab_name = str_replace("'","&#8217;",trim($this->input->post('lab_name')));
		$floor_name = str_replace("'","&#8217;",trim($this->input->post('floor_name')));
		$no_of_computer = trim($this->input->post('no_of_computer'));	
		$no_of_ac = trim($this->input->post('no_of_ac'));	
		$monitor_type = trim($this->input->post('monitor_type'));	
		$operating_system = trim($this->input->post('operating_system'));	
		$processor = trim($this->input->post('processor'));	
		$ram = trim($this->input->post('ram'));	
		$hard_disk = trim($this->input->post('hard_disk'));	
		$model_no = str_replace("'","&#8217;",trim($this->input->post('model_no')));
		
		$no_of_ethernet_switch = str_replace("'","&#8217;",trim($this->input->post('no_of_ethernet_switch')));
		$no_of_port_eth_switch = str_replace("'","&#8217;",trim($this->input->post('no_of_port_eth_switch')));
		$switch_manage_status = trim($this->input->post('switch_manage_status'));	
		$lan_speed = trim($this->input->post('lan_speed'));	
		$ehternet_swtch_company = str_replace("'","&#8217;",trim($this->input->post('ehternet_swtch_company')));
		$model_no_etherbet_swtch = str_replace("'","&#8217;",trim($this->input->post('model_no_etherbet_swtch')));
		
		$ups_connected = trim($this->input->post('ups_connected'));	
		$partitation = trim($this->input->post('partitation'));	
		$no_of_cctv_each_lab = trim($this->input->post('no_of_cctv_each_lab'));	
		$no_of_fan = trim($this->input->post('no_of_fan'));
		$fire_extinguisher = trim($this->input->post('fire_extinguisher'));		
	
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(empty($id) or !is_numeric($id)){
			$ar = array("status" => "fail", "error" => "Invalid id.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($lab_name)){
			$ar = array("status" => "fail", "error" => "Lab Name is required.", "frm_btn_id" => "submit_btn_id", "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($no_of_computer)){
			$ar = array("status" => "fail", "error" => "Number of Computer is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
				
		$check_qry = $this->db->query("select id from  tt_lab where 1=1 and id<>'".$id."' and center_id='".$centerId."' and lab_name='".$lab_name."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Lab exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$last_insert_id = $this->crud_model->update_lab_info();
		if($last_insert_id){
			$redirect_url = base_url()."index.php?admin/lab_listing/$centerId";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "lab id code is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		//$this->session->set_flashdata('message' , "Data saved successfully");
		//redirect('index.php?admin/ministry_of_textile');
	
	}

	function manage_client($task = ""){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		
		/*if(!hasPageAuthorize('manage_client')){
			redirect(base_url(), 'refresh');exit;
		} */  
		
		if(trim($this->input->post('button'))){
		$action = trim($this->input->post('button'));
		$vendor_id = $_POST['clientIds'];
		for($i=0;$i<sizeof($vendor_id); $i++)
		{	
			if(trim($this->input->post('button'))=='Inactive')
			{
				$result[] = $this->db->query("update tt_client set deleted=1 where id='".$this->db->escape_str($_POST['clientIds'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Activate')
			{
				$result[] = $this->db->query("update tt_client set deleted=0 where id='".$this->db->escape_str($_POST['clientIds'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Delete')
			{
				$result[] = $this->db->query("update tt_client set deleted=2 where id='".$this->db->escape_str($_POST['clientIds'][$i])."'");	
			}
		
		}
		
		}
		$data['admin_user_info']    = $this->crud_model->select_client_data();
		$data['page_name']          = 'manage_client';
		$data['page_title']         = "Manage Client";
		$this->load->view('backend/index', $data);
	}
	
	function add_client(){			
		/*if(!hasPageAuthorize('add_admin_user')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['page_name']          = 'add_client';
		$data['page_title']         = "Add Client";
		$this->load->view('backend/index', $data);
	}
	
	function add_client_process(){
	/*echo "<pre>";
		print_r($_POST);exit;*/
		$company_name = str_replace("'","&#8217;",trim($this->input->post('company_name')));
		$company_type = str_replace("'","&#8217;",trim($this->input->post('company_type')));
		$website = str_replace("'","&#8217;",trim($this->input->post('website')));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		//$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		$landmark = str_replace("'","&#8217;",trim($this->input->post('landmark')));
		$country_id = trim($this->input->post('country_id'));
		$state_id = trim($this->input->post('state_id'));
		$city_id = trim($this->input->post('city_name'));
		$pincode = trim($this->input->post('pincode'));
		//$latitude = str_replace("'","&#8217;",trim($this->input->post('latitude')));
		//$longitude = str_replace("'","&#8217;",trim($this->input->post('longitude')));
		$co_ordinator_name = str_replace("'","&#8217;",trim($this->input->post('co_ordinator_name')));	
		$email = trim($this->input->post('email'));
		//$country_code = trim($this->input->post('country_code'));
		$area_code = trim($this->input->post('area_code'));
		$landline_number = trim($this->input->post('landline_number'));
		$extension = trim($this->input->post('extension'));
		
		
		//$mob_country_code = trim($this->input->post('mob_country_code'));
		$mobile = trim($this->input->post('mobile'));
		$mobile_alternate = trim($this->input->post('mobile_alternate'));
		$bank_name = str_replace("'","&#8217;",trim($this->input->post('bank_name')));	
		$bank_account_no = str_replace("'","&#8217;",trim($this->input->post('bank_account_no')));	
		$bank_ifsc_code = str_replace("'","&#8217;",trim($this->input->post('bank_ifsc_code')));
		$bank_beneficial_name = str_replace("'","&#8217;",trim($this->input->post('bank_beneficial_name')));
		$pan_number = str_replace("'","&#8217;",trim($this->input->post('pan_number')));	
		$gst_number = str_replace("'","&#8217;",trim($this->input->post('gst_number')));
		$udyam_number = str_replace("'","&#8217;",trim($this->input->post('udyam_number')));
		//$is_active = trim($this->input->post('is_active'));
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_admin_user')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add admin user", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		if(empty($company_name)){
			$ar = array("status" => "fail", "error" => "Company Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($address)){
			$ar = array("status" => "fail", "error" => "Company Address is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($country_id)){
			$ar = array("status" => "fail", "error" => "Country is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($state_id)){
			$ar = array("status" => "fail", "error" => "State is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($city_id)){
			$ar = array("status" => "fail", "error" => "City is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
		
		
		$check_qry = $this->db->query("select id from  tt_client where 1=1 and company_name='".$company_name."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Company exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		
		$check_qry = $this->db->query("select id from  tt_client where 1=1 and email_id='".$email."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Company email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		////DOCUMENT UPLOAD SECTION START
		$upload_dir_doc = 'uploads/client_document/';
	//	$doc1 = NULL;
		if(isset($_FILES['doc1']) and !empty($_FILES['doc1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc2 = NULL;
		if(isset($_FILES['doc2']) and !empty($_FILES['doc2']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc2')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc2 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc3 = NULL;
		if(isset($_FILES['doc3']) and !empty($_FILES['doc3']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc3')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc3 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc4 = NULL;
		if(isset($_FILES['doc4']) and !empty($_FILES['doc4']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc4')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc4 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc5 = NULL;
		if(isset($_FILES['doc5']) and !empty($_FILES['doc5']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc5')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc5 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		///END
		
		
		
		if($state_id){
			$sts_name = $this->db->query("SELECT state_code_gst FROM tt_states where 1=1 AND id='".$state_id."'")->row();
			$state_code_gst = $sts_name->state_code_gst;
		
		}
		$save_data = array(
			"company_name" => $company_name,
			"company_type" => $company_type,
			"website" => $website,
			"address" => $address,
			"landmark" => $landmark,
			"country_id" => $country_id,
			"state" => $state_id,
			"city" => $city_id,
			"pincode" => $pincode,
			"co_ordinator_name" => $co_ordinator_name,
			"email_id" => $email,
			"mobile_no" => $mobile,
			"mobile_alternate" => $mobile_alternate,
			"area_code" => $area_code,
			"landline_number" => $landline_number,
			"extension" => $extension,
			"bank_name" => $bank_name,
			"bank_account_no" => $bank_account_no,
			"bank_ifsc_code" => $bank_ifsc_code,
			"bank_beneficial_name" => $bank_beneficial_name,
			"pan_number" => $pan_number,
			"gst_state_code" => $state_code_gst,
			"gst_number" => $gst_number,
			"udyam_number" => $udyam_number,
			"bank_doc" => $doc1,
			"agreement_doc" => $doc2,
			"mou_doc" => $doc3,
			"gst_doc" => $doc4,
			"udyam_doc" => $doc5,
			"created_by" => $this->session->userdata('login_user_id'),
			"created_on" => date('Y-m-d H:i:s')
		);	
		
		$result = $this->db->insert('tt_client',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		
		
		if($result){
			$redirect_url = base_url()."index.php?admin/manage_client";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	 public function load_city_id(){		
		$state_id = trim($_POST['state_id']);
		$city_id = "";
		if(!empty($_POST['city_id'])){
			$city_id = $_POST['city_id'];
		}
		echo $this->common_options->city_name_option($city_id, $state_id);
	}
	
	/*public function load_city_name(){		
		$state_id = trim($_POST['state_id']);
		$city_name = "";
		if(!empty($_POST['city_name'])){
			$city_name = $_POST['city_name'];
		}
		echo $this->common_options->get_city_list($city_name, $state_id);
	}*/
	
	
	function edit_client($id = NULL){			
		/*if(!hasPageAuthorize('edit_client')){
			redirect(base_url(), 'refresh');exit;
		} */

		'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$client_details = $this->db->query("SELECT * FROM tt_client where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$client_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['client_details'] = $client_details;
		$data['page_name']          = 'edit_client';
		$data['page_title']         = "Edit Client Information";
		$this->load->view('backend/index', $data);
	}
	
	
	function edit_client_process(){
		/*if(!hasPageAuthorize('edit_client_process')){
			redirect(base_url(), 'refresh');exit;
		} */  
		$id = trim($this->input->post('id'));
		$company_name = str_replace("'","&#8217;",trim($this->input->post('company_name')));
		$company_type = str_replace("'","&#8217;",trim($this->input->post('company_type')));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$landmark = str_replace("'","&#8217;",trim($this->input->post('landmark')));
		$country_id = trim($this->input->post('country_id'));
		$state_id = trim($this->input->post('state_id'));
		$city_id = trim($this->input->post('city_name'));
		$pincode = trim($this->input->post('pincode'));
		$website = str_replace("'","&#8217;",trim($this->input->post('website')));
		//$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		//$latitude = str_replace("'","&#8217;",trim($this->input->post('latitude')));
		//$longitude = str_replace("'","&#8217;",trim($this->input->post('longitude')));
		$co_ordinator_name = str_replace("'","&#8217;",trim($this->input->post('co_ordinator_name')));		
		$email = trim($this->input->post('email'));
		$mobile = trim($this->input->post('mobile_no'));
		$mobile_alternate = trim($this->input->post('mobile_alternate'));
		//$country_code = trim($this->input->post('country_code'));
		$area_code = trim($this->input->post('area_code'));
		$landline_number = trim($this->input->post('landline_number'));
		$extension = trim($this->input->post('extension'));		
		$bank_name = str_replace("'","&#8217;",trim($this->input->post('bank_name')));
		$bank_account_no = str_replace("'","&#8217;",trim($this->input->post('bank_account_no')));
		$bank_ifsc_code = str_replace("'","&#8217;",trim($this->input->post('bank_ifsc_code')));
		$bank_beneficial_name = str_replace("'","&#8217;",trim($this->input->post('bank_beneficial_name')));
		$pan_number = str_replace("'","&#8217;",trim($this->input->post('pan_number')));
		$gst_number = str_replace("'","&#8217;",trim($this->input->post('gst_number')));
		$udyam_number = str_replace("'","&#8217;",trim($this->input->post('udyam_number')));
		//$mob_country_code = trim($this->input->post('mob_country_code'));
		
		
		
	
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_admin_user')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add admin user", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		if(empty($company_name)){
			$ar = array("status" => "fail", "error" => "Company Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($address)){
			$ar = array("status" => "fail", "error" => "Company Address is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($state_id)){
			$ar = array("status" => "fail", "error" => "State is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($city_id)){
			$ar = array("status" => "fail", "error" => "City is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
		$check_qry = $this->db->query("select id from  tt_client where 1=1 and  id<>'".$id."' and company_name='".$company_name."' and state='".$state_id."' and city='".$city_id."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Company exist in selected city.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		
		$check_qry = $this->db->query("select id from  tt_client where 1=1  and  id<>'".$id."' and email_id='".$email."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Company email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($state_id){
			$sts_name = $this->db->query("SELECT state_code_gst FROM tt_states where 1=1 AND id='".$state_id."'")->row();
			$state_code_gst = $sts_name->state_code_gst;
		
		}
		
		////DOCUMENT UPLOAD SECTION START
		$upload_dir_doc = 'uploads/client_document/';
	//	$doc1 = NULL;
		if(isset($_FILES['doc1']) and !empty($_FILES['doc1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc2 = NULL;
		if(isset($_FILES['doc2']) and !empty($_FILES['doc2']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc2')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc2 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc3 = NULL;
		if(isset($_FILES['doc3']) and !empty($_FILES['doc3']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc3')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc3 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc4 = NULL;
		if(isset($_FILES['doc4']) and !empty($_FILES['doc4']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc4')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc4 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	//	$doc5 = NULL;
		if(isset($_FILES['doc5']) and !empty($_FILES['doc5']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'doc|pdf|txt|docx|png|jpg|jpeg|bmp';
			$configsd['max_size'] = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('doc5')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$doc5 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		///END
		
		$save_data = array(
			"company_name" => $company_name,
			"company_type" => $company_type,
			"website" => $website,
			"address" => $address,
			"landmark" => $landmark,
			"country_id" => $country_id,
			"state" => $state_id,
			"city" => $city_id,
			"pincode" => $pincode,
			"co_ordinator_name" => $co_ordinator_name,
			"email_id" => $email,
			"mobile_no" => $mobile,
			"mobile_alternate" => $mobile_alternate,
			"area_code" => $area_code,
			"landline_number" => $landline_number,
			"extension" => $extension,
			"bank_name" => $bank_name,
			"bank_account_no" => $bank_account_no,
			"bank_ifsc_code" => $bank_ifsc_code,
			"bank_beneficial_name" => $bank_beneficial_name,
			"pan_number" => $pan_number,
			"gst_state_code" => $state_code_gst,
			"gst_number" => $gst_number,
			"udyam_number" => $udyam_number,
			"updated_by" => $this->session->userdata('login_user_id'),
			"update_on" => date('Y-m-d H:i:s')
		);	
		
		$this->db->where('id',$id);
		$result = $this->db->update('tt_client',$save_data);
		
		if($doc1){ 	$save_doc1 = array(
									"bank_doc" => $doc1
					);	
					$this->db->where('id',$id);
					$resultd1 = $this->db->update('tt_client',$save_doc1);
		}
		if($doc2){ 	$save_doc2 = array(
									"agreement_doc" => $doc2
					);	
					$this->db->where('id',$id);
					$resultd2 = $this->db->update('tt_client',$save_doc2);
		}
		if($doc3){ 	$save_doc3 = array(
									"mou_doc" => $doc3
					);	
					$this->db->where('id',$id);
					$resultd3 = $this->db->update('tt_client',$save_doc3);
		}
		if($doc4){ 	$save_doc4 = array(
									"gst_doc" => $doc4
					);	
					$this->db->where('id',$id);
					$resultd3 = $this->db->update('tt_client',$save_doc4);
		}
		if($doc5){ 	$save_doc5 = array(
									"udyam_doc" => $doc5
					);	
					$this->db->where('id',$id);
					$resultd3 = $this->db->update('tt_client',$save_doc5);
		}
		
		
		
	//	$result = $this->db->insert('',$save_data);
	//	$last_insert_id = $this->db->insert_id();
				
	//	$last_insert_id = $this->crud_model->update_client_info();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/manage_client";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "lab id code is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
	}
	
		function view_client($id = NULL){			
		/*if(!hasPageAuthorize('view_client')){
				redirect(base_url(), 'refresh');exit;
		} */

		$this->session->set_userdata(array("edit_user_id" => $id));
		$client_details = $this->db->query("SELECT * FROM tt_client where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$client_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['client_details'] = $client_details;
		$data['page_name']          = 'view_client';
		$data['page_title']         = "View Client Detail";
		$this->load->view('backend/index', $data);
	}
	
	
	function manage_project_______________deleteddd(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		} */  
		/*if(trim($this->input->post('button'))){
		$action = trim($this->input->post('button'));
		$id = $_POST['ids'];
		for($i=0;$i<sizeof($id); $i++)
		{	
			if(trim($this->input->post('button'))=='Inactive')
			{
				$result[] = $this->db->query("update tt_center_booking set deleted=1 where id='".$this->db->escape_str($_POST['ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Activate')
			{
				$result[] = $this->db->query("update tt_center_booking set deleted=0 where id='".$this->db->escape_str($_POST['ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Delete')
			{
				$result[] = $this->db->query("update tt_center_booking set deleted=2 where id='".$this->db->escape_str($_POST['ids'][$i])."'");	
			}
		
		}
		
		}*/
		//($vendor_id);
		/*echo "<pre>";
		print_r($_POST);exit;*/

		
		$data['admin_project_info']    = $this->crud_model->select_all_project();
		$data['page_name']          = 'manage_project';
		$data['page_title']         = "Manage Project";
		$this->load->view('backend/index', $data);
	}
	
	function add_project(){			
		/*if(!hasPageAuthorize('add_project')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['city_name_info']    = $this->crud_model->select_all_city();
		$data['page_name']          = 'add_project';
		$data['page_title']         = "Add Project";
		$this->load->view('backend/index', $data);
	}
	
	function manage_manpower(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
	/*	if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		if(trim($this->input->post('button'))){
		$action = trim($this->input->post('button'));
		$id = $_POST['ids'];
		for($i=0;$i<sizeof($id); $i++)
		{	
			if(trim($this->input->post('button'))=='Inactive')
			{
				$result[] = $this->db->query("update tt_manpower set deleted=1 where id='".$this->db->escape_str($_POST['ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Activate')
			{
				$result[] = $this->db->query("update tt_manpower set deleted=0 where id='".$this->db->escape_str($_POST['ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Delete')
			{
				$result[] = $this->db->query("update tt_manpower set deleted=2 where id='".$this->db->escape_str($_POST['ids'][$i])."'");	
			}
		
		}
		
		}
		//($vendor_id);
		/*echo "<pre>";
		print_r($_POST);exit;*/

		
		$data['admin_user_info']    = $this->crud_model->select_all_manpower();
		echo $this->db->last_query();exit;	
		$data['page_name']          = 'manage_manpower';
		$data['page_title']         = "Manage Manpower";
		$this->load->view('backend/index', $data);
	}
	
	function add_manpower(){			
		/*if(!hasPageAuthorize('add_vendor')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['page_name']          = 'add_manpower';
		$data['page_title']         = "Register New Manpower";
		$this->load->view('backend/index', $data);
	}

	/*function add_manpower_process(){
		
		$full_name = str_replace("'","&#8217;",trim($this->input->post('full_name')));
		$country_code = trim($this->input->post('country_code'));
		$contact_number = trim($this->input->post('contact_number'));
		$alt_country_code = trim($this->input->post('alt_country_code'));
		$alternamt_contact_no = trim($this->input->post('alternamt_contact_no'));
		$email = trim($this->input->post('email'));
		$date_of_birth = trim($this->input->post('date_of_birth'));
				
		$father_name = str_replace("'","&#8217;",trim($this->input->post('father_name')));
		$f_couuntry_code = trim($this->input->post('f_couuntry_code'));
		$father_contact_no = trim($this->input->post('father_contact_no'));
		$qualification = str_replace("'","&#8217;",trim($this->input->post('qualification')));

		
		$experience_online_exam = trim($this->input->post('experience_online_exam'));
		if($experience_online_exam=='yes')
		{
			$exp_exam_name = trim($this->input->post('exp_exam_name'));
		}
		else
		{
			$exp_exam_name = '';
		}
		
		$govt_id_type = str_replace("'","&#8217;",trim($this->input->post('govt_id_type')));
		$govt_id_no = str_replace("'","&#8217;",trim($this->input->post('govt_id_no')));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		
		$state_id = trim($this->input->post('state_id'));
		$city = trim($this->input->post('city'));
		$pincode = trim($this->input->post('pincode'));
		
		$today_date=date('Y-m-d H:i:s');
				
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
		
	
		if(empty($full_name)){
			$ar = array("status" => "fail", "error" => "Full Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($contact_number)){
			$ar = array("status" => "fail", "error" => "Contact Number is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
		$check_qry = $this->db->query("select id from tt_manpower where 1=1 and email='".$email."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if($date_of_birth){
			//d/m/y
			$birthdate_ar = explode("/", $date_of_birth);
			$birthdate = $birthdate_ar[2]."-".$birthdate_ar[0]."-".$birthdate_ar[1];
		}
		
		$save_data = array(
			"full_name" => $full_name,
			"country_code" => $country_code,
			"contact_number" => $contact_number,
			"alt_country_code" => $alt_country_code,
			"alternamt_contact_no"=> $alternamt_contact_no,
			"email" => $email,
			"date_of_birth" => $birthdate,
			"father_name" => $father_name,
			"f_couuntry_code" => trim($f_couuntry_code),
			"father_contact_no" => trim($father_contact_no),			
			"qualification" => trim($qualification),
			"experience_online_exam" => trim($experience_online_exam),
			"exp_exam_name" => trim($exp_exam_name),
			"govt_id_type" => trim($govt_id_type),
			"govt_id_no" => trim($govt_id_no),
			"address" => trim($address),
			"address_second" => trim($address_second),
			"state" => trim($state_id),
			"city" => trim($city),
			"pincode" => $pincode,
			"created_by" => $this->session->userdata('login_user_id'),
			"created_on" => date('Y-m-d H:i:s')
		);	
		
		$result = $this->db->insert('tt_manpower',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/manage_manpower";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}*/
	
	function add_manpower_process(){
	
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$mp_type = trim($this->input->post('mp_type'));
		$fl_type = trim($this->input->post('fl_type'));
		if($mp_type==1){
			$fl_type=='';		
		}
		$vendor_name = str_replace("'","&#8217;",trim($this->input->post('vendor_name')));
		$client_name = str_replace("'","&#8217;",trim($this->input->post('client_name')));
		$full_name = str_replace("'","&#8217;",trim($this->input->post('full_name')));
		$contact_number = trim($this->input->post('contact_number'));
		$alternamt_contact_no = trim($this->input->post('alternamt_contact_no'));
		$email = trim($this->input->post('email'));
		$date_of_birth_m = trim($this->input->post('date_of_birth'));
		$date_of_birth_mn = explode("/", $date_of_birth_m);
		$date_of_birth = $date_of_birth_mn[2]."-".$date_of_birth_mn[1]."-".$date_of_birth_mn[0];
		$language = str_replace("'","&#8217;",trim($this->input->post('language')));
		$gender = trim($this->input->post('gender'));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$country_id = trim($this->input->post('country_id'));
		$state_id = trim($this->input->post('state_id'));
		$city = trim($this->input->post('state_id'));
		$pincode = trim($this->input->post('pincode'));
		$add_status = trim($this->input->post('add_status'));
		
		if($add_status=='yes'){
			$address = str_replace("'","&#8217;",trim($this->input->post('address')));
			$state_id = trim($this->input->post('state_id'));
			$city = $this->input->post('city');
			$pincode = trim($this->input->post('pincode'));
		}
		if($add_status=='no'){
			$permanent_address = str_replace("'","&#8217;",trim($this->input->post('permanent_address')));
			$state_id_p = $this->input->post('state_id_p');
			$city_p = $this->input->post('city_p');
			$pincode_p = trim($this->input->post('pincode_p'));
		}
		
		$ready_to_travel = $this->input->post('ready_to_travel');
		$linkedin = str_replace("'","&#8217;",trim($this->input->post('linkedin')));
		$twitter = str_replace("'","&#8217;",trim($this->input->post('twitter')));
		$facebook = str_replace("'","&#8217;",trim($this->input->post('facebook')));
		$instagram = str_replace("'","&#8217;",trim($this->input->post('instagram')));
		$father_name = str_replace("'","&#8217;",trim($this->input->post('father_name')));
		$father_contact_no = trim($this->input->post('father_contact_no'));
		$occupation = str_replace("'","&#8217;",trim($this->input->post('occupation')));
		$matric = str_replace("'","&#8217;",trim($this->input->post('matric')));
		$matric_school = str_replace("'","&#8217;",trim($this->input->post('matric_school')));
		$matric_year = trim($this->input->post('matric_year'));
		$intermediate = str_replace("'","&#8217;",trim($this->input->post('intermediate')));
		$intermediate_school = str_replace("'","&#8217;",trim($this->input->post('intermediate_school')));
		$intermediate_year = trim($this->input->post('intermediate_year'));
		$bachelor = trim($this->input->post('bachelor'));
		$bachelor_st = trim($this->input->post('bachelor_st'));
		$university = str_replace("'","&#8217;",trim($this->input->post('university')));
		$batchelor_sem = trim($this->input->post('batchelor_sem'));
		$bachelor_year = trim($this->input->post('bachelor_year'));		
		$course = str_replace("'","&#8217;",trim($this->input->post('course')));
		$subject = str_replace("'","&#8217;",trim($this->input->post('subject')));
		
		
		$experience_online_exam = $this->input->post('experience_online_exam');
		if($experience_online_exam=='yes')
		{
			$work_mode = trim($this->input->post('work_mode'));
			if($work_mode=='online')
			{
				$company = trim($this->input->post('company'));
				$designation = trim($this->input->post('designation'));
				$project = trim($this->input->post('project'));
				$experience = trim($this->input->post('experience'));
			}
			if($work_mode=='offline')
			{
				$company = trim($this->input->post('company'));
				$designation = trim($this->input->post('designation'));
				$project = trim($this->input->post('project'));
				$experience = trim($this->input->post('experience'));
			}
		}
		
		if($experience_online_exam=='any_others')
		{
			$work_mode = '';
			$experience_other = trim($this->input->post('experience_other'));
			$other_designation = trim($this->input->post('other_designation'));
			$other_job = trim($this->input->post('other_job'));
			$other_exp = trim($this->input->post('other_exp'));
		}
		
		
		
		$aadhar = str_replace("'","&#8217;",trim($this->input->post('aadhar')));
		$pan = str_replace("'","&#8217;",trim($this->input->post('pan')));
		$passport = str_replace("'","&#8217;",trim($this->input->post('passport')));
		$driving = str_replace("'","&#8217;",trim($this->input->post('driving')));
		$voter = str_replace("'","&#8217;",trim($this->input->post('voter')));
		$p_verification = str_replace("'","&#8217;",trim($this->input->post('p_verification')));
		$p_verification_dt = trim($this->input->post('p_verification_dt'));
		if($p_verification_dt){
			//d/m/y
			$date_arm = explode("/", $p_verification_dt);
			$start_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}
		$bgc_report = str_replace("'","&#8217;",trim($this->input->post('bgc_report')));
		$bgc_report_dt = trim($this->input->post('bgc_report_dt'));
		if($bgc_report_dt){
			//d/m/y
			$date_arm = explode("/", $bgc_report_dt);
			$start_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}
		
		$benf_name = str_replace("'","&#8217;",trim($this->input->post('benf_name')));
		$bank_account_no = str_replace("'","&#8217;",trim($this->input->post('bank_account_no')));
		$bank_ifsc_code = str_replace("'","&#8217;",trim($this->input->post('bank_ifsc_code')));
		$bank_name = str_replace("'","&#8217;",trim($this->input->post('bank_name')));

		$today_date=date('Y-m-d H:i:s');
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_manpower')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new Manpower entry", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		
		
		if(empty($mp_type)){
			$ar = array("status" => "fail", "error" => "Manpower Category is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($mp_type==2 && $fl_type=='')
		{
				$ar = array("status" => "fail", "error" => "Manpower Freelance Category  is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;	
		}
	
	
	
	
		if(empty($full_name)){
			$ar = array("status" => "fail", "error" => "Manpower Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
			if(empty($contact_number)){
				$ar = array("status" => "fail", "error" => "Mobile Number is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
			
			if(empty($email)){
				$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
			
			if($email){
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
					echo json_encode($ar);
					exit;
				}
			}
		
			$check_qry = $this->db->query("select id from tt_manpower where 1=1 and email='".$email."' and email!=''");
			if($check_qry->num_rows()>0){
				$ar = array("status" => "fail", "error" => "Email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		
		$upload_dir = 'uploads/manpower_image/';
		$upload_dir_doc = 'uploads/manpower_document/';

		$photo = NULL;
		if(isset($_FILES['photo']) and !empty($_FILES['photo']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('photo')){	
							//echo $this->image_lib->display_errors();
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$photo = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		
		$marksheet_ten = NULL;
		if(isset($_FILES['marksheet_ten']) and !empty($_FILES['marksheet_ten']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('marksheet_ten')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$marksheet_ten = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		
		$marksheet_inter = NULL;
		if(isset($_FILES['marksheet_inter']) and !empty($_FILES['marksheet_inter']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('marksheet_inter')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$marksheet_inter = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		$marksheet_batchelor = NULL;
		if(isset($_FILES['marksheet_batchelor']) and !empty($_FILES['marksheet_batchelor']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('marksheet_batchelor')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$marksheet_batchelor = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		$resume_upload = NULL;
		if(isset($_FILES['resume_upload']) and !empty($_FILES['resume_upload']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('resume_upload')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$resume_upload = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		
		$aadhar1 = NULL;
		if(isset($_FILES['aadhar1']) and !empty($_FILES['aadhar1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('aadhar1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$aadhar1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$pan1 = NULL;
		if(isset($_FILES['pan1']) and !empty($_FILES['pan1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('pan1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$pan1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$passport1 = NULL;
		if(isset($_FILES['passport1']) and !empty($_FILES['passport1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('passport1')){					
			$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$passport1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$dl1 = NULL;
		if(isset($_FILES['dl1']) and !empty($_FILES['dl1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('dl1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$dl1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$voter1 = NULL;
		if(isset($_FILES['voter1']) and !empty($_FILES['voter1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('voter1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$voter1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$p_verification_crtft = NULL;
		if(isset($_FILES['p_verification_crtft']) and !empty($_FILES['p_verification_crtft']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('p_verification_crtft')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$p_verification_crtft = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$bgc_report_crtft = NULL;
		if(isset($_FILES['bgc_report_crtft']) and !empty($_FILES['bgc_report_crtft']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('bgc_report_crtft')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$bgc_report_crtft = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$passbook = NULL;
		if(isset($_FILES['passbook']) and !empty($_FILES['passbook']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('passbook')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$passbook = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
				
		
		/*if($date_of_birth){
			//d/m/y
			$birthdate_ar = explode("/", $date_of_birth);
			$birthdate = $birthdate_ar[2]."-".$birthdate_ar[0]."-".$birthdate_ar[1];
		}
*/
			/*$man_id_qry = $this->db->query("SELECT id,manpower_id from tt_manpower WHERE 1=1 AND state_id='".$state_id."' order by id desc limit 1")->row();
			$last_manpower_id= $man_id_qry->manpower_id;
			$new_manpower_id=$last_manpower_id+1;*/
		
		$save_data = array(
			"mp_type" => $mp_type,
			"freelance_type" => $fl_type,
			"vendor_name" => $vendor_name,
			"client_name" => $client_name,
			"full_name" => $full_name,
			"contact_number" => $contact_number,
			"alternamt_contact_no"=> $alternamt_contact_no,
			"email" => $email,
			"date_of_birth" => $date_of_birth,
			"language" => $language,
			"gender" => $gender,
			"user_pic" => $photo,
			"address" => $address,
			"state" => $state_id,
			"city" => $city,
			"pincode" => $pincode, 
			"add_status" => $add_status,
			"permanent_address" => $permanent_address,
			"state_id_p" => $state_id_p,
			"city_p" => $city_p,
			"pincode_p" => $pincode_p,
			"ready_to_travel" => $ready_to_travel,
			"linkedin" => $linkedin,
			"twitter" => $twitter,
			"facebook" => $facebook,
			"instagram" => $instagram,
			"father_name" => $father_name,
			"father_contact_no" => $father_contact_no,
			"occupation" => $occupation,
			"matric" => $matric,
			"matric_school" => $matric_school,
			"matric_year" => $matric_year,
			"intermediate" => $intermediate,
			"intermediate_school" => $intermediate_school,
			"intermediate_year" => $intermediate_year,
			"bachelor" => $bachelor,
			"bachelor_st" => $bachelor_st,
			"university" => $university,
			"batchelor_sem" => $batchelor_sem,
			"bachelor_year" => $bachelor_year,
			"course" => $course,
			"subject" => $subject,
			"experience_online_exam" => $experience_online_exam,
			"work_mode" => $work_mode,
			"company" => $company,
			"designation" => $designation,
			"project" => $project,
			"experience" => $experience,
			"experience_other" => $experience_other,
			"other_designation" => $other_designation,
			"other_job" => $other_job,
			"other_exp" => $other_exp,
			"aadhar" => $aadhar,
			"pan" => $pan,
			"passport" => $passport,
			"driving" => $driving,
			"voter" => $voter,
			"p_verification" => $p_verification,
			"p_verification_dt" => $p_verification_dt,
			"bgc_report" => $bgc_report,
			"bgc_report_dt" => $bgc_report_dt,
			"benf_name" => $benf_name,
			"bank_account_number" => $bank_account_no,
			"bank_ifsc_code" => $bank_ifsc_code,
			"bank_name" => $bank_name,
			"created_by" => $this->session->userdata('login_user_id'),
			"created_on" => date('Y-m-d H:i:s')
		);	
		
		$result = $this->db->insert('tt_manpower',$save_data);
		$last_insert_id = $this->db->insert_id();
		$manpowerId=$last_insert_id;

		if($photo){
				$save_img1 = array(
					"user_pic" => $photo
				);	
				$this->db->where('id',$last_insert_id);
				$result0 = $this->db->update('tt_manpower',$save_img1);
		}
		
		if($marksheet_ten){
				$save_mksh = array(
					"marksheet_tenth" => $marksheet_ten
				);	
				$this->db->where('id',$last_insert_id);
				$result14 = $this->db->update('tt_manpower',$save_mksh);
		}
		
		if($marksheet_inter){
				$save_mksh_two = array(
					"marksheet_intermediate" => $marksheet_inter
				);	
				$this->db->where('id',$last_insert_id);
				$result15 = $this->db->update('tt_manpower',$save_mksh_two);
		}
		
		if($marksheet_batchelor){
				$save_mksh_bachlr = array(
					"marksheet_batchelor" => $marksheet_batchelor
				);	
				$this->db->where('id',$last_insert_id);
				$result18 = $this->db->update('tt_manpower',$save_mksh_bachlr);
		}
		
		if($resume_upload){
				$save_mksh_resume = array(
					"resume_upload" => $resume_upload
				);	
				$this->db->where('id',$last_insert_id);
				$result16 = $this->db->update('tt_manpower',$save_mksh_resume);
		} 
		
		if($aadhar1){
				$save_doc1 = array(
					"aadhar_pic" => $aadhar1
				);	
				$this->db->where('id',$last_insert_id);
				$result1 = $this->db->update('tt_manpower',$save_doc1);
		}
		
		if($pan1){
				$save_doc2 = array(
					"pan_pic" => $pan1
				);	
				$this->db->where('id',$last_insert_id);
				$result2 = $this->db->update('tt_manpower',$save_doc2);
		}
		
		if($passport1){
				$save_doc3 = array(
					"passport_pic" => $passport1
				);	
				$this->db->where('id',$last_insert_id);
				$resultd3 = $this->db->update('tt_manpower',$save_doc3);
		}
		if($dl1){
				$save_doc4 = array(
					"driving_lic_pic" => $dl1
				);	
				$this->db->where('id',$last_insert_id);
				$resultd4 = $this->db->update('tt_manpower',$save_doc4);
		}
		
		if($voter1){
				$save_doc5 = array(
					"votor_card_pic" => $voter1
				);	
				$this->db->where('id',$last_insert_id);
				$resultd5 = $this->db->update('tt_manpower',$save_doc5);
		}
		
		if($p_verification_crtft){
				$save_doc6 = array(
					"police_verf_pic" => $p_verification_crtft
				);	
				$this->db->where('id',$last_insert_id);
				$resultd6 = $this->db->update('tt_manpower',$save_doc6);
		}

		if($bgc_report_crtft){
				$save_doc7 = array(
					"bgc_report_image" => $bgc_report_crtft
				);	
				$this->db->where('id',$last_insert_id);
				$resultd7 = $this->db->update('tt_manpower',$save_doc7);
		}
		
		if($passbook){
				$save_doc8 = array(
					"bank_pbk_image" => $passbook
				);	
				$this->db->where('id',$last_insert_id);
				$resultd8 = $this->db->update('tt_manpower',$save_doc8);
		}
		
		if($result){
			$redirect_url = base_url()."index.php?admin/manpower";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
		function edit_manpower($id = NULL){			
		/*if(!hasPageAuthorize('edit_manpower')){
			redirect(base_url(), 'refresh');exit;
		} */

		'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$mp_details = $this->db->query("SELECT * FROM tt_manpower where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$mp_details){
			redirect(base_url(), 'refresh');exit;
		}
		

		$data['mp_details'] = $mp_details;
		$data['page_name']  = 'edit_manpower';
		$data['page_title'] = "Edit Manpower Information";
		$this->load->view('backend/index', $data);
	}
	
	
	
function edit_manpower_process___old(){
	
	/*echo "<pre>";
		print_r($_POST);exit;*/
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('edit_manpower')){
			$ar = array("status" => "fail", "error" => "You do not have permission to edit", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
				
		$edit_user_id  = $this->session->userdata('edit_user_id');
		if(empty($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		if(!is_numeric($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		
		$full_name = str_replace("'","&#8217;",trim($this->input->post('full_name')));
		$country_code = trim($this->input->post('country_code'));
		$contact_number = trim($this->input->post('contact_number'));
		$alt_country_code = trim($this->input->post('alt_country_code'));
		$alternamt_contact_no = trim($this->input->post('alternamt_contact_no'));
		$email = trim($this->input->post('email'));
		$birthdate = trim($this->input->post('date_of_birth'));
				
		$father_name = str_replace("'","&#8217;",trim($this->input->post('father_name')));
		$f_couuntry_code = trim($this->input->post('f_couuntry_code'));
		$father_contact_no = trim($this->input->post('father_contact_no'));
		$qualification = str_replace("'","&#8217;",trim($this->input->post('qualification')));

		$experience_online_exam = trim($this->input->post('experience_online_exam'));
		if($experience_online_exam=='yes')
		{
			$exp_exam_name = trim($this->input->post('exp_exam_name'));
		}
		else
		{
			$exp_exam_name = '';
		}
	
		$govt_id_type = str_replace("'","&#8217;",trim($this->input->post('govt_id_type')));
		$govt_id_no = str_replace("'","&#8217;",trim($this->input->post('govt_id_no')));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$address_second = str_replace("'","&#8217;",trim($this->input->post('address_second')));
		$state_id = trim($this->input->post('state_id'));
		$city = trim($this->input->post('city'));
		$pincode = trim($this->input->post('pincode'));
		$today_date=date('Y-m-d H:i:s');
		
		if(empty($full_name)){
			$ar = array("status" => "fail", "error" => "Please enter name.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($contact_number)){
			$ar = array("status" => "fail", "error" => "Please enter contact number.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
		
			$check_qry = $this->db->query("select * from  tt_manpower where 1=1 and id<>'".$edit_user_id."' and email='".$email."'");
			if($check_qry->num_rows()>0){
				$ar = array("status" => "fail", "error" => "User email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
			
		if($birthdate){
			//d/m/y
			$birthdate_ar = explode("/", $birthdate);
			$date_of_birth = $birthdate_ar[2]."-".$birthdate_ar[0]."-".$birthdate_ar[1];
		}	
	
		$save_data = array(
			"full_name" => $full_name,
			"country_code" => $country_code,
			"contact_number" => $contact_number,
			"alt_country_code" => $alt_country_code,
			"alternamt_contact_no"=> $alternamt_contact_no,
			"email" => $email,
			"date_of_birth" => $date_of_birth,
			"father_name" => $father_name,
			"f_couuntry_code" => trim($f_couuntry_code),
			"father_contact_no" => trim($father_contact_no),			
			"qualification" => trim($qualification),
			"experience_online_exam" => trim($experience_online_exam),
			"exp_exam_name" => trim($exp_exam_name),
			"govt_id_type" => trim($govt_id_type),
			"govt_id_no" => trim($govt_id_no),
			"address" => trim($address),
			"address_second" => trim($address_second),
			"state" => trim($state_id),
			"city" => trim($city),
			"pincode" => $pincode,
			"modified_by" => $this->session->userdata('login_user_id'),
			"update_on" => date('Y-m-d H:i:s')
		);	
		
		$this->db->where('id',$edit_user_id);
        $result = $this->db->update('tt_manpower',$save_data);
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			$redirect_url = base_url()."index.php?admin/manage_manpower";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	
	
	}
	
	
	
	function edit_manpower_process(){
	
		/*echo "<pre>";
		print_r($_POST);exit;*/
		$edit_user_id  = $this->session->userdata('edit_user_id');
		if(empty($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		if(!is_numeric($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		$mp_type = trim($this->input->post('mp_type'));
		$fl_type = trim($this->input->post('fl_type'));
		if($mp_type==1){
			$fl_type=='';		
		}
		$vendor_name = str_replace("'","&#8217;",trim($this->input->post('vendor_name')));
		$client_name = str_replace("'","&#8217;",trim($this->input->post('client_name')));
		$full_name = str_replace("'","&#8217;",trim($this->input->post('full_name')));
		$contact_number = trim($this->input->post('contact_number'));
		$alternamt_contact_no = trim($this->input->post('alternamt_contact_no'));
		$email = trim($this->input->post('email'));
		$date_of_birth_m = trim($this->input->post('date_of_birth'));
		$date_of_birth_mn = explode("/", $date_of_birth_m);
		$date_of_birth = $date_of_birth_mn[2]."-".$date_of_birth_mn[1]."-".$date_of_birth_mn[0];
		$language = str_replace("'","&#8217;",trim($this->input->post('language')));
		$gender = trim($this->input->post('gender'));
		$address = str_replace("'","&#8217;",trim($this->input->post('address')));
		$state_id = trim($this->input->post('state_id'));
		$city = trim($this->input->post('city'));
		$pincode = trim($this->input->post('pincode'));
		$add_status = trim($this->input->post('add_status'));
		$deleted = trim($this->input->post('deleted'));
		
		if($add_status=='yes'){
			$address = str_replace("'","&#8217;",trim($this->input->post('address')));
			$state_id = trim($this->input->post('state_id'));
			$city = $this->input->post('city');
			$pincode = trim($this->input->post('pincode'));
		}
		if($add_status=='no'){
			$permanent_address = str_replace("'","&#8217;",trim($this->input->post('permanent_address')));
			$state_id_p = $this->input->post('state_id_p');
			$city_p = $this->input->post('city_p');
			$pincode_p = trim($this->input->post('pincode_p'));
		}
		
		$ready_to_travel = $this->input->post('ready_to_travel');
		$linkedin = str_replace("'","&#8217;",trim($this->input->post('linkedin')));
		$twitter = str_replace("'","&#8217;",trim($this->input->post('twitter')));
		$facebook = str_replace("'","&#8217;",trim($this->input->post('facebook')));
		$instagram = str_replace("'","&#8217;",trim($this->input->post('instagram')));
		$father_name = str_replace("'","&#8217;",trim($this->input->post('father_name')));
		$father_contact_no = trim($this->input->post('father_contact_no'));
		$occupation = str_replace("'","&#8217;",trim($this->input->post('occupation')));
		$matric = str_replace("'","&#8217;",trim($this->input->post('matric')));
		$matric_school = str_replace("'","&#8217;",trim($this->input->post('matric_school')));
		$matric_year = trim($this->input->post('matric_year'));
		$intermediate = str_replace("'","&#8217;",trim($this->input->post('intermediate')));
		$intermediate_school = str_replace("'","&#8217;",trim($this->input->post('intermediate_school')));
		$intermediate_year = trim($this->input->post('intermediate_year'));
		$bachelor = trim($this->input->post('bachelor'));
		$bachelor_st = trim($this->input->post('bachelor_st'));
		$university = str_replace("'","&#8217;",trim($this->input->post('university')));
		$batchelor_sem = trim($this->input->post('batchelor_sem'));
		if($bachelor_st=='2'){
			$bachelor_year = trim($this->input->post('bachelor_year'));		
		} else {
			$bachelor_year ='';
		}
		$course = str_replace("'","&#8217;",trim($this->input->post('course')));
		$subject = str_replace("'","&#8217;",trim($this->input->post('subject')));
		
		
		$experience_online_exam = $this->input->post('experience_online_exam');
		if($experience_online_exam=='yes')
		{
			$work_mode = trim($this->input->post('work_mode'));
			if($work_mode=='online')
			{
				$company = trim($this->input->post('company'));
				$designation = trim($this->input->post('designation'));
				$project = trim($this->input->post('project'));
				$experience = trim($this->input->post('experience'));
			}
			if($work_mode=='offline')
			{
				$company = trim($this->input->post('company'));
				$designation = trim($this->input->post('designation'));
				$project = trim($this->input->post('project'));
				$experience = trim($this->input->post('experience'));
			}
		}
		
		if($experience_online_exam=='any_others')
		{
			$work_mode = '';
			$experience_other = trim($this->input->post('experience_other'));
			$other_designation = trim($this->input->post('other_designation'));
			$other_job = trim($this->input->post('other_job'));
			$other_exp = trim($this->input->post('other_exp'));
		}
		
		
		
		$aadhar = str_replace("'","&#8217;",trim($this->input->post('aadhar')));
		$pan = str_replace("'","&#8217;",trim($this->input->post('pan')));
		$passport = str_replace("'","&#8217;",trim($this->input->post('passport')));
		$driving = str_replace("'","&#8217;",trim($this->input->post('driving')));
		$voter = str_replace("'","&#8217;",trim($this->input->post('voter')));
		$p_verification = str_replace("'","&#8217;",trim($this->input->post('p_verification')));
		$p_verification_dt = trim($this->input->post('p_verification_dt'));
		if($p_verification_dt){
			//d/m/y
			$date_arm = explode("/", $p_verification_dt);
			$p_verification_dte = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}
		$bgc_report = str_replace("'","&#8217;",trim($this->input->post('bgc_report')));
		$bgc_report_dt = trim($this->input->post('bgc_report_dt'));
		if($bgc_report_dt){
			//d/m/y
			$date_arm = explode("/", $bgc_report_dt);
			$bgc_report_dte = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}
		
		$benf_name = str_replace("'","&#8217;",trim($this->input->post('benf_name')));
		$bank_account_no = str_replace("'","&#8217;",trim($this->input->post('bank_account_no')));
		$bank_ifsc_code = str_replace("'","&#8217;",trim($this->input->post('bank_ifsc_code')));
		$bank_name = str_replace("'","&#8217;",trim($this->input->post('bank_name')));

		$today_date=date('Y-m-d H:i:s');
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_manpower')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new Manpower entry", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */

		if(empty($mp_type)){
			$ar = array("status" => "fail", "error" => "Manpower Category is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($mp_type==2 && $fl_type=='')
		{
				$ar = array("status" => "fail", "error" => "Manpower Freelance Category  is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;	
		}
			

	
		if(empty($full_name)){
			$ar = array("status" => "fail", "error" => "Manpower Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
			if(empty($contact_number)){
				$ar = array("status" => "fail", "error" => "Mobile Number is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
			
			if(empty($email)){
				$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
		$check_qry = $this->db->query("select id from tt_manpower where 1=1 and id<>'".$edit_user_id."' and email='".$email."' and email!=''");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$upload_dir = 'uploads/manpower_image/';
		$upload_dir_doc = 'uploads/manpower_document/';

		$photo = NULL;
		if(isset($_FILES['photo']) and !empty($_FILES['photo']['name'])){	
			$original = $upload_dir;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('photo')){	
							//echo $this->image_lib->display_errors();
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Save");				
				echo json_encode($ar);
				exit;
				
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$photo = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		$marksheet_ten = NULL;
		if(isset($_FILES['marksheet_ten']) and !empty($_FILES['marksheet_ten']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('marksheet_ten')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$marksheet_ten = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		
		$marksheet_inter = NULL;
		if(isset($_FILES['marksheet_inter']) and !empty($_FILES['marksheet_inter']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('marksheet_inter')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$marksheet_inter = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		
		
		$resume_upload = NULL;
		if(isset($_FILES['resume_upload']) and !empty($_FILES['resume_upload']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('resume_upload')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$resume_upload = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		
		$marksheet_batchelor = NULL;
		if(isset($_FILES['marksheet_batchelor']) and !empty($_FILES['marksheet_batchelor']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('marksheet_batchelor')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$marksheet_batchelor = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		
		$aadhar1 = NULL;
		if(isset($_FILES['aadhar1']) and !empty($_FILES['aadhar1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('aadhar1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$aadhar1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$pan1 = NULL;
		if(isset($_FILES['pan1']) and !empty($_FILES['pan1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('pan1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$pan1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$passport1 = NULL;
		if(isset($_FILES['passport1']) and !empty($_FILES['passport1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('passport1')){					
			$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$passport1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$dl1 = NULL;
		if(isset($_FILES['dl1']) and !empty($_FILES['dl1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('dl1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$dl1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$voter1 = NULL;
		if(isset($_FILES['voter1']) and !empty($_FILES['voter1']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('voter1')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$voter1 = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$p_verification_crtft = NULL;
		if(isset($_FILES['p_verification_crtft']) and !empty($_FILES['p_verification_crtft']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('p_verification_crtft')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$p_verification_crtft = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$bgc_report_crtft = NULL;
		if(isset($_FILES['bgc_report_crtft']) and !empty($_FILES['bgc_report_crtft']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('bgc_report_crtft')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$bgc_report_crtft = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
		$passbook = NULL;
		if(isset($_FILES['passbook']) and !empty($_FILES['passbook']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg|doc|pdf|txt|docx';
			$configsd['max_size']             = 4096;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('passbook')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$passbook = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
				
		
		/*if($date_of_birth){
			//d/m/y
			$birthdate_ar = explode("/", $date_of_birth);
			$birthdate = $birthdate_ar[2]."-".$birthdate_ar[0]."-".$birthdate_ar[1];
		}
*/
			/*$man_id_qry = $this->db->query("SELECT id,manpower_id from tt_manpower WHERE 1=1 AND state_id='".$state_id."' order by id desc limit 1")->row();
			$last_manpower_id= $man_id_qry->manpower_id;
			$new_manpower_id=$last_manpower_id+1;*/
		
		$save_data = array(
			"mp_type" => $mp_type,
			"freelance_type" => $fl_type,
			"vendor_name" => $vendor_name,
			"client_name" => $client_name,
			"full_name" => $full_name,
			"contact_number" => $contact_number,
			"alternamt_contact_no"=> $alternamt_contact_no,
			"email" => $email,
			"date_of_birth" => $date_of_birth,
			"language" => $language,
			"gender" => $gender,
			"address" => $address,
			"state" => $state_id,
			"city" => $city,
			"pincode" => $pincode, 
			"add_status" => $add_status,
			"permanent_address" => $permanent_address,
			"state_id_p" => $state_id_p,
			"city_p" => $city_p,
			"pincode_p" => $pincode_p,
			"ready_to_travel" => $ready_to_travel,
			"linkedin" => $linkedin,
			"twitter" => $twitter,
			"facebook" => $facebook,
			"instagram" => $instagram,
			"father_name" => $father_name,
			"father_contact_no" => $father_contact_no,
			"occupation" => $occupation,
			"matric" => $matric,
			"matric_school" => $matric_school,
			"matric_year" => $matric_year,
			"intermediate" => $intermediate,
			"intermediate_school" => $intermediate_school,
			"intermediate_year" => $intermediate_year,
			"bachelor" => $bachelor,
			"bachelor_st" => $bachelor_st,
			"university" => $university,
			"batchelor_sem" => $batchelor_sem,
			"bachelor_year" => $bachelor_year,
			"course" => $course,
			"subject" => $subject,
			"experience_online_exam" => $experience_online_exam,
			"work_mode" => $work_mode,
			"company" => $company,
			"designation" => $designation,
			"project" => $project,
			"experience" => $experience,
			"experience_other" => $experience_other,
			"other_designation" => $other_designation,
			"other_job" => $other_job,
			"other_exp" => $other_exp,
			"aadhar" => $aadhar,
			"pan" => $pan,
			"passport" => $passport,
			"driving" => $driving,
			"voter" => $voter,
			"p_verification" => $p_verification,
			"p_verification_dt" => $p_verification_dte,
			"bgc_report" => $bgc_report,
			"bgc_report_dt" => $bgc_report_dte,
			"benf_name" => $benf_name,
			"bank_account_number" => $bank_account_no,
			"bank_ifsc_code" => $bank_ifsc_code,
			"bank_name" => $bank_name,
			"modified_by" => $edit_user_id,
			"update_on" => date('Y-m-d H:i:s'),
			"deleted" => $deleted
		);	
		
		$this->db->where('id',$edit_user_id);
        $result = $this->db->update('tt_manpower',$save_data);

		if($photo){
				$save_img1 = array(
					"user_pic" => $photo
				);	
				$this->db->where('id',$edit_user_id);
				$result0 = $this->db->update('tt_manpower',$save_img1);
		}
		
		if($marksheet_ten){
				$save_mksh = array(
					"marksheet_tenth" => $marksheet_ten
				);	
				$this->db->where('id',$edit_user_id);
				$result14 = $this->db->update('tt_manpower',$save_mksh);
		}
		
		if($marksheet_inter){
				$save_mksh_two = array(
					"marksheet_intermediate" => $marksheet_inter
				);	
				$this->db->where('id',$edit_user_id);
				$result15 = $this->db->update('tt_manpower',$save_mksh_two);
		}
		
		if($resume_upload){
				$save_mksh_resume = array(
					"resume_upload" => $resume_upload
				);	
				$this->db->where('id',$edit_user_id);
				$result16 = $this->db->update('tt_manpower',$save_mksh_resume);
		} 
		
		if($marksheet_batchelor){
				$save_mksh_bachlr = array(
					"marksheet_batchelor" => $marksheet_batchelor
				);	
				$this->db->where('id',$edit_user_id);
				$result18 = $this->db->update('tt_manpower',$save_mksh_bachlr);
		}
		
		if($aadhar1){
				$save_doc1 = array(
					"aadhar_pic" => $aadhar1
				);	
				$this->db->where('id',$edit_user_id);
				$result1 = $this->db->update('tt_manpower',$save_doc1);
		}
		
		if($pan1){
				$save_doc2 = array(
					"pan_pic" => $pan1
				);	
				$this->db->where('id',$edit_user_id);
				$result2 = $this->db->update('tt_manpower',$save_doc2);
		}
		
		if($passport1){
				$save_doc3 = array(
					"passport_pic" => $passport1
				);	
				$this->db->where('id',$edit_user_id);
				$resultd3 = $this->db->update('tt_manpower',$save_doc3);
		}
		if($dl1){
				$save_doc4 = array(
					"driving_lic_pic" => $dl1
				);	
				$this->db->where('id',$edit_user_id);
				$resultd4 = $this->db->update('tt_manpower',$save_doc4);
		}
		
		if($voter1){
				$save_doc5 = array(
					"votor_card_pic" => $voter1
				);	
				$this->db->where('id',$edit_user_id);
				$resultd5 = $this->db->update('tt_manpower',$save_doc5);
		}
		
		if($p_verification_crtft){
				$save_doc6 = array(
					"police_verf_pic" => $p_verification_crtft
				);	
				$this->db->where('id',$edit_user_id);
				$resultd6 = $this->db->update('tt_manpower',$save_doc6);
		}

		if($bgc_report_crtft){
				$save_doc7 = array(
					"bgc_report_image" => $bgc_report_crtft
				);	
				$this->db->where('id',$edit_user_id);
				$resultd7 = $this->db->update('tt_manpower',$save_doc7);
		}
		
		if($passbook){
				$save_doc8 = array(
					"bank_pbk_image" => $passbook
				);	
				$this->db->where('id',$edit_user_id);
				$resultd8 = $this->db->update('tt_manpower',$save_doc8);
		}
		
		if($result){
			$redirect_url = base_url()."index.php?admin/manpower";
			$this->session->set_flashdata('message' , "Data modified successfully");
			$ar = array("status" => "pass", "error" => "Data modified successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function view_manpower($id = NULL){			
		/*if(!hasPageAuthorize('edit_manpower')){
			redirect(base_url(), 'refresh');exit;
		} */

		'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$mp_details = $this->db->query("SELECT * FROM tt_manpower where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$mp_details){
			redirect(base_url(), 'refresh');exit;
		}
		

		$data['mp_details'] = $mp_details;
		$data['page_name']  = 'view_manpower';
		$data['page_title'] = "View Manpower Information";
		$this->load->view('backend/index', $data);
	}
	
/*	function add_project_process(){
	
		$client_id = trim($this->input->post('client_id')); 
		
		$exam_name =  trim($this->input->post('exam_name'));
		$ready_date = $_POST['ready_date'];  
		
		
		$mock_test_date = $_POST['mock_test_date']; 
		
		$type_of_exam = $_POST['type_of_exam'];   
		if($type_of_exam=='government')
		{
			$exam_type = $_POST['exam_type']; 
		}
		else
		{
			$exam_type = $_POST['exam_type_p'];  
		}
		$batchTime = trim($this->input->post('batchTime'));
		$batch_time_1 = trim($this->input->post('batch_time_1'));
		$batch_time_2 = trim($this->input->post('batch_time_2'));
		$batch_time_3 = trim($this->input->post('batch_time_3'));
		$batch_time_4 = trim($this->input->post('batch_time_4'));
		$batch_time_5 = trim($this->input->post('batch_time_5'));
		
		$city_name = $_POST['city_name'];
		$all_city = implode (", ", $city_name);
		
		$cityall=explode(",",$all_city);
		foreach($cityall as $eachCity)
		{
			$ctg.=trim(get_city_name($eachCity)).',';
		}
		$city_name_txt=substr($ctg,0,-1);
		
		$no_of_seat = $_POST['no_of_seat'];
		$total_seat = implode (", ", $no_of_seat);
		$no_of_batch = $_POST['no_of_batch'];
		$total_batch = implode (", ", $no_of_batch);
		$no_of_days = $_POST['no_of_days'];
		$total_days = implode (", ", $no_of_days);
		$start_date = $_POST['start_date'];
		$total_start_days = implode (", ", $start_date);
		$end_date = $_POST['end_date'];
		$total_end_days = implode (", ", $end_date);
		
		$commercial_value = trim($this->input->post('commercial_value'));
		$commrcl_by_per = trim($this->input->post('commrcl_by_per'));
		
		$operating_system = trim($this->input->post('operating_system'));
		$ram_size = trim($this->input->post('ram_size'));
		$processor_type = trim($this->input->post('processor_type'));
		$display_resolution = trim($this->input->post('display_resolution'));
		
		
		$exam_mode = $_POST['exam_mode'];
		if($exam_mode=='internet')
		{
			$internet_speed = trim($this->input->post('internet_speed'));
			$server_ratio_1 = '';
			$server_ratio_2 = '';
			$server_operating_system = '';
			$server_processor_type = '';
			$server_ram_size ='';
		}
		else
		{
			$internet_speed='';
			$server_ratio_1 = trim($this->input->post('server_ratio_1'));
			$server_ratio_2 = trim($this->input->post('server_ratio_2'));
			$exam_mode_server_ratio=$server_ratio_1.':'.$server_ratio_2;
			$server_operating_system = trim($this->input->post('server_operating_system'));
			$server_processor_type = trim($this->input->post('server_processor_type'));
			$server_ram_size = trim($this->input->post('server_ram_size'));
		}
		
		$cctv_req = trim($this->input->post('cctv_req'));
		if($cctv_req=='yes')
		{
			$cctvfootage = trim($this->input->post('cctvfootage'));
		}
		else
		{
			$cctvfootage='no';
		}
		$lab_partitation = trim($this->input->post('lab_partitation'));
		$printer_status = trim($this->input->post('printer_status'));
		$rough_sheet = trim($this->input->post('rough_sheet'));
		$exam_co_ordinator = trim($this->input->post('exam_co_ordinator'));
		$waiting_area = trim($this->input->post('waiting_area'));
		$parking_facility = trim($this->input->post('parking_facility'));
		$security_guard = trim($this->input->post('security_guard'));
		$seperate_restroom = trim($this->input->post('seperate_restroom'));
		
		$center_superintendent_1 = trim($this->input->post('center_superintendent_1'));
		$center_superintendent_2 = trim($this->input->post('center_superintendent_2'));
		$center_superintendent_ratio=$center_superintendent_1.':'.$center_superintendent_2;
		
		$technical_person_1 = trim($this->input->post('technical_person_1'));
		$technical_person_2 = trim($this->input->post('technical_person_2'));
		$technical_person_ratio=$technical_person_1.':'.$technical_person_2;
		
		$invigilator_ratio_1 = trim($this->input->post('invigilator_ratio_1'));
		$invigilator_ratio_2 = trim($this->input->post('invigilator_ratio_2'));
		$invigilator_ratio=$invigilator_ratio_1.':'.$invigilator_ratio_2;
		
		$sucurity_guard_ratio_1 = trim($this->input->post('sucurity_guard_ratio_1'));
		$sucurity_guard_ratio_2 = trim($this->input->post('sucurity_guard_ratio_2'));
		$sucurity_guard_ratio=$sucurity_guard_ratio_1.':'.$sucurity_guard_ratio_2;
		
		$today_date=date('Y-m-d H:i:s');
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(!hasPageAuthorize('add_manpower')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new entry", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
				
		if(empty($client_id)){
			$ar = array("status" => "fail", "error" => "Client required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
	
		if(empty($client_id)){
			$ar = array("status" => "fail", "error" => "Client required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}

if($ready_date){
			//d/m/y
			$date_ar = explode("/", $ready_date);
			$readydate = $date_ar[2]."-".$date_ar[1]."-".$date_ar[0];
		}
		if($mock_test_date){
			//d/m/y
			$date_arm = explode("/", $mock_test_date);
			$mocktestdate = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}

$save_data = array(
			"client_name" => $client_id,
			"exam_name" => $exam_name,
			"readiness_date"=> $readydate,
			"mock_test_date" => $mocktestdate,
			"type_of_exam" => $type_of_exam,
			"exam_type" => $exam_type,
			"exam_batch_time" => $batchTime,			
			"batch_1" => $batch_time_1,
			"batch_2" => $batch_time_2,
			"batch_3" => $batch_time_3,
			"batch_4" => $batch_time_4,
			"batch_5" => $batch_time_5,
			"exam_city" => $all_city,
			"exam_city_name" => $city_name_txt,
			"booking_seat_count" => $total_seat,
			"no_of_batch" => $total_batch,
			"no_of_days" => $total_days,
			"star_date" => $total_start_days,
			"end_state" => $total_end_days,
			"commercial" => $commercial_value,
			"commercial_per" => $commrcl_by_per,
			"operating_system" => $operating_system,
			"system_ram" => $ram_size,
			"system_processor" => $processor_type,
			"monitor_resolution" => $display_resolution,
			"exam_mode" => $exam_mode,
			"speed_of_internet" => $internet_speed,
			"ratio_of_server" => $exam_mode_server_ratio,
			"server_operating_system" => $server_operating_system,
			"server_processor" => $server_processor_type,
			"server_ram" => $server_ram_size,
			"cctv_required" => $cctv_req,
			"cctv_footage" => $cctvfootage,
			"partitation_of_lab" => $lab_partitation,
			"printer" => $printer_status,
			"rough_sheet" => $rough_sheet,
			"exam_co_ordinator" => $exam_co_ordinator,
			"waiting_area" => $waiting_area,
			"parking_facility" => $parking_facility,
			"security_guard" => $security_guard,
			"seperate_restroom" => $seperate_restroom,
			"center_supertendient_ratio" => $center_superintendent_ratio,
			"technical_person_ratio" => $technical_person_ratio,
			"invigilator_ratio" => $invigilator_ratio,
			"security_guard_ratio" => $sucurity_guard_ratio,
			"created_by" => $this->session->userdata('login_user_id'),
			"created_on" => date('Y-m-d H:i:s')
		);	
		$result = $this->db->insert('tt_project_master',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/manage_booking_search/$last_insert_id";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
			
	exit;
	echo "<pre>";
		print_r($_POST);exit;
	}*/
	
	function add_project_process_______old5oct19(){
		
			echo "<pre>";
		print_r($_POST);exit;

	    $rdno=rand(10,1000);
	    $project_group_id = strtotime(date('Y-m-d H:i:s')).''.$rdno; 
		$client_id = trim($this->input->post('client_id'));
		$exam_name = trim($this->input->post('exam_name'));
		$ready_date = $_POST['ready_date'];  
		$mock_test_date = $_POST['mock_test_date']; 
		
		$type_of_exam = $_POST['type_of_exam'];   
		if($type_of_exam=='government')
		{
			$exam_type = $_POST['exam_type']; 
		}
		else
		{
			$exam_type = $_POST['exam_type_p'];  
		}
		$batchTime = trim($this->input->post('batchTime'));
		$batch_time_1 = trim($this->input->post('batch_time_1'));
		$batch_time_2 = trim($this->input->post('batch_time_2'));
		$batch_time_3 = trim($this->input->post('batch_time_3'));
		$batch_time_4 = trim($this->input->post('batch_time_4'));
		$batch_time_5 = trim($this->input->post('batch_time_5'));
	
		$city_name_d = $_POST['city_name'];
		//echo '<br>AB='.$cityCount=count($city_name );
		//print_r($city_name);
		//exit;
	//	$exam_city_Name = str_replace("_"," ",trim($city_name[$k]));
	//	$exam_city_id=get_city_ids($exam_city_Name);
		foreach($city_name_d as $ctname)
		{
			$exam_city_Name=$ctname;
			$cityname = str_replace("_"," ",$exam_city_Name);
			
			$ct_qry = $this->db->query("SELECT city_id FROM tt_city_master WHERE 1=1 AND city_name='".trim($cityname)."'")->row();
			$city_ida=$ct_qry->city_id;
			//echo '<br>qrs='.$dd="SELECT city_id FROM tt_city_master WHERE 1=1 AND city_name='".trim($cityname)."'";
			//echo '<br>sdsuu='.$cityIds = get_city_ids($cityname);
				$new_ct.=$city_ida.',';
		}
		$vertAdv=substr($new_ct,0,-1);
		$city_name=explode(',',$vertAdv);
		//print_r($city_names);
		$cityCount=count($city_name);
		//exit;
		
		$no_of_seat = $_POST['no_of_seat'];
		$no_of_batch = $_POST['no_of_batch'];
		$no_of_days = $_POST['no_of_days'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		
		$commercial_value = trim($this->input->post('commercial_value'));
		$commrcl_by_per = trim($this->input->post('commrcl_by_per'));
		
		$operating_system = trim($this->input->post('operating_system'));
		$ram_size = trim($this->input->post('ram_size'));
		$processor_type = trim($this->input->post('processor_type'));
		$display_resolution = trim($this->input->post('display_resolution'));
		
		
		$exam_mode = $_POST['exam_mode'];
		if($exam_mode=='internet')
		{
			$internet_speed = trim($this->input->post('internet_speed'));
			$server_ratio_1 = '';
			$server_ratio_2 = '';
			$server_operating_system = '';
			$server_processor_type = '';
			$server_ram_size ='';
		}
		else
		{
			$internet_speed='';
			$server_ratio_1 = trim($this->input->post('server_ratio_1'));
			$server_ratio_2 = trim($this->input->post('server_ratio_2'));
			$exam_mode_server_ratio=$server_ratio_1.':'.$server_ratio_2;
			$server_operating_system = trim($this->input->post('server_operating_system'));
			$server_processor_type = trim($this->input->post('server_processor_type'));
			$server_ram_size = trim($this->input->post('server_ram_size'));
		}
		
		$cctv_req = trim($this->input->post('cctv_req'));
		if($cctv_req=='yes')
		{
			$cctvfootage = trim($this->input->post('cctvfootage'));
		}
		else
		{
			$cctvfootage='no';
		}
		$lab_partitation = trim($this->input->post('lab_partitation'));
		$phydical_handicapped = trim($this->input->post('phydical_handicapped'));
		$printer_status = trim($this->input->post('printer_status'));
		$rough_sheet = trim($this->input->post('rough_sheet'));
		$exam_co_ordinator = trim($this->input->post('exam_co_ordinator'));
		$waiting_area = trim($this->input->post('waiting_area'));
		$parking_facility = trim($this->input->post('parking_facility'));
		$security_guard = trim($this->input->post('security_guard'));
		$seperate_restroom = trim($this->input->post('seperate_restroom'));
		$lab_ac = trim($this->input->post('lab_ac'));
		
		$center_superintendent1 = trim($this->input->post('center_superintendent_1'));
		$center_superintendent2 = trim($this->input->post('center_superintendent_2'));
		$center_superintendent_ratio= $center_superintendent1.':'.$center_superintendent2;
		
		$technical_person1 = trim($this->input->post('technical_person_1'));
		$technical_person2 = trim($this->input->post('technical_person_2'));
		$technical_person_ratio=$technical_person1.':'.$technical_person2;
		
		$invigilator_ratio1 = trim($this->input->post('invigilator_ratio_1'));
		$invigilator_ratio2 = trim($this->input->post('invigilator_ratio_2'));
		$invigilator_ratio=$invigilator_ratio1.':'.$invigilator_ratio2;
		
		$sucurity_guard_ratio1 = trim($this->input->post('sucurity_guard_ratio_1'));
		$sucurity_guard_ratio2 = trim($this->input->post('sucurity_guard_ratio_2'));
		$sucurity_guard_ratio=$sucurity_guard_ratio1.':'.$sucurity_guard_ratio2;
		
		$today_date=date('Y-m-d H:i:s');
		
		
		$cl_qry = $this->db->query("SELECT company_name FROM tt_client WHERE 1=1 AND id='".$client_id."'")->row();
		$client_name=$cl_qry->company_name;
		
		
				
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_manpower')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new entry", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
				
		if(empty($client_id)){
			$ar = array("status" => "fail", "error" => "Client required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
	
		if(empty($client_id)){
			$ar = array("status" => "fail", "error" => "Client required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}

if($ready_date){
			//d/m/y
			$date_ar = explode("/", $ready_date);
			$readydate = $date_ar[2]."-".$date_ar[1]."-".$date_ar[0];
		}
		if($mock_test_date){
			//d/m/y
			$date_arm = explode("/", $mock_test_date);
			$mocktestdate = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}

for ($k = 0 ; $k < $cityCount; $k++)
		{
			if($city_name[$k])
			{		
			
				if($commrcl_by_per=='System')
				{
					$amount=$commercial_value*$no_of_days[$k]*$no_of_seat[$k];
					$gstamt=$amount*18/100;
					$totalAmount=$amount+$gstamt;
				}
				if($commrcl_by_per=='Candidate')
				{
					$amount=$commercial_value*$no_of_days[$k]*$no_of_seat[$k]*$no_of_batch[$k];
					$gstamt=$amount*18/100;
					$totalAmount=$amount+$gstamt;
				}
								
$save_data = array(
			"project_group_id" => $project_group_id,
			"client_id" => $client_id,
			"client_name" => $client_name,
			"exam_name" => str_replace("'","&#8217;",trim($exam_name)),
			"readiness_date"=> $readydate,
			"mock_test_date" => $mocktestdate,
			"total_exam_batch" => $batchTime,			
			"batch_1" => str_replace("'","&#8217;",trim($batch_time_1)),
			"batch_2" => str_replace("'","&#8217;",trim($batch_time_2)),
			"batch_3" => str_replace("'","&#8217;",trim($batch_time_3)),
			"batch_4" => str_replace("'","&#8217;",trim($batch_time_4)),
			"batch_5" => str_replace("'","&#8217;",trim($batch_time_5)),
			"type_of_exam" => $type_of_exam,
			"exam_type" => $exam_type,
			"exam_city_id" => $city_name[$k],
			"exam_city" => get_city_name($city_name[$k]),
			"number_of_seat" => str_replace("'","&#8217;",trim($no_of_seat[$k])),
			"number_of_batch" => str_replace("'","&#8217;",trim($no_of_batch[$k])),
			"number_of_day" => str_replace("'","&#8217;",trim($no_of_days[$k])),
			"exam_start_date" => $start_date[$k],
			"exam_end_date" => $end_date[$k],
			"commerical" => str_replace("'","&#8217;",trim($commercial_value)),
			"gst_percent" => 18,
			"gst_amount" => $gstamt,
			"total_cost" => $amount,
			"total_payable_amount" => $totalAmount,
			"commerical_per" => $commrcl_by_per,
			"operating_system" => $operating_system,
			"system_ram" => $ram_size,
			"system_processor" => $processor_type,
			"monitor_resolution" => $display_resolution,
			"exam_mode" => $exam_mode,
			"speed_of_internet" => $internet_speed,
			"ratio_of_server" => $exam_mode_server_ratio,
			"server_operating_system" => $server_operating_system,
			"server_processor" => $server_processor_type,
			"server_ram" => $server_ram_size,
			"cctv_required" => $cctv_req,
			"cctv_footage" => $cctvfootage,
			"partitation_of_lab" => $lab_partitation,
			"phydical_handicapped" => $phydical_handicapped,
			"printer" => $printer_status,
			"rough_sheet" => $rough_sheet,
			"exam_co_ordinator" => $exam_co_ordinator,
			"waiting_area" => $waiting_area,
			"parking_facility" => $parking_facility,
			"security_guard" => $security_guard,
			"seperate_restroom" => $seperate_restroom,
			"ac_in_each_lab" => $lab_ac,
			"center_supertendient_ratio" => $center_superintendent_ratio,
			"technical_person_ratio" => $technical_person_ratio,
			"invigilator_ratio" => $invigilator_ratio,
			"security_guard_ratio" => $sucurity_guard_ratio,
			"created_by" => $this->session->userdata('login_user_id'),
			"created_on" => date('Y-m-d H:i:s')
		);	
		$result = $this->db->insert('tt_project_requirement_master',$save_data);
		}
	}	
	
	$last_insert_id = $this->db->insert_id();
	
	
		
		if($result){
			$redirect_url = base_url()."index.php?admin/manage_booking_search/$project_group_id";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
			
//	exit;
/*	echo "<pre>";
		print_r($_POST);exit;*/
	}
	
	public function load_only_city_name(){		
		$state_id = trim($_POST['state_id']);
		$city_id = "";
		if(!empty($_POST['city'])){
			$city_id = $_POST['city'];
		}
		echo $this->common_options->get_city_list($city_id, $state_id);
	}
	
	//Abhinav End
	function manage_booking_search($last_insert_id=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
	/*	if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		} */  
		 '<br>ID='.$searchId=$last_insert_id;
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		
		$req_details = $this->db->query("SELECT id, project_group_id, operating_system, system_ram, system_processor FROM tt_project_requirement_master WHERE 1=1 AND project_group_id='".$searchId."' and status=0")->row();
		//echo '<br>Q='.$aa="SELECT * FROM tt_project_requirement_master WHERE 1=1 AND project_group_id='".$last_insert_id."'";
		//exit;
		 '<br>S='.$operating_system = $req_details->operating_system;
		 '<br>S1='.	$system_ram = $req_details->system_ram;
		 '<br>S2='.	$system_processor = $req_details->system_processor;
		
		
		
		$data['manage_project_infos']    = $this->crud_model->search_all_center($last_insert_id);
		
		
		foreach ($data['manage_project_infos'] as $rowsnew)
			{
				$ctId.=trim($rowsnew['id']).',';
			}			
			'<br>s='.$exam_center_id=substr($ctId, 0,-1);
		
		$qrystr = "";	
		if($operating_system){
			$qrystr .= " AND operating_system = '".$operating_system."'";
		}
		if($system_processor){
			$qrystr .= " AND processor = '".$system_processor."'";
		}
		if($system_ram){
			$qrystr .= " AND ram <= '".$system_ram."'";
		}
		
	//	echo '<br>LQR='.$ss="SELECT * FROM tt_lab  WHERE 1=1 and FIND_IN_SET(center_id, '".trim($exam_center_id)."') $qrystr";
	//	echo '<br>LQRs='.$ss="SELECT * FROM tt_lab  WHERE 1=1 and center_id IN('".trim($exam_center_id)."') $qrystr";
		
		
		$data['manage_project_info'] = $this->db->query("SELECT * FROM tt_lab  WHERE 1=1 and deleted=0 and center_id IN('".trim($exam_center_id)."') $qrystr")->result_array();
		
		
		$data['page_name']          = 'manage_booking_search';
		$data['page_title']         = "Manage Booking Search Result";
		$this->load->view('backend/index', $data);
	}
	
	function booking_search_process(){
	
	/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$idsall = $_POST['ids'];
		
		foreach($idsall as $statusrts)
		{
			$arr=explode("_", $statusrts);
			$status.=$statusrts['arr'].', ';
		}
		 $allstatus=substr($status,0,-2);
		 $ids=explode(",",$allstatus);
		
		
		
		foreach($idsall as $arprj)
		{
			$apj=explode("_", $arprj);
			$pjary.=$apj[1].', ';
		}
		$allpary=substr($pjary,0,-2);
		$allPid=explode(",",$allpary);
		
		
		$project_uid = $_POST['project_uniq_id'];
		//print_r($project_uid);
		$project_id = $_POST['project_id']; 
		$project_name = $_POST['project_name']; 
		$cleint_id = $_POST['cleint_id'];
		$client_name = $_POST['client_name'];
		$city  = $_POST['city'];  
		
		$city_id  = $_POST['city_id']; 
		$center_id  = $_POST['center_id']; 
		$center_name  = $_POST['center_name']; 
		$vendor_id = $_POST['vendor_id']; 
		$date_of_booking_start = $_POST['bookin_start_date']; 
		$date_of_booking_end = $_POST['booking_end_date']; 
		$number_of_day = $_POST['number_of_day']; 
		
		$total_exam_batch = $_POST['total_exam_batch']; 
		$batch_1 = $_POST['batch_1']; 
		$batch_2 = $_POST['batch_2']; 
		$batch_3 = $_POST['batch_3']; 
		$batch_4 = $_POST['batch_4']; 
		$batch_5 = $_POST['batch_5']; 
		
		$number_of_batch = $_POST['number_of_batch']; 
		
		$req_seat = $_POST['req_seat']; 
		$seat_cost  = $_POST['seat_cost'];
		//exit;
	/*	$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(!hasPageAuthorize('manage_booking_search')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new entry", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		
		
		foreach ($idsall as $selID)
		{
			'<br>K VAL= '.$ll= $selID;
			'<br>K rrr= '.$zzz=explode("_", $ll);
			'<br>K ss= '.$k=$zzz[0];
			
			if($k)
			{
				$save_data = array(
				"sid" => $ids[$k],
				"city_id" => trim($city_id[$k]),
				"city_name" => get_city_name($city_id[$k]),
				"project_id" => $project_id,
				"project_name" => trim($project_name),
				"client_id" => trim($cleint_id),
				"client_name" => trim($client_name),
				"center_id" => $center_id[$k],
				"center_name" => $center_name[$k],
				"vendor_id" => $vendor_id[$k],
				"vendor_name" => $this->common_options->get_vendorname($vendor_id[$k]),
				"date_of_booking_start" => $date_of_booking_start[$k],
				"date_of_booking_end" => $date_of_booking_end[$k],
				"number_of_day" => $number_of_day[$k],
				"total_exam_batch" => $total_exam_batch[$k],
				"batch_1" => $batch_1[$k],
				"batch_2" => $batch_2[$k],
				"batch_3" => $batch_3[$k],
				"batch_4" => $batch_4[$k],
				"batch_5" => $batch_5[$k],
				"number_of_batch" => $number_of_batch[$k],
				"required_seat" => $req_seat[$k],
				"proposed_cost" => $seat_cost[$k],
				"booking_date" => date('Y-m-d H:i:s')
			);	
				$result = $this->db->insert('tt_center_booking',$save_data);
			}
		}
	
		foreach ($allPid as $pjid)
		{
			$save_data = array(
						"status" => 1,
						"last_modified_by" => $this->session->userdata('login_user_id'),
						"last_modified_on" => date('Y-m-d H:i:s')
					);	
					$this->db->where('id',$pjid);
					$result1 = $this->db->update('tt_project_requirement_master',$save_data);	
					
		}
		
		$last_insert_id = $this->db->insert_id();
		if($result){
			$redirect_url = base_url()."index.php?admin/pending_booking";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Lab Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		/*echo "<pre>";
		print_r($_POST);exit;*/
	}
	
		function pending_booking(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		} */  
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$data['admin_project_info']    = $this->crud_model->search_all_pending();
		$data['page_name']          = 'pending_booking';
		$data['page_title']         = "Pending Booking";
		$this->load->view('backend/index', $data);
	}
	
	function send_mail_for_center(){
		/*if(!hasPageAuthorize('send_email_pending_center')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$id = $this->db->escape_str(trim($this->input->post('id')));
		$sender_email_id = str_replace("'","&#8217;",trim($this->input->post('sender_email_id')));
		$mail_subject = str_replace("'","&#8217;",trim($this->input->post('mail_subject')));
		$mail_message = str_replace("'","&#8217;",trim($this->input->post('mail_message')));
	
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(empty($id) or !is_numeric($id)){
			$ar = array("status" => "fail", "error" => "Invalid id.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($sender_email_id)){
			$ar = array("status" => "fail", "error" => "Enter email.", "frm_btn_id" => "submit_btn_id", "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		if(empty($mail_message)){
			$ar = array("status" => "fail", "error" => "Mail contents is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$Message="<table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='29' height='23' align='left' valign='top' bgcolor='#45BCD2'>&nbsp;</td>
    <td align='left' valign='top' bgcolor='#45BCD2'>&nbsp;</td>
  </tr>
  <tr>
    <td height='354' align='left' valign='top' bgcolor='#ececec'>&nbsp;</td>
    <td align='left' valign='top' bgcolor='#ececec' style='font-family: Arial, Helvetica, sans-serif;color:#363737;font-size:12px;line-height:20px;'>
  <br /><br />
    Dear Sir/Madam,<br />
    <br />
   
    ".ucfirst($mail_message)." <br /><br />  
	
 
	
    Best Regards,<br />
    Testpan Team    </td>
  </tr>
   <tr>
    <td width='29' height='23' align='left' valign='top' bgcolor='#45BCD2'>&nbsp;</td>
    <td align='left' valign='top' bgcolor='#45BCD2'>&nbsp;</td>
  </tr>
</table>";
		        $ToSubject = 'Testpan Center Management System';
				$mail_From = 'info@seemysolutions.com';
				$headers = 'From: '.$mail_From. "\r\n";
				$headers .= "Content-type: text/html\r\n"; 
				$headers .= 'Bcc: '.$mail_Bcc."\r\n";
				mail($sender_email_id, $ToSubject, $Message, $headers); 
		
		$last_insert_id = '1';
		if($last_insert_id){
			$redirect_url = base_url()."index.php?admin/pending_booking";
			$this->session->set_flashdata('message' , "Mail Sent successfully");
			$ar = array("status" => "pass", "error" => "Mail Sent successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "lab id code is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		//$this->session->set_flashdata('message' , "Data saved successfully");
		//redirect('index.php?admin/ministry_of_textile');
	
	}
	
	function confirm_booking($id = NULL){			
		//if(!hasPageAuthorize('confirm_booking')){
		//	redirect(base_url(), 'refresh');exit;
		//} 
		
		
		//'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$ct_details = $this->db->query("SELECT * FROM tt_center_booking where 1=1 and id='".$id."'")->row();
		if(!$ct_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['ct_details'] = $ct_details;
		
		
		
		$data['page_name']          = 'confirm_booking';
		$data['page_title']         = "Confirm Booking";
		$this->load->view('backend/index', $data);
	}
	
	
	
	
	function final_booking_process(){
		/*echo "<pre>";
		print_r($_POST);exit;*/
		$id = $_POST['id']; 
		$city_id = $_POST['city_id'];
		$city_name = $_POST['city_name'];
		$project_id = $_POST['project_id'];
		$project_name = $_POST['project_name'];
		$client_id = $_POST['client_id'];
		$client_name = $_POST['client_name'];
		$center_id = $_POST['center_id'];
		$center_name = $_POST['center_name'];
		$vendor_id = $_POST['vendor_id'];
		$vendor_name = $_POST['vendor_name'];
		$proposed_cost = $_POST['proposed_cost'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$number_of_day = $_POST['number_of_day'];
		$final_seat_count = $_POST['final_seat_count'];
		$final_amount = $_POST['final_amount'];
		$extra_amount = $_POST['extra_amount'];
		$advance_amount = $_POST['advance_amount'];
		$commrcl_by_per = $_POST['commrcl_by_per'];
		$batchTime = $_POST['batchTime'];
		$batch_time_1 = $_POST['batch_time_1'];
		$batch_time_2 = $_POST['batch_time_2'];
		$batch_time_3 = $_POST['batch_time_3'];
		$batch_time_4 = $_POST['batch_time_4'];
		$batch_time_5 = $_POST['batch_time_5'];
		
		$batchcount = $_POST['batchcount'];
		$batch_count_1 = $_POST['batch_count_1'];
		$batch_count_2 = $_POST['batch_count_2'];
		$batch_count_3 = $_POST['batch_count_3'];
		$batch_count_4 = $_POST['batch_count_4'];
		$batch_count_5 = $_POST['batch_count_5'];
		
		$total_batch_seat=$batch_count_1+$batch_count_2+$batch_count_3+$batch_count_4+$batch_count_5;
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_manpower')){
			$ar = array("status" => "fail", "error" => "You do not have permission", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		/*if($total_batch_seat > $final_seat_count){
			$ar = array("status" => "fail", "error" => "Batch seat count can't be greater than required seat!.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	*/
		if(empty($start_date)){
			$ar = array("status" => "fail", "error" => "Exam Start Date required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		if(empty($end_date)){
			$ar = array("status" => "fail", "error" => "Exam End Date required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($final_seat_count)){
			$ar = array("status" => "fail", "error" => "Total Seat value required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($final_amount)){
			$ar = array("status" => "fail", "error" => "Total Seat Amount required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($commrcl_by_per)){
			$ar = array("status" => "fail", "error" => "Commercial type required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($number_of_day)){
			$ar = array("status" => "fail", "error" => "Number of Booking Day required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		////bill generation
		$gst='18'; 
		/*$amount=$final_seat_count*$final_amount;
		$gstAMount=$amount*18/100;
		$totalPayable=$amount+$gstAMount;*/
	
		if($commrcl_by_per=="Candidate")
		{
			//$amount=$final_seat_count*$final_amount*$batchTime;
			$amount=$final_seat_count*$final_amount*$batchTime*$number_of_day;
			$gstAMount=$amount*18/100;
			$totalPayable=$amount+$gstAMount;
		}
		if($commrcl_by_per=="System")
		{
			//$amount=$final_seat_count*$final_amount;
			$amount=$final_seat_count*$final_amount*$number_of_day;
			$gstAMount=$amount*18/100;
			$totalPayable=$amount+$gstAMount;
		}
		
		$save_data = array(
			"status" => 1,
			"modified_by" => $this->session->userdata('login_user_id'),
			"modify_date" => date('Y-m-d H:i:s')
		);	
		
		$this->db->where('id',$id);
        $result = $this->db->update('tt_center_booking',$save_data);
		//$last_insert_ids = $this->db->insert_id();
		
		
		$save_data = array(
			"center_book_id" => $id,
			"project_id" => $project_id,
			"project_name" => $project_name,
			"client_id" => $client_id,
			"client_name" => $client_name,
			"center_id"=> $center_id,
			"center_name" => $center_name,
			"vendor_id" => $vendor_id,
			"vendor_name" => $vendor_name,
			"city_id" => $city_id,			
			"city_name" => get_city_name($city_id),
			"exam_start_date" => $start_date,
			"exam_end_date" => $end_date,
			"number_of_day" => $number_of_day,
			"total_exam_batch" => $batchTime,
			"batch_1" => $batch_time_1,
			"batch_2" => $batch_time_2,
			"batch_3" => $batch_time_3,
			"batch_4" => $batch_time_4,
			"batch_5" => $batch_time_5,
			"total_batch_count" => $batchcount,
			"batch_count_1" => $batch_count_1,
			"batch_count_2" => $batch_count_2,
			"batch_count_3" => $batch_count_3,
			"batch_count_4" => $batch_count_4,
			"batch_count_5" => $batch_count_5,
			"total_seat" => $final_seat_count,
			"proposed_cost_each" => $proposed_cost,
			"per_sys_or_candidate" => $commrcl_by_per,
			"extra_amount" => $extra_amount,
			"final_cost_each" => $final_amount,
			"total_cost" => $amount,
			"advance_payment" => $advance_amount,
			"gst_percent" => $gst,
			"gst_amount" => $gstAMount,
			"total_payable_amount" => $totalPayable,
			"final_booking_date" => date('Y-m-d H:i:s'),
			"book_status" => 1,
			"created_by" => $this->session->userdata('login_user_id'),
			"created_on" => date('Y-m-d H:i:s')
		);	
		
		$result = $this->db->insert('tt_center_booking_master',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		$save_data1 = array(
						"status" => 1,
						"modified_by" => $this->session->userdata('login_user_id'),
						"modify_date" => date('Y-m-d H:i:s')
					);	
					$this->db->where('id',$id);
					$result1 = $this->db->update('tt_center_booking',$save_data1);	
				
		
		
		
		
		if($result){
			$redirect_url = base_url()."index.php?admin/pending_booking";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function confirmed_booking(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$data['admin_project_info'] = $this->crud_model->search_all_confirmed();
		$data['page_name']          = 'confirmed_booking';
		$data['page_title']         = "Confirmed Booking";
		$this->load->view('backend/index', $data);
	}
	
	function pay_invoice_process(){
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
	    
		$id = $_POST['id'];
		$center_book_id = $_POST['center_book_id'];
		$city_id = $_POST['city_id'];
		$project_id = $_POST['project_id'];
		$payment_detail = $_POST['payment_detail'];
		
		$ct_qry = $this->db->query("SELECT id FROM tt_center_booking WHERE 1=1 AND city_id='".$city_id."' and project_id='".$project_id."'")->row();
		$bid=$ct_qry->id;
		
		
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('pay_invoice')){
			$ar = array("status" => "fail", "error" => "You do not have permission", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		if(empty($payment_detail)){
			$ar = array("status" => "fail", "error" => "Enter Payment Detail.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$save_data = array(
			"status" => 2,
			"modified_by" => $this->session->userdata('login_user_id'),
			"modify_date" => date('Y-m-d H:i:s')
		);	
		
		$this->db->where('id',$center_book_id);
        $result = $this->db->update('tt_center_booking',$save_data);	
		
	
		$save_data = array(
			"book_status" => 2,
			"payment_status" => 1,
			"payment_detail" => $payment_detail,
			"payment_date" => date('Y-m-d H:i:s'),
			"modified_by" => $this->session->userdata('login_user_id'),
			"modify_date" => date('Y-m-d H:i:s')
		);	
		
		$this->db->where('id',$id);
        $result = $this->db->update('tt_center_booking_master',$save_data);
		
		
		
		
		
		
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			$redirect_url = base_url()."index.php?admin/confirmed_booking";
			$this->session->set_flashdata('message' , "Payment successfully");
			$ar = array("status" => "pass", "error" => "Payment successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function completed_booking(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		} */  
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$data['admin_project_info']    = $this->crud_model->search_all_completed();
		$data['page_name']          = 'completed_booking';
		$data['page_title']         = "Completed Booking";
		$this->load->view('backend/index', $data);
	}
	
	function cancil_booking_process(){
		/*echo "<pre>";
		print_r($_POST);exit;*/
		$id = $_POST['id'];
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('cancil_booking_popup')){
			$ar = array("status" => "fail", "error" => "You do not have permission", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
*/		$save_data = array(
			"modified_by" => $this->session->userdata('login_user_id'),
			"modify_date" => date('Y-m-d H:i:s'),
			"deleted" => 1
			
		);	
		$this->db->where('id',$id);
        $result = $this->db->update('tt_center_booking',$save_data);
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			$redirect_url = base_url()."index.php?admin/pending_booking";
			$this->session->set_flashdata('message' , "Project Cancel successfully");
			$ar = array("status" => "pass", "error" => "Project Cancel successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function center_invoice_listing(){
		if ($this->session->userdata('admin_login') != 1 or $this->session->userdata('admin_login') !=3)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		//echo '<br><br><br><br>QE= '.$ss="SELECT * FROM tt_center_booking_master where 1=1 and book_status=2  GROUP BY project_id, center_id";

		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$data['admin_project_info']    = $this->crud_model->search_invoice_for_center();
		$data['page_name']          = 'center_invoice_listing';
		$data['page_title']         = "Center Invoice";
		$this->load->view('backend/index', $data);
	}
	
	function download_invoice($prjID, $id){
	
		if(empty($prjID)){
			echo "Transaction id is required";
			exit;
		}
		if(!is_numeric($prjID)){
			echo "invalid id, please provide numerical id";
			exit;
		}
		if(empty($id)){
			echo "Center id is required";
			exit;
		}
		if(!is_numeric($id)){
			echo "invalid id, please provide numerical id";
			exit;
		}
		//validate in database
		//echo '<br>A='.$aa="SELECT * FROM tt_exam_booking_detail WHERE 1=1 AND project_id='".$prjID."' and center_id='".$id."' and book_flag=0 and status=1";
	//	exit;
		
		$transaction_qry_ct = $this->db->query("SELECT * FROM tt_exam_booking_detail WHERE 1=1 AND project_id='".$prjID."' and center_id='".$id."' and book_flag=0 and status=1")->row();
		$center_id=$transaction_qry_ct->center_id;
		$exam_name= $transaction_qry_ct->project_name;
		
		
		$transaction_exam = $this->db->query("SELECT * FROM tt_project_detail WHERE 1=1 AND project_id='".$prjID."' and book_flag=0")->row();
		$asdate1=date("d M Y", strtotime($transaction_exam->start_date));
		$asdate2=date("d M Y", strtotime($transaction_exam->end_date));
		
		$transaction_qry = $this->db->query("SELECT * FROM tt_exam_booking_detail WHERE 1=1 AND project_id='".$this->db->escape_str($prjID)."' and center_id='".$this->db->escape_str($id)."' and book_flag=0 and status=1 and deleted=0")->result_array();
		
		
		$actual_amount=0;
		$gst_amounts=0;
		$cm_total_payable=0;
		foreach($transaction_qry as $bookedseat)
		{ 
			$actual_amount = $actual_amount + $bookedseat['cm_total_amount'];
			$gst_amounts = $gst_amounts + $bookedseat['cm_gst_amount'];
			$cm_total_payable = $cm_total_payable + $bookedseat['cm_total_payable'];
			
		}
		$actual_amount;
		$gst_amount=$gst_amounts/2;
		$igst_amount=$gst_amount;
		$cm_total_payable;
		$center_qry = $this->db->query("SELECT * FROM tt_center WHERE 1=1 AND id='".$id."'")->row();
		$center_name=$center_qry->center_name;
		$center_address= $center_qry->address;
		$center_city=$center_qry->city;
		$center_pincode= $center_qry->pin_code;
		$center_state= get_state_name($center_qry->state_id);
		$center_pincode= $center_qry->pin_code;
		$center_gst= $center_qry->gst_no;
		$center_superintendent= $center_qry->cs_name;
		$cs_mobile= $center_qry->cs_contact_number;
		$cs_email= $center_qry->cs_email;
		$invoice_no= "TIPL/"."2018-19/0"."$id";
		$gst_no= $center_qry->gst_no;
		$gst_state_code= get_state_name($center_qry->gst_state_code).' - '.$center_qry->gst_state_code;
		$bank_name= $center_qry->bank_name;
		$beneficiary_name= $center_qry->beneficiary_name;
		$bank_account_number= $center_qry->bank_account_number;
		$bank_ifsc_code= $center_qry->bank_ifsc_code;
		$cs_name= $center_qry->cs_name;
		$pan_no= $center_qry->pan_no;
		//get_state_name
		
		//print_r($transaction_row);exit;
		//fragment previous tax if sum is provided
		//if previously created package then need to put taxes in transaction table 
		
		$projectid= $transaction_qry_ct->project_id;
		$pdid= $transaction_qry_ct->id;
		$cpid= sprintf("%04d", $pdid); 
		$examdate= $transaction_qry_ct->exam_date;
		$parts = explode('-', $examdate);
		$yr= $parts[0];
		$yr2=$yr+1;
		$array_yr = str_split($yr2);
		$nxtyr=$array_yr[2].''.$array_yr[3];
		$billYear=$yr.'-'.$nxtyr;
		$inv_no="TIPL/C/". "$billYear". "/". "$cpid";
		$invoiceDate=date('d-m-Y');
		
		//exit;
		
		
		include_once  APPPATH . '/vendor/mpdf/mpdf.php' ;
		$n_pdf_obj = new mPDF("'en-GB-x','A4','','',10,10,10,10,6,3");	
		
		
			//also keep file for authority letter and Key Receipt
			//for package
			
				
				
				$message = "";			
				$message .= '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>testpan.com</title>
</head>
<body>
<h2 style="text-align:center;"><strong>TAX INVOICE</strong></h2>
<table width="100%" border="1" cellspacing="0" style="font-size:3mm">
 
  <tr>
    <td colspan="8" valign="top"><table width="100%" height="342">
        <tr>
          <td height="24">Center Name</td>
          <td>'.ucwords($center_name).'</td>
          <td>Invoice No</td>
          <td>'.$inv_no.'</td>
        </tr>
        <tr>
          <td height="24">&nbsp;</td>
          <td rowspan="3">'.ucwords($center_address).' <br> '.ucwords($center_city).', '.$center_state.' - '.$center_pincode.'</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Address</td>
          <td>Invoice Date</td>
          <td>'.$invoiceDate.'</td>
        </tr>
        <tr>
          <td height="24">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Person Name</td>
          <td valign="top">'.ucwords($center_superintendent).'</td>
          <td>MSME [Y/N]</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Mobile</td>
          <td>'.$cs_mobile.'</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Email ID</td>
          <td>'.$cs_email.'</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24" colspan="4"><hr></td>
        </tr>
        <tr>
          <td height="24">Bill To</td>
          <td>Testpan India Private Limited</td>
          <td>GSTIN</td>
          <td>07AAFCT9560Q1ZG</td>
        </tr>
        <tr>
          <td height="24">&nbsp;</td>
          <td>WZ-1390/7,IInd Floor, (Above MTNL Exchange)</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Billing Address</td>
          <td>Pankha Road,Nangal Raya, </td>
          <td>STATE</td>
          <td>DELHI - 07</td>
        </tr>
        <tr>
          <td height="24">&nbsp;</td>
          <td>New Delhi 110046, India.</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="25%" height="24">Phone No.</td>
          <td width="25%">91-11-28520481</td>
          <td width="272">&nbsp;</td>
          <td width="25%">&nbsp;</td>
        </tr>
        
      
        
    </table>    </td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8"><strong>Description Of Services - Infra Charges for Conducting '.ucwords($exam_name).' Exam At my centre</strong></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr >
    <td width="14%" align="center"><strong>HSN/SAC</strong></td>
    <td width="14%" align="center"><strong>Exam Date</strong></td>
    <td width="14%" align="center"><strong>Quantity</strong></td>
    
    <td width="14%" align="center"><strong>Mode</strong></td>
    <td width="14%" align="center"><strong>Rate</strong></td>
    <td width="15%" align="center"><strong>Extra</strong></td>
    <td width="15%" align="center"><strong>Total</strong></td>
  </tr>';
  $totalGST='';
  $cm_payable='';
  $cm_payable_tot='';
 	foreach($transaction_qry as $bookedseat)
	{ 
  			$bookmode='';
			$bookmode=$bookedseat['cm_pay_option'];
			if($bookmode=='1'){ $pay_mode ='Candidate'; }
			if($bookmode=='2'){ $pay_mode ='System'; }
			if($bookmode=='4'){ $pay_mode ='Lumpsum'; }
  			$exam_city=$bookedseat['city_name'];
            $center_name=$bookedseat['center_name'];
  			$examDate=date("d M Y", strtotime($bookedseat['exam_date']));  
            $quantity=$bookedseat['total_seat'];
            if($bookmode=='1'){
            	 $quantity=$bookedseat['total_seat'];
            }
            if($bookmode=='2'){
             	$allbatch=array($bookedseat['batch1'], $bookedseat['batch2'], $bookedseat['batch3'], $bookedseat['batch4'], $bookedseat['batch5']);
				$quantity = max($allbatch);
            }
            if($bookmode=='4'){
            	 $quantity=$bookedseat['total_seat'];
            }
            
            $bach=$bookedseat['total_batch'];
            $vrate=$bookedseat['cm_cost'];
            $extraamt=$bookedseat['cm_extra_cost'];
            $totalAmt=$bookedseat['cm_total_amount'];

  			$totalGST=$bookedseat['cm_gst_amount'];
			$toalGST=$totalGST+$toalGST;
            
            $cm_total=$bookedseat['cm_total_amount'];
			$cm_total_amount=$cm_total_amount+$cm_total;
			
			$cm_payable_tot=$bookedseat['cm_total_payable'];
			
            
            if($gst_no){
				$cm_total_payable_amount=$cm_total_payable_amount+$cm_payable_tot;
            } else {
				$cm_total_payable_amount=$cm_total_amount;
            }
  
  $message .= '<tr>
    <td align="center">999295</td>
    <td align="center">'.$examDate.'</td>
    <td align="center">'.$quantity.'</td>
    
    <td align="center">'.$pay_mode.'</td>
    <td align="center">'.$vrate.'</td>
    <td align="center">'.$extraamt.'</td>
    <td align="center">'.$totalAmt.'</td>
  </tr>';
  }
  $message .= '<tr>
    <td colspan="4" rowspan="4">&nbsp;</td>
    <td colspan="2">Total (Rs.)</td>
    <td align="center">'.number_format($cm_total_amount, 2).'</td>
  </tr>';
  if($gst_state==7 && $gst_no!=''){
  
  $message .= '<tr>
    <td colspan="2"><p>CGST @ 9% </p><p>SGST @ 9%</p><p>IGST  @ 18%</p></td>
    <td align="center"><p align="center">'.number_format(($toalGST/2), 2).'</p>
    <p align="center">'.number_format(($toalGST/2), 2).'</p>
    
    
    <p>&nbsp;</p></td>
  </tr>';
  }
  if($gst_state!=7 && $gst_no!=''){
  $message .= '<tr>
    <td colspan="2"><p>CGST @ 9% </p><p>SGST @ 9%</p><p>IGST  @ 18%</p></td>
    <td align="center"><p>&nbsp;</p>
    <p>&nbsp;</p>
    
    
    <p align="center">'.number_format(($toalGST), 2).'</p></td>
  </tr>';
  }
  if($gst_no!=''){
  $message .= '<tr>
    <td colspan="2">Total GST (Rs.)</td>
    <td align="center">'.number_format($toalGST, 2).'</td>
  </tr>';
  } else {
  $message .= '<tr>
    <td colspan="2">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>';
  }
  
  $message .= '<tr>
    <td colspan="2"><strong>Total Amount (Rs.)</strong></td>
    <td align="center">'.number_format($cm_total_payable_amount, 2).'</td>
  </tr>
  
  <tr>
    <td height="22" colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td height="218" colspan="8"><table width="100%" cellpadding="5" border="1" cellspacing="0" style="border-collapse:collapse;" >
      
      <tr>
        <td width="35%">PAN Number:</td>
        <td width="35%">'.$pan_no.'</td>
        <td width="30%" align="center">&nbsp;</td>
        </tr>
      <tr>
        <td>GSTIN:</td>
        <td>'.$gst_no.'</td>
        <td rowspan="6" align="center" valign="top">Authorised Signatory, Stamp &amp; Date</td>
        </tr>
      <tr>
        <td>GST State :</td>
        <td>'.$gst_state_code.'</td>
        </tr>
      <tr>

        <td>Beneficiary Name:</td>
        <td>'.ucwords($beneficiary_name).'</td>
        </tr>
      <tr>
        <td>Account Number:</td>
        <td>'.$bank_account_number.'</td>
        </tr>
      <tr>
        <td>IFSC:</td>
        <td>'.$bank_ifsc_code.'</td>
        </tr>
      <tr>
        <td>Bank Name:</td>
        <td>'.$bank_name.'</td>
        </tr>
     
      <tr></tr>
     
    </table></td>
  </tr>
</table>		
</body>
				</html>';
				
				$invoice_html = mb_convert_encoding($message, 'UTF-8', 'UTF-8');			
				$n_pdf_obj->setAutoBottomMargin = 'stretch';				
				$n_pdf_obj->SetHTMLFooter('<div style="width:600px; margin:auto; text-align:center; font:normal 24px Arial, Helvetica, sans-serif;">
	<p><strong> Testpan India Pvt Ltd, Pankha Road, Nangal Raya, New Delhi-110046</strong>
	</p>
</div>');	
				
				$invoiceFilePath = "invoice"."pdf";	
				//$invoiceFilePath = "invoice_".$transaction_row->id.".pdf";		
				$n_pdf_obj->WriteHTML($invoice_html);			
				//download it.
				//$this->m_pdf->pdf->Output($pdfFilePath, "D");  \
				//I: Display on Browser		
				$n_pdf_obj->Output($invoiceFilePath, "I");			
				
				//#End propcare invoice mail template
	}
	
	function center_summary(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
	/*	if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		if(trim($this->input->post('button'))){
		$action = trim($this->input->post('button'));
		$id = $_POST['ids'];
		for($i=0;$i<sizeof($id); $i++)
		{	
			if(trim($this->input->post('button'))=='Inactive')
			{
				$result[] = $this->db->query("update tt_center_booking set deleted=1 where id='".$this->db->escape_str($_POST['ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Activate')
			{
				$result[] = $this->db->query("update tt_center_booking set deleted=0 where id='".$this->db->escape_str($_POST['ids'][$i])."'");	
			}
			if(trim($this->input->post('button'))=='Delete')
			{
				$result[] = $this->db->query("update tt_center_booking set deleted=2 where id='".$this->db->escape_str($_POST['ids'][$i])."'");	
			}
		
		}
		
		}
		//($vendor_id);
		/*echo "<pre>";
		print_r($_POST);exit;*/

		
		$data['center_summary_info']    = $this->crud_model->select_center_summary();
		$data['page_name']          = 'center_summary';
		$data['page_title']         = "Center Summary";
		$this->load->view('backend/index', $data);
	}
	
		function invoice_listing(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$data['admin_project_info']    = $this->crud_model->search_all_completed_invoice();
		$data['page_name']          = 'invoice_listing';
		$data['page_title']         = "Vendor Invoice";
		$this->load->view('backend/index', $data);
	}
	function invoice_project($id=NULL){
		/*if(!hasPageAuthorize('invoice_project')){
			redirect(base_url(), 'refresh');exit;
		} */

		$this->session->set_userdata(array("edit_user_id" => $id));
	//	$p_details = $this->db->query("SELECT * FROM tt_center_booking where 1=1 and project_id='".$this->db->escape_str($id)."'")->result_array();
		
		$p_details = $this->db->query("SELECT * FROM tt_center_booking_master where 1=1 and project_id='".$this->db->escape_str($id)."'")->result_array();

		//$p_name = $this->db->query("SELECT project_name FROM tt_center_booking_master where 1=1 and project_id='".$this->db->escape_str($id)."'")->row();
		//echo '<br>QE'.$aa="SELECT * FROM tt_center_booking_master where 1=1 and project_id='".$this->db->escape_str($id)."'";
		
		/*if(!$p_details){
			redirect(base_url(), 'refresh');exit;
		}*/
		$data['p_details'] = $p_details;
		$data['page_name'] = 'invoice_project';
		$data['page_title']= "Project Invoice Detail";
		$this->load->view('backend/index', $data);		
	}
	
	function admin_users_role($task = ""){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		
		if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}   
		$data['admin_user_info']    = $this->crud_model->select_admin_role();
		$data['page_name']          = 'admin_users_role';
		$data['page_title']         = "Admin Users Role";
		$this->load->view('backend/index', $data);
	}
	function add_admin_role(){			
		if(!hasPageAuthorize('add_admin_role')){
			redirect(base_url(), 'refresh');exit;
		} 
		$data['page_name']          = 'add_admin_role';
		$data['page_title']         = "Add Admin Role";
		$this->load->view('backend/index', $data);
	}
	 function add_admin_role_process(){
	 
		$admin_role_name = trim($this->input->post('admin_role_name'));
		$access_admin = trim($this->input->post('access_admin'));
		$access_vendor = trim($this->input->post('access_vendor'));
		$access_center = trim($this->input->post('access_center'));
		$access_client = trim($this->input->post('access_client'));		
		$access_booking = trim($this->input->post('access_booking'));
		
		$access_project = trim($this->input->post('access_project'));
		$access_invoice = trim($this->input->post('access_invoice'));
		$access_manpower = trim($this->input->post('access_manpower'));
		$access_manpower_payment = trim($this->input->post('access_manpower_payment'));
		$center_download_permit = trim($this->input->post('center_download_permit'));
				
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(!hasPageAuthorize('add_admin_role')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add admin user", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
		
		if(empty($admin_role_name)){
			$ar = array("status" => "fail", "error" => "Admin Role Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($access_admin)){
			$ar = array("status" => "fail", "error" => "Access Admin Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($access_vendor)){
			$ar = array("status" => "fail", "error" => "Access Vendor Optionis required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_center)){
			$ar = array("status" => "fail", "error" => "Access Center Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_client)){
			$ar = array("status" => "fail", "error" => "Access Client Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_booking)){
			$ar = array("status" => "fail", "error" => "Access Booking Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_project)){
			$ar = array("status" => "fail", "error" => "Access Project Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_invoice)){
			$ar = array("status" => "fail", "error" => "Access Invoice Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_manpower)){
			$ar = array("status" => "fail", "error" => "Access Manpower Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_manpower_payment)){
			$ar = array("status" => "fail", "error" => "Access Manpower Payment Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($center_download_permit)){
			$ar = array("status" => "fail", "error" => "Access Center Download Permission is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		$check_qry = $this->db->query("select * from  tt_roles where 1=1 and title='".$admin_role_name."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Admin Role Already Defined.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}

		if($admin_role_name == "Super User")						{
			$ar = array("status" => "fail", "error" => "Role Name not accepted", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$save_data = array(
			"title" => $admin_role_name,
			"access_admin" => $access_admin,
			"access_vendor" => $access_vendor,
			"access_center" => $access_center,
			"access_client" => $access_client,
			"access_booking" => $access_booking,
			"access_project" => $access_project,
			"access_invoice" => $access_invoice,
			"access_manpower" => $access_manpower,
			"access_manpower_payment" => $access_manpower_payment,
			"access_center_download" => $center_download_permit,
			"created_by" => $this->session->userdata('login_user_id'),
			"created" => date('Y-m-d H:i:s')
		);	
		
		$result = $this->db->insert('tt_roles',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/admin_users_role";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	function edit_admin_role($id = NULL){			
		if(!hasPageAuthorize('edit_admin_user')){
			redirect(base_url(), 'refresh');exit;
		} 
		//1: Super Admin can not be updated
		if(empty($id) or !is_numeric($id) or $id<=1){
			redirect(base_url(), 'refresh');exit;
		}		
		$this->session->set_userdata(array("edit_user_id" => $id));
		$user_details = $this->db->query("SELECT * FROM tt_roles where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$user_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['user_details'] = $user_details;
		$data['page_name']          = 'edit_admin_role';
		$data['page_title']         = "Edit Admin Role";
		$this->load->view('backend/index', $data);
	}
	function edit_admin_role_process(){
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(!hasPageAuthorize('edit_admin_role')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add admin user", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
				
		$edit_user_id  = $this->session->userdata('edit_user_id');
		if(empty($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		if(!is_numeric($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		$admin_role_name = trim($this->input->post('admin_role_name'));
		$access_admin = trim($this->input->post('access_admin'));
		$access_vendor = trim($this->input->post('access_vendor'));
		$access_center = trim($this->input->post('access_center'));
		$access_client = trim($this->input->post('access_client'));		
		$access_booking = trim($this->input->post('access_booking'));
		$access_project = trim($this->input->post('access_project'));
		$access_invoice = trim($this->input->post('access_invoice'));
		$access_manpower = trim($this->input->post('access_manpower'));
		$access_manpower_payment = trim($this->input->post('access_manpower_payment'));
		$center_download_permit = trim($this->input->post('center_download_permit'));
		
		if(empty($access_admin)){
			$ar = array("status" => "fail", "error" => "Access Admin Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($access_vendor)){
			$ar = array("status" => "fail", "error" => "Access Vendor Optionis required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_center)){
			$ar = array("status" => "fail", "error" => "Access Center Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_client)){
			$ar = array("status" => "fail", "error" => "Access Client Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_booking)){
			$ar = array("status" => "fail", "error" => "Access Booking Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_project)){
			$ar = array("status" => "fail", "error" => "Access Project Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_invoice)){
			$ar = array("status" => "fail", "error" => "Access Invoice Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_manpower)){
			$ar = array("status" => "fail", "error" => "Access Manpower Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($access_manpower_payment)){
			$ar = array("status" => "fail", "error" => "Access Manpower Payment Option is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($center_download_permit)){
			$ar = array("status" => "fail", "error" => "Access Center Data Download is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$check_qry = $this->db->query("select * from  tt_roles where 1=1 and id<>'".$edit_user_id."' and title='".$admin_role_name."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Admin Role exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$save_data = array(
			"title" => $admin_role_name,
			"access_admin" => $access_admin,
			"access_vendor" => $access_vendor,
			"access_center" => $access_center,
			"access_client" => $access_client,
			"access_booking" => $access_booking,
			"access_project" => $access_project,
			"access_invoice" => $access_invoice,
			"access_manpower" => $access_manpower,
			"access_manpower_payment" => $access_manpower_payment,
			"access_center_download" => $center_download_permit,
			"updated_by" => $this->session->userdata('login_user_id'),
			"updated" => date('Y-m-d H:i:s')
		);	
		
		$this->db->where('id',$edit_user_id);
        $result = $this->db->update('tt_roles',$save_data);
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			//$redirect_url = base_url()."index.php?c=admin&m=add_new_id_card_step_one&bundle_id=".$last_insert_id;
			$redirect_url = base_url()."index.php?admin/admin_users_role";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
		function download_vendor_invoice($prjID, $vendorId){
	
		if(empty($prjID)){
			echo "Transaction id is required";
			exit;
		}
		if(!is_numeric($prjID)){
			echo "invalid id, please provide numerical id";
			exit;
		}
		if(empty($vendorId)){
			echo "Transaction id is required";
			exit;
		}
		if(!is_numeric($vendorId)){
			echo "invalid id, please provide numerical id";
			exit;
		}
		
		$transaction_qry = $this->db->query("SELECT * FROM tt_exam_booking_detail WHERE 1=1 and project_id='".$this->db->escape_str($prjID)."' AND vendor_id='".$this->db->escape_str($vendorId)."' and book_flag=0 and status=1")->result_array();
		
	//	echo '<br>A='.$ss="SELECT * FROM tt_exam_booking_detail WHERE 1=1 and project_id='".$this->db->escape_str($prjID)."' AND vendor_id='".$this->db->escape_str($vendorId)."' and book_flag=0 and status=1";
		
		foreach($transaction_qry as $vrows)
		{
			$project_name=$vrows['project_name'];
			//$assessment_date=$vrows['exam_start_date'];
			
			$assessment_date = date("d-m-Y", strtotime($vrows['exam_date']));
		}
	
		$vendor_qry = $this->db->query("SELECT * FROM tt_vendor WHERE 1=1 AND vendor_id='".$this->db->escape_str($vendorId)."'")->row();
		$vendor_name=$vendor_qry->vendor_name;
		$co_ordinator_name= $vendor_qry->co_ordinator_name;
		$vendorAddress= $vendor_qry->address;
		$vendor_city=get_city_name($vendor_qry->city);
		$location=$vendor_qry->location;
		$pan= $vendor_qry->pan;
		$vendor_state= get_state_name($vendor_qry->state_id);
		$gst_no= $vendor_qry->gst_no;
		$bank_name= $vendor_qry->bank_name;
		$bank_account_number= $vendor_qry->bank_account_number;
		$bank_account_ifsc= $vendor_qry->bank_account_ifsc;
		$address= $vendor_qry->address;
		$city= $vendor_qry->city;
		$pincode= $vendor_qry->pincode;
		$cs_name= $vendor_qry->cs_name;
		$pan_no= $vendor_qry->pan_no;
		if($gst_no){
		$gst_state_code= get_state_name($vendor_qry->state_id).' - '.$vendor_qry->state_id;
		}
		$vendor_mobile= $vendor_qry->vendor_mobile;
		$vendor_email= $vendor_qry->vendor_email;
		
		$inv_id_qry = $this->db->query("SELECT project_id,project_name, created_on FROM tt_exam_booking_detail WHERE 1=1 and project_id='".$this->db->escape_str($prjID)."' AND vendor_id='".$this->db->escape_str($vendorId)."' and book_flag=0 and status=1")->row();
		$projectid= $inv_id_qry->project_id;
		$projectName= $inv_id_qry->project_name;
		$crton= $inv_id_qry->created_on;
		$parts = explode('-', $crton);
		$yr= $parts[0];
		$yr2=$yr+1;
		$array_yr = str_split($yr2);
		$nxtyr=$array_yr[2].''.$array_yr[3];
		$billYear=$yr.'-'.$nxtyr;
		$inv="TIPL/V/". "$billYear". "/". "$projectid";
		$invoiceDate=date('d-m-Y');
		
		//print_r($transaction_row);exit;
		$vendor_inv_id_qry = $this->db->query("SELECT * FROM tt_exam_booking_detail WHERE 1=1 and project_id='".$this->db->escape_str($prjID)."' AND vendor_id='".$this->db->escape_str($vendorId)."' and book_flag=0 and status=1 and deleted=0")->result_array();
		
		
		include_once  APPPATH . '/vendor/mpdf/mpdf.php' ;
		$n_pdf_obj = new mPDF("'en-GB-x','A4','','',10,10,10,10,6,3");	
		
			//also keep file for authority letter and Key Receipt
			//for package
			
				$message = "";			
				$message .= '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>testpan.com</title>
</head>
<body>
<h2 style="text-align:center;"><strong>TAX INVOICE</strong></h2>
<table width="100%" border="1" cellspacing="0" style="font-size:3mm">
 
  <tr>
    <td colspan="9" valign="top"><table width="100%" height="342">
        <tr>
          <td height="24">Company Name</td>
          <td>'.$vendor_name.'</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Name</td>
          <td>'.$co_ordinator_name.'</td>
          <td>Invoice No</td>
          <td>'.$inv.'</td>
        </tr>
        <tr>
          <td height="24">&nbsp;</td>
          <td rowspan="3" valign="top">'.$vendorAddress.' <br> '.$vendor_city.', '.$vendor_state.' - '.$pincode.'</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Address</td>
          <td>Invoice Date</td>
          <td>'.$invoiceDate.'</td>
        </tr>
        <tr>
          <td height="24">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Mobile</td>
          <td>'.$vendor_mobile.'</td>
          <td>MSME [Y/N]</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Eail ID</td>
          <td>'.$vendor_email.'</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24" colspan="4"><hr></td>
        </tr>
        <tr>
          <td height="24">Bill To</td>
          <td>Testpan India Private Limited</td>
          <td>GSTIN</td>
          <td>07AAFCT9560Q1ZG</td>
        </tr>
        <tr>
          <td height="24">&nbsp;</td>
          <td>WZ-1390/7,IInd Floor, (Above MTNL Exchange)</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24">Billing Address</td>
          <td>Pankha Road,Nangal Raya, </td>
          <td>STATE</td>
          <td>DELHI - 07</td>
        </tr>
        <tr>
          <td height="24">&nbsp;</td>
          <td>New Delhi 110046, India.</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="25%" height="24">Phone No.</td>
          <td width="25%">91-11-28520481</td>
          <td width="272">&nbsp;</td>
          <td width="25%">&nbsp;</td>
        </tr>
        
      
        
    </table>    </td>
  </tr>
  <tr bordercolor="#000000" style="border:double">
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr bordercolor="#000000" style="border:double">
    <td colspan="9"><strong>Description Of Services - Infra Charges for Conducting '.ucwords($projectName).' Exam At my centre</strong></td>
  </tr>
  <tr bordercolor="#000000" style="border:double">
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr align="center" bordercolor="#000000" style="border:double">
    <td width="37%" align="center"><strong>City - Center Name</strong></td>
    <td width="9%" align="center"><strong>HSN/SAC</strong></td>
    <td width="10%" align="center"><strong>Exam Date</strong></td>
    <td width="8%" align="center"><strong>Quantity</strong></td>
    
    <td width="9%" align="center"><strong>Mode</strong></td>
    <td width="7%" align="center"><strong>Rate</strong></td>
    <td width="10%" align="center"><strong>Extra</strong></td>
    <td width="10%" align="center"><strong>Total</strong></td>
  </tr>';
  $totalGST='';
  $cm_payable='';
  $cm_total='';
  foreach($vendor_inv_id_qry as $vendor_data)
  {
  			$bookmode='';
			$bookmode=$vendor_data['cm_pay_option'];
			if($bookmode=='1'){ $pay_mode ='Candidate'; }
			if($bookmode=='2'){ $pay_mode ='System'; }
			if($bookmode=='4'){ $pay_mode ='Lumpsum'; }
  			$exam_city=$vendor_data['city_name'];
            $center_name=$vendor_data['center_name'];
  			$examDate=$vendor_data['exam_date'];
            $quantity=$vendor_data['total_seat'];
            if($bookmode=='1'){
            	 $quantity=$vendor_data['total_seat'];
            }
            if($bookmode=='2'){
             	$allbatch=array($vendor_data['batch1'], $vendor_data['batch2'], $vendor_data['batch3'], $vendor_data['batch4'], $vendor_data['batch5']);
				$quantity = max($allbatch);
            }
            if($bookmode=='4'){
            	 $quantity=$vendor_data['total_seat'];
            }
            
            $bach=$vendor_data['total_batch'];
            $vrate=$vendor_data['cm_cost'];
            $extraamt=$vendor_data['cm_extra_cost'];
            $totalAmt=$vendor_data['cm_total_amount'];

  			$totalGST=$vendor_data['cm_gst_amount'];
			$toalGST=$totalGST+$toalGST;
            
            $cm_total=$vendor_data['cm_total_amount'];
			$cm_total_amount=$cm_total_amount+$cm_total;
			
			$cm_payable=$vendor_data['cm_total_payable'];
			
			
			 if($gst_no){
				$cm_total_payable=$cm_total_payable+$cm_payable;
            } else {
				$cm_total_payable=$cm_total_amount;
            }
  
  $message .= '<tr bordercolor="#000000" style="border:double">
    <td align="center">'.ucwords($exam_city).' - '.ucwords($center_name).'</td>
    <td align="center">999295</td>
    <td align="center">'.$examDate.'</td>
    <td align="center">'.$quantity.'</td>
    
    <td align="center">'.$pay_mode.'</td>
    <td align="center">'.$vrate.'</td>
    <td align="center">'.$extraamt.'</td>
    <td align="center">'.$totalAmt.'</td>
  </tr>';
  }
  $message .= '<tr valign="middle" bordercolor="#000000" style="border:double">
    <td colspan="4" rowspan="4">&nbsp;</td>
    <td colspan="3">NET AMOUNT (INR)</td>
    <td>'.number_format($cm_total_amount, 2).'</td>
  </tr>';
  if($gst_state==7 && $gst_no!=''){
  
  $message .= '<tr bordercolor="#000000" style="border:double">
    <td colspan="3"><p>CGST @ 9% </p><p>SGST @ 9%</p><p>IGST  @ 18%</p></td>
    <td><p align="center">'.number_format(($toalGST/2), 2).'</p>
    <p align="center">'.number_format(($toalGST/2), 2).'</p>
    
    
    <p>&nbsp;</p></td>
  </tr>';
  }
  if($gst_state!=7 && $gst_no!=''){
  $message .= '<tr bordercolor="#000000" style="border:double">
    <td colspan="3"><p>CGST @ 9% </p><p>SGST @ 9%</p><p>IGST  @ 18%</p></td>
    <td><p>&nbsp;</p>
    <p>&nbsp;</p>
    
    
    <p align="center">'.number_format(($toalGST), 2).'</p></td>
  </tr>';
  }
  if($gst_no){
  $message .= '<tr bordercolor="#000000" style="border:double" align="center">
    <td colspan="3">TOTAL GST (INR)</td>
    <td>'.number_format($toalGST, 2).'</td>
  </tr>';
  } else {
	  $message .= '<tr bordercolor="#000000" style="border:double" align="center">
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
  }
  $message .= '<tr bordercolor="#000000" style="border:double">
    <td colspan="3"><strong>BILLING AMOUNT (INR)</strong></td>
    <td><div align="center">'.number_format(($cm_total_payable), 2).'</div></td>
  </tr>
  <tr bordercolor="#000000" style="border:double">
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9"><p align="center">&nbsp; </p>
     
   </td>
  </tr>
  <tr>
    <td height="218" colspan="9"><table width="100%" cellpadding="5" border="1" cellspacing="0" style="border-collapse:collapse;" >
      
      <tr>
        <td width="35%"><strong>PAN Number:</strong></td>
        <td width="35%">'.$pan.'</td>
        <td width="30%" align="center">Authorised Signatory, Stamp &amp; Date</td>
        </tr>
      <tr>
        <td><strong>GSTIN:</strong></td>
        <td>'.$gst_no.'</td>
        <td rowspan="7">&nbsp;</td>
        </tr>
      <tr>
        <td><strong>GST State Code:</strong></td>
        <td>'.$gst_state_code.'</td>
        </tr>
      <tr>

        <td><strong>Beneficiary Name:</strong></td>
        <td>'.$co_ordinator_name.'</td>
        </tr>
      <tr>
        <td><strong>Account Number:</strong></td>
        <td>'.$bank_account_number.'</td>
        </tr>
      <tr>
        <td><strong>IFSC:</strong></td>
        <td>'.$bank_account_ifsc.'</td>
        </tr>
      <tr>
        <td><strong>Bank Name:</strong></td>
        <td>'.$bank_name.'</td>
        </tr>
     
      <tr>
        
        </tr>
     
    </table></td>
  </tr>
</table>		
</body>
				</html>';
				
				$invoice_html = mb_convert_encoding($message, 'UTF-8', 'UTF-8');			
				$n_pdf_obj->setAutoBottomMargin = 'stretch';				
				$n_pdf_obj->SetHTMLFooter('<div style="width:600px; margin:auto; text-align:center; font:normal 24px Arial, Helvetica, sans-serif;">
	<p><strong> Testpan India Pvt Ltd, Pankha Road, Nangal Raya, New Delhi-110046</strong>
	</p>
</div>');	
				
				$invoiceFilePath = "invoice"."pdf";	
				//$invoiceFilePath = "invoice_".$transaction_row->id.".pdf";		
				$n_pdf_obj->WriteHTML($invoice_html);			
				//download it.
				//$this->m_pdf->pdf->Output($pdfFilePath, "D");  \
				//I: Display on Browser		
				$n_pdf_obj->Output($invoiceFilePath, "I");			
				
				//#End propcare invoice mail template
	}
	
	function client_invoice_listing(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		//echo '<br><br><br><br>QE= '.$ss="SELECT * FROM tt_center_booking_master where 1=1 and book_status=2  GROUP BY project_id, center_id";

		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$data['admin_project_info']    = $this->crud_model->search_invoice_for_client();
		$data['page_name']          = 'client_invoice_listing';
		$data['page_title']         = "Client Invoice";
		$this->load->view('backend/index', $data);
	}
	
	function download_client_invoice($prjID){
	
		if(empty($prjID)){
			echo "Transaction id is required";
			exit;
		}
		if(!is_numeric($prjID)){
			echo "invalid id, please provide numerical id";
			exit;
		}
		
		$transaction_qrys = $this->db->query("SELECT * FROM tt_exam_booking_detail WHERE 1=1 and project_id='".$this->db->escape_str($prjID)."' and book_flag=0 and status=1")->row();
	
		
		
		$client_id=$transaction_qrys->client_id;
		$prjId=$transaction_qrys->project_id;
		$assesmentName=$transaction_qrys->project_name;
		$exam_date=$transaction_qrys->exam_date;
		$exam_s_date=date("d M Y", strtotime($transaction_qrys->exam_date));
		//$exam_e_date=date("d M Y", strtotime($transaction_qrys->exam_end_date));
		$assesementDate=$exam_s_date;
		$inv_id=$transaction_qrys->id;
		
		$client_qrys = $this->db->query("SELECT * FROM tt_client WHERE 1=1 and id='".$client_id."' and deleted=0")->row();
		$cleint_name=$client_qrys->company_name;
		$client_address=$client_qrys->address;
		$client_state=get_state_name($client_qrys->state);
		$client_state_id=$client_qrys->state;
		$client_city=get_city_name($client_qrys->city);
		$client_pincode=$client_qrys->pincode;
		$client_co_ordinator=$client_qrys->co_ordinator_name;
		//$client_gst_code=$client_qrys->gst_state_code;
		$client_gst_code=get_state_name($client_qrys->gst_state_code).' - '.$client_qrys->gst_state_code;
		$client_gst_no=$client_qrys->gst_number;
		
		
	//	$transaction_qrys = $this->db->query("SELECT project_name FROM tt_center_booking_master WHERE 1=1 and project_id='".$this->db->escape_str($prjID)."'")->row();
	//	$assesmentName=$transaction_qrys->project_name;
		
		$transaction_qry = $this->db->query("SELECT * FROM tt_exam_booking_detail WHERE 1=1 and project_id='".$this->db->escape_str($prjID)."' and book_flag=0 and status=1")->result_array();
		foreach($transaction_qry as $vrows)
		{
			$project_name=$vrows['project_name'];
			$assessment_date=$vrows['exam_date'];
			
		}
		$totalGst='';
		foreach($transaction_qry as $vrows)
		{
			$totalGst=$vrows['tp_gst_amount']+$totalGst;
			//$assessment_date=$vrows['exam_start_date'];
			
		}
		$totalAmount = 0;
		$totalGst=0;
		foreach($transaction_qry as $vrows)
		{ 
			$totalAmount = $totalAmount + $vrows['tp_total_amount'];
			$totalGst=$totalGst + $vrows['tp_gst_amount'];
		}
		 $totalAmount;
		
		$totalGst;
		$totalPayable=$totalAmount+$totalGst;
		//////
		$projectid= $client_qrys->project_id;
		$examdate= $exam_date;
		$parts = explode('-', $examdate);
		$yr= $parts[0];
		$yr2=$yr+1;
		$array_yr = str_split($yr2);
		$nxtyr=$array_yr[2].''.$array_yr[3];
		$billYear=$yr.'-'.$nxtyr;
		$inv_no="TIPL/". "$billYear". "/". "$prjId";
		$invoiceDate=date('d-m-Y');
		//////
		
		
		//print_r($transaction_row);exit;
	
		include_once  APPPATH . '/vendor/mpdf/mpdf.php' ;
		$n_pdf_obj = new mPDF("'en-GB-x','A4','','',10,10,10,10,6,3");	
		
			//also keep file for authority letter and Key Receipt
			//for package
				
				$message = "";			
				$message .= '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>testpan.com</title>
</head>
<body>
<h2 style="text-align:center;"><strong>TAX INVOICE</strong></h2>
<table width="100%" border="1" cellspacing="0" style="font-size:3mm">
 
  <tr>
    <td colspan="9" valign="top"><table width="100%" height="240">
        <tr>
          <td width="249">Company</td>
          <td colspan="2">TESTPAN India Private Limited </td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Address</td>
          <td width="396">WZ -1390/7, 2nd Floor (Above MTNL Exchange Office) Pankha Road, Nangal Raya, New Delhi-110046, India</td>
          <td width="13">&nbsp;</td>

          <td colspan="2" rowspan="5" align="center"><img src="assets/images/lgtp.jpg" width="552" height="250"></td>
        </tr>
        <tr>
          <td valign="top">GSTIN</td>
          <td>07AAFCT9560Q1ZG</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">STATE Code</td>
          <td>DELHI - 07</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Email</td>
          <td>finance@testpanindia.com</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Phone No.</td>
          <td>00911128520481</td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td>Kind Attention</td>
          <td>'.ucwords($client_co_ordinator).'</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>Bill To</td>
          <td>'.ucwords($cleint_name).'</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>Billing Address</td>
          <td>'.ucwords($client_address).', <br> '.ucwords($client_state).', '.ucwords($client_city).', <br> Pin Code -'.$client_pincode.'</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>GSTIN</td>
          <td>'.$client_gst_no.'</td>
          <td>&nbsp;</td>
          <td width="239">Invoice No.</td>
          <td width="254">'.$inv_no.'</td>
        </tr>
        <tr>
          <td>STATE Code</td>
          <td>'.$client_gst_code.'</td>
          <td>&nbsp;</td>
          <td>Invoice Date.</td>
          <td>'.$invoiceDate.'</td>
        </tr>
        
      
        
    </table>    </td>
  </tr>
  
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr bordercolor="#000000" style="border:double">
    <td colspan="9"><strong>Description Of Services - Infra Charges for Conducting '.ucwords($assesmentName).' Exam At Below mention centers</strong></td>
  </tr>
  <tr bordercolor="#000000" style="border:double">
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr bordercolor="#000000" style="border:double">
    <td width="37%" align="center"><strong>City Name - Center Name</strong></td>
    <td width="9%" align="center"><strong>HSN/SAC</strong></td>
    <td width="10%" align="center" nowrap><strong>Exam Date</strong></td>
    <td width="8%" align="center" nowrap><strong>Quantity </strong></td>
  
    <td width="8%" align="center"><strong>Mode</strong></td>
    <td width="9%" align="center"><strong>Rate</strong></td>
    <td width="9%" align="center"><strong>Extra</strong></td>
    <td width="10%" align="center"><strong>Total</strong></td>
  </tr>
  <tr bordercolor="#000000" style="border:double">
    <td colspan="9">&nbsp;</td>
  </tr>';
  $toalGST='';
  $quantity='';
  foreach($transaction_qry as $vrows)
		{
    		//$book_mode=$vrows['commerical_per'];
			
			$bookmode='';
			$bookmode=$vrows['tp_pay_option'];
			if($bookmode=='1'){ $tp_Pmode ='Candidate'; }
			if($bookmode=='2'){ $tp_Pmode ='System'; }
			if($bookmode=='4'){ $tp_Pmode ='Lumpsum'; }
  			$exam_city=$vrows['city_name'];
            $center_name=$vrows['center_name'];
  			$examDate=$vrows['exam_date'];
            
            if($bookmode=='1'){
            	 $quantity=$vrows['req_book_seat'];
            }
            if($bookmode=='2'){
             	$allbatch=array($vrows['req_batch1'], $vrows['req_batch2'], $vrows['req_batch3'], $vrows['req_batch4'], $vrows['req_batch5']);
				$quantity = max($allbatch);
            }
            if($bookmode=='4'){
            	 $quantity=$vrows['req_book_seat'];
            }
            
            
            
            
            $bach=$vrows['total_batch'];
            $tpRate=$vrows['tp_cost'];
            $extraamt=$vrows['tp_extra_cost'];
            $totalAmt=$vrows['tp_total_amount'];
            
            $totalGST=$vrows['tp_gst_amount'];
			$toalGST=$totalGST+$toalGST;
            
            $totalAmt=$vrows['tp_total_amount'];
			$alltotal=$alltotal+$totalAmt;
			
			$tp_payable=$vrows['tp_total_payable'];
			$tp_total_payable_amt=$tp_total_payable+$tp_payable;
            
            if($client_gst_no){
				$tp_total_payable=$tp_total_payable_amt;
            } else {
				$tp_total_payable=$alltotal;
            }
            
  
  $message .= '<tr bordercolor="#000000" style="border:double">
    <td align="center">'.ucwords($exam_city).' - '.ucwords($center_name).' </td>
    <td align="center">999295</td>
    <td align="center">'.$examDate.'</td>
    <td align="center">'.$quantity.'</td>
    
    <td align="center">'.$tp_Pmode.'</td>
    <td align="center">'.$tpRate.'</td>
    <td align="center">'.$extraamt.'</td>
    <td align="center">'.$totalAmt.'</td>
  </tr>';
  }
  $message .= '<tr bordercolor="#000000" style="border:double">
    <td colspan="4" rowspan="4">&nbsp;</td>
    <td colspan="3">TOTAL</td>
    <td>'.number_format($alltotal, 2).'</td>
  </tr>';
  if($client_state_id==7 && $client_gst_no!=''){
	  
  $message .= '<tr bordercolor="#000000" style="border:double">
    <td colspan="3"><p>CGST @ 9%</p>
    <p>SGST @ 9%</p>
    <p>IGST  @ 18%</p></td>
    <td align="center" valign="top">
    
    <p>'.number_format(($toalGST/2), 2).'</p>
    <p>'.number_format(($toalGST/2), 2).'</p>
    
    
    <p>&nbsp;</p>
    
    </td>
  </tr>';
  }
   if($client_state_id!=7 && $client_gst_no!=''){
  $message .= '<tr bordercolor="#000000" style="border:double">
    <td colspan="3"><p>CGST @ 9%</p>
    <p>SGST @ 9%</p>
    <p>IGST  @ 18%</p></td>
    <td align="center" valign="top">
    
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    
    
    <p>'.number_format(($toalGST), 2).'</p>
    
    </td>
  </tr>';
  }
 
  $message .= '<tr bordercolor="#000000" style="border:double">';
   if($client_gst_no){  
   $message .= '<td colspan="3">TOTAL GST</td>
    <td align="center">'.$toalGST.'</td>';
	}
  $message .= '</tr>
  
  <tr bordercolor="#000000" style="border:double">
    <td colspan="3">Grand Total (A)</td>
    <td>'.number_format(($tp_total_payable), 2).'</td>
  </tr>
  <tr bordercolor="#000000" style="border:double">
    <td colspan="9">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="9"><table width="100%" cellpadding="5" border="1" cellspacing="0" style="border-collapse:collapse;" >
      
      <tr>
        <td width="35%" align="left"><div align="left">PAN Number:</div></td>
        <td width="35%">AAFCT9560Q</td>
        <td width="30%" rowspan="6" align="center" valign="top">For Testpan India Private Limited <br>
          Authorised Signatory </td>
        </tr>
      <tr>
        <td align="left"><div align="left">Beneficiary Name:</div></td>
        <td>Testpan India Private Limited</td>
        </tr>
      <tr>
        <td align="left"><div align="left">Account Number:</div></td>
        <td>916020063705845</td>
        </tr>
      <tr>

        <td align="left"><div align="left">IFSC:</div></td>
        <td>UTIB0001602</td>
        </tr>
      <tr>
        <td align="left"><div align="left">Bank Name:</div></td>
        <td>916020063705845</td>
        </tr>
      <tr>
        <td align="left"><div align="left">CIN :</div></td>
        <td>U74999DL2016PTC307238</td>
        </tr>
     
    </table></td>
  </tr>
  <tr align="center">
    <td colspan="9"><p align="center">&nbsp;</p>    </td>
  </tr>
</table>		
</body>
				</html>';
				
				$invoice_html = mb_convert_encoding($message, 'UTF-8', 'UTF-8');			
				$n_pdf_obj->setAutoBottomMargin = 'stretch';				
				$n_pdf_obj->SetHTMLFooter('<div style="width:600px; margin:auto; text-align:center; font:normal 24px Arial, Helvetica, sans-serif;">
	<p><strong> Testpan India Pvt Ltd, Pankha Road, Nangal Raya, New Delhi-110046</strong>
	</p>
</div>');	
				
				$invoiceFilePath = "invoice"."pdf";	
				//$invoiceFilePath = "invoice_".$transaction_row->id.".pdf";		
				$n_pdf_obj->WriteHTML($invoice_html);			
				//download it.
				//$this->m_pdf->pdf->Output($pdfFilePath, "D");  \
				//I: Display on Browser		
				$n_pdf_obj->Output($invoiceFilePath, "I");			
				
				//#End propcare invoice mail template
	}
	
	function cost_sheet(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 

		
		$data['admin_project_info']    = $this->crud_model->search_all_completed();
		$data['page_name']          = 'cost_sheet';
		$data['page_title']         = "Cost Sheet";
		$this->load->view('backend/index', $data);
	}
	
	function cost_sheet_detail($id=NULL){
		
		$this->session->set_userdata(array("edit_user_id" => $id));
		
		 $c_details = $this->db->query("SELECT * FROM tt_exam_booking_detail where 1=1 and project_id='".base64_decode($this->db->escape_str($id))."' and status=1 and deleted=0")->result_array();
	//	$p_details = $this->db->query("SELECT * FROM tt_center_booking where 1=1 and project_id='".base64_decode($this->db->escape_str($id))."'")->result_array();
		//echo '<br>A='.$aa="SELECT * FROM tt_exam_booking_detail where 1=1 and project_id='".base64_decode($this->db->escape_str($id))."'";
		$prj_n_details = $this->db->query("SELECT project_name FROM tt_exam_booking_detail where 1=1 AND project_id='".base64_decode($this->db->escape_str($id))."' and status=1 and deleted=0")->row();
		//exit;
		if(!$c_details){
			redirect(base_url(), 'refresh');exit;
		}
	$project_id = $_POST['project_id'];
	$project_name = $prj_n_details->project_name;
	if(trim($this->input->post('button'))=='Download Cost Sheet')
	{
		error_reporting(-1);
		set_time_limit(10000);
		$this->load->library('export');
		
		$this->db->select(" @a:=@a+1 'Serial No', ru.project_name as 'Project Name', CONCAT(ct.region_code,'-', ct.state_code,'-', ct.city_code,'-', ct.center_id) as 'Center Code', v.vendor_name as 'Vendor Name', ru.center_name as 'Center Name', ru.city_name as 'City', ru.exam_date as 'Exam Date', ru.batch1 as 'Batch1', ru.batch2 as 'Batch2', ru.batch3 as 'Batch3', ru.batch4 as 'Batch4', ru.batch5 as 'Batch5', ru.total_seat as 'Total Seat', (CASE WHEN ru.cm_pay_option = 1 THEN 'Per Candidate' WHEN ru.cm_pay_option = 2 THEN 'Per System' WHEN ru.cm_pay_option = 4 THEN 'LumpSum' END) AS 'Center Payment Mode', ru.cm_cost as 'Center Cost', ru.cm_extra_cost as 'Center Extra Cost', ru.cm_total_seat_cost+ru.cm_extra_cost as 'Center Total Cost', (CASE WHEN ru.tp_pay_option = 1 THEN 'Per Candidate' WHEN ru.tp_pay_option = 2 THEN 'Per System' WHEN ru.tp_pay_option = 4 THEN 'LumpSum' END) AS 'Testpan Payment Mode', ru.tp_cost as 'Testpan Cost', ru.tp_extra_cost as 'Testpan Extra Cost', (ru.tp_total_seat_cost+ru.tp_extra_cost) as 'Testpan Total Cost', (ru.tp_total_seat_cost+ru.tp_extra_cost)-(ru.cm_total_seat_cost+ru.cm_extra_cost) as 'Margin'", false);			
		$this->db->from('tt_exam_booking_detail ru, (SELECT @a:= 0) AS a')->join('tt_center ct', 'ru.center_id=ct.id', 'left')->join('tt_vendor v', 'ru.vendor_id=v.vendor_id', 'left');
		$this->db->where ('ru.project_id', base64_decode($this->db->escape_str($id))); 
		$this->db->where ('ru.status', 1); 
		$this->db->where ('ru.deleted', 0); 
		$this->db->order_by("ru.id", "asc"); 
		$query = $this->db->get();
		$e_data = $query->result_array();
		$aa=$project_name;
		$file_name = "Cost_Seat_".$aa.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		} 
		
		
		
		$data['prj_details'] = $c_details;
		$data['prj_n_details'] = $prj_n_details;
		$data['page_name'] = 'cost_sheet_detail';
		$data['page_title']= "Cost Sheet :  $project_name";
		$this->load->view('backend/index', $data);		
	}
	
	function password(){
		/*if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} */
		
		/*if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		$data['page_name']          = 'password';
		$data['page_title']         = "Change Password";
		$this->load->view('backend/index', $data);
	}	
	
	function password_process(){
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(!hasPageAuthorize('add_admin_user')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add admin user", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
		
		$old_pass = str_replace("'","&#8217;",trim($this->input->post('old_pass')));
		$new_pass = str_replace("'","&#8217;",trim($this->input->post('new_pass')));
		$re_new_pass = str_replace("'","&#8217;",trim($this->input->post('re_new_pass')));
		$ipaddress=$_SERVER['REMOTE_ADDR'];
		
		
		if(empty($old_pass)){
			$ar = array("status" => "fail", "error" => "Enter your old password.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
					
		if(empty($new_pass)){
			$ar = array("status" => "fail", "error" => "Enter your New Password.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($re_new_pass)){
			$ar = array("status" => "fail", "error" => "Again Enter Your New Password.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		$my_old_pass = sha1($old_pass);
		
		$check_qry = $this->db->query("select * from  tt_admin_users where 1=1 and id='".$this->session->userdata('login_user_id')."' and password='".$my_old_pass."'");
		if($check_qry->num_rows()==0){
			$ar = array("status" => "fail", "error" => "Please Enter Correct Old Password.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if($new_pass!=$re_new_pass){
			$ar = array("status" => "fail", "error" => "Password mismatch", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		else
		{		
			$my_new_pass = sha1($new_pass);
		}
		
		if($my_new_pass){
			$save_data["password"] = $my_new_pass;
		}
		$this->db->where('id',$this->session->userdata('login_user_id'));
        $result = $this->db->update('tt_admin_users',$save_data);
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			//$redirect_url = base_url()."index.php?c=admin&m=add_new_id_card_step_one&bundle_id=".$last_insert_id;
			$redirect_url = base_url()."index.php?admin/dashboard";
			$this->session->set_flashdata('message' , "Password Changed successfully");
			$ar = array("status" => "pass", "error" => "Password Changed successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function change_password_process(){
		/*if(!hasPageAuthorize('send_email_pending_center')){
			redirect(base_url(), 'refresh');exit;
		}  */ 
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$id = $this->db->escape_str(trim($this->input->post('id')));
		$password = str_replace("'","&#8217;",trim($this->input->post('password')));
		$repassword = str_replace("'","&#8217;",trim($this->input->post('repassword')));
	
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(empty($id) or !is_numeric($id)){
			$ar = array("status" => "fail", "error" => "Invalid id.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($password)){
			$ar = array("status" => "fail", "error" => "Enter New Password.", "frm_btn_id" => "submit_btn_id", "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		if(empty($repassword)){
			$ar = array("status" => "fail", "error" => "Re=enter Password .", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($password!=$repassword){
			$ar = array("status" => "fail", "error" => "Please re-enter correct password.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		$enc_pass = sha1($password);		
		
		if($enc_pass){
			$save_data["password"] = $enc_pass;
		}
		$this->db->where('id',$id);
        $result = $this->db->update('tt_admin_users',$save_data);
		if($result){
		
			$redirect_url = base_url()."index.php?admin/admin_users";
			$this->session->set_flashdata('message' , "Password Chnged successfully");
			$ar = array("status" => "pass", "error" => "Password Chnged successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "lab id code is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		//$this->session->set_flashdata('message' , "Data saved successfully");
		//redirect('index.php?admin/ministry_of_textile');
	
	}
	
	/////////////
	
	      /////Search module start///
	
	function center_listing()
    {              
       
	   ini_set('display_errors', 1);
	   error_reporting(E_ALL);
	  	  
        
		if(trim($this->input->post('button'))=='Download')
		{
				// set_time_limit(10000);
			$vendor_id = $this->input->post('vendor_id');	
			$state_id = $this->input->post('state_id');
			$city = $this->input->post('city');
			$seat_from = $this->input->post('seat_from');
			$seat_to = $this->input->post('seat_to');
			
			//$qrystr = "";	
			
						
		$this->load->library('export');
		// $this->db->select(" @a:=@a+1 'Serial No', CONCAT(ru.region_code,'-', ru.state_code,'-', ru.city_code,'-', ru.center_id) as 'Center Code', v.vendor_name as 'Vendor Name', ru.center_name as 'Center Name', ru.address as 'Center Address', ru.landmark as 'Landmark', ru.city as 'City', s.title as 'State', ru.pin_code as 'Pin Code', ru.nearest_railway_station as 'Nearest Railway Station', ru.nearest_bus_stop as 'Nearest Bus Stand', ru.cs_name as 'CS Name', ru.cs_contact_number as 'CS Mobile', ru.cs_email as 'CS Email', ru.am_name as 'AM Name', ru.am_contact_no as 'AM Mobile', ru.am_email as 'AM Email', ru.emergency_contact_no as 'Emergency Mobile', ru.landline_number as 'Landline Number', ru.td_name as 'IT Person', ru.td_contact_no as 'IT Mobile', ru.td_email as 'IT Email', ru.total_no_lab as 'Total Lab', ru.total_no_system as 'Total System', ru.parking_facility as 'Parking', ru.candidates_waiting_hall as 'Waiting Hall [Candidate]', ru.locker_facility as 'Locker',	ru.network_printer as 'Printer', ru.cctv_dvr as 'DVR', ru.power_backup_generator_kv as 'Genset [KVA]', ru.power_back_ups_kv as 'UPS [KVA]', ru.power_backup_hour as 'Backup Duration', ru.power_backup_unit as 'Backup Unit', ru.primary_isp_name as 'Primary Internet', ru.primary_isp_bband_or_lease as 'Primary Type', ru.primary_isp_speed as 'Primary Speed', ru.secondary_isp_name as 'Backup Internet', ru.secondary_isp_bband_or_lease as 'Backup Type', ru.secondary_isp_speed as 'Backup Speed', ru.type_of_center as 'Center Type', ru.created_on as 'Create Date', ru.last_modified_on as 'Last Modify', ru.center_owner as 'BMTC', lb.lab_name as 'Lab Name', lb.floor_name as 'Lab Floor', lb.no_of_computer as 'Computer in Lab', lb.no_of_ac as 'No. of AC in Lab', lb.monitor_type as 'Monitor Type in Lab', lb.operating_system as 'Operating System in Lab', lb.processor as 'Processor in Lab', lb.ram as 'RAM in Lab System', lb.hard_disk as 'Hard-disk in Lab System'", false);	
		
		// $this->db->from('tt_center ru, (SELECT @a:= 0) AS a')->join('tt_states s', 'ru.state_id=s.id', 'left')->join('tt_vendor v', 'ru.vendor_id=v.vendor_id', 'left')->join('tt_lab lb', 'ru.id=lb.center_id', 'left');
			
	//	$this->db->where_in ('ru.id', $center_id);
	
		// if($state_id){
		// 		$this->db->where_in ('ru.state_id', $state_id); 
		// } 	
		// if($state_id){
		// 		$this->db->where_in ('ru.state_id', $state_id); 
		// }
		// if($city){
		// 		$this->db->where_in ('ru.city_id', $city); 
		// }
			

		// if($seat_to){
		// 		//$this->db->where_in ('ru.total_no_system', $seat_to); 
		// 		$this->db->where('total_no_system <=', $seat_to); 
		// }
		// if($seat_from){
		// 		//$this->db->where_in ('ru.total_no_system', $seat_from); 
		// 		$this->db->where('total_no_system >=', $seat_from);  
		// }	
	
		// if($vendor_id){
		// 		$this->db->where_in ('ru.vendor_id', $vendor_id); 
		// }
	
		//if($this->session->userdata('login_user_id')!=1){
		//		$this->db->where_in('center_owner', $this->session->userdata('login_user_id'));
		//}
		
	
		
		
		// $this->db->where ('ru.deleted', 0); 
		// $this->db->order_by("ru.id", "asc"); 
		// $query = $this->db->get();
		// $e_data = $query->result_array();



		$this->db->select("
@a:=@a+1 as 'Serial No',
CONCAT(ru.region_code,'-', ru.state_code,'-', ru.city_code,'-', ru.center_id) as 'Center Code',
v.vendor_name as 'Vendor Name',
ru.center_name as 'Center Name',
ru.address as 'Center Address',
ru.landmark as 'Landmark',
ru.city as 'City',
s.title as 'State',
ru.pin_code as 'Pin Code',
ru.nearest_railway_station as 'Nearest Railway Station',
ru.nearest_bus_stop as 'Nearest Bus Stand',
ru.cs_name as 'CS Name',
ru.cs_contact_number as 'CS Mobile',
ru.cs_email as 'CS Email',
ru.am_name as 'AM Name',
ru.am_contact_no as 'AM Mobile',
ru.am_email as 'AM Email',
ru.emergency_contact_no as 'Emergency Mobile',
ru.landline_number as 'Landline Number',
ru.td_name as 'IT Person',
ru.td_contact_no as 'IT Mobile',
ru.td_email as 'IT Email',
ru.total_no_lab as 'Total Lab',
ru.total_no_system as 'Total System',
ru.parking_facility as 'Parking',
ru.candidates_waiting_hall as 'Waiting Hall [Candidate]',
ru.locker_facility as 'Locker',
ru.network_printer as 'Printer',
ru.cctv_dvr as 'DVR',
ru.power_backup_generator_kv as 'Genset [KVA]',
ru.power_back_ups_kv as 'UPS [KVA]',
ru.power_backup_hour as 'Backup Duration',
ru.power_backup_unit as 'Backup Unit',
ru.primary_isp_name as 'Primary Internet',
ru.primary_isp_bband_or_lease as 'Primary Type',
ru.primary_isp_speed as 'Primary Speed',
ru.secondary_isp_name as 'Backup Internet',
ru.secondary_isp_bband_or_lease as 'Backup Type',
ru.secondary_isp_speed as 'Backup Speed',
ru.type_of_center as 'Center Type',
ru.created_on as 'Create Date',
ru.last_modified_on as 'Last Modify',
ru.center_owner as 'BMTC',

lb.lab_names as 'Lab Name',
lb.total_computers as 'Computer in Lab',
lb.no_of_ac as 'No. of AC in Lab',

", FALSE);



$this->db->from('tt_center ru, (SELECT @a:=0) a');

$this->db->join('tt_states s','ru.state_id=s.id','left');
$this->db->join('tt_vendor v','ru.vendor_id=v.vendor_id','left');

$this->db->join("(SELECT 
        center_id,
        GROUP_CONCAT(lab_name SEPARATOR ', ') as lab_names,
        SUM(no_of_computer) as total_computers,
        sum(no_of_ac) as no_of_ac

    FROM tt_lab
    GROUP BY center_id) lb","ru.id=lb.center_id","left");

$this->db->where('ru.deleted',0);

if($state_id){
	$this->db->where_in ('ru.state_id', $state_id); 
}

if($city){
	$this->db->where_in ('ru.city_id', $city); 
}

if($seat_to){
	//$this->db->where_in ('ru.total_no_system', $seat_to); 
	$this->db->where('total_no_system <=', $seat_to); 
}
if($seat_from){
	//$this->db->where_in ('ru.total_no_system', $seat_from); 
	$this->db->where('total_no_system >=', $seat_from);  
}	

if($vendor_id){
	$this->db->where_in ('ru.vendor_id', $vendor_id); 
}

$this->db->order_by("ru.id","asc");

$query = $this->db->get();
$e_data = $query->result_array();


		// echo "<pre>"; print_r($e_data); die();
		// $aa=date('Y-m-d H:i:s');
		// $file_name = "Center_data_".$aa.".csv";
		$aa = date('Y-m-d_H-i-s');
		$file_name = "Center_data_".$aa.".xls";

		$this->export->export_as_excel($e_data, $file_name);
		
		} 
		
        $data['page_name'] = 'center_listing';
        $data['page_title'] = "Center Listing";
        $this->load->view('backend/index', $data);		
    }
		
	public function ajax_center_listing($state_id=NULL)
    {		
		if(!is_numeric($state_id)){
			$state_id = NULL;
		}
		$list = $this->crud_model->search_center_listings();		
		//echo $this->db->last_query();exit;
        $data = array();
       // $no = $_POST['start'];
        foreach ($list as $row_data) {            
             $row = array();   
			$count++;
			//$row[] = $this->db->last_query();
			$ext_labs = $this->db->query("SELECT COUNT(id) as total_exist_lab FROM tt_lab where 1=1 and center_id='".$row_data['id']."' and deleted=0")->row();
			$total_exist_lab = $ext_labs->total_exist_lab;
			
			$ext_img = $this->db->query("SELECT COUNT(id) as total_img FROM tt_center_images where 1=1 and center_id='".$row_data['id']."' and deleted=0")->row();
			$total_img = $ext_img->total_img;
			
			$ext_doc = $this->db->query("SELECT COUNT(id) as total_doc FROM tt_center_document where 1=1 and center_id='".$row_data['id']."' and deleted=0")->row();
			$total_doc = $ext_doc->total_doc;
						       
           // $row[] = $row_data['id'];
			// $row[] = $this->db->last_query();
			$row[] = $count;
            $row[] = strtoupper($row_data['region_code']."-".$row_data['state_code']."-".$row_data['city_code']."-".$row_data['center_id']);
			if($row_data['center_owner']==0){
				$row[] = 'NO <br>REGISTERED';

				}
				else{
					$row[] = 'BMTC <br>UPLOADED';	
				}
			$row[] = ucwords($row_data['center_name']);
			$row[] = ucwords($row_data['city']);
			$row[] = $row_data['total_no_system'];
		//	$row[] = '';
		//	$row[] = $row_data['total_no_system'];
			if($row_data['deleted']==0){$status='Active'; }
			if($row_data['deleted']==1){$status='In-Active'; }
			if($row_data['deleted']==2){$status='Deleted'; }
						
			$row[] = ' <a href="'.base_url().'index.php?admin/edit_center/'.$row_data['id'].'" title="Edit"  target="_blank"> &#9830; Edit Center</a><br>   <a href="'.base_url().'index.php?admin/view_center/'.$row_data['id'].'"  target="_blank" title="View"> &#9830; View Center <br></a>
			<a href="'.base_url().'index.php?admin/center_image_upload/'.$row_data['id'].'" title="Image Upload"  target="_blank" >&#9830; Upload Image <br></a> 
			<a href="'.base_url().'index.php?admin/center_video_upload/'.$row_data['id'].'" title="Video Upload"  target="_blank" >&#9830; Upload Video <br></a> 
		<a href="#" onClick="showAjaxModal(\''.base_url().'index.php?modal/popup/delete_center/'.$row_data['id'].'\');"  title="Delete">
                       &#9830; Delete Center
        </a>
		';
		$row[] = 'Image:' .$total_img.' Doc: '.$total_doc;
		
		if($row_data['center_type']=='online'){
		if($row_data['total_no_lab']==$total_exist_lab)
		{
			$row[] ='<a title="LAB Entry Full" title="Lab Full" class="btn btn-white"> <i class="entypo-stop"></i>Add Lab</a>';
		 } else { 
			 $row[] ='<a href="'.base_url().'index.php?admin/add_lab/'.$row_data['id'].'" title="Add Lab" class="btn btn-orange"> <i class="entypo-plus"></i> Lab</a>';
		 } 
		} else {
			
			$row[] ='<span> Offline Center</span>';
		}
		if($row_data['center_type']=='online'){ 
		 if($row_data['total_no_lab']!=0){
			$row[] = '<a href="'.base_url().'index.php?admin/lab_listing/'.$row_data['id'].'" title="Edit Lab" class="btn btn-orange"> <i class="entypo-pencil"></i> Lab</a>';
		} else {
			$row[] ='<a title="No LAb" class="btn btn-white">No Lab</a>';
		}
		} else {
			
			$row[] ='<span> NO LAB</span>';
		}
		
		
			
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->crud_model->count_all_searched_listings($bundle_id),
                        "recordsFiltered" => $this->crud_model->count_filtered_searched_listings($bundle_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
	///End search module
	
	function delete_center_process(){
		$submit_btn_id = $_POST['submit_btn_id'];
		$delete_id = trim($_POST['delete_id']);
		$message = trim($_POST['message']);
		if(empty($delete_id) or !is_numeric($delete_id)){
			$ar = array("status" => "fail", "error" => "Invalid id.", "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Yes");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($message)){
			$ar = array("status" => "fail", "error" => "Enter Reason for Delete Center.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		
		$save_data = array(
							"last_modified_on" => date("Y-m-d H:i:s"),
							"reason_of_delete" => $message,
							"deleted" =>1	
		);
		$this->db->where('id',$delete_id);
        $result = $this->db->update('tt_center',$save_data);
		
		$save_datas = array("deleted" => 1);
		$this->db->where('center_id',$delete_id);
        $results = $this->db->update('tt_lab',$save_datas);
		
		if($result){
			//$redirect_url = base_url()."index.php?c=admin&m=add_new_id_card_step_one&bundle_id=".$last_insert_id;
			$redirect_url = base_url()."index.php?admin/center_listing";
			$this->session->set_flashdata('message' , "Center deleted successfully");
			$ar = array("status" => "pass", "error" => "Data deleted successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Yes");			
			echo json_encode($ar);
			exit;
		}
	}
	
	
	function add_project_process(){
		
		/*	echo "<pre>";
		print_r($_POST);exit;*/

	    $rdno=rand(10,1000);
	    $project_group_id = strtotime(date('Y-m-d H:i:s')).''.$rdno; 
		
		$client_id = trim($this->input->post('client_id'));
		if($client_id){
			$cl_qry = $this->db->query("SELECT company_name FROM tt_client WHERE 1=1 AND id='".$client_id."'")->row();
			$client_name=$cl_qry->company_name;
		}
		$exam_name = trim($this->input->post('exam_name'));
		$exam_start_date = $_POST['start_date'];  
		$exam_end_date = $_POST['end_date']; 
		
		if($exam_start_date){
			//d/m/y
			$date_arm = explode("/", $exam_start_date);
			$start_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}
		if($exam_end_date){
			//d/m/y
			$date_arm = explode("/", $exam_end_date);
			$end_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}		
		$exam_type = $_POST['exam_type'];   
		if($type_of_exam=='government')
		{
			$exam_type_detail = $_POST['exam_type_detail']; 
		}
		else
		{
			$exam_type_detail = $_POST['exam_type_detail'];  
		}
		
		$exam_mode = trim($this->input->post('exam_mode'));
		if($exam_mode=='internet'){
			$inet_mode_os = trim($this->input->post('inet_mode_os'));
			$inet_mode_ram = trim($this->input->post('inet_mode_ram'));
			$inet_mode_processor = trim($this->input->post('inet_mode_processor'));
			$inet_mode_display = trim($this->input->post('inet_mode_display'));
			$inet_mode_internet_each = trim($this->input->post('inet_mode_internet_each'));
			$server_mode_os = '';
			$server_mode_ram = '';
			$server_mode_processor = '';
			$server_mode_ratio='';
			$server_mode_internet = '';
		}
		else
		{
			$server_mode_os = trim($this->input->post('server_mode_os'));
			$server_mode_ram = trim($this->input->post('server_mode_ram'));
			$server_mode_processor = trim($this->input->post('server_mode_processor'));
			$server_mode_ratio_1 = trim($this->input->post('server_mode_ratio_1'));
			$server_mode_ratio_2 = trim($this->input->post('server_mode_ratio_2'));
			$server_mode_ratio=$server_mode_ratio_1.':'.$server_mode_ratio_2;
			$server_mode_internet = trim($this->input->post('server_mode_internet'));
			$inet_mode_os ='';
			$inet_mode_ram ='';
			$inet_mode_processor = '';
			$inet_mode_display = '';
			$inet_mode_internet_each = '';
		}
		$total_batch = trim($this->input->post('total_batch'));
		$batch1 = trim($this->input->post('batch1'));
		$batch2 = trim($this->input->post('batch2'));
		$batch3 = trim($this->input->post('batch3'));
		$batch4 = trim($this->input->post('batch4'));
		$batch5 = trim($this->input->post('batch5'));
	
		$parking_facility = $_POST['parking_facility'];
		$security_guard = $_POST['security_guard'];
		$locker_facility = $_POST['locker_facility'];
		$waiting_area = $_POST['waiting_area'];
		$power_backup = $_POST['power_backup'];
		$ph_handicaped = $_POST['ph_handicaped'];
		$printer = $_POST['printer'];
		$rough_sheet = $_POST['rough_sheet'];
		$partition_in_lab = $_POST['partition_in_lab'];
		$ac_in_lab = $_POST['ac_in_lab'];
		$cctv_required = $_POST['cctv_required'];
		if($cctv_required=='yes'){
			$cctv_recording = $_POST['cctv_recording'];
		} else {
			$cctv_recording = '';
		}
		$center_suptn_ratio_1 = trim($this->input->post('center_suptn_ratio_1'));
		$center_suptn_ratio_2 = trim($this->input->post('center_suptn_ratio_2'));
		$center_suptn_ratio = $center_suptn_ratio_1.':'.$center_suptn_ratio_2;
		
		$tech_person_ratio_1 = trim($this->input->post('tech_person_ratio_1'));
		$tech_person_ratio_2 = trim($this->input->post('tech_person_ratio_2'));
		$tech_person_ratio = $tech_person_ratio_1.':'.$tech_person_ratio_2;
		
		$invigilator_ratio_1 = trim($this->input->post('invigilator_ratio_1'));
		$invigilator_ratio_2 = trim($this->input->post('invigilator_ratio_2'));
		$invigilator_ratio = $invigilator_ratio_1.':'.$invigilator_ratio_2;
		
		$security_guard_ratio_1 = trim($this->input->post('security_guard_ratio_1'));
		$security_guard_ratio_2 = trim($this->input->post('security_guard_ratio_2'));
		$security_guard_ratio = $security_guard_ratio_1.':'.$security_guard_ratio_2;
		
	    $city_name_val = $_POST['city_name_val']; 
	//	$exam_city_name = $_POST['exam_city_name'];  
	//	$exam_required_seat = $_POST['exam_required_seat'];   
	//	$exam_req_days = $_POST['exam_req_days'];   
		$cityCount=count($city_name_val);
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
	//	$slab_define = $_POST['slab_define']; 
	//	$tp_slab_from = $_POST['tp_slab_from']; 
	//	$tp_slab_to = $_POST['tp_slab_to']; 
	//	$tp_slab_amount = $_POST['tp_slab_amount']; 
	//	$ct_slab_from = $_POST['ct_slab_from']; 
	//	$ct_slab_to = $_POST['ct_slab_to']; 
	//	$ct_slab_amount = $_POST['ct_slab_amount']; 
		
	//	$tp_slab_Count=count($tp_slab_from);
	//	$ct_slab_Count=count($ct_slab_from);
		
	/*	for ($j = 0 ; $j < $tp_slab_Count; $j++)
		{
			$save_datas = array(
			"project_id" => $project_group_id,
			"slab_type" => 1,
			"slab_number" => $j+1,
			"seat_from" => str_replace("'","&#8217;",trim($tp_slab_from[$j])),
			"seat_to" => str_replace("'","&#8217;",trim($tp_slab_to[$j])),
			"amount"=> str_replace("'","&#8217;",trim($tp_slab_amount[$j])),
			"created_by" => $this->session->userdata('login_user_id'),
			"create_date" => date('Y-m-d H:i:s')
		);	
			$results = $this->db->insert('tt_testpan_rate_slab',$save_datas);
		}
		for ($m = 0 ; $m < $ct_slab_Count; $m++)
		{
			$save_datas1 = array(
			"project_id" => $project_group_id,
			"slab_type" => 2,
			"slab_number" => $m+1,
			"seat_from" => str_replace("'","&#8217;",trim($ct_slab_from[$m])),
			"seat_to" => str_replace("'","&#8217;",trim($ct_slab_to[$m])),
			"amount"=> str_replace("'","&#8217;",trim($ct_slab_amount[$m])),
			"created_by" => $this->session->userdata('login_user_id'),
			"create_date" => date('Y-m-d H:i:s')
		);	
			$results1 = $this->db->insert('tt_testpan_rate_slab',$save_datas1);
		}*/
		
			
		if(empty($client_id)){
			$ar = array("status" => "fail", "error" => "Client required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
	
		if(empty($exam_name)){
			$ar = array("status" => "fail", "error" => "Exam name required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}


for ($k = 0 ; $k < $cityCount; $k++)
{
		$state_ids='';
		$st_qry = $this->db->query("SELECT state_id FROM tt_city_master WHERE 1=1 AND city_id='$city_name_val[$k]'")->row();
		$state_ids=$st_qry->state_id;	
			
			
 $save_data = array(
			"project_id" => $project_group_id,
			"client_id" => $client_id,
			"client_name" => $client_name,
			"exam_name" => str_replace("'","&#8217;",trim($exam_name)),
			"start_date"=> $start_date,
			"end_date" => $end_date,
			"exam_type" => $exam_type,
			"exam_type_detail" => $exam_type_detail,
			"exam_mode" => $exam_mode,
			"inet_mode_os" => $inet_mode_os,
			"inet_mode_ram" => $inet_mode_ram,
			"inet_mode_processor" => $inet_mode_processor,
			"inet_mode_display" => $inet_mode_display,
			"inet_mode_internet_each" => $inet_mode_internet_each,
			"server_mode_os" => $server_mode_os,
			"server_mode_ram" => $server_mode_ram,
			"server_mode_processor" => $server_mode_processor,
			"server_mode_ratio" => $server_mode_ratio,
			"server_mode_internet" => $server_mode_internet,
			"total_batch" => $total_batch,			
			"batch1" => str_replace("'","&#8217;",trim($batch1)),
			"batch2" => str_replace("'","&#8217;",trim($batch2)),
			"batch3" => str_replace("'","&#8217;",trim($batch3)),
			"batch4" => str_replace("'","&#8217;",trim($batch4)),
			"batch5" => str_replace("'","&#8217;",trim($batch5)),
			"parking_facility" => $parking_facility,
			"security_guard" => $security_guard,
			"locker_facility" => $locker_facility,
			"waiting_area" => $waiting_area,
			"power_backup" => $power_backup,
			"ph_handicaped" => $ph_handicaped,
			"printer" => $printer,
			"rough_sheet" => $rough_sheet,
			"partition_in_lab" => $partition_in_lab,
			"ac_in_lab" => $ac_in_lab,
			"cctv_required" => $cctv_required,
			"cctv_recording" => $cctv_recording,
			"center_suptn_ratio" => $center_suptn_ratio,
			"tech_person_ratio" => $tech_person_ratio,
			"invigilator_ratio" => $invigilator_ratio,
			"security_guard_ratio" => $security_guard_ratio,
			"state_id" => $state_ids,
			"exam_city_id" => $city_name_val[$k],
			"exam_city_name" => get_city_name($city_name_val[$k]),  
		//	"exam_required_seat" => $exam_required_seat[$k],
		//	"exam_req_days" => $exam_req_days[$k],
			"created_by" => $this->session->userdata('login_user_id'),
			"created_on" => date('Y-m-d H:i:s')
		);	
		$result = $this->db->insert('tt_project_detail',$save_data);
		$last_insert_id = $this->db->insert_id();
	}	
	$projectcId=base64_encode($project_group_id);
	
		if($result){
			$redirect_url = base_url()."index.php?admin/exam_center_list/$projectcId";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
//	exit;
/*	echo "<pre>";
		print_r($_POST);exit;*/
	}
	
	
		function exam_center_list($projectcId=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
	/*	if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		} */  
		'<br>ID='.$searchId=base64_decode($projectcId);
		
		$prj_qry = $this->db->query("SELECT exam_name, client_name FROM tt_project_detail where project_id='".$searchId."'")->row();							        		
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$data['manage_project_infos'] = $this->crud_model->search_all_center($searchId);
			
		$data['page_name']          = 'exam_center_list';
		$data['page_title']         = "Center List for Exam: $prj_qry->exam_name (Client: $prj_qry->client_name)";
		$this->load->view('backend/index', $data);
	}
	
	function center_booking($projectcId=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
	/*	if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		} */  
		'<br>ID='.$searchId=base64_decode($projectcId);
		
	//	$prj_qry = $this->db->query("SELECT exam_name, client_name FROM tt_project_detail where project_id='".$searchId."'")->row();							        		
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		//$data['manage_project_infos'] = $this->crud_model->search_all_center($searchId);
			
		$data['page_name']          = 'center_booking';
		$data['page_title']         = "Schedule Center Booking";
		$this->load->view('backend/index', $data);
	}
	
	
	function center_booking_process(){
		
		/*		echo "<pre>";
		print_r($_POST);exit;*/
		
		$project_id = trim($this->input->post('project_id'));
		$projectName = trim($this->input->post('projectName'));
		$center_id = trim($this->input->post('center_id'));
		$state_id = trim($this->input->post('state_id'));
		$city_id = trim($this->input->post('city_id'));
		$center_name = trim($this->input->post('center_name'));
		$client_name = trim($this->input->post('client_name'));
		$client_id = trim($this->input->post('client_id'));
		$vendor_id = trim($this->input->post('vendor_id'));
		$vendor_name = trim($this->input->post('vendor_name'));
		
		$booking_id=$project_id;
		
		 '<br>A1='.$examdate = $this->input->post('examdate');
	//	print_r($examdate);
	//	 '<br>A2='.$book_seat_count = $this->input->post('book_seat_count');
	//	print_r($book_seat_count);
	//	 '<br>A3='.$total_batch = $this->input->post('total_batch');
	//	print_r($total_batch);
		 '<br>A4='.$batch1 = $this->input->post('batch1');
	//	print_r($batch1);
		 '<br>A5='.$batch2 = $this->input->post('batch2');
	//	print_r($batch2);
		 '<br>A6='.$batch3 = $this->input->post('batch3');
	//	print_r($batch3);
		 '<br>A7='.$batch4 = $this->input->post('batch4');
	//	print_r($batch4);
		 '<br>A8='.$batch5 = $this->input->post('batch5');
		 
		 '<br>A8='.$tp_rate_mode = $this->input->post('tp_rate_mode');
		 '<br>A8='.$tp_cost = $this->input->post('tp_cost');
		 '<br>A8='.$tp_extra = $this->input->post('tp_extra');
		 
		  '<br>A8='.$cm_rate_mode = $this->input->post('cm_rate_mode');
		 '<br>A8='.$cm_cost = $this->input->post('cm_cost');
		 '<br>A8='.$cm_extra = $this->input->post('cm_extra');
	//	print_r($batch5);
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
		

		
 '<br>Count= '.$dateCount=count($examdate);
 '<br>Count= '.$seatCount=count($book_seat_count);
for ($k = 0 ; $k < $dateCount; $k++)
{
	if($examdate[$k]!='' && $batch1[$k]!='' or $batch2[$k]!='' or $batch3[$k]!='' or $batch4[$k]!='' or $batch5[$k]!='')
	{		
			$batch='';
			 $a='';
			 $b='';
			 $c='';
			 $d='';
			 $e='';
			$totalBookedSeat='';
			if($batch1[$k]!=''){ $a=1; }
			if($batch2[$k]!=''){ $b=1; }	
			if($batch3[$k]!=''){ $c=1; }
			if($batch4[$k]!=''){ $d=1; }
			if($batch5[$k]!=''){ $e=1; }
			$batch=$a+$b+$c+$d+$e;
			$totalBookedSeat=$batch1[$k]+$batch2[$k]+$batch3[$k]+$batch4[$k]+$batch5[$k];
								
$save_data = array(
			"booking_id	" => $booking_id,
			"project_id" => $project_id,
			"project_name" => $projectName,
			"client_id" => $client_id,
			"client_name" => $client_name,
			"center_id"=> $center_id,
			"center_name" => $center_name,
			"vendor_id	" => $vendor_id,			
			"vendor_name" => $vendor_name,
			"state_id" => $state_id,
			"city_id" => $city_id,
			"city_name" => get_city_name($city_id),
			"exam_date" => $examdate[$k],
			"req_total_batch" => $batch,
			"req_batch1" => $batch1[$k],
			"req_batch2" => $batch2[$k],
			"req_batch3" => $batch3[$k],
			"req_batch4" => $batch4[$k],
			"req_batch5" => $batch5[$k],
			"req_book_seat" => $totalBookedSeat,
			"req_tp_pay_option	" => $tp_rate_mode[$k],
			"req_tp_cost" => $tp_cost[$k],
			"req_tp_extra_cost" => $tp_extra[$k],
			"req_cm_pay_option" => $cm_rate_mode[$k],
			"req_cm_cost" => $cm_cost[$k],
			"req_cm_extra_cost" => $cm_extra[$k],
			"created_on" => date('Y-m-d H:i:s'),			
			"created_by" => $this->session->userdata('login_user_id')
			
		);	
		$result = $this->db->insert('tt_exam_booking_detail',$save_data);
		$last_insert_id[] = $this->db->insert_id();	
		}
	}	
		//$booking_type_array = rtrim(implode(',', $last_insert_id), ',');
		//$booked_city=base64_encode($booking_type_array);
		$prjId=base64_encode($project_id);
			
	 	$last_insert_id = $this->db->insert_id();
		if($result){
			$redirect_url = base_url()."index.php?admin/center_booking_list/&pd=$prjId";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	 
	
	
		function center_booking_list($projectcId=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		 $projId = $_REQUEST['pd'];
		$pd=base64_decode($projId);
		
		
		
		if(trim($this->input->post('button'))=='Download Confirm Center')
	{
		 $projectId=trim($this->input->post('projectId')); 
		 
		$prj_qry = $this->db->query("SELECT project_name FROM tt_exam_booking_detail where project_id='".base64_decode($projectId)."' and deleted=0")->row();						
		$project_name=ucwords($prj_qry->project_name);
		 
		 
		error_reporting(-1);
		set_time_limit(10000);
		$this->load->library('export');
		
		$this->db->select(" @a:=@a+1 'Serial No', CONCAT(c.region_code,'-', c.state_code,'-', c.city_code,'-', c.center_id) as 'Center Code', ru.client_name as 'Client Name', ru.project_name as 'Project Name',ru.center_name as 'Center Name',c.address as 'Center Address', c.landmark as 'Landmark',  c.city as 'City', s.title as 'State', c.pin_code as 'Pincode', c.nearest_railway_station as 'Railway Station', c.distance_from_station as 'Distance', c.nearest_bus_stop as 'Bus Stand', c.distance_from_bus_stop as 'Distance', CONCAT(c.landline_country_code,'-', c.landline_area_code,'-', c.landline_number) as 'Landline Number', c.cs_name as 'CS Name', c.cs_contact_number as 'CS Mobile', c.cs_email as 'CS Email',c.am_name as 'AM Name', c.am_contact_no as 'AM Mobile', c.am_email as 'AM Email',c.td_name as 'TD Name', c.td_contact_no as 'TD Mobile', c.td_email as 'TD Email', c.total_no_system as 'Total System', c.total_no_lab as 'Total Lab',	ru.exam_date as 'Exam Date', ru.batch1 as 'Batch1',ru.batch2 as 'Batch2',ru.batch3 as 'Batch3',ru.batch4 as 'Batch4',ru.batch5 as 'Batch5', ru.total_seat as 'Total Booked', c.cctv_dvr as 'CCTV', c.parking_facility as 'Parking', c.parents_waiting_hall as 'Parents Waiting Hall', c.candidates_waiting_hall as 'Candidate waiting Hall', c.locker_facility as 'Locker', c.power_backup_generator_kv as 'Genset [KVA]', c.power_back_ups_kv as 'UPS [KVa]', c.ac_in_each_lab as 'AC in LAB', c.partitaion_each_lab as 'LAB Partition', c.primary_isp_name as 'Primary ISP Name', c.primary_isp_bband_or_lease as 'Primary ISP Type',c.primary_isp_speed as 'Primary ISP Speed',c.secondary_isp_name as 'Secondary ISP Name',c.secondary_isp_bband_or_lease as 'Secondary ISP Type',c.secondary_isp_speed as 'Secondary ISP Speed',c.secondary_isp_speed as 'Secondary ISP Speed',(CASE WHEN ru.status = 1 THEN 'Confirmed' WHEN ru.status = 0 THEN 'Pending' END) AS 'Booking Status'", false);		
			$this->db->from('tt_exam_booking_detail ru, (SELECT @a:= 0) AS a')->join('tt_center c', 'ru.center_id=c.id', 'left')->join('tt_states s', 'c.state_id=s.id', 'left');
			
				
			
			
			
		//	$this->db->from('tt_exam_booking_detail ru, (SELECT @a:= 0) AS a')->join('tt_center c', 'ru.center_id=c.id', 'left')->join('tt_states s', 'c.state_id=s.id', 'left');
		$this->db->where ('ru.project_id', base64_decode($projectId)); 
		$this->db->where ('ru.status', 1); 
		$this->db->where ('ru.book_flag', 0); 
		$this->db->where ('ru.deleted', 0); 
		$this->db->order_by("ru.id", "asc"); 
		$query = $this->db->get();
	//	echo $this->db->last_query();exit;
		$e_data = $query->result_array();
		$aa=$project_name;
		$file_name = "Project_".$aa.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		} 
		
		if(trim($this->input->post('button'))=='Download Lab Detail')
	{
		 $projectId=trim($this->input->post('projectId')); 
		 
		$prj_qry = $this->db->query("SELECT project_name FROM tt_exam_booking_detail where project_id='".base64_decode($projectId)."' and deleted=0")->row();						
		$project_name=ucwords($prj_qry->project_name);
		 
		
		error_reporting(-1);
		set_time_limit(10000);
		$this->load->library('export');
		
		$this->db->select(" @a:=@a+1 'Serial No', CONCAT(c.region_code,'-', c.state_code,'-', c.city_code,'-', c.center_id) as 'Center Code', ru.client_name as 'Client Name', ru.project_name as 'Project Name',ru.center_name as 'Center Name', c.city as 'City', s.title as 'State', c.total_no_system as 'Total System', l.lab_name as 'Lab Name', l.floor_name as 'Floor Name', l.no_of_computer as 'Lab System', l.no_of_cctv_each_lab as 'Total CCTV', l.ups_connected as 'UPS Connected', l.partitation as 'Partitation', l.operating_system as 'Operating System',l.processor as 'Processor', l.ram as 'RAM', l.hard_disk as 'HardDisk', l.monitor_type as 'Monitor Type', l.no_of_ethernet_switch as 'Switch Count', l.ehternet_swtch_company as 'Switch Company',  l.no_of_port_eth_switch as 'Switch Port',	l.switch_manage_status as 'Switch Managegable', l.model_no_etherbet_swtch as 'Switch Model No', l.lan_speed as 'Lan Speed',l.no_of_ac as 'No of AC', l.no_of_fan as 'Fan'", false);		
			$this->db->from('tt_exam_booking_detail ru, (SELECT @a:= 0) AS a')->join('tt_center c', 'ru.center_id=c.id', 'left')->join('tt_states s', 'c.state_id=s.id', 'left')->join('tt_lab l', 'c.id=l.center_id', 'left');
			
				
			
			
			
		//	$this->db->from('tt_exam_booking_detail ru, (SELECT @a:= 0) AS a')-> join('tt_center c', 'ru.center_id=c.id', 'left')->join('tt_states s', 'c.state_id=s.id', 'left');
		$this->db->where ('ru.project_id', base64_decode($projectId)); 
		$this->db->where ('ru.status', 1); 
		$this->db->where ('ru.book_flag', 0); 
		$this->db->where ('ru.deleted', 0); 
		$this->db->where ('l.deleted', 0); 
		$this->db->group_by('l.id');
		//$this->db->order_by("c.id", "asc"); 
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$e_data = $query->result_array();
		$aa=$project_name;
		$file_name = "Lab_for_".$aa.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		} 
		
		
	/*	if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		} */  
		$projectId=base64_decode($projId);
	    $prj_qry = $this->db->query("SELECT id, project_name FROM tt_exam_booking_detail where project_id='".$projectId."' and deleted=0")->row();							        $project_name=ucwords($prj_qry->project_name);	
		
		$data['booked_exam_list_data'] = $this->crud_model->search_booking_project($projectId);
			
		$data['page_name']          = 'center_booking_list';
		$data['page_title']         = "Project : $project_name, Center Booking Listing";
		$this->load->view('backend/index', $data);
	}
	
	function booking_confirm_popup_process(){
		/*echo "<pre>";
		print_r($_POST);exit;
		*/
		
		$id = $_POST['id']; 
		$project_id = $_POST['project_id'];
		$prjId=base64_encode($project_id);
	
		$project_name = $_POST['project_name'];
		$client_id = $_POST['client_id'];
		$booking_id = $_POST['booking_id'];
		$state_id = $_POST['state_id'];
		$city_id = $_POST['city_id'];
		$city_name = $_POST['city_name'];
		$center_id = $_POST['center_id'];
		$exam_date = $_POST['exam_date'];
		
		$book_seat = $_POST['book_seat'];
		$batch1 = $_POST['batch1'];
		$batch2 = $_POST['batch2'];
		$batch3 = $_POST['batch3'];
		$batch4 = $_POST['batch4'];
		$batch5 = $_POST['batch5'];
		$avialable_seat = $_POST['avialable_seat'];
		
		$bookSeat=$batch1+$batch2+$batch3+$batch4+$batch5;
		$gst_prct=18;
		$allbatch=array($batch1, $batch2, $batch3, $batch4, $batch5);
		$max_seat_value = max($allbatch);
		$batchCount='';
		$a='';
		$b='';
		$c='';
		$d='';
		$e='';
		if($batch1!=''){ $a=1; }
		if($batch2!=''){ $b=1; }	
		if($batch3!=''){ $c=1; }
		if($batch4!=''){ $d=1; }
		if($batch5!=''){ $e=1; }
		$batchCount=$a+$b+$c+$d+$e;
		
	//	$avialable_seat = $_POST['avialable_seat'];
		
		/*if($avialable_seat<$bookSeat){
			$ar = array("status" => "fail", "error" => "Seat Not Available for Booking.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	*/
		
		$tp_extra_amount = $_POST['tp_extra_amount'];
		$cm_extra_amount = $_POST['cm_extra_amount'];

		$tp_paymode = $_POST['tp_paymode'];
		if($tp_paymode==1){												//candidate
			$tp_final_amount = $_POST['tp_candidate_amount'];
			$tp_system_amount='';
			$tp_lumpsum='';
			$tp_total_seat_cost=$bookSeat*$tp_final_amount;
			$tp_total=($bookSeat*$tp_final_amount)+$tp_extra_amount;
			$tp_gst_amount=$tp_total*$gst_prct/100;
			$tp_payable_amount=$tp_total+$tp_gst_amount;
			
		}
		if($tp_paymode==2){												//system
			$tp_final_amount = $_POST['tp_system_amount'];
			$max_seat_value = $max_seat_value;
			$tp_candidate_amount='';
			$tp_lumpsum='';
			$tp_total_seat_cost=$max_seat_value*$tp_final_amount;
			$tp_total=($max_seat_value*$tp_final_amount)+$tp_extra_amount;
			$tp_gst_amount=$tp_total*$gst_prct/100;
			$tp_payable_amount=$tp_total+$tp_gst_amount;
		}
		if($tp_paymode==4){												//lumpsum
			$tp_final_amount = $_POST['tp_lumpsum_amount'];
			//$max_seat_value = $_POST['max_seat_value'];
			$tp_candidate_amount='';
			$tp_slabrate='';
			$tp_slab_id='';
			$tp_total_seat_cost=$tp_final_amount;
			$tp_total=$tp_final_amount+$tp_extra_amount;
			$tp_gst_amount=$tp_total*$gst_prct/100;
			$tp_payable_amount=$tp_total+$tp_gst_amount;
		}
		
		
		$cm_paymode = $_POST['cm_paymode'];
		if($cm_paymode==1){												//candidate
			$cm_final_amount = $_POST['cm_candidate_amount'];
			$cm_system_amount='';
			$tpcm_lumpsum='';
			$cm_total_seat_cost=$bookSeat*$cm_final_amount;
			$cm_total=($bookSeat*$cm_final_amount)+$cm_extra_amount;
			$cm_gst_amount=$cm_total*$gst_prct/100;
			$cm_payable_amount=$cm_total+$cm_gst_amount;
		}
		if($cm_paymode==2){
			$cm_final_amount = $_POST['cm_system_amount'];
			$max_seat_value = $max_seat_value;
			$cm_candidate_amount='';
			$tpcm_lumpsum='';
			$cm_total_seat_cost=$max_seat_value*$cm_final_amount;
			$cm_total=($max_seat_value*$cm_final_amount)+$cm_extra_amount;
			$cm_gst_amount=$cm_total*$gst_prct/100;
			$cm_payable_amount=$cm_total+$cm_gst_amount;
		}
		if($cm_paymode==4){
			$cm_final_amount = $_POST['cm_lumpsum_amount'];
			//$max_seat_value = $_POST['max_seat_value'];
			$cm_candidate_amount='';
			$cm_system_amount='';
			$cm_total_seat_cost=$cm_final_amount;
			$cm_total=$cm_final_amount+$cm_extra_amount;
			$cm_gst_amount=$cm_total*$gst_prct/100;
			$cm_payable_amount=$cm_total+$cm_gst_amount;
		}
		$status = $_POST['status'];
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
		
		
		if(empty($tp_paymode)){
			$ar = array("status" => "fail", "error" => "Select Booking Mode.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		if(empty($cm_paymode)){
			$ar = array("status" => "fail", "error" => "Select Booking Mode.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($status)){
			$ar = array("status" => "fail", "error" => "Status required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if($status=='1'){
			$cofirm_date=date('Y-m-d H:i:s');
			$cofirm_by_user=$this->session->userdata('login_user_id');
			$statusval=$status;
		}
		else
		{
			$cofirm_date='';
			$cofirm_by_user='';
			$statusval='0';
		}
		
		$save_data = array(
			"total_batch" => $batchCount,
			"batch1" => $batch1,
			"batch2" => $batch2,
			"batch3" => $batch3,
			"batch4" => $batch4,
			"batch5" => $batch5,
			"total_seat" => $bookSeat,
			"tp_pay_option" => $tp_paymode,
			"tp_cost" => $tp_final_amount,
			"tp_total_seat_cost" => $tp_total_seat_cost,
			"tp_extra_cost" => $tp_extra_amount,
			"tp_total_amount" => $tp_total,
			"tp_gst_amount" => $tp_gst_amount,
			"tp_total_payable" => $tp_payable_amount,
			"cm_pay_option" => $cm_paymode,
			"cm_cost" => $cm_final_amount,
			"cm_total_seat_cost" => $cm_total_seat_cost,
			"cm_extra_cost" => $cm_extra_amount,
			"cm_total_amount" => $cm_total,
			"cm_gst_amount" => $cm_gst_amount,
			"cm_total_payable" => $cm_payable_amount,
			"status" => $statusval,
			"cofirm_date" =>$cofirm_date,
			"confirm_by" =>$cofirm_by_user 
		);	
		//echo $this->db->last_query();exit;
		$this->db->where('id',$id);
        $result = $this->db->update('tt_exam_booking_detail',$save_data);
		
		
		if($client_id==52){
			
			//center Details
			$bookSeat;
			
			$center_qry = $this->db->query("SELECT country_id, state_id, city_id, center_name,address,address_second,landmark,pin_code, mobile_no FROM tt_center where id='".$center_id."'")->row();						       
			$country_id=$center_qry->country_id;
			$country_name = $this->common_options->get_country_name($center_qry->country_id);
			$state_id=$center_qry->state_id;
			$state_name = $this->common_options->get_state_name($center_qry->state_id);
			$city_id=$center_qry->city_id;
			$city_name = $this->common_options->get_city_name($center_qry->city_id);
			$center_name=ucwords($center_qry->center_name);
			$address=ucwords($center_qry->address);
			$address_second=ucwords($center_qry->address_second);
			$landmark=ucwords($center_qry->landmark);
			$pin_code=ucwords($center_qry->pin_code);	
			$mobile_no=$center_qry->mobile_no;	
			
			$save_data = array(
								"client_id" => $client_id,
								"booking_id" => $booking_id,
								"project_id" => $project_id,
								"project_name" => $project_name,
								"center_id" => $center_id,
								"center_name" => $center_name,
								"center_address" => $address, 
								"second_address" => $address_second, 
								"landmark" => $landmark, 
								"contact_number" => $mobile_no, 
								"state_id" => $state_id,
								"state_name" => $state_name,
								"city_id" => $city_id,
								"city_name" => $city_name,
								"pincode" => $pin_code,
								"exam_date" => $exam_date,
								"total_seat" => $bookSeat,
								"total_batch" => $batchCount,
								"status" => 1,
								"doe" =>$cofirm_date,
								"added_by" =>$cofirm_by_user 
						);	
					$results = $this->db->insert('tt_anglo_booking',$save_data);
					$last_insert_id = $this->db->insert_id();	
			
		}
		
		if($result){
			$redirect_url = base_url()."index.php?admin/center_booking_list/&pd=$prjId";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function manage_project(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		$data['all_project_info']    = $this->crud_model->select_all_project();
		//echo $this->db->last_query();exit;
		$data['page_name']          = 'manage_project';
		$data['page_title']         = "All Project";
		$this->load->view('backend/index', $data);
	}
	
	function view_project($projectcId=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		$projId = $_REQUEST['pd'];
		$projectId=base64_decode($projId);
	    $prj_qry = $this->db->query("SELECT id, project_name FROM tt_exam_booking_detail where project_id='".$projectId."' and deleted=0")->row();							        $project_name=ucwords($prj_qry->project_name);	
		
		$data['view_exam_list_data'] = $this->crud_model->view_booking_project($projectId);
			
		$data['page_name']          = 'view_project';
		$data['page_title']         = " Project Detail : $project_name";
		$this->load->view('backend/index', $data);
	}
	
	
	
	function cancil_exam_process(){
		
		$id = $_POST['id'];
		$project_id = base64_encode($_POST['project_id']);
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
		$save_data = array(
			"cofirm_date" => date('Y-m-d H:i:s'),
			"confirm_by" => $this->session->userdata('login_user_id'),
			"deleted" => 1
			
		);	
		$this->db->where('id',$id);
        $result = $this->db->update('tt_exam_booking_detail',$save_data);
		if($result){
			//unset session id
			//$this->session->unset_userdata('edit_user_id');			  
			$redirect_url = base_url()."index.php?admin/center_booking_list/&pd=$project_id";
			$this->session->set_flashdata('message' , "Exam Cancel successfully");
			$ar = array("status" => "pass", "error" => "Exam Cancel successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	function confrm_and_close_exam_process(){
		
		$pid = $_POST['pid'];
		$project_id = base64_encode($_POST['pid']);
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
		$save_data = array(
			"cofirm_date" => date('Y-m-d H:i:s'),
			"confirm_by" => $this->session->userdata('login_user_id'),
			"status" => 1
			
		);	
		$this->db->where('project_id',$pid);
		$this->db->where('status', 0);
		$this->db->where('deleted', 0);
        $result = $this->db->update('tt_exam_booking_detail',$save_data);
		if($result){
			$save_datas = array(
				"last_modified_by" => $this->session->userdata('login_user_id'),
				"last_modified_on" => date('Y-m-d H:i:s'),
				"status" => 1
				
			);	
			$this->db->where('project_id',$pid);
			$this->db->where('status', 0);
			$this->db->where('deleted', 0);
			$result = $this->db->update('tt_project_detail',$save_datas);
		}
		
		if($result){
			//unset session id
			//$this->session->unset_userdata('edit_user_id');			  
			$redirect_url = base_url()."index.php?admin/manage_project";
			$this->session->set_flashdata('message' , "Project Confirmed successfully");
			$ar = array("status" => "pass", "error" => "Project Confirmed successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function add_notification(){			
		/*if(!hasPageAuthorize('add_project')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['city_name_info']    = $this->crud_model->select_all_city();
		$data['page_name']          = 'add_notification';
		$data['page_title']         = "Create Notification";
		$this->load->view('backend/index', $data);
	}
	
	function add_notification_process(){
		
		/*	echo "<pre>";
		print_r($_POST);exit;*/

	    $rdno=rand(10,1000);
	    $project_group_ids = strtotime(date('Y-m-d H:i:s')).''.$rdno; 
		
		$exam_name = trim($this->input->post('exam_name'));
		$exam_start_date = $_POST['start_date'];  
		$req_seat = $_POST['req_seat']; 
		if($exam_start_date){
			//d/m/y
			$date_arm = explode("/", $exam_start_date);
			$start_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}
	
	    $city_name_val = $_POST['city_name_val']; 
	
		$cityCount=count($city_name_val);
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
	
		if(empty($exam_name)){
			$ar = array("status" => "fail", "error" => "Exam Name required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
	
		if(empty($exam_start_date)){
			$ar = array("status" => "fail", "error" => "Exam Date required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($city_name_val)){
			$ar = array("status" => "fail", "error" => "Exam City required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}


for ($k = 0 ; $k < $cityCount; $k++)
{
 $save_data = array(
 			"project_id"=> $project_group_ids,
			"exam_name" => str_replace("'","&#8217;",trim($exam_name)),
			"exam_date"=> $start_date,
			"exam_city_id" => $city_name_val[$k],
			"exam_city_name" => get_city_name($city_name_val[$k]),
			"required_seat" => $req_seat,
			"created_by" => $this->session->userdata('login_user_id'),
			"create_date" => date('Y-m-d H:i:s')
		);	
		$result = $this->db->insert('tt_exam_notification',$save_data);
		$last_insert_id = $this->db->insert_id();
	}	
	$projectcId=base64_encode($project_group_ids);
	
		if($result){
			$redirect_url = base_url()."index.php?admin/notification_center_list/$projectcId";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
//	exit;
/*	echo "<pre>";
		print_r($_POST);exit;*/
	}
	
	function notification_center_list($projectcId=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
	/*	if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		} */  
		'<br>ID='.$searchId=base64_decode($projectcId);
		
		$prj_qry = $this->db->query("SELECT exam_name FROM tt_exam_notification where project_id='".$searchId."'")->row();							        		
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		if(trim($this->input->post('button'))=='Send Notification')
		{
				
		  echo "hiiii";
		
		
		
		}
		
		
		
		
		$data['manage_notification_infos'] = $this->crud_model->search_center_for_notification($searchId);
			
		$data['page_name']          = 'notification_center_list';
		$data['page_title']         = "Center For Notification Exam: $prj_qry->exam_name";
		$this->load->view('backend/index', $data);
	}
	
	function manage_notification(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		$data['all_notification_info']    = $this->crud_model->select_all_notification();
		$data['page_name']          = 'manage_notification';
		$data['page_title']         = "Mobile Notifications";
		$this->load->view('backend/index', $data);
	}
	
	function view_notification($projectcIds=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//'<br>A='.$this->session->set_userdata(array("edit_user_id" => $projectcIds));
		
		$projIds = $this->db->escape_str($projectcIds);
		$project_Ids=base64_decode($projIds);
	    $prj_qry = $this->db->query("SELECT id, exam_name FROM tt_exam_notification_send where project_id='".$project_Ids."' and deleted=0")->row();
		$exam_name = $prj_qry->exam_name;	
		$data['view_notification_info']    = $this->crud_model->view_notification_status($project_Ids);
		$data['page_name']          = 'view_notification';
		$data['page_title']         = "BMTC Notification Status : $exam_name";
		$this->load->view('backend/index', $data);
	}
	
function notification_send_process(){
		/*	echo "<pre>";
		print_r($_POST);exit;*/

	    $title = trim($this->input->post('title'));
		$message = trim($this->input->post('message'));
		$notify_center = $_POST['notify'];  
		$nfCount=count($notify_center);

		//exit;
		$examn_date = $_POST['examn_date']; 
		$req_seat = $_POST['req_seat'];
		 
		$project_id = $_POST['project_id'];  
		$project_name = $_POST['project_name']; 
		
		//exit;
		if(empty($title)){
			$ar = array("status" => "fail", "error" => "Title Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		
		if(empty($message)){
			$ar = array("status" => "fail", "error" => "Message Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
	
		if(empty($notify_center)){
			$ar = array("status" => "fail", "error" => "Selection of Center Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}

for ($k = 0 ; $k < $nfCount; $k++)
{
	$custmId=$notify_center[$k];
	$centerId='';
	$notfId='';
	$mobile_number='';
	$cityId='';
	$device_token='';
	$custm_str_arr = explode ("_", $custmId);  
	$centerId=$custm_str_arr[0];
	$notfId=$custm_str_arr[1];		
	
	
	$mob_qry = $this->db->query("SELECT city_id,cs_contact_number FROM tt_center where id='".$centerId."'")->row();	
	$cityId=$mob_qry->city_id;
	$mobile_number=trim($mob_qry->cs_contact_number);	
	
	$tkn_qry = $this->db->query("SELECT * FROM tt_admin_users where mobile_phone='".$mobile_number."'")->row();	
	if(!empty($tkn_qry->device_token)){
		$device_token=$tkn_qry->device_token;
		$user_id=$tkn_qry->id;
	} else {
		$device_token="na";
		$user_id=$tkn_qry->id;
	}
//exit;
 	$save_data = array(
						"notification_id" => $notfId,
						"project_id" => $project_id,
						"exam_name" => $project_name,
						"exam_date" => $examn_date,
						"required_seat" => $req_seat,
						"device_token" => $device_token,
						"user_id" => $user_id,
						"mobile_number" => $mobile_number,
						"title"=> $title,
						"message"=> $message,
						"city_name" => get_city_name($cityId),
						"city_id" => $cityId,
						"center_id" => $centerId,
						"sender_mobile" => $mobile_number,
						"create_date" => date('Y-m-d H:i:s'),
						"created_by" => $this->session->userdata('login_user_id')
			);	
			$result = $this->db->insert('tt_exam_notification_send',$save_data);
			
			$save_datas = array(
				"send_notification" => 1,
				"status" => 1
			);	
			$this->db->where('project_id',$project_id);
			$this->db->where('exam_city_id', $cityId);
			$this->db->where('deleted', 0);
			$result = $this->db->update('tt_exam_notification',$save_datas);
			
	}	
	//$projectcId=base64_encode($project_group_id);
	
		if($result){
			$redirect_url = base_url()."index.php?admin/manage_notification";
			$this->session->set_flashdata('message' , "Notification Sent successfully");
			$ar = array("status" => "pass", "error" => "Notification Sent successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function delete_lab_process(){
		$submit_btn_id = $_POST['submit_btn_id'];
		$delete_id = trim($_POST['delete_id']);
		$center_id = trim($_POST['centerId']);
		$message = trim($_POST['message']);
		if(empty($delete_id) or !is_numeric($delete_id)){
			$ar = array("status" => "fail", "error" => "Invalid id.", "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Yes");			
			echo json_encode($ar);
			exit;
		}
		if(empty($message)){
			$ar = array("status" => "fail", "error" => "Enter Reason for Delete Lab.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		
		$save_data = array(
			"last_modify_on" => date("Y-m-d H:i:s"),
			"reason_of_delete" => $message,
			"deleted" =>1	
			
		);	
		
		$this->db->where('id',$delete_id);
        $result = $this->db->update('tt_lab',$save_data);
		
		
		if($result){
			//$redirect_url = base_url()."index.php?c=admin&m=add_new_id_card_step_one&bundle_id=".$last_insert_id;
			$redirect_url = base_url()."index.php?admin/lab_listing/$center_id";
			$this->session->set_flashdata('message' , "Lab deleted successfully");
			$ar = array("status" => "pass", "error" => "Data deleted successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Yes");			
			echo json_encode($ar);
			exit;
		}
	}
	
	
		function package(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//'<br>A='.$this->session->set_userdata(array("edit_user_id" => $projectcIds));
		
		//$projIds = $this->db->escape_str($projectcIds);
		//$project_Ids=base64_decode($projIds);
	  //  $prj_qry = $this->db->query("SELECT id, exam_name FROM tt_exam_notification_send where project_id='".$project_Ids."' and deleted=0")->row();
		//$exam_name = $prj_qry->exam_name;	
		$data['view_package_info']    = $this->crud_model->select_all_package();
		$data['page_name']          = 'package';
		$data['page_title']         = "Package";  
		$this->load->view('backend/index', $data);
	}
	
		function add_package(){			
		/*if(!hasPageAuthorize('add_vendor')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['page_name']          = 'add_package';
		$data['page_title']         = "Add Package";
		$this->load->view('backend/index', $data);
	}
	
	
	function add_package_process(){
	/*	echo "<pre>";
		print_r($_POST);exit;*/		
		$package_name = str_replace("'","&#8217;",trim($this->input->post('package_name')));
		$package_cost = str_replace("'","&#8217;",trim($this->input->post('package_cost')));
		$package_validity = str_replace("'","&#8217;",trim($this->input->post('package_validity')));
		$status = trim($this->input->post('status'));
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(!hasPageAuthorize('add_package')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add package", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
		
		if(empty($package_name))						{
			$ar = array("status" => "fail", "error" => "Please Enter Package Name.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}

		if(empty($package_cost)){
			$ar = array("status" => "fail", "error" => "Package Cost is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($package_validity)){
			$ar = array("status" => "fail", "error" => "Package Validity is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($status)){
			$ar = array("status" => "fail", "error" => "Package Status is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}

		
		$check_qry = $this->db->query("select package_id from tt_package where 1=1 and package_name='".$package_name."' and deleted=0");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Package Name exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
				
		
		$save_data = array(
			"package_name" => $package_name,
			"package_amount" => $package_cost,
			"package_validity" => $package_validity,	
			"create_date" => date("Y-m-d"),	
			"created_by" => $this->session->userdata('login_user_id'),
			"status" => trim($this->input->post('status'))
		);	
		
		$result = $this->db->insert('tt_package',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/package";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function edit_package($id = NULL){			
		if(!hasPageAuthorize('edit_package')){
			redirect(base_url(), 'refresh');exit;
		} 
		//1: Super Admin can not be updated
	//	if(empty($id) or !is_numeric($id) or $id<=1){
	//		redirect(base_url(), 'refresh');exit;
	//	}		
		$this->session->set_userdata(array("edit_user_id" => $id));
		$package_details = $this->db->query("SELECT * FROM tt_package where 1=1 AND package_id='".$this->db->escape_str($id)."'")->row();
		if(!$package_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['package_details'] = $package_details;
		$data['page_name']    = 'edit_package';
		$data['page_title']   = "Edit Package";
		$this->load->view('backend/index', $data);
	}
	
	
	function edit_package_process(){
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		if(!hasPageAuthorize('edit_package')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add package detail", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
				
		$edit_user_id  = $this->session->userdata('edit_user_id');
		if(empty($edit_user_id)){
			$ar = array("status" => "fail", "error" => "Update User id Not found", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;	
		}
		
		$package_name = str_replace("'","&#8217;",trim($this->input->post('package_name')));
		$package_cost = str_replace("'","&#8217;",trim($this->input->post('package_cost')));
		$package_validity = str_replace("'","&#8217;",trim($this->input->post('package_validity')));
		$status = trim($this->input->post('status'));
		
		if(!hasPageAuthorize('edit_package')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add/edit package", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} 
		
		if(empty($package_name))						{
			$ar = array("status" => "fail", "error" => "Please Enter Package Name.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}

		if(empty($package_cost)){
			$ar = array("status" => "fail", "error" => "Package Cost is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($package_validity)){
			$ar = array("status" => "fail", "error" => "Package Validity is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		/*if(empty($status)){
			$ar = array("status" => "fail", "error" => "Package Status is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}*/
	
	
		$check_qry = $this->db->query("select * from  tt_package where 1=1 and package_id<>'".$edit_user_id."' and package_name='".$package_name."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Package Exist!", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		$save_data = array(
			"package_name" => $package_name,
			"package_amount" => $package_cost,
			"package_validity" => $package_validity,	
			"modify_date" => date("Y-m-d"),	
			"modify_by" => $this->session->userdata('login_user_id'),
			"status" => trim($this->input->post('status'))
		);	
		
		
		$this->db->where('package_id',$edit_user_id);
        $result = $this->db->update('tt_package',$save_data);
		if($result){
			//unset session id
			$this->session->unset_userdata('edit_user_id');			
			$redirect_url = base_url()."index.php?admin/package";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	
	
	function coupon_code_generator()
    {              
	   error_reporting(-1);
	  	  
        
        $data['page_name'] = 'coupon_code_generator';
        $data['page_title'] = "Coupon Code Generator";
        $this->load->view('backend/index', $data);		
    }
	
	function generate_coupon_process(){
		/*echo "<pre>";
		print_r($_POST);exit;	*/	
			
		$user_name = $_POST['user_name'];    
		$cityCount=count($user_name);
		$validity = $_POST['validity'];    

		
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
		for ($k = 0; $k < $cityCount; $k++)
		{
			$cid=$user_name[$k];
			
			$permitted_chars = $cid.'0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$newCoupon=substr(str_shuffle($permitted_chars), 0, 10);
			
				$save_data = array(
					"coupon_code" => BMTC.$newCoupon,
					"coupon_status" => 0,
					"coupon_add" => 2,	
					"coupon_create_date" => date("Y-m-d")	
				);	
				$this->db->where('id',$cid);
				$result = $this->db->update('tt_admin_users',$save_data);
				
				if($result){
				$save_data1 = array(
				"user_id" => $cid,
				"coupon_code" => BMTC.$newCoupon,	
				"validity" => $validity,	
				"create_date" => date("Y-m-d")
				);	
				$result = $this->db->insert('tt_coupon_code',$save_data1);
				$last_insert_id = $this->db->insert_id();
			}
				
		}
		
		if($result){
			$redirect_url = base_url()."index.php?admin/coupon_code_generator";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	function membership($task = ""){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		
		if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}   
		$data['admin_user_info']    = $this->crud_model->select_membership_users();
		$data['page_name']          = 'membership';
		$data['page_title']         = "Membership";
		$this->load->view('backend/index', $data);
	}
	 //////// deleted center/////
	 
	 function deleted_center()
    {              
       
	   error_reporting(-1);
	   /*if(trim($this->input->post('button'))=='Download')
		{
				set_time_limit(10000);
			$vendor_id = $_POST['vendor_id'];	
			$state_id = $_POST['state_id'];
			$city = $_POST['city'];
			$seat_from = $_POST['seat_from'];
			$seat_to = $_POST['seat_to'];
			
			//$qrystr = "";	
			
						
		$this->load->library('export');
		$this->db->select(" @a:=@a+1 'Serial No', CONCAT(ru.region_code,'-', ru.state_code,'-', ru.city_code,'-', ru.center_id) as 'Center Code', v.vendor_name as 'Vendor Name', 
		ru.center_name as 'Center Name', ru.address as 'Center Address', ru.landmark as 'Landmark', ru.city as 'City', s.title as 'State', ru.pin_code as 'Pin Code', 
		ru.nearest_railway_station as 'Nearest Railway Station', ru.nearest_bus_stop as 'Nearest Bus Stand', ru.cs_name as 'CS Name', ru.cs_contact_number as 'CS Mobile', ru.cs_email as 'CS Email', 
		ru.am_name as 'AM Name', ru.am_contact_no as 'AM Mobile', ru.am_email as 'AM Email', ru.emergency_contact_no as 'Emergency Mobile', ru.landline_number as 'Landline Number', 
		ru.td_name as 'IT Person', ru.td_contact_no as 'IT Mobile', ru.td_email as 'IT Email', ru.total_no_lab as 'Total Lab', ru.total_no_system as 'Total System', ru.parking_facility as 'Parking', ru.candidates_waiting_hall as 'Waiting Hall [Candidate]', 
		ru.locker_facility as 'Locker',	ru.network_printer as 'Printer', ru.cctv_dvr as 'DVR', ru.power_backup_generator_kv as 'Genset [KVA]', ru.power_back_ups_kv as 'UPS [KVA]', 
		ru.power_backup_hour as 'Backup Duration', ru.power_backup_unit as 'Backup Unit', ru.primary_isp_name as 'Primary Internet', ru.primary_isp_bband_or_lease as 'Primary Type', ru.primary_isp_speed as 'Primary Speed', 
		ru.secondary_isp_name as 'Backup Internet', ru.secondary_isp_bband_or_lease as 'Backup Type', ru.secondary_isp_speed as 'Backup Speed', ru.type_of_center as 'Center Type', 
		ru.created_on as 'Create Date', ru.last_modified_on as 'Last Modify', ru.center_owner as 'BMTC'", false);	
		
		$this->db->from('tt_center ru, (SELECT @a:= 0) AS a')->join('tt_states s', 'ru.state_id=s.id', 'left')->join('tt_vendor v', 'ru.vendor_id=v.vendor_id', 'left');
			
	//	$this->db->where_in ('ru.id', $center_id);
	
		if($state_id){
				$this->db->where_in ('ru.state_id', $state_id); 
		} 	
		if($state_id){
				$this->db->where_in ('ru.state_id', $state_id); 
		}
		if($city){
				$this->db->where_in ('ru.city_id', $city); 
		}
			

		if($seat_to){
				//$this->db->where_in ('ru.total_no_system', $seat_to); 
				$this->db->where('total_no_system <=', $seat_to); 
		}
		if($seat_from){
				//$this->db->where_in ('ru.total_no_system', $seat_from); 
				$this->db->where('total_no_system >=', $seat_from);  
		}	
	
		if($vendor_id){
				$this->db->where_in ('ru.vendor_id', $vendor_id); 
		}
	
	
	
		
		
		$this->db->where ('ru.deleted', 0); 
		$this->db->order_by("ru.id", "asc"); 
		$query = $this->db->get();
		$e_data = $query->result_array();
		$aa=date('Y-m-d H:i:s');
		$file_name = "Center_data_".$aa.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		} */
		
        $data['page_name'] = 'deleted_center';
        $data['page_title'] = "Deleted Center";
        $this->load->view('backend/index', $data);		
    }
		
	public function ajax_deleted_center($state_id=NULL)
    {		
		if(!is_numeric($state_id)){
			$state_id = NULL;
		}
		$list = $this->crud_model->search_deleted_centers();		
		//echo $this->db->last_query();exit;
        $data = array();
       // $no = $_POST['start'];
        foreach ($list as $row_data) {            
             $row = array();    
			//$row[] = $this->db->last_query();
			$ext_labs = $this->db->query("SELECT COUNT(id) as total_exist_lab FROM tt_lab where 1=1 and center_id='".$row_data['id']."' and deleted=0")->row();
			$total_exist_lab = $ext_labs->total_exist_lab;
						       
           // $row[] = $row_data['id'];
			// $row[] = $this->db->last_query();
			
            $row[] = strtoupper($row_data['region_code']."-".$row_data['state_code']."-".$row_data['city_code']."-".$row_data['center_id']);
			if($row_data['center_owner']==0){
				$row[] = 'NO REGISTERED';

				}
				else{
					$row[] = 'BMTC UPLOADED';	
				}
			$row[] = ucwords($row_data['center_name']);
			$row[] = ucwords($row_data['city']);
			$row[] = $row_data['total_no_system'];
		//	$row[] = '';
		//	$row[] = $row_data['total_no_system'];
		
						
		
		
		if($row_data['reason_of_delete']!='')
		{
			$row[] = ucwords($row_data['reason_of_delete']);   
		 } else { 
			 $row[] ='';
		 } 
		
			
		
		$row[] = ' <a href="'.base_url().'index.php?admin/view_center/'.$row_data['id'].'"  target="_blank" title="View" class="btn btn-orange"> <i class="entypo-eye"></i></a>';
		
		$row[] = '<a href="#" onClick="showAjaxModal(\''.base_url().'index.php?modal/popup/restore_center/'.$row_data['id'].'\');"  title="Restore"
                       class="btn btn-danger ">
                        <i class="entypo-reply"></i> 
        </a>';
		
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->crud_model->count_all_deleted_listings($bundle_id),
                        "recordsFiltered" => $this->crud_model->count_filtered_deleted_listings($bundle_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
	 //////end ////
	 
	 function restore_center_process(){
		$submit_btn_id = $_POST['submit_btn_id'];
		$delete_id = trim($_POST['delete_id']);
		//$message = trim($_POST['message']);
		if(empty($delete_id) or !is_numeric($delete_id)){
			$ar = array("status" => "fail", "error" => "Invalid id.", "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Yes");			
			echo json_encode($ar);
			exit;
		}
		
	/*	if(empty($message)){
			$ar = array("status" => "fail", "error" => "Enter Reason for Delete Center.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	*/
		
		$save_data = array(
							"last_modified_on" => date("Y-m-d H:i:s"),
							//"reason_of_delete" => $message,
							"deleted" =>0	
		);
		$this->db->where('id',$delete_id);
        $result = $this->db->update('tt_center',$save_data);
		
		$save_datas = array("deleted" => 1);
		$this->db->where('center_id',$delete_id);
        $results = $this->db->update('tt_lab',$save_datas);
		
		if($result){
			//$redirect_url = base_url()."index.php?c=admin&m=add_new_id_card_step_one&bundle_id=".$last_insert_id;
			$redirect_url = base_url()."index.php?admin/center_listing";
			$this->session->set_flashdata('message' , "Center restored successfully");
			$ar = array("status" => "pass", "error" => "Data restored successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Yes");			
			echo json_encode($ar);
			exit;
		}
	}
	
	
	/*function exam_listing(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 

		
		$data['admin_user_info']    = $this->crud_model->select_all_exam();
		$data['page_name']          = 'exam_listing';
		$data['page_title']         = "Exam Listing";
		$this->load->view('backend/index', $data);
	}*/
	
	function exam_listing()
    {        
			if(trim($this->input->post('button'))=='Download')
		{
				set_time_limit(10000);
			$state_id = $_POST['state_id'];
			$city = $_POST['city'];
			$center_ids_list = $_POST['center_ids_list'];
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			
			//$qrystr = "";	
			
						
		$this->load->library('export');
		$this->db->select(" @a:=@a+1 'Serial No', ad.first_name as 'Booked By', ru.project_name as 'Exam Name', 
		ru.client_name as 'Client Name', ru.exam_date as 'Exam Date', CONCAT(rc.region_code,'-', rc.state_code,'-', rc.city_code,'-', rc.center_id) as 'Center Code', ru.center_name as 'Center Name', ru.city_name as 'City', s.title as 'State Name', 
		ru.total_seat as 'Booked Node', rc.total_no_system as 'Total Nodes', (rc.total_no_system - ru.total_seat) as ' Available Nodes'", false);	
		
		$this->db->from('tt_exam_booking_detail ru, (SELECT @a:= 0) AS a')->join('tt_states s', 'ru.state_id=s.id', 'left')->join('tt_center rc', 'ru.center_id=rc.id', 'left')->join('tt_admin_users ad', 'ru.created_by=ad.id', 'left');
			
	//	$this->db->where_in ('ru.id', $center_id);
	
		if($state_id){
				$this->db->where_in ('ru.state_id', $state_id); 
		} 	
		if($city){
				$this->db->where_in ('ru.city_id', $city); 
		}
		if($center_ids_list){
				$this->db->where_in ('ru.center_id', $center_ids_list); 
		}
			

	/*	if($start_date){
				$this->db->where('total_no_system <=', $seat_to); 
		}
		if($end_date){
				$this->db->where('total_no_system >=', $seat_from);  
		}	*/
	
		
		$this->db->where ('ru.deleted', 0); 
		$this->db->order_by("ru.id", "asc"); 
		$query = $this->db->get();
		$e_data = $query->result_array();
		$aa=date('Y-m-d H:i:s');
		$file_name = "Exam_data_".$aa.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		} 
	      
        $data['page_name'] = 'exam_listing';
        $data['page_title'] = "Scheduled Examination";
        $this->load->view('backend/index', $data);		
    }
		
	public function ajax_exam_listing($state_id=NULL)
    {		
		if(!is_numeric($state_id)){
			$state_id = NULL;
		}
		$list = $this->crud_model->search_exam_listings();		
		//echo $this->db->last_query();exit;
        $data = array();
       // $no = $_POST['start'];
        foreach ($list as $row_data) {            
             $row = array();    
			//$row[] = $this->db->last_query();
								       
           // $row[] = $row_data['id'];
		//	 $row[] = $this->db->last_query();
		
		$aa=$row_data['total_seat'];
		$b=$aa+$row_data['total_seat'];
			
			if($this->common_options->get_user_role_id($row_data['created_by'])=='9'){
				$row[] = 'Test Center';
			} else {
				$row[] = 'Admin';
			}
			
			   
			$row[] = ucwords($row_data['city_name']); 
			$row[] = ucwords($row_data['center_name']);
			
			$row[] = ucwords($row_data['project_name']);
			$row[] = date("d M Y", strtotime($row_data['exam_date'])); 
			$row[] = ''; 
			$row[] = $row_data['total_seat'];			
			
			$row[] ='<a href="#" onClick="showAjaxModal(\''.base_url().'index.php?modal/popup/view_exam_detail/'.$row_data['booking_id'].'\');"  title="View"
                       class="btn btn-orange "><i class="entypo-eye"></i></a>';
			
			
		//$row[] = ucwords($row_data['client_name']);
			
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->crud_model->count_all_exam_listings($bundle_id),
                        "recordsFiltered" => $this->crud_model->count_filtered_exam_listings($bundle_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
	
	function demo(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		
		if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}   
	//	$data['admin_user_info']    = $this->crud_model->select_membership_users();
		$data['page_name']          = 'demo';
		$data['page_title']         = "demo";
		$this->load->view('backend/index', $data);
	}
	
		public function load_dynamic_city_center_data(){
			$city = trim($_POST['city']);
			$ed_id = trim($_POST['ed_id']);		
			$row = $this->db->query("SELECT * from tt_city_master where 1=1 and city_id='".$this->db->escape_str($city)."'")->row();
			$ed_options = $this->common_options->center_list_options($ed_id, $city);
			echo json_encode(array("director_office_data" => (array)$row, "ed_options" => $ed_options));
		}
		
		function center_image_upload($id = NULL){			
		/*if(!hasPageAuthorize('edit_center')){
			redirect(base_url(), 'refresh');exit;
		} */
		//if(isset($_REQUEST['id'])){
			 '<br>A='.$id = trim($this->db->escape_str($id));
		//}
		$center_details = $this->db->query("SELECT * FROM tt_center where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		
		//phpinfo();exit;
		/*if(!hasPageAuthorize('add_card')){
			redirect(base_url()."index.php?admin/form_bundle_listings_to_add_card");exit;
		} */
		
		
		//now find bundle exist or or not in our database;
		$center_details = $this->crud_model->get_center_details($id);
		if(!$center_details){
			redirect(base_url()."index.php?admin/form_bundle_listings_to_add_card");exit;
		}
		
		//is any form added to this bundle
		//$data['id_card_row'] = $this->db->query("SELECT id FROM tt_center where 1=1 and id='".$id."'")->num_rows();		
		$data['center_details'] = $center_details;
		$data['page_name']          = 'center_image_upload';
		$data['page_title']         = "Upload Center Images";
		$this->load->view('backend/index', $data);
	}
	public function center_image_upload_process($id) {
        set_time_limit(0);
		$center_details = $this->crud_model->get_center_details($id);
		if (!empty($_FILES)) {
			$pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 5);
			$tempFile = $_FILES['file']['tmp_name'];
			$fileName = $pass.$_FILES['file']['name'];
		   // $targetPath = 'uploads/user_image/bundle/';
			$upload_dir = 'uploads/center_image/';
			/*if (!is_dir($upload_dir)){
				mkdir($upload_dir, 0777);
			}*/
			
			//upload
			$upload_dir .= "/";			

			
			$targetFile = $upload_dir . strtolower($fileName);
			if(move_uploaded_file($tempFile, $targetFile)){
				$file_name_ar = explode('.', basename($targetFile));
				$file_name_part1 = $file_name_ar[0];
				
				//if file name is numeric then insert it in database			
				
				if($file_name_part1){
					
						$original_user_photo = basename($targetFile);
						$save_date = array(
							"center_id" => $center_details->id,
							"center_image" => $original_user_photo,
							"doe" => date('Y-m-d H:i:s'),
							"added_by" => $this->session->userdata('login_user_id')
						);
			
						$result = $this->db->insert('tt_center_images',$save_date);
										
				}							
			}	
        }else{
			redirect(base_url()."index.php?admin/center_listing/");exit;
		}
    }
	

		
		public function createzip()
		{
			$id = $this->input->post('id');
			if($this->input->post('but_createzip1') != NULL)
			{
				 $id = $this->input->post('id');
				 $center_id = $this->input->post('center_id');
				 $imagess = $this->input->post('but_createzip1');
				 
				 foreach($imagess as $image)
				 {
					$filepath1 = FCPATH.'/uploads/center_image/'.$image;
					$this->zip->read_file($filepath1);
				 }
				 $filename = "$center_id.zip";
				 $this->zip->download($filename);
			}
			else
			{
			
			 redirect(base_url()."index.php?admin/view_center/$id");
			}
		}
		
		
		///////MANPOWER AJAX MODULE
		function manpower()
    {              	  
     
		
        $data['page_name'] = 'manpower';
        $data['page_title'] = "Manpower";
        $this->load->view('backend/index', $data);		
    }
		
	public function ajax_manpower($state_id=NULL)
    {		
		if(!is_numeric($state_id)){
			$state_id = NULL;
		}
		$list = $this->crud_model->search_manpowers();		
		//echo $this->db->last_query();exit;
        $data = array();
       // $no = $_POST['start'];
        foreach ($list as $row_data) {            
             $row = array();    
			//$row[] = $this->db->last_query();
			//$ext_labs = $this->db->query("SELECT COUNT(id) as total_exist_lab FROM tt_lab where 1=1 and center_id='".$row_data['id']."' and deleted=0")->row();
		//	$total_exist_lab = $ext_labs->total_exist_lab;
						       
           // $row[] = $row_data['id'];
			// $row[] = $this->db->last_query();
			
            $row[] = ucwords($row_data['vendor_name']);
			
			$row[] = ucwords($row_data['full_name']);
			$row[] = ucwords($row_data['contact_number']);
			$row[] = ucwords($row_data['email']);
			$row[] = ucwords($this->common_options->get_city_name($row_data['city'])).' / '.ucwords($this->common_options->get_state_name($row_data['state']));  
			
			$row[] = ucwords($row_data['experience_online_exam']);
		//	$row[] = '';
			
		
							$col_class='';
							if($row_data['deleted']==0)
							{
								$col_class="badge-active";
								$status='<div class="badge ".$col_class." style="background:#8fbc8f">Active</div>';
								// 
							}
							if($row_data['deleted']==1)
							{
								 $col_class="badge-inactive";
								 $status='<div class="badge ".$col_class." style="background:#adff2f">Inactive</div>';
								 //$status="Inactive";
								 
							}
							if($row_data['deleted']==2)
							{
								$col_class="badge-deleted";
								 $status='<div class="badge ".$col_class." style="background:#ff0000">Deleted</div>';
								// $status="Deleted";
								  
							}		
		
			
			
						
			$row[] = $status;
							$mp_type='';
							if($row_data['mp_type']==1)
							{
								 $mptype="General";
								// $col_class="badge-active";
							}
							if($row_data['mp_type']==2)
							{
								 $mptype="Freelancer";
								 //$col_class="badge-inactive";
							}
			
			$row[] = ucwords($this->common_options->get_manpower_category_name($row_data['mp_type']));
			
			$row[] ='<a href="'.base_url().'index.php?admin/edit_manpower/'.$row_data['id'].'" title="Edit" class="btn btn-orange" style="height:25px; width:35px"> <i class="entypo-pencil"></i></a>'
					.'<br><br>'.'<a href="'.base_url().'index.php?admin/view_manpower/'.$row_data['id'].'" title="View" class="btn btn-green" style="height:25px; width:35px"> <i class="entypo-eye"></i> </a>';
		
		 
		
			//$row[] = ;
		
			
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->crud_model->count_all_searched_listings_mpower($bundle_id),
                        "recordsFiltered" => $this->crud_model->count_filtered_searched_listings_mpower($bundle_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
		
		 public function load_freelancer_type(){		
		$mp_type = trim($_POST['mp_type']);
		$fl_type = "";
		if(!empty($_POST['fl_type'])){
			$fl_type = $_POST['fl_type'];
		}
		echo $this->common_options->manpower_sub_catg_option($fl_type, $mp_type);
	}
	
	function location(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		
		if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		}   
	//	$data['admin_user_info']    = $this->crud_model->select_membership_users();
		$data['page_name']          = 'location';
		$data['page_title']         = "location";
		$this->load->view('backend/index', $data);
	}
	
	
	public function state_list_options(){		
		$country_id = trim($_POST['country_id']);
		$state_id = "";
		if(!empty($_POST['state_id'])){
			$state_id = $_POST['state_id'];
		}
		echo $this->common_options->state_list_options($state_id, $country_id);
	}
	
		public function load_dynamic_state_city_data(){
		$state_id = trim($_POST['state_id']);
		$ed_id = trim($_POST['ed_id']);		
		$row = $this->db->query("SELECT * from tt_states where 1=1 and id='".$this->db->escape_str($state_id)."'")->row();
		$ed_options = $this->common_options->city_state_area_options($ed_id, $state_id);
		echo json_encode(array("director_office_data" => (array)$row, "ed_options" => $ed_options));
	}
	
	
	function manual_invoice($id = ""){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		
		 '<br>A='.$pan_card=$_REQUEST['pan_card'];
		 '<br>A='.$financial_year=$_REQUEST['financial_year'];
		 '<br>A='.$bill_date_from=$_REQUEST['bill_date_from'];
		 '<br>A='.$bill_date_to=$_REQUEST['bill_date_to'];
		//if(!hasPageAuthorize('admin_users')){
		//	redirect(base_url(), 'refresh');exit;
		//}  
		
		if(trim($this->input->post('button'))=='Download')
		{
			set_time_limit(10000);
			$pan_card=$_REQUEST['pan_card'];
			$financial_year = $_POST['financial_year'];	
			//$bill_date_from = $_POST['bill_date_from'];
		    //$bill_date_to = $_POST['bill_date_to'];
			
			$bill_date_f = $_POST['bill_date_from'];
			$bill_dates = explode("/", $bill_date_f);
			$bill_date_from = $bill_dates[2]."-".$bill_dates[0]."-".$bill_dates[1];
			
			$bill_date_t = $_POST['bill_date_to'];
			$bill_datest = explode("/", $bill_date_t);
			$bill_date_too = $bill_datest[2]."-".$bill_datest[0]."-".$bill_datest[1];
		
			//$qrystr = "";	
			
						
    		$this->load->library('export'); 
    		$this->db->select(" @a:=@a+1 'Serial No', s.financial_year as 'Financial Year', ru.bill_date as 'Bill Date', ru.payment_date as 'Payment Date', ru.payment_status as 'Payment Status', ru.exam_name as 'Exam Name', ru.exam_start_date as 'Exam Start Date', ru.exam_end_date as 'Exam End Date', 
    		ru.manpower_name as 'Manpower Name', ru.mobile_no as 'Mobile Number', ru.email_id as 'Email', ru.amount as 'Amounr', ru.beneficiary_name as 'Beneficiary Name', ru.beneficiary_account_no as 'Beneficiary Account No.', ru.bank_ifsc_code as 'IFSC Code', ru.beneficiary_pan_no as 'Pan Number', ru.remarks as 'Remarks'", false);	
    		
    		$this->db->from('tt_manual_invoice ru, (SELECT @a:= 0) AS a')->join('tt_financial_year s', 'ru.financial_year=s.id', 'left');
			
	        //	$this->db->where_in ('ru.id', $center_id);
	        
    		if($financial_year){
    				$this->db->where_in ('ru.financial_year', $financial_year); 
    		} 	
    		if($bill_date_f && $bill_date_t){
    				$this->db->where_in('ru.bill_date BETWEEN "'.$bill_date_from.'" and "'.$bill_date_too.'"');
    		}
    		$this->db->where ('ru.beneficiary_pan_no', $pan_card); 
    		$this->db->where ('ru.deleted', 0); 
    		
    		$this->db->order_by("ru.bill_date", "desc"); 
    		$query = $this->db->get();
    		$e_data = $query->result_array();
    		$aa=date('Y-m-d H:i:s');
    		$file_name = "Manpower_Manual_Invoice_".$aa.".xls";
    		$this->export->export_as_excel($e_data, $file_name);
		
		} 
		
		if(isset($bill_date_from) and !empty($bill_date_from) and isset($bill_date_to) and !empty($bill_date_to))
		{
			$bill_date_f = $_POST['bill_date_from'];
			$bill_dates = explode("/", $bill_date_f);
			$bill_date_from = $bill_dates[2]."-".$bill_dates[0]."-".$bill_dates[1];
			
			$bill_date_t = $_POST['bill_date_to'];
			$bill_datest = explode("/", $bill_date_t);
			$bill_date_too = $bill_datest[2]."-".$bill_datest[0]."-".$bill_datest[1];
			
			$qrystring.="and bill_date BETWEEN '".$bill_date_from."' and '".$bill_date_too."'";
		}

		if(isset($_POST['financial_year']) and !empty($_POST['financial_year']))
		{
			$qrystring.= "and financial_year='".$financial_year."'";
		}
		
		
		if(isset($_POST['payment_status']) && !empty($_POST['payment_status']))
        {
            $payment_status = $_POST['payment_status'];
            $qrystring .= " AND payment_status='".$payment_status."'";
        }
		
		$data['manual_invoice_info'] = $this->db->query("SELECT * FROM tt_manual_invoice where 1=1 and beneficiary_pan_no='".$id."'  $qrystring and deleted=0 ORDER BY bill_date desc")->result_array();
		

		$data['page_name']          = 'manual_invoice';
		$data['page_title']         = "Manpower Payment Details";
		$this->load->view('backend/index', $data);
		$redirect_url = base_url()."index.php?admin/manual_invoice/$pan_card";
	}
	
	/*	function search_manual_invoice($task = ""){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		
		echo '<br>A='.$pan_card=$_REQUEST['pan_card'];
		//if(!hasPageAuthorize('admin_users')){
		//	redirect(base_url(), 'refresh');exit;
		//}   
		$data['manual_invoice_info']    = $this->crud_model->select_manual_invoice($task);
		$data['page_name']          = 'manual_invoice';
		$data['page_title']         = "Manpower Payment Details";
		//$this->load->view('backend/index', $data);
		$redirect_url = base_url()."index.php?admin/manual_invoice/$pan_card";
	}*/
	
	
	
	
	
	
	
	
	
	function add_manual_invoice(){			
		/*if(!hasPageAuthorize('add_vendor')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['page_name']          = 'add_manual_invoice';
		$data['page_title']         = "Add Manpower Payment Detail";
		$this->load->view('backend/index', $data);
	}
	
	function add_manual_invoice_process(){
		
		$financial_year = trim($this->input->post('financial_year'));
		$bill_date_s = trim($this->input->post('bill_date'));
		$bill_dates = explode("/", $bill_date_s);
		$bill_date = $bill_dates[2]."-".$bill_dates[1]."-".$bill_dates[0];
		
		$payment_date_s = trim($this->input->post('payment_date'));
		$payment_dates = explode("/", $payment_date_s);
		$payment_date = $payment_dates[2]."-".$payment_dates[1]."-".$payment_dates[0];
		$exam_name = str_replace("'","&#8217;",trim($this->input->post('exam_name')));
		
		$exam_date_s = trim($this->input->post('exam_start_date'));
		$exam_dates = explode("/", $exam_date_s);
		$exam_start_date = $exam_dates[2]."-".$exam_dates[1]."-".$exam_dates[0]; 
		
		$exam_end_date_s = trim($this->input->post('exam_end_date'));
		$exam_end_dates = explode("/", $exam_end_date_s);
		$exam_end_date = $exam_end_dates[2]."-".$exam_end_dates[1]."-".$exam_end_dates[0]; 
		
		$payment_status = trim($this->input->post('payment_status'));
		
		$manpower_name = str_replace("'","&#8217;",trim($this->input->post('manpower_name')));
		$mobile_phone = trim($this->input->post('mobile_phone'));
		$email = trim($this->input->post('email'));
		$amountss = str_replace("'","&#8217;",trim($this->input->post('amount')));
		
		$beneficiary_name = str_replace("'","&#8217;",trim($this->input->post('beneficiary_name')));
		$beneficiary_account_no = str_replace("'","&#8217;",trim($this->input->post('beneficiary_account_no')));
		$ifsc_code = str_replace("'","&#8217;",trim($this->input->post('ifsc_code')));
		$beneficiary_pan_no = str_replace("'","&#8217;",trim($this->input->post('beneficiary_pan_no')));
		$remarks = str_replace("'","&#8217;",trim($this->input->post('remarks')));
		
		$today_date=date('Y-m-d H:i:s');
		
		
		$ext_labs = $this->db->query("SELECT sum(amount) as total_amount FROM tt_manual_invoice where 1=1 and beneficiary_pan_no='".$beneficiary_pan_no."' and financial_year='".$financial_year."'  and deleted=0")->row();
		
		$total_Amount=$ext_labs->total_amount;
		if($total_Amount>100000){
			$stax= $amountss*2/100;
			//$amount = $amountss + $stax;
			$amount = $amountss;
		}
		else
		{
			$stax='';
			$amount = $amountss;
		}
		//echo $this->db->last_query();exit;
		//exit;	
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_vendor')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new vendor", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		
	
		if(empty($financial_year)){
			$ar = array("status" => "fail", "error" => "Select Financial Year.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	
		if(empty($bill_date)){
			$ar = array("status" => "fail", "error" => "Select Bill Date.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($payment_date)){
			$ar = array("status" => "fail", "error" => "Select Payment Date.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($payment_status)){
			$ar = array("status" => "fail", "error" => "Select Payment Status.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($exam_name)){
			$ar = array("status" => "fail", "error" => "Exam Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($exam_start_date)){
			$ar = array("status" => "fail", "error" => "Exam Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($exam_end_date)){
			$ar = array("status" => "fail", "error" => "Exam Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($manpower_name)){
			$ar = array("status" => "fail", "error" => "Manpower name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
		
		
		 
		
					
	/*	$check_qry = $this->db->query("select vendor_id from tt_vendor where 1=1 and vendor_email='".$email."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Vendor email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}*/
		
		$save_data = array(
			"financial_year" => $financial_year,
			"bill_date" => $bill_date,
			"payment_date" => $payment_date,  
			"payment_status" => $payment_status,
			"exam_name" => $exam_name,
			"exam_start_date" => $exam_start_date,
			"exam_end_date" => $exam_end_date,
			"manpower_name"=> $manpower_name,
			"mobile_no" => $mobile_phone,
			"email_id" => $email,
			"net_amount" => $amountss,
			"service_tax" => $stax,
			"amount" => $amount,
			"beneficiary_name" => $beneficiary_name,
			"beneficiary_account_no" => $beneficiary_account_no,
			"bank_ifsc_code" => $ifsc_code,
			"beneficiary_pan_no" => $beneficiary_pan_no,
			"remarks" => $remarks,
			"added_by" => $this->session->userdata('login_user_id'),
			"doe" => date('Y-m-d H:i:s')
		);	
		
		$result = $this->db->insert('tt_manual_invoice',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/manualinvoice";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	
	function invoice_manual($task = ""){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		
		//if(!hasPageAuthorize('admin_users')){
		//	redirect(base_url(), 'refresh');exit;
		//}   
		$data['invoice_manual_info']    = $this->crud_model->select_invoice_manual();
		$data['page_name']          = 'invoice_manual';
		$data['page_title']         = "Manual Invoice Details";
		$this->load->view('backend/index', $data);
	}
	
		function add_invoice_manual(){			
		/*if(!hasPageAuthorize('add_vendor')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['page_name']          = 'add_invoice_manual';
		$data['page_title']         = "Add Manual Invoice";
		$this->load->view('backend/index', $data);
	}
	
    
    function add_invoice_manual_process()
    {
        $fy_year = $this->input->post('fy_year');
        $manpower_name = str_replace("'", "&#8217;", trim($this->input->post('manpower_name')));
        $address = str_replace("'", "&#8217;", trim($this->input->post('address')));
        $contact_number = trim($this->input->post('contact_number'));
        $email = trim($this->input->post('email'));
        $account_holder_name = str_replace("'", "&#8217;", trim($this->input->post('account_holder_name')));
        $bank_account_number = str_replace("'", "&#8217;", trim($this->input->post('bank_account_number')));
        $ifsc_code = str_replace("'", "&#8217;", trim($this->input->post('ifsc_code')));
        $pan_number = str_replace("'", "&#8217;", trim($this->input->post('pan_number')));
        $bank_name = str_replace("'", "&#8217;", trim($this->input->post('bank_name')));
        $branch_name = str_replace("'", "&#8217;", trim($this->input->post('branch_name')));
    
        $exam_date_s = $this->input->post('exam_date');
        $exam_end_date_e = $this->input->post('exam_end_date');
        $exam_name = $this->input->post('exam_name');
        $no_of_manpower = $this->input->post('no_of_manpower');
        $no_of_days = $this->input->post('no_of_days');
        $pay_mode = $this->input->post('pay_mode');
        $price_per_day = $this->input->post('price_per_day');
        $price_per_hour = $this->input->post('price_per_hour');
        $total_price = $this->input->post('total_price');
    
        $count_entry = count($this->input->post('exam_name'));
    
        $rdno = rand(10, 1000);
        $mp_group_ids = strtotime(date('H:i:s')) + $rdno;
    
        $today_date = date('Y-m-d H:i:s');
        $submit_btn_id = trim($this->input->post('submit_btn_id'));
    
        if (empty($manpower_name)) {
            $ar = array(
                "status" => "fail",
                "error" => "Enter Manpower Name.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
            echo json_encode($ar);
            exit;
        }
    
        if (empty($contact_number)) {
            $ar = array(
                "status" => "fail",
                "error" => "Enter Manpower Mobile Number.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
            echo json_encode($ar);
            exit;
        }
    
        if (empty($email)) {
            $ar = array(
                "status" => "fail",
                "error" => "Enter Manpower Email.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
            echo json_encode($ar);
            exit;
        }
    
        if ($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $ar = array(
                    "status" => "fail",
                    "error" => "Invalid email.",
                    "frm_btn_id" => $submit_btn_id,
                    "redirect" => ""
                );
                echo json_encode($ar);
                exit;
            }
        }
    
        $this->db->trans_begin();
    
        for ($m = 0; $m < $count_entry; $m++) {
    
            $save_data = array(
                "group_id" => $mp_group_ids,
                "financial_year" => $fy_year,
                "manpower_name" => $manpower_name,
                "address" => $address,
                "contact_number" => $contact_number,
                "email" => $email,
                "exam_date" => $exam_date_s[$m],
                "exam_end_date" => $exam_end_date_e[$m],
                "exam_name" => $exam_name[$m],
                "no_of_manpower" => $no_of_manpower[$m],
                "no_of_days" => $no_of_days[$m],
                "price_mode" => $pay_mode[$m],
                "price_per_day" => $price_per_day[$m],
                "price_per_hour" => $price_per_hour[$m],
                "total_price" => $total_price[$m],
                "account_holder_name" => $account_holder_name,
                "bank_account_number" => $bank_account_number,
                "ifsc_code" => $ifsc_code,
                "pan_number" => $pan_number,
                "bank_name" => $bank_name,
                "branch_name" => $branch_name,
                "added_by" => $this->session->userdata('login_user_id'),
                "doe" => date('Y-m-d H:i:s')
            );
    
            $result = $this->db->insert('tt_invoice_manual', $save_data);
    
            if (!$result) {
                $this->db->trans_rollback();
    
                $ar = array(
                    "status" => "fail",
                    "error" => "Unable to save invoice information.",
                    "frm_btn_id" => $submit_btn_id,
                    "redirect" => ""
                );
    
                echo json_encode($ar);
                exit;
            }
        }
    
        /*
         * Generate next invoice number.
         *
         * IMPORTANT:
         * Do NOT use ORDER BY id DESC here.
         * We need the highest invoice number for this financial year.
         */
        $id_qry = $this->db->query("
            SELECT MAX(
                CAST(SUBSTRING_INDEX(invoice_number, '/', -1) AS UNSIGNED)
            ) AS max_invoice
            FROM tt_invoice_manual
            WHERE financial_year = " . $this->db->escape($fy_year) . "
        ")->row();
    
        $newpo = ((int) $id_qry->max_invoice) + 1;
    
        $po_number = 'TIPL/' . $fy_year . '/' . $newpo;
    
        // Assign generated invoice number to the complete group
        $save_datas = array(
            "invoice_number" => $po_number
        );
    
        $this->db->where('group_id', $mp_group_ids);
        $result = $this->db->update('tt_invoice_manual', $save_datas);
    
        if (!$result) {
            $this->db->trans_rollback();
    
            $ar = array(
                "status" => "fail",
                "error" => "Unable to generate invoice number.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
    
            echo json_encode($ar);
            exit;
        }
    
        if ($this->db->trans_status() === FALSE) {
    
            $this->db->trans_rollback();
    
            $ar = array(
                "status" => "fail",
                "error" => "Transaction failed.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
    
            echo json_encode($ar);
            exit;
        }
    
        $this->db->trans_commit();
    
        $redirect_url = base_url() . "index.php?admin/invoice_manual";
    
        $this->session->set_flashdata(
            'message',
            "Data saved successfully"
        );
    
        $ar = array(
            "status" => "pass",
            "error" => "Data saved successfully",
            "frm_btn_id" => $submit_btn_id,
            "redirect" => $redirect_url
        );
    
        echo json_encode($ar);
        exit;
    }
	
	function confrm_and_delete_project(){
		
		$pid = $_POST['pid'];
		$project_id = base64_encode($_POST['pid']);
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
		$save_data = array(
			"cofirm_date" => date('Y-m-d H:i:s'),
			"confirm_by" => $this->session->userdata('login_user_id'),
			"deleted" => 1
			
		);	
		$this->db->where('project_id',$pid);
		$this->db->where('deleted', 0);
        $result = $this->db->update('tt_exam_booking_detail',$save_data);
		if($result){
			$save_datas = array(
				"last_modified_by" => $this->session->userdata('login_user_id'),
				"last_modified_on" => date('Y-m-d H:i:s'),
				"deleted" => 1
				
			);	
			$this->db->where('project_id',$pid);
			//$this->db->where('status', 0);
			//$this->db->where('deleted', 0);
			$result = $this->db->update('tt_project_detail',$save_datas);
		}
		
		if($result){
			//unset session id
			//$this->session->unset_userdata('edit_user_id');			  
			$redirect_url = base_url()."index.php?admin/manage_project";
			$this->session->set_flashdata('message' , "Project Deleted successfully");
			$ar = array("status" => "pass", "error" => "Project Deleted successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "An error occurred while saving data.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	
	function edit_manual_invoice($id = NULL){			
		/*if(!hasPageAuthorize('edit_client')){
			redirect(base_url(), 'refresh');exit;
		} */

		'<br>A='.$this->session->set_userdata(array("edit_user_id" => $id));
		$mp_inv_details = $this->db->query("SELECT * FROM tt_manual_invoice where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$mp_inv_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['mp_inv_details'] = $mp_inv_details;
		$data['page_name']          = 'edit_manual_invoice';
		$data['page_title']         = "Edit Manpower Payment Detail";
		$this->load->view('backend/index', $data);
	}
	
	
	function edit_manual_invoice_process(){
		/*if(!hasPageAuthorize('edit_client_process')){
			redirect(base_url(), 'refresh');exit;
		} */  
		
		
		$id = trim($this->input->post('id'));
		$financial_year = trim($this->input->post('financial_year'));
		$bill_date_s = trim($this->input->post('bill_date'));
		$bill_dates = explode("/", $bill_date_s);
		$bill_date = $bill_dates[2]."-".$bill_dates[1]."-".$bill_dates[0];
		
		$payment_date_s = trim($this->input->post('payment_date'));
		$payment_dates = explode("/", $payment_date_s);
		$payment_date = $payment_dates[2]."-".$payment_dates[1]."-".$payment_dates[0];
		
		$payment_status = trim($this->input->post('payment_status'));
		
		$exam_name = str_replace("'","&#8217;",trim($this->input->post('exam_name')));
		
		$exam_date_s = trim($this->input->post('exam_start_date'));
		$exam_dates = explode("/", $exam_date_s);
		$exam_start_date = $exam_dates[2]."-".$exam_dates[1]."-".$exam_dates[0]; 
		
		$exam_end_date_s = trim($this->input->post('exam_end_date'));
		$exam_end_dates = explode("/", $exam_end_date_s);
		$exam_end_date = $exam_end_dates[2]."-".$exam_end_dates[1]."-".$exam_end_dates[0]; 
		
		$manpower_name = str_replace("'","&#8217;",trim($this->input->post('manpower_name')));
		$mobile_phone = trim($this->input->post('mobile_phone'));
		$email = trim($this->input->post('email'));
		$amount = str_replace("'","&#8217;",trim($this->input->post('amount')));
		
		$beneficiary_name = str_replace("'","&#8217;",trim($this->input->post('beneficiary_name')));
		$beneficiary_account_no = str_replace("'","&#8217;",trim($this->input->post('beneficiary_account_no')));
		$ifsc_code = str_replace("'","&#8217;",trim($this->input->post('ifsc_code')));
		$beneficiary_pan_no = str_replace("'","&#8217;",trim($this->input->post('beneficiary_pan_no')));
		$remarks = str_replace("'","&#8217;",trim($this->input->post('remarks')));
		$today_date=date('Y-m-d H:i:s');
		$pan_card = trim($this->input->post('pan_card'));
		
			
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_vendor')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new vendor", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		if(empty($financial_year)){
			$ar = array("status" => "fail", "error" => "Select Financial Year.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	
		if(empty($bill_date)){
			$ar = array("status" => "fail", "error" => "Select Bill Date.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($payment_date)){
			$ar = array("status" => "fail", "error" => "Select Payment Date.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($exam_name)){
			$ar = array("status" => "fail", "error" => "Exam Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($exam_start_date)){
			$ar = array("status" => "fail", "error" => "Exam Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($exam_end_date)){
			$ar = array("status" => "fail", "error" => "Exam Name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($manpower_name)){
			$ar = array("status" => "fail", "error" => "Manpower name is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($email)){
			$ar = array("status" => "fail", "error" => "Email is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ar = array("status" => "fail", "error" => "Invalid email.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
				echo json_encode($ar);
				exit;
			}
		}
		
					
	/*	$check_qry = $this->db->query("select vendor_id from tt_vendor where 1=1 and vendor_email='".$email."'");
		if($check_qry->num_rows()>0){
			$ar = array("status" => "fail", "error" => "Vendor email exist.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}*/
		
		$save_data = array(
			"financial_year" => $financial_year,
			"bill_date" => $bill_date,
			"payment_date" => $payment_date, 
			"payment_status" => $payment_status, 
			"exam_name" => $exam_name,
			"exam_start_date" => $exam_start_date,
			"exam_end_date" => $exam_end_date,
			"manpower_name"=> $manpower_name,
			"mobile_no" => $mobile_phone,
			"email_id" => $email,
			"amount" => $amount,
			"beneficiary_name" => $beneficiary_name,
			"beneficiary_account_no" => $beneficiary_account_no,
			"bank_ifsc_code" => $ifsc_code,
			"beneficiary_pan_no" => $beneficiary_pan_no,
			"remarks" => $remarks,
			"updated_by" => $this->session->userdata('login_user_id'),
			"dou" => date('Y-m-d H:i:s')
		);	
		
		$this->db->where('id',$id);
		$result = $this->db->update('tt_manual_invoice',$save_data);

		if($result){
			$redirect_url = base_url()."index.php?admin/manual_invoice/$pan_card";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "lab id code is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
	}
	
	
	/////////////////manual invoice
	
		function manualinvoice()
   		{              	  
     	if(trim($this->input->post('button'))=='Download')
		{
				set_time_limit(10000);
			$financial_year = $_POST['financial_year'];	
			//$bill_date_from = $_POST['bill_date_from'];
		//$bill_date_to = $_POST['bill_date_to'];
			
			$bill_date_f = $_POST['bill_date_from'];
			$bill_dates = explode("/", $bill_date_f);
			$bill_date_from = $bill_dates[2]."-".$bill_dates[0]."-".$bill_dates[1];
			
			$bill_date_t = $_POST['bill_date_to'];
			$bill_datest = explode("/", $bill_date_t);
			$bill_date_too = $bill_datest[2]."-".$bill_datest[0]."-".$bill_datest[1];
		
			//$qrystr = "";	
			
						
		$this->load->library('export'); 
		$this->db->select(" @a:=@a+1 'Serial No', s.financial_year as 'Financial Year', ru.bill_date as 'Bill Date', ru.payment_date as 'Payment Date', ru.payment_status as 'Payment Status', ru.exam_name as 'Exam Name', ru.exam_start_date as 'Exam Start Date', ru.exam_end_date as 'Exam End Date', 
		ru.manpower_name as 'Manpower Name', ru.mobile_no as 'Mobile Number', ru.email_id as 'Email', ru.amount as 'Amounr', ru.beneficiary_name as 'Beneficiary Name', ru.beneficiary_account_no as 'Beneficiary Account No.', ru.bank_ifsc_code as 'IFSC Code', ru.beneficiary_pan_no as 'Pan Number', ru.remarks as 'Remarks'", false);	
		
		$this->db->from('tt_manual_invoice ru, (SELECT @a:= 0) AS a')->join('tt_financial_year s', 'ru.financial_year=s.id', 'left');
			
	//	$this->db->where_in ('ru.id', $center_id);
	
		if($financial_year){
				$this->db->where_in ('ru.financial_year', $financial_year); 
		} 	
		if($bill_date_f && $bill_date_t){
				$this->db->where_in('ru.bill_date BETWEEN "'.$bill_date_from.'" and "'.$bill_date_too.'"');
		}
		
		$this->db->where ('ru.deleted', 0); 
		$this->db->order_by("ru.bill_date", "desc"); 
		$query = $this->db->get();
		$e_data = $query->result_array();
		$aa=date('Y-m-d H:i:s');
		$file_name = "Manpower_Invoice_".$aa.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		} 
		
        $data['page_name'] = 'manualinvoice';
        $data['page_title'] = "Manpower Payment";
        $this->load->view('backend/index', $data);		
    }
		
	public function ajax_manpowerinvoice($state_id=NULL)
    {		
		if(!is_numeric($state_id)){
			$state_id = NULL;
		}
		$list = $this->crud_model->search_manualinvoice();		
		//echo $this->db->last_query();exit;
        $data = array();
       // $no = $_POST['start'];
	   $s=1;
	   $total_amount='';
        foreach ($list as $row_data) {   
		          
             $row = array();    
			//$row[] = $this->db->last_query();
			$ext_labs = $this->db->query("SELECT sum(amount) as total_amount FROM tt_manual_invoice where 1=1 and beneficiary_pan_no='".$row_data['beneficiary_pan_no']."' and deleted=0")->row();
			
		
			
			$total_amount = '&#x20b9;'.' '.$ext_labs->total_amount;
						       
           // $row[] = $row_data['id'];
		//	 $row[] = $this->db->last_query();
			$row[] = $s;
			$row[] = strtoupper($row_data['exam_name']);
			$row[] = strtoupper($row_data['manpower_name']);
			$row[] = ucwords($row_data['mobile_no']);
			$row[] = $total_amount; 
			
			
			
			
			
			$row[] = strtoupper($row_data['beneficiary_pan_no']);
			$row[] = date("d M Y", strtotime($row_data['bill_date']));  
			
			$row[] ='<a href="'.base_url().'index.php?admin/manual_invoice/'.$row_data['beneficiary_pan_no'].'" title="View" class="btn btn-green" style="height:25px; width:35px"> <i class="entypo-eye"></i> </a>';
		
		 
		
			//$row[] = ;
		
			
            $data[] = $row;
			$s++;
        }
 		
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->crud_model->count_all_searched_listings_mpowerInv($bundle_id),
                        "recordsFiltered" => $this->crud_model->count_filtered_searched_listings_mpowerInv($bundle_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
	
	//////////////////
	
	function invoice_detail()
   		{              	  
     	if(trim($this->input->post('button'))=='Download')
		{
				set_time_limit(10000);
			$financial_year = $_POST['financial_year'];	
			//$bill_date_from = $_POST['bill_date_from'];
		//$bill_date_to = $_POST['bill_date_to'];
			
			$bill_date_f = $_POST['bill_date_from'];
			$bill_dates = explode("/", $bill_date_f);
			$bill_date_from = $bill_dates[2]."-".$bill_dates[0]."-".$bill_dates[1];
			
			$bill_date_t = $_POST['bill_date_to'];
			$bill_datest = explode("/", $bill_date_t);
			$bill_date_too = $bill_datest[2]."-".$bill_datest[0]."-".$bill_datest[1];
		
			//$qrystr = "";	
			
						
		$this->load->library('export'); 
		$this->db->select(" @a:=@a+1 'Serial No', s.financial_year as 'Financial Year', ru.bill_date as 'Bill Date', ru.payment_date as 'Payment Date', ru.payment_status as 'Payment Status', ru.exam_name as 'Exam Name', ru.exam_start_date as 'Exam Start Date', ru.exam_end_date as 'Exam End Date', 
		ru.manpower_name as 'Manpower Name', ru.mobile_no as 'Mobile Number', ru.email_id as 'Email', ru.amount as 'Amounr', ru.beneficiary_name as 'Beneficiary Name', ru.beneficiary_account_no as 'Beneficiary Account No.', ru.bank_ifsc_code as 'IFSC Code', ru.beneficiary_pan_no as 'Pan Number', ru.remarks as 'Remarks'", false);	
		
		$this->db->from('tt_manual_invoice ru, (SELECT @a:= 0) AS a')->join('tt_financial_year s', 'ru.financial_year=s.id', 'left');
			
	//	$this->db->where_in ('ru.id', $center_id);
	
		if($financial_year){
				$this->db->where_in ('ru.financial_year', $financial_year); 
		} 	
		if($bill_date_f && $bill_date_t){
				$this->db->where_in('ru.bill_date BETWEEN "'.$bill_date_from.'" and "'.$bill_date_too.'"');
		}
		
		$this->db->where ('ru.deleted', 0); 
		$this->db->order_by("ru.bill_date", "desc"); 
		$query = $this->db->get();
		$e_data = $query->result_array();
		$aa=date('Y-m-d H:i:s');
		$file_name = "Manpower_Invoice_".$aa.".xls";
		$this->export->export_as_excel($e_data, $file_name);
		
		} 
		
        $data['page_name'] = 'invoice_detail';
        $data['page_title'] = "Manpower Payment";
        $this->load->view('backend/index', $data);		
    }
		
	public function ajax_invoice_details($state_id=NULL)
    {		
		if(!is_numeric($state_id)){
			$state_id = NULL;
		}
		$list = $this->crud_model->search_invoice_detail_ct();		
		//echo $this->db->last_query();exit;
        $data = array();
       // $no = $_POST['start'];
	   $s=1;
	   $total_amount='';
        foreach ($list as $row_data) {   
		          
             $row = array();    
			//$row[] = $this->db->last_query();
			$ext_labs = $this->db->query("SELECT sum(amount) as total_amount FROM tt_manual_invoice where 1=1 and beneficiary_pan_no='".$row_data['beneficiary_pan_no']."' and deleted=0")->row();
			
		
			
			$total_amount = '&#x20b9;'.' '.$ext_labs->total_amount;
						       
           // $row[] = $row_data['id'];
		//	 $row[] = $this->db->last_query();
			$row[] = $s;
			$row[] = ucwords($row_data['exam_name']);
			$row[] = ucwords($row_data['manpower_name']);
			$row[] = ucwords($row_data['mobile_no']);
			$row[] = $total_amount; 
			
			
			
			
			
			$row[] = ucwords($row_data['beneficiary_pan_no']);
			$row[] = date("d M Y", strtotime($row_data['bill_date']));  
			
			$row[] ='<a href="'.base_url().'index.php?admin/invoice_detail/'.$row_data['beneficiary_pan_no'].'" title="View" class="btn btn-green" style="height:25px; width:35px"> <i class="entypo-eye"></i> </a>';
		
		 
		
			//$row[] = ;
		
			
            $data[] = $row;
			$s++;
        }
 		
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->crud_model->count_all_searched_listings_invoice_details($bundle_id),
                        "recordsFiltered" => $this->crud_model->count_filtered_searched_listings_invoice_detail($bundle_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
	
	function edit_invoice_manual($id = NULL){			
		/*if(!hasPageAuthorize('edit_invoice_manual')){
			redirect(base_url(), 'refresh');exit;
		} */
		//1: Super Admin can not be updated
	//	if(empty($id) or !is_numeric($id) or $id<=1){
	//		redirect(base_url(), 'refresh');exit;
	//	}		
		$this->session->set_userdata(array("edit_user_id" => $id));
		$mp_prof_details = $this->db->query("SELECT * FROM tt_invoice_manual where 1=1 AND group_id='".$this->db->escape_str($id)."'")->row();
		$mp_details = $this->db->query("SELECT * FROM tt_invoice_manual where 1=1 AND group_id='".$this->db->escape_str($id)."'")->result_array();
		if(!$mp_prof_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['mp_prof_details'] = $mp_prof_details;
		$data['mp_details'] = $mp_details;
		$data['page_name']    = 'edit_invoice_manual';
		$data['page_title']   = "Edit Manual Invoice";
		$this->load->view('backend/index', $data);
	}
	
	
	function edit_invoice_manual_process()
    {
        $edit_user_id = $this->session->userdata('edit_user_id');
    
        $submit_btn_id = trim($this->input->post('submit_btn_id'));
    
        if (empty($edit_user_id)) {
            $ar = array(
                "status" => "fail",
                "error" => "Update User id Not found",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
            echo json_encode($ar);
            exit;
        }
    
        if (!is_numeric($edit_user_id)) {
            $ar = array(
                "status" => "fail",
                "error" => "Update User id Not found",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
            echo json_encode($ar);
            exit;
        }
    
        $manpower_name = str_replace(
            "'",
            "&#8217;",
            trim($this->input->post('manpower_name'))
        );
    
        $address = str_replace(
            "'",
            "&#8217;",
            trim($this->input->post('address'))
        );
    
        $contact_number = trim($this->input->post('contact_number'));
        $email = trim($this->input->post('email'));
    
        $account_holder_name = str_replace(
            "'",
            "&#8217;",
            trim($this->input->post('account_holder_name'))
        );
    
        $bank_account_number = str_replace(
            "'",
            "&#8217;",
            trim($this->input->post('bank_account_number'))
        );
    
        $ifsc_code = str_replace(
            "'",
            "&#8217;",
            trim($this->input->post('ifsc_code'))
        );
    
        $pan_number = str_replace(
            "'",
            "&#8217;",
            trim($this->input->post('pan_number'))
        );
    
        $bank_name = str_replace(
            "'",
            "&#8217;",
            trim($this->input->post('bank_name'))
        );
    
        $branch_name = str_replace(
            "'",
            "&#8217;",
            trim($this->input->post('branch_name'))
        );
    
        $exam_date_s = $this->input->post('exam_date');
        $exam_end_date_e = $this->input->post('exam_end_date');
        $exam_name = $this->input->post('exam_name');
    
        $no_of_manpower = $this->input->post('no_of_manpower');
        $no_of_days = $this->input->post('no_of_days');
    
        $pay_mode = $this->input->post('pay_mode');
        $price_per_day = $this->input->post('price_per_day');
        $price_per_hour = $this->input->post('price_per_hour');
        $total_price = $this->input->post('total_price');
    
        $invId = $this->input->post('invId');
        $group_id = $this->input->post('group_id');
    
        /*
         * We don't need to trust invoice_number from POST.
         * We will get the existing invoice number from DB using group_id.
         */
        $financial_year = $this->input->post('financial_year');
    
        $count_entry = count($this->input->post('exam_name'));
    
        if (empty($manpower_name)) {
            $ar = array(
                "status" => "fail",
                "error" => "Manpower Name Required.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
            echo json_encode($ar);
            exit;
        }
    
        if (empty($contact_number)) {
            $ar = array(
                "status" => "fail",
                "error" => "Manpower Mobile Number Required.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
            echo json_encode($ar);
            exit;
        }
    
        if (empty($email)) {
            $ar = array(
                "status" => "fail",
                "error" => "Manpower Email Required.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
            echo json_encode($ar);
            exit;
        }
    
        /*
         * Get the existing invoice number from DB.
         *
         * This is important because invoice_number coming from
         * hidden/input field should not be trusted.
         */
        $existing_invoice = $this->db
            ->select('invoice_number')
            ->where('group_id', $group_id)
            ->where('financial_year', $financial_year)
            ->limit(1)
            ->get('tt_invoice_manual')
            ->row();
    
        if (!$existing_invoice) {
            $ar = array(
                "status" => "fail",
                "error" => "Existing invoice record not found.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
            echo json_encode($ar);
            exit;
        }
    
        $invoice_number = $existing_invoice->invoice_number;
    
        /*
         * Start transaction
         */
        $this->db->trans_begin();
    
        $result = true;
    
        for ($m = 0; $m < $count_entry; $m++) {
    
            /*
             * Existing row
             */
            if (!empty($invId[$m])) {
    
                $save_data = array(
                    "manpower_name" => $manpower_name,
                    "address" => $address,
                    "contact_number" => $contact_number,
                    "email" => $email,
                    "exam_date" => $exam_date_s[$m],
                    "exam_end_date" => $exam_end_date_e[$m],
                    "exam_name" => $exam_name[$m],
                    "no_of_manpower" => $no_of_manpower[$m],
                    "no_of_days" => $no_of_days[$m],
                    "price_mode" => $pay_mode[$m],
                    "price_per_day" => $price_per_day[$m],
                    "price_per_hour" => $price_per_hour[$m],
                    "total_price" => $total_price[$m],
                    "account_holder_name" => $account_holder_name,
                    "bank_account_number" => $bank_account_number,
                    "ifsc_code" => $ifsc_code,
                    "pan_number" => $pan_number,
                    "bank_name" => $bank_name,
                    "branch_name" => $branch_name,
                    "added_by" => $this->session->userdata('login_user_id'),
                    "doe" => date('Y-m-d H:i:s')
                );
    
                $this->db->where('id', $invId[$m]);
                $this->db->where('group_id', $group_id);
    
                $result = $this->db->update(
                    'tt_invoice_manual',
                    $save_data
                );
    
                if (!$result) {
                    break;
                }
            }
    
            /*
             * New row added while editing
             */
            if (empty($invId[$m])) {
    
                $save_datas = array(
                    "group_id" => $group_id,
    
                    /*
                     * IMPORTANT:
                     * Use invoice number fetched from DB,
                     * NOT invoice number coming from POST.
                     */
                    "invoice_number" => $invoice_number,
    
                    "financial_year" => $financial_year,
                    "manpower_name" => $manpower_name,
                    "address" => $address,
                    "contact_number" => $contact_number,
                    "email" => $email,
                    "exam_date" => $exam_date_s[$m],
                    "exam_end_date" => $exam_end_date_e[$m],
                    "exam_name" => $exam_name[$m],
                    "no_of_manpower" => $no_of_manpower[$m],
                    "no_of_days" => $no_of_days[$m],
                    "price_mode" => $pay_mode[$m],
                    "price_per_day" => $price_per_day[$m],
                    "price_per_hour" => $price_per_hour[$m],
                    "total_price" => $total_price[$m],
                    "account_holder_name" => $account_holder_name,
                    "bank_account_number" => $bank_account_number,
                    "ifsc_code" => $ifsc_code,
                    "pan_number" => $pan_number,
                    "bank_name" => $bank_name,
                    "branch_name" => $branch_name,
                    "added_by" => $this->session->userdata('login_user_id'),
                    "doe" => date('Y-m-d H:i:s')
                );
    
                $result = $this->db->insert(
                    'tt_invoice_manual',
                    $save_datas
                );
    
                if (!$result) {
                    break;
                }
            }
        }
    
        /*
         * Check transaction status
         */
        if ($this->db->trans_status() === FALSE || !$result) {
    
            $this->db->trans_rollback();
    
            $ar = array(
                "status" => "fail",
                "error" => "Unable to update invoice information.",
                "frm_btn_id" => $submit_btn_id,
                "redirect" => ""
            );
    
            echo json_encode($ar);
            exit;
        }
    
        /*
         * Commit transaction
         */
        $this->db->trans_commit();
    
        $redirect_url = base_url() . "index.php?admin/invoice_manual";
    
        $this->session->set_flashdata(
            'message',
            "Data Updated successfully"
        );
    
        $ar = array(
            "status" => "pass",
            "error" => "Data Updated successfully",
            "frm_btn_id" => $submit_btn_id,
            "redirect" => $redirect_url
        );
    
        echo json_encode($ar);
        exit;
    }
	
	
	//////diwali
	
	function add_notification_dw(){			
		/*if(!hasPageAuthorize('add_project')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['city_name_info']    = $this->crud_model->select_all_city();
		$data['page_name']          = 'add_notification_dw';
		$data['page_title']         = "Create Notification";
		$this->load->view('backend/index', $data);
	}
	
	function add_notification_dw_process(){
		
		/*	echo "<pre>";
		print_r($_POST);exit;*/

	    $rdno=rand(10,1000);
	    $project_group_ids = strtotime(date('Y-m-d H:i:s')).''.$rdno; 
		
		$exam_name = trim($this->input->post('exam_name'));
		//$exam_start_date = $_POST['start_date'];  
		//$req_seat = $_POST['req_seat']; 
		/*if($exam_start_date){
			//d/m/y
			$date_arm = explode("/", $exam_start_date);
			$start_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}*/
	
	    $city_name_val = $_POST['city_name_val']; 
	
		$cityCount=count($city_name_val);
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
	
		if(empty($exam_name)){
			$ar = array("status" => "fail", "error" => "Title Name required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
	
		/*if(empty($exam_start_date)){
			$ar = array("status" => "fail", "error" => "Exam Date required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}*/
		if(empty($city_name_val)){
			$ar = array("status" => "fail", "error" => "City required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}


for ($k = 0 ; $k < $cityCount; $k++)
{
 $save_data = array(
 			"project_id"=> $project_group_ids,
			"exam_name" => str_replace("'","&#8217;",trim($exam_name)),
			"exam_date"=> date('Y-m-d H:i:s'),
			"exam_city_id" => $city_name_val[$k],
			"exam_city_name" => get_city_name($city_name_val[$k]),
			"required_seat" => 0,
			"created_by" => $this->session->userdata('login_user_id'),
			"create_date" => date('Y-m-d H:i:s')
		);	
		$result = $this->db->insert('tt_exam_notification',$save_data);
		$last_insert_id = $this->db->insert_id();
	}	
	$projectcId=base64_encode($project_group_ids);
	
		if($result){
			$redirect_url = base_url()."index.php?admin/notification_center_list_dw/$projectcId";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
//	exit;
/*	echo "<pre>";
		print_r($_POST);exit;*/
	}
	
	function notification_center_list_dw($projectcId=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
	/*	if(!hasPageAuthorize('admin_users')){
			redirect(base_url(), 'refresh');exit;
		} */  
		'<br>ID='.$searchId=base64_decode($projectcId);
		
		$prj_qry = $this->db->query("SELECT exam_name FROM tt_exam_notification where project_id='".$searchId."'")->row();							        		
		
		/*echo "<pre>";
		print_r($_POST);exit;*/
		
		if(trim($this->input->post('button'))=='Send Notification')
		{
				
		  echo "hiiii";
		
		
		
		}
		
		
		
		
		$data['manage_notification_infos'] = $this->crud_model->search_center_for_notification($searchId);
			
		$data['page_name']          = 'notification_center_list_dw';
		$data['page_title']         = "Diwali Notification : $prj_qry->exam_name";
		$this->load->view('backend/index', $data);
	}
	
	function manage_notification_dw(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		$data['all_notification_info']    = $this->crud_model->select_all_notification_dw();
		$data['page_name']          = 'manage_notification_dw';
		$data['page_title']         = "Mobile Notifications";
		$this->load->view('backend/index', $data);
	}
	
	function view_notification_dw($projectcIds=NULL){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//'<br>A='.$this->session->set_userdata(array("edit_user_id" => $projectcIds));
		
		$projIds = $this->db->escape_str($projectcIds);
		$project_Ids=base64_decode($projIds);
	    $prj_qry = $this->db->query("SELECT id, exam_name FROM tt_exam_notification_send where project_id='".$project_Ids."' and deleted=0")->row();
		$exam_name = $prj_qry->exam_name;	
		$data['view_notification_info']    = $this->crud_model->view_notification_status($project_Ids);
		$data['page_name']          = 'view_notification_dw';
		$data['page_title']         = "BMTC Notification Status : $exam_name";
		$this->load->view('backend/index', $data);
	}
	
function notification_send_process_dw(){
		/*echo "<pre>";
		print_r($_POST);exit;*/

	    $title = trim($this->input->post('title'));
		$message = trim($this->input->post('message'));
		$notify_center = $_POST['notify'];  
		$nfCount=count($notify_center);

		//exit;
		//$examn_date = $_POST['examn_date']; 
		//$req_seat = $_POST['req_seat'];
		 
		$project_id = $_POST['project_id'];  
		$project_name = $_POST['project_name']; 
		
		//exit;
		if(empty($title)){
			$ar = array("status" => "fail", "error" => "Title Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		
		if(empty($message)){
			$ar = array("status" => "fail", "error" => "Message Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
	
		/*if(empty($notify_center)){
			$ar = array("status" => "fail", "error" => "Selection of Center Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}*/

for ($k = 0 ; $k < $nfCount; $k++)
{
	$custmId=$notify_center[$k];
	$centerId='';
	$notfId='';
	$mobile_number='';
	$cityId='';
	$device_token='';
	$custm_str_arr = explode ("_", $custmId);  
	$centerId=$custm_str_arr[0];
	$notfId=$custm_str_arr[1];		
	
	
	$mob_qry = $this->db->query("SELECT city_id,cs_contact_number FROM tt_center where id='".$centerId."'")->row();	
	$cityId=$mob_qry->city_id;
	$mobile_number=trim($mob_qry->cs_contact_number);	
	
	$tkn_qry = $this->db->query("SELECT * FROM tt_admin_users where mobile_phone='".$mobile_number."'")->row();	
	if(!empty($tkn_qry->device_token)){
		$device_token=$tkn_qry->device_token;
		$user_id=$tkn_qry->id;
	} else {
		$device_token="na";
	}

 	$save_data = array(
						"notification_id" => $notfId,
						"project_id" => $project_id,
						"exam_name" => $project_name,
						//"exam_date" => $examn_date,
						//"required_seat" => $req_seat,
						"device_token" => $device_token,
						"user_id" => $this->session->userdata('login_user_id'),
						"mobile_number" => $mobile_number,
						"title"=> $title,
						"message"=> $message,
						"city_name" => get_city_name($cityId),
						"city_id" => $cityId,
						"center_id" => $centerId,
						"sender_mobile" => $mobile_number,
						"create_date" => date('Y-m-d H:i:s'),
						"created_by" => $this->session->userdata('login_user_id')
			);	
			$result = $this->db->insert('tt_exam_notification_send',$save_data);
			
			$save_datas = array(
				"send_notification" => 1,
				"status" => 1
			);	
			$this->db->where('project_id',$project_id);
			$this->db->where('exam_city_id', $cityId);
			$this->db->where('deleted', 0);
			$result = $this->db->update('tt_exam_notification',$save_datas);
			
	}	
	//$projectcId=base64_encode($project_group_id);
	
		if($result){
			$redirect_url = base_url()."index.php?admin/manage_notification_dw";
			$this->session->set_flashdata('message' , "Notification Sent successfully");
			$ar = array("status" => "pass", "error" => "Notification Not Sent successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
	
	
			function porder(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		$data['all_po_info']    = $this->crud_model->select_all_purchase_order();
		$data['page_name']          = 'porder';
		$data['page_title']         = "Purchase Order (PO)";
		$this->load->view('backend/index', $data);
	}
	
	function add_purchase_order(){			
		/*if(!hasPageAuthorize('add_project')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['city_name_info']    = $this->crud_model->select_all_city();
		$data['page_name']          = 'add_purchase_order';
		$data['page_title']         = "New Purchase Order";
		$this->load->view('backend/index', $data);
	}
	
	
	function add_purchasing_order_process(){
		
		/*	echo "<pre>";
		print_r($_POST);exit;
*/
	    $rdno=rand(10,1000);
	    $project_group_ids = strtotime(date('Y-m-d H:i:s')).''.$rdno; 
		
		$fy_year = $this->input->post('fy_year');
	//	$po_number = str_replace("'","&#8217;",trim($this->input->post('po_number')));
		$po_date = str_replace("'","&#8217;",trim($this->input->post('po_date')));
		$service_type = str_replace("'","&#8217;",trim($this->input->post('service_type')));
		$assesement_name = str_replace("'","&#8217;",trim($this->input->post('assesement_name')));
		$assesment_date_from = str_replace("'","&#8217;",trim($this->input->post('assesment_date_from')));
		$assesment_date_to = str_replace("'","&#8217;",trim($this->input->post('assesment_date_to')));
		$name_address = str_replace("'","&#8217;",trim($this->input->post('name_address')));
		$contact_person_name = str_replace("'","&#8217;",trim($this->input->post('contact_person_name')));
		$contact_number = str_replace("'","&#8217;",trim($this->input->post('contact_number')));
		$gst_number = str_replace("'","&#8217;",trim($this->input->post('gst_number')));
		//$gstdel = substr($gst_number, 0, 2);
		
		
		$description =$this->input->post('description');
		$quantity = $this->input->post('quantity');
		$no_of_days = $this->input->post('no_of_days');
		$rate = $this->input->post('rate');
		$amount = $this->input->post('amount');
		$qtyCount=count($description);
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
		if(empty($fy_year)){
			$ar = array("status" => "fail", "error" => "Select Financial Year.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		
		if(empty($po_date)){
			$ar = array("status" => "fail", "error" => "PO Date required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		
		if(empty($assesement_name)){
			$ar = array("status" => "fail", "error" => "Assesement Name required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		
		if(empty($assesment_date_from)){
			$ar = array("status" => "fail", "error" => "Assesement Date From required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($assesment_date_to)){
			$ar = array("status" => "fail", "error" => "Assesement Date To required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
			
		if(empty($name_address)){
			$ar = array("status" => "fail", "error" => "Address required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($contact_person_name)){
			$ar = array("status" => "fail", "error" => "Contact Person Name required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		if(empty($contact_number)){
			$ar = array("status" => "fail", "error" => "Contact Person Mobile No required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		$this->db->trans_begin();
		
		$save_data = array( 
			"po_date" => $po_date,
			"po_financial_year" => $fy_year,
			"service_type"=> $service_type,
			"assesement_name" => $assesement_name,
			"assesment_date_from" => $assesment_date_from,
			"assesment_date_to" => $assesment_date_to,
			"name_address" => $name_address,
			"contact_person_name" => $contact_person_name,
			"contact_number" => $contact_number,
			"gst_number" => $gst_number,
			"added_by" => $this->session->userdata('login_user_id'),
			"doe" => date('Y-m-d H:i:s')
		);	
		$result = $this->db->insert('tt_purchase_order',$save_data);
		$po_id = $this->db->insert_id();
		
		
		$id_qry = $this->db->query("SELECT po_number FROM tt_purchase_order WHERE 1=1 and po_financial_year='".$fy_year."' and id!='".$po_id."' ORDER BY id DESC LIMIT 1")->row();
		//echo $this->db->last_query();exit;
		$poid=$id_qry->po_number;
		$str_pid = explode ("/", $poid); 
		$newpo=($str_pid[2]+1);
		$po_number='TIPL'.'/'.$fy_year.'/'.$newpo;
		//exit;
		
		
		//$po_number='TIPL/$fy_year/'.$po_id;
		
		$save_data = array(
					"po_number" => $po_number
			);	
		$this->db->where('id',$po_id);
		$result = $this->db->update('tt_purchase_order',$save_data);
		//echo $this->db->last_query();exit;
		$qnt=0;
		$nod=0;
		$ratee=0;
		$amt=0;
		

		for ($k = 0 ; $k < $qtyCount; $k++)
		{
			if(empty($description[$k])){
			$ar = array("status" => "fail", "error" => "Description required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		if(empty($quantity[$k])){
			$ar = array("status" => "fail", "error" => "Quantity required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($no_of_days[$k])){
			$ar = array("status" => "fail", "error" => "Number of Days required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($rate[$k])){
			$ar = array("status" => "fail", "error" => "Rate required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($amount[$k])){
			$ar = array("status" => "fail", "error" => "Amount required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
			
		 $save_data = array(
					"po_id"=> $po_id,
					"description" => $description[$k],
					"quantity"=> $quantity[$k],
					"no_of_days" => $no_of_days[$k],
					"rate" => $rate[$k],
					"amount" => $amount[$k],
					"added_by" => $this->session->userdata('login_user_id'),
					"doe" => date('Y-m-d H:i:s')
				);	
				$result = $this->db->insert('tt_po_details',$save_data);
				$last_insert_id = $this->db->insert_id();
				$qnt=$quantity[$k]+$qnt;
				$nod=$no_of_days[$k]+$nod;
				$ratee=$rate[$k]+$ratee;
				$amt=$amount[$k]+$amt;
		}	
		if($gst_number!='')
		{
			$gst_pertg=18;
			$gstamt=$amt*18/100;
			$totalAmount=$gstamt+$amt;
		}
		if($gst_number=='')
		{
			$gst_pertg=18;
			$gstamt=$amt*0;
			$totalAmount=$gstamt+$amt;
		}
		
		$save_dataa = array(
			"gst_percentage" => $gst_pertg,
			"gst_amount" => $gstamt,
			"amount" => $amt,
			"total_amount"=> $totalAmount,
		);	
		
		$this->db->where('id',$po_id);
        $resulta = $this->db->update('tt_purchase_order',$save_dataa);
		$this->db->trans_commit();
	//echo '<br>A='.$total=$amt;
	//exit;
		if($result){
			$redirect_url = base_url()."index.php?admin/add_purchase_order_confirm/$po_id";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
//	exit;
/*	echo "<pre>";
		print_r($_POST);exit;*/
	}
	
	function add_purchase_order_confirm($id = NULL){		
		/*if(!hasPageAuthorize('edit_admin_user')){
			redirect(base_url(), 'refresh');exit;
		} */
		//1: Super Admin can not be updated
		/*if(empty($id) or !is_numeric($id) or $id<=1){
			redirect(base_url(), 'refresh');exit;
		}	*/	
		$this->session->set_userdata(array("edit_user_id" => $id));
		$user_details = $this->db->query("SELECT * FROM tt_purchase_order where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		$data['po_order_info']    = $this->crud_model->select_all_po_order($id);
		
		//echo $this->db->last_query();exit;
		if(!$user_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['user_details'] = $user_details;
		$data['page_name']          = 'add_purchase_order_confirm';
		$data['page_title']         = "Edit Admin User";
		$this->load->view('backend/index', $data);
	}
	
	function add_purchase_order_confirm_process(){
		
		/*	echo "<pre>";
		print_r($_POST);exit;*/

	   
		$oid =$this->input->post('oid');
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
	
		$save_data = array(
 			"confirm_po"=> 2,
			"confirm_by" => $this->session->userdata('login_user_id'),
			"confirm_date" => date('Y-m-d H:i:s')
		);	
		$this->db->where('id',$oid);
        $result = $this->db->update('tt_purchase_order',$save_data);
		
		

		if($result){
			$redirect_url = base_url()."index.php?admin/porder";
			$this->session->set_flashdata('message' , "Order Completed successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
//	exit;
/*	echo "<pre>";
		print_r($_POST);exit;*/
	}
	
	
	
	public function remove_order($ids='')
	{
		
		$prdt_del_qry = $this->db->query("SELECT * FROM tt_po_details WHERE 1=1 and id='".$ids."' and deleted=0")->row();
		$po_id=$prdt_del_qry->po_id;
		$p_amount=$prdt_del_qry->amount;
		
		
		$del_qry = $this->db->query("SELECT * FROM tt_purchase_order WHERE 1=1 and id='".$po_id."' and deleted=0")->row();
		$t_amount=$del_qry->amount;
		//exit;
		$revised_amount=$t_amount-$p_amount;
		$revised_gst=$revised_amount*18/100;
		$revised_total=$revised_amount+$revised_gst;
		
		$save_data = array(
					"gst_amount" => $revised_gst,
					"amount" => $revised_amount,
					"total_amount" => $revised_total,
			);	
		$this->db->where('id',$po_id);
		$result = $this->db->update('tt_purchase_order',$save_data);
		
		
		
		$save_datass1 = array(
					"deleted" => 1,
					"updated_by" => $this->session->userdata('login_user_id'),
					"dou" => date('Y-m-d H:i:s')
			);	
		$this->db->where('id',$ids);
		$result = $this->db->update('tt_po_details',$save_datass1);
		
		/*$redirect_url = base_url()."index.php?admin/add_purchase_order_confirm/$po_id";
		$this->session->set_flashdata('message' , "Data saved successfully");
		$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
		echo json_encode($ar);*/
	//	exit;
		$this->session->set_flashdata('status','Product Deleted!');
		redirect("admin/add_purchase_order_confirm/$po_id","refresh");
	}	 
	
	function modify_po_order($id = NULL){			
		/*if(!hasPageAuthorize('edit_admin_user')){
			redirect(base_url(), 'refresh');exit;
		}*/ 
		//1: Super Admin can not be updated
		if(empty($id) or !is_numeric($id) or $id<=1){
			redirect(base_url(), 'refresh');exit;
		}		
		$this->session->set_userdata(array("edit_user_id" => $id));
		$user_details = $this->db->query("SELECT * FROM tt_purchase_order where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		$data['po_order_info']    = $this->crud_model->select_all_po_order($id);
		
		//echo $this->db->last_query();exit;
		if(!$user_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['user_details'] = $user_details;
		$data['page_name']          = 'modify_po_order';
		$data['page_title']         = "Modify Purchase Order";
		$this->load->view('backend/index', $data);
	}
	
	
	function modify_po_order_process(){
		
		/*	echo "<pre>";
		print_r($_POST);exit;*/

	   
		$oid =$this->input->post('oid');
		
		//$po_number = str_replace("'","&#8217;",trim($this->input->post('po_number')));
		$po_date = str_replace("'","&#8217;",trim($this->input->post('po_date')));
		$service_type = str_replace("'","&#8217;",trim($this->input->post('service_type')));
		$assesement_name = str_replace("'","&#8217;",trim($this->input->post('assesement_name')));
		$assesment_date_from = str_replace("'","&#8217;",trim($this->input->post('assesment_date_from')));
		$assesment_date_to = str_replace("'","&#8217;",trim($this->input->post('assesment_date_to')));
		$name_address = str_replace("'","&#8217;",trim($this->input->post('name_address')));
		$contact_person_name = str_replace("'","&#8217;",trim($this->input->post('contact_person_name')));
		$contact_number = str_replace("'","&#8217;",trim($this->input->post('contact_number')));
		$gst_number = str_replace("'","&#8217;",trim($this->input->post('gst_number')));
		
		
		$poid =$this->input->post('poid');
		$description =$this->input->post('description');
		$quantity = $this->input->post('quantity');
		$no_of_days = $this->input->post('no_of_days');
		$rate = $this->input->post('rate');
		$amount = $this->input->post('amount');
		$qtyCount=count($description);
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		
	
		if(empty($po_date)){
			$ar = array("status" => "fail", "error" => "PO Date required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		
		if(empty($assesement_name)){
			$ar = array("status" => "fail", "error" => "Assesement Name required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
		
		if(empty($assesment_date_from)){
			$ar = array("status" => "fail", "error" => "Assesement Date From required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($assesment_date_to)){
			$ar = array("status" => "fail", "error" => "Assesement Date To required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
			
		if(empty($name_address)){
			$ar = array("status" => "fail", "error" => "Address required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($contact_person_name)){
			$ar = array("status" => "fail", "error" => "Contact Person Name required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		if(empty($contact_number)){
			$ar = array("status" => "fail", "error" => "Contact Person Mobile No required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	
				
		$save_data = array(
 			"po_date" => $po_date,
			"service_type"=> $service_type,
			"assesement_name" => $assesement_name,
			"assesment_date_from" => $assesment_date_from,
			"assesment_date_to" => $assesment_date_to,
			"name_address" => $name_address,
			"contact_person_name" => $contact_person_name,
			"contact_number" => $contact_number,
			"gst_number" => $gst_number,
			"updated_by" => $this->session->userdata('login_user_id'),
			"dou" => date('Y-m-d H:i:s')
		);	
		$this->db->where('id',$oid);
        $results = $this->db->update('tt_purchase_order',$save_data);
		
		
		$qnt=0;
		$nod=0;
		$ratee=0;
		$amt=0;
		

		for ($k = 0 ; $k < $qtyCount; $k++)
		{
			if($poid[$k]!='')
			{
				if(empty($description[$k])){
			$ar = array("status" => "fail", "error" => "Description required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		if(empty($quantity[$k])){
			$ar = array("status" => "fail", "error" => "Quantity required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($no_of_days[$k])){
			$ar = array("status" => "fail", "error" => "Number of Days required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($rate[$k])){
			$ar = array("status" => "fail", "error" => "Rate required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($amount[$k])){
			$ar = array("status" => "fail", "error" => "Amount required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
				 $save_datas = array(
					"description" => $description[$k],
					"quantity"=> $quantity[$k],
					"no_of_days" => $no_of_days[$k],
					"rate" => $rate[$k],
					"amount" => $amount[$k],
					"updated_by" => $this->session->userdata('login_user_id'),
					"dou" => date('Y-m-d H:i:s')
					);	
					$this->db->where('id',$poid[$k]);
					$this->db->where('po_id',$oid);
        			$resulta = $this->db->update('tt_po_details',$save_datas);			
			}
			if($poid[$k]=='')
			{
				 $save_data = array(
					"po_id"=> $oid,
					"description" => $description[$k],
					"quantity"=> $quantity[$k],
					"no_of_days" => $no_of_days[$k],
					"rate" => $rate[$k],
					"amount" => $amount[$k],
					"added_by" => $this->session->userdata('login_user_id'),
					"doe" => date('Y-m-d H:i:s')
				);	
				$result = $this->db->insert('tt_po_details',$save_data);
				$last_insert_id = $this->db->insert_id();
			}
				$qnt=$quantity[$k]+$qnt;
				$nod=$no_of_days[$k]+$nod;
				$ratee=$rate[$k]+$ratee;
				$amt=$amount[$k]+$amt;
		}	
		$gst_pertg=18;
		$gstamt=$amt*18/100;
		$totalAmount=$gstamt+$amt;
		
		
		if($gst_number!='')
		{
			$gst_pertg=18;
			$gstamt=$amt*18/100;
			$totalAmount=$gstamt+$amt;
		}
		if($gst_number=='')
		{
			$gst_pertg=18;
			$gstamt=0;
			$totalAmount=$gstamt+$amt;
		}
		
		
		
		$save_dataa = array(
			"gst_percentage" => $gst_pertg,
			"gst_amount" => $gstamt,
			"amount" => $amt,
			"total_amount"=> $totalAmount,
		);	
		
		$this->db->where('id',$oid);
        $resulta = $this->db->update('tt_purchase_order',$save_dataa);
		
	//echo '<br>A='.$total=$amt;
	//exit;
		if($results){
			$redirect_url = base_url()."index.php?admin/add_purchase_order_confirm/$oid";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
//	exit;
/*	echo "<pre>";
		print_r($_POST);exit;*/
	}
	
		public function load_dynamic_address_by_gst_data(){
		$gst_number = trim($_POST['gst_number']);
		$row = $this->db->query("SELECT * from tt_purchase_order where 1=1 and gst_number='".$this->db->escape_str($gst_number)."'")->row();
		$ed_options = $row->name_address;
		echo json_encode(array("director_office_data" => (array)$row, "ed_options" => $ed_options));
	}
	

	////////Manpower Project Start
		function manpower_project(){
		if ($this->session->userdata('admin_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		} 
		$data['all_po_info']    = $this->crud_model->select_all_manpower_project();
		$data['page_name']          = 'manpower_project';
		$data['page_title']         = "Manpower Project";
		$this->load->view('backend/index', $data);
	}
	
	function add_manpower_project(){			
		/*if(!hasPageAuthorize('add_project')){
			redirect(base_url(), 'refresh');exit;
		} */
		$data['city_name_info']    = $this->crud_model->select_all_city();
		$data['page_name']          = 'add_manpower_project';
		$data['page_title']         = "Add New Manpower Project";
		$this->load->view('backend/index', $data);
	}
	
	
	
	function add_manpower_project_process(){
		
		/*	echo "<pre>";
		print_r($_POST);exit;*/
		
		$client_id = trim($this->input->post('client_id'));
		$exam_name = trim($this->input->post('exam_name'));
		//$exam_name = str_replace("'","&#8217;",trim($this->input->post('exam_name')));
		$start_date = $_POST['start_date'];  
		$end_date = $_POST['end_date']; 
		if($start_date){
			//d/m/y
			$date_arm = explode("/", $start_date);
			$estart_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}
		if($end_date){
			//d/m/y
			$date_arm = explode("/", $end_date);
			$eend_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}		
		$exam_category = $_POST['exam_category'];   
		$exam_type = $this->input->post('exam_type');
		$exam_mode = $this->input->post('exam_mode');
		$exam_city = $this->input->post('city_name_val');
		
		$exam_city_json = json_encode($exam_city);
		//exit;
		
		$payment_type = $this->input->post('payment_type');
		$exam_cost = str_replace("'","&#8217;",trim($this->input->post('exam_cost')));
		$exam_extra_cost = str_replace("'","&#8217;",trim($this->input->post('exam_extra_cost')));
		$client_paymet_type = $this->input->post('client_paymet_type');
		$client_cost = str_replace("'","&#8217;",trim($this->input->post('client_cost')));
		$client_extra_cost = str_replace("'","&#8217;",trim($this->input->post('client_extra_cost')));
		$margin_cost = str_replace("'","&#8217;",trim($this->input->post('margin_cost')));
		//$cityCount=count($exam_city);
		//exit;
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
			
		
		if(empty($client_id)){
			$ar = array("status" => "fail", "error" => "Client Name Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
	
		if(empty($exam_name)){
			$ar = array("status" => "fail", "error" => "Exam Name Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($start_date)){
			$ar = array("status" => "fail", "error" => "Exam Start Date Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($end_date)){
			$ar = array("status" => "fail", "error" => "Exam End Date Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($exam_category)){
			$ar = array("status" => "fail", "error" => "Select Type of Examination.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($exam_type)){
			$ar = array("status" => "fail", "error" => "Select Examination Type.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($exam_mode)){
			$ar = array("status" => "fail", "error" => "Select Examination Mode.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if($exam_city_json=='false'){
			$ar = array("status" => "fail", "error" => "Select Examination City.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($payment_type)){
			$ar = array("status" => "fail", "error" => "Select Manpower/Vendor Payment Mode.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($exam_cost)){
			$ar = array("status" => "fail", "error" => "Enter Examination Cost.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($client_paymet_type)){
			$ar = array("status" => "fail", "error" => "Select Client Payment Mode.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($client_cost)){
			$ar = array("status" => "fail", "error" => "Enter Client Examination Cost.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}

			
		
		$rdno=rand(10,5000);
	    $mp_group_id = strtotime(date('Y-m-d H:i:s')).''.$rdno; 
			
		
	//	for ($k = 0 ; $k < $cityCount; $k++)
	//	{
		/*	$state_ids='';
			$st_qry = $this->db->query("SELECT state_id FROM tt_city_master WHERE 1=1 AND city_id='$exam_city[$k]'")->row();
			$state_id=$st_qry->state_id;*/
			
 		$save_data = array(
			"mp_group_id" => $mp_group_id,
			"client_id" => $client_id,
			"exam_name" => $exam_name,
			"start_date" => $estart_date,
			"end_date" => $eend_date,
			"exam_category"=> $exam_category,
			"exam_type" => $exam_type,
			"exam_mode" => $exam_mode,
			"exam_city" => $exam_city_json,
			"payment_type" => $payment_type,
			"exam_cost" => $exam_cost,
			"exam_extra_cost" => $exam_extra_cost,
			"client_paymet_type" => $client_paymet_type,
			"client_cost" => $client_cost,
			"client_extra_cost" => $client_extra_cost,
			"margin_cost" => $margin_cost,
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$result = $this->db->insert('tt_manpower_project',$save_data);
		$last_insert_id = $this->db->insert_id();
	//	}
		//$projectcId=base64_encode($project_group_id);
	
		if($result){
			$redirect_url = base_url()."index.php?admin/manpower_project";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
//	exit;
/*	echo "<pre>";
		print_r($_POST);exit;*/
	}
	
	
	function edit_manpower_project($id = NULL){			
		/*if(!hasPageAuthorize('edit_client')){
			redirect(base_url(), 'refresh');exit;
		} */

		$this->session->set_userdata(array("edit_user_id" => $id));
		$mpp_details = $this->db->query("SELECT * FROM tt_manpower_project where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		if(!$mpp_details){
			redirect(base_url(), 'refresh');exit;
		}
		$data['mpp_details'] = $mpp_details;
		$data['page_name'] = 'edit_manpower_project';
		$data['page_title'] = "Edit Manpower Project";
		$this->load->view('backend/index', $data);
	}
	
	function edit_manpower_project_process(){
		/*if(!hasPageAuthorize('edit_client_process')){
			redirect(base_url(), 'refresh');exit;
		} */  
		$id = trim($this->input->post('id'));
		$client_id = trim($this->input->post('client_id'));
		$exam_name = trim($this->input->post('exam_name'));
		//$exam_name = str_replace("'","&#8217;",trim($this->input->post('exam_name')));
		$start_date = $_POST['start_date'];  
		$end_date = $_POST['end_date']; 
		if($start_date){
			//d/m/y
			$date_arm = explode("/", $start_date);
			$estart_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}
		if($end_date){
			//d/m/y
			$date_arm = explode("/", $end_date);
			$eend_date = $date_arm[2]."-".$date_arm[1]."-".$date_arm[0];
		}		
		$exam_category = $_POST['exam_category'];   
		$exam_type = trim($this->input->post('exam_type'));
		$exam_mode = trim($this->input->post('exam_mode'));
		$exam_city = $this->input->post('city_name_val');
		$exam_city_json = json_encode($exam_city);
		
		$payment_type = trim($this->input->post('payment_type'));
		$exam_cost = str_replace("'","&#8217;",trim($this->input->post('exam_cost')));
		$exam_extra_cost = str_replace("'","&#8217;",trim($this->input->post('exam_extra_cost')));
		$client_paymet_type = trim($this->input->post('client_paymet_type'));
		$client_cost = str_replace("'","&#8217;",trim($this->input->post('client_cost')));
		$client_extra_cost = str_replace("'","&#8217;",trim($this->input->post('client_extra_cost')));
		$margin_cost = str_replace("'","&#8217;",trim($this->input->post('margin_cost')));
	
		
		
		
	
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_admin_user')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add admin user", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		if(empty($client_id)){
			$ar = array("status" => "fail", "error" => "Client Name Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}	
	
		if(empty($exam_name)){
			$ar = array("status" => "fail", "error" => "Exam Name Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		if(empty($start_date)){
			$ar = array("status" => "fail", "error" => "Exam Start Date Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($end_date)){
			$ar = array("status" => "fail", "error" => "Exam End Date Required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($exam_category)){
			$ar = array("status" => "fail", "error" => "Select Type of Examination.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($exam_type)){
			$ar = array("status" => "fail", "error" => "Select Examination Type.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($exam_mode)){
			$ar = array("status" => "fail", "error" => "Select Examination Mode.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		/*if(empty($exam_city)){
			$ar = array("status" => "fail", "error" => "Select Examination City.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}*/
		
		if(empty($payment_type)){
			$ar = array("status" => "fail", "error" => "Select Manpower/Vendor Payment Mode.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($exam_cost)){
			$ar = array("status" => "fail", "error" => "Enter Examination Cost.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($client_paymet_type)){
			$ar = array("status" => "fail", "error" => "Select Client Payment Mode.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		if(empty($client_cost)){
			$ar = array("status" => "fail", "error" => "Enter Client Examination Cost.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}

	/*	$state_ids='';
		$st_qry = $this->db->query("SELECT state_id FROM tt_city_master WHERE 1=1 AND city_id='$exam_city'")->row();
		$state_id=$st_qry->state_id;	*/
			
			
 		$save_data = array(
			"client_id" => $client_id,
			"exam_name" => $exam_name,
			"start_date" => $estart_date,
			"end_date" => $eend_date,
			"exam_category"=> $exam_category,
			"exam_type" => $exam_type,
			"exam_mode" => $exam_mode,
			"exam_city" => $exam_city_json,
			//"state_id" => $state_id,
			"payment_type" => $payment_type,
			"exam_cost" => $exam_cost,
			"exam_extra_cost" => $exam_extra_cost,
			"client_paymet_type" => $client_paymet_type,
			"client_cost" => $client_cost,
			"client_extra_cost" => $client_extra_cost,
			"margin_cost" => $margin_cost,
			"doe" => date('Y-m-d H:i:s'),
			"added_by" => $this->session->userdata('login_user_id')
		);	
		$this->db->where('id',$id);
		$result = $this->db->update('tt_manpower_project',$save_data);
		//echo $this->db->last_query();exit;
	//	$result = $this->db->insert('',$save_data);
	//	$last_insert_id = $this->db->insert_id();
				
	//	$last_insert_id = $this->crud_model->update_client_info();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/manpower_project";
			$this->session->set_flashdata('message' , "Data Updated successfully");
			$ar = array("status" => "pass", "error" => "Data Updated successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "lab id code is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
	}
	
		function center_video_upload($id = NULL){			
		/*if(!hasPageAuthorize('edit_center')){
			redirect(base_url(), 'refresh');exit;
		} */
		//if(isset($_REQUEST['id'])){
			 '<br>A='.$id = trim($this->db->escape_str($id));
		//}
		$center_details = $this->db->query("SELECT * FROM tt_center where 1=1 AND id='".$this->db->escape_str($id)."'")->row();
		
		//phpinfo();exit;
		/*if(!hasPageAuthorize('add_card')){
			redirect(base_url()."index.php?admin/form_bundle_listings_to_add_card");exit;
		} */
		
		
		//now find bundle exist or or not in our database;
		$center_details = $this->crud_model->get_center_details($id);
		if(!$center_details){
			redirect(base_url()."index.php?admin/form_bundle_listings_to_add_card");exit;
		}
		
		//is any form added to this bundle
		//$data['id_card_row'] = $this->db->query("SELECT id FROM tt_center where 1=1 and id='".$id."'")->num_rows();		
		$data['center_details'] = $center_details;
		$data['page_name']          = 'center_video_upload';
		$data['page_title']         = "Upload Center Video";
		$this->load->view('backend/index', $data);
	}
	function center_video_upload_process(){
		
	/*		echo "<pre>";
		print_r($_POST);exit;
	*/
		$centre_id = trim($this->input->post('centre_id'));
		$about_video = str_replace("'","&#8217;",trim($this->input->post('about_video')));
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		/*if(!hasPageAuthorize('add_vendor')){
			$ar = array("status" => "fail", "error" => "You do not have permission to add new vendor", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		} */
		////DOCUMENT UPLOAD SECTION START
		
		if(empty($about_video)){
			$ar = array("status" => "fail", "error" => "Enter About Video.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
		
		
		$upload_dir_doc = 'uploads/center_video/';
	//	$video = NULL;
		if(isset($_FILES['video']) and !empty($_FILES['video']['name'])){	
			$original = $upload_dir_doc;				
			$configsd['upload_path']  = $original;			
			$configsd['allowed_types'] = 'mp4|WMV|MPEG';
			$configsd['max_size'] = 20000;	 //in KB
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			if ( ! $this->upload->do_upload('video')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "", "btnlbl" => "Update");				
				echo json_encode($ar);
				exit;			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$video = addslashes($uploaded_data['upload_data']['file_name']);															
			}
		}
	
		$save_data = array(
			"center_id" => $centre_id,
			"about_video" => $about_video,
			"center_video" => $video,
			"doe" => date('Y-m-d H:i:s'),
			"added_by" =>  $this->session->userdata('login_user_id')
		);	
		
		$result = $this->db->insert('tt_center_video',$save_data);
		$last_insert_id = $this->db->insert_id();
		
		if($result){
			$redirect_url = base_url()."index.php?admin/center_listing";
			$this->session->set_flashdata('message' , "Data saved successfully");
			$ar = array("status" => "pass", "error" => "Data saved successfully", "frm_btn_id" => $submit_btn_id, "redirect" => $redirect_url);			
			echo json_encode($ar);
			exit;
		}else{
			$ar = array("status" => "fail", "error" => "Information is required.", "frm_btn_id" => $submit_btn_id, "redirect" => "");			
			echo json_encode($ar);
			exit;
		}
	}
}	
?>
