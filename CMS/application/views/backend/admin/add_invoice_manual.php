 <link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">

<div class="row">

    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0" style="background-color:#ffffd9">
            
            <div class="panel-body">			
                <form role="form" name="add_invoice_manual" id="add_invoice_manual" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_invoice_manual_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />





<!--
<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Manpower Profle</strong></span>
</div>-->

<div class="form-group" style="background-color:#ffffd9">
	
       <div class="col-sm-2">
	<strong>Financial Year </strong>
				 <select name="fy_year" class="form-control" style="height:30px">
      <option value="">Financial Year</option>
      <option value="2024-25">2024-25</option>
      <?php if($this->session->userdata('login_user_id')==1){?><option value="2023-24">2023-24</option><?php } ?>
	  <option value="2025-26">2025-26</option>
	  <option value="2026-27">2026-27</option>
    </select>
	</div>

	<div class="col-sm-3">
	<strong >Manpower Name </strong>
		<input type="text" name="manpower_name" class="form-control" id="manpower_name" style="text-transform:uppercase">
	</div>
    
   	<div class="col-sm-5">
	<strong >Manpower Address </strong>
		<input type="text" name="address" class="form-control" id="address" style="text-transform:uppercase">
	</div>

	<div class="col-sm-2">
	<strong >Mobile Number <em style="color:#C00;">*</em></strong>
		<input type="text" name="contact_number" class="form-control" id="contact_number" style="text-transform:uppercase" maxlength="10" onkeypress="return isNumberKey(event)" >
	</div>
    
</div>

<div class="form-group" style="background-color:#ffffd9">

    <div class="col-sm-3">
	<strong>Email Id  <em style="color:#C00;">*</em></strong>
		<input type="text" name="email" class="form-control" id="email" style="text-transform:uppercase">
	</div>

  
    
    


  <div class="col-sm-3">
		<strong>Accout Holder Name </strong>
		<input type="text" name="account_holder_name" class="form-control" id="account_holder_name" placeholder="" style="text-transform:uppercase" >
	</div>
	
   
<div class="col-sm-2">
	<strong>Bank Account Number </strong>
		<input type="text" name="bank_account_number" class="form-control" id="bank_account_number" placeholder="" style="text-transform:uppercase" >
	</div>
    
     <div class="col-sm-2">
	<strong>IFSC Code </strong>
		<input type="text" name="ifsc_code" class="form-control" id="ifsc_code" placeholder="" style="text-transform:uppercase" >
	</div>


	<div class="col-sm-2">
	<strong>Pan Number </strong>
		 <input type="text" name="pan_number" class="form-control" id="pan_number" placeholder="" style="text-transform:uppercase" >
	</div>
    
</div>
<div class="form-group" style="background-color:#ffffd9">

    <div class="col-sm-3">
	<strong>Bank Name </strong>
			<input type="text" name="bank_name" class="form-control" id="bank_name" placeholder="" style="text-transform:uppercase">
	</div>
	
	<div class="col-sm-3">
	<strong>Branch Name </strong>
				<input type="text" name="branch_name" class="form-control" id="branch_name" placeholder="" style="text-transform:uppercase" >
	</div>
    
 
    
    
   
</div>


<div class="form-group" style="background-color:#17A2B8">
</div>


