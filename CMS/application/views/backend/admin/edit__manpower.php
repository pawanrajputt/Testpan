<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">

<div class="row">

    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <span style="float:right"> *Uploaded: [&#10004; ], Not Uploaded: [ &#10006; ]  </span>
            <div class="panel-body">			
                <form role="form" name="edit_mpower" id="edit_mpower" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_manpower_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

<div class="form-group">

	<label for="field-2" class="col-sm-1 control-label">Status : </label>
	<div class="col-sm-3">
					<select name="deleted" id="deleted" class="form-control" style="background-color: #00FF66">
						  <option value="0" <?php if($mp_details->deleted==0){?> selected="selected"<?php } ?>>Active</option>
						  <option value="1" <?php if($mp_details->deleted==1){?> selected="selected"<?php } ?>>Inactive</option>
						  <option value="2" <?php if($mp_details->deleted==2){?> selected="selected"<?php } ?>>Deleted</option>
					</select> 
	</div>

</div>


<div class="form-group">

	<label for="field-2" class="col-sm-2 control-label">Manpower Category  <em style="color:#C00;">*</em> : </label>
	<div class="col-sm-4">
                    	<select  class="form-control" name="mp_type" id="mp_type" onchange="fl_select_option();" style='text-transform:uppercase'>
		  					<?php echo $this->common_options->select_manpower_category_options($mp_details->mp_type);?>
        				</select>
	</div>
    
    <label for="field-2" class="col-sm-2 control-label" <?php if($mp_details->mp_type!=2){?> style="display:none;" <?php } ?>id="fl_one">Freelancer Category <em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4" <?php if($mp_details->mp_type!=2){?> style="display:none;" <?php } ?> id="fl_two">
                   <select  class="form-control" name="fl_type" id="fl_type" style='text-transform:uppercase'>
		 			  <?php echo $this->common_options->manpower_sub_catg_option($mp_details->freelance_type);?>
        		</select>

	</div>
	
	

</div>


<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Manpower Profle</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong >Vendor Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="vendor_name" class="form-control" id="vendor_name" style='text-transform:uppercase' value="<?php echo $mp_details->vendor_name;?>" required>
	</div>
	
	<div class="col-sm-4">
	<strong >Client Name </strong>
		<input type="text" name="client_name" class="form-control" id="client_name" style='text-transform:uppercase' value="<?php echo $mp_details->client_name;?>">
	</div>


	<div class="col-sm-4">
	<strong >Manpower Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="full_name" class="form-control" id="full_name" style='text-transform:uppercase' value="<?php echo $mp_details->full_name;?>">
	</div>
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Contact No 1 <em style="color:#C00;">*</em></strong>
		<input type="text" name="contact_number" class="form-control" id="contact_number" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $mp_details->contact_number;?>" >
	</div>
	
	<div class="col-sm-4">
	<strong>Contact No 2 <em style="color:#C00;">*</em></strong>
		<input type="text" name="alternamt_contact_no" class="form-control" id="alternamt_contact_no" maxlength="10" onkeypress="return isNumberKey(event)"  <?php echo $mp_details->alternamt_contact_no;?>>
	</div>
	
	<div class="col-sm-4">
	<strong>Email <em style="color:#C00;">*</em></strong>
		<input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $mp_details->email;?>">
	</div>
	
</div>

<div class="form-group">
	
	
	
	<div class="col-sm-4">
	<strong>Date of Birth <em style="color:#C00;">*</em></strong>
		<input type="text" name="date_of_birth" class="form-control datepicker" value="<?php if($mp_details->date_of_birth){ echo date('d/m/Y', strtotime($mp_details->date_of_birth));}?>"> 
	</div>
	
	<div class="col-sm-4">
	<strong>Language Known <em style="color:#C00;">*</em></strong>
		 <input type="text" name="language" class="form-control" id="language" style='text-transform:uppercase' value="<?php echo $mp_details->language;?>" >
	</div>
	
	<div class="col-sm-2">
		<strong>Gender <em style="color:#C00;">*</em></strong><br>
		<i class="fa fa-male" aria-hidden="true"></i>
		<input type="radio"  name="gender" id="gender" value="male"/ <?php if($mp_details->gender=='male'){ ?> checked="checked"<?php } ?>> Male
		<i class="fa fa-female" aria-hidden="true"></i>
		<input type="radio"  name="gender" id="gender" value="female"/ <?php if($mp_details->gender=='female'){ ?> checked="checked"<?php } ?>> Female
	</div>
	
	<div class="col-sm-2">
	<strong>Photo <em style="color:#C00;">* </em><?php if($mp_details->user_pic==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="photo" id="photo" /> <span style="color:#060; font-size:10px;">[Max: 1MB, jpg, jpeg]</span>
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Correspondence Address</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-5">
	<strong>Full Address <em style="color:#C00;">*</em></strong>
		 <input type="text" name="address" class="form-control" id="address" style='text-transform:uppercase' value="<?php echo $mp_details->address;?>" >
	</div>

	<div class="col-sm-3">
	<strong>State <em style="color:#C00;">*</em></strong>
				<select  class="form-control" name="state_id" id="state_id" onchange="loadCity();" style='text-transform:uppercase'>
		  <?php echo $this->common_options->state_options($mp_details->state);?> 
        </select>
	</div>
	
	<div class="col-sm-2">
		<strong>City <em style="color:#C00;">*</em></strong>
		<select  class="form-control" name="city" id="city" style='text-transform:uppercase'>
		   <?php echo $this->common_options->get_city_list($mp_details->city);?>
        </select>
	</div>
	
	<div class="col-sm-2">
	<strong>Pin Code <em style="color:#C00;">*</em></strong>
		<input type="text" name="pincode" class="form-control" id="pincode" maxlength="6" onkeypress="return isNumberKey(event)" value="<?php echo $mp_details->pincode;?>"  >
	</div>

</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Same as Permanent Address <em style="color:#C00;">*</em></strong>
		<input type="radio" name="add_status" id="add_status" value="yes" onClick="add_status1(this);" <?php if($mp_details->add_status=='yes'){?> checked="checked"<?php } ?>/> Yes
		<input type="radio"  name="add_status" id="add_status" value="no" onClick="add_status2(this);" <?php if($mp_details->add_status=='no'){?> checked="checked"<?php } ?>/> No
	</div>
	
</div>

<div class="form-group" id="perma_add" <?php if($mp_details->add_status=='yes'){?> style="display:none;" <?php } ?>>

	<div class="col-sm-5">
	<strong>Permanent Address <em style="color:#C00;">*</em></strong>
		 <input type="text" name="permanent_address" class="form-control" id="permanent_address" style='text-transform:uppercase' value="<?php echo $mp_details->permanent_address;?>">
	</div>

	<div class="col-sm-3">
	<strong>State <em style="color:#C00;">*</em></strong>
				<select  class="form-control" name="state_id_p" id="state_id_p" onchange="loadCity_p();" style='text-transform:uppercase'>
		  <?php echo $this->common_options->state_options($mp_details->state_id_p);?>
        </select>
	</div>
	
	<div class="col-sm-2">
		<strong>City <em style="color:#C00;">*</em></strong>
		<select  class="form-control" name="city_p" id="city_p" style='text-transform:uppercase'>
		   <?php echo $this->common_options->get_city_list($mp_details->city_p);?>
        </select>
	</div>
	
	<div class="col-sm-2">
	<strong>Pin Code <em style="color:#C00;">*</em></strong>
		<input type="text" name="pincode_p" class="form-control" id="pincode_p" maxlength="6" onkeypress="return isNumberKey(event)" value="<?php echo $mp_details->pincode_p;?>">
	</div>

</div>

<div class="form-group">

	<div class="col-sm-3">
		<strong>Ready to Travell </strong><br>
		
		<input type="radio"  name="ready_to_travel" id="ready_to_travel" value="yes" <?php if($mp_details->ready_to_travel=='yes'){?> checked="checked"<?php } ?>/> Yes
		
		<input type="radio"  name="ready_to_travel" id="ready_to_travel" value="no" <?php if($mp_details->ready_to_travel=='no'){?> checked="checked"<?php } ?>/> No
	</div>

</div>


<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Social Media Profile</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Linkedin </strong>
	<i class="fa fa-linkedin-square" aria-hidden="true"></i>
		<input type="text" name="linkedin" class="form-control" id="linkedin" style='text-transform:uppercase' value="<?php echo $mp_details->linkedin;?>">
	</div>
	
	<div class="col-sm-3">
	<strong>Twitter </strong>
	<i class="fa fa-twitter-square" aria-hidden="true"></i>
		<input type="text" name="twitter" class="form-control" id="twitter" value="<?php echo $mp_details->twitter;?>" >
	</div>
	
	<div class="col-sm-3">
	<strong>Facebook </strong>
	<i class="fa fa-facebook" aria-hidden="true"></i>
		<input type="text" name="facebook" class="form-control" id="facebook" value="<?php echo $mp_details->facebook;?>" >
	</div>

	<div class="col-sm-3">
	<strong>Instagram </strong>
	<i class="fa fa-instagram" aria-hidden="true"></i>
		<input type="text" name="instagram" class="form-control" id="instagram" value="<?php echo $mp_details->instagram;?>">
	</div>	
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Parents Details</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Father's Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="father_name" class="form-control" id="father_name" style='text-transform:uppercase' value="<?php echo $mp_details->father_name;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Contact No </strong>
		<input type="text" name="father_contact_no" class="form-control" id="father_contact_no" value="<?php echo $mp_details->father_contact_no;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Occupation <em style="color:#C00;">*</em></strong>
		<input type="text" name="occupation" class="form-control" id="occupation" value="<?php echo $mp_details->occupation;?>">
	</div>	
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Acadmic Qualification</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-4">
	<strong>Matriculation</strong>
		<input type="text" name="matric" class="form-control" id="matric" placeholder="Board Name" value="<?php echo $mp_details->matric;?>">
	</div>
	
	<div class="col-sm-4">
	<strong>School Name</strong>
		<input type="text" name="matric_school" class="form-control" id="matric_school" placeholder="School Name" value="<?php echo $mp_details->matric_school;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Passing Year</strong>
		<input type="text" name="matric_year" class="form-control" id="matric_year" placeholder="Year" value="<?php echo $mp_details->matric_year;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Marksheet Upload  <?php if($mp_details->marksheet_tenth==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="marksheet_ten" id="marksheet_ten" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>

</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Intermediate</strong>
		<input type="text" name="intermediate" class="form-control" id="intermediate" placeholder="Board Name" value="<?php echo $mp_details->intermediate;?>">
	</div>
	
	<div class="col-sm-4">
	<strong>School Name</strong>
		<input type="text" name="intermediate_school" class="form-control" id="intermediate_school" placeholder="School Name" value="<?php echo $mp_details->intermediate_school;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Passing Year</strong>
		<input type="text" name="intermediate_year" class="form-control" id="intermediate_year" placeholder="Year" value="<?php echo $mp_details->intermediate_year;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Marksheet Upload  <?php if($mp_details->marksheet_intermediate==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="marksheet_inter" id="marksheet_inter" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
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
						  <option value="1" <?php if($mp_details->bachelor=='1'){?> selected="selected"<?php } ?> >BACHELOR of ARTS</option>
						  <option value="2" <?php if($mp_details->bachelor=='2'){?> selected="selected"<?php } ?> >BACHELOR of SCIENCE</option>
						  <option value="3" <?php if($mp_details->bachelor=='3'){?> selected="selected"<?php } ?> >BACHELOR of COMMERCE</option>
						  <option value="4" <?php if($mp_details->bachelor=='4'){?> selected="selected"<?php } ?> >BACHELOR of ENGG/TECH</option>
						  <option value="5" <?php if($mp_details->bachelor=='5'){?> selected="selected"<?php } ?> >BACHELOR of COMPUTER SCIENCE</option>
						  <option value="6" <?php if($mp_details->bachelor=='6'){?> selected="selected"<?php } ?> >BACHELOR of SCIENCE</option>
						  <option value="7" <?php if($mp_details->bachelor=='7'){?> selected="selected"<?php } ?> >BACHELOR of SCIENCE</option>
						  <option value="8" <?php if($mp_details->bachelor=='8'){?> selected="selected"<?php } ?> >BACHELOR of SCIENCE</option>
					</select>
	</div>
	
	<div class="col-sm-2">
	<strong>Status</strong>
		<select name="bachelor_st" id="bachelor_st" class="form-control" onClick="acadmic_status(this);">
						  <option value="">SELECT</option>
						  <option value="1" <?php if($mp_details->bachelor_st=='1'){?> selected="selected" <?php } ?>>PURSUING</option>
						  <option value="2" <?php if($mp_details->bachelor_st=='2'){?> selected="selected" <?php } ?>>COMPLETED</option>
					</select>
	</div>
	
	<div class="col-sm-5">
	<strong>University Name</strong>
		<input type="text" name="university" class="form-control" id="university" placeholder="Board Name" value="<?php echo $mp_details->university;?>">
	</div>
	
	<div class="col-sm-2">
		<strong>Year</strong>
					<select name="batchelor_sem" class="form-control">
						  <option value="">SELECT</option>
						  <option value="1" <?php if($mp_details->batchelor_sem=='1'){?> selected="selected" <?php } ?>>FIRST</option>
						  <option value="2" <?php if($mp_details->batchelor_sem=='2'){?> selected="selected" <?php } ?>>SECOND</option>
						  <option value="3" <?php if($mp_details->batchelor_sem=='3'){?> selected="selected" <?php } ?>>THIRD</option>
						   <option value="4" <?php if($mp_details->batchelor_sem=='4'){?> selected="selected" <?php } ?>>FOURTH</option>
					</select>
	</div>

</div>
	
<div class="form-group" id="acadmic_div" <?php if($mp_details->bachelor_st=='1'){?> style="display:none;" <?php } ?>>

	<div class="col-sm-2">
	<strong>Passing Year</strong>
		<input type="text" name="bachelor_year" class="form-control" id="bachelor_year" placeholder="Year" value="<?php echo $mp_details->bachelor_year;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Marksheet Upload  <?php if($mp_details->marksheet_intermediate==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="marksheet_batchelor" id="marksheet_batchelor" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Technical Skills</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Course Name</strong>
		<input type="text" name="course" class="form-control" id="course" value="<?php echo $mp_details->course;?>">
	</div>
	
	<div class="col-sm-4">
	<strong>Subject</strong>
		<input type="text" name="subject" class="form-control" id="subject" value="<?php echo $mp_details->subject;?>">
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Experience Details</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
		<strong>Experience in Exams Field <em style="color:#C00;">*</em></strong></br>
		<input type="radio" name="experience_online_exam" id="experience_online_exam" value="yes" onClick="expjob1(this);" <?php if($mp_details->experience_online_exam=='yes'){?> checked="checked"<?php } ?> /> Yes
		<input type="radio" name="experience_online_exam" id="experience_online_exam" value="any_others" onClick="expjob2(this);" <?php if($mp_details->experience_online_exam=='any_others'){?> checked="checked"<?php } ?>/> Any Others
	</div>
	
	<div class="col-sm-3" <?php if($mp_details->experience_online_exam=='any_others'){?>  style="display:none;" <?php } ?> id="exp_exam">
		<strong>Worked Mode </strong></br>
		<input type="radio" name="work_mode" id="work_mode" value="online" onClick="online(this);" <?php if($mp_details->work_mode=='online'){?> checked="checked"<?php } ?> /> Online
		<input type="radio"  name="work_mode" id="work_mode" value="offline" onClick="offline(this);" <?php if($mp_details->work_mode=='offline'){?> checked="checked"<?php } ?> /> Offline
	</div>
	
	
	
</div>
	
<div class="form-group" <?php if($mp_details->experience_online_exam=='yes' && $mp_details->work_mode==''){?> style="display:none;" <?php } ?> id="exp_online">

	<div class="col-sm-3">
	<strong>Company Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="company" class="form-control" id="company" value="<?php echo $mp_details->company;?>">
	</div>
	
	<div class="col-sm-3">
	<strong>Designation <em style="color:#C00;">*</em></strong>
		<input type="text" name="designation" class="form-control" id="designation" value="<?php echo $mp_details->designation;?>">
	</div>
	
	<div class="col-sm-3">
	<strong>Project Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="project" class="form-control" id="project" value="<?php echo $mp_details->project;?>">
	</div>

	<div class="col-sm-3">
	<strong>Experience Month <em style="color:#C00;">*</em></strong>
		<input type="text" name="experience" class="form-control" id="experience" value="<?php echo $mp_details->experience;?>">
	</div>
	

</div>

<div class="form-group" style="display:none;" id="exp_offline">

	<div class="col-sm-3">
	<strong>Company Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="experience_other" class="form-control" id="experience_other" value="<?php echo $mp_details->experience_other;?>">
	</div>
	
	<div class="col-sm-3">
	<strong>Designation <em style="color:#C00;">*</em></strong>
		<input type="text" name="other_designation" class="form-control" id="other_designation" value="<?php echo $mp_details->other_designation;?>">
	</div>
	
	<div class="col-sm-3">
	<strong>Job Responsblity <em style="color:#C00;">*</em></strong>
		<input type="text" name="other_job" class="form-control" id="other_job" value="<?php echo $mp_details->other_job;?>">
	</div>

	<div class="col-sm-3">
	<strong>Experience Month <em style="color:#C00;">*</em></strong>
		<input type="text" name="other_exp" class="form-control" id="other_exp" value="<?php echo $mp_details->other_exp;?>">
	</div>
	
</div>
<div class="form-group">
<div class="col-sm-2">
	<strong>Resume Upload  <?php if($mp_details->resume_upload==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="resume_upload" id="resume_upload" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>
</div>
<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Goverment Issued ID</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Aadhar No <em style="color:#C00;">*</em>  </strong>
		<input type="text" name="aadhar" class="form-control" id="aadhar" value="<?php echo $mp_details->aadhar;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>PAN No <em style="color:#C00;">*</em> </strong>
		<input type="text" name="pan" class="form-control" id="pan" maxlength="10" value="<?php echo $mp_details->pan;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Passport</strong>
		<input type="text" name="passport" class="form-control" id="passport" value="<?php echo $mp_details->passport;?>">
	</div>

	<div class="col-sm-2">
	<strong>DL No</strong>
		<input type="text" name="driving" class="form-control" id="driving" value="<?php echo $mp_details->driving;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Voter ID</strong>
		<input type="text" name="voter" class="form-control" id="voter" value="<?php echo $mp_details->voter;?>">
	</div>

</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Aadhar Card <em style="color:#C00;">*</em> <?php if($mp_details->aadhar_pic==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="aadhar1" id="aadhar1" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>
	
	<div class="col-sm-2">
	<strong>PAN Card <em style="color:#C00;">*</em> <?php if($mp_details->pan_pic==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="pan1" id="pan1" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>
	
	<div class="col-sm-2">
	<strong>Passport  <?php if($mp_details->passport_pic==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong> 
			<input type="file" name="passport1" id="passport1" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>
	
	<div class="col-sm-2">
	<strong>Driving Licence  <?php if($mp_details->driving_lic_pic==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong> 
			<input type="file" name="dl1" id="dl1" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>
	
	<div class="col-sm-2">
	<strong>Voter ID  <?php if($mp_details->votor_card_pic==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong> 
			<input type="file" name="voter1" id="voter1" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Identity Verification</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Police Verification Certificate No</strong>
		<input type="text" name="p_verification" class="form-control" id="p_verification" value="<?php echo $mp_details->p_verification;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Last Verification Date</strong>
		<input type="text" name="p_verification_dt" class="form-control datepicker" id="p_verification_dt" value="<?php if($mp_details->p_verification_dt){ echo date('d/m/Y', strtotime($mp_details->p_verification_dt));}?>">
	</div>
	
	<div class="col-sm-3">
	<strong>Police Verification Certificate  <?php if($mp_details->police_verf_pic==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong> 
			<input type="file" name="p_verification_crtft" id="p_verification_crtft" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>
	
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>BGC Report No </strong>
		<input type="text" name="bgc_report" class="form-control" id="bgc_report" value="<?php echo $mp_details->bgc_report;?>" >
	</div>
	
	<div class="col-sm-2">
	<strong>Last Verification Date</strong>
		<input type="text" name="bgc_report_dt" class="form-control datepicker" id="bgc_report_dt" value="<?php if($mp_details->bgc_report_dt){ echo date('d/m/Y', strtotime($mp_details->bgc_report_dt));}?>">
	</div>
	
	<div class="col-sm-3">
	<strong>BGC Report  <?php if($mp_details->bgc_report_dt==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong> 
			<input type="file" name="bgc_report_crtft" id="bgc_report_crtft" /> <span style="color:#060; font-size:10px;">[Max: 2MB, PDF]</span>
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Banking Details</strong></span>
</div>

<div class="form-group">
	
	<div class="col-sm-4">
	<strong>Beneficiary Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="benf_name" class="form-control" id="benf_name" style='text-transform:uppercase' value="<?php echo $mp_details->benf_name;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Account Number <em style="color:#C00;">*</em></strong>
		<input type="text" name="bank_account_no" class="form-control" id="bank_account_no" style='text-transform:uppercase' value="<?php echo $mp_details->bank_account_number;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>IFSC Code <em style="color:#C00;">*</em></strong>
		<input type="text" name="bank_ifsc_code" class="form-control" id="bank_ifsc_code" style='text-transform:uppercase' value="<?php echo $mp_details->bank_ifsc_code;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Bank Name <em style="color:#C00;">*</em></strong>
        <select  class="form-control" name="bank_name" id="bank_name" style='text-transform:uppercase'>
		  <?php echo $this->common_options->select_bank_name($mp_details->bank_name);?>
        </select>
	</div>
	
	<div class="col-sm-2">
	<strong>Passbook <em style="color:#C00;">*</em> <?php if($mp_details->bank_pbk_image==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
			<input type="file" name="passbook" id="passbook" /> <span style="color:#060; font-size:10px;">[Max: 1MB, PDF]</span>
	</div>
	
</div>

    <div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
     <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('edit_mpower','save_btn')" value="Submit">
	 
    </div>
    <div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p>
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

//Abhinav
function loadCity(){
	var state_id = $.trim($("#state_id").val());
	var city = $.trim($("#city").val());
	if(state_id==""){
		return false;
	}
	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
		
	var datastring = "state_id="+state_id+"&city="+city;	
	var url = "<?php echo base_url();?>index.php?admin/load_city_id";	
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
			$("#city").html(message);
		}		
	});
}

function loadCity_p(){
	var state_id_p = $.trim($("#state_id_p").val());
	var city_p = $.trim($("#city_p").val());
	if(state_id_p==""){
		return false;
	}
	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
		
	var datastring = "state_id="+state_id_p+"&city="+city_p;	
	var url = "<?php echo base_url();?>index.php?admin/load_city_id";	
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
			$("#city_p").html(message);
		}		
	});
}

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