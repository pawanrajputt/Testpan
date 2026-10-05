
<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
           
            <div class="panel-body" style="background-color:#00FFFF">			
                <form role="form" name="edit_center" id="edit_center" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_center_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $center_details->id; ?>" />
				<input type="hidden" name="cityids" id="cityids" value=" <?php echo $center_details->city_id; ?>" />
				
<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Details</strong></span>
</div>
                    
<div class="form-group">

	<div class="col-sm-3"><strong>
	Center Type <em style="color:#C00;">*</em></strong><br />
		<input type="radio" name="centertype" id="centertype" value="online" <?php if($center_details->center_type=='online'){ ?> checked="checked" <?php } ?> onClick="onlinecent(this);" /> ONLINE CENTER
		<input type="radio"  name="centertype" id="centertype" value="offline" <?php if($center_details->center_type=='offline'){ ?> checked="checked" <?php } ?>   onClick="offlinecent(this);" /> OFFLINE CENTER
	</div>
	
	<div class="col-sm-5"><strong>
	Center Name</strong>
		<input type="text" name="center_name" class="form-control" id="center_name" placeholder="Center Name" value="<?php echo $center_details->center_name;?>" style='text-transform:uppercase'>
	</div>

	<div class="col-sm-4">
		<strong>Select Vendor</strong>
		<select  class="form-control" name="vendor_id" id="vendor_id" style='text-transform:uppercase'>
		  <?php echo $this->common_options->vendor_options($center_details->vendor_id);?>
        </select>
	</div>
 </div>
 
  <div class="form-group">  
    <div class="col-sm-2">
	<strong>Country <em style="color:#C00;">*</em></strong>
				<select  class="form-control" name="country_id" id="country_id" onchange="loadStateList();" disabled="disabled">
		 		  <?php echo $this->common_options->country_list_options($center_details->country_id);?>
         		</select>
	</div>

	<div class="col-sm-3">
	<strong>State</strong>
		<select  class="form-control" name="state_id" id="state_id" onchange="loadCity();" disabled="disabled" style='text-transform:uppercase'>
		  <?php echo $this->common_options->state_options($center_details->state_id);?>
        </select>
	</div>		

	<div class="col-sm-3">
		<strong>City:</strong>
		<select  class="form-control" name="city" id="city" disabled="disabled" style='text-transform:uppercase'>
		   <?php echo $this->common_options->get_city_list($center_details->city_id);?>
        </select>
	</div>
	
	<div class="col-sm-2">
	<strong>City Code:</strong>
		<input type="text" name="city_code" class="form-control" id="city_code" placeholder="city code" value="<?php echo $center_details->city_code;?>" disabled="disabled" style='text-transform:uppercase'>
		<strong style="color: #006600; font-size:9px "> *Enter Railway City Code only </strong>
	</div>
	
	<div class="col-sm-2">
	<strong>Pin Code:</strong>
		<input type="text" name="pincode" class="form-control" id="pincode" maxlength="6" value="<?php echo $center_details->pin_code;?>" onkeypress="return isNumberKey(event)" >
	</div>

</div>

<div class="form-group">


	
	<div class="col-sm-2">
	<strong>Latitude</strong>
		<input type="text" name="c_lat" class="form-control" id="c_lat" maxlength="10" value="<?php echo $center_details->address_lat;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Longitude</strong>
		<input type="text" name="c_long" class="form-control" id="c_long" maxlength="10" value="<?php echo $center_details->address_long;?>">
	</div>
    
    <div class="col-sm-4">
	<strong>Address 1:</strong>
		 <textarea name="address" id="address"  class="form-control" style='text-transform:uppercase'><?php echo $center_details->address;?></textarea>
	</div>
	
	<div class="col-sm-4">
	<strong>Address 2:</strong>
		 <textarea name="address_second" id="address_second"  class="form-control" style='text-transform:uppercase'><?php echo $center_details->address_second;?></textarea>
	</div>
	
</div>
	
