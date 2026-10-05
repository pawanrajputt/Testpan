<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body" style="background-color:#00FFFF">			
                <form role="form" name="edit_client" id="edit_client" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_client_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
                <input type="hidden" name="id" id="id" value="<?php echo $client_details->id;?>" />    
<div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Client Company Detail</strong></span>
	
</div>

<div class="form-group">
	<div class="col-sm-8">
	<strong>Company Name <em style="color:#C00;">*</em></strong>
		<input type="text" name="company_name" class="form-control" id="company_name" value="<?php echo $client_details->company_name;?>" style='text-transform:uppercase'/>
	</div>
	
	<div class="col-sm-4">
	<strong>Company Type </strong>
		<input type="text" name="company_type" class="form-control" id="company_type" style='text-transform:uppercase' value="<?php echo $client_details->company_type;?>">
	</div>
	
	
</div>

<div class="form-group">	

		<div class="col-sm-3">
	<strong>Address <em style="color:#C00;">*</em></strong>
			 <input type="text" name="address" id="address" class="form-control" style='text-transform:uppercase' value="<?php echo $client_details->address;?>">
			 </div>
	<div class="col-sm-3">
	<strong>Landmark</strong>
		<input type="text" name="landmark" class="form-control" id="landmark" value="<?php echo $client_details->landmark;?>">
	</div>

	 <div class="col-sm-3">
	<strong>Country <em style="color:#C00;">*</em></strong>
	
        <select  class="form-control" name="country_id" id="country_id" onchange="loadStateList();">
		 		  <?php echo $this->common_options->country_list_options($client_details->country_id);?>
         		</select>        
	</div>

	<div class="col-sm-3">
	<strong>State <em style="color:#C00;">*</em></strong>
		
         <select  class="form-control" name="state_id" id="state_id" onchange="load_city_data();">
		 		  <?php echo $this->common_options->state_list_options($client_details->state);?>
         		</select>
	</div>
</div>
<div class="form-group">		
	<div class="col-sm-4">
	<strong>City <em style="color:#C00;">*</em></strong>
         <select  class="form-control" name="city_name" id="city_name">
		 			 <?php echo $this->common_options->city_state_area_options($client_details->city);?> 
         		</select>
	</div>
	
	<div class="col-sm-4">
	<strong>Pincode</strong>
		<input type="text" name="pincode" class="form-control" id="pincode" maxlength="6" value="<?php echo $client_details->pincode;?>" onkeypress="return isNumberKey(event)" />
	</div>
	
	<div class="col-sm-4">
	<strong>Website </strong>
		<input type="text" name="website" class="form-control" id="website" style='text-transform:uppercase' value="<?php echo $client_details->website;?>">
	</div>
	
</div>





<div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Company Contact Person</strong></span>
</div>

 <div class="form-group">
	<div class="col-sm-4">
	<strong>Co-ordinator Name:</strong>
		<input type="text" name="co_ordinator_name" class="form-control" id="co_ordinator_name" style='text-transform:uppercase' value="<?php echo $client_details->co_ordinator_name;?>">
	</div>
	
	<div class="col-sm-4">
	<strong>Email <em style="color:#C00;">*</em></strong>
		<input type="text" name="email" class="form-control" id="email" value="<?php echo $client_details->email_id;?>" >
	</div>
	
	<div class="col-sm-2">
		<strong>Mobile Number <em style="color:#C00;">*</em></strong>
			<input type="text" name="mobile_no" style="width:100px" value="<?php echo $client_details->mobile_no;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Mobile Number </span>
		</div>
		<div class="col-sm-2">
			<strong>Alternate Mobile Number:</strong>
			<input type="text" name="mobile_alternate" style="width:100px" value="<?php echo $client_details->mobile_alternate;?>" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
			<span style="font-size:9px">Alternate Number</span>
		</div>

	
	<div class="form-group">
	<div class="col-sm-2" align="right">
	<strong>Landline Number:</strong>
	</div>
	
	<div class="col-sm-1" style="width:100px">
		<input type="text" name="area_code" class="form-control" id="field-8" maxlength="5" onkeypress="return isNumberKey(event)" value="<?php echo $client_details->area_code;?>">
		<span style="font-size:9px">Std Code</span>
	</div>

	<div class="col-sm-2">
		<input type="text" name="landline_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $client_details->landline_number;?>">
		<span style="font-size:9px">Landline Number</span>
	</div>
	<div class="col-sm-1">
		<input type="text" name="extension" class="form-control" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" value="<?php echo $client_details->extension;?>">
		<span style="font-size:9px">Extension</span>
	</div>

	
