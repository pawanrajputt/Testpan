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
//$total_batch=$prj_qry_dtl->total_batch;



$book_seat=$prj_qry_dtl->req_book_seat;

$total_batch=$prj_qry_dtl->req_total_batch;
$batch1=$prj_qry_dtl->req_batch1;
$batch2=$prj_qry_dtl->req_batch2;
$batch3=$prj_qry_dtl->req_batch3;
$batch4=$prj_qry_dtl->req_batch4;
$batch5=$prj_qry_dtl->req_batch5;
$allbatch=array($batch1, $batch2, $batch3, $batch4, $batch5);
$max_seat_value = max($allbatch);
//get rateslab:

$req_tp_pay_option=$prj_qry_dtl->req_tp_pay_option;
if($req_tp_pay_option==1){
$req_tp_cost1=$prj_qry_dtl->req_tp_cost;
$req_tp_cost2='';
$req_tp_cost4='';
}
if($req_tp_pay_option==2){
$req_tp_cost1='';
$req_tp_cost2=$prj_qry_dtl->req_tp_cost;
$req_tp_cost4='';
}
if($req_tp_pay_option==4){
$req_tp_cost1='';
$req_tp_cost2='';
$req_tp_cost4=$prj_qry_dtl->req_tp_cost;
}
$req_tp_extra_cost=$prj_qry_dtl->req_tp_extra_cost;

$req_cm_pay_option=$prj_qry_dtl->req_cm_pay_option;
if($req_cm_pay_option==1){
$req_cm_cost1=$prj_qry_dtl->req_cm_cost;
$req_cm_cost2='';
$req_cm_cost3='';
}
if($req_cm_pay_option==2){
$req_cm_cost1='';
$req_cm_cost2=$prj_qry_dtl->req_cm_cost;
$req_cm_cost3='';
}
if($req_cm_pay_option==4){
$req_cm_cost1='';
$req_cm_cost2='';
$req_cm_cost4=$prj_qry_dtl->req_cm_cost;
}
$req_cm_extra_cost=$prj_qry_dtl->req_cm_extra_cost	;


$lab_qry = $this->db->query("SELECT SUM(no_of_computer) as totalsystem FROM tt_lab where center_id='".$center_id."' and deleted=0")->row();	   
$avlbsystem = $lab_qry->totalsystem;


$seat_query = $this->db->query("SELECT id,req_book_seat FROM tt_exam_booking_detail WHERE 1=1 AND center_id='".$center_id."' and  city_id='".$city_id."' and exam_date='".$exam_date."' and project_id!='".$project_id."' and deleted=0")->row();
		
	//	echo '<br>QRY='.$ss = "SELECT id,book_seat FROM tt_exam_booking_detail WHERE 1=1 AND center_id='".$center_id."' and  city_id='".$city_id."' and exam_date='".$exam_date."' and project_id!='".$project_id."' and deleted=0";
		$bookedSeat= $seat_query->book_seat;
		$availableSeat=$avlbsystem-$bookedSeat;






?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            

			
            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="booking_confirm_popup" id="booking_confirm_popup" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/booking_confirm_popup_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $param2;?>" />
                <input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id;?>" />
                 <input type="hidden" name="max_seat_value" id="max_seat_value" value="<?php echo $max_seat_value;?>" />
                 <input type="hidden" name="avialable_seat" id="avialable_seat" value="<?php echo $availableSeat;?>" />
                
                
           <div class="form-group" style="background-color:#2C97B3">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp; Project: <?php echo ucfirst($project_name);?> ,  Center:  <?php echo ucfirst($center_name);?>, City:  <?php echo ucfirst(get_city_name($city_id));?></strong></span>
	
</div>        
                    <div class="form-group">
							<label class="col-sm-2"><strong>Exam Date:</strong></label>
                        <div class="col-sm-2" style=" font-size:16px"><strong>
							 <?php echo $exam_date; ?></strong>
												
                        </div>
                 		 <label class="col-sm-2"><strong>Total Booking:</strong></label>
                        <div class="col-sm-2" style=" font-size:16px"><strong>
							 <?php echo $book_seat; ?></strong>
												
                        </div>
                        
                         <label class="col-sm-2"><strong>Available Seat:</strong></label>
                        <div class="col-sm-2" style=" font-size:16px"><strong>
							 <?php echo $availableSeat; ?></strong>
												
                        </div>
                    </div>
                    
