 <link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">

<div class="row">

    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0" style="background-color:#ffffd9">
            
            <div class="panel-body">			
                 <form role="form" name="edit_invoice_manual" id="edit_invoice_manual" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_invoice_manual_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />




<!--
<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Manpower Profle</strong></span>
</div>-->

<div class="form-group" style="background-color:#ffffd9">

	<div class="col-sm-3">
	<strong >Manpower Name </strong>
		<input type="text" name="manpower_name" class="form-control" id="manpower_name" style="text-transform:uppercase" value="<?php echo $mp_prof_details->manpower_name;?>">
	</div>
    
   	<div class="col-sm-4">
	<strong >Manpower Address </strong>
		<input type="text" name="address" class="form-control" id="address" style="text-transform:uppercase" value="<?php echo $mp_prof_details->address;?>">
	</div>

	<div class="col-sm-2">
	<strong >Mobile Number <em style="color:#C00;">*</em></strong>
		<input type="text" name="contact_number" class="form-control" id="contact_number" style="text-transform:uppercase" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $mp_prof_details->contact_number;?>">
	</div>
    <div class="col-sm-3">
	<strong>Email Id  <em style="color:#C00;">*</em></strong>
		<input type="text" name="email" class="form-control" id="email" style="text-transform:uppercase" value="<?php echo $mp_prof_details->email;?>">
	</div>
  </div>
  
    
    
<div class="form-group" style="background-color:#ffffd9">

  <div class="col-sm-2">
		<strong>Accout Holder Name </strong>
		<input type="text" name="account_holder_name" class="form-control" id="account_holder_name" placeholder="" style="text-transform:uppercase" value="<?php echo $mp_prof_details->account_holder_name;?>">
	</div>
	
   
<div class="col-sm-2">
	<strong>Bank Account Number </strong>
		<input type="text" name="bank_account_number" class="form-control" id="bank_account_number" placeholder="" style="text-transform:uppercase" value="<?php echo $mp_prof_details->bank_account_number;?>">
	</div>
    
     <div class="col-sm-2">
	<strong>IFSC Code </strong>
		<input type="text" name="ifsc_code" class="form-control" id="ifsc_code" placeholder="" style="text-transform:uppercase" value="<?php echo $mp_prof_details->ifsc_code;?>">
	</div>


	<div class="col-sm-2">
	<strong>Pan Number </strong>
		 <input type="text" name="pan_number" class="form-control" id="pan_number" placeholder="" style="text-transform:uppercase" value="<?php echo $mp_prof_details->pan_number;?>">
	</div>
    <div class="col-sm-2">
	<strong>Bank Name </strong>
			<input type="text" name="bank_name" class="form-control" id="bank_name" placeholder="" style="text-transform:uppercase" value="<?php echo $mp_prof_details->bank_name;?>">
	</div>
	
	<div class="col-sm-2">
	<strong>Branch Name </strong>
				<input type="text" name="branch_name" class="form-control" id="branch_name" placeholder="" style="text-transform:uppercase" value="<?php echo $mp_prof_details->branch_name;?>">
	</div>
</div>