</div>
	
	
</div>

<div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Banking Details</strong></span>
</div>

<div class="form-group">
	
	<div class="col-sm-4">
	<strong>Bank Name:</strong>
		<input type="text" name="bank_name" class="form-control" id="bank_name" value="<?php echo $client_details->bank_name;?>" style='text-transform:uppercase'>
	</div>
	
	<div class="col-sm-4">
	<strong>Account Number:</strong>
		<input type="text" name="bank_account_no" class="form-control" id="bank_account_no" value="<?php echo $client_details->bank_account_no;?>" style='text-transform:uppercase'>
	</div> 
	
	<div class="col-sm-4">
	<strong>IFSC Code:</strong>
		<input type="text" name="bank_ifsc_code" class="form-control" id="bank_ifsc_code" value="<?php echo $client_details->bank_ifsc_code;?>" style='text-transform:uppercase'>
	</div>	

</div>
<div class="form-group">	

 <div class="col-sm-4">
	<strong>Beneficial Name:</strong>
		<input type="text" name="bank_beneficial_name" class="form-control" id="bank_beneficial_name" value="<?php echo $client_details->bank_beneficial_name;?>" style='text-transform:uppercase'>
	</div>
    
     <div class="col-sm-4">
	<strong>PAN Number:</strong>
		<input type="text" name="pan_number" class="form-control" id="pan_number" value="<?php echo $client_details->pan_number;?>" style='text-transform:uppercase'>
	</div>
    
	<div class="col-sm-4">
	<strong>GST Number:</strong>
		<input type="text" name="gst_number" class="form-control" id="gst_number" style='text-transform:uppercase' value="<?php echo $client_details->gst_number;?>">
	</div>

</div>

<div class="form-group">	

  <div class="col-sm-4">
	<strong>Upload Cancelled Cheque:   <strong>Uploaded  <?php if($client_details->bank_doc!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->bank_doc; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong> </strong>
 
		<input type="file" name="doc1" id="doc1" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf]</span>
  </div>


  <div class="col-sm-4">
	<strong>Upload Agreement:  <strong>Uploaded  <?php if($client_details->agreement_doc!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->agreement_doc; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong> </strong></strong>
		<input type="file" name="doc2" id="doc2" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf]</span>
	</div>

		<div class="col-sm-4">
	<strong>Upload MOU:  <strong>Uploaded  <?php if($client_details->mou_doc!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->mou_doc; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong> </strong></strong></strong>
		<input type="file" name="doc3" id="doc3" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf]</span>
	</div>
    
</div>

<div class="form-group">	

  <div class="col-sm-4">
	<strong>Upload GST Certificate:  <strong>Uploaded  <?php if($client_details->gst_doc!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->gst_doc; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong> </strong></strong></strong></strong>
		<input type="file" name="doc4" id="doc4" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf]</span>
  </div>


  <div class="col-sm-4">
	<strong>Udyam Aadhar Number:  </strong>
		<input type="text" name="udyam_number" class="form-control" id="udyam_number" style='text-transform:uppercase' value="<?php echo $client_details->udyam_number; ?>">
	</div>

		<div class="col-sm-4">
	<strong>Upload Udyam:    <strong>Uploaded  <?php if($client_details->udyam_doc!=''){ ?>[ &#10004; ]
  <a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->udyam_doc; ?>"><i class="entypo-eye"></i> View </a>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong> </strong></strong></strong></strong></strong>
		<input type="file" name="doc5" id="doc5" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf]</span>
	</div>
    
</div>

    <div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('edit_client','save_btn')" value="Submit">
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
                </form>
            </div>

        </div>

    </div>
</div>
<script src="assets/js/bootstrap-multiselect.js"></script>
<script>

function loadCity(){
	var state_id = $.trim($("#state_id").val());
	var city_id = $.trim($("#city_id").val());
	if(state_id==""){
		return false;
	}
	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
		
	var datastring = "state_id="+state_id+"&city_id="+city_id;	
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
			$("#city_id").html(message);
		}		
	});
}

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

