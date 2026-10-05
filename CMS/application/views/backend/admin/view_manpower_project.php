<?php
$query = $this->db->query("SELECT * FROM tt_manpower_project where 1=1 and id='".$this->db->escape_str($param2)."'");
$row = $query->row();

?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading" align="center">
                <div class="panel-title" align="center">
                    <h3 align="center">Manpower Project Information Details</h3>
                </div>
            </div>

            <div class="panel-body" style="font-size:14px; color:#454545;">
            
			
                   <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Exam Name: </label><label for="field-ta" class="col-sm-9 control-label"><?php echo strtoupper($row->exam_name);?>&nbsp; </label>
                    </div>
                   <div style="clear:both;"></div> 
                  <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Client Name: </label><label for="field-ta" class="col-sm-9 control-label"><?php echo ucwords($this->common_options->get_client_name($row->client_id)); ?>&nbsp;</label>
                    </div>   
                   <div style="clear:both;"></div> 
				    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Exam Start Date: </label><label for="field-ta" class="col-sm-9 control-label"><?php echo $row->start_date; ?>&nbsp;</label>
                    </div>  
                     <div style="clear:both;"></div> 
                     <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Exam End Date: </label><label for="field-ta" class="col-sm-9 control-label"><?php echo $row->end_date; ?>&nbsp;</label>
                    </div> 
                     <div style="clear:both;"></div> 
                     <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Exam Type: </label><label for="field-ta" class="col-sm-9 control-label"><?php echo strtoupper($row->exam_category); ?>  >>>  <?php echo strtoupper($row->exam_type); ?>&nbsp;</label>  
                    </div>  
                     <div style="clear:both;"></div> 
                      <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Exam Mode: </label><label for="field-ta" class="col-sm-9 control-label"><?php echo strtoupper($row->exam_mode); ?>&nbsp;</label>
                    </div>  
                     <div style="clear:both;"></div> 
                      <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Exam City: </label><label for="field-ta" class="col-sm-9 control-label">
						<?php
						$exam_city_ar = json_decode($row->exam_city);
						// print_r($exam_city_ar);
				 		foreach($exam_city_ar as $cityname){ 
					 	$stateId=$this->common_options->get_state_id($cityname);
						echo $city= ucwords($this->common_options->get_city_name($cityname)).' - ['.$this->common_options->get_state_name($stateId).'])'.'<br>';
					   
						 }
               

                 ?>
						
						
						
						</label>
                    </div>  
                    <div style="clear:both;"></div> 
                    
                    <div align="center" class="form-group" style="background-color:#0099ff;">
<span style="color:#FFFFFF; font-size:14px">	<strong>Payment Details</strong></span>
</div>
                    <div style="clear:both;"></div> 
                      <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Vendor/Manpower:</label>
                        <label for="field-ta" class="col-sm-2 control-label"><?php if($row->payment_type=='shift'){?> Per Shift <?php } ?>
                        <?php if($row->payment_type=='day'){?> Per Day <?php } ?></label>	
                         <label for="field-ta" class="col-sm-3 control-label"> Cost:  &#8377; <?php echo $row->exam_cost; ?></label>
                          <label for="field-ta" class="col-sm-4 control-label"> Extra Cost:  &#8377; <?php echo $row->exam_extra_cost; ?></label>
                      						
                    </div>  
                    <div style="clear:both;"></div> 
                   <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Client Payment: </label>
                        <label for="field-ta" class="col-sm-2 control-label"><?php if($row->client_paymet_type=='shift'){?> Per Shift <?php } ?>
                        <?php if($row->client_paymet_type=='day'){?> Per Day <?php } ?></label>	
                         <label for="field-ta" class="col-sm-3 control-label"> Cost:  &#8377; <?php echo $row->client_cost; ?></label>
                          <label for="field-ta" class="col-sm-4 control-label"> Extra Cost:  &#8377; <?php echo $row->client_extra_cost; ?></label>
                      						
                    </div> 
					 <div style="clear:both;"></div> 
				   <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Margin: </label><label for="field-ta" class="col-sm-9 control-label">&#8377; <?php echo $row->margin_cost; ?>&nbsp;</label>
                    </div>  
					<br />
					<div style="clear:both;"></div> 
					 <div class="form-group" align="center">
                      <label for="field-ta" class="col-sm-12 control-label">
                      <button type="button" class="btn btn-default btn btn-success" data-dismiss="modal">Close</button> </label>
                          
                    </div>  

                    
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