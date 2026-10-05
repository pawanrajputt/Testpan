<?php
$ss=$this->db->escape_str($param2);
$fileType = explode(".", $ss);
//print_r($fileType);
?>

	
<div class="row">
    <div class="col-md-12">
  	
        <div class="panel panel-primary">
            <div class="panel-body">
                <img align="middle" src="<?php echo base_url(); ?>uploads/manpower_image/<?php echo $ss ?>" style="height:80%; width:80%; border:1px; margin-left:5%; margin-right:5%" >
                
            </div>
        </div>
	
	
	
    </div>
</div>
