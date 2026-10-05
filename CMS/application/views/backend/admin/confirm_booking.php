<?php

$id=$ct_details->id;
$city_id=$ct_details->city_id;
$city_name=$ct_details->city_name;
$project_id=$ct_details->project_id;
$project_name=$ct_details->project_name;
$client_id=$ct_details->client_id;
$client_name=$ct_details->client_name;
$center_id=$ct_details->center_id;
$center_name=$ct_details->center_name;
$vendor_id=$ct_details->vendor_id;
$vendor_name=$ct_details->vendor_name;
$date_of_booking_start=$ct_details->date_of_booking_start;
$date_of_booking_end=$ct_details->date_of_booking_end;
$number_of_day=$ct_details->number_of_day;
$required_seat=$ct_details->required_seat;
$proposed_cost=$ct_details->proposed_cost;

$total_exam_batch=$ct_details->total_exam_batch;
$batch_1=$ct_details->batch_1;
$batch_2=$ct_details->batch_2;
$batch_3=$ct_details->batch_3;
$batch_4=$ct_details->batch_4;
$batch_5=$ct_details->batch_5;

$number_of_batch=$ct_details->number_of_batch;


$city_center=$ct_details->city_name;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            

			
            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="confirm_booking_popup" id="confirm_booking_popup" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/final_booking_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
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
                <input type="hidden" name="proposed_cost" id="proposed_cost" value="<?php echo $proposed_cost;?>" />
                
				   
           <div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Examination Detail</strong></span>
	
</div>        
                    
					 <div class="form-group">
							<label class="col-sm-3" style="font-size:14px"><strong>Project/Requirment Name:</strong></label>
                        <div class="col-sm-3" style="font-size:24px"><strong>
							 <?php echo ucfirst($project_name);?>, <?php echo $city_center; ?>
								</strong>				
                        </div>
                    </div>
            
					<div class="form-group" >
							<label class="col-sm-3" style="font-size:14px"><strong>Vendor Name:</strong></label>
                        <div class="col-sm-3" style="font-size:14px"><strong>
							 <?php echo ucfirst($vendor_name);?></strong>
												
                        </div>
                   
							<label class="col-sm-3" style="font-size:14px"><strong>Center Name:</strong></label>
                        <div class="col-sm-3" style="font-size:14px"><strong>
							 <?php echo ucfirst($center_name);?></strong>
												
                        </div>
                    </div>
                    
        <div class="form-group" style="background-color:#009999">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Booking Detail</strong></span>
	
