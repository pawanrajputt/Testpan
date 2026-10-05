

<div style="clear:both;"></div>
<!--<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

<input name="button" type="submit" class="btn" id="button" style="background-color: #ff0000; color: white;" onclick="javascript:return notify_company(document.myform);" value="Inactive" />
<input name="button" type="submit" class="btn" id="button" style="background-color: #8bc34a; color: white;" onclick="javascript:return notify_company(document.myform);" value="Activate" />
<input name="button" type="submit" class="btn" id="button" style="background-color: #03a9f4; color: white;" onclick="javascript:return notify_company(document.myform);" value="Delete" />-->
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
           
            <th style="background-color:#0099ff; color:#FFF" width="35%">Client Name </th>
            <th style="background-color:#0099ff; color:#FFF" width="20%">Project Name</th>
			<th style="background-color:#0099ff; color:#FFF; text-align:center" width="10%">Start Date </th>
			<th style="background-color:#0099ff; color:#FFF; text-align:center" width="10%">End Date </th>
            <th style="background-color:#0099ff; color:#FFF; text-align:center" width="5%">Cities </th>
			<th style="background-color:#0099ff; color:#FFF; text-align:center" width="5%">Booked </th>
			<th style="background-color:#0099ff; color:#FFF; text-align:center" width="15%">Status</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($admin_project_info as $row) { 
		
					
				$prjID='';
				
				$prjID =$row['project_id'];	
				
				$project_query = $this->db->query("SELECT * FROM tt_project_detail WHERE 1=1 AND project_id='".$prjID."'")->row();
				$start_date = $project_query->start_date;
				$end_date = $project_query->end_date;	
				
				$ct_query = $this->db->query("SELECT * FROM tt_exam_booking_detail WHERE 1=1 AND project_id='".$prjID."' and deleted=0 order by id")->result_array();	
				$cityCount=count($ct_query);
				$prjsep['req_book_seat']='';
				$totalSeat = 0;
				foreach($ct_query as $prjsep)
				{ 
					$totalSeat = $totalSeat + $prjsep['req_book_seat'];
				}
				$totalSeat;
				
				$bookedseat['total_seat']='';
				$totalbookedSeat = 0;
				foreach($ct_query as $prjbooked)
				{ 
					$totalbookedSeat = $totalbookedSeat + $prjbooked['total_seat'];
				}
				$totalbookedSeat;
				$status="";
				$statusdis='';

				foreach($ct_query as $statusrts)
				{
					$status.=$statusrts['status'].', ';
				}
				 $allstatus=substr($status,0,-2);
				 $arr=explode(",",$allstatus);
				/* if (in_array(0, $arr))
				  {
				  	$statusdis= "Pending";
				  }*/
				
				   if (in_array(1, $arr) && in_array(0, $arr) )
				  {
				   	$statusdis= "Partially Confirmed";
				  }
				 if (in_array(1, $arr) && !in_array(0, $arr))
				  {
				  	$statusdis= "Confirmed";
				  }
				  //$projectcId=base64_encode($project_group_id);
			
		?>  
         <tr>
              
                 <td><?php echo ucwords(($row['client_name'])) ?></td>   
                <td>
                
       
         <a href="<?php echo base_url(); ?>index.php?admin/cost_sheet_detail/<?php echo base64_encode($prjID); ?>" class="btn btn-green btn-sm btn-icon icon-left"><i class="entypo-eye"></i><?php echo ucwords($row['project_name']) ?></a>       
                
                </td>
				 <td style="text-align:center"><?php echo date("d M Y", strtotime($start_date)); ?></td>
				 <td style="text-align:center"><?php echo date("d M Y", strtotime($end_date)); ?></td>
				<td style="text-align:center"><?php echo $cityCount; ?></td>
				<td style="text-align:center"><?php echo $totalbookedSeat; ?></td>
				<td style="text-align:center"><?php echo $statusdis; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
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

