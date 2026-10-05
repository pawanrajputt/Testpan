<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_options
{
	var $ci;
	var $user_status_ar = array("active" => "Active", "blocked" => "Blocked");
	var $payment_status_ar = array("0" => "Select Payment Status", "fullpaid" => "Full Paid", "partial" => "Partial Payment", "unpaid" => "Unpaid");
	
	public function __construct(){
		// Get CI object.
		$this->ci =& get_instance();					
	}
	
	public function state_options($selected=''){
		$query = $this->ci->db->query("SELECT id, title from tt_states where 1=1 ORDER BY title ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['title'].'</option>';
			}
		}
		return $options;
	}
	
	function get_state_name($id)
	{
		return $this->ci->db->query("SELECT title from tt_states where 1=1 and id='".$id."'")->row()->title;
	}
	
	function get_country_name($id)
	{
		return $this->ci->db->query("SELECT name from tt_countries where 1=1 and id='".$id."'")->row()->name;
	}
	
	public function admin_role_option($selected=''){
		$query = $this->ci->db->query("SELECT id, title from tt_roles where 1=1 and id!=1 ORDER BY title ASC ");
		$options = "";
		$options .= '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['title'].'</option>';
			}
		}
		return $options;
	}

	public function user_status_options($selected=''){		
		$options = "";		
		foreach($this->user_status_ar as $key=>$val){
			$options .= '<option value="'.$key.'" ';
			if($selected==$key){
				$options .= ' selected ="selected"';
			}
			$options .= ' >'.$val.'</option>';
		}
		return $options;
	}
	
	function get_admin_name($id)
	{
		return $this->ci->db->query("SELECT email from tt_admin_users where 1=1 and id='".$id."'")->row()->email;
	}

	function get_admin_fullname($id)
	{
		return $this->ci->db->query("SELECT first_name,last_name from tt_admin_users where 1=1 and id='".$id."'")->row()->first_name;
	}
	
	function get_user_role_id($id)
	{
		return $this->ci->db->query("SELECT role_id from tt_admin_users where 1=1 and id='".$id."'")->row()->role_id;
	}
	
	public function vendor_options($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_vendor where 1=1 and deleted=0 ORDER BY vendor_name ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT VENDOR</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['vendor_id'].'" ';
				if($selected==$row['vendor_id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['vendor_name'].'</option>';
			}
		}
		return $options;
	}
	
	function get_vendorname($id)
	{
		return $this->ci->db->query("SELECT vendor_name from tt_vendor where 1=1 and vendor_id='".$id."'")->row()->vendor_name;
	}
	
	function get_centername($id)
	{
		return $this->ci->db->query("SELECT center_name from tt_center where 1=1 and id='".$id."'")->row()->center_name;
	}
	
	public function city_name_option($selected='', $state_id=NULL){
		if($state_id){
			$query = $this->ci->db->query("SELECT city_id, state_id,city_name, city_code from tt_city_master where 1=1 AND state_id='".$state_id."'  ORDER BY city_name ASC ");
		}else{
			$query = $this->ci->db->query("SELECT city_id, state_id,city_name, city_code from tt_city_master where 1=1 ORDER BY city_name ASC ");
		}
		
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['city_id'].'" ';
				if($selected==$row['city_id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.ucfirst($row['city_name']).'-'.$row['city_code'].'</option>';
			}
		}
		return $options;
	}
	
	public function all_city_name_option($selected='', $state_id=NULL){
		
		$query = $this->ci->db->query("SELECT city_id, state_id,city_name, city_code from tt_city_master where 1=1 ORDER BY city_name");
		
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['city_id'].'';
				if($selected==$row['city_id']){
					$options .= ' selected ="selected"';
				}
				$options .= '  >'.ucfirst($row['city_name']).' </option>';
			}
		}
		return $options;
	}
	
	function get_city_name($id)
	{
		return $this->ci->db->query("SELECT city_name from tt_city_master where 1=1 and city_id='".$id."'")->row()->city_name;
	}
	
	function get_city_ids($ids)
	{
		return $this->ci->db->query("SELECT city_id from tt_city_master where 1=1 and city_name='".trim($ids)."'")->row()->city_id;
	}
		
	public function select_client_options($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_client where 1=1 and deleted=0 ORDER BY company_name ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT CLIENT</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['company_name'].'</option>';
			}
		}
		return $options;
	}
	
	
	public function operating_system_options($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_operating_system where 1=1 and deleted=0 ORDER BY id ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT OS</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.trim($row['operating_system']).'" ';
				if($selected==trim($row['operating_system'])){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.trim($row['operating_system']).'</option>';
			}
		}
		return $options;
	}		
		
	
	public function ram_options($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_ram where 1=1 and deleted=0 ORDER BY id ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT RAM</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.trim($row['ram_detail']).'" ';
				if($selected==trim($row['ram_detail'])){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.trim($row['ram_detail']).' '.trim($row['size']).'</option>';
			}
		}
		return $options;
	}		
	
	public function processor_options($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_processor where 1=1 and deleted=0 ORDER BY processor ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT PROCESSOR</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.trim($row['processor']).'" ';
				if($selected==trim($row['processor'])){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.trim($row['processor']).'</option>';
			}
		}
		return $options;
	}	
	
	public function display_resolution_option($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_display_resolution where 1=1 and deleted=0 ORDER BY id ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT RESOLUTION</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.trim($row['monitor_resolution']).'" ';
				if($selected==trim($row['monitor_resolution'])){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.trim($row['monitor_resolution']).'</option>';
			}
		}
		return $options;
	}			
	
	public function monitor_type_option($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_monitor_type where 1=1 and deleted=0 ORDER BY monitor_type ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT MONITOR</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.trim($row['monitor_type']).'" ';
				if($selected==trim($row['monitor_type'])){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.trim($row['monitor_type']).'</option>';
			}
		}
		return $options;
	}		
	
	public function lan_speed_option($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_lan_speed where 1=1 and deleted=0 ORDER BY lan_speed ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT LAN</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.trim($row['lan_speed']).'" ';
				if($selected==trim($row['lan_speed'])){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.trim($row['lan_speed']).'</option>';
			}
		}
		return $options;
	}				
	
	public function hard_disk_option($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_hard_disk where 1=1 and deleted=0 ORDER BY hard_disk ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SLECT HDD</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.trim($row['hard_disk']).'" ';
				if($selected==trim($row['hard_disk'])){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.trim($row['hard_disk']).'</option>';
			}
		}
		return $options;
	}
	
	//Abhinav 
	/*public function get_only_city_name($selected='', $state_id=NULL){
		if($state_id){
			$query = $this->ci->db->query("SELECT state_id,city_name, city_code from tt_city_master where 1=1 AND state_id='".$state_id."'  ORDER BY city_name ASC ");
		}else{
			$query = $this->ci->db->query("SELECT state_id,city_name, city_code from tt_city_master where 1=1 ORDER BY city_name ASC ");
		}
		
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">Select one</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['city_name'].'" ';
				if($selected==$row['city_name']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.ucfirst(trim($row['city_name'])).'</option>';
			}
		}
		return $options;
	}*/
	
	public function get_city_list($selected='', $state_id=NULL){
		if($state_id){
			$query = $this->ci->db->query("SELECT state_id,city_name, city_code from tt_city_master where 1=1 AND state_id='".$state_id."'  ORDER BY city_name ASC ");
		}else{
			$query = $this->ci->db->query("SELECT city_id, state_id,city_name, city_code from tt_city_master where 1=1 ORDER BY city_name ASC ");
			//return;
		}
		
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['city_id'].'" ';
				if($selected==$row['city_id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.ucfirst($row['city_name']).'</option>';
			}
		}
		return $options;
	}
	
	function get_role_type($id)
	{
		return $this->ci->db->query("SELECT title from tt_roles where 1=1 and id='".$id."'")->row()->title;
	}
	
	function get_region_name($id)
	{
		return $this->ci->db->query("SELECT zone_name from tt_states where 1=1 and id='".$id."'")->row()->zone_name;
	}
	
	public function gst_state_options($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_states where 1=1 ORDER BY id asc ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT GST STATE</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['state_code_gst'].'" ';
				if($selected==$row['state_code_gst']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['title'].'- ['.($row['state_code_gst']).']</option>';
			}
		}
		return $options;
	}
	
	function get_project_name($id)
	{
		return $this->ci->db->query("SELECT project_name from tt_center_booking where 1=1 and project_id='".$id."'")->row()->project_name;
	}
	
	public function select_bank_name($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_bank_name where 1=1 and deleted=0 ORDER BY bank_name ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT BANK</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['bank_name'].'" ';
				if($selected==$row['bank_name']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['bank_name'].'</option>';
			}
		}
		return $options;
	}
	
	public function select_center_type($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_center_type where 1=1 and deleted=0 ORDER BY center_type ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT CENTER TYPE</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['center_type'].'</option>';
			}
		}
		return $options;
	}
	
	function get_center_type($id)
	{
		return $this->ci->db->query("SELECT center_type from tt_center_type where 1=1 and id='".$id."'")->row()->center_type;
	}
	
	///5oct2019
	
	function get_client_name($id)
	{
		return $this->ci->db->query("SELECT company_name from tt_client where 1=1 and id='".$id."'")->row()->company_name;
	}

	
	public function center_city_name_option($selected='', $state_id=NULL){
		
		$query = $this->ci->db->query("SELECT c.city_id, c.city_name, s.title from tt_city_master c left join tt_states s on c.state_id=s.id where 1=1 ORDER BY c.city_name ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['city_id'].'" ';
				if($selected==$row['city_id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.strtoupper($row['city_name']).' - '.ucfirst($row['title']).'</option>';
			}
		}
		return $options;
	}
	
	public function center_owner_name_option($selected='', $id=NULL){
		
		$query = $this->ci->db->query("SELECT id,email,first_name,mobile_phone	from tt_admin_users where 1=1 and role_id=9 and coupon_add=0 and deleted=0 order by id");
		//echo $this->ci->db->last_query();exit;
		//$options = "";
		//$options .= '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.strtoupper($row['first_name']).' ('.$row['mobile_phone'].')</option>';
			}
		}
		return $options;
	}
	
		function get_package_name($id)
	{
		return $this->ci->db->query("SELECT package_name from tt_package where 1=1 and package_id='".$id."'")->row()->package_name;
	}
	
	function get_state_id($id)
	{
		return $this->ci->db->query("SELECT state_id from tt_city_master where 1=1 and city_id='".$id."'")->row()->state_id;
	}
	
		public function center_list_options($selected='', $city=NULL){
		if($city){
			$query = $this->ci->db->query("SELECT id, center_name from tt_center where 1=1 AND city_id='".$city."'  ORDER BY center_name ASC ");
		}else{
			$query = $this->ci->db->query("SELECT id, center_name from tt_center where 1=1 AND city_id='".$city."' ORDER BY center_name ASC ");
		}
		
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">Select one</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				
				$options .= ' >'.ucwords($row['center_name']).'</option>';				
			}
		}
		return $options;
	}
	
	
	public function select_manpower_category_options($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_manpower_category where 1=1 and deleted=0 ORDER BY manpower_catg ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT Manpower Category</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['manpower_catg'].'</option>';
			}
		}
		return $options;
	}
	
	function get_manpower_category_name($id)
	{
		return $this->ci->db->query("SELECT manpower_catg from tt_manpower_category where 1=1 and id='".$id."'")->row()->manpower_catg;
	}
	
	public function manpower_sub_catg_option($selected='', $mp_type=NULL){
		
	if($mp_type){
			$query = $this->ci->db->query("SELECT id, mp_catg_id, mp_sub_catg_name from tt_manpower_sub_catg where 1=1 and mp_catg_id='".$mp_type."'  ORDER BY mp_sub_catg_name ");
	}else{
			$query = $this->ci->db->query("SELECT id, mp_catg_id, mp_sub_catg_name from tt_manpower_sub_catg where 1=1  ORDER BY mp_sub_catg_name ");
	}
		
		//$query = $this->ci->db->query("SELECT id, mp_catg_id, mp_sub_catg_name from tt_manpower_sub_catg where 1=1 and mp_catg_id='".$mp_type."'  ORDER BY mp_sub_catg_name ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">Select Manpower Sub-Category</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.strtoupper($row['mp_sub_catg_name']).'</option>';
			}
		}
		return $options;
	}
	
	
	
	/*public function freelancer_type_option($selected='', $mp_type=NULL){
		if($mp_type){
			$query = $this->ci->db->query("SELECT id, mp_sub_catg_name from tt_manpower_sub_catg where 1=1 AND mp_catg_id='".$mp_type."'  ORDER BY mp_sub_catg_name ASC ");
		}else{
		//	$query = $this->ci->db->query("SELECT id, mp_sub_catg_name from tt_manpower_sub_catg where 1=1   ORDER BY mp_sub_catg_name ASC");
		}
		
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">Select Manpower Sub-Category</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.ucfirst($row['mp_sub_catg_name']).'</option>';
			}
		}
		return $options;
	}*/
	
	public function country_list_options($selected='', $lelectlbl=true){
		$query = $this->ci->db->query("SELECT id, name from tt_countries where 1=1 ORDER BY name ASC ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		if($lelectlbl){
			$options .= '<option value="">Select one</option>';
		}
		if(!is_array($selected)){
			$selected = (array)$selected;	
		}
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if(!empty($selected) and in_array($row['id'], $selected)){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['name'].'</option>';
			}
		}
		return $options;
	}
	
	public function state_list_options($selected='', $country_id=NULL){
		if($country_id){
			$query = $this->ci->db->query("SELECT id, title from tt_states where 1=1 AND country_id='".$country_id."'  ORDER BY title ASC ");
		}else{
			$query = $this->ci->db->query("SELECT id, title from tt_states where 1=1   ORDER BY title ASC ");
		}
		
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">Select one</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if($selected==$row['id']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.ucfirst($row['title']).'</option>';
			}
		}
		return $options;
	}
	
	public function city_state_area_options($selected='', $state_id=NULL){
		if($state_id){
			$query = $this->ci->db->query("SELECT city_id, city_name from tt_city_master where 1=1 AND state_id='".$state_id."'  ORDER BY city_name ASC ");
		}else{
			$query = $this->ci->db->query("SELECT city_id, city_name from tt_city_master where 1=1 ORDER BY city_name='' ASC ");
		}
		
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">Select one</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['city_id'].'" ';
				if($selected==$row['city_id']){
					$options .= ' selected ="selected"';
				}
				
				$options .= ' >'.ucwords($row['city_name']).'</option>';				
			}
		}
		return $options;
	}
	
	function get_financial_year($id)
	{
		return $this->ci->db->query("SELECT id,financial_year from tt_financial_year where 1=1 and id='".$id."'")->row()->financial_year;
	}
	
	public function financial_year_options($selected='', $lelectlbl=true){
		$query = $this->ci->db->query("SELECT id, financial_year from tt_financial_year where 1=1 ORDER BY financial_year desc ");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		if($lelectlbl){
			$options .= '<option value="">Select one</option>';
		}
		if(!is_array($selected)){
			$selected = (array)$selected;	
		}
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['id'].'" ';
				if(!empty($selected) and in_array($row['id'], $selected)){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['financial_year'].'</option>';
			}
		}
		return $options;
	}
	
	public function payment_status_options($selected=''){		
		$options = "";		
		foreach($this->payment_status_ar as $key=>$val){
			$options .= '<option value="'.$key.'" ';
			if($selected==$key){
				$options .= ' selected ="selected"';
			}
			$options .= ' >'.$val.'</option>';
		}
		return $options;
	}
	
	
	
	
	
	public function get_manpower_vendor_options($selected=''){
		$query = $this->ci->db->query("SELECT vendor_name from tt_manpower where 1=1 and vendor_name!='' group BY vendor_name ASC");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT VENDOR</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['vendor_name'].'" ';
				if($selected==$row['vendor_name']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['vendor_name'].'</option>';
			}
		}
		return $options;
	}
	
	public function get_manpower_client_options($selected=''){
		$query = $this->ci->db->query("SELECT client_name from tt_manpower where 1=1 and client_name!='' group BY client_name ASC");
		//echo $this->ci->db->last_query();exit;
		$options = "";
		$options .= '<option value="">SELECT CLIENT</option>';
		if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows as $row){
				$options .= '<option value="'.$row['client_name'].'" ';
				if($selected==$row['client_name']){
					$options .= ' selected ="selected"';
				}
				$options .= ' >'.$row['client_name'].'</option>';
			}
		}
		return $options;
	}
	
	
	function convert_number(float $number) {
       $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }
}