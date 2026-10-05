<?php

$query = $this->db->query("SELECT * FROM tt_center_booking where 1=1 and id='".$this->db->escape_str($param2)."'");
$row = $query->row();
$city_id=$row->city_id;
$city_name=$row->city_name;
$project_id=$row->project_id;
$project_name=$row->project_name;
$center_id=$row->center_id;
$center_name=$row->center_name;
$vendor_id=$row->vendor_id;
$vendor_name=$row->vendor_name;
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
                <form role="form" name="cancil_booking_popup" id="cancil_booking_popup" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/cancil_booking_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $param2;?>" />
				
				    
					 <div class="form-group">
							<label class="col-sm-12"><h3 align="center">Are you sure to Cancil <br />Booking Project/Requirement: <?php echo ucfirst($project_name);?></h3></label>
                      
                    </div>
					
						
					
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('cancil_booking_popup','save_btn')" value="Submit">
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