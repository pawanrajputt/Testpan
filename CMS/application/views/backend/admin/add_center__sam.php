<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-body">	
            
                <form role="form" name="add_center" id="add_center" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_center_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Details</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
		<strong>Registration Type:</strong>
					<select name="total_batch" id="adisel" class="form-control">
						  <option value="">SELECT</option>
					</select>
	</div>
	
		<div class="col-sm-3">
		<strong>Operational Mode:</strong>
					<select name="total_batch" id="adisel" class="form-control">
						  <option value="">SELECT</option>
					</select>
	</div>
	
	<div class="col-sm-6"><strong>
	Center Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="center_name" class="form-control" id="center_name" placeholder="Center Name" style='text-transform:uppercase'>
	</div>
	
</div>
                    
<div class="form-group">

	<div class="col-sm-3">
		<strong>Select Vendor <em style="color:#C00;">*</em></strong>
		<select  class="form-control" name="vendor_id" id="vendor_id" style='text-transform:uppercase'>
		  <?php echo $this->common_options->vendor_options('');?>
        </select>
	</div>

	<div class="col-sm-3">
	<strong>State <em style="color:#C00;">*</em></strong>
				<select  class="form-control" name="state_id" id="state_id" onchange="loadCity();" style='text-transform:uppercase'>
		  <?php echo $this->common_options->state_options('');?>
        </select>
	</div>
	
	<div class="col-sm-3">
		<strong>City <em style="color:#C00;">*</em></strong>
		<select  class="form-control" name="city" id="city" style='text-transform:uppercase'>
		   <?php echo $this->common_options->get_city_list('');?>
        </select>
	</div>
	
	<div class="col-sm-3">
	<strong>City Code: <em style="color:#C00;">*</em></strong>
		<input type="text" name="city_code" class="form-control" id="city_code" placeholder="city code" style='text-transform:uppercase'>
		<strong style="color: #006600; font-size:9px "> *Enter Railway City Code only </strong>
	</div>
	
</div>
	
<div class="form-group">

	<div class="col-sm-6">
	<strong>Address <em style="color:#C00;">*</em></strong>
		 <input type="text" name="address" id="address"  class="form-control" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-4">
	<strong>Landmark</strong>
		<input type="text" name="landmark" class="form-control" id="landmark" placeholder="Landmark" style='text-transform:uppercase'>
	</div>
	
			<div class="col-sm-2">
	<strong>Pin Code:</strong>
		<input type="text" name="pincode" class="form-control" id="pincode" maxlength="6" onkeypress="return isNumberKey(event)" >
	</div>
	
</div>
	
<div class="form-group">	
	
	<div class="col-sm-4">
	<strong>Google Link</strong>
		<input type="text" name="c_lat" class="form-control" id="c_lat" maxlength="10" placeholder="Auto Fill">
	</div>
	
	<div class="col-sm-4">
	<strong>Website</strong>
		<input type="text" name="c_lat" class="form-control" id="c_lat" maxlength="10" placeholder="Auto Fill">
	</div>
	
		<div class="col-sm-2">
	<strong>Sign Board</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
		<div class="col-sm-2">
	<strong>Aproch Road</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Contact Details</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>STD Code</strong>
		<input type="text" name="landline_area_code" class="form-control" id="field-8" maxlength="5" placeholder="Std" onkeypress="return isNumberKey(event)" >
	</div>

	<div class="col-sm-3">
	<strong>Landline No</strong>
		<input type="text" name="landline_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-3">
	<strong>Email Id</strong>
		<input type="text" name="landline_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Railway Station to Center</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Nearest Railway Station Name</strong>
		<input type="text" name="railway_station" class="form-control" id="railway_station" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-3">
	<strong>Google Link</strong>
		<input type="text" name="rail_long" class="form-control" id="rail_long" placeholder="Auto Fill">
	</div>
	
	<div class="col-sm-2">
	<strong>Distance</strong>
		<input type="text" name="rail_distance" class="form-control" id="rail_distance" placeholder="Auto Fill">
	</div>	
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Bus Stand to Center</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Nearest Bus Station Name</strong>
		<input type="text" name="bus_stop" class="form-control" id="bus_stop" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-3">
	<strong>Google Link</strong>
		<input type="text" name="bus_lat" class="form-control" id="bus_lat" placeholder="Auto Fill" >
	</div>
	
	<div class="col-sm-2">
	<strong>Distance</strong>
		<input type="text" name="bus_distance" class="form-control" id="bus_distance" placeholder="Auto Fill">
	</div>	
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Category of Center</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Type of Center:</strong>
	<select  class="form-control" name="type_of_center" id="type_of_center" style='text-transform:uppercase'>
		  <?php echo $this->common_options->select_center_type('');?>
        </select>
	</div>
	
	<div class="col-sm-3">
	<strong>Approved By:</strong>
		<input type="text" name="center_approved_by" class="form-control" id="center_approved_by">
	</div>
	
	<div class="col-sm-3">
	<strong>Affiliation:</strong>
		<input type="text" name="center_affiliation_by" class="form-control" id="center_affiliation_by" >
	</div>
	
	<div class="col-sm-3">
	<strong>Establish of Lab Year: </strong>
		<input type="text" name="center_lab_establish_year" class="form-control datepicker" id="center_lab_establish_year" >  
	</div>
	
