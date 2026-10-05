<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Export{
	var $ci;		
	public function __construct(){
		// Get CI object.
		$this->ci =& get_instance();	
	}
	
	private function filterData(&$str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}
	
	//export as excel	
	public function export_as_excel($data, $file_name){

		// echo "<pre>"; print_r($data); die();
		// file name for download
		$fileName = $file_name;			
		// headers for download
		header("Content-Disposition: attachment; filename=\"$fileName\"");
		header("Content-Type: application/vnd.ms-excel");
		
		$flag = false;

		if(!empty($data)){
            echo implode("\t", array_keys($data[0])) . "\n"; // keys as headers
        }
		// foreach($data as $row) {
		// 	if(!$flag) {
		// 		// display column names as first row
		// 		echo implode("\t", array_keys($row)) . "\n";
		// 		$flag = true;
		// 	}
		// 	// filter data
		// 	array_walk($row, array($this, 'filterData'));
		// 	echo implode("\t", array_values($row)) . "\n";
	
		// }

		 foreach ($data as $row) {
            echo implode("\t", array_values($row)) . "\n";
        }

		exit;
	}




}

?>
