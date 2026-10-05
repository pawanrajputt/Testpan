<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
                <form role="form" name="add_admin_user" id="add_admin_user" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_package_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
                    
<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Package Name<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="text" name="package_name" class="form-control" id="package_name" placeholder="Package Name" >
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Package Cost: <em style="color:#C00;">*</em> </label>
	<div class="col-sm-3">
		<input type="text" name="package_cost" class="form-control" id="field-8" maxlength="5" onkeypress="return isNumberKey(event)" > 
	</div>
	<div class="col-sm-1">
		 (INR)
	</div>
</div>
<div class="form-group">	
	<label for="field-1" class="col-sm-3 control-label">Package Validity: <em style="color:#C00;">*</em></label>
	<div class="col-sm-3">
		<input type="text" name="package_validity" class="form-control" id="field-8" maxlength="5" onkeypress="return isNumberKey(event)" > 	</div>
		<div class="col-sm-1">
		 Month
	</div>

</div>


<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Status : <em style="color:#C00;">*</em></label>
	<div class="col-sm-3">
		 <select name="status" parsley-trigger="change" required="" placeholder="" autocomplete="off" class="form-control">								
								<option value="1" selected="selected">Active</option>								
								<option value="0">Inactive</option>								
		 </select> 
	</div>
	
</div>	
    <div class="col-sm-2 control-label col-sm-offset-2">
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_admin_user','save_btn')" value="Submit">
       
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