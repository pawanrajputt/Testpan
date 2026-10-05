<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body" style="background-color:#00FFFF; color: #033">			
                <form role="form" name="edit_manpower_project" id="edit_manpower_project" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_manpower_project_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
                <input type="hidden" name="id" id="id" value="<?php echo $mpp_details->id;?>" /> 

                    
<div class="form-group" style="background-color:#0099ff; height:5px;">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;</strong></span>
</div>

<div class="form-group">
	
	<div class="col-sm-6"><strong>
	Select Client </strong>
		<select  class="form-control" name="client_id" id="client_id" style='text-transform:uppercase' >
		  <?php echo $this->common_options->select_client_options($mpp_details->client_id);?>
        </select>
	</div>


	<div class="col-sm-6">
		<strong>Examination Name</strong>
				<input type="text" name="exam_name" class="form-control" id="exam_name" placeholder="Examination Name" style='text-transform:uppercase' value="<?php echo $mpp_details->exam_name;?>">
	</div>

	
</div>
                    

<div class="form-group">
	
	
		
	<div class="col-sm-2">
		<strong>Exam Between - Start Date:</strong>
		<input type="text" name="start_date" class="form-control datepicker"  autocomplete="off" value="<?php if($mpp_details->start_date){ echo date('d/m/Y', strtotime($mpp_details->start_date));}?>">
	</div>
	
	
	<div class="col-sm-2">
		<strong>Exam End Date:</strong>
		<input type="text" name="end_date" class="form-control datepicker" autocomplete="off" value="<?php if($mpp_details->end_date){ echo date('d/m/Y', strtotime($mpp_details->end_date));}?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Type of Examination</strong><br />
		<input type="radio"  name="exam_category" value="government" <?php if($mpp_details->exam_category=='government'){ ?> checked="checked" <?php } ?> /> <label for="rad1">Government</label>&nbsp;&nbsp;
		<input type="radio"  name="exam_category" value="private" <?php if($mpp_details->exam_category=='private'){ ?> checked="checked" <?php } ?>/> <label for="rad2">Private</label>
	</div>
	
	<div class="col-sm-4">
	<strong>Examination Type</strong><br />
		<input type="radio" name="exam_type"  value="enterance" <?php if($mpp_details->exam_type=='enterance'){ ?> checked="checked" <?php } ?> /> <label for="rad1"> Enterance</label> &nbsp;&nbsp;&nbsp;
		<input type="radio"  name="exam_type" value="reccuitment" <?php if($mpp_details->exam_type=='reccuitment'){ ?> checked="checked" <?php } ?> /> <label for="rad2"> Reccuitment</label>&nbsp;&nbsp;&nbsp;
        <input type="radio" name="exam_type" value="mock" <?php if($mpp_details->exam_type=='mock'){ ?> checked="checked" <?php } ?> /><label for="rad3"> Mock </label>  &nbsp;&nbsp;&nbsp;
		<input type="radio"  name="exam_type" value="survey" <?php if($mpp_details->exam_type=='survey'){ ?> checked="checked" <?php } ?> /> <label for="rad4"> Survey </label>
	</div>
	
	<div class="col-sm-2">
	<strong>Exam Mode:</strong><br />
		<input type="radio" name="exam_mode" value="ibt" <?php if($mpp_details->exam_mode=='ibt'){ ?> checked="checked" <?php } ?>/> 
        <label for="rad1">IBT</label>
		<input type="radio"  name="exam_mode"  value="cbt" <?php if($mpp_details->exam_mode=='cbt'){ ?> checked="checked" <?php } ?>/> 
        <label for="rad2">CBT</label>
        <input type="radio"  name="exam_mode"  value="event" <?php if($mpp_details->exam_mode=='event'){ ?> checked="checked" <?php } ?>/> 
        <label for="rad3">EVENT</label>
	</div>
    
	
</div>

<div class="form-group">
	
	
   
	
	<div class="col-sm-9"><strong>
	Select Examination City / Location</strong>
<?php 
$exam_city_ar = json_decode($mpp_details->exam_city);
//print_r($exam_city_ar);
?>        
        <select tyle="display:none"  class="form-control select2" multiple="multiple"  name="city_name_val[]" id="city_name_val" style='text-transform:uppercase' >
		  <?php echo $this->common_options->center_city_name_option($exam_city_ar, false);?> 
        </select>
        
       
	</div>


	
	
