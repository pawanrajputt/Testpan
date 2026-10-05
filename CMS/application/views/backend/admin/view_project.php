<!--<link href="../../../../assets/css/neon.css" rel="stylesheet" type="text/css" />-->


 <?php 
		  foreach ($view_exam_list_data as $rowdata) { 
		  	$prjId=$rowdata['project_id'];
		  }
		  
 ?>
 <link href="../../../../assets/css/neon.css" rel="stylesheet" type="text/css" />
 
<div style="clear:both;"></div>



			<div style="width:60%; background-color:#3FC; border:double" class="">
           <?php 
		   
            $ext_finance = $this->db->query("SELECT sum(tp_total_amount) as total_tp_amt, sum(tp_gst_amount) as tp_total_gst, sum(tp_total_payable) as tp_ttl_payable, sum(tp_extra_cost) as tp_ttl_extra_cost, sum(tp_total_payable) as tp_ttl_payable, sum(cm_total_seat_cost) as cl_ttl_cost, sum(cm_extra_cost) as cm_ttl_extra_cost, sum(cm_total_amount) as cm_ttl_amount, sum(cm_gst_amount) as cm_ttl_gst_amount, sum(cm_total_payable) as cm_ttl_payable  FROM tt_exam_booking_detail where 1=1 and project_id='".$prjId."' and deleted=0")->row();
			$tp_total_seat_amount = $ext_finance->total_tp_amt;
			$tp_total_gst_amount = $ext_finance->tp_total_gst;
			$tp_total_extra_cost = $ext_finance->tp_ttl_extra_cost;
			$tp_total_payable = $ext_finance->tp_ttl_payable;
			
			$client_total_seat_amount = $ext_finance->cl_ttl_cost;
			$client_total_gst_amount = $ext_finance->cm_ttl_gst_amount;
			$client_total_extra_cost = $ext_finance->cm_ttl_extra_cost;
			$client_total_payable = $ext_finance->cm_ttl_amount;
			
			$marginCost=($tp_total_seat_amount+$tp_total_extra_cost)-($client_total_seat_amount+$client_total_extra_cost);
           ?> 
				
				<table width="100%" class="table table-bordered table-bordered" style="background-color:#3FC">
					<caption><h4>Payment Details</h4></caption>
					<thead>
						<tr style="background-color:#3FC">
							<th style="background-color:#3FC">
							<strong>	Testpan Cost</strong>
							</th style="background-color:#3FC">
							<th style="background-color:#3FC">
							<strong>	Venue Cost</strong>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr style="background-color:#3FC ">
						  <td colspan="1" style="background-color:#3FC"> <strong>TestPan Cost : &#8377; <?php echo $tp_total_seat_amount; ?></td>
						  <td colspan="1" style="background-color:#3FC"> <strong>Venue Cost : &#8377; <?php echo $client_total_seat_amount; ?></td>
					  </tr>
						<tr style="background-color:#3FC ">
						  <td colspan="1" style="background-color:#3FC"> <strong>Extra Cost : &#8377; <?php echo $tp_total_extra_cost; ?></td>
						  <td colspan="1" style="background-color:#3FC"> <strong>Extra Cost : &#8377;<?php echo $client_total_extra_cost; ?></td>
					  </tr>
						<tr style="background-color:#3FC ">
						  <td colspan="1" style="background-color:#3FC"> <strong>Gst Amount :  &#8377; <?php echo $tp_total_gst_amount; ?></td>
						  <td colspan="1" style="background-color:#3FC"> <strong>Gst Amount :  &#8377; <?php echo $client_total_gst_amount; ?></td>
					  </tr>
						<tr style="background-color:#3FC ">
						  <td colspan="1" style="background-color:#3FC"> <strong>Total Payable <strong> Amount:  &#8377; <?php echo $tp_total_payable; ?></strong></td>
						  <td colspan="1" style="background-color:#3FC"> <strong>Total Payable <strong> Amount:  &#8377; <?php echo $client_total_payable; ?></strong></td>
					  </tr>
						<tr style="background-color:#3FC ">
							<td colspan="2" align="center" style="background-color:#3FC"><strong>Total Margin : &#8377; (<?php echo $tp_total_seat_amount; ?>+<?php echo $tp_total_extra_cost; ?>)-(<?php echo $client_total_seat_amount; ?>+<?php echo $client_total_extra_cost; ?>)=<?php echo $marginCost; ?> </strong></td>
						       
						</tr>
                        
					</tbody>
	  </table>
			</div>
			
		
