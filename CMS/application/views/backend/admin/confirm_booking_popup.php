<?php

$query = $this->db->query("SELECT * FROM tt_center_booking where 1=1 and id='".$this->db->escape_str($param2)."'");
$row = $query->row();
$city_id=$row->city_id;
$city_name=$row->city_name;
$project_id=$row->project_id;
$project_name=$row->project_name;
$client_id=$row->client_id;
$client_name=$row->client_name;
$center_id=$row->center_id;
$center_name=$row->center_name;
$vendor_id=$row->vendor_id;
$vendor_name=$row->vendor_name;
$date_of_booking_start=$row->date_of_booking_start;
$date_of_booking_end=$row->date_of_booking_end;
$number_of_day=$row->number_of_day;
$required_seat=$row->required_seat;
$proposed_cost=$row->proposed_cost;

'<br>BT'.$total_exam_batch=$row->total_exam_batch;
$batch_1=$row->batch_1;
$batch_2=$row->batch_2;
$batch_3=$row->batch_3;
$batch_4=$row->batch_4;
$batch_5=$row->batch_5;


$city_center=$row->city_name;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Confirm Booking </h3>
                </div>
            </div>

			
            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="confirm_booking_popup" id="confirm_booking_popup" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/final_booking_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $param2;?>" />
				<input type="hidden" name="city_id" id="city_id" value="<?php echo $city_id;?>" />
				<input type="hidden" name="city_name" id="city_name" value="<?php echo get_city_name($city_id);?>" />
				<input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id;?>" />
                 <input type="hidden" name="project_name" id="project_name" value="<?php echo $project_name;?>" /> 
				 <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id;?>" /> 
				 <input type="hidden" name="client_name" id="client_name" value="<?php echo $client_name;?>" /> 
				<input type="hidden" name="center_id" id="center_id" value="<?php echo $center_id;?>" />
				<input type="hidden" name="center_name" id="center_name" value="<?php echo $center_name;?>" />
				<input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo $vendor_id;?>" />
				<input type="hidden" name="vendor_name" id="vendor_name" value="<?php echo $vendor_name;?>" />
				    
					 <div class="form-group">
							<label class="col-sm-4">Project/Requirment Name:</label>
                        <div class="col-sm-8">
							 <?php echo ucfirst($project_name);?>
												
                        </div>
                    </div>
					
					<div class="form-group">
							<label class="col-sm-4">Vendor Name:</label>
                        <div class="col-sm-8">
							 <?php echo ucfirst($vendor_name);?>
												
                        </div>
                    </div>
					
					<div class="form-group">
							<label class="col-sm-4">Center Name:</label>
                        <div class="col-sm-8">
							 <?php echo ucfirst($center_name);?>
												
                        </div>
                    </div>
					<div class="form-group">
							<label class="col-sm-4">Start Date:</label>
                        <div class="col-sm-8">
						<input type="date" name="start_date" class="form-control" value="<?php echo $date_of_booking_start; ?>" >
			
                        </div>
                    </div>
					
					<div class="form-group">
							<label class="col-sm-4">End Date:</label>
                        <div class="col-sm-8">
						<input type="date" name="end_date" class="form-control" value="<?php echo $date_of_booking_end; ?>">
												
                        </div>
                    </div>
					<div class="form-group">
							<label class="col-sm-4">Required Seat:</label>
                        <div class="col-sm-6">
							 <?php echo $required_seat; ?>
												
                        </div>
                    </div>					<div class="form-group">
							<label class="col-sm-4">Final Seat Booking:</label>
                        <div class="col-sm-6">
							 <input type="text" value="" name="final_seat_count" class="form-control" id="field-2" onkeypress="return isNumberKey(event)" >
												
                        </div>
                    </div>
					
			<div class="form-group">
							<label class="col-sm-4">Final Booking Amount:</label>
                        <div class="col-sm-6">
							<input type="text" value="" name="final_amount" class="form-control" id="field-2" onkeypress="return isNumberKey(event)"  >
												
                        </div>
                    </div>
					
			
					
					<div class="form-group">
							<label class="col-sm-4">Commercial:</label>
                        <div class="col-sm-6">
									<input type="radio" name="commrcl_by_per" id="commrcl_by_per" value="Candidate" /> Per Candidate
									<input type="radio"  name="commrcl_by_per" id="commrcl_by_per" value="System" /> Per System
                        </div>
                    </div>		
				
				
				<div class="form-group">
							<label class="col-sm-4">Advance Booking Amount:</label>
                        <div class="col-sm-6">
							<input type="text" value="" name="advance_amount" class="form-control" id="field-2" onkeypress="return isNumberKey(event)"  >
												
                        </div>
                    </div>		
				
					<div class="form-group">
							<label class="col-sm-4">Number of Booking Days:</label>
                        <div class="col-sm-6">
							<input type="text" value="<?php echo $number_of_day; ?>" name="number_of_day" class="form-control" id="field-2" onkeypress="return isNumberKey(event)"  >
												
                        </div>
                    </div>		
				
                    
					<div class="form-group">
							<label class="col-sm-4">Exam Batch (Time):</label>
                        <div class="col-sm-8">
									<select name="batchTime" id="adisel" class="form-control">
										  <option value="">Select</option>
										  <option value="1" <?php if($total_exam_batch=='1'){ ?> selected="selected"<?php } ?>>1</option>
										  <option value="2"  <?php if($total_exam_batch=='2'){ ?> selected="selected"<?php } ?>>2</option>
										  <option value="3"  <?php if($total_exam_batch=='3'){ ?> selected="selected"<?php } ?>>3</option>
										  <option value="4"  <?php if($total_exam_batch=='4'){ ?> selected="selected"<?php } ?>>4</option>
										  <option value="5"  <?php if($total_exam_batch=='5'){ ?> selected="selected"<?php } ?>>5</option>
									</select>
						

