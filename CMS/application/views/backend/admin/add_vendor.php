add_vendor_process<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body" style="background-color:#00FFFF">		
                <form role="form" name="add_vendor" id="add_vendor" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_vendor_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

                    
<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	Vendor Name<em style="color:#C00;">*</em> : </strong></label>
	<div class="col-sm-4">
		<input type="text" name="vendor_name" class="form-control" id="vendor_name" placeholder="Vendor Name" style='text-transform:uppercase' >
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Co-Ordinator Name<em style="color:#C00;">*</em> : </strong></label>
	<div class="col-sm-4">
		<input type="text" name="co_oreinator_name" class="form-control" id="co_oreinator_name" placeholder="Enter Co ordinator name" style='text-transform:uppercase' >
	</div>
	
</div>



<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	Mobile Number: </strong></label>
	<div class="col-sm-1">
		<input type="text" name="country_code" class="form-control" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" >
		<span style="color:#060; font-size:7px"><strong>	Country Code </strong></span>
	</div>
	
	<div class="col-sm-2" style="width:135px">
		<input type="text" name="mobile_phone" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
		<span style="color:#060; font-size:7px"><strong>	Primary Number</strong></span>
	</div>
	<div class="col-sm-2" style="width:135px">
		<input type="text" name="alternate_mobile" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
		<span style="color:#060; font-size:7px"><strong>	Alternate Number</strong></span>
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Landline Number: </strong></label>
	<div class="col-sm-1" style="width:80px">
		<input type="text" name="ll_country_code" class="form-control" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" >
		<span style="color:#060; font-size:7px"><strong>	Country Code </strong> </span>
	</div>
	
	<div class="col-sm-1" style="width:80px">
		<input type="text" name="ll_area_code" class="form-control" id="field-8" maxlength="6" onkeypress="return isNumberKey(event)" >
		<span style="color:#060; font-size:7px"><strong>	Area Code </strong></span>
	</div>
	<div class="col-sm-1" style="width:120px">
		<input type="text" name="ll_number" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" >
		<span style="color:#060; font-size:7px"><strong>	Landline Number </strong></span>
	</div>
	<div class="col-sm-1" style="width:75px">
		<input type="text" name="ll_extension" class="form-control" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" >
		<span style="color:#060; font-size:7px"><strong>	Extension </strong></span>
	</div>
    
	
</div>





<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	Email<em style="color:#C00;">*</em>: </strong></label>
	<div class="col-sm-4">
		<input type="text" name="email" class="form-control" id="email" >
	</div>
    
   <label for="field-1" class="col-sm-2 control-label"><strong>	 Country<em style="color:#C00;">*</em>: </strong></label>
	<div class="col-sm-4">
		       <select  class="form-control" name="country_id" id="country_id" onchange="loadStateList();">
		 		  <?php echo $this->common_options->country_list_options('');?>
         		</select>
	</div> 
	
</div>


<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	State<em style="color:#C00;">*</em>: </strong></label>
	<div class="col-sm-4">
		        
        <select  class="form-control" name="state_id" id="state_id" onchange="load_city_data();" style='text-transform:uppercase'>
		   <?php echo $this->common_options->state_options('');?>
         </select>
	</div>
    
    	<label for="field-1" class="col-sm-2 control-label"><strong>	Pan Number<em style="color:#C00;">*</em>: </strong></label>
	<div class="col-sm-4">
		<input type="text" name="pancard_number" class="form-control" id="pancard_number" style='text-transform:uppercase'>
	</div>
    
	
</div>



<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	GST Number<em style="color:#C00;">*</em>: </strong></label>
	<div class="col-sm-4">
		<input type="text" name="gst_number" class="form-control" id="gst_number" style='text-transform:uppercase' >
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Upload GST Certificate<em style="color:#C00;">*</em>: </strong></label>
	<div class="col-sm-4">
		<input type="file" name="doc1" id="doc1" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf, png, bmp, jpeg, jpg]</span>
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	Bank Account Name: </strong></label>
	<div class="col-sm-4">
		<input type="text" name="bank_name" class="form-control" id="bank_name" style='text-transform:uppercase'>
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Bank Account Number: </strong></label>
	<div class="col-sm-4">
		<input type="text" name="bank_ac_number" class="form-control" id="bank_ac_number" style='text-transform:uppercase'>
	</div>
	
</div>



<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	Bank Account IFSC: </strong></label>
	<div class="col-sm-4">
		<input type="text" name="bank_ac_ifsc" class="form-control" id="bank_ac_ifsc" style='text-transform:uppercase' >
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Upload Cancelled Cheque: </strong></label>
	<div class="col-sm-4">
		<input type="file" name="doc2" id="doc2" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf, png, bmp, jpeg, jpg]</span>
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	Address 1<em style="color:#C00;">*</em>: </strong></label>
	<div class="col-sm-4">
		 <textarea name="address" id="address"  class="form-control" style='text-transform:uppercase'></textarea>
	</div>
    
    	<label for="field-1" class="col-sm-2 control-label"><strong>	Address 2 : </strong></label>
	<div class="col-sm-4">
		 <textarea name="address_second" id="address_second"  class="form-control" style='text-transform:uppercase'></textarea>
	</div>
	
	
</div>


<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	City : </strong></label>
	<div class="col-sm-4">
         <select  class="form-control" name="city_name" id="city_name">
		 			 <option value="">Select One</option>
         </select>
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Pincode: </strong></label>
	<div class="col-sm-4">
		<input type="text" name="pincode" class="form-control" id="pincode" >
	</div>
	
	
</div>


<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	Upload Agreement : </strong></label>
	<div class="col-sm-4">
         <input type="file" name="doc3" id="doc3" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf, png, bmp, jpeg, jpg]</span>
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Upload MOU:  </strong></label>
	<div class="col-sm-4">
		<input type="file" name="doc4" id="doc4" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf, png, bmp, jpeg, jpg]</span>
	</div>
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label"><strong>	 Udyam Number : </strong></label>
	<div class="col-sm-4">
         <input type="text" name="udyam_number" class="form-control" id="udyam_number" >
	</div>
    
    <label for="field-1" class="col-sm-2 control-label"><strong>	Upload Udyam: </strong></label>
	<div class="col-sm-4">
		<input type="file" name="doc5" id="doc5" /> <span style="color:#060; font-size:10px;">[Max: 2MB, doc, docx, pdf, png, bmp, jpeg, jpg]</span>
	</div>
</div>






    <div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_vendor','save_btn')" value="Submit">
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