<div class="form-group" style="background-color:#f8f8f8">
	<div class="col-sm-2">
	<strong>Exam Start Date </strong>
		<input type="date" name="exam_date[]" class="form-control" style="text-transform:uppercase"  >
	</div>
    
    <div class="col-sm-2">
	<strong>Exam End Date <em style="color:#C00;">*</em></strong>
		<input type="date" name="exam_end_date[]" class="form-control" style="text-transform:uppercase" >
	</div>
	
    <div class="col-sm-4">
	<strong>Exam Name </strong>
		<input type="text" name="exam_name[]" class="form-control" placeholder=""  style="text-transform:uppercase"  >
	</div>
    <div class="col-sm-2">
	<strong>Number of Manpower</strong>
		 <input type="text" name="no_of_manpower[]" class="form-control" placeholder="" style="text-transform:uppercase" >
	</div>
	<div class="col-sm-2">
	<strong>Number of Days</strong>
		 <input type="text" name="no_of_days[]" class="form-control" placeholder="" style="text-transform:uppercase" ="">
	</div>
    
    <div class="col-sm-2">
	<strong>Payment Mode</strong><br />
    	<select name="pay_mode[]" class="form-control">
        	<option value="">Select Pay Mode</option>	
    	  <option value="Per Day">PER DAY</option>
    	  <option value="Per Hour">PER HOUR</option>
    	</select>
	</div>
    
   
    
    <div class="col-sm-2">
	<strong>Price Per Day </strong>
		 <input type="text" name="price_per_day[]" class="form-control" placeholder="" style="text-transform:uppercase" onchange="CheckNo(this)" ><span style="font-size:10px; color:#030">*[ Not be less than Rs. 1000 ]</span>
	</div>

	<div class="col-sm-2">
	<strong>Price Per Hour </strong>
			<input type="text" name="price_per_hour[]" class="form-control" placeholder="" style="text-transform:uppercase" onchange="CheckNewNo(this)"><span style="font-size:10px; color:#030">*[ Not be less than Rs. 125 ]</span>
	</div>

	<div class="col-sm-2">
	<strong>Total Price </strong>
			<input type="text" name="total_price[]" class="form-control" placeholder="" style="text-transform:uppercase" >
	</div>
    
    <div class="col-sm-4" align="right">
	<strong>&nbsp; </strong><br />
			<button type="button" name="add" id="add" class="btn btn-success">Add More</button>
	</div>
	
</div>	



<div class="form-group" style="background-color:#17A2B8">
</div>

<div style="clear:both;"></div> 

 <table width="100%" border="0" align="center" class="table-responsive" id="dynamic_field" style="background-color:#17A2B8">
                    
 </table>





<div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
   
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_invoice_manual','save_btn')" value="Submit">
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
		$('#dynamic_field').append('<div id="row'+i+'"><div class="form-group" style="background-color:#f8f8f8"><div class="col-sm-2"><strong>Exam Start Date </strong><input type="date" name="exam_date[]" id="exam_date" class="form-control" style="text-transform:uppercase" ></div><div class="col-sm-2"><strong>Exam End Date <em style="color:#C00;">*</em></strong><input type="date" name="exam_end_date[]" class="form-control" style="text-transform:uppercase" ></div><div class="col-sm-4"><strong>Exam Name </strong><input type="text" name="exam_name[]" class="form-control" placeholder="" style="text-transform:uppercase" >	</div><div class="col-sm-2"><strong>Number of Manpower</strong><input type="text" name="no_of_manpower[]" class="form-control" placeholder="" style="text-transform:uppercase" ></div><div class="col-sm-2"><strong>Number of Days</strong><input type="text" name="no_of_days[]" class="form-control" placeholder="" style="text-transform:uppercase"></div><div class="col-sm-2"><strong>Payment Mode</strong><br /><select name="pay_mode[]" class="form-control"><option value="">Select Pay Mode</option><option value="Per Day">PER DAY</option><option value="Per Hour">PER HOUR</option></select></div><div class="col-sm-2"><strong>Price Per Day </strong><input type="text" name="price_per_day[]" class="form-control" placeholder="" style="text-transform:uppercase" onchange="CheckNo(this)" ><span style="font-size:10px; color:#030">*[ Not be less than Rs. 1000 ]</span></div><div class="col-sm-2"><strong>Price Per Hour </strong><input type="text" name="price_per_hour[]" class="form-control" placeholder="" style="text-transform:uppercase" onchange="CheckNewNo(this)"><span style="font-size:10px; color:#030">*[ Not be less than Rs. 125 ]</span></div><div class="col-sm-2"><strong>Total Price </strong><input type="text" name="total_price[]" class="form-control" placeholder="" style="text-transform:uppercase" ></div><div class="col-sm-4" align="right"><label><p>&nbsp;</p><br></label><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" style="height:30px">X</button></div></div><div style="clear:both;"></div>');
	});
	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
});



</script>