


<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">
<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />


<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th></th>
			<th>Client Name</th>
            <th>Project Name</th>
            <th>City</th>
            <th>Exam Date</th>
            <th>Required Seat</th>
			<th>Booked Seat</th>
			<th>Pending Seat</th>
			<th>Last Update</th>
			<th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($admin_project_info as $row) { 
				$deleted=$row['deleted'];	
				$project_gid=$row['project_id'];
				$city_id=$row['city_id'];
			$stp1_qry = $this->db->query("SELECT * FROM tt_project_requirement_master WHERE 1=1 AND project_group_id='".$project_gid."' and exam_city_id='".$city_id."'")->row();
			'<br>ST='.$req_seat=$stp1_qry->number_of_seat;
				$clientName=$stp1_qry->client_name;
			

		?>  
		
            <tr>
                <td></td>
                	 <td><?php echo ucwords($clientName) ?></td>
					<td><a href="<?php echo base_url(); ?>index.php?admin/project_detail/<?php echo $project_gid; ?>" target="_blank"><?php echo ucwords($row['project_name']) ?></a></td>
                     <td><?php echo get_city_name($city_id);  ?></td>
				  <td><?php echo $row['date_of_booking_start']; ?> to <?php echo $row['date_of_booking_end']; ?></td>
				   <td><?php echo $row['required_seat'];  ?></td>
				    <td>Under Process..</td>
					 <td><?php echo $row['required_seat']; ?></td>
					 <td><?php echo $row['booking_date']; ?></td>
				
                <td>
							
					
				<a <?php if($deleted==1){?> disabled <?php } ?> onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/send_email_pending_center/<?php echo $row['id'] ?>');" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Sent Mail
                    </a>
					
					
				<a <?php if($deleted==1){?> disabled <?php } ?> 	<a href="<?php echo base_url(); ?>index.php?admin/confirm_booking/<?php echo $row['id']; ?>">
                        <i class="entypo-pencil"></i>Confirm
                </a>
					
				
				<!--onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/confirm_booking_popup/<?php echo $row['id'] ?>');" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Confirm
                    </a>-->
				
                 <a  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/cancil_booking_popup/<?php echo $row['id'] ?>');" 
                        class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Cancel
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