</div>


<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Security</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Entry Point:</strong>
		<input type="text" name="entry_point" class="form-control" id="entry_point" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-2">
	<strong>Exit Point: </strong>
		<input type="text" name="exit_point" class="form-control" id="exit_point" onkeypress="return isNumberKey(event)">
	</div>

	<div class="col-sm-2">
	<strong>Male Guard:</strong>
	<input type="text" name="security_guard_male" class="form-control" id="security_guard_male" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-2">
	<strong>Female Guard:</strong>
		<input type="text" name="security_guard_female" class="form-control" id="security_guard_female" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-2">
	<strong>DVR:</strong> <br />
				<input type="radio" name="cctv_dvr" id="cctv_dvr" value="yes" /> Yes
				<input type="radio"  name="cctv_dvr" id="cctv_dvr" value="no" /> No
	</div>

	<div class="col-sm-2">
	<strong><i class="fa fa-circle-o"></i> Parking:</strong> <br /> 
		<input type="radio" name="parking_facility" id="parking_facility" value="yes" /> Yes
				<input type="radio"  name="parking_facility" id="parking_facility" value="no" /> No
	</div>
	
</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Drinking Water:</strong> <br />
				<input type="radio" name="drinking_water_facility" id="drinking_water_facility" value="yes" /> Yes
				<input type="radio"  name="drinking_water_facility" id="drinking_water_facility" value="no" /> No
	</div>

	<div class="col-sm-2">
	<strong>Fire Extinguisher:</strong> <br />
		<input type="radio" name="fire_extinguisher" id="fire_extinguisher" value="yes" /> Yes
				<input type="radio"  name="fire_extinguisher" id="fire_extinguisher" value="no" /> No
	</div>

    <div class="col-sm-2">
	<strong><i class="fa fa-wheelchair"></i> For PH Candidate:</strong><br />
		<input type="radio" name="ph_facility" id="ph_facility" value="yes" onClick="phfacility1(this);" /> Yes
		<input type="radio"  name="ph_facility" id="ph_facility" value="no" onClick="phfacility2(this);" /> No
	</div>

	<div class="col-sm-2" style="display:none;" id="phdiv">
	<strong>Facility</strong><br />
		<input type="radio"  name="phydical_handicapped" id="phydical_handicapped" value="ground_floor"/> Ground Floor
	<input type="radio"  name="phydical_handicapped" id="phydical_handicapped" value="lift"/> Lift
	</div>
	
	<div class="col-sm-2">
	<strong>Locker:</strong> <br />
				<input type="radio" name="locker_facility" id="locker_facility" value="yes" /> Yes
				<input type="radio"  name="locker_facility" id="locker_facility" value="no" /> No
	</div>
	
	<div class="col-sm-2">
	<strong>Projector & Sound:</strong> <br />
		<input type="radio" name="projector_sound_system" id="projector_sound_system" value="yes" /> Yes
				<input type="radio"  name="projector_sound_system" id="projector_sound_system" value="no" /> No
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-2">
	<strong>Waiting Hall [Parents]:</strong> <br />
		<input type="radio" name="parents_waiting_hall" id="parents_waiting_hall" value="yes" /> Yes
				<input type="radio"  name="parents_waiting_hall" id="parents_waiting_hall" value="no" /> No
	</div>
	
	<div class="col-sm-2">
	<strong>Waiting Hall [Candidates]: </strong><br />
				<input type="radio" name="candidates_waiting_hall" id="candidates_waiting_hall" value="yes" /> Yes
				<input type="radio"  name="candidates_waiting_hall" id="candidates_waiting_hall" value="no" /> No
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-2">
	<strong>Parking Photo</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>Entry Gate</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>Exit Gate</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>Toilet Photo</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>	
	
	<div class="col-sm-2">
	<strong>DVR Screenshot</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>Drinking Water</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>

