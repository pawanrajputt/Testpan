
<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">



<input name="button" type="submit" class="btn btn-success" id="button" style="color: white;"  value="Download" /> 

<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th width="10%" style="color:#FFFFFF; background-color:#17A2B8">Lab Name</th>
            <th width="10%" style="color:#FFFFFF; background-color:#17A2B8">Computer</th>
            <th width="8%" style="color:#FFFFFF; background-color:#17A2B8">Total ACs</th>
			<th width="10%" style="color:#FFFFFF; background-color:#17A2B8">Monitor Type</th>
			<th width="12%" style="color:#FFFFFF; background-color:#17A2B8">Operating System</th>
			<th width="10%" style="color:#FFFFFF; background-color:#17A2B8">Processor</th>
			<th width="5%" style="color:#FFFFFF; background-color:#17A2B8">RAM</th>
			<th width="10%" style="color:#FFFFFF; background-color:#17A2B8">Hard Disk</th>
			<th width="10%" style="color:#FFFFFF; background-color:#17A2B8">Model No</th>
			<th width="15%" style="color:#FFFFFF; background-color:#17A2B8">Action</th>
        </tr>
    </thead>

    <tbody>
	 
        <?php foreach ($admin_user_info as $row) { 
	
		?>   
            <tr>
				<td><?php echo ucwords($row['lab_name']) ?><input type="hidden" name="centerId" id="centerId" value="<?php echo $row['center_id']; ?>" /></td>
                <td><?php echo $row['no_of_computer'] ?></td>
                 <td><?php echo $row['no_of_ac'] ?></td>
                <td><?php echo $row['monitor_type'] ?></td>
				<td><?php echo $row['operating_system'] ?></td>
				<td><?php echo $row['processor'] ?></td>
				<td><?php echo $row['ram'] ?></td>
				<td><?php echo $row['hard_disk'] ?></td>
				<td><?php echo $row['model_no'] ?></td>
				<!--<td> <div class="badge <?php echo $col_class; ?>" ><?php echo $status; ?></td>-->
                <td>
            
				
				<a  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/edit_lab/<?php echo $row['id'] ?>');" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                
              <a  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/delete_lab/<?php echo $row['id'] ?>');" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-cancel"></i>
                        Delete
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
	
$('#check_all_lab').click(function() {
if( $('#check_all_lab').is(":checked") )
{
$('input[name="lab_ids[]"]').each( function() {
$(this).attr("checked",true);
})
}
else
{
$('input[name="lab_ids[]"]').each( function() {
$(this).attr("checked",false);
})
}

});

$('input[name="lab_ids[]"]').bind('change', function() {

if ( $('input[name="lab_ids[]"]').filter(':not(:checked)').length == 0 )
{
$('#check_all_lab').attr("checked",true);
}
else
{
$('#check_all_lab').attr("checked",false);
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
			document.myform.action="<?php echo base_url(); ?>index.php?admin/center_listing";
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