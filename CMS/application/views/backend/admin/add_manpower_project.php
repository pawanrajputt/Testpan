<!--<style>
input,textarea,select,.multiselect{border:1px solid #afdae2; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color:#6A6969;}
.multiselect{
	width:470px;
	padding:4px;
	height:96px;
	overflow-x:hidden;
	overflow-y:auto;
}
.multiselect{background-color:#eef3f4;}

</style>-->

<style type="text/css">
.multiselect {
    width:30em;
    height:15em;
    border:solid 1px #c0c0c0;
    overflow:auto;
}
 
.multiselect label {
    display:block;
}
 
.multiselect-on {
    color:#ffffff;
    background-color:#ACBA91;
}
.hintPanda{display:none; visibility:hidden;}

input[type="radio"]:checked+label { font-weight: bolder; color: #007a7a }
</style>



<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body" style="background-color:#00FFFF; color: #033">			
                <form role="form" name="add_manpower_project" id="add_manpower_project" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_manpower_project_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

                    
<div class="form-group" style="background-color:#0099ff; height:5px;">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;</strong></span>
</div>

<div class="form-group">
	
	<div class="col-sm-6"><strong>
	Select Client </strong>
		<select  class="form-control" name="client_id" id="client_id" style='text-transform:uppercase' >
		  <?php echo $this->common_options->select_client_options('');?>
        </select>
	</div>


	<div class="col-sm-6">
		<strong>Examination Name</strong>
				<input type="text" name="exam_name" class="form-control" id="exam_name" placeholder="Examination Name" style='text-transform:uppercase'>
	</div>

	
</div>
                    

<div class="form-group">
	
	
		
	<div class="col-sm-2">
		<strong>Exam Between - Start Date:</strong>
		<input type="text" name="start_date" class="form-control datepicker"  autocomplete="off">
	</div>
	
	
	<div class="col-sm-2">
		<strong> End Date:</strong>
		<input type="text" name="end_date" class="form-control datepicker" autocomplete="off">
	</div>
	
	<div class="col-sm-2">
	<strong>Type of Examination</strong><br />
		<input type="radio"  name="exam_category" value="government"/> <label for="rad1">Government</label>&nbsp;&nbsp;
		<input type="radio"  name="exam_category" value="private" /> <label for="rad2">Private</label>
	</div>
	
	<div class="col-sm-4">
	<strong>Examination Type</strong><br />
		<input type="radio" name="exam_type"  value="enterance" /> <label for="rad1"> Enterance</label> &nbsp;&nbsp;&nbsp;
		<input type="radio"  name="exam_type" value="reccuitment" /> <label for="rad2"> Reccuitment</label>&nbsp;&nbsp;&nbsp;
        <input type="radio" name="exam_type" value="mock" /><label for="rad3"> Mock </label>  &nbsp;&nbsp;&nbsp;
		<input type="radio"  name="exam_type" value="survey" /> <label for="rad4"> Survey </label>
	</div>
	
	<div class="col-sm-2">
	<strong>Exam Mode:</strong><br />
		<input type="radio" name="exam_mode" value="ibt" /> 
        <label for="rad1">IBT</label>
		<input type="radio"  name="exam_mode"  value="cbt" /> 
        <label for="rad2">CBT</label>
        <input type="radio"  name="exam_mode"  value="event" /> 
        <label for="rad3">EVENT</label>
	</div>
    
	
</div>

<div class="form-group">
	
	
   
	
	<div class="col-sm-9"><strong>
	Select Examination City / Location</strong>        
         <select tyle="display:none"  class="form-control select2" multiple="multiple"  name="city_name_val[]" id="city_name_val" style='text-transform:uppercase' >
		  <?php echo $this->common_options->center_city_name_option('');?>
        </select>  
	</div>
	

	
	
</div>



<div class="form-group" style="background-color:#0099ff; height:2px;">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;</strong></span>
</div>





<div class="form-group">
	<div class="col-sm-3">
	<strong>Vendor/Manpower Payment:</strong><br />
		<input type="radio" name="payment_type" value="shift" /> 
        <label for="rad1">PER SHIFT</label>&nbsp;&nbsp;&nbsp;
		<input type="radio"  name="payment_type"  value="day" /> 
        <label for="rad2">PER DAY</label>
	</div>
	
	<div class="col-sm-2">
	<strong>Cost:</strong><br />
		<input type="text" name="exam_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)" onkeyup="calc()"> 
	</div>
	
	<div class="col-sm-2">
	<strong>Extra Cost:</strong><br />
		<input type="text" name="exam_extra_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)" onkeyup="calc()"> 
	</div>
	
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Client Payment:</strong><br />
		<input type="radio" name="client_paymet_type" value="shift" /> 
        <label for="rad1">PER SHIFT</label>&nbsp;&nbsp;&nbsp;
		<input type="radio"  name="client_paymet_type"  value="day" /> 
        <label for="rad2">PER DAY</label>
	</div>
	
	<div class="col-sm-2">
	<strong>Cost:</strong><br />
		<input type="text" name="client_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)" onkeyup="calc()"> 
	</div>
	
	<div class="col-sm-2">
	<strong>Extra Cost:</strong><br />
		<input type="text" name="client_extra_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)" onkeyup="calc()"> 
	</div>
	
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Margin:</strong><br />
	</div>	
    <div class="col-sm-2">
		<input type="text" name="margin_cost" class="form-control"  style="height:28px" onkeypress="return isNumberKey(event)"> 
        
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
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onClick="saveFrmDetails('add_manpower_project','save_btn')" value="Submit" style="width:150px; font-size:15px;">
		
		
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
    var elm = document.forms["add_manpower_project"];

    if (elm["exam_cost"].value != "" && elm["exam_extra_cost"].value != "" && elm["client_cost"].value != "" && elm["client_extra_cost"].value != "")
      {elm["margin_cost"].value = (parseInt(elm["client_cost"].value) + parseInt(elm["client_extra_cost"].value)) - (parseInt(elm["exam_cost"].value) + parseInt(elm["exam_extra_cost"].value));}
  }
</script>


	
