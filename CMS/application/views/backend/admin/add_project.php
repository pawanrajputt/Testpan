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
            

            <div class="panel-body">			
                <form role="form" name="add_project" id="add_project" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_project_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

                    
<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;Project / Requirement Details</strong></span>
	
</div>
<div class="form-group">
	
	<div class="col-sm-5"><strong>
	Select Client Name</strong>
		<select  class="form-control" name="client_id" id="client_id" style='text-transform:uppercase' >
		  <?php echo $this->common_options->select_client_options('');?>
        </select>
	</div>


	<div class="col-sm-7">
		<strong>Examination Name</strong>
				<input type="text" name="exam_name" class="form-control" id="exam_name" placeholder="Examination Name" style='text-transform:uppercase'>
	</div>

	
</div>
                    

<div class="form-group">
	
	
		
	<div class="col-sm-3">
		<strong>Project Start Date:</strong>
		<input type="text" name="start_date" class="form-control datepicker"  autocomplete="off">
	</div>
	
	
	<div class="col-sm-3">
		<strong>Project End Date:</strong>
		<input type="text" name="end_date" class="form-control datepicker" autocomplete="off">
	</div>
	
	<div class="col-sm-3">
	<strong>Type of Examination</strong><br />
		<input type="radio"  name="exam_type" id="exam_type" value="government" onClick="shownetwork1(this);"/> <label for="rad1">Government</label>
	<input type="radio"  name="exam_type" id="exam_type" value="private" onClick="shownetwork2(this);"/> <label for="rad2">Private</label>
	</div>
	
	<div class="col-sm-3" style="display:none;" id="govt_job_div">
	<strong>Examination Type</strong><br />
		<input type="radio" name="exam_type_detail" id="exam_type_detail" value="enterance" /> <label for="rad1">Enterance Test</label> 
		<input type="radio"  name="exam_type_detail" id="exam_type_detail" value="reccuitment" /> <label for="rad2">Reccuitment Test</label> <br />
        <input type="radio" name="exam_type_detail" id="exam_type_detail" value="mock" /><label for="rad1">Mock Test</label>  
		<input type="radio"  name="exam_type_detail" id="exam_type_detail" value="survey" /> <label for="rad2"> Survey Test</label>
	</div>
	
	<div class="col-sm-3" style="display:none;" id="pvt_job_div">
	<strong>Examination Type</strong><br />
    <input type="radio" name="exam_type_detail" id="exam_type_detail" value="enterance" /> <label for="rad1">Enterance Test</label> 
		<input type="radio"  name="exam_type_detail" id="exam_type_detail" value="reccuitment" /> <label for="rad2">Reccuitment Test</label> <br />
		<input type="radio" name="exam_type_detail" id="exam_type_detail" value="mock" /><label for="rad1">Mock Test</label>  
		<input type="radio"  name="exam_type_detail" id="exam_type_detail" value="survey" /> <label for="rad2"> Survey Test</label>
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-4">
	<strong>Exam Mode:</strong><br />
		<input type="radio" name="exam_mode" id="exam_mode" value="internet" onClick="exammodes1(this);" /> 
        <label for="rad1">Internet Based</label>
		<input type="radio"  name="exam_mode" id="exam_mode" value="server" onClick="exammodes2(this);" /> 
        <label for="rad2">Server Based</label>
	</div>
    
   
</div>


<div class="form-group" style="display:none; border-color:#09F; border-style:dashed; border-bottom:dashed; border-bottom-color:#09F" id="internet_div">

<div align="center">
<span style="color:#039; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;Delivery Machine Configuration</strong></span>
</div>
	<br />
<div class="col-sm-3">
	<strong>Operating System:</strong>
		<select  class="form-control" name="inet_mode_os" id="inet_mode_os">
		  <?php echo $this->common_options->operating_system_options('');?>
        </select>
	</div>
    
 <div class="col-sm-2">
	<strong>RAM:</strong>
		<select  class="form-control" name="inet_mode_ram" id="inet_mode_ram">
		  <?php echo $this->common_options->ram_options('');?>
        </select>
	</div>   

<div class="col-sm-2">
	<strong>Processor:</strong>
		<select  class="form-control" name="inet_mode_processor" id="inet_mode_processor">
		  <?php echo $this->common_options->processor_options('');?>
        </select>
	</div>
    
<div class="col-sm-3">
	<strong>Display Resolution:</strong>
		<select  class="form-control" name="inet_mode_display" id="inet_mode_display">
		  <?php echo $this->common_options->display_resolution_option('');?>
        </select>
	</div>    
       
    
<div class="col-sm-2">
	<strong>Internet on each:</strong><br />
		<input type="radio" name="inet_mode_internet_each" id="inet_mode_internet_each" value="yes" />  <label for="rad1">Yes</label> 
		<input type="radio"  name="inet_mode_internet_each" id="inet_mode_internet_each" value="no"/>  <label for="rad2">No</label>
        <p>&nbsp;</p>
	</div>
