<?php
	$pageUrl=$_SERVER['REQUEST_URI']; 
	$newUrl=parse_url($pageUrl);
	$aurl=$newUrl[query];
	$hlink=explode('/',$aurl);
	$projId=base64_decode($hlink[2]);
	 '<br>Project='.$pf = $_REQUEST['pf'];
	 '<br>CenterId='.$cct = $_REQUEST['cct'];
	 '<br>City='.$ct = $_REQUEST['ct'];	
	
	////total seat of center
	
	$lab_qry = $this->db->query("SELECT SUM(no_of_computer) as totalsystem FROM tt_lab where center_id='".$cct."' and deleted=0")->row();	   
	 '<br>s='.$reqired_system = $lab_qry->totalsystem;
	
	$center_qry = $this->db->query("SELECT center_name, vendor_id FROM tt_center WHERE 1=1 AND id='".$cct."'")->row();
	$center_name=$center_qry->center_name;
	$vendor_id=$center_qry->vendor_id;
	
	
	
	
	/*date_default_timezone_set('UTC');
			
			$start_date = '2015-01-01';
			$end_date = '2015-01-05';
			
			while (strtotime($start_date) <= strtotime($end_date)) {
				echo '<br>A='.$a="wwww";
				$start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
			}*/
	
	
	
	$project_query = $this->db->query("SELECT * FROM tt_project_detail WHERE 1=1 AND project_id='".$pf."' and exam_city_id='".$ct."'")->row();
	//echo '<br>QRY='.$ct = "SELECT * FROM tt_project_detail WHERE 1=1 AND project_id='".$pf."' and exam_city_id='".$ct."'";
	 '<br>A1='.$start_dates= $project_query->start_date;
	 '<br>A1='.$start_date=date ("Y-m-d", strtotime("-1 days", strtotime($start_dates)));
	 '<br>A2='.$end_date= $project_query->end_date;
	 '<br>A2='.$projectName= $project_query->exam_name;
	 '<br>A2='.$cityName= $project_query->exam_city_name;
	 '<br>A2='.$centerName= $project_query->exam_name;
	 '<br>A2='.$VendorName= $project_query->exam_name;
	 '<br>A2='.$client_name= $project_query->client_name;
	 '<br>A2='.$client_id= $project_query->client_id;
	'<br>A2='.$state_id=  $this->common_options->get_state_id($project_query->exam_city_id);
	/*echo '<br>A3='.$total_examDay= $project_query->exam_req_days;
	echo '<br>A4='.$total_req_seat= $project_query->exam_required_seat;
	echo '<br>A5='.strtotime($exam_start_date);
	echo '<br>A6='.strtotime($exam_end_date);*/
	//exit;
?>

