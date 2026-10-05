<button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_purchase_order');" 
    class="btn btn-blue pull-right">
      <i class="entypo-plus"></i>Add New PO
</button>


<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">

<table class="table table-striped datatable" id="table-2">
    <thead>
        <tr style="background-color:#0099ff">
        	<th>&nbsp;</th>
            <th width="15%" style="color:#FFF">PO Number</th>
            <th width="20%" style="color:#FFF; text-align:">Assesement </th>
            <th width="15%" style="color:#FFF; text-align:">Contact Person</th>
            <th width="20%" style="color:#FFF; text-align:">Address</th>
			<th width="10%" style="color:#FFF; text-align:center">PO Date</th>
			<th width="10%" style="color:#FFF; text-align:center">Amount</th>
			<th width="10%" style="color:#FFF; text-align:center">Action</th>
			
      </tr>
    </thead>

    <tbody>
        <?php foreach ($all_po_info as $row) { 
				
		$count++;
		
		
		
		
		
		
				
		?>  
		
            <tr>
            	 <td> <?php echo $count; ?> </td>
                <td> <?php echo ucfirst($row['po_number']); ?> </td>
			 <td> <?php echo ucfirst($row['assesement_name']); ?> </td>
             <td> <?php echo ucfirst($row['contact_person_name']); ?> </td>
              <td> <?php echo ucfirst($row['name_address']); ?> </td>
				<!--<td><?php echo $booked_system; ?></td>-->
                 <td> <?php echo ucfirst($row['po_date']); ?> </td>
                <td style="text-align:center">
					<?php echo ucfirst($row['total_amount']); ?>
				</td>
				<td style="text-align:center">
				<a href="<?php echo base_url(); ?>index.php?admin/add_purchase_order_confirm/<?php echo $row['id']; ?>" class="btn btn-green btn-sm btn-icon icon-left">
                      <i class="entypo-eye"></i> View </a>
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