<?php
	$pageUrl=$_SERVER['REQUEST_URI']; 
	$newUrl=parse_url($pageUrl);
	$aurl=$newUrl[query];
	$hlink=explode('/',$aurl);
	$projId=$hlink[2];
	$project_query = $this->db->query("SELECT * FROM tt_project_requirement_master WHERE 1=1 AND project_group_id='".$projId."'")->row();
	'<br>EX= '.$project_name = $project_query->exam_name;
	'<br>EX= '.$cleint_id = $project_query->client_id;
	'<br>EX= '.$client_name = $project_query->client_name;
	
	
?>

<div style="clear:both;"></div>
<br>
			
				 <form role="form" name="add_booking" id="add_booking" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/booking_search_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				
				
				
				
				
				<input type="hidden" name="project_id" id="project_id" value="<?php echo $projId; ?>" />
				<input type="hidden" name="project_name" id="project_name" value="<?php echo $project_name; ?>" />
				<input type="hidden" name="cleint_id" id="cleint_id" value="<?php echo $cleint_id; ?>" />
				<input type="hidden" name="client_name" id="client_name" value="<?php echo $client_name; ?>" />

<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><!--<input type="checkbox" name="check_all_client" id="check_all_client" />--></th>
            <th>Date</th>
            <th>City</th>
            <th>Center </th>
			<th>Vendor</th>
			<th>Available Seat</th>
			<th>Project Required Seat</th>
			<th>Custom Required Seat</th>
			<th>Center Cost</th>
        </tr>
    </thead>

    <tbody>
	
        <?php foreach ($manage_project_info as $row) { 
						
					
					$id=$row['center_id'];
					   '<br>ID='.$projId;
				
				 	$exm_ct_query = $this->db->query("SELECT * FROM tt_center WHERE 1=1 AND id='".$row['center_id']."'")->row();	   
	   				$city_id = $exm_ct_query->city_id;
					$vendor_id = $exm_ct_query->vendor_id;
					$center_name = $exm_ct_query->center_name;
					$total_no_system = $exm_ct_query->total_no_system;
	
	
				  
				  $project_ct_query = $this->db->query("SELECT * FROM tt_project_requirement_master WHERE 1=1 AND project_group_id='".$projId."' and exam_city_id='".trim($city_id)."'")->row();
		
					 '<br>pj= '.$pmid = $project_ct_query->project_group_id;  //project unique id
						
						 '<br>EX1= '.$exam_start_date = $project_ct_query->exam_start_date;
						 '<br>EX= '.$exam_end_date = $project_ct_query->exam_end_date;
						'<br>EX= '.$number_of_day = $project_ct_query->number_of_day;
						 '<br>EX= '.$total_exam_batch = $project_ct_query->total_exam_batch;
						 '<br>EX= '.$batch_1 = $project_ct_query->batch_1;
						 '<br>EX= '.$batch_2 = $project_ct_query->batch_2;
						 '<br>EX= '.$batch_3 = $project_ct_query->batch_3;
						 '<br>EX= '.$batch_4 = $project_ct_query->batch_4;
						 '<br>EX= '.$batch_5 = $project_ct_query->batch_5;
						'<br>EX= '. $prjReq_seat=$project_ct_query->number_of_seat;
						'<br>EX= '. $number_of_batch=$project_ct_query->number_of_batch;
						
					
					
					$seat_avl_query = $this->db->query("SELECT * FROM tt_center_booking_master WHERE 1=1 AND exam_start_date='".$exam_start_date."' and exam_end_date='".$exam_end_date."' and center_id='".$id."'")->row();
		//	echo	   '<br>CHK ='.$aa="SELECT * FROM tt_center_booking_master WHERE 1=1 AND exam_start_date='".$exam_start_date."' and exam_end_date='".$exam_end_date."' and center_id='".$id."'";
				 	 '<br>count ='.$cct=count($seat_avl_query);
					  '<br>UST= '.$used_seat= $seat_avl_query->total_seat;
						  '<br>ST= '.$totalSeat=$total_no_system;
						 $balance_seat=$totalSeat-$used_seat;
					  
		?>  
		
            <tr>
                <td><input name="ids[<?php echo $id; ?>]" type="checkbox" id="ids" value="<?php echo $id.'_'.$pmid; ?>">
					<input name="project_uniq_id[<?php echo $pmid; ?>]" type="hidden" value="<?php echo $pmid;?>" />
				</td>
                 <td><?php echo $exam_start_date ?> - <?php echo $exam_end_date ?> 
				 
				 
				 <input name="bookin_start_date[<?php echo $id; ?>]" type="hidden" value="<?php echo $exam_start_date;?>" />
				<input name="booking_end_date[<?php echo $id; ?>]" type="hidden" value="<?php echo $exam_end_date;?>" />
                <input name="number_of_day[<?php echo $id; ?>]" type="hidden" value="<?php echo $number_of_day;?>" />
                				 
				 <input name="total_exam_batch[<?php echo $id; ?>]" type="hidden" value="<?php echo $total_exam_batch;?>" />
				 <input name="batch_1[<?php echo $id; ?>]" type="hidden" value="<?php echo $batch_1;?>" />
				 <input name="batch_2[<?php echo $id; ?>]" type="hidden" value="<?php echo $batch_2;?>" />
				 <input name="batch_3[<?php echo $id; ?>]" type="hidden" value="<?php echo $batch_3;?>" />
				 <input name="batch_4[<?php echo $id; ?>]" type="hidden" value="<?php echo $batch_4;?>" />
				 <input name="batch_5[<?php echo $id; ?>]" type="hidden" value="<?php echo $batch_5;?>" />
				 <input name="number_of_batch[<?php echo $id; ?>]" type="hidden" value="<?php echo $number_of_batch;?>" />
				 </td>
                <td><?php echo ucwords(get_city_name($city_id)) ?> 
				<input name="city[<?php echo $id; ?>]" type="hidden" value="<?php echo get_city_name($city_id);?>" />
				<input name="city_id[<?php echo $id; ?>]" type="hidden" value="<?php echo $city_id;?>" />
				</td>
				  <td><?php echo ucwords($center_name); ?> <input name="center_name[<?php echo $id; ?>]" type="hidden" value="<?php echo $center_name;?>" />
				  <input name="center_id[<?php echo $id; ?>]" type="hidden" value="<?php echo $id;?>" /></td>
				    <td><?php echo ucwords($this->common_options->get_vendorname($vendor_id)); ?> <input name="vendor_id[<?php echo $id; ?>]" type="hidden" value="<?php echo $vendor_id;?>" /></td>
					  <td><?php echo $balance_seat; ?></td>   
					    <td><?php echo $prjReq_seat; ?></td>
				  <td><input name="req_seat[<?php echo $id; ?>]" type="text" width="25mm"  maxlength="5" /></td>
				    <td><input name="seat_cost[<?php echo $id; ?>]" type="text" width="25mm" maxlength="4" /></td>
            </tr>
        <?php } 
		if($id==0){
		
		?>
        <strong>!! NOT ANY MATCHING CENTER AVAILABLE</strong>
        <?php } ?>
    </tbody>
