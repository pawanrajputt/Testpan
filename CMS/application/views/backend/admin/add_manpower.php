 <link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">

<div class="row">

    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            
            <div class="panel-body">			
                <form role="form" name="add_mpower" id="add_mpower" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_manpower_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />


<div class="form-group">

	<label for="field-1" class="col-sm-2 control-label">Manpower Category  <em style="color:#C00;">*</em> : </label>
	<div class="col-sm-4">
                    	<select  class="form-control" name="mp_type" id="mp_type" onchange="fl_select_option();" style='text-transform:uppercase'>
		  					<?php echo $this->common_options->select_manpower_category_options('');?>
        				</select>
	</div>
    
    <label for="field-1" class="col-sm-2 control-label" style="display:none;" id="fl_one">Freelancer Category <em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4" style="display:none;" id="fl_two">
                   <select  class="form-control" name="fl_type" id="fl_type" style='text-transform:uppercase'>
		 			  <?php echo $this->common_options->manpower_sub_catg_option('');?>
        		</select>

	</div>

</div>




<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Manpower Profle</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong >Vendor Name </strong>
		<input type="text" name="vendor_name" class="form-control" id="vendor_name" style='text-transform:uppercase'>
	</div>
    
   	<div class="col-sm-4">
	<strong >Client Name </strong>
		<input type="text" name="client_name" class="form-control" id="client_name" style='text-transform:uppercase'>
	</div>

	<div class="col-sm-4">
	<strong >Manpower Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="full_name" class="form-control" id="full_name" style='text-transform:uppercase'>
	</div>
  </div>
  
    
    <div class="form-group">

	<div class="col-sm-4">
	<strong>Contact No 1 <em style="color:#C00;">*</em></strong>
		<input type="text" name="contact_number" class="form-control" id="contact_number" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-4">
	<strong>Contact No 2 </strong>
		<input type="text" name="alternamt_contact_no" class="form-control" id="alternamt_contact_no" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
    
    <div class="col-sm-4">
	<strong>Email <em style="color:#C00;">*</em></strong>
		<input type="text" name="email" class="form-control" id="email" placeholder="Email">
	</div>
	
    
	
</div>

<div class="form-group">
	
	
	<div class="col-sm-4">
	<strong>Date of Birth </strong>
		<input type="text" name="date_of_birth" class="form-control datepicker" >
	</div>
	
	<div class="col-sm-4">
	<strong>Language Known</strong>
		 <input type="text" name="language" class="form-control" id="language" style='text-transform:uppercase' >
	</div>
	
	<div class="col-sm-2">
		<strong>Gender </strong><br>
		<i class="fa fa-male" aria-hidden="true"></i>
		<input type="radio"  name="gender" id="gender" value="male"/> Male
		<i class="fa fa-female" aria-hidden="true"></i>
		<input type="radio"  name="gender" id="gender" value="female"/> Female
	</div>
	
	<div class="col-sm-2">
	<strong>Photo </strong>
			<input type="file" name="photo" id="photo" /> <span style="color:#060; font-size:10px;">[Max: 1MB, jpg, jpeg]</span>
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Correspondence Address</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-5">
	<strong>Full Address </strong>
		 <input type="text" name="address" class="form-control" id="address" style='text-transform:uppercase' >
	</div>

	<div class="col-sm-3">
	<strong>Country </strong>
			 <select  class="form-control" name="country_id" id="country_id" onchange="loadStateList();">
		 		  <?php echo $this->common_options->country_list_options('');?>
         		</select>
	</div>

	<div class="col-sm-3">
	<strong>State </strong>
			 <select  class="form-control" name="state_id" id="state_id" onchange="load_city_data();" style='text-transform:uppercase'>
		   <?php echo $this->common_options->state_options('');?>
         </select>
	</div>
	
	
	
	

</div>

<div class="col-sm-4">
		<strong>City </strong>
		 <select  class="form-control" name="city_name" id="city_name">
		 			 <option value="">Select One</option>
         		</select>
	</div>
<div class="form-group">
<div class="col-sm-4">
	<strong>Pin Code </strong>
		<input type="text" name="pincode" class="form-control" id="pincode" maxlength="6" onkeypress="return isNumberKey(event)" >
	</div>
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Same as Permanent Address </strong>
		<input type="radio" name="add_status" id="add_status" value="yes" onClick="add_status1(this);" /> Yes
		<input type="radio"  name="add_status" id="add_status" value="no" onClick="add_status2(this);" /> No
	</div>
	
</div>

