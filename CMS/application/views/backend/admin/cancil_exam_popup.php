<?php

$prj_qry_dtl = $this->db->query("SELECT * FROM tt_exam_booking_detail where id='".$this->db->escape_str($param2)."' and deleted=0")->row();							 $project_name=ucwords($prj_qry->project_name);	


//$vendor_details->vendor_name;
//$row = $query->row();
 '<br>ii='.$id=$prj_qry_dtl->id;
$project_id=$prj_qry_dtl->project_id;
$project_name=$prj_qry_dtl->project_name;
$center_id=$prj_qry_dtl->center_id;
$center_name=$prj_qry_dtl->center_name;
$city_id=$prj_qry_dtl->city_id;
$city_name=$prj_qry_dtl->city_name;
$exam_date=$prj_qry_dtl->exam_date;



?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Cancil Booking </h3>
                </div>
            </div>

			
            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="cancil_exam_popup" id="cancil_exam_popup" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/cancil_exam_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $param2;?>" />
					<input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id;?>" />
				    
					 <div class="form-group">
							<label class="col-sm-12"><h3 align="center">Are you sure to Cancil <br />Exam: <?php echo ucfirst($project_name);?> for City : <?php echo ucfirst($city_name);?></h3></label>
                      
                    </div>
					
						
					
                    <div class="col-sm-3 control-label col-sm-offset-5">
                    
                    
                       <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('cancil_exam_popup','save_btn')" value="Submit" style="width:150px; font-size:15px;">
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

