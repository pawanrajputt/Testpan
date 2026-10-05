
<?php
	 foreach ($p_details as $rowshd) { 
	 
	 '<br>PGIDs= '.$projectids=$rowshd['project_group_id'];	
	 '<br>IDs= '.$cityIds =$rowshd['exam_city_id'];
	$prj_query = $this->db->query("SELECT * FROM tt_center_booking WHERE 1=1 AND project_id='".$projectids."' and city_id='".$cityIds."'")->row();	
	 $projectname=$prj_query->project_name;     
	}		
?>



<div style="clear:both;"></div>
<br>

<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        
        
        <tr>
           	 <th nowrap="nowrap"> Project Name</th>
            <th nowrap="nowrap"> Center Name</th>
            <th nowrap="nowrap">City Name</th>
			<th nowrap="nowrap">Booking Date </th>
			<th nowrap="nowrap">Project Required Seats </th>
            <th nowrap="nowrap">Center Avaliable Seat </th>
			<th nowrap="nowrap">Booked Seat</th>
			<th nowrap="nowrap">Commercial</th>
			<th nowrap="nowrap">Booked on</th>
			<th>Status</th>
			<th nowrap="nowrap">Last Update</th>
        </tr>
    </thead>

    <tbody>
	
        <?php foreach ($p_details as $rows) { 
		
					
				$cnf_bookedSeat='';
				$id =$rows['id'];	
				$projectName =$rows['project_name'];
				$projectid =$rows['project_id'];
				$cId =$rows['center_id']; //center id
				$exam_city_id =$rows['city_id']; //center id
				$booking_date =$rows['booking_date']; //center id
				$status=$rows['status'];
				$ex_start_date=$rows['date_of_booking_start'];
				$ex_end_date=$rows['date_of_booking_end'];
				$exam_city_name =$rows['city_name']; //center id
				$ex_req_seat=$rows['required_seat'];
				$centerName=$rows['center_name'];
				
				$g_query = $this->db->query("SELECT * FROM tt_project_requirement_master WHERE 1=1 AND project_group_id='".$projectid."' and exam_city_id='".$exam_city_id."' and deleted=0 ")->row();
				$prj_req_seat=$g_query->number_of_seat;
				
				
				 
				$center_query = $this->db->query("SELECT * FROM tt_center_booking WHERE 1=1 AND project_id='".$projectid."' and city_id='".$exam_city_id."' and deleted=0 ")->row();	
				
				//$center_query = $this->db->query("SELECT * FROM tt_center_booking WHERE 1=1 AND id='".$id."' and project_id='".$projectid."'")->row();	
			//	 '<br>QS='.$ss="SELECT * FROM tt_center_booking WHERE 1=1 AND project_id='".$projectid."' and city_id='".$exam_city_id."' and deleted=0";
			//	'<br>CT'.$centerName=$center_query->center_name;
				$centerId=$center_query->center_id;
				$status_center=$center_query->status;
				//$prj_req_seat=$center_query->required_seat;
				$start_date=$center_query->date_of_booking_start;
				$end_date=$center_query->date_of_booking_end;
				$cityId=$center_query->city_id;
				$city_name=$center_query->city_name;
				$bookDate=$center_query->booking_date;
				$cnf_bookedSeats=$center_query->required_seat;
				
				 
				$bkd_query = $this->db->query("SELECT * FROM tt_center_booking_master WHERE 1=1 AND center_id='".$center_id."' and exam_start_date='".trim($rows['exam_start_date'])."' and exam_end_date='".trim($rows['exam_end_date'])."'")->result_array();	
				'<br>QSd='.$acount=count($bkd_query);
				if($acount==0)
				{
					$cnt_query = $this->db->query("SELECT total_no_system FROM tt_center WHERE 1=1 AND id='".$centerId."'")->row();	
					$avlSeat=$cnt_query->total_no_system;
				}
				
				$cnf_bk_query = $this->db->query("SELECT * FROM tt_center_booking_master WHERE 1=1 AND project_id='".$projectid."' and city_id='".$cityId."' and center_book_id='".$cId."'")->row();
				//echo	'<br>QSd='.$ss="SELECT * FROM tt_center_booking_master WHERE 1=1 AND project_id='".$projectid."' and city_id='".$cityId."' and center_book_id='".$cId."'";
				'<br>QSd='.$bcount=count($cnf_bk_query);
				'<br>QSd='.$modifyBy=$cnf_bk_query->modified_by;
				if($bcount!=0)
				{
					 $cnf_bookedSeat=$cnf_bk_query->total_seat;
					 $last_update=$cnf_bk_query->modify_date;
					 $commercial=$cnf_bk_query->final_cost_each;
					 $commercial_mode=$cnf_bk_query->per_sys_or_candidate;
					 $commerical_value=$commercial.' / '.$commercial_mode;
				}
				else
				{
					$cnf_bookedSeat=$prj_req_seat;
					$commerical_value="";
				}
				'<br>A='.$nodifyBy=$cnf_bk_query->modified_by;
				if($nodifyBy=='0' or $nodifyBy==''){ 
					 '<br>AD='.$last_update=$center_query->booking_date;
				}
			 
				
				if($status_center=='1')   
				{
					$bstatus="Confirmed";
					$seat_cost=$center_query->proposed_cost;
					//$seat_per_cost=$center_query->per_sys_or_candidate;
					$seat_per_cost=$rows['commerical_per'];
				}
				else if($status_center=='2')
				{
					$bstatus="Completed";
					'<br>B= '.$seat_cost=$cnf_bk_query->final_cost_each;
					$seat_per_cost=$cnf_bk_query->per_sys_or_candidate;

				}
				else
				{
					$bstatus="Pending";
					$seat_cost=$center_query->proposed_cost;
					$seat_per_cost=$rows['commerical_per'];
					
				}
				
		?> 
		
            <tr>
               	 <td><?php  echo ucwords($projectName); ?></td>   
                 <td><?php if($centerName){ echo ucwords($centerName); } else { echo "Center N/A"; }?></td>   
                <td><?php echo ucwords($exam_city_name) ?></td>
				  <td><?php if($status==0){ echo date("d M Y", strtotime($ex_start_date)); ?> to  <?php  echo date("d M Y", strtotime($ex_end_date));   } else { echo date("d M Y", strtotime($start_date)); ?> to  <?php  echo date("d M Y", strtotime($end_date)); } ?></td>
				<td><?php if($prj_req_seat) { echo $prj_req_seat; } else { echo $ex_req_seat;  } ?></td>
				<td><?php echo $avlSeat; ?></td>
				<td><?php echo $cnf_bookedSeats; ?></td>
				<td>Rs. <?php echo $seat_cost; ?> <!--/ <?php echo $seat_per_cost; ?>--></td>
				<td><?php if($bookDate){  echo date("d M Y", strtotime($bookDate)); } else { echo date("d M Y", strtotime($booking_date)); } ?></td>
               <td><?php echo $bstatus; ?></td>
			   <td><?php if($last_update){  echo date("d M Y", strtotime($last_update)); } else { echo "N/A";  }   ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>


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