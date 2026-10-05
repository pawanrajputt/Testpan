<?php  $param2;
	$cqry = $this->db->query("SELECT center_name,city FROM tt_center where 1=1 and id='".$param2."'");
		$centerName = $cqry->row()->center_name;	
		$centerCity = $cqry->row()->city;
?>
    <style>
      blink {
        animation: blinker .6s linear infinite;
        color: #FF0000;
       }
      @keyframes blinker {  
        80% { opacity: 0; }
       }
    </style>
<div class="row">
    <div class="col-md-12">
 
        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Restore Center </h3>
                </div>
            </div>

            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="delete_bunle_frm" id="delete_bunle_frm" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/restore_center_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
                <input type="hidden" name="delete_id" id="delete_id" value="<?php echo $param2;?>" /> 
                                   
                    <div class="form-group">
                       <label for="field-ta" class="col-sm-12 control-label" style="color:#360; text-align:center"><h3><strong><?php echo ucfirst($centerName); ?>, <?php echo ucfirst($centerCity); ?></strong></h3></label>
                       
                       
                    <!-- <label for="field-ta" class="col-sm-12 control-label" style="color:#360; text-align:center">
                         <textarea name="message" id="message" cols="45" rows="5"></textarea>
                       
                       </label>  
                       <label for="field-ta" class="col-sm-12 control-label" style="color:#360; text-align:center">Please Enter Reason of Delete?</label>-->
                       
                        <label for="field-ta" class="col-sm-12 control-label" style="color:#360; text-align:center"><h3><strong><blink style="font-size:30px"> ! </blink> Do you want to Restore this center?</strong></h3></label>
                        
                        <h2></h2>
                        
                        
                        
                         <p>&nbsp;</p>
                    </div>					
                    <div class="col-sm-6 control-label col-sm-offset-2">
                        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('delete_bunle_frm','save_btn')" value="Yes"> <button type="button" class="btn btn-green" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>