</div>


<div class="form-group" style="display:none; border-color:#09F; border-style:dashed; border-bottom:dashed; border-bottom-color:#09F" id="server_div1">

<div align="center">
<span style="color:#039; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;Server Configuration</strong></span>
</div>
	<br />
    
    <div class="col-sm-3">
	<strong>Operating System:</strong>
		<select  class="form-control" name="server_mode_os" id="server_mode_os">
		  <?php echo $this->common_options->operating_system_options('');?>
        </select>
	</div>
	
    <div class="col-sm-2">
	<strong>RAM:</strong>
		<select  class="form-control" name="server_mode_ram" id="server_mode_ram">
		  <?php echo $this->common_options->ram_options('');?>
        </select>
	</div>
    
	<div class="col-sm-2">
	<strong>Processor:</strong>
		<select  class="form-control" name="server_mode_processor" id="server_mode_processor">
		  <?php echo $this->common_options->processor_options('');?>
        </select>
	</div>

<div class="col-sm-3">
	<strong>Server Ratio:</strong><br />
		<input type="text" name="server_mode_ratio_1" class="" id="server_mode_ratio_1" style="width:80px; height:28px"> <strong>:</strong>
		<input type="text" name="server_mode_ratio_2" class="" id="server_mode_ratio_2" style="width:80px; height:28px"><br />
        (server : candidate)
	</div>

<div class="col-sm-2">
	<strong>Internet Required:</strong><br />
		<input type="radio" name="server_mode_internet" id="server_mode_internet" value="yes" /> <label for="rad1">Yes</label>
		<input type="radio"  name="server_mode_internet" id="server_mode_internet" value="no"/><label for="rad2">No</label> 
	</div>
</div>

	
<div class="form-group">	
	<div class="col-sm-3">
		<strong>Exam Batch (Time):</strong>
		
					<select name="total_batch" id="adisel" class="form-control">
						  <option value="">Select</option>
						  <option value="1">1</option>
						  <option value="2">2</option>
						  <option value="3">3</option>
						  <option value="4">4</option>
						  <option value="5">5</option>
					</select>
	</div>

	<div class="col-sm-3" id="divexbatch1" style="display: none">
	<strong>Timing 1</strong>
		<input type="text" name="batch1" class="form-control" id="batch1" >
	</div>
	
	<div class="col-sm-3" id="divexbatch2" style="display: none">
	<strong>Timing 2</strong>
		<input type="text" name="batch2" class="form-control" id="batch2"  >
	</div>
	
	<div class="col-sm-3" id="divexbatch3" style="display: none">
	<strong>Timing 3</strong>
		<input type="text" name="batch3" class="form-control" id="batch3" >
	</div>


</div>

<div class="form-group">
	<div class="col-sm-3" id="divexbatch4" style="display: none">
	<strong>Timing 4</strong>
		<input type="text" name="batch4" class="form-control" id="batch4" >
	</div>
	
	<div class="col-sm-3" id="divexbatch5" style="display: none">
	<strong>Timing 5</strong>
		<input type="text" name="batch5" class="form-control" id="batch5" >
	</div>
	
	
	
</div>


<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;Examination City / Location</strong></span>
	
</div>
<div class="form-group">
	
	<div class="col-sm-10"><strong>
	Select Examination City</strong>
		 <select tyle="display:none"  class="form-control select2" multiple="multiple"  name="city_name_val[]" id="city_name_val" style='text-transform:uppercase' >
		  <?php echo $this->common_options->center_city_name_option('');?>
        </select>  
	</div>


	
	
</div>







