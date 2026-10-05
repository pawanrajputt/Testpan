<?php
$c_details = $this->db->query("SELECT * FROM tt_exam_booking_detail where 1=1 and booking_id='".$this->db->escape_str($param2)."'")->result_array();

$prjname = $this->db->query("SELECT * FROM tt_exam_booking_detail where 1=1 and booking_id='".$this->db->escape_str($param2)."'")->row();
$project_name= $prjname->project_name;				
					

?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading" align="center">
                <div class="" align="center">
                    <h3>Exam Schedule for <?php echo ucfirst($project_name);?></h3>
                </div>
            </div>

			
            <div class="panel-body">
			<p id="error_msg" style="color:#FF0000;"></p>
					
				
					<table class="table table-striped datatable" id="table-2">
    <thead>
        <tr style="background-color:#3300FF">
            <th style="color:#FFF"><strong>Exam Date</strong></th>
            <th style="color:#FFF"><strong>City</strong></th>
			<th style="color:#FFF"><strong>Center</strong></th>
            <th style="color:#FFF"><strong>Total Batch</strong></th>
			<th style="color:#FFF"><strong>Total Seat</strong></th>
			<th style="color:#FFF"><strong>Available Seat</strong></th>
        </tr>
    </thead>

    <tbody>
      <?php   foreach($c_details as $row){   
							
					$query = $this->db->query("SELECT * FROM tt_center where 1=1 and id='".$row['center_id']."'");
					$rowdata = $query->row();
					$total_no_system=$rowdata->total_no_system;
					$balSeat=$total_no_system-$row['total_seat'];
		?>   
            <tr style="border-color:#000033">
                 <td style="color:#000033"><?php echo $row['exam_date']; ?></td>
                <td style="color:#000033"><?php echo ucwords($row['city_name']); ?></td>
				<td style="color:#000033"><?php echo ucwords($row['center_name']);?></td> 
				<td style="color:#000033" align="center"><?php echo $row['total_batch']; ?></td>
				<td style="color:#000033" align="center"><?php echo $row['total_seat']; ?></td>      
				<td style="color:#000033" align="center"><?php echo $balSeat; ?></td>   
            </tr>
        <?php } ?>
    </tbody>
</table>
					
				
					
						
					
                 
              
            </div>

        </div>

    </div>
</div>

