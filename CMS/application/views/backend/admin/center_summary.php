


<div style="clear:both;"></div>
<br>

<table class="table table-bordered table-striped datatable" id="data-table">
    <thead>
        <tr align="center" valign="middle">
		  <th>Region</th>
			 <th>State</th>
			  <th>City</th>
              <th>No of Center </th>
			  <th>Used Center</th>
			  <th>Fresh Center</th>
		    <th>Document [Yes]</th>
			<th>Document [No]</th>
			<th>Photograph [Yes]</th>
			<th>Photograph [No]</th>
			<th>Used Seats</th>
            <th>Fresh Seats</th>
            <th>Total Seats</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($center_summary_info as $row) { 
		
				$total_seat='';
				$city_id=$row['city_id'];
				$region_code=$row['region_code'];
				$state_id=$row['state_id'];
				//echo '<br>S='.$total_seat=$row['total_no_system'];
				
				//echo '<br>A='.$dd="SELECT SUM(total_no_system) as t_seat FROM tt_center where  city_id='".$row['city_id']."' and  deleted=0";
				
				$tst_query = $this->db->query("SELECT SUM(total_no_system) as t_seat FROM tt_center where  city_id='".$row['city_id']."' and  deleted=0");
				//echo '<br>S='.$total_seat = $tst_query->row()->id;
				$total_seat = $tst_query->row()->t_seat;
				
				$total_center='';
				$total_doc_yes='';
				$total_doc_no='';
				$total_photo_yes='';
				$total_photo_no='';
				$freshSeatall='';
				
				$rg_qry = $this->db->query("SELECT * FROM tt_center_booking WHERE 1=1 AND city_id='".$city_id."' and project_id='".$project_id."'")->row();
				$bid=$ct_qry->id;
				
				$city_query = $this->db->query("SELECT COUNT(city_id) as total_center FROM tt_center where city_id='".$row['city_id']."' and  deleted=0");
				$total_center = $city_query->row()->total_center;		
				
				$doc_yes_query = $this->db->query("SELECT COUNT(city_id) as total_d_yes FROM tt_center where document_sign='yes' and city_id='".$row['city_id']."' and  deleted=0");
				$total_doc_yes = $doc_yes_query->row()->total_d_yes;	
				
				$doc_no_query = $this->db->query("SELECT COUNT(city_id) as total_d_no FROM tt_center where document_sign='no' and city_id='".$row['city_id']."' and  deleted=0");
				$total_doc_no = $doc_no_query->row()->total_d_no;	
				
				$phg_yes_query = $this->db->query("SELECT COUNT(city_id) as total_p_yes FROM tt_center where photographs='yes' and city_id='".$row['city_id']."' and  deleted=0");
				$total_photo_yes = $phg_yes_query->row()->total_p_yes;	
				
				$phg_no_query = $this->db->query("SELECT COUNT(city_id) as total_p_no FROM tt_center where photographs='no' and city_id='".$row['city_id']."' and  deleted=0");
				$total_photo_no = $phg_no_query->row()->total_p_no;
				
				$used_ct_query = $this->db->query("SELECT COUNT(city_id) as used_city FROM tt_center_booking_master where  city_id='".$row['city_id']."' and  deleted=0");
				$total_used_ct = $used_ct_query->row()->used_city;
				
				$freshCenter=$total_center-$total_used_ct;
				if($freshCenter>-0)
				{
					$freshcentertot=$freshCenter;
				}
				else
				{
					$freshcentertot='0';
				}
				//echo '<br>A='.$dd="SELECT SUM(total_seat) as used_seat FROM tt_center_booking_master where  city_id='".$row['city_id']."' and  deleted=0";
				$used_seat_query = $this->db->query("SELECT SUM(total_seat) as used_seat FROM tt_center_booking_master where  city_id='".$row['city_id']."' and  deleted=0");
				$total_used_seat = $used_seat_query->row()->used_seat;
				
				$freshSeat=$total_seat-$total_used_seat;
				if($freshSeat>=0)
				{
					$freshSeatall=$freshSeat;
				}
				else
				{
					$freshSeatall='0';
				}
				
			
		?>  
		
            <tr>
                <td><?php echo ucwords($this->common_options->get_region_name($row['state_id'])); ?></td>
				<td><a href="<?php echo base_url(); ?>index.php?c=admin&m=center_listing&state_id=<?php echo $row['state_id']; ?>" target="_blank" title="View Center"><?php echo ucwords($this->common_options->get_state_name($row['state_id'])); ?></a></td>
				<td><a href="<?php echo base_url(); ?>index.php?c=admin&m=center_listing&state_id=<?php echo $row['state_id']; ?>&city=<?php echo $row['city_id']; ?>" target="_blank" title="View Center"><?php echo ucwords($this->common_options->get_city_name($row['city_id'])); ?></a></td>
				<td><?php echo $total_center; ?></td>
				<td><?php echo $total_used_ct; ?></td>
				<td><?php echo $freshcentertot; ?></td>
				<td><?php echo $total_doc_yes; ?></td>
				<td><?php echo $total_doc_no; ?></td>
				<td><?php echo $total_photo_yes; ?></td>
                <td><?php echo $total_photo_no; ?></td>
              <td><?php echo $total_used_seat; ?></td>
			  <td><?php echo $freshSeatall; ?></td>
			  <td colspan="2"><?php echo $total_seat; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>





<!-- ================== BEGIN PAGE LEVEL JS ================== -->



	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js_p/table-manage-buttons.demo.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js_p/apps.min.js"></script> 
	
	<script>
		$(document).ready(function() {
			App.init();
			TableManageButtons.init();
		});
		
	</script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	