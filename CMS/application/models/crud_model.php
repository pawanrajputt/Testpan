<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        $this->db->where($type . '_id', $type_id);
        $query = $this->db->get($type);
        $result = $query->result_array();
        foreach ($result as $row)
            return $row[$field];
        //return	$this->db->get_where($type,array($type.'_id'=>$type_id))->row()->$field;	
    }

    ////////invoices/////////////
    function create_invoice() 
    {
        $data['title']              = $this->input->post('title');
        $data['invoice_number']     = $this->input->post('invoice_number');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp']      = $this->input->post('due_timestamp');
        $data['vat_percentage']     = $this->input->post('vat_percentage');
        $data['discount_amount']    = $this->input->post('discount_amount');
        $data['status']             = $this->input->post('status');

        $invoice_entries            = array();
        $descriptions               = $this->input->post('entry_description');
        $amounts                    = $this->input->post('entry_amount');
        $number_of_entries          = sizeof($descriptions);
        
        for ($i = 0; $i < $number_of_entries; $i++)
        {
            if ($descriptions[$i] != "" && $amounts[$i] != "")
            {
                $new_entry          = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries']    = json_encode($invoice_entries);

        $this->db->insert('invoice', $data);
    }
    
   
    //////system settings//////
    function update_system_settings() {
        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_title');
        $this->db->where('type', 'system_title');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('address');
        $this->db->where('type', 'address');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('phone');
        $this->db->where('type', 'phone');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('paypal_email');
        $this->db->where('type', 'paypal_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_currency_id');
        $this->db->where('type', 'system_currency_id');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_email');
        $this->db->where('type', 'system_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('buyer');
        $this->db->where('type', 'buyer');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('purchase_code');
        $this->db->where('type', 'purchase_code');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('language');
        $this->db->where('type', 'language');
        $this->db->update('settings', $data);
        $this->session->set_userdata('current_language' , $this->input->post('language'));

        $data['description'] = $this->input->post('text_align');
        $this->db->where('type', 'text_align');
        $this->db->update('settings', $data);
    }

    /////creates log/////
    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }
 
   ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '') {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }
	function select_admin_users()
    {
        return $this->db->query('SELECT * FROM tt_admin_users where 1=1 and deleted=0 ORDER BY id')->result_array();
    }
	
	function select_admin_role()
    {
        return $this->db->query('SELECT * FROM tt_roles where 1=1 ORDER BY id')->result_array();
    }
	
	function select_all_vendor()
    {
		//if($this->session->userdata('login_user_id')!=1)
	//	if($this->session->userdata('role_id')!=1 or $this->session->userdata('role_id')!=8)
		//{
		//	return $this->db->query("SELECT * FROM tt_vendor where 1=1 and created_by='".$this->session->userdata('login_user_id')."' ORDER BY vendor_id")->result_array();
	//	} else {
        	return $this->db->query("SELECT * FROM tt_vendor where 1=1  ORDER BY created_on desc")->result_array();
	//	}
    }
    
	function select_all_center()
    {
			$state_id = $_POST['state_id'];
			$city = $_POST['city'];
			$seat_from = $_POST['seat_from'];
			$seat_to = $_POST['seat_to'];
			
			$qrystr = "";	
			if($state_id){
				$qrystr .= " AND state_id='".$state_id."'";
			}
			if($city){
				$qrystr .= " AND city_id='".$city."'";
			}
			
			if($seat_from!='' and $seat_to!=''){
				$qrystr .= " AND total_no_system between '$seat_from' and '$seat_to'";
			}
			if($seat_from=='' and $seat_to!=''){
				$qrystr .= " AND total_no_system <= '$seat_to'";
			}
			if($seat_from!='' and $seat_to==''){
				$qrystr .= " AND total_no_system >= '$seat_from'";
			}
			
        return $this->db->query('SELECT * FROM tt_center where 1=1 and deleted=0  '.$qrystr.' ORDER BY region_code, state_code asc ')->result_array();
    }
	function select_all_lab($id = NULL)
    {
        return $this->db->query("SELECT * FROM tt_lab where 1=1 and center_id='".$id."' and deleted=0 ORDER BY id asc")->result_array();
    }
	
	function update_lab_info()
    {
        $data['lab_name'] = trim($this->input->post('lab_name'));
		$data['floor_name'] = trim($this->input->post('floor_name'));
		$data['no_of_computer'] = trim($this->input->post('no_of_computer'));
		$data['no_of_ac'] = trim($this->input->post('no_of_ac'));
		$data['monitor_type'] = trim($this->input->post('monitor_type'));
		$data['operating_system'] = trim($this->input->post('operating_system'));
		$data['processor'] = trim($this->input->post('processor'));
		$data['ram'] = trim($this->input->post('ram'));
		$data['hard_disk'] = trim($this->input->post('hard_disk'));
		$data['model_no'] = trim($this->input->post('model_no'));
		$data['no_of_ethernet_switch'] = trim($this->input->post('no_of_ethernet_switch'));
		$data['no_of_port_eth_switch'] = trim($this->input->post('no_of_port_eth_switch'));
		$data['switch_manage_status'] = trim($this->input->post('switch_manage_status'));
		$data['lan_speed'] = trim($this->input->post('lan_speed'));
		$data['ehternet_swtch_company'] = trim($this->input->post('ehternet_swtch_company'));
		$data['model_no_etherbet_swtch'] = trim($this->input->post('model_no_etherbet_swtch'));
		$data['ups_connected'] = trim($this->input->post('ups_connected'));
		$data['partitation'] = trim($this->input->post('partitation'));
		$data['no_of_cctv_each_lab'] = trim($this->input->post('no_of_cctv_each_lab'));
		$data['no_of_fan'] = trim($this->input->post('no_of_fan'));
		$data['fire_extinguisher'] = trim($this->input->post('fire_extinguisher'));
		$data['last_modify_on'] = date('Y-m-d H:i:s');
		$id = trim($this->input->post('id'));
        $this->db->where('id',$id);
        return $this->db->update('tt_lab',$data);
    }
	
	function select_client_data()
    {
		
		//echo '<br>AAA='.$this->session->userdata('role_id');
		//exit;
		//if($this->session->userdata('role_id')!=1){
			//return $this->db->query("SELECT * FROM tt_client where 1=1 and deleted=0 and created_by='".$this->session->userdata('login_user_id')."' ORDER BY id")->result_array();
		//} else {
        	return $this->db->query('SELECT * FROM tt_client where 1=1 and deleted=0 ORDER BY id desc')->result_array();
		//}

		
		
		
        
    }
	
	function update_client_info()
    {
		$sts_name = $this->db->query("SELECT state_code_gst FROM tt_states where 1=1 AND id='".trim($this->input->post('state_id'))."'")->row();
		$state_code_gst = $sts_name->state_code_gst;
		
        $data['company_name'] = trim($this->input->post('company_name'));
		$data['address'] = trim($this->input->post('address'));
		$data['address_second'] = trim($this->input->post('address_second'));
		$data['landmark'] = trim($this->input->post('landmark'));
		$data['state'] = trim($this->input->post('state_id'));
		$data['city'] = trim($this->input->post('city_id'));
		$data['pincode'] = trim($this->input->post('pincode'));
		$data['latitude'] = trim($this->input->post('latitude'));
		$data['longitude'] = trim($this->input->post('longitude'));
		$data['co_ordinator_name'] = trim($this->input->post('co_ordinator_name'));
		$data['country_code'] = trim($this->input->post('country_code'));
		$data['area_code'] = trim($this->input->post('area_code'));
		$data['landline_number'] = trim($this->input->post('landline_number'));
		$data['email_id'] = trim($this->input->post('email'));
		$data['gst_state_code'] = $state_code_gst;
		$data['gst_number'] = trim($this->input->post('gst_number'));
		$data['mob_country_code'] = trim($this->input->post('mob_country_code'));
		$data['mobile_no'] = trim($this->input->post('mobile'));
		$data['mobile_alternate'] = trim($this->input->post('mobile_alternate'));
		$data['bank_name'] = trim($this->input->post('bank_name'));
		$data['bank_account_no'] = trim($this->input->post('bank_account_no'));
		$data['bank_ifsc_code'] = trim($this->input->post('bank_ifsc_code'));
		$data['updated_by'] = $this->session->userdata('login_user_id');
		$data['update_on'] = date('Y-m-d H:i:s');
		$id = trim($this->input->post('id'));
        $this->db->where('id',$id);
        return $this->db->update('tt_client',$data);
    }
	
	function select_all_project___________delete()
    {
       // return $this->db->query('SELECT * FROM tt_project_master where 1=1  ORDER BY id')->result_array();
		 return $this->db->query('SELECT * FROM tt_project_requirement_master where 1=1  GROUP  BY project_group_id')->result_array();
    }
	function select_all_city()
    {
        return $this->db->query('SELECT * FROM tt_city_master where 1=1')->result_array();
    }
	function select_all_manpower()
    {
		if($this->session->userdata('login_user_id')!=1){
			return $this->db->query("SELECT * FROM tt_manpower where 1=1 and created_by='".$this->session->userdata('login_user_id')."' ORDER BY id")->result_array();
		} else {
        	return $this->db->query('SELECT * FROM tt_manpower where 1=1 ORDER BY id')->result_array();
		}
    }
	
function search_all_center($searchId=NULL)
    {      
			$qry_details = $this->db->query("SELECT * FROM tt_project_detail WHERE 1=1 AND project_id='".$searchId."' and status=0")->result_array();
			foreach ($qry_details as $rownew)
			{
				$ctName.=trim($rownew['exam_city_id']).',';
			}			
			$exam_city_name=substr($ctName, 0,-1);
			
			//echo 'QR!='.$aa="SELECT * FROM tt_center  WHERE 1=1 and deleted=0 and FIND_IN_SET(city_id, '".trim($exam_city_name)."') ORDER BY city_id ASC";
			
	   return $this->db->query("SELECT * FROM tt_center  WHERE 1=1 and deleted=0 and FIND_IN_SET(city_id, '".trim($exam_city_name)."') ORDER BY city_id ASC")->result_array();
		
    }
	
	function search_all_pending()
    {
        return $this->db->query('SELECT * FROM tt_center_booking where 1=1 and status=0  ORDER BY id')->result_array();
    }
	function search_all_confirmed()
    {
        return $this->db->query('SELECT * FROM tt_center_booking_master where 1=1 and book_status=1  ORDER BY id')->result_array();
    }
	function search_all_completed()
    {
        return $this->db->query('SELECT * FROM tt_exam_booking_detail where 1=1 and status=1  GROUP BY project_id order by exam_date desc')->result_array();
    }
	
	/*function select_seperate_project($id=NULL)
    {
        return $this->db->query("SELECT * FROM tt_center_booking_master where 1=1 and project_id='".$id."'")->result_array();
		echo '<br>QW='.$aa="SELECT * FROM tt_center_booking_master where 1=1 and project_id='".$id."'";
    }*/
		function select_center_summary()
    {
       // return $this->db->query('SELECT * FROM tt_project_master where 1=1  ORDER BY id')->result_array();
	   if($this->session->userdata('login_user_id')!=1){
			 return $this->db->query("SELECT * FROM tt_center where 1=1 and deleted=0 and created_by='".$this->session->userdata('login_user_id')."' GROUP  BY city_id")->result_array();
		} else {
        	 return $this->db->query('SELECT * FROM tt_center where 1=1 and deleted=0  GROUP  BY city_id')->result_array();
		}
	   
	   
	   
		
    }
	
	function search_all_completed_invoice()
    {
        return $this->db->query('SELECT * FROM tt_exam_booking_detail where 1=1 and book_flag=0 and status=1  GROUP BY project_id, vendor_id')->result_array();
    }
	function search_invoice_for_client()
    {
        //return $this->db->query('SELECT * FROM tt_center_booking_master where 1=1 and book_status=2  GROUP BY project_id, client_id')->result_array();
		//return $this->db->query('SELECT * FROM tt_center_booking_master where 1=1 GROUP BY project_id, client_id')->result_array();
		return $this->db->query('SELECT * FROM tt_exam_booking_detail where 1=1 and book_flag=0 and status=1  GROUP BY project_id, client_id')->result_array();
    }
	
	function search_invoice_for_center()
    {
        //return $this->db->query('SELECT * FROM tt_center_booking_master where 1=1 and book_status=2  GROUP BY project_id, client_id')->result_array();
		//return $this->db->query('SELECT * FROM tt_center_booking_master where 1=1 GROUP BY project_id, client_id')->result_array();
		return $this->db->query('SELECT * FROM tt_exam_booking_detail where 1=1 and book_flag=0 and status=1  GROUP BY project_id, center_id')->result_array();
    }
	
	////////////////////
	
	function search_center_listings()
    {       
		
		$this->_get_center_card_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
		return $query->result_array();
    }

	
	function count_filtered_searched_listings($bundle_id){
		$this->_get_center_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_searched_listings($bundle_id = NULL){        
		$this->_get_center_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	private function _get_center_card_listings_query(){			

		$this->db->select("ru.id, ru.center_type, ru.center_id , ru.country_id, ru.state_id, ru.city_id, ru.region_code, ru.state_code, ru.city_code, ru.center_owner, ru.center_name, ru.city,  ru.total_no_system, ru.total_no_system, ru.total_no_lab, ru.udyam_number, ru.deleted", false);
		
		//	$this->db->select("ru.id, ru.center_id, ru.state_id, ru.city_id, ru.region_code, ru.state_code, ru.city_code, ru.center_owner, ru.center_name, ru.city,  ru.total_no_system, ru.total_no_system, ru.total_no_lab, ru.deleted, lb.operating_system, lb.processor, lb.ram", false);

		$this->db->from('tt_center ru')->join('tt_lab lb', 'ru.id=lb.center_id', 'left');
		
		if(isset($_POST['country_id']) and !empty($_POST['country_id'])){

			$this->db->where('ru.country_id', $_POST['country_id']);

		}
		
		if(isset($_POST['state_id']) and !empty($_POST['state_id'])){

			$this->db->where('ru.state_id', $_POST['state_id']);

		}

		if(isset($_POST['city']) and !empty($_POST['city'])){

			$this->db->where('ru.city_id', $_POST['city']);
		
		}
		
		if(isset($_POST['seat_to']) and !empty($_POST['seat_to'])){
			$this->db->where('ru.total_no_system <=', $_POST['seat_to']);    
		}
		
		if(isset($_POST['seat_from']) and !empty($_POST['seat_from'])){
			$this->db->where('ru.total_no_system >=', $_POST['seat_from']);  
		}
		
		if(isset($_POST['vendor_id']) and !empty($_POST['vendor_id'])){
			$this->db->where('ru.vendor_id', $_POST['vendor_id']);  
		}
		
		if(isset($_POST['operating_system']) and !empty($_POST['operating_system'])){

			$this->db->where('lb.operating_system', $_POST['operating_system']);
		
		}
		
		if(isset($_POST['processor']) and !empty($_POST['processor'])){

			$this->db->where('lb.processor', $_POST['processor']);
		
		}
		
		if(isset($_POST['ram']) and !empty($_POST['ram'])){

			$this->db->where('lb.ram', $_POST['ram']);
		
		}
		
		if(isset($_POST['centertype']) and !empty($_POST['centertype'])){

			$this->db->where('ru.center_type', $_POST['centertype']);
		
		}
		
		if($this->session->userdata('role_id')==9){

			$this->db->where('center_owner', $this->session->userdata('login_user_id'));
		
		}
		
		/*if($this->session->userdata('login_user_id')!=1){

			$this->db->where('center_owner', $this->session->userdata('login_user_id'));
		
		}*/
		
		
		
	
	   if($_POST['search']['value']){		
	   		
			  $this->db->where('(ru.center_name LIKE "%'.$_POST['search']['value'].'%" or ru.city LIKE "%'.$_POST['search']['value'].'%" or ru.landline_number LIKE "%'.$_POST['search']['value'].'%"
			  or ru.address LIKE "%'.$_POST['search']['value'].'%" or ru.address_second LIKE "%'.$_POST['search']['value'].'%" or ru.pin_code LIKE "%'.$_POST['search']['value'].'%" or landmark LIKE "%'.$_POST['search']['value'].'%"
			  or ru.cs_name LIKE "%'.$_POST['search']['value'].'%" or ru.cs_contact_number LIKE "%'.$_POST['search']['value'].'%" or ru.cs_phone_alternate LIKE "%'.$_POST['search']['value'].'%" or ru.cs_email LIKE "%'.$_POST['search']['value'].'%"
			  or ru.am_name LIKE "%'.$_POST['search']['value'].'%" or ru.am_contact_no LIKE "%'.$_POST['search']['value'].'%" or ru.am_phone_alternate LIKE "%'.$_POST['search']['value'].'%" or ru.am_email LIKE "%'.$_POST['search']['value'].'%"
			  or ru.poc_name LIKE "%'.$_POST['search']['value'].'%" or ru.poc_contact_no LIKE "%'.$_POST['search']['value'].'%" or ru.poc_mobile_alternate LIKE "%'.$_POST['search']['value'].'%" or ru.poc_email LIKE "%'.$_POST['search']['value'].'%"
			  or ru.emergency_contact_no LIKE "%'.$_POST['search']['value'].'%" or ru.emergency_number_alternate LIKE "%'.$_POST['search']['value'].'%"
			  or ru.td_name LIKE "%'.$_POST['search']['value'].'%" or ru.td_contact_no LIKE "%'.$_POST['search']['value'].'%" or ru.td_phone_alternate LIKE "%'.$_POST['search']['value'].'%" or ru.td_email LIKE "%'.$_POST['search']['value'].'%"
			    or ru.td_name LIKE "%'.$_POST['search']['value'].'%" or ru.udyam_number LIKE "%'.$_POST['search']['value'].'%" or ru.td_phone_alternate LIKE "%'.$_POST['search']['value'].'%" or ru.td_email LIKE "%'.$_POST['search']['value'].'%"	  
			  or ru.type_of_center LIKE "%'.$_POST['search']['value'].'%" or ru.center_approved_by LIKE "%'.$_POST['search']['value'].'%" or ru.center_affiliation_by LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }

	   $this->db->group_by('ru.id'); 

	   $column_order = array('ru.id', 'ru.center_name', 'ru.city', 'ru.created_by','','','ru.created_on', ''); //set column field database for datatable orderable	   
	   
	   $this->db->where('ru.deleted', 0);
	   

	    if(isset($_POST['order'])){

            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        }else{

			$this->db->order_by("ru.id", "asc"); 

		}
		
	}
	
	function search_booking_project($projectId = '')
    {      
		//	echo 'QR!='.$aa="SELECT * FROM tt_exam_booking_detail  WHERE 1=1 and deleted=0 and project_id='".$projectId."'  ORDER BY id ASC";
		  return $this->db->query("SELECT * FROM tt_exam_booking_detail  WHERE 1=1 and deleted=0 and project_id='".$projectId."' ORDER BY id ASC")->result_array();
		
    }
	function select_all_project()
    {
       // return $this->db->query('SELECT * FROM tt_project_master where 1=1  ORDER BY id')->result_array();
	 // echo 'QR!='.$aa="SELECT * FROM tt_project_detail where 1=1 and deleted=0 GROUP  BY project_id";
		 return $this->db->query('SELECT * FROM tt_project_detail where 1=1 and deleted=0 GROUP BY project_id ORDER BY start_date desc')->result_array();
		 
    }
	
	function view_booking_project($projectId = '')
    {      
			//echo 'QR!='.$aa="SELECT * FROM tt_project_detail  WHERE 1=1 and deleted=0 and project_id='".$projectId."' ORDER BY id ASC";
		  return $this->db->query("SELECT * FROM tt_project_detail  WHERE 1=1 and deleted=0 and project_id='".$projectId."' ORDER BY exam_city_id ASC")->result_array();
		
    }
	
	function search_center_for_notification($searchId=NULL)
    {      
			$qry_details = $this->db->query("SELECT * FROM tt_exam_notification WHERE 1=1 AND project_id='".$searchId."' and status=0")->result_array();
			foreach ($qry_details as $rownew)
			{
				$ctName.=trim($rownew['exam_city_id']).',';
			}			
			$exam_city_name=substr($ctName, 0,-1);
			
			//echo 'QR!='.$aa="SELECT * FROM tt_center  WHERE 1=1 and deleted=0 and FIND_IN_SET(city_id, '".trim($exam_city_name)."') ORDER BY city_id ASC";
			
	   return $this->db->query("SELECT * FROM tt_center  WHERE 1=1 and deleted=0 and FIND_IN_SET(city_id, '".trim($exam_city_name)."') ORDER BY city_id ASC")->result_array();
		
    }
	
	function select_all_notification()
    {
		 return $this->db->query('SELECT * FROM tt_exam_notification where 1=1 and deleted=0 GROUP BY project_id')->result_array();
	}
	
	function view_notification_status($project_Ids = NULL)
    {
		 return $this->db->query("SELECT * FROM tt_exam_notification_send WHERE 1=1 and project_id='".$project_Ids."' and deleted=0 ORDER BY city_id ASC")->result_array();
	}
	
	function select_all_package()
    {
		 return $this->db->query('SELECT * FROM tt_package where 1=1 and deleted=0 order by package_id')->result_array();
	}
	
	function select_membership_users()
    {
        return $this->db->query('SELECT * FROM tp_order where 1=1 and status=0 and deleted=0 order by id desc')->result_array();
    }
	
	////////deleted center////
	function search_deleted_centers()
    {       
		
		$this->_get_deleted_center_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
		return $query->result_array();
    }

	
	function count_filtered_deleted_listings($bundle_id){
		$this->_get_deleted_center_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_deleted_listings($bundle_id = NULL){        
		$this->_get_deleted_center_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	private function _get_deleted_center_listings_query(){			

		$this->db->select("id, center_id, state_id, city_id, region_code, state_code, city_code, center_owner, center_name, city,  total_no_system, total_no_system, total_no_lab, reason_of_delete, deleted", false);

		$this->db->from('tt_center');

		
		if(isset($_POST['state_id']) and !empty($_POST['state_id'])){

			$this->db->where('state_id', $_POST['state_id']);

		}

		if(isset($_POST['city']) and !empty($_POST['city'])){

			$this->db->where('city_id', $_POST['city']);
		
		}
		
		if(isset($_POST['seat_to']) and !empty($_POST['seat_to'])){
			$this->db->where('total_no_system <=', $_POST['seat_to']);    
		}
		
		if(isset($_POST['seat_from']) and !empty($_POST['seat_from'])){
			$this->db->where('total_no_system >=', $_POST['seat_from']);  
		}
		
		if(isset($_POST['vendor_id']) and !empty($_POST['vendor_id'])){
			$this->db->where('vendor_id', $_POST['vendor_id']);  
		}
		
		if($this->session->userdata('login_user_id')!=1){

			$this->db->where('center_owner', $this->session->userdata('login_user_id'));
		
		}
	
	   if($_POST['search']['value']){		
	   		
			  $this->db->where('(center_name LIKE "%'.$_POST['search']['value'].'%" or city LIKE "%'.$_POST['search']['value'].'%" or landline_number LIKE "%'.$_POST['search']['value'].'%"
			  or address LIKE "%'.$_POST['search']['value'].'%" or address_second LIKE "%'.$_POST['search']['value'].'%" or pin_code LIKE "%'.$_POST['search']['value'].'%" or landmark LIKE "%'.$_POST['search']['value'].'%"
			  or cs_name LIKE "%'.$_POST['search']['value'].'%" or cs_contact_number LIKE "%'.$_POST['search']['value'].'%" or cs_phone_alternate LIKE "%'.$_POST['search']['value'].'%" or cs_email LIKE "%'.$_POST['search']['value'].'%"
			  or am_name LIKE "%'.$_POST['search']['value'].'%" or am_contact_no LIKE "%'.$_POST['search']['value'].'%" or am_phone_alternate LIKE "%'.$_POST['search']['value'].'%" or am_email LIKE "%'.$_POST['search']['value'].'%"
			  or poc_name LIKE "%'.$_POST['search']['value'].'%" or poc_contact_no LIKE "%'.$_POST['search']['value'].'%" or poc_mobile_alternate LIKE "%'.$_POST['search']['value'].'%" or poc_email LIKE "%'.$_POST['search']['value'].'%"
			  or emergency_contact_no LIKE "%'.$_POST['search']['value'].'%" or emergency_number_alternate LIKE "%'.$_POST['search']['value'].'%"
			  or td_name LIKE "%'.$_POST['search']['value'].'%" or td_contact_no LIKE "%'.$_POST['search']['value'].'%" or td_phone_alternate LIKE "%'.$_POST['search']['value'].'%" or td_email LIKE "%'.$_POST['search']['value'].'%"
			  or type_of_center LIKE "%'.$_POST['search']['value'].'%" or center_approved_by LIKE "%'.$_POST['search']['value'].'%" or center_affiliation_by LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }

	   

	   $column_order = array('id', 'center_name', 'city', 'created_by','','','created_on', ''); //set column field database for datatable orderable	   
	   
	   $this->db->where('deleted', 1);
	   

	    if(isset($_POST['order'])){

            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        }else{

			$this->db->order_by("id", "asc"); 

		}
	}
	
	
	/*function select_all_exam()
    {
        return $this->db->query('SELECT * FROM tt_exam_booking_detail where 1=1 and status=1 ORDER BY id')->result_array();
    }*/
	
	function search_exam_listings()
    {       
		$this->_get_exam_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
		return $query->result_array();
    }

	
	function count_filtered_exam_listings($bundle_id){
		$this->_get_exam_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_exam_listings($bundle_id = NULL){        
		$this->_get_exam_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	private function _get_exam_listings_query(){			

		$this->db->select("id, booking_id, project_id, project_name, client_id, client_name, center_id, center_name, vendor_id, vendor_name, state_id,  city_id, city_name, exam_date, total_batch, total_seat, created_on, cofirm_date, created_by, status, deleted", false);

		$this->db->from('tt_exam_booking_detail');

		if(isset($_POST['state_id']) and !empty($_POST['state_id'])){
			$this->db->where('state_id', $_POST['state_id']);
		}

		if(isset($_POST['city']) and !empty($_POST['city'])){
			$this->db->where('city_id', $_POST['city']);
		}
		
		if(isset($_POST['center_ids_list']) and !empty($_POST['center_ids_list'])){
			$this->db->where('center_id', $_POST['center_ids_list']);
		}
		
				
		if(isset($_POST['start_date']) and !empty($_POST['start_date']) and isset($_POST['end_date']) and !empty($_POST['end_date']))
		{
			$startdate = explode("/", $_POST['start_date']);
			$e_start_date = $startdate[2]."-".$startdate[1]."-".$startdate[0];
			
			$enddate = explode("/", $_POST['end_date']);
			$e_end_date = $enddate[2]."-".$enddate[1]."-".$enddate[0];
	
			$this->db->where('exam_date BETWEEN "'.$e_start_date.'" and "'.$e_end_date.'"');
		}
		
		
		
	   if($_POST['search']['value']){		
	   		
			  $this->db->where('(project_name LIKE "%'.$_POST['search']['value'].'%" or client_name LIKE "%'.$_POST['search']['value'].'%" or center_name LIKE "%'.$_POST['search']['value'].'%"
			  or vendor_name LIKE "%'.$_POST['search']['value'].'%" or city_name LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }

	   $column_order = array('id', 'project_name', 'city_name', 'created_by','','','created_on', ''); //set column field database for datatable orderable	   
	   
	   $this->db->where('deleted', 0);
	
		$this->db->group_by('booking_id'); 
	    if(isset($_POST['order'])){

            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        }else{

			$this->db->order_by("exam_date", "desc"); 

		}
	}
	
	 function get_center_details($id)
    {
        return $this->db->query("SELECT * from tt_center WHERE 1=1 AND id='".$this->db->escape_str($id)."'")->row();
    }
	
	/////end /////
	
	///////MANPOWER AJAX MODULE
	
	function search_manpowers()
    {       
		
		$this->_get_manpower_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
		return $query->result_array();
    }

	
	function count_filtered_searched_listings_mpower($bundle_id){
		$this->_get_manpower_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_searched_listings_mpower($bundle_id = NULL){        
		$this->_get_manpower_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	private function _get_manpower_listings_query(){			

		$this->db->select("ru.id, ru.mp_type, ru.freelance_type, ru.manpower_id, ru.vendor_name, ru.full_name, ru.contact_number, ru.email, ru.date_of_birth, ru.language, ru.gender, ru.address,  ru.user_pic, ru.state, ru.city,ru.experience_online_exam, ru.deleted", false);
		
		

		$this->db->from('tt_manpower ru');
		
		if(isset($_POST['mp_type']) and !empty($_POST['mp_type'])){

			$this->db->where('ru.mp_type', $_POST['mp_type']);

		}
		
		if(isset($_POST['fl_type']) and !empty($_POST['fl_type'])){

			$this->db->where('ru.freelance_type', $_POST['fl_type']);

		}
		
		if($this->session->userdata('login_user_id')!=1){

			$this->db->where('ru.created_by', $this->session->userdata('login_user_id'));

		}
		
		if(isset($_POST['vendor']) and !empty($_POST['vendor'])){

			$this->db->where('ru.vendor_name', $_POST['vendor']);

		}
		
		if(isset($_POST['client']) and !empty($_POST['client'])){

			$this->db->where('ru.client_name', $_POST['client']);

		}
		
		if(isset($_POST['deleted']) and !empty($_POST['deleted'])){

			if($_POST['deleted']==3){
				$this->db->where('ru.deleted', 0);
			}
			if($_POST['deleted']==2){
				$this->db->where('ru.deleted', 2);
			}
			if($_POST['deleted']==1){
				$this->db->where('ru.deleted', 1);
			}
			
			//$this->db->where('ru.deleted', $_POST['deleted']);
			
			

		}


		
	   if($_POST['search']['value']){		
	   		
			  $this->db->where('(ru.full_name LIKE "%'.$_POST['search']['value'].'%" or ru.city LIKE "%'.$_POST['search']['value'].'%" or ru.contact_number LIKE "%'.$_POST['search']['value'].'%" or ru.email LIKE "%'.$_POST['search']['value'].'%" or ru.language LIKE "%'.$_POST['search']['value'].'%" or ru.gender LIKE "%'.$_POST['search']['value'].'%" or address LIKE "%'.$_POST['search']['value'].'%"  or ru.state LIKE "%'.$_POST['search']['value'].'%" or ru.permanent_address LIKE "%'.$_POST['search']['value'].'%" or ru.occupation LIKE "%'.$_POST['search']['value'].'%" or ru.company LIKE "%'.$_POST['search']['value'].'%" or ru.designation LIKE "%'.$_POST['search']['value'].'%" or ru.experience LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }

	   $this->db->group_by('ru.id'); 

	   $column_order = array('ru.id', 'ru.full_name', 'ru.city', 'ru.created_by','ru.state','','ru.created_on', ''); //set column field database for datatable orderable	   
	   
	 //  $this->db->where('ru.deleted', 0);
	   

	    if(isset($_POST['order'])){

            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        }else{

			$this->db->order_by("ru.id", "asc"); 

		}
	}
	
	function select_manual_invoice($task= '') 
    {
        return $this->db->query("SELECT * FROM tt_manual_invoice where 1=1 and beneficiary_pan_no='".$task."' and deleted=0 ORDER BY bill_date desc")->result_array();
    }
	
	function select_invoice_manual()
    {
        return $this->db->query('SELECT * FROM tt_invoice_manual where 1=1 and deleted=0 group by group_id ORDER BY id desc')->result_array();
    }
	
	
	///////manual invoice ajax
	
	function search_manualinvoice()
    {       
		
		$this->_get_manpowerinvoice_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
		return $query->result_array();
    }

	
	function count_filtered_searched_listings_mpowerInv($bundle_id){
		$this->_get_manpowerinvoice_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_searched_listings_mpowerInv($bundle_id = NULL){        
		$this->_get_manpowerinvoice_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	private function _get_manpowerinvoice_listings_query(){			

	//	$this->db->select("ru.id, ru.mp_type, ru.freelance_type, ru.manpower_id, ru.vendor_name, ru.full_name, ru.contact_number, ru.email, ru.date_of_birth, ru.language, ru.gender, ru.address,  ru.user_pic, ru.state, ru.city,ru.experience_online_exam, ru.deleted", false);
		//$this->db->from('tt_manpower ru');
		
		$this->db->select("ru.id, ru.financial_year, ru.bill_date, ru.payment_date, ru.payment_status, ru.exam_name, ru.exam_start_date, ru.exam_end_date, ru.manpower_name, ru.mobile_no, ru.email_id, ru.amount,  ru.beneficiary_name, ru.beneficiary_account_no, ru.bank_ifsc_code,ru.beneficiary_pan_no, ru.deleted", false);
		$this->db->from('tt_manual_invoice ru');
		
		if(isset($_POST['financial_year']) and !empty($_POST['financial_year']))
		{
			$this->db->where('ru.financial_year', $_POST['financial_year']);
		}

		
		if(isset($_POST['bill_date_from']) and !empty($_POST['bill_date_from']) and isset($_POST['bill_date_to']) and !empty($_POST['bill_date_to']))
		{
			$bill_date_f = $_POST['bill_date_from'];
			$bill_dates = explode("/", $bill_date_f);
			$bill_date_from = $bill_dates[2]."-".$bill_dates[0]."-".$bill_dates[1];
			
			$bill_date_t = $_POST['bill_date_to'];
			$bill_datest = explode("/", $bill_date_t);
			$bill_date_too = $bill_datest[2]."-".$bill_datest[0]."-".$bill_datest[1];
			
			$this->db->where('ru.bill_date BETWEEN "'.$bill_date_from.'" and "'.$bill_date_too.'"');
		}
		
		
		
	   if($_POST['search']['value']){		
	   		
			  $this->db->where('(ru.financial_year LIKE "%'.$_POST['search']['value'].'%" or ru.bill_date LIKE "%'.$_POST['search']['value'].'%" or ru.payment_date LIKE "%'.$_POST['search']['value'].'%" or ru.payment_status LIKE "%'.$_POST['search']['value'].'%" or ru.exam_name LIKE "%'.$_POST['search']['value'].'%" or ru.exam_start_date LIKE "%'.$_POST['search']['value'].'%" or ru.exam_end_date LIKE "%'.$_POST['search']['value'].'%"  or ru.manpower_name LIKE "%'.$_POST['search']['value'].'%" or ru.mobile_no LIKE "%'.$_POST['search']['value'].'%" or ru.email_id LIKE "%'.$_POST['search']['value'].'%" or ru.amount LIKE "%'.$_POST['search']['value'].'%" or ru.beneficiary_pan_no LIKE "%'.$_POST['search']['value'].'%" or ru.beneficiary_account_no LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }

	   $this->db->group_by('ru.beneficiary_pan_no'); 

	   $column_order = array('ru.id', 'ru.exam_name', 'ru.manpower_name', 'ru.added_by','ru.beneficiary_pan_no','','ru.doe', ''); //set column field database for datatable orderable	   
	   
	   $this->db->where('ru.deleted', 0);
	   

	    if(isset($_POST['order'])){

            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        }else{

			$this->db->order_by("ru.payment_date", "desc"); 

		}
	}
	
	//////////////////////////////
	
	function search_invoice_detail_ct()
    {       
		
		$this->_get_invoice_detail_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
		return $query->result_array();
    }

	
	function count_filtered_searched_listings_invoice_detail($bundle_id){
		$this->_get_invoice_detail_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_searched_listings_invoice_details($bundle_id = NULL){        
		$this->_get_invoice_detail_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	private function _get_invoice_detail_listings_query(){			

	//	$this->db->select("ru.id, ru.mp_type, ru.freelance_type, ru.manpower_id, ru.vendor_name, ru.full_name, ru.contact_number, ru.email, ru.date_of_birth, ru.language, ru.gender, ru.address,  ru.user_pic, ru.state, ru.city,ru.experience_online_exam, ru.deleted", false);
		//$this->db->from('tt_manpower ru');
		
		$this->db->select("ru.id, ru.financial_year, ru.bill_date, ru.payment_date, ru.payment_status, ru.exam_name, ru.exam_start_date, ru.exam_end_date, ru.manpower_name, ru.mobile_no, ru.email_id, ru.amount,  ru.beneficiary_name, ru.beneficiary_account_no, ru.bank_ifsc_code,ru.beneficiary_pan_no, ru.deleted", false);
		$this->db->from('tt_manual_invoice ru');
		
		if(isset($_POST['financial_year']) and !empty($_POST['financial_year']))
		{
			$this->db->where('ru.financial_year', $_POST['financial_year']);
		}

		
		if(isset($_POST['bill_date_from']) and !empty($_POST['bill_date_from']) and isset($_POST['bill_date_to']) and !empty($_POST['bill_date_to']))
		{
			$bill_date_f = $_POST['bill_date_from'];
			$bill_dates = explode("/", $bill_date_f);
			$bill_date_from = $bill_dates[2]."-".$bill_dates[0]."-".$bill_dates[1];
			
			$bill_date_t = $_POST['bill_date_to'];
			$bill_datest = explode("/", $bill_date_t);
			$bill_date_too = $bill_datest[2]."-".$bill_datest[0]."-".$bill_datest[1];
			
			$this->db->where('ru.bill_date BETWEEN "'.$bill_date_from.'" and "'.$bill_date_too.'"');
		}
		
		
		
	   if($_POST['search']['value']){		
	   		
			  $this->db->where('(ru.financial_year LIKE "%'.$_POST['search']['value'].'%" or ru.bill_date LIKE "%'.$_POST['search']['value'].'%" or ru.payment_date LIKE "%'.$_POST['search']['value'].'%" or ru.payment_status LIKE "%'.$_POST['search']['value'].'%" or ru.exam_name LIKE "%'.$_POST['search']['value'].'%" or ru.exam_start_date LIKE "%'.$_POST['search']['value'].'%" or ru.exam_end_date LIKE "%'.$_POST['search']['value'].'%"  or ru.manpower_name LIKE "%'.$_POST['search']['value'].'%" or ru.mobile_no LIKE "%'.$_POST['search']['value'].'%" or ru.email_id LIKE "%'.$_POST['search']['value'].'%" or ru.amount LIKE "%'.$_POST['search']['value'].'%" or ru.beneficiary_pan_no LIKE "%'.$_POST['search']['value'].'%" or ru.beneficiary_account_no LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }

	   $this->db->group_by('ru.beneficiary_pan_no'); 

	   $column_order = array('ru.id', 'ru.exam_name', 'ru.manpower_name', 'ru.added_by','ru.beneficiary_pan_no','','ru.doe', ''); //set column field database for datatable orderable	   
	   
	   $this->db->where('ru.deleted', 0);
	   

	    if(isset($_POST['order'])){

            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        }else{

			$this->db->order_by("ru.payment_date", "desc"); 

		}
	}
	
	
	
	function select_all_notification_dw()
    {
		 return $this->db->query('SELECT * FROM tt_exam_notification where 1=1 and required_seat=0 and deleted=0 GROUP BY project_id')->result_array();
	}
	
	
	function select_all_purchase_order()
    {
		 return $this->db->query('SELECT * FROM tt_purchase_order where 1=1 and deleted=0 order BY doe DESC')->result_array();
	}
	
	function select_all_po_order($id = '')
    {      
		  return $this->db->query("SELECT * FROM tt_po_details  WHERE 1=1 and deleted=0 and po_id='".$id."' and deleted=0 ORDER BY id ASC")->result_array();
		
    }
	
	
	////manpower project
	
	function select_all_manpower_project()
    {
		 return $this->db->query('SELECT * FROM tt_manpower_project where 1=1 and deleted=0 order BY id')->result_array();
	}
	
	
	
	
}