<style>
.blinking{
    animation:blinkingText 1.0s infinite;
}
@keyframes blinkingText{
    0%{     color: #000;    }
    49%{    color: transparent; }
    50%{    color: transparent; }
    99%{    color:transparent;  }
    100%{   color: #000;    }
}
</style>
<div style="clear:both;"></div>
<br>

       <form role="form" name="center_booking" id="center_booking" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/center_booking_process" method="post" enctype="multipart/form-data">

	
<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
<input type="hidden" name="project_id" id="project_id" value="<?php echo $pf; ?>" />
<input type="hidden" name="projectName" id="projectName" value="<?php echo $projectName; ?>" />
<input type="hidden" name="center_id" id="center_id" value="<?php echo $cct; ?>" />
<input type="hidden" name="city_id" id="city_id" value="<?php echo $ct; ?>" />
<input type="hidden" name="state_id" id="state_id" value="<?php echo $state_id; ?>" />
<input type="hidden" name="center_name" id="center_name" value="<?php echo $center_name; ?>" />
<input type="hidden" name="center_id" id="center_id" value="<?php echo $cct; ?>" />

<input type="hidden" name="client_name" id="client_name" value="<?php echo $client_name; ?>" />	
<input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>" />	
<input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo $vendor_id; ?>" />	
<input type="hidden" name="vendor_name" id="vendor_name" value="<?php echo $this->common_options->get_vendorname($center_qry->vendor_id); ?>" />	



				
<table cellpadding="0" class="table" style="vertical-align:middle; width:80%; background-color:#3399ff" align="center">
<tr>
  <td width="15%" valign="middle" style="color:#fff"><strong>PROJECT NAME :</td>
  <td width="50%" valign="middle" style="color:#fff"><strong><?php echo strtoupper($projectName); ?></strong></td>
  <td width="15%" valign="middle" style="color:#fff"><strong>CITY NAME:</td>
  <td width="20%" valign="middle" style="color:#fff"><strong><?php echo strtoupper(get_city_name($ct)); ?></strong></td>
</tr>
<tr>
  <td valign="middle" style="color:#fff"><strong>CENTER NAME :</strong></td>
  <td valign="middle" style="color:#fff"><strong><?php echo strtoupper($center_name); ?></strong></td>
  <td valign="middle" style="color:#fff">&nbsp;</td>
  <td valign="middle" style="color:#fff">&nbsp;</td>
</tr>
<?php /*?><tr>
  <td valign="middle" style="color:#FFF">VENDOR NAME</td>
  <td valign="middle" style="color:#FFF"><?php echo ucwords($this->common_options->get_vendorname($center_qry->vendor_id));?></td>
  <td valign="middle" style="color:#FFF">&nbsp;</td>
  <td valign="middle" style="color:#FFF">&nbsp;</td>
</tr><?php */?>
</table>
				
			

<table width="100%" class="table table-striped datatable" id="table-2">


<thead>
        <tr>
          <th width="10%" nowrap="nowrap" style="background-color:#3399ff; color:#FFF; text-align:center"><strong>Exam Date</strong></th>
            <th width="15%" style="background-color:#3399ff; color:#FFF; text-align:center"><strong>Available</strong></th>
		  <th width="5%" style="background-color:#3399ff; color:#FFF;"><strong>Batch 1</strong></th>
		  <th width="5%" style="background-color:#3399ff; color:#FFF;"><strong>Batch 2</strong></th>
		  <th width="5%" style="background-color:#3399ff; color:#FFF;"><strong>Batch 3</strong></th>
          <th width="5%" style="background-color:#3399ff; color:#FFF;"><strong>Batch 4</strong></th>
          <th width="5%" style="background-color:#3399ff; color:#FFF;"><strong>Batch 5</strong></th>
            
			<th width="15%" align="center" style="background-color:#3399ff; color:#FFF;"><strong>Payment CS</strong></th>
			<th width="5%" align="center" style="background-color:#3399ff; color:#FFF;"><strong>Cost (CS)</strong></th>
			<th width="5%" align="center" style="background-color:#3399ff; color:#FFF;"><strong>Extra</strong></th>
			   
			<th width="15%" align="center" style="background-color:#3399ff; color:#FFF;"><strong>Payment TP</strong></th>
			<th width="5%" align="center" style="background-color:#3399ff; color:#FFF;"><strong>Cost (TP)</strong></th>
			<th width="5%" align="center" style="background-color:#3399ff; color:#FFF;"><strong>Extra</strong></th>
          
      </tr>
    </thead>

    <tbody>
	
<?php 
	$counter = 0;
	
	while (strtotime($start_date) <= strtotime($end_date)-1) {
		
		$exam_start_date_us = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
		
		$seat_query = $this->db->query("SELECT id,total_seat FROM tt_exam_booking_detail WHERE 1=1 AND center_id='".$cct."' and  city_id='".$ct."' and exam_date='".$exam_start_date_us."' and deleted=0")->row();
		
	//	echo '<br>QRY='.$ss = "SELECT id,total_seat FROM tt_exam_booking_detail WHERE 1=1 AND center_id='".$cct."' and  city_id='".$ct."' and exam_date='".$exam_start_date_us."' and deleted=0";
		$bookedSeat= $seat_query->total_seat;
		$availableSeat=$reqired_system-$bookedSeat;
		
 ?>		
            <tr>
               

                <td nowrap="nowrap" style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><strong><?php echo $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date))); ?></strong>
                <input type="hidden" name="examdate[]" id="examdate" value="<?php echo  $exam_start_date_us; ?>" />
                
                
                </td>
                <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center; font-size:14px"><strong><?php if($availableSeat>=0){ echo  $availableSeat; } else { echo $availableSeat=0;} ?></strong> </td>
                
               
                
				
                  
				    <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">
                    <input type="text" name="batch1[]"  class="form-control" style="width:55px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?> ></td>
                    
					  <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">
                      <input type="text" name="batch2[]"  class="form-control" style="width:55px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?> ></td>   
					  <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">
                      <input type="text" name="batch3[]"  class="form-control" style="width:55px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?> ></td>   
                       <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">
                       <input type="text" name="batch4[]"  class="form-control" style="width:55px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?> ></td>   
                        <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">
                        <input type="text" name="batch5[]"  class="form-control" style="width:55px" id="field-8" maxlength="4" onkeypress="return isNumberKey(event)" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?> ></td>
                          <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">  
                      <select class="form-control" name="cm_rate_mode[]" style="width:100px" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?>>
                            <option value=""> Select </option>
                            <option value="1">Candidate</option>
                            <option value="2">System</option>
                            <option value="4">LumpSum</option>
                        </select></td>
                         <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><input type="text" name="cm_cost[]"  class="form-control" style="width:60px" id="field-" maxlength="7" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?> /></td>
                         <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><input type="text" name="cm_extra[]"  class="form-control" style="width:62px" id="field-" maxlength="7" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?> /></td>
						 <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">  
                      <select class="form-control" name="tp_rate_mode[]" style="width:100px" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?>>
                            <option value=""> Select </option>
                            <option value="1">Candidate</option>
                            <option value="2">System</option>
                            <option value="4">LumpSum</option>
                        </select></td>
                        <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><input type="text" name="tp_cost[]"  class="form-control" style="width:60px" id="field-" maxlength="7" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?> /></td>
                        <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><input type="text" name="tp_extra[]"  class="form-control" style="width:62px" id="field-" maxlength="7" <?php if($availableSeat==0){ ?> disabled="disabled" <?php } ?> /></td>
                     <!--   <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><input type="text" name="field-"  class="form-control" style="width:60px" id="field-" maxlength="4" onkeypress="return isNumberKey(event)" /></td>
                        <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">&nbsp;</td>-->
            </tr>	
       
		
	<?php } ?>	
		
       
    </tbody>
    
</table>
<div class="col-sm-5 control-label col-sm-offset-2">
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('center_booking','save_btn')" value="Submit" style="width:150px; font-size:15px;">
         </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
	
</form>
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
