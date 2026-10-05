<?php
$ss=$this->db->escape_str($param2);
$fileType = explode(".", $ss);

?>

	
<div class="row">
    <div class="col-md-12">
  	<?php if($fileType[1]!='pdf'){?>
        <div class="panel panel-primary">
            <div class="panel-body">
                <img align="middle" src="<?php echo base_url(); ?>uploads/center_image/<?php echo $ss ?>" style="height:80%; width:80%; border:1px; margin-left:5%; margin-right:5%" >
            </div>
        </div>
	<?php } ?>
	
	<?php if($fileType[1]=='pdf'){?>
        <div class="panel panel-primary">
            <div class="panel-body">
				 <iframe height="15000px" align="middle" src="<?php echo base_url(); ?>uploads/center_document/<?php echo $ss ?>" frameborder="0" marginheight="0" marginwidth="0" width="100%" scrolling="auto"></iframe>
                
            </div>
        </div>
	<?php } ?>
    </div>
</div>
