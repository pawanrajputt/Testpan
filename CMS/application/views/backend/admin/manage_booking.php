<button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_project');" 
    class="btn btn-primary pull-right">
        Add Project
</button>


<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">
<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

<input name="button" type="submit" class="btn" id="button" style="background-color: #ff0000; color: white;" onclick="javascript:return notify_company(document.myform);" value="Inactive" />
<input name="button" type="submit" class="btn" id="button" style="background-color: #8bc34a; color: white;" onclick="javascript:return notify_company(document.myform);" value="Activate" />
<input name="button" type="submit" class="btn" id="button" style="background-color: #03a9f4; color: white;" onclick="javascript:return notify_company(document.myform);" value="Delete" />
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><input type="checkbox" name="check_all_client" id="check_all_client" /></th>
            <th>Client Name</th>
            <th>Exam Name</th>
            <th>City </th>
			<th>Status</th>
			<th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($center_user_info as $row) { 
		
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
                <td><input name="ids[]" type="checkbox" id="ids" value="<?php echo $row['id']; ?>"></td>
                 <td><?php echo ucwords($row['client_name']) ?></td>
                <td><?php echo ucwords($row['exam_name']) ?></td>
				  <td><?php echo ucwords($row['exam_city_name']); ?></td>
				<td><div class="badge <?php echo $col_class; ?>"><?php echo $status; ?></td>
				
                <td>
                  <a href="<?php echo base_url(); ?>index.php?admin/#/<?php echo $row['id']; ?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?admin/#/<?php echo $row['id'] ?>');"
                       class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-cancel"></i>
                        View
                    </a>
                   
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>


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