<?php  $param2;
	$lqry = $this->db->query("SELECT * FROM tt_lab where 1=1 and id='".$param2."'");
		$centerId = $lqry->row()->center_id;	
		$labName = $lqry->row()->lab_name;
		
		$cqry = $this->db->query("SELECT center_name,city FROM tt_center where 1=1 and id='".$centerId."'");
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

            <div class="panel-heading" align="center">
                <div class="panel-title">
                    <h3>Delete Lab </h3>
                </div>
            </div>

            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="delete_bunle_frm" id="delete_bunle_frm" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/delete_lab_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
                <input type="hidden" name="centerId" id="centerId" value="<?php echo $centerId;?>" /> 
                 <input type="hidden" name="delete_id" id="delete_id" value="<?php echo $param2;?>" /> 
                                   
                    <div class="form-group">
                       <label for="field-ta" class="col-sm-12 control-label" style="color:#360; text-align:center"><h4><strong>Lab Name: <?php echo ucfirst($labName); ?>, Center Name: <?php echo ucfirst($centerName); ?>, <?php echo ucfirst($centerCity); ?></strong>
                         <textarea name="message" id="message" cols="45" rows="5"></textarea>
                       
                       </label>
                         <label for="field-ta" class="col-sm-12 control-label" style="color:#360; text-align:center">Reason of Delete?</label>
                    </h4>    <label for="field-ta" class="col-sm-12 control-label" style="color:#360; text-align:center"><h3><strong><blink style="font-size:30px"> ! </blink> Are You Sure to delete this Lab?</strong></h3></label>
                      <label for="message"></label>
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