<?php
	$center_id=$lab_details->id;
	$assign_lab=$lab_details->total_no_lab;
	
	$ext_lan_cnt = $this->db->query("SELECT COUNT(id) as total_exist_lab FROM tt_lab where 1=1 and center_id='".$center_id."'");
	$total_exist_lab = $ext_lan_cnt->row()->total_exist_lab;
	
	$total_lab=$assign_lab-$total_exist_lab;
	$balLab=$assign_lab-$total_lab;
?>

<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
                <form role="form" name="add_center" id="add_center" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_lab_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="no_of_lab" id="no_of_lab" value="<?php echo $total_lab; ?>" />
				<input type="hidden" name="center_id" id="center_id" value="<?php echo $center_id; ?>" />
<?php    
		for ($k = 0 ; $k < $total_lab; $k++){
		//$lb=$k+1;
		
?>
<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;LAB <?php echo $balLab+$k+1;?> Details </strong></span>
	
</div>



<div class="form-group">
	<div class="col-sm-3">
	<strong>Lab Name</strong>
		<input type="text" name="lab_name[<?php echo $k; ?>]" class="form-control" id="lab_name" required >
	</div>
	
	<div class="col-sm-3">
	<strong>Floor Name</strong>
		<input type="text" name="floor_name[<?php echo $k; ?>]" class="form-control" id="floor_name" required >
	</div>
	
	<div class="col-sm-3">
	<strong>Numbers of Computer</strong>
		<input type="text" name="no_of_computer[<?php echo $k; ?>]" class="form-control" id="no_of_computer" onkeypress="return isNumberKey(event)" >
	</div>
	
	
	
	<div class="col-sm-3">
	<strong>Monitor Type</strong>
		<select  class="form-control" name="monitor_type[<?php echo $k; ?>]" id="monitor_type">
		   <?php echo $this->common_options->monitor_type_option('');?>
        </select>
	</div>
	
	
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Operating System</strong>
		<select  class="form-control" name="operating_system[<?php echo $k; ?>]" id="operating_system">
		   <?php echo $this->common_options->operating_system_options('');?>
        </select>
		
	</div>	
	
	<div class="col-sm-3">
	<strong>Processor</strong>
			<select  class="form-control" name="processor[<?php echo $k; ?>]" id="processor">
		   <?php echo $this->common_options->processor_options('');?>
        </select>
	</div>
	
	<div class="col-sm-3">
	<strong>RAM (GB)</strong>
			<select  class="form-control" name="ram[<?php echo $k; ?>]" id="ram">
		   <?php echo $this->common_options->ram_options('');?>
        </select>
	</div>
	
	<div class="col-sm-3">
	<strong>Hard Disk Drive (GB)</strong>
		<select  class="form-control" name="hard_disk[<?php echo $k; ?>]" id="hard_disk">
		   <?php echo $this->common_options->hard_disk_option('');?>
        </select>
	</div>
	
</div>

<div class="form-group">


<div class="col-sm-3">
	<strong>Model Number</strong>
		<input type="text" name="model_no[<?php echo $k; ?>]" class="form-control" id="model_no" >
	</div>	

	<div class="col-sm-3">
	<strong>No of Ethernet Switch</strong>
		<input type="text" name="no_of_ethernet_switch[<?php echo $k; ?>]" class="form-control" id="no_of_ethernet_switch" >
	</div>


<div class="col-sm-3">
	<strong>No of Port of each Ethernet switch</strong>
		<input type="text" name="no_of_port_eth_switch[<?php echo $k; ?>]" class="form-control" id="no_of_port_eth_switch" >
	</div>

<div class="col-sm-3">
	<strong>Switch Managed</strong><br />
		<input type="radio"  name="switch_manage_status[<?php echo $k; ?>]" id="switch_manage_status" value="yes"/> Yes
	<input type="radio"  name="switch_manage_status[<?php echo $k; ?>]" id="switch_manage_status" value="no"/> No
	</div>


</div>
<div class="form-group">


<div class="col-sm-3">
	<strong>Ethernet Switch Company</strong>
		<input type="text" name="ehternet_swtch_company[<?php echo $k; ?>]" class="form-control" id="ehternet_swtch_company" >
	</div>

<div class="col-sm-3">
	<strong>Model No of Ethernet switch</strong>
		<input type="text" name="model_no_etherbet_swtch[<?php echo $k; ?>]" class="form-control" id="model_no_etherbet_swtch" >
	</div>


<div class="col-sm-3">
	<strong>Lan Speed</strong>
		<select  class="form-control" name="lan_speed[<?php echo $k; ?>]" id="lan_speed">
		   <?php echo $this->common_options->lan_speed_option('');?>
        </select>
	</div>
	
<div class="col-sm-2">

	<strong>No. of CCTV in each lab</strong>
		<input type="text" name="no_of_cctv_each_lab[<?php echo $k; ?>]" class="form-control" id="no_of_cctv_each_lab" onkeypress="return isNumberKey(event)">
	</div>	
</div>

<div class="form-group">	
	
	
<div class="col-sm-3">
	<strong>Numbers of ACs</strong>
		<input type="text" name="no_of_acs[<?php echo $k; ?>]" class="form-control" id="no_of_acs" onkeypress="return isNumberKey(event)" >
	</div>



<div class="col-sm-3">
	<strong>Number of Fan :</strong>
		<input type="text" name="no_of_fan[<?php echo $k; ?>]" class="form-control" id="no_of_fan" onkeypress="return isNumberKey(event)">
	</div>	
	
	
	
<div class="col-sm-2">
	<strong>UPS Connected</strong><br />
			<input type="radio"  name="ups_connected[<?php echo $k; ?>]" id="ups_connected" value="yes"/> Yes
	<input type="radio"  name="ups_connected[<?php echo $k; ?>]" id="ups_connected" value="no"/> No
	</div>

<div class="col-sm-2">
	<strong>Partitation</strong><br />
			<input type="radio"  name="partitation[<?php echo $k; ?>]" id="partitation" value="yes"/> Yes
		<input type="radio"  name="partitation[<?php echo $k; ?>]" id="partitation" value="no"/> No
	</div>




<div class="col-sm-2">
	<strong>Fire Extinguisher  :</strong><br />
		<input type="radio"  name="fire_extinguisher[<?php echo $k; ?>]" id="fire_extinguisher" value="yes"/> Yes
	<input type="radio"  name="fire_extinguisher[<?php echo $k; ?>]" id="fire_extinguisher" value="no"/> No
	</div>
</div>

<?php } ?>


    <div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
    
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_center','save_btn')" value="Submit" align="middle">
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
                </form>
            </div>

        </div>

    </div>
</div>
<script src="assets/js/bootstrap-multiselect.js"></script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>