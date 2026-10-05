<button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_client');" 
    class="btn btn-primary pull-right">
        Add New Client
</button>


<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">
<!--<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />-->

<input name="button" type="submit" class="btn" id="button" style="background-color: #ff0000; color: white;" onclick="javascript:return notify_company(document.myform);" value="Inactive" />
<input name="button" type="submit" class="btn" id="button" style="background-color: #8bc34a; color: white;" onclick="javascript:return notify_company(document.myform);" value="Activate" />
<input name="button" type="submit" class="btn" id="button" style="background-color: #03a9f4; color: white;" onclick="javascript:return notify_company(document.myform);" value="Delete" />

	<table class="table table-striped datatable" id="table-2">
    <thead>
        <tr style="background-color:#0099ff">
			<th width="5%"><input type="checkbox" name="check_all_client" id="check_all_client" /></th>
            <th width="28%" style="color:#FFF">Company Name</th>
			<th width="17%" style="color:#FFF">Name</th>
			<th width="10%"  style="color:#FFF">Mobile</th>
			<th width="10%" style="color:#FFF">City</th>
            <th width="10%" style="color:#FFF">State</th>
			<th width="5%"  style="color:#FFF">Status</th>
			<th width="15%" style="color:#FFF">Action (Edit / View)</th>
		</tr>
    </thead>

    <tbody>
        <?php foreach ($admin_user_info as $row) { 
		
					$col_class='';
							if($row['deleted']==0)
							{
								 $status="Active";
								 $col_class="badge-active";
							}
							if($row['deleted']==1)
							{
								 $status="Inactive";
								 $col_class="badge-inactive";
							}
							if($row['deleted']==2)
							{
								  $status="Deleted";
								  $col_class="badge-deleted";
							}			
		?>  
		
            <tr>
                <td><input name="clientIds[]" type="checkbox" id="clientIds" value="<?php echo $row['id']; ?>"></td>
                 <td><?php echo ucwords($row['company_name']) ?></td>
                <td><?php echo ucwords($row['co_ordinator_name']) ?></td>
				<td><?php echo $row['mobile_no'] ?></td>
				  <td><?php echo ucwords(get_city_name($row['city'])); ?></td>
				  <td><?php echo ucwords(get_state_name($row['state'])); ?></td>
				<td><div class="badge <?php echo $col_class; ?>"><?php echo $status; ?></td>
				
                <td>
                  <a href="<?php echo base_url(); ?>index.php?admin/edit_client/<?php echo $row['id']; ?>" class="btn btn-blue btn-sm icon-left">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                    
                    <a href="<?php echo base_url(); ?>index.php?admin/view_client/<?php echo $row['id']; ?>" class="btn btn-orange btn-sm icon-left" title="View">
                        <i class="entypo-eye"></i>
                        
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