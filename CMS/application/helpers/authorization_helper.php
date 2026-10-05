<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('hasPageAuthorize'))
{
	/**
	 * hasPageAuthorize
	 *	 
	 * Check that user is authorized to see this page 
	 * 
	 
	 */
	function hasPageAuthorize($page = NULL)
	{
		 $CI =& get_instance();	
		 //$uri = $_SERVER['REQUEST_URI'];
		 if($CI->session->userdata('role_id') == 1 or $CI->session->userdata('role_id') == 2){
		 	return true;
		 }		 
		 if($page){	 			 	
			if(stristr($CI->session->userdata('department_str'), $page)){
				return true;
			}else{
				false;
			}
		 
		 }else{
		 	return false;
		 }		 
	}
}

if ( ! function_exists('get_state_name'))
{
	/**
	 * get_state_name
	 *	 
	 * Get State name
	 * 
	 
	 */
	function get_state_name($state_id)
	{
		 $CI =& get_instance();	
		return @$CI->db->query("SELECT title from tt_states where 1=1 and id='".$state_id."'")->row()->title;
	}
}

if ( ! function_exists('get_city_name'))
{
	/**
	 * get_state_name
	 *	 
	 * Get State name
	 * 
	 
	 */
	function get_city_name($city_id)
	{
		 $CI =& get_instance();	
		return @$CI->db->query("SELECT city_name from tt_city_master where 1=1 and city_id='".$city_id."'")->row()->city_name;
	}
}



if ( ! function_exists('limit_text'))
{
	/**
	 * limit_text
	 *	 
	 * Get limit_text
	 * 
	 
	 */
	function limit_text($text, $limit) {
		if(strlen($text)>$limit){
			return substr($text, 0, $limit).".";
		}
		return $text;
	}
}

if ( ! function_exists('state_name'))
{
	/**
	 * state_name
	 *	 
	 * Get state_name
	 * 
	 
	 */
	function state_name($state_id) {
		$CI =& get_instance();	
		return @$CI->db->query("SELECT title from tt_states where 1=1 AND id='".$state_id."' ")->row()->title;
	}
}





if ( ! function_exists('admin_user_details'))
{
	/**
	 * admin_user_details
	 *	 
	 * Get admin user details
	 *  $id:  id
	 
	 */
	function admin_user_details($id) {
		$CI =& get_instance();	
		return @$CI->db->query("SELECT * from tt_admin_users where 1=1 AND id='".$id."'")->row();
	}
}
 

	

?>