<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
                <form role="form" name="add_admin_role" id="add_admin_role" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_admin_role_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
                    
<div class="form-group">

<div class="col-sm-3">
	<strong>Admin Role:</strong> <br />
			<input type="text" name="admin_role_name" class="form-control" id="admin_role_name" placeholder="Admin Role" >
	</div>
</div>

<div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Rights to Access Menu</strong></span>
</div>


<div class="form-group">
	<div class="col-sm-3">
	<strong>Access to Admin Users:</strong> <br />
				<input type="radio" name="access_admin" id="access_admin" value="1" /> Yes
				<input type="radio"  name="access_admin" id="access_admin" value="2" /> No
	</div>
	
	<div class="col-sm-3">
	<strong>Access to Vendors:</strong> <br />
			<input type="radio" name="access_vendor" id="access_vendor" value="1" /> Yes
				<input type="radio"  name="access_vendor" id="access_vendor" value="2" /> No
	</div>
	
	<div class="col-sm-3">
	<strong>Access to Center:</strong> <br />
		<input type="radio" name="access_center" id="access_center" value="1" /> Yes
				<input type="radio"  name="access_center" id="access_center" value="2" /> No
	</div>
	
	<div class="col-sm-3">
	<strong>Access to Client:</strong> <br />
		<input type="radio" name="access_client" id="access_client" value="1" /> Yes
				<input type="radio"  name="access_client" id="access_client" value="2" /> No
	</div>
</div>

<div class="form-group">

	
<div class="col-sm-3">
	<strong>Access to Booking:</strong> <br />
		<input type="radio" name="access_booking" id="access_booking" value="1" /> Yes
				<input type="radio"  name="access_booking" id="access_booking" value="2" /> No
	</div>
<div class="col-sm-3">
	<strong>Access to Project:</strong> <br />
		<input type="radio" name="access_project" id="access_project" value="1" /> Yes
				<input type="radio"  name="access_project" id="access_project" value="2" /> No
	</div>	
	<div class="col-sm-3">
	<strong>Access to Invoice:</strong> <br />
		<input type="radio" name="access_invoice" id="access_invoice" value="1" /> Yes
				<input type="radio"  name="access_invoice" id="access_invoice" value="2" /> No
	</div>	
	<div class="col-sm-3">
	<strong>Access to Manpower:</strong> <br />
		<input type="radio" name="access_manpower" id="access_manpower" value="1" /> Yes
				<input type="radio"  name="access_manpower" id="access_manpower" value="2" /> No
	</div>	
</div>

<div class="form-group">
<div class="col-sm-3">
	<strong>Manpower Payment:</strong> <br />
		<input type="radio" name="access_manpower_payment" id="access_manpower_payment" value="1" /> Yes
		<input type="radio"  name="access_manpower_payment" id="access_manpower_payment" value="2" /> No
	</div>	
	
<div class="col-sm-3">
	<strong>Download Excel (Center):</strong> <br />
		<input type="radio" name="center_download_permit" id="center_download_permit" value="1" /> Yes
				<input type="radio"  name="center_download_permit" id="center_download_permit" value="2" /> No
	</div>
	
		
		
</div>

	
		
    <div class="col-sm-2 control-label col-sm-offset-2">
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_admin_role','save_btn')" value="Submit">
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
                </form>
            </div>

        </div>

    </div>
</div>
<script src="assets/js/bootstrap-multiselect.js"></script>
<script>

$(document).ready(function(){
	//keep data in d/m/y format
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy'/*,
		startDate: '-3d'*/
	})
});
</script>