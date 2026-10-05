<?php
$ss=$this->db->escape_str($param2);
$fileType = explode(".", $ss);
//print_r($fileType);
?>

	
<div class="row">
    <div class="col-md-12">
  	<?php if($fileType[1]=='jpg' or $fileType[1]=='jpeg' or $fileType[1]=='png' or $fileType[1]=='bmp'){?>
        <div class="panel panel-primary">
            <div class="panel-body">
            <img align="middle" src="<?php echo base_url(); ?>uploads/manpower_document/<?php echo $ss ?>" style="height:80%; width:80%; border:1px; margin-left:5%; margin-right:5%" >
			
			</div>
        </div>
	<?php } ?>
	
	<?php if($fileType[1]=='pdf'){?>
        <div class="panel panel-primary">
            <div class="panel-body">
				 <iframe height="15000px" align="middle" src="<?php echo base_url(); ?>uploads/manpower_document/<?php echo $ss ?>" frameborder="0" marginheight="0" marginwidth="0" width="100%" scrolling="auto"></iframe>
                
            </div>
        </div>
	<?php } ?>
    
    <?php if($fileType[1]=='docx' or $fileType[1]=='doc'){?>
        <div class="panel panel-primary">
            <div class="panel-body" style="background-color:#0CF">
            
        <a href="<?php echo base_url(); ?>uploads/manpower_document/<?php echo $ss ?>" target="_blank">   <img src="<?php echo base_url(); ?>assets/images/view.png" style="height:70px; width:80px; margin:5px; padding:5px; border:1px" alt="User Image" title="User Image"/>
             Click Here View Document File      </a>	 
                
            </div>
        </div>
	<?php } ?>
    </div>
</div>