<div class="form-group" id="perma_add" style="display:none;">

	<div class="col-sm-5">
	<strong>Permanent Address </strong>
		 <input type="text" name="permanent_address" class="form-control" id="permanent_address" style='text-transform:uppercase' >
	</div>

	<div class="col-sm-3">
	<strong>State </strong>
				<select  class="form-control" name="state_id_p" id="state_id_p" onchange="loadCity_p();" style='text-transform:uppercase'>
		  <?php echo $this->common_options->state_options('');?>
        </select>
	</div>
	
	<div class="col-sm-3">
	<strong>State </strong>
				<select  class="form-control" name="state_id_p" id="state_id_p" onchange="loadCity_p();" style='text-transform:uppercase'>
		  <?php echo $this->common_options->state_options('');?>
        </select>
	</div>
</div>	
<div class="form-group">

<div class="col-sm-2">
		<strong>City </strong>
		<select  class="form-control" name="city_p" id="city_p" style='text-transform:uppercase'>
		   <?php echo $this->common_options->get_city_list('');?>
        </select>
	</div>



	<div class="col-sm-2">
	<strong>Pin Code </strong>
		<input type="text" name="pincode_p" class="form-control" id="pincode_p" maxlength="6" onkeypress="return isNumberKey(event)" >
	</div>

</div>

<div class="form-group">

	<div class="col-sm-3">
		<strong>Ready to Travell </strong><br>
		
		<input type="radio"  name="ready_to_travel" id="ready_to_travel" value="yes"/> Yes
		
		<input type="radio"  name="ready_to_travel" id="ready_to_travel" value="no"/> No
	</div>

</div>


