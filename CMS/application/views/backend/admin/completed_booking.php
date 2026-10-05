


<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">
<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />


<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th></th>
            <th>Project Name</th>
            <th>Center</th>
			 <th>City</th>
            <th>Booking Date </th>
			<th>Booked Seat</th>
			<th>Payable Amount</th>
			<th>Payment Status</th>
			<th>Payment Date</th>
			<th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($admin_project_info as $row) { 
				
				$project_gid=$row['project_id'];
				$total_seat=$row['total_seat'];
				$seat_cost=$row['total_seat'];
				$totalCost=$row['total_cost'];
				$gstAmt=$row['gst_amount'];
				$finalCost=$row['total_payable_amount'];
				if($row['payment_status']==0)
				{
					$payStatus="Pending";
				}
				if($row['payment_status']==1)
				{
					$payStatus="Paid";
				}
							
		?>  
		
            <tr>
                <td></td>
                 <td><a href="<?php echo base_url(); ?>index.php?admin/project_detail/<?php echo $project_gid; ?>" target="_blank"><?php echo ucwords($row['project_name']) ?></a></td>
                <td><?php echo ucwords($row['center_name']) ?></td>
				<td><?php echo ucwords($row['city_name']) ?></td>
				  <td><?php echo $row['exam_start_date']; ?> - <?php echo $row['exam_end_date']; ?></td>
				   <td><?php echo $row['total_seat']; ?></td>
				    <td><img src="assets/images/rupees.png"  style="max-height:11px;"  class="img-circle" alt="logo" title="Testpan logo"/>  <?php echo $finalCost; ?></td>
					<td><?php echo $payStatus; ?></td>
					 <td><?php echo date('d/m/Y', strtotime($row['payment_date'])); ?>   </td>
				
                <td>
							
					
				<a href="<?php echo base_url(); ?>index.php?admin/download_invoice/<?php echo $row['id']; ?>/invoice" title="Invoice" target="_blank" class="btn btn-default btn-sm btn-icon icon-left">
                      <i class="entypo-download"></i>
                       Invoice
                    </a>	
					
					
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>

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