<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;Amenties Requirement</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Parking Facility:</strong><br />
		<input type="radio" name="parking_facility" id="parking_facility" value="yes" /> <label for="rad1">Yes</label>
		<input type="radio"  name="parking_facility" id="parking_facility" value="no" /> <label for="rad2">No	</label>
	</div>

	<div class="col-sm-3">
	<strong>Security Guard:</strong><br />
		<input type="radio" name="security_guard" id="security_guard" value="male" /><label for="rad1">Male</label>  
		<input type="radio"  name="security_guard" id="security_guard" value="female" /><label for="rad2">Female</label>  	
		<input type="radio"  name="security_guard" id="security_guard" value="both" /> <label for="rad3">Both</label> 	
	</div>
    
    <div class="col-sm-3">
	<strong>Locker:</strong><br />
	<input type="radio"  name="locker_facility" id="locker_facility" value="yes"/><label for="rad1">Yes</label>  
	<input type="radio"  name="locker_facility" id="locker_facility" value="no"/><label for="rad2">No</label>  
	</div>

	<div class="col-sm-3">
	<strong>Waiting Area:</strong><br />
	<input type="radio"  name="waiting_area" id="waiting_area" value="yes"/> <label for="rad1">Yes</label>  
	<input type="radio"  name="waiting_area" id="waiting_area" value="no"/> <label for="rad2">No</label> 
	</div>
 </div>
 <div class="form-group">   
    <div class="col-sm-3">
	<strong>Power Backup:</strong><br />
		<input type="radio" name="power_backup" id="power_backup" value="yes" /><label for="rad1">Yes</label>  
		<input type="radio"  name="power_backup" id="power_backup" value="no" /> <label for="rad2">No</label> 
    </div>

	<div class="col-sm-3">
	<strong>PH Handicapped:</strong><br />
		<input type="radio"  name="ph_handicaped" id="ph_handicaped" value="yes"/><label for="rad1">Yes</label>  
	<input type="radio"  name="ph_handicaped" id="ph_handicaped" value="no"/> <label for="rad2">No</label> 
	</div>

	<div class="col-sm-3">
	<strong>Printer:</strong><br />
		<input type="radio" name="printer" id="printer" value="yes" /> <label for="rad1">Yes</label>  
		<input type="radio"  name="printer" id="printer" value="no" /> <label for="rad2">No</label> 
     </div>
    
	<div class="col-sm-3">
	<strong>Rough Sheet:</strong><br />
		<input type="radio" name="rough_sheet" id="rough_sheet" value="yes" /> <label for="rad1">Yes</label>  
		<input type="radio"  name="rough_sheet" id="rough_sheet" value="no" /> <label for="rad2">No</label> 	
     </div>
</div>
<div class="form-group">
	
    <div class="col-sm-3">
	<strong>Partition:</strong><br />
		<input type="radio" name="partition_in_lab" id="partition_in_lab" value="yes" /> <label for="rad1">Yes</label>  
		<input type="radio"  name="partition_in_lab" id="partition_in_lab" value="no" /><label for="rad2">No</label> 	</div>
	
	<div class="col-sm-3">

	<strong>AC in Lab:</strong><br />
		<input type="radio" name="ac_in_lab" id="ac_in_lab" value="yes" /> <label for="rad1">Yes</label>  
		<input type="radio"  name="ac_in_lab" id="ac_in_lab" value="no" /> <label for="rad2">No</label> 
	</div>
    
	<div class="col-sm-3">
	<strong>CCTV Required:</strong><br />
		<input type="radio" name="cctv_required" id="cctv_required" value="yes" onClick="cctvhdsh1(this);" /> <label for="rad1">Yes</label>  
		<input type="radio"  name="cctv_required" id="cctv_required" value="no" onClick="cctvhdsh2(this);" /> <label for="rad2">No</label> 
	</div>
	
	<div class="col-sm-3" style="display:none;" id="cctvclp">
	<strong>Footage Required:</strong><br />
		<input type="radio" name="cctv_recording" id="cctv_recording" value="yes" /> <label for="rad1">Yes</label>  
		<input type="radio"  name="cctv_recording" id="cctv_recording" value="no" /><label for="rad2">No</label> 
	</div>
</div>



<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;Manpower Ratio</strong></span>
</div>


<div class="form-group">
	<div class="col-sm-3">
	<strong>Center Superintendent:</strong><br />
		<input type="text" name="center_suptn_ratio_1" class="" id="center_suptn_ratio_1" style="width:80px; height:28px" onkeypress="return isNumberKey(event)"> <strong>:</strong>
		<input type="text" name="center_suptn_ratio_2" class="" id="center_suptn_ratio_2" style="width:80px; height:28px" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-3">
	<strong>Technical Person Ratio:</strong><br />
		<input type="text" name="tech_person_ratio_1" class="" id="tech_person_ratio_1" style="width:80px; height:28px" onkeypress="return isNumberKey(event)"> <strong>:</strong>
		<input type="text" name="tech_person_ratio_2" class="" id="tech_person_ratio_2" style="width:80px; height:28px" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-3">
	<strong>Invigilator Ratio:</strong><br />
		<input type="text" name="invigilator_ratio_1" class="" id="invigilator_ratio_1" style="width:80px; height:28px" onkeypress="return isNumberKey(event)"> <strong>:</strong>
		<input type="text" name="invigilator_ratio_2" class="" id="invigilator_ratio_2" style="width:80px; height:28px" onkeypress="return isNumberKey(event)">
	</div>
	
	
	<div class="col-sm-3">
	<strong>Security Guard Ratio:</strong><br />
		<input type="text" name="security_guard_ratio_1" class="" id="security_guard_ratio_1" style="width:80px; height:28px" onkeypress="return isNumberKey(event)"> <strong>:</strong>
		<input type="text" name="security_guard_ratio_2" class="" id="security_guard_ratio_2" style="width:80px; height:28px" onkeypress="return isNumberKey(event)">
	</div>
	
		