</table>


	   <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onClick="saveFrmDetails('add_booking','save_btn')" value="Submit">
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
	
</form>

<script src="assets/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">	
	
$('#check_all_client').click(function() {
if( $('#check_all_client').is(":checked") )
{
$('input[name="clientIds[]"]').each( function() {
$(this).attr("checked",true);
})
}
else
{
$('input[name="clientIds[]"]').each( function() {
$(this).attr("checked",false);
})
}

});

$('input[name="clientIds[]"]').bind('change', function() {

if ( $('input[name="clientIds[]"]').filter(':not(:checked)').length == 0 )
{
$('#check_all_client').attr("checked",true);
}
else
{
$('#check_all_client').attr("checked",false);
}

});



function notify_company(frm) //COMPANY notify to manager by caller
{
	for(var i=0;i<frm.elements.length;i++)
	{
		if(frm.elements[i].checked==false){ 
			var flag=0;
		}
		else if(frm.elements[i].checked==true){
				var flag=1;
				break;
		}
	}
	if(flag==0){
		//("Please Check Atleast One value");
		return false;
	}
	else{
		
		if(flag==1){
		var gifName = frm;
		//input_box=confirm("Are you Sure to notify manager");
		 if (input_box==true)
		 {
			document.myform.action="<?php echo base_url(); ?>index.php?admin/manage_client";
			document.myform.submit();
		}
		else
		{
		  return false
		}
	  }
	}
}

</script>