


<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
   		<tr><?php echo ucwords($centerId); ?>
		  <td colspan="54" align="right" style="font-size:14px; width:100%; color:#2193D1"> <input  name="button" type="submit" class="btn" id="button" style="background-color: #03a9f4; color: white;" onclick="javascript:return notify_company(document.myform);" value="Download Cost Sheet" /></td>
		</tr>
        <tr> 
          <td colspan="3" style="font-size:11px; color:#000; background-color:#CCC" align="center" width="35%"><strong>Center Details</strong></td>
          <td colspan="5" style="font-size:11px; color:#000; background-color:#CCC" align="center" width="10%"><strong>Batches</strong></td>
          <td style="font-size:11px; color:#000; background-color:#CCC" width="5%">&nbsp;</td>
          <td colspan="4" style="font-size:11px; color:#000; background-color:#CCC" align="center" width="20%"><strong>Center Payment (&#8377;)</strong></td>
          <td colspan="4" style="font-size:11px; color:#000; background-color:#CCC" align="center" width="20%"><strong>TestPan Payment (&#8377;)</strong></td>
          <td style="font-size:11px; color:#000; background-color:#CCC"  width="10%">&nbsp;</td>
        </tr>
        <tr>
            <th width="15%" style="font-size:11px; color:#000; background-color:#CCC"><strong>City</strong></th>
			<th width="15%" style="font-size:11px; color:#000; background-color:#CCC"> <strong>Center</strong></th>
          	<th width="5%"  style="font-size:11px; color:#000; background-color:#CCC"><strong>Exam Date</strong></th>
			<th width="10%" style="font-size:11px; color:#000; background-color:#CCC"><strong>One</strong></th>
			<th width="2%" style="font-size:11px; color:#000; background-color:#CCC"><strong>Two</strong></th>
			<th width="2%" style="font-size:11px; color:#000; background-color:#CCC"><strong>Three</strong></th>
			<th width="2%" style="font-size:11px; color:#000; background-color:#CCC"><strong>Four</strong></th>
            <th width="2%" style="font-size:11px; color:#000; background-color:#CCC"><strong>Five</strong></th>
		  	<th width="5%" style="font-size:11px; color:#000; background-color:#CCC"><strong>Total</strong> </th>
		 	<th width="20%" style="font-size:11px; color:#000; background-color:#CCC"><strong> Mode</strong></th>
			<th width="5%" style="font-size:11px; color:#000; background-color:#CCC"> <strong>Cost </strong></th>
        	<th width="5%" style="font-size:11px; color:#000; background-color:#CCC"><strong>Extra</strong></th>
		  	<th width="5%" style="font-size:11px; color:#000; background-color:#CCC"><strong>Payment</strong> </th>
      		<th width="20%" style="font-size:11px; color:#000; background-color:#CCC"> <strong>Mode</strong></th>
		  	<th width="5%" style="font-size:11px; color:#000; background-color:#CCC"> <strong>Cost</strong></th>
			<th width="5%" style="font-size:11px; color:#000; background-color:#CCC"> <strong>Extra</strong></th>
            <th width="5%" style="font-size:11px; color:#000; background-color:#CCC"><strong>Payment </strong></th>
			<th width="10%" style="font-size:11px; color:#000; background-color:#CCC"><strong>Margin</strong></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($prj_details as $row) { 
				
				$cm_pay_mode='';
				$cm_Pmode='';
				$cm_rate='';
				$cm_totalSeatCost='';
				$cm_extra_cost='';
				$cm_totalSeatCost='';
				$cm_pay_mode=$row['cm_pay_option'];
				$cm_rate=$row['cm_cost'];
				$cm_extra_cost=$row['cm_extra_cost'];
				$cm_totalSeatCost=$row['cm_total_seat_cost'];
				$cm_total=$cm_extra_cost+$cm_totalSeatCost;
				
				if($cm_pay_mode=='1'){ $cm_Pmode ='Candidate'; }
				if($cm_pay_mode=='2'){ $cm_Pmode ='System'; }
				if($cm_pay_mode=='4'){ $cm_Pmode ='Lumpsum'; }
				

				
				$tpPmode='';
				$cmPmode='';
				$tp_totalSeatCost='';
				$tp_pay_mode=$row['tp_pay_option'];
				$tp_rate=$row['tp_cost'];
				$tp_extra_cost=$row['tp_extra_cost'];
				$tp_totalSeatCost=$row['tp_total_seat_cost'];
				$tp_total=$tp_extra_cost+$tp_totalSeatCost;
				if($tp_pay_mode=='1'){ $tpPmode ='Candidate'; }
				if($tp_pay_mode=='2'){ $tpPmode ='System'; }
				if($tp_pay_mode=='4'){ $tpPmode ='Lumpsum'; }
				
				
				$margin='';
				$margin = $tp_total-$cm_total;
				
				
				
				
				
				
		?>  
		
            <tr style="font-size:11px">
				<td><strong><?php echo $row['city_name']; ?></strong></td>
				<td><strong><?php echo $row['center_name']; ?></strong></td>
                <td nowrap="nowrap"><strong><?php echo date("d M Y", strtotime($row['exam_date'])); ?></strong></td>
				<td><strong><?php echo $row['batch1']; ?></strong></td>
				<td><strong><?php echo $row['batch2']; ?></strong></td>
                <td><strong><?php echo $row['batch3']; ?></strong></td>
             	<td><strong><?php echo $row['batch4']; ?></strong></td>
			  	<td><strong><?php echo $row['batch5']; ?></strong></td>
			   	<td><strong><?php echo $row['total_seat']; ?></strong></td>
			    <td><strong><?php echo $cm_Pmode; ?></strong></td>
				<td><strong><?php echo $cm_rate; ?></strong></td>
				<td><strong><?php echo $cm_extra_cost; ?></strong></td>
				<td><strong><?php echo $cm_total; ?></strong></td>
				<td><strong><?php echo $tpPmode; ?></strong></td>
				<td><strong><?php echo $tp_rate; ?></strong></td>
				<td><strong><?php echo $tp_extra_cost; ?></strong></td>
                <td><strong><?php echo $tp_total; ?> </strong></td>
				<td><strong><?php echo $margin; ?></strong></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</form>




<!-- ================== BEGIN PAGE LEVEL JS ================== -->


<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap"<?php /*?>,
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"<?php */?>
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function (i, el)
        {
            var $this = $(el),
                    $p = $this.closest('tr');

            $(el).on('change', function ()
            {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        // Replace Checboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        });
    });
</script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	