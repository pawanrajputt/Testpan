<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
                <form role="form" name="change_password" id="change_password" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/password_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

                    
<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">Old Password<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="password" name="old_pass" class="form-control" id="old_pass"  style='text-transform:uppercase' >
	</div>
	
</div>

<div class="form-group">
	<label for="field-1" class="col-sm-3 control-label">New Password<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-5">
		<input type="password" name="new_pass" class="form-control" id="new_pass"  style='text-transform:uppercase' >
	</div>
	
</div>
<div class="form-group">
  <label for="field-1" class="col-sm-3 control-label">Re enter Password<em style="color:#C00;">*</em>: </label>
	<div class="col-sm-5">
		<input type="password" name="re_new_pass" class="form-control" id="re_new_pass" style='text-transform:uppercase'>
	</div>
	
</div>

    <div class="col-sm-4 control-label col-sm-offset-2">
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('change_password','save_btn')" value="Submit">
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
                </form>
            </div>

        </div>

    </div>
</div>
<script src="assets/js/bootstrap-multiselect.js"></script>