<div class="form-group">

	
	
	<div class="col-sm-4">
	<strong>Landmark</strong>
		<textarea name="landmark" id="landmark" class="form-control" style='text-transform:uppercase'><?php echo $center_details->landmark;?></textarea>
	</div>
    
    <div class="col-sm-4">
	<strong>Udyam Aadhar Number:</strong>
		<input type="text" name="udyam_number" class="form-control" id="udyam_number"  value="<?php echo $center_details->udyam_number;?>" >
	</div>
    
     <div class="col-sm-4">
	<strong>Upload Udyam Aadhar Document:  <?php if($center_details->udyam_document==''){ ?>[ &#10006; ] <?php } else { ?> [ &#10004; ]<?php } ?></strong>
		<input type="file" name="docudm" id="docudm" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf]</span>
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Railway Station to Center</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Nearest Railway Station Name</strong>
		<input type="text" name="railway_station" class="form-control" id="railway_station" value="<?php echo $center_details->nearest_railway_station;?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-3">
	<strong>Railway Station Latitude</strong>
		<input type="text" name="rail_lat" class="form-control" id="rail_lat" value="<?php echo $center_details->station_lat;?>"  >
	</div>
	
	<div class="col-sm-3">
	<strong>Railway Station Longitude</strong>
		<input type="text" name="rail_long" class="form-control" id="rail_long" value="<?php echo $center_details->station_long;?>"  >
	</div>
	
	<div class="col-sm-3">
	<strong>Distance from Railway Station</strong>
		<input type="text" name="rail_distance" class="form-control" id="rail_distance" value="<?php echo $center_details->distance_from_station;?>"  >
	</div>	
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Bus Stand to Center</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Nearest Bus Station Name</strong>
		<input type="text" name="bus_stop" class="form-control" id="bus_stop" value="<?php echo $center_details->nearest_bus_stop;?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-3">
	<strong>Bus Station Latitude</strong>
		<input type="text" name="bus_lat" class="form-control" id="bus_lat" value="<?php echo $center_details->bus_lat;?>" >
	</div>
	
	<div class="col-sm-3">
	<strong>Bus Station Longitude</strong>
		<input type="text" name="bus_long" class="form-control" id="bus_long" value="<?php echo $center_details->bus_long;?>" >
	</div>
	
	<div class="col-sm-3">
	<strong>Distance from Bus Station</strong>
		<input type="text" name="bus_distance" class="form-control" id="bus_distance" value="<?php echo $center_details->distance_from_bus_stop;?>" >
	</div>	
	
</div>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Parking Facility:</strong> <br /> 
		<input type="radio" name="parking_facility" id="parking_facility" value="yes" <?php if($center_details->parking_facility=='yes'){?> checked="checked"<?php } ?> /> Yes
		<input type="radio"  name="parking_facility" id="parking_facility" value="no" <?php if($center_details->parking_facility=='no'){?> checked="checked"<?php } ?> /> No
	</div>
    
    <div class="col-sm-2">
	<strong>For PH Candidate:</strong><br />
		<input type="radio" name="ph_facility" id="ph_facility" value="yes" onClick="phfacility1(this);" <?php if($center_details->for_ph_candidate=='yes'){?> checked="checked"<?php } ?> /> Yes
		<input type="radio"  name="ph_facility" id="ph_facility" value="no" onClick="phfacility2(this);" <?php if($center_details->for_ph_candidate=='no'){?> checked="checked"<?php } ?> /> No
	</div>

	<div class="col-sm-2" <?php if($center_details->for_ph_candidate=='no'){?> style="display:none;" <?php } ?> id="phdiv">
	<strong>Facility</strong><br />
		<input type="radio"  name="phydical_handicapped" id="phydical_handicapped" value="ground_floor" <?php if($center_details->phydical_handicapped=='ground_floor'){?> checked="checked"<?php } ?>/> Ground Floor
	<input type="radio"  name="phydical_handicapped" id="phydical_handicapped" value="lift" <?php if($center_details->phydical_handicapped=='lift'){?> checked="checked"<?php } ?>/> Lift
	</div>
    
	<div class="col-sm-2">
	<strong>Document Signed</strong><br />
		<input type="radio"  name="doc_signed" id="doc_signed" value="yes" onclick="docyes(this);" <?php if($center_details->document_sign=='yes'){?> checked="checked"<?php } ?> /> Yes
	<input type="radio"  name="doc_signed" id="doc_signed" value="no" onclick="docno(this);" <?php if($center_details->document_sign=='no'){?> checked="checked"<?php } ?> /> No
	</div>
	
	<div class="col-sm-2">
	<strong>Photographs</strong><br />
		<input type="radio"  name="photographs" id="photographs" value="yes" onclick="photoyes(this);" <?php if($center_details->photographs=='yes'){?> checked="checked"<?php } ?>/> Yes
	<input type="radio"  name="photographs" id="photographs" value="no" onclick="photono(this);" <?php if($center_details->photographs=='no'){?> checked="checked"<?php } ?>/> No
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Landline Number & Emergency Number</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-1" style="width:80px">
		<input type="text" name="landline_country_code" class="form-control col-sm-1" id="field-8" placeholder="91" maxlength="4" value="<?php echo $center_details->landline_country_code;?>" onkeypress="return isNumberKey(event)" >
		<span style="font-size:9px">ISD Code</span>
	</div>
	
	<div class="col-sm-1" style="width:90px">
		<input type="text" name="landline_area_code" class="form-control" id="field-8" placeholder="STD Code" maxlength="5" value="<?php echo $center_details->landline_area_code;?>" onkeypress="return isNumberKey(event)" >
		<span style="font-size:9px">STD Code</span>
	</div>

	<div class="col-sm-2" style="width:130px">
		<input type="text" name="landline_number" class="form-control" id="field-8" placeholder="Landline No" maxlength="10" value="<?php echo $center_details->landline_number;?>" onkeypress="return isNumberKey(event)" >
		<span style="font-size:9px">Landline Number</span>
	</div>
	
	<div class="col-sm-1">
		<input type="text" name="landline_extension" class="form-control" id="field-8" placeholder="Ext" maxlength="4" value="<?php echo $center_details->landline_extension;?>" onkeypress="return isNumberKey(event)" >
		<span style="font-size:9px">Extension</span>
	</div>
	
	<div class="col-sm-1">
		<input type="text" name="emergency_counter_code" value="<?php echo $center_details->emergency_counter_code;?>"  class="form-control" style="width:60px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" >
		<span style="font-size:9px">ISD Code </span>
	</div>

	<div class="col-sm-3">
		<input type="text" name="emergency_contact_no" style="width:250px; width:100px" value="<?php echo $center_details->emergency_contact_no; ?>" class="form-control" id="field-8" placeholder="Emergency Primary" maxlength="10" onkeypress="return isNumberKey(event)" />
		<span style="font-size:9px">Emergency Primary</span>
	</div>

	<div class="col-sm-3">
		<input type="text" name="emergency_number_alternate" style="width:270px; width:100px" value="<?php echo $center_details->emergency_number_alternate;?>" class="form-control" id="field-8" placeholder="Emergency Alternate" maxlength="10" onkeypress="return isNumberKey(event)" >
		<span style="font-size:9px">Emergency Alternate</span>
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Primary Banking Detail</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3" style="width:180px">
	<strong>GST No</strong>
		<input type="text" name="gst_number" class="form-control" id="gst_number" value="<?php echo $center_details->gst_no; ?>" style='text-transform:uppercase'>
	</div>

	<div class="col-sm-3">
	<strong>GST State</strong>
		<select  class="form-control" name="gst_state_code" id="gst_state_code" style='text-transform:uppercase' >
		  <?php echo $this->common_options->gst_state_options($center_details->gst_state_code);?>
        </select>
	</div>

	<div class="col-sm-2">
	<strong>Pan Number</strong>
		<input type="text" name="pan_number" class="form-control" id="pan_number" value="<?php echo $center_details->pan_no; ?>" style='text-transform:uppercase'>
	</div>

	<div class="col-sm-2" style="width:260px">
	<strong>Beneficiary Name</strong>
		<input type="text" name="beneficiary_name" class="form-control" id="beneficiary_name" value="<?php echo $center_details->beneficiary_name; ?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2" style="width:159px">
	<strong>Account Number</strong>
		<input type="text" name="bank_account_no" class="form-control" id="bank_account_no" value="<?php echo $center_details->bank_account_number; ?>" style='text-transform:uppercase' >
	</div>
	
</div>

<div class="form-group">

	<div class="col-sm-2" style="width:180px">
	<strong>IFSC Code</strong>
		<input type="text" name="bank_ifsc_code" class="form-control" id="bank_ifsc_code" value="<?php echo $center_details->bank_ifsc_code; ?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-3">
	<strong>Bank Name</strong>
         <select  class="form-control" name="bank_name" id="bank_name" style='text-transform:uppercase'>
		 <?php echo $this->common_options->select_bank_name($center_details->bank_name);?>
        </select>
	</div>
	
	<div class="col-sm-3"> 
	<strong>Secondary Banking</strong><br />
		<input type="radio"  name="secondary_banking" id="secondary_banking" value="yes" onclick="secbank1(this);" <?php if($center_details->sec_bank_option=='yes'){?> checked="checked"<?php } ?>/> Yes
		<input type="radio"  name="secondary_banking" id="secondary_banking" value="no" onclick="secbank2(this);" <?php if($center_details->sec_bank_option=='no' or $center_details->sec_bank_option==''){?> checked="checked"<?php } ?>/> No
	</div>
	
</div>
 
<div class="form-group" style="background-color:#17A2B8; <?php if($center_details->sec_bank_option=='no' or $center_details->sec_bank_option==''){?> display:none; <?php } ?>" id="bankdiv1">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Secondary Banking Detail</strong></span>
</div>

<div class="form-group" <?php if($center_details->sec_bank_option=='no' or $center_details->sec_bank_option==''){?> style="display:none;" <?php } ?> id="bankdiv">

	<div class="col-sm-2" style="width:180px">
	<strong>Pan Number</strong>
		<input type="text" name="secondary_pan_number" class="form-control" id="secondary_pan_number" value="<?php echo $center_details->secondary_pan_no; ?>" style='text-transform:uppercase'>
	</div>
	
    <div class="col-sm-3">
	<strong>Beneficiary Name</strong>
		<input type="text" name="secondary_beneficiary_name" class="form-control" id="secondary_beneficiary_name" value="<?php echo $center_details->secondary_beneficiary_name; ?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-2">
	<strong>Account Number</strong>
		<input type="text" name="secondary_bank_account_no" class="form-control" id="secondary_bank_account_no" value="<?php echo $center_details->secondary_bank_account_no; ?>" style='text-transform:uppercase'>
	</div>

	<div class="col-sm-2" style="width:260px">
	<strong>Bank Name</strong>
        <select  class="form-control" name="secondary_bank_name" id="secondary_bank_name" style='text-transform:uppercase'>
		  <?php echo $this->common_options->select_bank_name($center_details->secondary_bank_name);?>
	   </select>
	</div>

	<div class="col-sm-2" style="width:159px">
	<strong>IFSC Code</strong>
		<input type="text" name="secondary_bank_ifsc_code" class="form-control" id="secondary_bank_ifsc_code" value="<?php echo $center_details->secondary_bank_ifsc_code; ?>" style='text-transform:uppercase'>
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Superintendent</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-4">
	<strong>Center Superintendent Name:</strong>
		<input type="text" name="cs_name" class="form-control" id="cs_name" value="<?php echo $center_details->cs_name;?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-4">
		<strong>Center Superintendent Contact Number:</strong>
			<div class="col-sm-4">
			<input type="text" name="cs_country_code"  class="form-control" value="<?php echo $center_details->cs_country_code;?>" style="width:60px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Country Code</span>
		</div>
		<div class="col-sm-4">
			<input type="text" name="cs_contact_number" style="width:100px" value="<?php echo $center_details->cs_contact_number;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Primary Number</span>
		</div>
		<div class="col-sm-4">
			<input type="text" name="cs_phone_alternate" style="width:100px" value="<?php echo $center_details->cs_phone_alternate;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Alternate Number</span>
		</div>
	
	</div>
	
	<div class="col-sm-4">
	<strong>Center Superintendent Email id:</strong>
		<input type="email" name="cs_email" class="form-control" id="cs_email" value="<?php echo $center_details->cs_email;?>" >
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Assistant Manager</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-4">
	<strong>Assistant Manager Name:</strong>
		<input type="text" name="am_name" class="form-control" id="am_name" value="<?php echo $center_details->am_name;?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-4">
		<strong>Assistant Managet Contact Number:</strong>
		<br />	<div class="col-sm-4">
			<input type="text" name="am_country_code"  class="form-control" value="<?php echo $center_details->am_country_code;?>" style="width:60px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Country Code </span>
		</div>
		<div class="col-sm-4">
			<input type="text" name="am_contact_no" style="width:100px" value="<?php echo $center_details->am_contact_no;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Primary Number</span>
		</div>
		<div class="col-sm-4">
			<input type="text" name="am_phone_alternate" style="width:100px" value="<?php echo $center_details->am_phone_alternate;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Alternate Number</span>
		</div>
	</div>
	
	<div class="col-sm-4">
	<strong>Assistant Manager Email id:</strong>
		<input type="email" name="am_email" class="form-control" id="am_email" value="<?php echo $center_details->am_email;?>" >
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Point of Contact</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-4">
	<strong>Point of Contact Name:</strong>
		<input type="text" name="poc_name" class="form-control" id="poc_name" value="<?php echo $center_details->poc_name;?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-4">
		<strong>Point of Contact Number:</strong>
		<br />	<div class="col-sm-4">
			<input type="text" name="poc_country_code"  class="form-control" value="<?php echo $center_details->poc_country_code;?>" style="width:60px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Country Code </span>
		</div>
		<div class="col-sm-4">
			<input type="text" name="poc_contact_no" style="width:100px" value="<?php echo $center_details->poc_contact_no;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Primary Number</span>
		</div>
		<div class="col-sm-4">
			<input type="text" name="poc_mobile_alternate" style="width:100px" value="<?php echo $center_details->poc_mobile_alternate;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Alternate Number</span>
		</div>
	</div>
	
	<div class="col-sm-4">
	<strong>Point of Contact Email id:</strong>
		<input type="email" name="poc_email" class="form-control" id="poc_email" value="<?php echo $center_details->poc_email;?>" >
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Technical Department</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-4">
	<strong>Technical Department Name:</strong>
		<input type="text" name="td_name" class="form-control" id="td_name"  value="<?php echo $center_details->td_name;?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-4">
		<strong>Technical Department Contact Number:</strong>
			<div class="col-sm-4">
			<input type="text" name="td_country_code"  class="form-control" value="<?php echo $center_details->td_country_code;?>" style="width:60px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Country Code </span>
		</div>
		<div class="col-sm-4">
			<input type="text" name="td_contact_no" style="width:100px" value="<?php echo $center_details->td_contact_no;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Primary Number</span>
		</div>
		<div class="col-sm-4">
			<input type="text" name="td_phone_alternate" style="width:100px" value="<?php echo $center_details->td_phone_alternate;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Alternate Number</span>
		</div>
	</div>
	
	<div class="col-sm-4">
	<strong>Technical Department Email id:</strong>
		<input type="email" name="td_email" class="form-control" id="td_email"  value="<?php echo $center_details->td_email;?>" >
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Lab / Center</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-2">
	<strong>Total System:</strong>
		<input type="text" name="total_no_system" class="form-control" id="total_no_system" placeholder="" value="<?php echo $center_details->total_no_system;?>"  onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-2" id="centdiv" <?php if($center_details->center_type=='offline'){?> style="display:none;" <?php } ?>>
	<strong>Total Lab:</strong>
		<input type="text" name="total_no_lab" class="form-control" id="total_no_lab" placeholder="" value="<?php echo $center_details->total_no_lab;?>"  onkeypress="return isNumberKey(event)" >
	</div>
	
     <div class="col-sm-2">
	<strong>Single Network:</strong><br />
		<input type="radio" name="sngl_ntwk" id="sngl_ntwk" value="yes" onClick="singlntwk1(this);" <?php if($center_details->connected_single_network=='yes'){?> checked="checked"<?php } ?> /> Yes
		<input type="radio"  name="sngl_ntwk" id="sngl_ntwk" value="no" onClick="singlntwk2(this);" <?php if($center_details->connected_single_network=='no'){?> checked="checked"<?php } ?> /> No
	</div>
    <div class="col-sm-2" <?php if($center_details->connected_single_network=='yes'){?> style="display:none;" <?php } ?> id="cctvclp">
	<strong>How Many Network:</strong>
		<input type="text" name="how_many_network" class="form-control" id="how_many_network" value="<?php echo $center_details->how_many_network;?>" placeholder="" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-2">
	<strong>Partition in Each Lab:</strong><br />
		<input type="radio"  name="partitaion_each_lab" id="partitaion_each_lab" value="yes" <?php if($center_details->partitaion_each_lab=='yes'){?> checked="checked"<?php } ?> /> Yes
		<input type="radio"  name="partitaion_each_lab" id="partitaion_each_lab" value="no" <?php if($center_details->partitaion_each_lab=='no'){?> checked="checked"<?php } ?>/> No
	</div>
	
    <div class="col-sm-2">
	<strong>AC in Each Lab:</strong><br />
		<input type="radio" name="lab_ac" id="lab_ac" value="yes" <?php if($center_details->ac_in_each_lab=='yes'){?> checked="checked"<?php } ?>/> Yes
		<input type="radio" name="lab_ac" id="lab_ac" value="no" <?php if($center_details->ac_in_each_lab=='no'){?> checked="checked"<?php } ?>/> No
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Lab Internet</strong></span>
</div>

<?php /*?><div class="form-group">
	<div class="col-sm-3">
	<strong>LAN Company Name:</strong>
		<input type="text" name="lan_company_name" class="form-control" id="lan_company_name" placeholder="" value="<?php echo $center_details->lan_company_name;?>" >
	</div>
	
	<div class="col-sm-3">
	<strong>LAN Model No.:</strong>
		<input type="text" name="lan_model_number" class="form-control" id="lan_model_number" placeholder="" value="<?php echo $center_details->lan_model_number;?>" >
	</div>
	
	<div class="col-sm-3">
	<strong>LAN Speed:</strong><br />
		<input type="text" name="lan_speed" class="form-control" id="lan_speed" placeholder="" value="<?php echo $center_details->lan_speed;?>" >
	</div>
	
	<div class="col-sm-3">
	<strong>LAN Managed:</strong><br />
		<input type="radio" name="lan_managed" id="lan_managed" value="yes" <?php if($center_details->lan_managed=='yes'){?> checked="checked"<?php } ?> /> YES
				<input type="radio"  name="lan_managed" id="lan_managed" value="no" <?php if($center_details->lan_managed=='no'){?> checked="checked"<?php } ?> /> No
				
	</div>
	
</div><?php */?>

<div class="form-group">

	<div class="col-sm-2">
	<strong>Primary ISP Name:</strong>
		<input type="text" name="primary_isp_name" class="form-control" id="primary_isp_name" placeholder="" value="<?php echo $center_details->primary_isp_name;?>"  >
	</div>
	
	<div class="col-sm-2">
	<strong>Primary ISP:</strong><br />
		<input type="radio" name="primary_isp_bband_or_lease" id="primary_isp_bband_or_lease" value="broadband" <?php if($center_details->primary_isp_bband_or_lease=='broadband'){?> checked="checked"<?php } ?> /> Broadband
		<input type="radio"  name="primary_isp_bband_or_lease" id="primary_isp_bband_or_lease" value="leased" <?php if($center_details->primary_isp_bband_or_lease=='leased'){?> checked="checked"<?php } ?> /> Leased
	</div>
	
	<div class="col-sm-2">
	<strong>Primary ISP Speed:</strong>
		<input type="text" name="primary_isp_speed" class="form-control" id="primary_isp_speed" maxlength="10" value="<?php echo $center_details->primary_isp_speed;?>" onkeypress="return isNumberKey(event)"  >
	</div>

	<div class="col-sm-2">
	<strong>Secondary ISP Name:</strong>
		<input type="text" name="secondary_isp_name" class="form-control" id="secondary_isp_name" placeholder="" value="<?php echo $center_details->secondary_isp_name;?>" >
	</div>
	
	<div class="col-sm-2">
	<strong>Secondary ISP:</strong><br />
		<input type="radio" name="secondary_isp_bband_or_lease" id="secondary_isp_bband_or_lease" value="broadband" <?php if($center_details->secondary_isp_bband_or_lease=='broadband'){?> checked="checked"<?php } ?> /> Broadband
				<input type="radio"  name="secondary_isp_bband_or_lease" id="secondary_isp_bband_or_lease" value="leased" <?php if($center_details->secondary_isp_bband_or_lease=='leased'){?> checked="checked"<?php } ?> /> Leased
	</div>
	
	<div class="col-sm-2">
	<strong>Secondary ISP Speed:</strong>
		<input type="text" name="secondary_isp_speed" class="form-control" id="secondary_isp_speed" maxlength="10" value="<?php echo $center_details->secondary_isp_speed;?>" onkeypress="return isNumberKey(event)">
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Lab Power & CCTV</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Power Backup(Generator KVA):</strong>
		<input type="number" name="power_backup_generator_kv" class="form-control" id="power_backup_generator_kv" maxlength="6" value="<?php echo $center_details->power_backup_generator_kv;?>" >
	</div>
	
	<div class="col-sm-3">
	<strong>Power Backup(UPS KVA):</strong>
		<input type="number" name="power_back_ups_kv" class="form-control" id="power_back_ups_kv" maxlength="10" value="<?php echo $center_details->power_back_ups_kv;?>" >
	</div>
	
	<div class="col-sm-3">
	<strong>Power Backup Hours:</strong>
		<input type="number" name="power_backup_hour" class="form-control" id="power_backup_hour" maxlength="10" value="<?php echo $center_details->power_backup_hour;?>" >
	</div>
	
	<div class="col-sm-3">
	<strong>Backup (minute/hours) :</strong> <br /> 
		<input type="radio" name="power_backup_unit" id="power_backup_unit" value="minute" <?php if($center_details->power_backup_unit=='minute'){?> checked="checked"<?php } ?> /> Minute
		<input type="radio"  name="power_backup_unit" id="power_backup_unit" value="hour" <?php if($center_details->power_backup_unit=='hour'){?> checked="checked"<?php } ?> /> Hours
	</div>
	
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>DVR Facility:</strong> <br />
				<input type="radio" name="cctv_dvr" id="cctv_dvr" value="yes" <?php if($center_details->cctv_dvr=='yes'){?> checked="checked"<?php } ?> /> Yes
				<input type="radio"  name="cctv_dvr" id="cctv_dvr" value="no" <?php if($center_details->cctv_dvr=='no'){?> checked="checked"<?php } ?> /> No
	</div>
	
	<div class="col-sm-3">
	<strong>Network Printer:</strong> <br />
			<input type="radio" name="network_printer" id="network_printer" value="yes" <?php if($center_details->network_printer=='yes'){?> checked="checked"<?php } ?> /> Yes
				<input type="radio"  name="network_printer" id="network_printer" value="no" <?php if($center_details->network_printer=='no'){?> checked="checked"<?php } ?> /> No
	</div>
	
	<div class="col-sm-3">
	<strong>Projector & Sound System:</strong> <br />
		<input type="radio" name="projector_sound_system" id="projector_sound_system" value="yes" <?php if($center_details->projector_sound_system=='yes'){?> checked="checked"<?php } ?> /> Yes
				<input type="radio"  name="projector_sound_system" id="projector_sound_system" value="no" <?php if($center_details->projector_sound_system=='no'){?> checked="checked"<?php } ?> /> No
	</div>
	<div class="col-sm-3">
	<strong>Fire Extinguisher each lab:</strong> <br />
		<input type="radio" name="fire_extinguisher" id="fire_extinguisher" value="yes" <?php if($center_details->fire_extinguisher=='yes'){?> checked="checked"<?php } ?> /> Yes
				<input type="radio"  name="fire_extinguisher" id="fire_extinguisher" value="no" <?php if($center_details->fire_extinguisher=='no'){?> checked="checked"<?php } ?> /> No
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Security in Lab</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Security Guard [Male]:</strong>
	<input type="text" name="security_guard_male" class="form-control" id="security_guard_male" value="<?php echo $center_details->security_guard_male;?>" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-3">
	<strong>Security Guard [Female]:</strong>
		<input type="text" name="security_guard_female" class="form-control" id="security_guard_female" value="<?php echo $center_details->security_guard_female;?>" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-3">
	<strong>Entry Point:</strong>
		<input type="text" name="entry_point" class="form-control" id="entry_point" value="<?php echo $center_details->entry_point;?>" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-3">
	<strong>Exit Point: </strong>
		<input type="text" name="exit_point" class="form-control" id="exit_point" value="<?php echo $center_details->exit_point;?>" onkeypress="return isNumberKey(event)">
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Lab Facility</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Locker Facility:</strong> <br />
		<input type="radio" name="locker_facility" id="locker_facility" value="yes" <?php if($center_details->locker_facility=='yes'){?> checked="checked"<?php } ?> /> Yes
		<input type="radio"  name="locker_facility" id="locker_facility" value="no" <?php if($center_details->locker_facility=='no'){?> checked="checked"<?php } ?> /> No
	</div>
	
	<div class="col-sm-3">
	<strong>Drinking Water Facility:</strong> <br />
		<input type="radio" name="drinking_water_facility" id="drinking_water_facility" value="yes" <?php if($center_details->drinking_water_facility=='yes'){?> checked="checked"<?php } ?> /> Yes
		<input type="radio"  name="drinking_water_facility" id="drinking_water_facility" value="no" <?php if($center_details->drinking_water_facility=='no'){?> checked="checked"<?php } ?> /> No
	</div>
	
	<div class="col-sm-3">
	<strong>Waiting Hall Facility[For Parents]:</strong> <br />
		<input type="radio" name="parents_waiting_hall" id="parents_waiting_hall" value="yes" <?php if($center_details->parents_waiting_hall=='yes'){?> checked="checked"<?php } ?> /> Yes
				<input type="radio"  name="parents_waiting_hall" id="parents_waiting_hall" value="no" <?php if($center_details->parents_waiting_hall=='no'){?> checked="checked"<?php } ?> /> No
	</div>
	
	<div class="col-sm-3">
	<strong>Waiting Hall Facility [For Candidates]: </strong><br />
				<input type="radio" name="candidates_waiting_hall" id="candidates_waiting_hall" value="yes" <?php if($center_details->candidates_waiting_hall=='yes'){?> checked="checked"<?php } ?> /> Yes
				<input type="radio"  name="candidates_waiting_hall" id="candidates_waiting_hall" value="no" <?php if($center_details->candidates_waiting_hall=='no'){?> checked="checked"<?php } ?> /> No
	</div>
	
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Category of Center</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-3">
	<strong>Type of Center:</strong>
	<select  class="form-control" name="type_of_center" id="type_of_center" style='text-transform:uppercase'>
		  <?php echo $this->common_options->select_center_type($center_details->type_of_center);?>
        </select>
	</div>
	
	<div class="col-sm-3">
	<strong>Approved By:</strong>
		<input type="text" name="center_approved_by" class="form-control" id="center_approved_by" value="<?php echo $center_details->center_approved_by;?>">
	</div>
	
	<div class="col-sm-3">
	<strong>Affiliation:</strong>
		<input type="text" name="center_affiliation_by" class="form-control" id="center_affiliation_by" value="<?php echo $center_details->center_affiliation_by;?>">
	</div>
	
	<div class="col-sm-3">
	<strong>Establish of Lab Year: </strong>
		<input type="text" name="center_lab_establish_year" class="form-control datepicker" id="field-6" value=" <?php if($center_details->center_lab_establish_year){ echo date('d/m/Y', strtotime($center_details->center_lab_establish_year));}?>">  
	</div>
	
</div>

<?php  echo date('Y/m/d', strtotime($center_details->center_lab_establish_year));?>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Experience in Exam</strong></span>
</div>

<div class="form-group">
	<div class="col-sm-4">
	<strong>Client Name:</strong>
	   <textarea name="center_client_name" class="form-control" id="center_client_name"  cols="3" rows="3"><?php echo $center_details->center_client_name;?></textarea>
	</div>
	
	<div class="col-sm-3">
	<strong>Exams Name:</strong>
		<textarea name="center_prev_exam_name" class="form-control" id="center_prev_exam_name"  cols="3" rows="3"><?php echo $center_details->center_prev_exam_name;?></textarea>
	</div>
	
	<div class="col-sm-5">
	<strong>Feedback:</strong>
    <textarea name="feedback" class="form-control" id="feedback"  cols="3" rows="3"><?php echo $center_details->feedback;?></textarea>
    </div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Picture Gallery</strong></span>
</div>

<div class="form-group">	

<?php foreach ($center_images as $rowimg) { 

 ?>   
	<div class="col-sm-2 zoom"> 
	
		<?php if($rowimg['center_image']!=''){ ?> <a  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/center_image_viewer/<?php echo $rowimg['center_image'] ?>');">
                     <img src="<?php echo base_url(); ?>uploads/center_image/<?php echo $rowimg['center_image'] ?>" style="height:70px; width:70%; margin:5px; padding:5px; border:1px" alt="Center Image" title="Center Image"/>
                    </a>	  <?php } ?>
			
		
		
		
		
		<br />	
        <input name="delimg[]" id="delimg[]" type="checkbox" value="<?php echo $rowimg['id'] ?>" />&nbsp;Delete
       </div>
<?php } ?>   
   
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Document Gallery</strong></span>
</div>

<div class="form-group">	
<br />
<?php foreach ($center_doc as $rowdoc) { ?>   
	<div class="col-sm-2">
    	<!--<a href="<?php echo base_url(); ?>uploads/center_document/<?php echo $rowdoc['doc_name'] ?>" target="_blank"><?php echo ucwords($rowdoc['doc_name']) ?> </a> -->
		
		<?php if($rowdoc['doc_name']!=''){ ?> <a  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/center_image_viewer/<?php echo $rowdoc['doc_name'] ?>');">
                <img src="<?php echo base_url(); ?>assets/images/docimg.png" style="height:50px; width:50px; margin:5px; padding:5px; border:1px" alt="Doc Image" title="Doc Image"/>
                    </a>	 <?php } ?>	
		
		
		
		<br />	
        <input name="deldoc[]" id="deldoc[]" type="checkbox" value="<?php echo $rowdoc['id'] ?>" />&nbsp;Delete
	</div>
<?php } ?>
   
</div>



<div class="form-group" style="display:none;" id="photodiv2">
	
	<div class="col-sm-3">
	<strong>Photo 5</strong> 
				<input type="file" name="image5" id="image5" /> <span style="color:#060; font-size:10px;">[Max: 2MB, jpg, jpeg, png]</span>
	</div>
	
	<div class="col-sm-3">
	<strong>Photo 6</strong> 
				<input type="file" name="image6" id="image6" /> <span style="color:#060; font-size:10px;">[Max: 2MB, jpg, jpeg, png]</span>
	</div>
	
	<div class="col-sm-3">
	<strong>Photo 7</strong> 
				<input type="file" name="image7" id="image7" /> <span style="color:#060; font-size:10px;">[Max: 2MB, jpg, jpeg, png]</span>
	</div>
	
	<div class="col-sm-3">
	<strong>Photo 8</strong> 
				<input type="file" name="image8" id="image8" /> <span style="color:#060; font-size:10px;">[Max: 2MB, jpg, jpeg, png]</span>
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;New Document Upload</strong></span>
</div>

<div class="form-group" <?php if($center_details->document_sign=='no'){?> style="display:none;" <?php } ?> id="docdiv1">
	<div class="col-sm-3">
	<strong>Document 1</strong> 
				<input type="file" name="doc1" id="doc1" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf]</span>
	</div>
	
	<div class="col-sm-3">
	<strong>Document 2</strong> 
				<input type="file" name="doc2" id="doc2" /> <span style="color:#060; font-size:10px;">[Max: 25MB, doc, docx, pdf]</span>
	</div>
	
	<div class="col-sm-3">
	<strong>Document 3</strong> 
				<input type="file" name="doc3" id="doc3" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf]</span>

	</div>
	
	<div class="col-sm-3">
	<strong>Document 4</strong> 
				<input type="file" name="doc4" id="doc4" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf]</span>
	</div>

</div>

    <div class="col-sm-4 control-label col-sm-offset-2">
	
    <a href="<?php echo base_url(); ?>index.php?admin/center_listing" class="btn btn-success"> << Back</a>
   
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('edit_center','save_btn')" value="Save" align="middle">
    
       <a href="<?php echo base_url(); ?>index.php?admin/center_listing" class="btn btn-success"> Exit</a>
       
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


function loadCity(){
	var state_id = $.trim($("#state_id").val());
	var city = $.trim($("#city").val());
	if(state_id==""){
		return false;
	}
	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
		
	var datastring = "state_id="+state_id+"&city="+city;	
	var url = "<?php echo base_url();?>index.php?admin/load_only_city_name";	
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
		$("#bankdiv1").show();
	}}
	function secbank2(str){
		if($(str).is(':checked')){
			$("#bankdiv").hide();
			$("#bankdiv1").hide();
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
	
	function onlinecent(str){
	if($(str).is(':checked')){
		$("#centdiv").show();
		
	}}
	
	function offlinecent(str){
		if($(str).is(':checked')){
			$("#centdiv").hide();
			
	}}
</script>