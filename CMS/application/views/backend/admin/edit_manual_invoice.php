<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
                <form role="form" name="edit_manual_invoice" id="edit_manual_invoice" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_manual_invoice_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				 <input type="hidden" name="id" id="id" value="<?php echo $mp_inv_details->id;?>" />   
                 <input type="hidden" name="pan_card" id="pan_card" value="<?php echo $mp_inv_details->beneficiary_pan_no;?>" />      
       <div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Financial Year<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<select  class="form-control" name="financial_year" id="financial_year">
		 		  <?php echo $this->common_options->financial_year_options($mp_inv_details->financial_year);?>
         		</select>
	</div>
	
</div>             
                    
<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Bill Date<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="bill_date" class="form-control datepicker" value="<?php if($mp_inv_details->bill_date){ echo date('d/m/Y', strtotime($mp_inv_details->bill_date));}?>">
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Payment Date<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="payment_date" class="form-control datepicker" value="<?php if($mp_inv_details->payment_date){ echo date('d/m/Y', strtotime($mp_inv_details->payment_date));}?>">
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Payment Status<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<select  class="form-control" name="payment_status" id="payment_status">
		 		  <?php echo $this->common_options->payment_status_options($mp_inv_details->payment_status);?>
         		</select>
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Exam Name<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="exam_name" class="form-control" id="exam_name" placeholder="" style='text-transform:uppercase' value="<?php echo $mp_inv_details->exam_name;?>" >
	</div>
	
</div>
<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Exam Start Date<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="exam_start_date" class="form-control datepicker" value="<?php if($mp_inv_details->exam_start_date){ echo date('d/m/Y', strtotime($mp_inv_details->exam_start_date));}?>">
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Exam End Date<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="exam_end_date" class="form-control datepicker" value="<?php if($mp_inv_details->exam_end_date){ echo date('d/m/Y', strtotime($mp_inv_details->exam_end_date));}?>">
	</div>
	
</div>


<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Manpower Name<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="manpower_name" class="form-control" id="manpower_name" placeholder="" style='text-transform:uppercase' value="<?php echo $mp_inv_details->manpower_name;?>">
	</div>
	
</div>


<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Mobile Number<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="mobile_phone" class="form-control" id="field-8" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $mp_inv_details->mobile_no;?>">
	</div>
	
</div>


<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Email Id<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
				<input type="text" name="email" class="form-control" id="email" value="<?php echo $mp_inv_details->email_id;?>">
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Amount<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="amount" class="form-control" id="amount" placeholder="" style='text-transform:uppercase' value="<?php echo $mp_inv_details->amount;?>">
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Beneficiary Name<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="beneficiary_name" class="form-control" id="beneficiary_name" placeholder="" style='text-transform:uppercase' value="<?php echo $mp_inv_details->beneficiary_name;?>">
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Bank IFSC Code<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="ifsc_code" class="form-control" id="ifsc_code" placeholder="" style='text-transform:uppercase' value="<?php echo $mp_inv_details->bank_ifsc_code;?>">
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Beneficiary Account No.<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="beneficiary_account_no" class="form-control" id="beneficiary_account_no" placeholder="" style='text-transform:uppercase' value="<?php echo $mp_inv_details->beneficiary_account_no;?>">
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">PAN Number<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="beneficiary_pan_no" class="form-control" id="beneficiary_pan_no" placeholder="" style='text-transform:uppercase' value="<?php echo $mp_inv_details->beneficiary_pan_no;?>">
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-2 control-label">Remarks : </label>
	<div class="col-sm-5">
		<textarea name="remarks" id="remarks"  class="form-control" style='text-transform:uppercase'><?php echo $mp_inv_details->remarks;?></textarea>
	</div>
	
</div>


    <div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('edit_manual_invoice','save_btn')" value="Submit">
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