<div class="form-group" style="background-color:#17A2B8">
</div>
 <?php            
		 foreach($mp_details as $invData){  	
		 
      ?>
	<input type="hidden" name="invId[]" value="<?php echo $invData['id'];?>" />
    <input type="hidden" name="group_id" value="<?php echo $invData['group_id'];?>" />
    <input type="hidden" name="invoice_number" value="<?php echo $invData['invoice_number'];?>" />
     <input type="hidden" name="financial_year" value="<?php echo $invData['financial_year'];?>" />

<div class="form-group" style="background-color:#f8f8f8">
	<div class="col-sm-2">
	<strong>Exam Start Date </strong>
		<input type="date" name="exam_date[]" class="form-control" style="text-transform:uppercase"  value="<?php if($invData['exam_date']!='0000-00-00'){ echo $invData['exam_date'];}?>">
	</div>
    
    <div class="col-sm-2">
	<strong>Exam End Date <em style="color:#C00;">*</em></strong>
		<input type="date" name="exam_end_date[]" class="form-control" style="text-transform:uppercase" value="<?php if($invData['exam_end_date']!='0000-00-00'){ echo $invData['exam_end_date'];}?>">
	</div>
	
    <div class="col-sm-4">
	<strong>Exam Name </strong>
		<input type="text" name="exam_name[]" class="form-control" placeholder=""  style="text-transform:uppercase" value="<?php echo $invData['exam_name'];?>" >
	</div>
    <div class="col-sm-2">
	<strong>Number of Manpower</strong>
		 <input type="text" name="no_of_manpower[]" class="form-control" placeholder="" style="text-transform:uppercase" value="<?php echo $invData['no_of_manpower'];?>">
	</div>
	<div class="col-sm-2">
	<strong>Number of Days</strong>
		 <input type="text" name="no_of_days[]" class="form-control" placeholder="" style="text-transform:uppercase" value="<?php echo $invData['no_of_days'];?>">
	</div>
    
    <div class="col-sm-2">
	<strong>Payment Mode</strong>
		 <select name="pay_mode[]" class="form-control">
        	<option value="">Select Pay Mode</option>	
    	  <option value="Per Day" <?php if($invData['price_mode']=='Per Day'){?> selected="selected"<?php } ?>>PER DAY</option>
    	  <option value="Per Hour" <?php if($invData['price_mode']=='Per Hour'){?> selected="selected"<?php } ?>>PER HOUR</option>
    	</select>
	</div>
    
    <div class="col-sm-2">
	<strong>Price per Day </strong>
		 <input type="text" name="price_per_day[]" class="form-control" placeholder="" style="text-transform:uppercase" onchange="CheckNo(this)" value="<?php echo $invData['price_per_day'];?>"><span style="font-size:10px; color:#030">*[ Not be less than Rs. 1000 ]</span>
	</div>

	<div class="col-sm-2">
	<strong>Price per Hour </strong>
			<input type="text" name="price_per_hour[]" class="form-control" placeholder="" style="text-transform:uppercase" onchange="CheckNewNo(this)" value="<?php echo $invData['price_per_hour'];?>"><span style="font-size:10px; color:#030">*[ Not be less than Rs. 125 ]</span>
	</div>

	<div class="col-sm-2">
	<strong>Total Price </strong>
			<input type="text" name="total_price[]" class="form-control" placeholder="" style="text-transform:uppercase" value="<?php echo $invData['total_price'];?>">
	</div>
   
	
</div>	


<div class="form-group" style="background-color:#17A2B8">
</div>

<div style="clear:both;"></div> 
<?php } ?>


 <table width="100%" border="0" align="center" class="table-responsive" id="dynamic_field" style="background-color:#17A2B8">
                    
 </table>

<div class="col-sm-4 control-label col-sm-offset-2">

<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('edit_invoice_manual','save_btn')" value="Submit">
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p>
    <span style="margin-left:100%; margin-right:2%"><button type="button" name="add" id="add" class="btn btn-success btn-blue">Add More</button>
    </span>
    </div>
    
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
</script>

<script>
function CheckNo(sender){
    if(!isNaN(sender.value)){
        if(sender.value <=999 )
            sender.value = '';
			// $('#errorMsg').show();
       
    }else{
          sender.value = '';
		//  $('#errorMsg').hide();
    }
}

function CheckNewNo(sender){
    if(!isNaN(sender.value)){
        if(sender.value <=124 )
            sender.value = '';
			// $('#errorMsg').show();
       
    }else{
          sender.value = '';
		//  $('#errorMsg').hide();
    }
}

</script>   

<script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		$('#dynamic_field').append('<div id="row'+i+'"><div class="form-group" style="background-color:#f8f8f8"><div class="col-sm-2"><strong>Exam Start Date </strong><input type="date" name="exam_date[]" id="exam_date" class="form-control" style="text-transform:uppercase" required></div><div class="col-sm-2"><strong>Exam End Date <em style="color:#C00;">*</em></strong><input type="date" name="exam_end_date[]" class="form-control" style="text-transform:uppercase"></div><div class="col-sm-4"><strong>Exam Name </strong><input type="text" name="exam_name[]" class="form-control" placeholder="" style="text-transform:uppercase">	</div><div class="col-sm-2"><strong>Number of Manpower</strong><input type="text" name="no_of_manpower[]" class="form-control" placeholder="" style="text-transform:uppercase"></div><div class="col-sm-2"><strong>Number of Days</strong><input type="text" name="no_of_days[]" class="form-control" placeholder="" style="text-transform:uppercase"></div><div class="col-sm-2"><strong>Payment Mode</strong><br /><select name="pay_mode[]" class="form-control"><option value="">Select Pay Mode</option><option value="Per Day">PER DAY</option><option value="Per Hour">PER HOUR</option></select></div><div class="col-sm-2"><strong>Price Per Day </strong><input type="text" name="price_per_day[]" class="form-control" placeholder="" style="text-transform:uppercase" onchange="CheckNo(this)" ><span style="font-size:10px; color:#030">*[ Not be less than Rs. 1000 ]</span></div><div class="col-sm-2"><strong>Price Per Hour </strong><input type="text" name="price_per_hour[]"class="form-control" placeholder="" style="text-transform:uppercase" onchange="CheckNewNo(this)"><span style="font-size:10px; color:#030">*[ Not be less than Rs. 125 ]</span></div><div class="col-sm-2"><strong>Total Price </strong><input type="text" name="total_price[]" class="form-control" placeholder="" style="text-transform:uppercase"></div><div class="col-sm-4" align="right"><label><p>&nbsp;</p><br></label><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" style="height:30px">X</button></div></div><div style="clear:both;"></div>');
	});
	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
});
</script>