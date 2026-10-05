<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zip_file extends CI_Controller {
 
 
 
 
 function index()
 {
  $directory = 'download';
  $data["images"] = glob($directory . "/*.jpg");
  $this->load->view('zip_file', $data);
 }

 function download()
 {
 echo "i m here";
  if($this->input->post('images'))
  {
   $this->load->library('zip');
   $images = $this->input->post('images');
   foreach($images as $image)
   {
    $this->zip->read_file($image);
   }
   $this->zip->download(''.time().'.zip');
  }
 } exit;
redirect(base_url()."index.php?admin/view_center/$id");
}

?>
