<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
               <form role="form" name="edit_admin_user" id="edit_admin_user" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_admin_user_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
   
<div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Roles of User</strong></span>
	
</div>   
   <div class="form-group">
	<div class="col-sm-5"><strong>
	Roles of User  <em style="color:#C00;">*</em></strong>
		<select  class="form-control" name="role_id" id="role_id" onchange="hideShowAccess(this.value, 'dropdown');">
		   <?php echo $this->common_options->admin_role_option($user_details->role_id);?>
         </select>  
	</div>
	
	<div class="col-sm-5"><strong>
	User Status  <em style="color:#C00;">*</em></strong>
		<select  class="form-control" name="status" id="status" >
		   <?php echo $this->common_options->user_status_options($user_details->status);?>
         </select>  
	</div>
	
</div>
   
   
        
	<div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Personal Details</strong></span>
	
</div>	


		
<div class="form-group">
	<div class="col-sm-5"><strong>
	First Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" value="<?php echo $user_details->first_name;?>" style='text-transform:uppercase' >
	</div>

	<div class="col-sm-5">
		<strong>Last Name</strong>
		<input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" value="<?php echo $user_details->last_name;?>" style="text-transform:uppercase" >
	</div>
</div>

<div class="form-group">
	<div class="col-sm-5"><strong>
	Email <em style="color:#C00;">*</em></strong>
		<input type="text" name="email" class="form-control" id="email" value="<?php echo $user_details->email;?>" >
	</div>

	<!--<div class="col-sm-5">
		<strong>Password <em style="color:#C00;">*</em></strong>
		<input type="text" name="password" class="form-control" id="password" value="<?php echo $user_details->password;?>" >
	</div>-->
</div>
		
<div class="form-group">
	<div class="col-sm-5"><strong>
	Date of Birth:</strong>
		<input type="text" name="birthdate" class="form-control datepicker" id="field-6" value="<?php if($user_details->birthdate){ echo date('d/m/Y', strtotime($user_details->birthdate));}?>">
	</div>

	<div class="col-sm-5">
		<strong>Gender </strong><br />
		<label>
        <input type="radio" name="gender" id="gender" value="m" <?php if($user_details->gender == 'm'){?> checked="checked"<?php }?> />
        </label>
	Male 
<label>	<input type="radio" name="gender" id="gender" value="f" <?php if($user_details->gender == 'f'){?> checked="checked"<?php }?> /> </label>
	 Female
	</div>
</div>	


	<div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Contact Details:</strong></span>
	
</div>	
		
<div class="form-group">
<label for="field-1" class="col-sm-2 control-label"><strong>Mobile Number:</strong> </label>
	<div class="col-sm-1">
	
		<input type="text" name="mobile_country_code"  class="form-control" style="width:60px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" value="<?php echo $user_details->mobile_country_code;?>" >
		<span style="font-size:9px">Country Code </span>
	</div>

	<div class="col-sm-2">
		<input type="text" name="mobile_phone" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $user_details->mobile_phone;?>">
		<span style="font-size:9px">Primary Number</span>
	</div>
	<div class="col-sm-2">
		<input type="text" name="alternate_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $user_details->alternate_number;?>" >
		<span style="font-size:9px">Alternate Number</span>
	</div>
	
</div>

<div class="form-group">
<label for="field-1" class="col-sm-2 control-label"><strong>Landline Number:</strong> </label>
	<div class="col-sm-1">
		<input type="text" name="ll_country_code" class="form-control col-sm-1" id="field-8" maxlength="3" onkeypress="return isNumberKey(event)" value="<?php echo $user_details->ll_country_code;?>">
		<span style="font-size:9px">Country Code</span>
	</div>
	<div class="col-sm-1" style="width:100px">
		<input type="text" name="ll_area_code" class="form-control" id="field-8" maxlength="5" onkeypress="return isNumberKey(event)" value="<?php echo $user_details->ll_area_code;?>">
		<span style="font-size:9px">Area Code</span>
	</div>

	<div class="col-sm-2">
		<input type="text" name="land_line_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $user_details->land_line_number;?>" >
		<span style="font-size:9px">Landline Number</span>
	</div>
	<div class="col-sm-1">
		<input type="text" name="land_line_extension" class="form-control" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" value="<?php echo $user_details->land_line_extension;?>">
		<span style="font-size:9px">Extension</span>
	</div>