<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Social Media Profile</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Linkedin </strong>
	<i class="fa fa-linkedin-square" aria-hidden="true"></i>
		<input type="text" name="linkedin" class="form-control" id="linkedin" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-3">
	<strong>Twitter </strong>
	<i class="fa fa-twitter-square" aria-hidden="true"></i>
		<input type="text" name="twitter" class="form-control" id="twitter" >
	</div>
	
	<div class="col-sm-3">
	<strong>Facebook </strong>
	<i class="fa fa-facebook" aria-hidden="true"></i>
		<input type="text" name="facebook" class="form-control" id="facebook" >
	</div>

	<div class="col-sm-3">
	<strong>Instagram </strong>
	<i class="fa fa-instagram" aria-hidden="true"></i>
		<input type="text" name="instagram" class="form-control" id="instagram" >
	</div>	
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Parents Details</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Father's Name </strong>
		<input type="text" name="father_name" class="form-control" id="father_name" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Contact No </strong>
		<input type="text" name="father_contact_no" class="form-control" id="father_contact_no" >
	</div>
	
	<div class="col-sm-2">
	<strong>Occupation </strong>
		<input type="text" name="occupation" class="form-control" id="occupation" >
	</div>	
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Acadmic Qualification</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-4">
	<strong>Matriculation</strong>
		<input type="text" name="matric" class="form-control" id="matric" placeholder="Board Name" >
	</div>
	
	<div class="col-sm-4">
	<strong>School Name</strong>
		<input type="text" name="matric_school" class="form-control" id="matric_school" placeholder="School Name">
	</div>
	
	<div class="col-sm-2">
	<strong>Passing Year</strong>
		<input type="text" name="matric_year" class="form-control" id="matric_year" placeholder="Year" >
	</div>
	
	<div class="col-sm-2">
	<strong>Marksheet Upload  <?php if($mp_details->marksheet_tenth==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="marksheet_ten" id="marksheet_ten" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>

</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Intermediate</strong>
		<input type="text" name="intermediate" class="form-control" id="intermediate" placeholder="Board Name" >
	</div>
	
	<div class="col-sm-4">
	<strong>School Name</strong>
		<input type="text" name="intermediate_school" class="form-control" id="intermediate_school" placeholder="School Name">
	</div>
	
	<div class="col-sm-2">
	<strong>Passing Year</strong>
		<input type="text" name="intermediate_year" class="form-control" id="intermediate_year" placeholder="Year" >
	</div>
	
	<div class="col-sm-2">
	<strong>Marksheet Upload  <?php if($mp_details->marksheet_intermediate==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="marksheet_inter" id="marksheet_inter" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Professinal Qualification</strong></span>
</div>

<div class="form-group">
	
	<div class="col-sm-3">
		<strong>Bachelors Degree</strong>
		
					<select name="bachelor" class="form-control">
						  <option value="">SELECT</option>
						  <option value="1">BACHELOR of ARTS</option>
						  <option value="2">BACHELOR of SCIENCE</option>
						  <option value="3">BACHELOR of COMMERCE</option>
						  <option value="4">BACHELOR of ENGG/TECH</option>
						  <option value="5">BACHELOR of COMPUTER SCIENCE</option>
						  <option value="6">BACHELOR of SCIENCE</option>
						  <option value="7">BACHELOR of SCIENCE</option>
						  <option value="8">BACHELOR of SCIENCE</option>
					</select>
	</div>
	
	<div class="col-sm-2">
	<strong>Status</strong>
		<select name="bachelor_st" id="bachelor_st" class="form-control" onClick="acadmic_status(this);">
						  <option value="">SELECT</option>
						  <option value="1">PURSUING</option>
						  <option value="2">COMPLETED</option>
					</select>
	</div>
	
	<div class="col-sm-5">
	<strong>University Name</strong>
		<input type="text" name="university" class="form-control" id="university" placeholder="Board Name">
	</div>
	
	<div class="col-sm-2">
		<strong>Year</strong>
					<select name="batchelor_sem" class="form-control">
						  <option value="">SELECT</option>
						  <option value="1">FIRST</option>
						  <option value="2">SECOND</option>
						  <option value="2">THIRD</option>
					</select>
	</div>

</div>
	
<div class="form-group" id="acadmic_div"  style="display:none;">

	<div class="col-sm-2">
	<strong>Passing Year</strong>
		<input type="text" name="bachelor_year" class="form-control" id="bachelor_year" placeholder="Year" >
	</div>
	
	<div class="col-sm-2">
	<strong>Marksheet Upload  <?php if($mp_details->marksheet_intermediate==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="marksheet_batchelor" id="marksheet_batchelor" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>

</div>



<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Technical Skills</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Course Name</strong>
		<input type="text" name="course" class="form-control" id="course" >
	</div>
	
	<div class="col-sm-4">
	<strong>Subject</strong>
		<input type="text" name="subject" class="form-control" id="subject" >
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Experience Details</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
		<strong>Experience in Exams Field </strong></br>
		<input type="radio" name="experience_online_exam" id="experience_online_exam" value="yes" onClick="expjob1(this);" /> Yes
		<input type="radio" name="experience_online_exam" id="experience_online_exam" value="any_others" onClick="expjob2(this);" /> Any Others
	</div>
	
	<div class="col-sm-3" style="display:none;" id="exp_exam">
		<strong>Worked Mode </strong></br>
		<input type="radio" name="work_mode" id="work_mode" value="online" onClick="online(this);" /> Online
		<input type="radio"  name="work_mode" id="work_mode" value="offline" onClick="offline(this);" /> Offline
	</div>
	
</div>
	
<div class="form-group" style="display:none;" id="exp_online">

	<div class="col-sm-3">
	<strong>Company Name </strong>
		<input type="text" name="company" class="form-control" id="company" >
	</div>
	
	<div class="col-sm-3">
	<strong>Designation </strong>
		<input type="text" name="designation" class="form-control" id="designation" >
	</div>
	
	<div class="col-sm-3">
	<strong>Project Name </strong>
		<input type="text" name="project" class="form-control" id="project" >
	</div>

	<div class="col-sm-3">
	<strong>Experience Month </strong>
		<input type="text" name="experience" class="form-control" id="experience" >
	</div>
	
</div>

<div class="form-group">
<div class="col-sm-2">
	<strong>Resume Upload  <?php if($mp_details->resume_upload==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="resume_upload" id="resume_upload" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>
</div>

<div class="form-group" style="display:none;" id="exp_offline">

	<div class="col-sm-3">
	<strong>Company Name </strong>
		<input type="text" name="experience_other" class="form-control" id="experience_other" >
	</div>
	
	<div class="col-sm-3">
	<strong>Designation </strong>
		<input type="text" name="other_designation" class="form-control" id="other_designation" >
	</div>
	
	<div class="col-sm-3">
	<strong>Job Responsblity </strong>
		<input type="text" name="other_job" class="form-control" id="other_job" >
	</div>

	<div class="col-sm-3">
	<strong>Experience Month </strong>
		<input type="text" name="other_exp" class="form-control" id="other_exp" >
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Goverment Issued ID</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Aadhar No </strong>
		<input type="text" name="aadhar" class="form-control" id="aadhar" >
	</div>
	
	<div class="col-sm-2">
	<strong>PAN No </strong>
		<input type="text" name="pan" class="form-control" id="pan" maxlength="10" >
	</div>
	
	<div class="col-sm-2">
	<strong>Passport</strong>
		<input type="text" name="passport" class="form-control" id="passport" >
	</div>

	<div class="col-sm-2">
	<strong>DL No</strong>
		<input type="text" name="driving" class="form-control" id="driving" >
	</div>
	
	<div class="col-sm-2">
	<strong>Voter ID</strong>
		<input type="text" name="voter" class="form-control" id="voter" >
	</div>

</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Aadhar Card </strong>
			<input type="file" name="aadhar1" id="aadhar1" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>
	
	<div class="col-sm-2">
	<strong>PAN Card </strong>
			<input type="file" name="pan1" id="pan1" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>
	
	<div class="col-sm-2">
	<strong>Passport</strong> 
			<input type="file" name="passport1" id="passport1" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>
	
	<div class="col-sm-2">
	<strong>Driving Licence</strong> 
			<input type="file" name="dl1" id="dl1" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>
	
	<div class="col-sm-2">
	<strong>Voter ID</strong> 
			<input type="file" name="voter1" id="voter1" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Identity Verification</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Police Verification Certificate No</strong>
		<input type="text" name="p_verification" class="form-control" id="p_verification" >
	</div>
	
	<div class="col-sm-2">
	<strong>Last Verification Date</strong>
		<input type="text" name="p_verification_dt" class="form-control datepicker" id="p_verification_dt" >
	</div>
	
	<div class="col-sm-3">
	<strong>Police Verification Certificate</strong> 
			<input type="file" name="p_verification_crtft" id="p_verification_crtft" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>
	
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>BGC Report No</strong>
		<input type="text" name="bgc_report" class="form-control" id="bgc_report" >
	</div>
	
	<div class="col-sm-2">
	<strong>Last Verification Date</strong>
		<input type="text" name="bgc_report_dt" class="form-control datepicker" id="bgc_report_dt" >
	</div>
	
	<div class="col-sm-3">
	<strong>BGC Report</strong> 
			<input type="file" name="bgc_report_crtft" id="bgc_report_crtft" /> <span style="color:#060; font-size:10px;">[Max: 2MB, PDF]</span>
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Banking Details</strong></span>
</div>

<div class="form-group">
	
	<div class="col-sm-4">
	<strong>Beneficiary Name </strong>
		<input type="text" name="benf_name" class="form-control" id="benf_name" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Account Number </strong>
		<input type="text" name="bank_account_no" class="form-control" id="bank_account_no" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>IFSC Code </strong>
		<input type="text" name="bank_ifsc_code" class="form-control" id="bank_ifsc_code" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Bank Name </strong>
        <select  class="form-control" name="bank_name" id="bank_name" style='text-transform:uppercase'>
		  <?php echo $this->common_options->select_bank_name('');?>
        </select>
	</div>
	
	<div class="col-sm-2">
	<strong>Passbook </strong>
			<input type="file" name="passbook" id="passbook" /> <span style="color:#060; font-size:10px;">[Max: 1MB]</span>
	</div>
	
</div>

    <div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
     <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_mpower','save_btn')" value="Submit">
	 
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p>
    <p id="error_msg" style="color:#FF0000;"></p>		</div>
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




	function add_status1(str){
	if($(str).is(':checked')){
		$("#perma_add").hide();
	} else 
		$("#perma_add").show();
	}
	
	function add_status2(str){
		if($(str).is(':checked')){
			$("#perma_add").show();
	} else 
		$("#perma_add").hide();
	}
	
	function expjob1(str){
	if($(str).is(':checked')){
		$("#exp_exam").show();
	} else 
		$("#exp_exam").hide();
		$("#exp_offline").hide();
	}
	
	function expjob2(str){
		if($(str).is(':checked')){
			$("#exp_offline").show();
	} else 
		$("#exp_offline").hide();
		$("#exp_exam").hide();
		$("#exp_online").hide();
	}
	
	function online(str){
	if($(str).is(':checked')){
		$("#exp_online").show();
	} else 
		$("#exp_exam").hide();
		$("#exp_offline").hide();
	}
	
	function offline(str){
	if($(str).is(':checked')){
		$("#exp_online").show();
	} else 
		$("#exp_exam").hide();
		$("#exp_offline").hide();
	}
	

$('#bachelor_st').on('change', function () {
    if(this.value === "2"){
        $("#acadmic_div").show();
    } else {
        $("#acadmic_div").hide();
    }
});
	
</script>

<script>
function fl_select_option(){
	var mp_type = $.trim($("#mp_type").val());
	var fl_type = $.trim($("#fl_type").val());
	if(mp_type==""){
		return false;
	}
	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
		
	var datastring = "mp_type="+mp_type+"&fl_type="+fl_type;	
	var url = "<?php echo base_url();?>index.php?admin/load_freelancer_type";	
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
			$("#fl_type").html(message);
		}		
	});
}

</script>

<script type="text/javascript">
        $(function () {
            $("#mp_type").change(function () {
               if ($(this).val() == "0") {
                   
                } else {
					$("#fl_one").hide();
                    $("#fl_two").hide();
                }
			  
			  
			    if ($(this).val() == "1") {
                    $("#fl_one").hide();
					$("#fl_two").hide();
                }
				if ($(this).val() == "2") {
                    $("#fl_one").show();
					$("#fl_two").show();
                } 
				else {
					
                }
            });
        });
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