</div>



<div class="form-group" style="background-color:#0099ff; height:2px;">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;</strong></span>
</div>





<div class="form-group">
	<div class="col-sm-3">
	<strong>Vendor/Manpower Payment:</strong><br />
		<input type="radio" name="payment_type" value="shift" <?php if($mpp_details->payment_type=='shift'){ ?> checked="checked" <?php } ?>/> 
        <label for="rad1">PER SHIFT</label>&nbsp;&nbsp;&nbsp;
		<input type="radio"  name="payment_type"  value="day" <?php if($mpp_details->payment_type=='day'){ ?> checked="checked" <?php } ?>/> 
        <label for="rad2">PER DAY</label>
	</div>
	
	<div class="col-sm-2">
	<strong>Cost:</strong><br />
		<input type="text" name="exam_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)" onkeyup="calc()" value="<?php echo $mpp_details->exam_cost; ?>"> 
	</div>
	
	<div class="col-sm-2">
	<strong>Extra Cost:</strong><br />
		<input type="text" name="exam_extra_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)" onkeyup="calc()" value="<?php echo $mpp_details->exam_extra_cost; ?>"> 
	</div>
	
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Client Payment:</strong><br />
		<input type="radio" name="client_paymet_type" value="shift" <?php if($mpp_details->client_paymet_type=='shift'){ ?> checked="checked" <?php } ?>/> 
        <label for="rad1">PER SHIFT</label>&nbsp;&nbsp;&nbsp;
		<input type="radio"  name="client_paymet_type"  value="day" <?php if($mpp_details->client_paymet_type=='day'){ ?> checked="checked" <?php } ?>/> 
        <label for="rad2">PER DAY</label>
	</div>
	
	<div class="col-sm-2">
	<strong>Cost:</strong><br />
		<input type="text" name="client_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)" onkeyup="calc()" value="<?php echo $mpp_details->client_cost; ?>"> 
	</div>
	
	<div class="col-sm-2">
	<strong>Extra Cost:</strong><br />
		<input type="text" name="client_extra_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)" onkeyup="calc()" value="<?php echo $mpp_details->client_extra_cost; ?>"> 
	</div>
	
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Margin:</strong><br />
	</div>	
    <div class="col-sm-2">
		<input type="text" name="margin_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)" value="<?php echo $mpp_details->margin_cost; ?>"> 
        
	</div>	
    <div class="col-sm-6">
	<span style="font-size:11px; color:#030">**Margin = (Client Cost + Client Extra Cost) - (Exam Cost + Exam Extra Cost)</span><br />
	</div>
</div>

<div class="form-group" style="background-color:#0099ff; height:5px;">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;</strong></span>
</div>

    <div class="col-sm-5 control-label col-sm-offset-2">
    <input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" style="width:150px; font-size:15px;"/>
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onClick="saveFrmDetails('edit_manpower_project','save_btn')" value="Update" style="width:150px; font-size:15px;"/>
		
		
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

function shownetwork(str){
	if($(str).is(':checked')){
		$("#no_of_network_div").show();
		loadOtherDepartment();
	}else{
		$("#no_of_network_div").hide();
	}
}
function hidenetwork(str){
	if($(str).is(':checked')){
		$("#no_of_network_div").hide();
		loadOtherDepartment();
	}else{
		$("#no_of_network_div").hide();
	}
}

$(document).ready(function(){
	//keep data in d/m/y format
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy'/*,
		startDate: '-3d'*/
	})
});

</script>

<script>
function calc()
  {
    var elm = document.forms["edit_manpower_project"];

    if (elm["exam_cost"].value != "" && elm["exam_extra_cost"].value != "" && elm["client_cost"].value != "" && elm["client_extra_cost"].value != "")
      {elm["margin_cost"].value = (parseInt(elm["client_cost"].value) + parseInt(elm["client_extra_cost"].value)) - (parseInt(elm["exam_cost"].value) + parseInt(elm["exam_extra_cost"].value));}
  }
</script>


	