</div>                      
					
					
                  <div class="form-group">
                    <div class="col-sm-5"><strong>
                    Start Date:  <em style="color:#C00;">*</em></strong>
                        <input type="date" name="start_date" class="form-control"  value="<?php echo $date_of_booking_start; ?>" >
                    </div>
                    
                    <div class="col-sm-5"><strong>
                   End Date: <em style="color:#C00;">*</em></strong>
                        <input type="date" name="end_date" class="form-control" value="<?php echo $date_of_booking_end; ?>">
                    </div>
                    
                </div>  
                    
                  <div class="form-group">
                    <div class="col-sm-5"><strong>
                    Required Seat:  <em style="color:#C00;">*</em></strong><br />
                      <span style="font-size:24px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $required_seat; ?></span>
                    </div>
                    
                    <div class="col-sm-5"><strong>
                   Final Seat Booking: <em style="color:#C00;">*</em></strong>
                       <input type="text" value="" name="final_seat_count" class="form-control" id="field-2" onkeypress="return isNumberKey(event)" >
                    </div>
                    
                </div>    
                    
                  <div class="form-group">
                    <div class="col-sm-5"><strong>
                   Final Booking Amount:  <em style="color:#C00;">*</em></strong>
                      <input type="text" value="" name="final_amount" class="form-control" id="field-2" onkeypress="return isNumberKey(event)"  >
                    </div>
                    
                    <div class="col-sm-5"><strong>
                   Commercial: <em style="color:#C00;">*</em></strong><br />
                     <div class="col-sm-8">
									<input type="radio" name="commrcl_by_per" id="commrcl_by_per" value="Candidate" /> Per Candidate
									<input type="radio"  name="commrcl_by_per" id="commrcl_by_per" value="System" /> Per System
                        </div>
                    </div>
                    
                </div>      
					
			
            
             <div class="form-group">
                    <div class="col-sm-3"><strong>
                   Advance Booking Amount:  <em style="color:#C00;">*</em></strong>
                        <input type="text" value="" name="advance_amount" class="form-control" id="field-2" onkeypress="return isNumberKey(event)"  >
                    </div>
                    
                    <div class="col-sm-3"><strong>
                   Number of Booking Days: <em style="color:#C00;">*</em></strong>
                        <input type="text" value="<?php echo $number_of_day; ?>" name="number_of_day" class="form-control" id="field-2" onkeypress="return isNumberKey(event)"  >
                    </div>
                    
                    <div class="col-sm-3"><strong>
                  Extra Amount (if any):  </strong>
                        <input type="text" value="" name="extra_amount" class="form-control" id="field-2" onkeypress="return isNumberKey(event)"  >
                    </div>
                    
                </div>  
            
  			 <div class="form-group">
                    <div class="col-sm-2"><strong>
                   Exam Batch (Time):<em style="color:#C00;">*</em></strong>
                       <select name="batchTime" id="adisel" class="form-control">
										  <option value="">Select</option>
										  <option value="1" <?php if($total_exam_batch=='1'){ ?> selected="selected"<?php } ?>>1</option>
										  <option value="2"  <?php if($total_exam_batch=='2'){ ?> selected="selected"<?php } ?>>2</option>
										  <option value="3"  <?php if($total_exam_batch=='3'){ ?> selected="selected"<?php } ?>>3</option>
										  <option value="4"  <?php if($total_exam_batch=='4'){ ?> selected="selected"<?php } ?>>4</option>
										  <option value="5"  <?php if($total_exam_batch=='5'){ ?> selected="selected"<?php } ?>>5</option>
									</select>
                    </div>
               

	<div class="col-sm-2" id="divexbatch1" <?php if(!$batch_1) {?> style="display: none" <?php } ?>>
	<strong>Timing 1</strong>
		<input type="text" name="batch_time_1" class="form-control" id="batch_time_1" value="<?php echo $batch_1; ?>" >
	</div>
	
	<div class="col-sm-2" id="divexbatch2" <?php if(!$batch_2) {?> style="display: none" <?php } ?>>
	<strong>Timing 2</strong>
		<input type="text" name="batch_time_2" class="form-control" id="batch_time_2" value="<?php echo $batch_2; ?>" >
	</div>
	
	<div class="col-sm-2" id="divexbatch3" <?php if(!$batch_3) {?> style="display: none" <?php } ?>>
	<strong>Timing 3</strong>
		<input type="text" name="batch_time_3" class="form-control" id="batch_time_3" value="<?php echo $batch_3; ?>" >
	</div>


	<div class="col-sm-2" id="divexbatch4" <?php if(!$batch_4) {?> style="display: none" <?php } ?>>
	<strong>Timing 4</strong>
		<input type="text" name="batch_time_4" class="form-control" id="batch_time_4" value="<?php echo $batch_4; ?>">
	</div>
	
	<div class="col-sm-2" id="divexbatch5" <?php if(!$batch_5) {?> style="display: none" <?php } ?>>
	<strong>Timing 5</strong>
		<input type="text" name="batch_time_5" class="form-control" id="batch_time_5" value="<?php echo $batch_5; ?>">
	</div>

						
						
						
		</div>
        
        
       <div class="form-group">
                    <div class="col-sm-2"><strong>
                   No of Batch :<em style="color:#C00;">*</em></strong>
                       <select name="batchcount" id="batsel" class="form-control">
										  <option value="">Select</option>
										  <option value="1" <?php if($number_of_batch=='1'){ ?> selected="selected"<?php } ?>>1</option>
										  <option value="2" <?php if($number_of_batch=='2'){ ?> selected="selected"<?php } ?>>2</option>
										  <option value="3" <?php if($number_of_batch=='3'){ ?> selected="selected"<?php } ?>>3</option>
										  <option value="4" <?php if($number_of_batch=='4'){ ?> selected="selected"<?php } ?>>4</option>
										  <option value="5" <?php if($number_of_batch=='5'){ ?> selected="selected"<?php } ?>>5</option>
									</select>
                    </div>
               

	<div class="col-sm-2" id="divbatchc1" <?php if(!$batch_1) {?> style="display: none" <?php } ?> >
	<strong>Batch 1</strong>
		<input type="text" name="batch_count_1" class="form-control" id="batch_count_1" value="" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-2" id="divbatchc2" <?php if(!$batch_2) {?> style="display: none" <?php } ?> >
	<strong>Batch 2</strong>
		<input type="text" name="batch_count_2" class="form-control" id="batch_count_2" value="" onkeypress="return isNumberKey(event)" >
	</div>
	
	<div class="col-sm-2" id="divbatchc3" <?php if(!$batch_3) {?> style="display: none" <?php } ?>  >
	<strong>Batch 3</strong>
		<input type="text" name="batch_count_3" class="form-control" id="batch_count_3" value="" onkeypress="return isNumberKey(event)" >
	</div>


	<div class="col-sm-2" id="divbatchc4" <?php if(!$batch_4) {?> style="display: none" <?php } ?> >
	<strong>Batch 4</strong>
		<input type="text" name="batch_count_4" class="form-control" id="batch_count_4" value="" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-2" id="divbatchc5" <?php if(!$batch_5) {?> style="display: none" <?php } ?> >
	<strong>Batch 5</strong>
		<input type="text" name="batch_count_5" class="form-control" id="batch_count_5" value="" onkeypress="return isNumberKey(event)">
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

<script type="text/javascript">
        $(function () {
            $("#batsel").change(function () {
               if ($(this).val() == "0") {
                   
                } else {
					$("#divbatchc1").hide();
                    $("#divbatchc2").hide();
					$("#divbatchc3").hide();
					$("#divbatchc4").hide();
					$("#divbatchc5").hide();
                }
			  
			  
			    if ($(this).val() == "1") {
                    $("#divbatchc1").show();
                } else {
                    $("#divbatchc2").hide();
					$("#divbatchc3").hide();
					$("#divbatchc4").hide();
					$("#divbatchc5").hide();
                }
				if ($(this).val() == "2") {
                    $("#divbatchc1").show();
					$("#divbatchc2").show();
                } else {
					$("#divbatchc3").hide();
					$("#divbatchc4").hide();
					$("#divbatchc5").hide();
                }
				if ($(this).val() == "3") {
                    $("#divbatchc1").show();
					$("#divbatchc2").show();
					$("#divbatchc3").show();
                } else {
					$("#divbatchc4").hide();
					$("#divbatchc5").hide();
                }
				if ($(this).val() == "4") {
                    $("#divbatchc1").show();
					$("#divbatchc2").show();
					$("#divbatchc3").show();
					$("#divbatchc4").show();
                } else {
					$("#divbatchc5").hide();
                }
				if ($(this).val() == "5") {
                    $("#divbatchc1").show();
					$("#divbatchc2").show();
					$("#divbatchc3").show();
					$("#divbatchc4").show();
					$("#divbatchc5").show();
                } else {
					
                }
            });
        });
</script>