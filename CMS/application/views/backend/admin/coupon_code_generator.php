<style type="text/css">
.multiselect {
    width:30em;
    height:15em;
    border:solid 1px #c0c0c0;
    overflow:auto;
}
 
.multiselect label {
    display:block;
}
 
.multiselect-on {
    color:#ffffff;
    background-color:#ACBA91;
}
.hintPanda{display:none; visibility:hidden;}

input[type="radio"]:checked+label { font-weight: bolder; color: #007a7a }
</style>



<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
                <form role="form" name="add_admin_user" id="add_admin_user" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/generate_coupon_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
                    
<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Center Owner Name<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		  
		
		<select class="form-control select2" multiple="multiple"  name="user_name[]" id="user_name" style='text-transform:uppercase' >
		  <?php echo $this->common_options->center_owner_name_option('');?>
        </select>
		<span style="color:#006600">[Select Multiple Center Owner for Generate Coupon Code]</span>
		
		
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Coupon Validity (in month)<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		  
		
		<input type="text" name="validity" class="form-control" id="validity" required  maxlength="2">
		<span style="color:#006600">[Validity of Coupon in month]</span>
		
		
	</div>
	
</div>

    <div class="col-sm-3 control-label col-sm-offset-3">
	
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_admin_user','save_btn')" value="Generate Coupon">
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