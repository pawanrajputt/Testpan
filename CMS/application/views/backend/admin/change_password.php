<?php

$query = $this->db->query("SELECT * FROM tt_admin_users where 1=1 and id='".$this->db->escape_str($param2)."'");
$row = $query->row();
$first_name=$row->first_name;
$last_name=$row->last_name;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Change Paassword </h3>
                </div>
            </div>

			<div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo ucfirst($first_name); ?> <?php echo ucfirst($last_name); ?> </h4>
                </div>
            </div>
            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="change_password" id="change_password" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/change_password_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $param2;?>" />
                  
				    
					 <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">New Password</label>

                        <div class="col-sm-5">
							<input type="text" value="" name="password" class="form-control" id="field-2"  >
												
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Re enter Password</label>

                        <div class="col-sm-5">
							<input type="text" value="" name="repassword" class="form-control" id="field-2"  >
												
                        </div>
                    </div>
                    
                    
				    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('change_password','save_btn')" value="Submit">
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>