</div>


	<div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Address Details:</strong></span>
	
</div>

<div class="form-group">
	<div class="col-sm-6">
		<strong>Address1:</strong>
		 <span>
            <textarea name="address" id="address"  class="form-control" style='text-transform:uppercase'><?php echo $user_details->address;?></textarea>
        </span>
	</div>

	<div class="col-sm-6">
		<strong>Address2:</strong>
		 <span>
            <textarea name="address_second" id="address_second"  class="form-control" style='text-transform:uppercase'><?php echo $user_details->address_second;?></textarea>
        </span>
	</div>


	
</div>



<div class="form-group">
			
            
            
            <div class="col-sm-3"><strong> Country: </strong>
				<select  class="form-control" name="country_id" id="country_id" onchange="loadStateList();">
		 		  <?php echo $this->common_options->country_list_options($user_details->country_id);?>
         		</select>
			</div>
            
            <div class="col-sm-3"><strong> State: </strong>
				<select  class="form-control" name="state_id" id="state_id" onchange="load_city_data();">
		 		  <?php echo $this->common_options->state_list_options($user_details->state_id);?>
         		</select>
			</div>
            
            <div class="col-sm-3"><strong> City: </strong>
				<select  class="form-control" name="city_name" id="city_name">
		 			 <?php echo $this->common_options->city_state_area_options($user_details->city);?> 
         		</select>
			</div>
	
    	
		<div class="col-sm-3">
			<strong>Pincode:</strong>
			<input type="text" name="zip_code" class="form-control" id="zip_code" maxlength="6" value="<?php echo $user_details->zip_code;?>" onkeypress="return isNumberKey(event)">
		</div>
</div>


		
    <div class="col-sm-4 control-label col-sm-offset-2">
	
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
    <?php if($user_details->log_status!=2) { ?>
         <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('edit_admin_user','save_btn')" value="Submit">
     <?php } else { ?>
     <?php echo "Locked Account Cannot Edited"; ?>
     <?php } ?>
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

$(document).ready(function(){
	//keep data in d/m/y format
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy'/*,
		startDate: '-3d'*/
	})
});


	loadStateList();
	load_city_data('<?php echo $user_details->state_id;?>');
</script>
<script type="text/javascript">
function load_city_data(){
	var state_id = $.trim($("#state_id").val());
	//alert(state_id);	
	if(state_id==""){
		return false;
	}
	//show_signature
	var datastring = "state_id="+state_id;	
	var url = "<?php echo base_url();?>index.php?admin/load_dynamic_state_city_data";	
	//alert(url);	return false;	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
	$.ajax({		
		type: 'POST',
		url: url,
		data: datastring,		
		dataType: "json",
		cache: false,
		success: function(message) {			
			//console.log(message)
			//alert(message.director_office_data.city);
			//var data = JSON.parse(message);  //this is required if dataType is html, not required for json
			//alert(message.office_head_signature_thumb);		
			
			
			if(message.ed_options){
				$("#city_name").html(message.ed_options);	
			}
			
			$("#save_btn").val("Submit");
			$("#save_btn").attr("disabled", false);		
		}		
		
	});
}

function loadStateList(){
	var country_id = $.trim($("#country_id").val());
	var state_id = $.trim($("#state_id").val());
	if(country_id==""){
		return false;
	}
	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
		
	var datastring = "country_id="+country_id+"&state_id="+state_id;	
	var url = "<?php echo base_url();?>index.php?admin/state_list_options";	
	//alert(url);	return false;	
	$.ajax({		
		type: 'POST',
		url: url,
		data: datastring,		
		dataType: "html",
		cache: false,
		success: function(message) {			
			//alert(message);	
			$("#save_btn").val("Submit");
			$("#save_btn").attr("disabled", false);	
			$("#state_id").html(message);
		}		
	});
}
</script>