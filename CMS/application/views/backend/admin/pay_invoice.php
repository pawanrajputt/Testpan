<?php

$query = $this->db->query("SELECT * FROM tt_center_booking_master where 1=1 and id='".$this->db->escape_str($param2)."'");
$row = $query->row();
$center_book_id=$row->center_book_id;
$city_id=$row->city_id;
$city_name=$row->city_name;
$project_id=$row->project_id;
$project_name=$row->project_name;
$center_id=$row->center_id;
$center_name=$row->center_name;
$vendor_id=$row->vendor_id;
$vendor_name=$row->vendor_name	;
$total_cost	=$row->total_cost;
$gst_amount=$row->gst_amount;
$total_payable_amount=$row->total_payable_amount;

?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Payment Detail </h3>
                </div>
            </div>

			
            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
                <form role="form" name="pay_invoice" id="pay_invoice" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/pay_invoice_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="id" id="id" value="<?php echo $param2;?>" />
				<input type="hidden" name="center_book_id" id="center_book_id" value="<?php echo $center_book_id;?>" />
				<input type="hidden" name="city_id" id="city_id" value="<?php echo $city_id;?>" />
				<input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id;?>" />
				    
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
							<label class="col-sm-4">City Name:</label>
                        <div class="col-sm-8">
							 <?php echo ucfirst($city_name);?>
												
                        </div>
                    </div>
					<div class="form-group">
							<label class="col-sm-4">Total Amount:</label>
                        <div class="col-sm-8">
						<img src="assets/images/rupees.png"  style="max-height:12px;"  class="img-circle"/> <?php echo $total_cost; ?>
			
                        </div>
                    </div>
					
					<div class="form-group">
							<label class="col-sm-4">GST (18%):</label>
                        <div class="col-sm-8">
						<img src="assets/images/rupees.png"  style="max-height:12px;"  class="img-circle"/> <?php echo $gst_amount; ?>
												
                        </div>
                    </div>
					
					<div class="form-group">
							<label class="col-sm-4">Total Payable Amount:</label>
                        <div class="col-sm-6">
							<img src="assets/images/rupees.png"  style="max-height:12px;"  class="img-circle"/><strong> <?php echo $total_payable_amount; ?></strong>
												
                        </div>
                    </div>
					
			<div class="form-group">
							<label class="col-sm-4">Payment Detail:</label>
                        <div class="col-sm-6">
						<textarea name="payment_detail" id="payment_detail"  class="form-control"></textarea>
												
                        </div>
                    </div>

                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('pay_invoice','save_btn')" value="Submit">
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