</div>

<div class="form-group">
	<div class="col-sm-4" id="divexbatch1" <?php if(!$batch_1) {?> style="display: none" <?php } ?>>
	<strong>Timing 1</strong>
		<input type="text" name="batch_time_1" class="form-control" id="batch_time_1" value="<?php echo $batch_1; ?>" >
	</div>
	
<br />	<div class="col-sm-4" id="divexbatch2" <?php if(!$batch_2) {?> style="display: none" <?php } ?>>
	<strong>Timing 2</strong>
		<input type="text" name="batch_time_2" class="form-control" id="batch_time_2" value="<?php echo $batch_2; ?>" >
	</div>
<br />	
	<div class="col-sm-4" id="divexbatch3" <?php if(!$batch_3) {?> style="display: none" <?php } ?>>
	<strong>Timing 3</strong>
		<input type="text" name="batch_time_3" class="form-control" id="batch_time_3" value="<?php echo $batch_3; ?>" >
	</div>


	<div class="col-sm-3" id="divexbatch4" <?php if(!$batch_4) {?> style="display: none" <?php } ?>>
	<strong>Timing 4</strong>
		<input type="text" name="batch_time_4" class="form-control" id="batch_time_4" value="<?php echo $batch_4; ?>">
	</div>
	
	<div class="col-sm-3" id="divexbatch5" <?php if(!$batch_5) {?> style="display: none" <?php } ?>>
	<strong>Timing 5</strong>
		<input type="text" name="batch_time_5" class="form-control" id="batch_time_5" value="<?php echo $batch_5; ?>">
	</div>

						
						
						
						</div>
                    </div>		
					
					
					
<!--<input name="" type="submit" />-->
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('confirm_booking_popup','save_btn')" value="Submit">
                      
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

$(document).ready(function(){
	//keep data in d/m/y format
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy'/*,
		startDate: '-3d'*/
	})
	var activate_js = '<?php echo $activate_js;?>';
	if(activate_js == '1'){
		loadOtherDepartment();
	}	
	
});

</script>

<script type="text/javascript">
        $(function () {
            $("#adisel").change(function () {
               if ($(this).val() == "0") {
                   
                } else {
					$("#divexbatch1").hide();
                    $("#divexbatch2").hide();
					$("#divexbatch3").hide();
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
			  
			  
			    if ($(this).val() == "1") {
                    $("#divexbatch1").show();
                } else {
                    $("#divexbatch2").hide();
					$("#divexbatch3").hide();
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "2") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
                } else {
					$("#divexbatch3").hide();
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "3") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
					$("#divexbatch3").show();
                } else {
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "4") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
					$("#divexbatch3").show();
					$("#divexbatch4").show();
                } else {
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "5") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
					$("#divexbatch3").show();
					$("#divexbatch4").show();
					$("#divexbatch5").show();
                } else {
					
                }
            });
        });
</script>