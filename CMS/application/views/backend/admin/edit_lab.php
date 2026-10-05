<?php
$query = $this->db->query("SELECT * FROM tt_lab where 1=1 and id='".$this->db->escape_str($param2)."'");
$row = $query->row();
$centerId=$row->center_id;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Edit Lab Information</h3>
                </div>
            </div>

            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="edit_lab_info" id="edit_lab_info" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_lab_info" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $param2;?>" />
				<input type="hidden" name="centerId" id="centerId" value="<?php echo $centerId;?>" />
                  
				    <div class="form-group">
                        <label for="field-1" class="col-sm-4 control-label">Lab Name</label>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->lab_name;?>" name="lab_name" class="form-control" id="field-1" >
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label for="field-1" class="col-sm-4 control-label">Floor Name</label>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->floor_name;?>" name="floor_name" class="form-control" id="field-1" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Number of Computer</label>

                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->no_of_computer;?>" name="no_of_computer" class="form-control" id="field-2" maxlength="6" onkeypress="return isNumberKey(event)"  >
							
                        </div>
                    </div>
					
				
					
					 <div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Monitor Type</label>

                        <div class="col-sm-6">
							<select  class="form-control" name="monitor_type" id="monitor_type">
							   <?php echo $this->common_options->monitor_type_option($row->monitor_type);?>
							</select>
												
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Operating System</label>

                        <div class="col-sm-6">
							<select  class="form-control" name="operating_system" id="operating_system">
							   <?php echo $this->common_options->operating_system_options($row->operating_system);?>
							</select>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Processor</label>

                        <div class="col-sm-6">
							<select  class="form-control" name="processor" id="processor">
							   <?php echo $this->common_options->processor_options($row->processor);?>
							</select>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">RAM</label>

                        <div class="col-sm-6">
							<select  class="form-control" name="ram" id="ram">
							   <?php echo $this->common_options->ram_options($row->ram);?>
							</select>
							
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Hard Disk Drive</label>

                        <div class="col-sm-6">
							<select  class="form-control" name="hard_disk" id="hard_disk">
							   <?php echo $this->common_options->hard_disk_option($row->hard_disk);?>
							</select>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Model Number</label>

                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->model_no;?>" name="model_no" class="form-control" id="field-2"  >
							
                        </div>
                    </div>
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">No of Ethernet Switch</label>

                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->no_of_ethernet_switch;?>" name="no_of_ethernet_switch" class="form-control" id="field-2"  >
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">No of Port of each Ethernet switch</label>

                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->no_of_port_eth_switch;?>" name="no_of_port_eth_switch" class="form-control" id="field-2"  >
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Switch Managed</label>

                        <div class="col-sm-6">
							<input type="radio"  name="switch_manage_status" id="switch_manage_status" value="yes" <?php if($row->switch_manage_status=='yes'){?> checked="checked"<?php } ?>/> Yes
							<input type="radio"  name="switch_manage_status" id="switch_manage_status" value="no" <?php if($row->switch_manage_status=='no'){?> checked="checked"<?php } ?>/> No
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Ethernet Switch Company</label>

                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->ehternet_swtch_company;?>" name="ehternet_swtch_company" class="form-control" id="field-2"  >
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Model No of Ethernet switch</label>

                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->model_no_etherbet_swtch;?>" name="model_no_etherbet_swtch" class="form-control" id="field-2"  >
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Lan Speed</label>

                        <div class="col-sm-6">
							<select  class="form-control" name="lan_speed" id="lan_speed">
							   <?php echo $this->common_options->lan_speed_option($row->lan_speed);?>
							</select>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">No. of CCTV in each lab</label>

                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->no_of_cctv_each_lab;?>" name="no_of_cctv_each_lab" class="form-control" id="field-2" onkeypress="return isNumberKey(event)" >
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Numbers of ACs</label>

                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->no_of_ac;?>" name="no_of_ac" class="form-control" id="field-2" onkeypress="return isNumberKey(event)" >
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Number of Fan</label>

                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $row->no_of_fan;?>" name="no_of_fan" class="form-control" id="field-2" onkeypress="return isNumberKey(event)" >
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">UPS Connected</label>

                        <div class="col-sm-6">
                            <input type="radio"  name="ups_connected" id="ups_connected" value="yes" <?php if($row->ups_connected=='yes'){?> checked="checked"<?php } ?>/> Yes
							<input type="radio"  name="ups_connected" id="ups_connected" value="no" <?php if($row->ups_connected=='no'){?> checked="checked"<?php } ?>/> No
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Partitation</label>

                        <div class="col-sm-6">
                           <input type="radio"  name="partitation" id="partitation" value="yes" <?php if($row->partitation=='yes'){?> checked="checked"<?php } ?>/> Yes
							<input type="radio"  name="partitation" id="partitation" value="no" <?php if($row->partitation=='no'){?> checked="checked"<?php } ?>/> No
							
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="field-ta" class="col-sm-4 control-label">Fire Extinguisher  </label>

                        <div class="col-sm-6">
                          	<input type="radio"  name="fire_extinguisher" id="fire_extinguisher" value="yes" <?php if($row->fire_extinguisher=='yes'){?> checked="checked"<?php } ?>/> Yes
							<input type="radio"  name="fire_extinguisher" id="fire_extinguisher" value="no" <?php if($row->fire_extinguisher=='no'){?> checked="checked"<?php } ?>/> No
							
                        </div>
                    </div>

                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('edit_lab_info','save_btn')" value="Submit">
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>