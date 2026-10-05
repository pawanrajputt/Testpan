<?php /*?><script src="<?php echo base_url();?>assets/js/hindi_font.js"></script><?php */?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Add new letter</h3>
                </div>
            </div>

            <div class="panel-body">			
                <form role="form" name="add_new_bundle_frm" id="add_new_bundle_frm" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_new_bundle_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
                <input type="hidden" name="assistant_director_signature_file_name" id="assistant_director_signature_file_name" value=""  />			

<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Select Regonal Office<em style="color:#FF0000;">*</em>:</label>
	<div class="col-sm-4">
		<select  class="form-control" name="state_id" id="state_id" onchange="loadCity();">
		   <?php echo $this->common_options->state_options($state_id);?>
         </select>
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Select Assiatant Director Office<em style="color:#FF0000;">*</em>:</label>
	<div class="col-sm-4">
		<select  class="form-control" name="city" id="city" onchange="load_assistant_director_data();">
		   <?php echo $this->common_options->get_city_list($city);?>
         </select>
	</div>

</div>

<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Select AD Working Area:</label>	
	<div class="col-sm-4">
		<select  class="form-control" name="center_ids_list" id="center_ids_list">
		  <option value="">Select One</option>
         </select>
	</div>

</div>

<?php /*?><div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">STATION AD / M&SEC: </label>
	<div class="col-sm-4">
	<input type="text" name="station_ad_m_sec" class="form-control" id="station_ad_m_sec" >
	</div>

</div><?php */?>

<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">DCHAD Letter No<em style="color:#FF0000;">*</em>:</label>
	<div class="col-sm-4">
	<input type="text" name="dch_letter_no" class="form-control" id="dch_letter_no" >
	</div>

</div>
<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Letter Date<em style="color:#FF0000;">*</em>:</label>
	
	<div class="col-sm-4">
	<input type="text" name="date_of_receipt_of_form" class="form-control datepicker" id="date_of_receipt_of_form" >
	</div>
</div>
<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">FORM QUANTITY RECD.:</label>
	<div class="col-sm-4">
	<input type="number" name="form_quantity_received" class="form-control" id="form_quantity_received" >
	</div>
</div>
<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Assistant Director Signature:</label>
	<div class="col-sm-4">
	<span id="show_signature"></span>
	</div>
</div>

<div class="col-sm-2 control-label col-sm-offset-2">     
     <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_new_bundle_frm','save_btn')" value="Submit">
</div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
                </form>
            </div>

        </div>

    </div>
</div>
<script type="text/javascript">
function load_assistant_director_data(){
	var city = $.trim($("#city").val());	
	if(city==""){
		return false;
	}
	//show_signature
	var datastring = "city="+city;	
	var url = "<?php echo base_url();?>index.php?admin/load_dynamic_city_center_data";	
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
			if(message.director_office_data.office_head_signature_thumb){
				$("#show_signature").html("<img src='<?php echo base_url();?>uploads/user_image/assistant_director_signature/thumb/"+message.director_office_data.office_head_signature_thumb+"'> Name: <strong>"+message.director_office_data.office_head_name+"</strong>");
				$("#assistant_director_signature_file_name").val(message.office_head_signature_thumb);
			}	
			
			if(message.ed_options){
				$("#center_ids_list").html(message.ed_options);	
			}
			
			$("#save_btn").val("Submit");
			$("#save_btn").attr("disabled", false);		
		}		
		
	});
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