<div class="form-group">
	<div class="col-sm-2" id="divbatchc1">
	<strong>Batch 1</strong>
		<input type="text" name="batch1" class="form-control" id="batch1" value="<?php echo $batch1; ?>"  onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-2" id="divbatchc2">
	<strong>Batch 2</strong>
		<input type="text" name="batch2" class="form-control" id="batch2" value="<?php echo $batch2; ?>" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-2" id="divbatchc3">
	<strong>Batch 3</strong>
		<input type="text" name="batch3" class="form-control" id="batch3" value="<?php echo $batch3; ?>" onkeypress="return isNumberKey(event)" >
	</div>


	<div class="col-sm-2" id="divbatchc4">
	<strong>Batch 4</strong>
		<input type="text" name="batch4" class="form-control" id="batch4" value="<?php echo $batch4; ?>" onkeypress="return isNumberKey(event)">
	</div>
	
	<div class="col-sm-2" id="divbatchc5">
	<strong>Batch 5</strong>
		<input type="text" name="batch5" class="form-control" id="batch5" value="<?php echo $batch5; ?>" onkeypress="return isNumberKey(event)">
	</div>
    
    
    <div class="col-sm-2" id="divbatchc5">
	<strong>Total</strong>
		<input type="text" name="sum" class="form-control" id="sum" value="<?php echo $book_seat; ?>"  readonly style="background:#FFF; font-size:16px">
	</div>
                        
</div>
        
              
 					
 <div class="form-group" style="background-color:#2C97B3">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp; Center Cost</strong></span>
</div>    
        
        
        <div class="form-group">
                    <div class="col-sm-3"><strong>
                   Payment Booking Mode :<em style="color:#C00;">*</em></strong>
                       <select name="cm_paymode" id="cm_paymode" class="form-control" style="width:150px">
										  <option value="">Select</option>
										  <option value="1" <?php if($req_cm_pay_option=='1'){ ?> selected="selected"<?php } ?>>Per Candidate</option>
										  <option value="2" <?php if($req_cm_pay_option=='2'){ ?> selected="selected"<?php } ?>>Per System</option>
                                          <option value="4" <?php if($req_cm_pay_option=='4'){ ?> selected="selected"<?php } ?>>Lump Sum</option>
									</select>
                    </div>
                    
                    <div class="col-sm-3" id="cm_payopt1" <?php if($req_cm_pay_option!=1){?>   style="display: none" <?php } ?> >
                    <strong>Per Candidate Amount:</strong>
                        <input type="text" name="cm_candidate_amount" class="form-control" id="cm_candidate_amount" value="<?php echo $req_cm_cost1; ?>" >
                    </div>
                    
                    <div class="col-sm-3" id="cm_payopt2" <?php if($req_cm_pay_option!=2){?>   style="display: none" <?php } ?> >
                    <strong>Per System Amount</strong>
                        <input type="text" name="cm_system_amount" class="form-control" id="cm_system_amount" value="<?php echo $req_cm_cost2; ?>" >
                    </div>
                    
                    
                    <div class="col-sm-3" id="cm_payopt4" <?php if($req_cm_pay_option!=4){?>   style="display: none" <?php } ?> >
                    <strong>LumpSum Amount</strong>
                        <input type="text" name="cm_lumpsum_amount" class="form-control" id="cm_lumpsum_amount" value="<?php echo $req_cm_cost4; ?>" >
                    </div>
                    
                    <div class="col-sm-3">
                    <strong>Extra Amount</strong>
                        <input type="text" name="cm_extra_amount" class="form-control" id="cm_extra_amount" value="<?php echo $req_cm_extra_cost; ?>" >
                    </div>
                    
          </div>   
                      
  <div class="form-group" style="background-color:#2C97B3">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp; Testpan Cost</strong></span>
</div>    
        
        
        <div class="form-group">
                    <div class="col-sm-3"><strong>
                   Payment Booking Mode :<em style="color:#C00;">*</em></strong>
                       <select name="tp_paymode" id="tp_paymode" class="form-control" style="width:150px">
										  <option value="">Select</option>
										  <option value="1" <?php if($req_tp_pay_option=='1'){ ?> selected="selected"<?php } ?>>Per Candidate</option>
										  <option value="2" <?php if($req_tp_pay_option=='2'){ ?> selected="selected"<?php } ?>>Per System</option>
                                          <option value="4" <?php if($req_tp_pay_option=='4'){ ?> selected="selected"<?php } ?>>LumpSum</option>
									</select>
                    </div>
                    
                    <div class="col-sm-3" id="payopt1" <?php if($req_tp_pay_option!=1){?>   style="display: none" <?php } ?> >
                    <strong>Per Candidate Amount:</strong>
                        <input type="text" name="tp_candidate_amount" class="form-control" id="candidate_amount" value="<?php echo $req_tp_cost1; ?>" >
                    </div>
                    
                    <div class="col-sm-3" id="payopt2"  <?php if($req_tp_pay_option!=2){?>   style="display: none" <?php } ?> >
                    <strong>Per System Amount</strong>
                        <input type="text" name="tp_system_amount" class="form-control" id="system_amount" value="<?php echo $req_tp_cost2; ?>" >
                    </div>
                    
                    
                    <div class="col-sm-3" id="payopt4"  <?php if($req_tp_pay_option!=4){?>   style="display: none" <?php } ?>>
                    <strong>LumpSum Amount</strong>
                        <input type="text" name="tp_lumpsum_amount" class="form-control" id="tp_lumpsum_amount" value="<?php echo $req_tp_cost4; ?>" >
                    </div>
                    
                    <div class="col-sm-3">
                    <strong>Extra Amount</strong>
                        <input type="text" name="tp_extra_amount" class="form-control" id="tp_extra_amount" value="<?php echo $req_tp_extra_cost; ?>" >
                    </div>
                    
                    
          </div> 
               	      
                        
                       
                        
    	 <div class="form-group" style="background-color: #2C97B3" align="right">
							<label class="col-sm-5" style="color:#FFF"><strong>Are you Sure to Confirm Booking</strong></label>
                        <div class="col-sm-3" style="color:#FFF" align="left"><strong>
                        <input type="radio" name="status" id="status" value="1" /> YES &nbsp;&nbsp;&nbsp;
                        <input type="radio" name="status" id="status" value="2" /> NO
								</strong>				
                        </div>
                    </div>
			
					
			
                    <div class="col-sm-3 control-label col-sm-offset-4">
                        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('booking_confirm_popup','save_btn')" value="Submit" style="width:150px; font-size:15px;">
                      
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


 <script type="text/javascript">
        $(function () {
            $("#tp_paymode").change(function () {
               if ($(this).val() == "0") {
                   
                } else {
					$("#payopt1").hide();
                    $("#payopt2").hide();
					$("#payopt3").hide();
					$("#payopt4").hide();
                }
			    if ($(this).val() == "1") {
                    $("#payopt1").show();
                } 
				else {
					$("#slab_one").hide();
					$("#slab_two").hide();
					$("#slab_three").hide();
					$("#slab_four").hide();
                }
				if ($(this).val() == "2") {
					$("#payopt2").show();
                } 
				else {
					$("#slab_one").hide();
					$("#slab_two").hide();
					$("#slab_three").hide();
					$("#slab_four").hide();
                }
				 if ($(this).val() == "4") {
                    $("#payopt4").show();
                } 
				else {
					$("#slab_one").hide();
					$("#slab_two").hide();
					$("#slab_three").hide();
					$("#slab_four").hide();
                }
				if ($(this).val() == "3") {
					$("#payopt3").show();
                } 
				 else {
                }
            });
        });
