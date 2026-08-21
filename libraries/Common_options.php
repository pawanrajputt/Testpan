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


	public function get_city_list($selected='', $state_id=NULL){
		if($state_id){
			$query = $this->ci->db->query("SELECT state_id,city_name, city_code from tt_city_master where 1=1 AND state_id='".$state_id."'  ORDER BY city_name ASC ");
		}else{
			$query = $this->ci->db->query("SELECT city_id, state_id,city_name, city_code from tt_city_master where 1=1 ORDER BY city_name ASC ");
		}
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
		
	public function select_client_options($selected=''){
		$query = $this->ci->db->query("SELECT * from tt_client where 1=1 and deleted=0 ORDER BY company_name ASC ");
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


    public function country_list_options($selected='', $lelectlbl=true){
		$query = $this->ci->db->query("SELECT id, name from tt_countries where 1=1 ORDER BY name ASC ");
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
	
}