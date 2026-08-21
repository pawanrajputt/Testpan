<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_options
{
	var $ci;
	
	public function __construct(){
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

	function get_city_name($id)
	{
		return $this->ci->db->query("SELECT city_name from tt_city_master where 1=1 and city_id='".$id."'")->row()->city_name;
	}
	
	function get_city_ids($ids)
	{
		return $this->ci->db->query("SELECT city_id from tt_city_master where 1=1 and city_name='".trim($ids)."'")->row()->city_id;
	}
	
}