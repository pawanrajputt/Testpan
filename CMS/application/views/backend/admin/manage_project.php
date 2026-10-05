<button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_project');" 
    class="btn btn-blue pull-right">
      <i class="entypo-plus"></i>   Add Project
</button>


<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">

<table class="table table-striped datatable" id="table-2">
    <thead>
        <tr style="background-color:#0099ff"> 
            <th width="17%" style="color:#FFF">Project Name</th>
			<th width="26%" style="color:#FFF">Client Name</th>
			<th style="color:#FFF; text-align:center;' width="10%">Start Date</th>
			<th style="color:#FFF; text-align:center;' width="10%" >End Date</th>
            <th style="color:#FFF; text-align:center;'  width="4%>City</th>
			<th style="color:#FFF; text-align:center' width="4%">Status</th>
			<th style="color:#FFF; text-align:center' width="25%">Action</th>
		</tr>
    </thead>

    <tbody>
        <?php foreach ($all_project_info as $row) { 
				
		$seat_qry = $this->db->query("SELECT SUM(exam_required_seat) as totalreqseat FROM tt_project_detail where project_id='".$row['project_id']."' and deleted=0" )->row();	   
		$reqired_system = $seat_qry->totalreqseat;
		
		$seat_qry = $this->db->query("SELECT count(id) as totalCity FROM tt_project_detail where project_id='".$row['project_id']."' and deleted=0")->row();
		$ttalCity = $seat_qry->totalCity;
		
		$seat_book_qry = $this->db->query("SELECT SUM(req_book_seat) as totalbookseat FROM tt_exam_booking_detail where project_id='".$row['project_id']."' and deleted=0")->row();	   
		$booked_system = $seat_book_qry->totalbookseat;
		
		$useractv='';
		$userid_array='';
		$user_array='';
		$bstatus='';
		$statusval='';
		$c_details = $this->db->query("SELECT status as bstatus FROM tt_project_detail where project_id='".$row['project_id']."' and deleted=0")->result_array();
		foreach($c_details as $roquser)
		{
			$useractv.=$roquser['bstatus'].',';
		}
		$userid_array=substr($useractv,0,-1);
		 $user_array=explode(',',$userid_array);
	
		if (in_array('0', $user_array)) {
    		$bstatus="Pending";	
			$statusval=0;
		}
		else
		{
			$bstatus="Closed";	
			$statusval=1;
	
		}
	
		/*if($statusofbooking==1)
		{
			$bstatus="Booked";	
		} else {
			$bstatus="Pending";	
		}*/
			
		?>  
		
            <tr>
                <td><a href='<?php echo base_url(); ?>index.php?admin/center_booking_list/&pd=<?php echo base64_encode($row['project_id']); ?>' class="btn btn-green btn-sm btn-icon icon-left" target="_blank" title="Project Detail">
                 <i class="entypo-search"></i>      <?php echo $row['exam_name']; ?></a>
                   </td>
                <td><?php echo ucwords(($row['client_name'])) ?></td>   
				<td style="text-align:center"><?php echo date("d M Y", strtotime($row['start_date'])); ?></td>
				<td style="text-align:center"><?php echo date("d M Y", strtotime($row['end_date'])); ?></td>
				<td style="text-align:center"><?php echo $ttalCity; ?></td>  
				<!--<td><?php echo $booked_system; ?></td>-->
				<td style="text-align:center"><?php echo $bstatus; ?></td>
                <td style="text-align:center">
                <?php if($statusval==0){?>  <a target="_blank" href="<?php echo base_url(); ?>index.php?admin/exam_center_list/<?php echo base64_encode($row['project_id']); ?>" class="btn btn-orange btn-sm btn-icon icon-left">
                        <i class="entypo-search"></i>
                        Search
                    </a>
                   <?php } //else { ?>
                    <!--<a href="<?php echo base_url(); ?>index.php?admin/center_booking_list/&pd=<?php echo base64_encode($row['project_id']); ?>" class="btn btn-blue btn-sm btn-icon icon-left" target="_blank">
                      <i class="entypo-search"></i> Confirm Booking
                    </a>-->
                    
                    <?php //} ?>
                    
                     <a href="<?php echo base_url(); ?>index.php?admin/view_project/&pd=<?php echo base64_encode($row['project_id']); ?>" class="btn btn-green btn-sm btn-icon icon-left" target="_blank">
                      <i class="entypo-eye"></i> View
                    </a><br /><br />
                    <?php if($statusval==0){ ?>
                     <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/all_confirm_exam_popup/<?php echo $row['project_id'] ?>');" 
                        class="btn btn-red btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Close
                    </a>
                    <?php } ?>
                    <?php if($statusval==0 or $statusval==1){ ?>
                    	 <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_delete/<?php echo $row['project_id'] ?>');" 
                        class="btn btn-red btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Delete
                    </a>
                    <?php } ?>				 
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