</div>


<?php /*?>
<div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;City</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-6 addto-search">
	 <input class="key_serch_city" type="text" style="width:560px; height:28px" placeholder="Search by city">
		<div class="selectarea multiselect srch_opt" style="width:560px; ">
		 <?php 
	 foreach ($city_name_info as $row) { 
	 
	 $cityname = str_replace(" ","_",trim($row['city_name']));
	 
?>
	<ul>
        <li>
	<label><input type="checkbox" name="city_name_val[]" id="city_name_val"  value="<?php echo $row['city_id'] ?>" onClick="showMe('<?php echo $cityname ?>'); showChecked(); checkboxes();" /><?php echo ucwords(trim($row['city_name'])) ?> - [<?php echo ucwords(trim(get_state_name($row['state_id']))) ?>]</label>						  
		  </li>
    </ul>					  
						<?php } ?>
		</div>
 
</div>
<!--<div class="col-sm-6 addto-search" align="center">
	<div align="right" id="result" style="font-size:30px; background:#0F9; font-style:normal; color: #060; width:350px;">Total City Selected = 0</div>
</div>-->		 
</div> 
<div class="citybox">

</div>
<?php */?>


 <div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp</strong></span>
</div>   



    <div class="col-sm-5 control-label col-sm-offset-2">
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onClick="saveFrmDetails('add_project','save_btn')" value="Submit" style="width:150px; font-size:15px;">
		
		
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

<script type="text/javascript">
        $(function () {
            $("#adisel").change(function () {
               if ($(this).val() == "0") {
                   
                } else {
					$("#divexbatch1").hide();
                    $("#divexbatch2").hide();
					$("#divexbatch3").hide();
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
			  
			  
			    if ($(this).val() == "1") {
                    $("#divexbatch1").show();
                } else {
                    $("#divexbatch2").hide();
					$("#divexbatch3").hide();
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "2") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
                } else {
					$("#divexbatch3").hide();
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "3") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
					$("#divexbatch3").show();
                } else {
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "4") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
					$("#divexbatch3").show();
					$("#divexbatch4").show();
                } else {
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "5") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
					$("#divexbatch3").show();
					$("#divexbatch4").show();
					$("#divexbatch5").show();
                } else {
					
                }
            });
        });
		
		/////show hide
	function shownetwork1(str){
	if($(str).is(':checked')){
		$("#govt_job_div").show();
		$("#pvt_job_div").hide();
	}}
	function shownetwork2(str){
		if($(str).is(':checked')){
			$("#pvt_job_div").show();
			$("#govt_job_div").hide();
	}}

	function exammodes1(str){
	if($(str).is(':checked')){
		$("#internet_div").show();
		$("#server_div").hide();
		$("#server_div1").hide();
	}}
	function exammodes2(str){
		if($(str).is(':checked')){
			$("#server_div").show();
			$("#server_div1").show();
			$("#internet_div").hide();
	}}	
		
	function cctvhdsh1(str){
	if($(str).is(':checked')){
		$("#cctvclp").show();
	}}
	function cctvhdsh2(str){
		if($(str).is(':checked')){
			$("#cctvclp").hide();
	}}	
    </script>
	
<!--<script type="text/javascript"> 
	
function showMe (it) { 
	
var cnt=$('.citybox').html();
//alert(cnt.indexOf('div'+it));
if(cnt.indexOf('div'+it)>0){
$('#div'+it).remove();
}
else
{
	var myJavascriptVar = it;
	var inputElems = document.querySelectorAll("input:checked").length;
	
	<?php 
	//	$counts='';
	//	$myPhpVar =  "'+it+'";
	//	$counts="'+inputElems+'";
	?>

	
           $('.citybox').append('<div class="form-group row" id="div'+it+'" style="display: block;"><div class="col-sm-1"><strong><?php  // echo $counts ?> </strong><input type="hidden" name="exam_city_name[]" class="form-control" id="exam_city_name" value="'+ it +'" ></div><div class="col-sm-2"><strong>City :     <?php // echo $myPhpVar; ?></strong></div><div class="col-sm-2"><strong>Required Seat</strong><input type="text" name="exam_required_seat[]" class="form-control" id="exam_required_seat" required></div><div class="col-sm-2"><strong>No of Days</strong><input type="text" name="exam_req_days[]" class="form-control" id="exam_req_days" required></div></div> ');
}
	} 
	
</script>
<script>
(function($){
  $(".key_serch_city").on('keyup', function(e) {
    var $this = $(this);
    var exp = new RegExp($this.val(), 'i');
    $(".srch_opt li label").each(function() {
      var $self = $(this);
      if(!exp.test($self.text())) {
        $self.parent().hide();
      } else {
        $self.parent().show();
      }
    });
  });
})(jQuery);
</script>-->
