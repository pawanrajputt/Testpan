<button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_package');" 
    class="btn btn-primary pull-right">
        Add New Package
</button>



<div style="clear:both;"></div>
<br>

<form id="myform" name="myform" method="post" action="">
<!--<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />-->

<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
			<th>&nbsp;</th>
            <th>Package Name</th>
            <th>Package Cost</th>
			<th>Validity</th>
            <th>Status</th>
			<th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($view_package_info as $row) { 
						
						if($row['status']==1){
							$statusa='Active';
						}
						if($row['status']==0){
							$statusa='In-Active';
						}
						
		
		?>   
            <tr>
                <td>
				
				
				
				</td>
                 <td><?php echo ucwords($row['package_name']) ?></td>
                <td>&#x20B9; <?php echo $row['package_amount'] ?>  </td>
				
				<td><?php echo ucwords($row['package_validity']) ?> Month</td>
				<td><?php echo $statusa; ?></div>
				</td>
                <td>
                    <a href="<?php echo base_url(); ?>index.php?admin/edit_package/<?php echo $row['package_id']; ?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                   
				<!--    <a href="<?php echo base_url(); ?>index.php?admin/delete_package/<?php echo $row['package_id']; ?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Delete
                    </a>-->
                   
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
	
$('#check_all_vendor').click(function() {
if( $('#check_all_vendor').is(":checked") )
{
$('input[name="vendor_ids[]"]').each( function() {
$(this).attr("checked",true);
})
}
else
{
$('input[name="vendor_ids[]"]').each( function() {
$(this).attr("checked",false);
})
}

});

$('input[name="vendor_ids[]"]').bind('change', function() {

if ( $('input[name="vendor_ids[]"]').filter(':not(:checked)').length == 0 )
{
$('#check_all_vendor').attr("checked",true);
}
else
{
$('#check_all_vendor').attr("checked",false);
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
			document.myform.action="<?php echo base_url(); ?>index.php?admin/vendor_listing";
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