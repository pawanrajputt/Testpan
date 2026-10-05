<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
                <form role="form" name="edit_vendor" id="edit_vendor" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_vendor_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

<div class="form-group">
<strong>	<label for="field-1" class="col-sm-2 control-label">Vendor Id : </label>
	<div class="col-sm-6"  >
		<?php echo $vendor_details->vendor_id;?>
	</div>
</strong>	
</div>




<div class="form-group">
<strong>	<label for="field-1" class="col-sm-2 control-label">Vendor Name<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-4">
		<input type="text" name="vendor_name" class="form-control" id="vendor_name" value="<?php echo $vendor_details->vendor_name;?>" placeholder="Vendor Name" style='text-transform:uppercase' disabled="disabled">
	</div>
	
   <label for="field-1" class="col-sm-2 control-label">Co-cordinator Name<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-4">
		<input type="text" name="co_oreinator_name" class="form-control" id="co_oreinator_name" value="<?php echo $vendor_details->co_ordinator_name;?>" placeholder="Vendor Name" style='text-transform:uppercase'  disabled="disabled">
	</div> 
    </strong>
</div>





<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label">Mobile Number: </label>
	<div class="col-sm-1">
		<input type="text" name="country_code" class="form-control" id="field-8" maxlength="4" value="<?php echo $vendor_details->country_code;?>" onkeypress="return isNumberKey(event)"  disabled="disabled">
		<span style="color:#060; font-size:7px"><strong>	Country Code </strong></span>
	</div>
	
	<div class="col-sm-2"  style="width:135px">
		<input type="text" name="mobile_phone" class="form-control" id="field-8" maxlength="10" value="<?php echo $vendor_details->vendor_mobile;?>" onkeypress="return isNumberKey(event)"  disabled="disabled">
		<span style="color:#060; font-size:7px"><strong>	Primary Number</strong></span>
	</div>
	<div class="col-sm-2"  style="width:135px">
		<input type="text" name="alternate_mobile" class="form-control" id="field-8" maxlength="10" value="<?php echo $vendor_details->alternate_mobile;?>" onkeypress="return isNumberKey(event)"  disabled="disabled">
		<span style="color:#060; font-size:7px"><strong>	Alternate Number</strong></span>
	</div>
    
    
	<label for="field-1" class="col-sm-2 control-label">Landline Number: </label>
	<div class="col-sm-1"  style="width:80px">
		<input type="text" name="ll_country_code" class="form-control" id="field-8" maxlength="4" value="<?php echo $vendor_details->ll_country_code;?>" onkeypress="return isNumberKey(event)"  disabled="disabled">
		<span style="color:#060; font-size:7px"><strong>	Country Code </strong> </span>
	</div>
	
	<div class="col-sm-1"  style="width:85px">
		<input type="text" name="ll_area_code" class="form-control" id="field-8" maxlength="6" value="<?php echo $vendor_details->ll_area_code;?>" onkeypress="return isNumberKey(event)"  disabled="disabled">
		<span style="color:#060; font-size:7px"><strong>	Area Code </strong></span>
	</div>
	<div class="col-sm-1"  style="width:120px">
		<input type="text" name="ll_number" class="form-control" id="field-8" maxlength="10" value="<?php echo $vendor_details->ll_number;?>" onkeypress="return isNumberKey(event)"  disabled="disabled">
		<span style="color:#060; font-size:7px"><strong>	Landline Number </strong></span>
	</div>
	<div class="col-sm-1" style="width:75px">
		<input type="text" name="ll_extension" class="form-control" id="field-8" maxlength="4" value="<?php echo $vendor_details->ll_extension;?>" onkeypress="return isNumberKey(event)"  disabled="disabled">
		<span style="color:#060; font-size:7px"><strong>	Extension </strong></span>
	</div>
    </strong>
</div>

<div class="form-group">
	
	
</div>

<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label">Email<em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4">
		<input type="text" name="email" class="form-control" id="email" value="<?php echo $vendor_details->vendor_email;?>"  disabled="disabled">
	</div>
    
    <label for="field-1" class="col-sm-2 control-label">Country<em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4">
		 <select  class="form-control" name="country_id" id="country_id" onchange="loadStateList();"  disabled="disabled">
		 		  <?php echo $this->common_options->country_list_options($vendor_details->country_id);?>
         		</select>  
	</div>
</strong>	
</div>