</script>

 <script type="text/javascript">
        $(function () {
            $("#cm_paymode").change(function () {
               if ($(this).val() == "0") {
                   
                } else {
					$("#cm_payopt1").hide();
                    $("#cm_payopt2").hide();
					$("#cm_payopt3").hide();
					$("#cm_payopt4").hide();
                }
			    if ($(this).val() == "1") {
                    $("#cm_payopt1").show();
                } 
				else {
					$("#cm_slab_one").hide();
					$("#cm_slab_two").hide();
					$("#cm_slab_three").hide();
					$("#cm_slab_four").hide();
                }
				if ($(this).val() == "2") {
					$("#cm_payopt2").show();
                } 
				else {
					$("#cm_slab_one").hide();
					$("#cm_slab_two").hide();
					$("#cm_slab_three").hide();
					$("#cm_slab_four").hide();
                }
				if ($(this).val() == "4") {
					$("#cm_payopt4").show();
                } 
				else {
					$("#cm_slab_one").hide();
					$("#cm_slab_two").hide();
					$("#cm_slab_three").hide();
					$("#cm_slab_four").hide();
                }
				if ($(this).val() == "3") {
					$("#cm_payopt3").show();
                } 
				 else {
                }
            });
        });
</script>                   
          
<script>
$(function(){
            $('#batch1, #batch2, #batch3, #batch4, #batch5').keyup(function(){
               var value1 = parseFloat($('#batch1').val()) || 0;
               var value2 = parseFloat($('#batch2').val()) || 0;
			   var value3 = parseFloat($('#batch3').val()) || 0;
			   var value4 = parseFloat($('#batch4').val()) || 0;
			   var value5 = parseFloat($('#batch5').val()) || 0;
               $('#sum').val(value1 + value2 + value3 + value4 + value5);
            });
         });
		 
		 
$('#batch1').keyup(function(){
  if ($(this).val() > <?php echo $availableSeat; ?>){
    alert("Booking not Allow above avalable seat <?php echo $availableSeat; ?>");
    $(this).val('<?php echo $availableSeat; ?>');
  }
});		 
$('#batch2').keyup(function(){
  if ($(this).val() > <?php echo $availableSeat; ?>){
    alert("Booking not Allow above avalable seat <?php echo $availableSeat; ?>");
    $(this).val('<?php echo $availableSeat; ?>');
  }
});		 		 
$('#batch3').keyup(function(){
  if ($(this).val() > <?php echo $availableSeat; ?>){
    alert("Booking not Allow above avalable seat <?php echo $availableSeat; ?>");
    $(this).val('<?php echo $availableSeat; ?>');
  }
});		 
$('#batch4').keyup(function(){
  if ($(this).val() > <?php echo $availableSeat; ?>){
    alert("Booking not Allow above avalable seat <?php echo $availableSeat; ?>");
    $(this).val('<?php echo $availableSeat; ?>');
  }
});		 
$('#batch5').keyup(function(){
  if ($(this).val() > <?php echo $availableSeat; ?>){
    alert("Booking not Allow above avalable seat <?php echo $availableSeat; ?>");
    $(this).val('<?php echo $availableSeat; ?>');
  }
});		 		 
		 
</script>               