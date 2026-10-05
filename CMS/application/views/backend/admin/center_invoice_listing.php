


<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">
<!--<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

<input name="button" type="submit" class="btn" id="button" style="background-color: #ff0000; color: white;" onclick="javascript:return notify_company(document.myform);" value="Inactive" />
<input name="button" type="submit" class="btn" id="button" style="background-color: #8bc34a; color: white;" onclick="javascript:return notify_company(document.myform);" value="Activate" />
<input name="button" type="submit" class="btn" id="button" style="background-color: #03a9f4; color: white;" onclick="javascript:return notify_company(document.myform);" value="Delete" />-->
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
			<th width="25%" style="color:#FFFFFF; background-color:#0099ff">Project Name</th>
            <th width="45%" style="color:#FFFFFF; background-color:#0099ff">Center Name</th>
			<th width="10%" style="color:#FFFFFF; background-color:#0099ff; text-align:center">Start Date </th>
			<th width="10%" style="color:#FFFFFF; background-color:#0099ff; text-align:center">End Date</th>
			<th width="5%" style="color:#FFFFFF; background-color:#0099ff; text-align:center">Booked</th>
			<th width="5%" style="color:#FFFFFF; background-color:#0099ff; text-align:center">Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($admin_project_info as $row) { 
		
					
				$prjID='';
				
				$prjID =$row['project_id'];	
				$projectName =$row['project_name'];
				$vendor_name =$row['center_name'];
				$centerId =$row['center_id'];
				$city_name =$row['city_name'];
				//$exam_start_date =$row['exam_date'];
				
				
				$exm_qrys = $this->db->query("SELECT start_date, end_date FROM tt_project_detail WHERE 1=1 and project_id='".$prjID."' and book_flag=0 and deleted=0")->row();
				$start_date=$exm_qrys->start_date;
				$end_date=$exm_qrys->end_date;
				

				
				$bkd_query = $this->db->query("SELECT * FROM tt_exam_booking_detail WHERE 1=1 AND project_id='".$prjID."' and center_id='".$centerId."' and book_flag=0 and status=1")->result_array();	
				//echo '<br>QY='.$ff="SELECT * FROM tt_center_booking WHERE 1=1 AND project_id='".$prjID."' order by id";
				//$cityCount=count($ct_query);
				$bookedseat['number_of_seat']='';
				$totalbookedSeat = 0;
				foreach($bkd_query as $bookedseat)
				{ 
					$totalbookedSeat = $totalbookedSeat + $bookedseat['total_seat'];
				}
				$totalbookedSeat;
				$exam_datea='';
				$exmDate='';
				foreach($bkd_query as $exmdate)
				{
					$exmDate.=date("d-m-Y", strtotime($exmdate['exam_date'])).', ';
				}
				$exam_datea=substr($exmDate,0,-2);
				
				
				$status="";
				$allstatus='';
				$arr='';
				foreach($bkd_query as $statusrts)
				{
					$status.=$statusrts['status'].', ';
				}
				$allstatus=substr($status,0,-2);
				
				//$arr=array($allstatus);
				$arr=explode(",",$allstatus);
				 if (in_array('0', $arr))
				  {
				  	$statusdis= "Pending";
				  }
				  else
				  {
				  	$statusdis= "Completed";
				  }
			
		?>  
		
            <tr>
                
                 <td><?php echo ucwords(($projectName)) ?></td>   
                <td><?php echo ucwords(($vendor_name)) ?></td>
				<td style="text-align:center"><?php echo  date("d M Y", strtotime($start_date)); ?></td> 
				<td style="text-align:center"><?php echo  date("d M Y", strtotime($end_date)); ?></td> 
				<td style="text-align:center"><?php echo $totalbookedSeat; ?></td>
                <td>
               
                 <a href="<?php echo base_url(); ?>index.php?admin/download_invoice/<?php echo $prjID; ?>/<?php echo $centerId; ?>/invoice" title="Invoice" target="_blank" class="btn btn-green btn-sm btn-icon icon-left">
                        <i class="entypo-download"></i>
                       Print
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