<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label">Location<em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4">
		  <select  class="form-control" name="state_id" id="state_id" onchange="load_city_data();"  disabled="disabled">
		 		  <?php echo $this->common_options->state_list_options($vendor_details->location);?>
         		</select>
	</div>
    
    <label for="field-1" class="col-sm-2 control-label">Pan Number<em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4">
		<input type="text" name="pancard_number" class="form-control" id="pancard_number" value="<?php echo $vendor_details->pan;?>" style='text-transform:uppercase'  disabled="disabled">
	</div>
</strong>	
</div>



<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label">GST Number<em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4">
		<input type="text" name="gst_number" class="form-control" id="gst_number" value="<?php echo $vendor_details->gst_no;?>" style='text-transform:uppercase'  disabled="disabled">
	</div>
    
      <label for="field-1" class="col-sm-2 control-label"><strong>	Upload GST Certificate<em style="color:#C00;">*</em>: </strong></label>
	<div class="col-sm-4">
    	
        <strong>Uploaded  <?php if($vendor_details->gst_document!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/vendor_document/<?php echo $vendor_details->gst_document; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong>
	</div>
</strong>	
</div>

<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label">Bank Account Name: </label>
	<div class="col-sm-4">
		<input type="text" name="bank_name" class="form-control" id="bank_name" value="<?php echo $vendor_details->bank_name;?>" style='text-transform:uppercase'  disabled="disabled">
	</div>
	
    	<label for="field-1" class="col-sm-2 control-label">Bank Account Number: </label>
	<div class="col-sm-4">
		<input type="text" name="bank_ac_number" class="form-control" id="bank_ac_number" value="<?php echo $vendor_details->bank_account_number;?>" style='text-transform:uppercase'  disabled="disabled">
	</div>
</strong>
</div>



<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label">Bank Account IFSC: </label>
	<div class="col-sm-4">
		<input type="text" name="bank_ac_ifsc" class="form-control" id="bank_ac_ifsc" value="<?php echo $vendor_details->bank_account_ifsc;?>" style='text-transform:uppercase'  disabled="disabled">
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Upload Cancelled Cheque: </strong></label>
	<div class="col-sm-4">
    	   <strong>Uploaded  <?php if($vendor_details->bank_doc!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/vendor_document/<?php echo $vendor_details->bank_doc; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong>
    
	</div>
</strong>	
</div>

<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label">Address 1<em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4">
		 <textarea name="address" id="address"  class="form-control" style='text-transform:uppercase'  disabled="disabled"><?php echo $vendor_details->address;?></textarea>
	</div>
	
    <label for="field-1" class="col-sm-2 control-label">Address 2 : </label>
	<div class="col-sm-4">
		 <textarea name="address_second" id="address_second"  class="form-control" style='text-transform:uppercase'  disabled="disabled"><?php echo $vendor_details->address_second;?></textarea>
	</div>
</strong>
</div>

<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label">City<em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4">
		<select  class="form-control" name="city_name" id="city_name"  disabled="disabled">
		 			 <?php echo $this->common_options->city_state_area_options($vendor_details->city);?> 
         		</select>
	</div>
    
	<label for="field-1" class="col-sm-2 control-label">Pincode<em style="color:#C00;">*</em>: </label>
	<div class="col-sm-4">
		<input type="text" name="pincode" class="form-control" id="pincode" value="<?php echo $vendor_details->pincode;?>"  disabled="disabled">
	</div>
</strong>	
</div>




<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label"><strong>	Upload Agreement : </strong></label>
	<div class="col-sm-4">
    	 <strong>Uploaded  <?php if($vendor_details->agreement_doc!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/vendor_document/<?php echo $vendor_details->agreement_doc; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong>
    
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Upload MOU:  </strong></label>
	<div class="col-sm-4">
    
    		 <strong>Uploaded  <?php if($vendor_details->mou_doc!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/vendor_document/<?php echo $vendor_details->mou_doc; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong>
	</div>
 </strong>
</div>

<div class="form-group">
<strong>
	<label for="field-1" class="col-sm-2 control-label"><strong>	 Udyam Number : </strong></label>
	<div class="col-sm-4">
         <input type="text" name="udyam_number" class="form-control" id="udyam_number" value="<?php echo $vendor_details->udyam_number;?>"  disabled="disabled">
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Upload Udyam: </strong></label>
	<div class="col-sm-4">
    	<strong>Uploaded  <?php if($vendor_details->udyam_doc!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/vendor_document/<?php echo $vendor_details->udyam_doc; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong>
	</div>
</strong>
</div>


<div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" class="btn btn-success" onclick="window.history.go(-1); return false;" type="button" value="Back" />
    </div>

   <br />
               
            
<script src="assets/js/bootstrap-multiselect.js"></script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>