</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Fire Extinguisher</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>Lift</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>Locker</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>Waiting Hall</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Lab Amenties</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Number of Lab:</strong>
		<input type="text" name="total_no_lab" class="form-control" id="total_no_lab" placeholder="" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-2">
	<strong>Total System:</strong>
		<input type="text" name="total_no_system" class="form-control" id="total_no_system" placeholder="" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-2">
	<strong>Network Printer:</strong> <br />
			<input type="radio" name="network_printer" id="network_printer" value="yes" /> Yes
				<input type="radio"  name="network_printer" id="network_printer" value="no" /> No
	</div>
	
    <div class="col-sm-2">
	<strong>Single Network:</strong><br />
		<input type="radio" name="sngl_ntwk" id="sngl_ntwk" value="yes" onClick="singlntwk1(this);" /> Yes
		<input type="radio"  name="sngl_ntwk" id="sngl_ntwk" value="no" onClick="singlntwk2(this);" /> No
	</div>
	
    <div class="col-sm-2" style="display:none;" id="cctvclp">
		<strong>How Many Network:</strong>
		<input type="text" name="network_count" class="form-control" id="network_count" placeholder="" onkeypress="return isNumberKey(event)" >
	</div>
	
</div>

<div class="form-group">
    
	<div class="col-sm-2">
		<strong>Partition in Each Lab:</strong><br />
		<input type="radio"  name="partitaion_each_lab" id="partitaion_each_lab" value="yes"/> Yes
		<input type="radio"  name="partitaion_each_lab" id="partitaion_each_lab" value="no"/> No
	</div>
	
    <div class="col-sm-2">
		<strong>AC in Each Lab:</strong><br />
		<input type="radio" name="lab_ac" id="lab_ac" value="yes"/> Yes
		<input type="radio" name="lab_ac" id="lab_ac" value="no"/> No
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Lab Internet</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Primary ISP Name:</strong>
		<input type="text" name="primary_isp_name" class="form-control" id="primary_isp_name" placeholder="" >
	</div>
	
	<div class="col-sm-2">
	<strong>Primary ISP:</strong><br />
		<input type="radio" name="primary_isp_bband_or_lease" id="primary_isp_bband_or_lease" value="broadband" /> Broadband
				<input type="radio"  name="primary_isp_bband_or_lease" id="primary_isp_bband_or_lease" value="leased" /> Leased
	</div>
	
	<div class="col-sm-2">
	<strong>Primary ISP Speed:</strong>
		<input type="text" name="primary_isp_speed" class="form-control" id="primary_isp_speed" maxlength="10" onkeypress="return isNumberKey(event)"  >
	</div>

	<div class="col-sm-2">
	<strong>Secondary ISP Name:</strong>
		<input type="text" name="secondary_isp_name" class="form-control" id="secondary_isp_name" placeholder="" >
	</div>
	
	<div class="col-sm-2">
	<strong>Secondary ISP:</strong><br />
		<input type="radio" name="secondary_isp_bband_or_lease" id="secondary_isp_bband_or_lease" value="broadband" /> Broadband
				<input type="radio"  name="secondary_isp_bband_or_lease" id="secondary_isp_bband_or_lease" value="leased" /> Leased
	</div>
	
	<div class="col-sm-2">
	<strong>Secondary ISP Speed:</strong>
		<input type="text" name="secondary_isp_speed" class="form-control" id="secondary_isp_speed" maxlength="10" onkeypress="return isNumberKey(event)">
	</div>
	
