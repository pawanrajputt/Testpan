<?php// echo current_url();?>

<?php //if($this->session->userdata('role_id')==1 or $this->session->userdata('role_id')==2){?>
<div class="row">

<div class="col-sm-3">
      <?php if($access_client=='1'){ ?>  <a href="<?php echo base_url(); ?>index.php?admin/manage_client"><?php } ?>
            <div class="tile-stats tile-white-red" style="background:  radial-gradient(#17A2B8 , #17A2B8 )">
                <div class="icon"><i class="fa fa-crosshairs"></i></div>
                <div class="num" data-start="0" data-end="No of Total client" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $cl_total;?></div>
                <h3 style="color:#FFFFFF">My Clients</h3>
            </div>
        </a>
  </div> 
	
	<div class="col-sm-3">
   <?php if($access_booking=='1'){ ?>     <a href="<?php echo base_url(); ?>index.php?admin/manage_project"><?php } ?>
            <div class="tile-stats tile-white-red" style="background: radial-gradient(#28A745 , #28A745 )">
                <div class="icon"><i class="fa fa-trophy"></i></div>
                <div class="num" data-start="0" data-end="No of Total Project" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $cprj_total;?></div>
                <h3 style="color:#FFFFFF">Total Center</h3>
            </div> 
        </a>
    </div>
	
	<div class="col-sm-3">
   <?php if($access_booking=='1'){ ?>     <a href="<?php echo base_url(); ?>index.php?admin/manage_project"><?php } ?>
            <div class="tile-stats tile-white-red" style="background: radial-gradient(#FB5714 , #FB5714 )">
                <div class="icon"><i class="fa fa-trophy"></i></div>
                <div class="num" data-start="0" data-end="No of Total Project" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $cprj_monthly;?></div>
                <h3 style="color:#FFFFFF">Total Notifications</h3>
            </div> 
        </a>
    </div>
	
	
	
    
	
	  <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/dashboard">
            <div class="tile-stats tile-white-red" style="background: radial-gradient(#DC3545 , #DC3545 )">
                <div class="icon"><i class="fa fa-globe"></i></div>
                <div class="num" data-start="0" data-end="No of Total City" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $city_total;?></div>
                <h3 style="color:#FFFFFF">Active Members</h3>
            </div>
        </a>
    </div> 



	
</div>
<?php //}?>
<br />



<script>
function count_dashboard_utility(str){
	//alert('aaa');return false;
	var datastring = "";		
	
	var url = "<?php echo base_url();?>index.php?admin/count_dashboard_utility/"+str;	
	//alert(url);
	
	$("#"+str+"_span").html("Please wait...");	
	
	$.ajax({		
		type: 'POST',
		url: url,
		data: datastring,		
		dataType: "html",
		cache: false,
		success: function(message) {			
			$("#"+str+"_span").html("");
			$("#"+str).html(message);	
		}		
	});	
}
</script>