<!--<table class="table panel-table table-bordered" id="table">
<tr bgcolor="#CCCCFF">
          <th style="background-color:#0099ff; color:#FFF" width="10%" nowrap="nowrap" >eeeee Date</th>
          <th style="background-color:#0099ff; color:#FFF" width="10%" >eerr</th>
          <th style="background-color:#0099ff; color:#FFF" width="35%" >Center Name</th>
          <th style="background-color:#0099ff; color:#FFF" width="15%" >Parryment Details</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" nowrap="nowrap" >Batch1</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch2 </th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch3</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch4 </th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch5</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="5%" >Status</th>
      </tr>
</table>-->

<?php foreach ($view_exam_list_data as $row) { 
				
					  $d_details =  $this->db->query("SELECT * FROM tt_exam_booking_detail  WHERE 1=1 and deleted=0 and project_id='".$row['project_id']."' and city_id='".$row['exam_city_id']."' ORDER BY id ASC")->result_array();
				
		?>  

<table class="table   table-bordered " id="table-2">
<tr bgcolor="#0099ff">
          <th colspan="11" nowrap="nowrap" style="background-color:#0099ff; color:#ffff; font-size:14px" align="center" > <b> Booking Detail : <?php echo get_city_name($row['exam_city_id']);?>  <?php if(count($d_details)==0) {  ?> : <span style="color:#fff"> Bookig Not Done ! </span> <?php } ?> </b> </th>
  </tr>
   <?php if(count($d_details)!=0) {  ?>
        <tr bgcolor="#0099ff">
          <th style="background-color:#0099ff; color:#FFF" width="10%" nowrap="nowrap" >Exam Date</th>
          <th style="background-color:#0099ff; color:#FFF" width="10%" >City</th>
          <th style="background-color:#0099ff; color:#FFF" width="35%" >Center Name</th>
          <th style="background-color:#0099ff; color:#FFF" width="15%" >Payment Details</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" nowrap="nowrap" >Batch1</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch2 </th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch3</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch4 </th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch5</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="5%" >Status</th>
      </tr>
  <?php } ?>
  
    
<?php
		//$Total_TP_Cost='';
		//$Total_cm_Cost='';
		  $p_details =  $this->db->query("SELECT * FROM tt_exam_booking_detail  WHERE 1=1 and deleted=0 and project_id='".$row['project_id']."' and city_id='".$row['exam_city_id']."' ORDER BY id ASC")->result_array();
		if(count($p_details)!=0)
		{
			$req_tp_costs='';
			$req_cm_costs='';
			$req_cm_extra_costs='';
			foreach ($p_details as $rows) { 
			if($rows['status']==0)
			{
				$status="Pending";
			}
			else
			{
				$status="Confirmed";
			}
			$req_tp_costs=$rows['req_tp_cost'];
			$req_cm_costs=$rows['req_cm_cost'];
			$req_cm_extra_costs=$rows['req_cm_extra_cost'];
			$diffewences=$req_tp_costs-$req_cm_costs;
			
			//$Total_TP_Cost=$req_tp_cost+$Total_TP_Cost;
			//$Total_cm_Cost=$req_cm_cost+$Total_cm_Cost;
			//$Total_margin=$Total_TP_Cost-$Total_cm_Cost;
	?>
        
            <tr>
               
                <td><?php echo $rows['exam_date']; ?></td>
                <td><?php echo get_city_name($rows['city_id']); ?></td>
				<td><?php echo $rows['center_name']; ?></td>
                <td><spam>Testpan Amount : <?php echo $req_tp_costs; ?></span>
                <div>Final Amount : <?php echo $req_cm_costs; ?></div>
                <div>Extra Amount : <?php echo $req_cm_extra_costs; ?></div>
                <div>Margin : <?php echo $diffewences; ?></div>
                
                </td>
				<td style="text-align:center"><?php echo $rows['batch1']; ?></td>
				<td style="text-align:center"><?php echo $rows['batch2']; ?></td>
				<td style="text-align:center"><?php echo $rows['batch3']; ?></td>
                <td style="text-align:center"><?php echo $rows['batch4']; ?></td>
                <td style="text-align:center"><?php echo $rows['batch5']; ?></td>
                <td style="text-align:center"><?php echo $status; ?></td>
				
            </tr>
            <?php }} ?>
          
       
</table>
    </br>
     <?php } ?>