</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Primary Speed</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>Secondary Speed</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Lab Power & CCTV</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Genset [KVA]</strong>
		<input type="number" name="power_backup_generator_kv" class="form-control" id="power_backup_generator_kv" maxlength="6" >
	</div>
	
	<div class="col-sm-2">
	<strong>UPS [KVA]</strong>
		<input type="number" name="power_back_ups_kv" class="form-control" id="power_back_ups_kv" maxlength="10"  >
	</div>
	
	<div class="col-sm-2">
	<strong>Backup [Duration]</strong>
		<input type="number" name="power_backup_hour" class="form-control" id="power_backup_hour" maxlength="10" >
	</div>
	
	<div class="col-sm-2">
	<strong>Backup [minute/hours]</strong> <br /> 
		<input type="radio" name="power_backup_unit" id="power_backup_unit" value="minute" /> Minute
				<input type="radio"  name="power_backup_unit" id="power_backup_unit" value="hour" /> Hours
	</div>
	
	<div class="col-sm-2">
	<strong>Genset Photo</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>UPS Photo</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>	

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Primary Banking Details</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-2" style="width:180px">
	<strong>GST No</strong>
		<input type="text" name="gst_number" class="form-control" id="gst_number" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-3">
	<strong>GST State</strong>
		<select  class="form-control" name="gst_state_code" id="gst_state_code" style='text-transform:uppercase'>
		  <?php echo $this->common_options->gst_state_options('');?>
        </select>
	</div>
	
	<div class="col-sm-2">
	<strong>Pan Number</strong>
		<input type="text" name="pan_number" class="form-control" id="pan_number" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2" style="width:260px">
	<strong>Beneficiary Name</strong>
		<input type="text" name="benf_name" class="form-control" id="benf_name" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2" style="width:159px">
	<strong>Account Number</strong>
		<input type="text" name="bank_account_no" class="form-control" id="bank_account_no" style='text-transform:uppercase'>
	</div>
	
</div>
	
<div class="form-group">

	<div class="col-sm-2" style="width:180px">
	<strong>IFSC Code</strong>
		<input type="text" name="bank_ifsc_code" class="form-control" id="bank_ifsc_code" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Bank Name</strong>
        <select  class="form-control" name="bank_name" id="bank_name" style='text-transform:uppercase'>
		  <?php echo $this->common_options->select_bank_name('');?>
        </select>
	</div>
	
	<div class="col-sm-2">
	<strong>GST Certificate</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>PAN Card</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>Passbook/Cheque</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
     <div class="col-sm-2">
	<strong>Secondary Banking</strong><br />
		<input type="radio" name="sec_bank_option" id="sec_bank_option" value="yes" onClick="secbank1(this);" /> Yes
		<input type="radio"  name="sec_bank_option" id="sec_bank_option" value="no" onClick="secbank2(this);" /> No
	</div>
	
 </div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Secondary Banking Details</strong></span>
</div>

<div class="form-group"  style="display:none;" id="bankdiv">
    
	<div class="col-sm-2" style="width:180px">
	<strong>Pan Number</strong>
		<input type="text" name="secondary_pan_no" class="form-control" id="secondary_pan_no" style='text-transform:uppercase'>
	</div>
	
    <div class="col-sm-3">
	<strong>Beneficiary Name</strong>
		<input type="text" name="secondary_beneficiary_name" class="form-control" id="secondary_beneficiary_name" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Account Number</strong>
		<input type="text" name="secondary_bank_account_no" class="form-control" id="secondary_bank_account_no" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2" style="width:260px">
	<strong>Bank Name</strong>
		<select  class="form-control" name="secondary_bank_name" id="secondary_bank_name" style='text-transform:uppercase'>
		  <?php echo $this->common_options->select_bank_name('');?>
        </select>
	</div>

	<div class="col-sm-2" style="width:159px">
	<strong>IFSC Code</strong>
		<input type="text" name="secondary_bank_ifsc_code" class="form-control" id="secondary_bank_ifsc_code" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Passbook/Cheque</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
	<div class="col-sm-2">
	<strong>PAN Card</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Owner</strong></span>
</div>

