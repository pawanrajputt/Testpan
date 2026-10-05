<?php

$query = $this->db->query("SELECT * FROM tt_center_booking where 1=1 and id='".$this->db->escape_str($param2)."'");
$row = $query->row();
$project_name=$row->project_name;
$center_name=$row->center_name;
$city_center=$row->city_name;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Send Mail </h3>
                </div>
            </div>

			<div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo ucfirst($project_name); ?>, Center Name: <?php echo ucfirst($center_name); ?>, <?php echo ucfirst($city_center); ?>  </h4>
                </div>
            </div>
            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="send_email_pending_center" id="send_email_pending_center" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/send_mail_for_center" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $param2;?>" />
				<input type="hidden" name="centerId" id="centerId" value="<?php echo $centerId;?>" />
                  
				    
					 <div class="form-group">
                        <label for="field-ta" class="col-sm-2 control-label">To</label>

                        <div class="col-sm-10">
							<input type="text" value="" name="sender_email_id" class="form-control" id="field-2"  >
												
                        </div>
                    </div>
					
			
					
					 <div class="form-group">
                        <label for="field-ta" class="col-sm-2 control-label">Message</label>

                        <div class="col-sm-10">
							<textarea name="mail_message" id="mail_message"  class="form-control" rows="10"></textarea>
												
                        </div>
                    </div>
			

                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('send_email_pending_center','save_btn')" value="Submit">
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