<div class="form-group">


	<div class="col-sm-3">
	<strong>Name:</strong>
		<input type="text" name="cs_name" class="form-control" id="cs_name" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Primary Number</strong>
		<input type="text" name="cs_contact_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	<div class="col-sm-2">
	<strong>Alternate Number</strong>
		<input type="text" name="cs_phone_alternate" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-3">
	<strong>Email id</strong>
		<input type="email" name="cs_email" class="form-control" id="cs_email" >
	</div>
	
	<div class="col-sm-2">
	<strong>User Photo</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Superintendent</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Name:</strong>
		<input type="text" name="cs_name" class="form-control" id="cs_name" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Primary Number</strong>
		<input type="text" name="cs_contact_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	<div class="col-sm-2">
	<strong>Alternate Number</strong>
		<input type="text" name="cs_phone_alternate" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-3">
	<strong>Email id</strong>
		<input type="email" name="cs_email" class="form-control" id="cs_email" >
	</div>
	
	<div class="col-sm-2">
	<strong>User Photo</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Assistant Manager</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Name:</strong>
		<input type="text" name="cs_name" class="form-control" id="cs_name" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Primary Number</strong>
		<input type="text" name="cs_contact_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	<div class="col-sm-2">
	<strong>Alternate Number</strong>
		<input type="text" name="cs_phone_alternate" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-3">
	<strong>Email id</strong>
		<input type="email" name="cs_email" class="form-control" id="cs_email" >
	</div>
	
	<div class="col-sm-2">
	<strong>User Photo</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Point of Contact</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Name:</strong>
		<input type="text" name="cs_name" class="form-control" id="cs_name" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Primary Number</strong>
		<input type="text" name="cs_contact_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	<div class="col-sm-2">
	<strong>Alternate Number</strong>
		<input type="text" name="cs_phone_alternate" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-3">
	<strong>Email id</strong>
		<input type="email" name="cs_email" class="form-control" id="cs_email" >
	</div>
	
	<div class="col-sm-2">
	<strong>User Photo</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Technical Department</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Name:</strong>
		<input type="text" name="cs_name" class="form-control" id="cs_name" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Primary Number</strong>
		<input type="text" name="cs_contact_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	<div class="col-sm-2">
	<strong>Alternate Number</strong>
		<input type="text" name="cs_phone_alternate" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-3">
	<strong>Email id</strong>
		<input type="email" name="cs_email" class="form-control" id="cs_email" >
	</div>
	
	<div class="col-sm-2">
	<strong>User Photo</strong> 
				<input type="file" name="doc1" id="doc1" />
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Experience in Exam</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-4">
	<strong>Client Name:</strong>
	    <textarea name="center_client_name" class="form-control" id="center_client_name"  cols="3" rows="3"></textarea>
	</div>
	
	<div class="col-sm-3">
	<strong>Exams Name:</strong>
		<textarea name="center_prev_exam_name" class="form-control" id="center_prev_exam_name"  cols="3" rows="3"></textarea>
	</div>
	
	<div class="col-sm-5">
	<strong>Feedback:</strong>
    	<textarea name="feedback" class="form-control" id="feedback"  Placeholder="Feedback will be filled by our side only" cols="3" rows="3"></textarea>
	</div>
	
</div>

    <div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
     <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_center','save_btn')" value="Submit">
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

function singlntwk1(str){
	if($(str).is(':checked')){
		$("#cctvclp").hide();
	}}
	
	function singlntwk2(str){
		if($(str).is(':checked')){
			$("#cctvclp").show();
	}}	
	
function phfacility1(str){
	if($(str).is(':checked')){
		$("#phdiv").show();
	}}
	function phfacility2(str){
		if($(str).is(':checked')){
			$("#phdiv").hide();
	}}		
	
function secbank1(str){
	if($(str).is(':checked')){
		$("#bankdiv").show();
	}}
	
	function secbank2(str){
		if($(str).is(':checked')){
			$("#bankdiv").hide();
	}}

function photoyes(str){
	if($(str).is(':checked')){
		$("#photodiv1").show();
		$("#photodiv2").show();
		loadOtherDepartment();
	}else{
		$("#photodiv1").hide();
		$("#photodiv2").hide();
	}}
	
function photono(str){
	if($(str).is(':checked')){
		$("#photodiv1").hide();
		$("#photodiv2").hide();
		loadOtherDepartment();
	}else{
		$("#photodiv1").hide();
		$("#photodiv2").hide();
	}}

function docyes(str){
	if($(str).is(':checked')){
		$("#docdiv1").show();
		loadOtherDepartment();
	}else{
		$("#docdiv1").hide();
	}}

function docno(str){
	if($(str).is(':checked')){
		$("#docdiv1").hide();
		loadOtherDepartment();
	}else{
		$("#docdiv1").hide();
	}}	
		
</script>