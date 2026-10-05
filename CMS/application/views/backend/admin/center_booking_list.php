<?php 
		foreach ($booked_exam_list_data as $rowss)
{
	$projectId=$rowss['project_id'];
}


?>


<div style="clear:both;"></div>
<br>

<form id="myform" name="myform" method="post" action="">
<table class="table table-striped datatable" id="table-1">
    <thead>
   		<tr><?php echo ucwords($centerId); ?>
        <td colspan="54" align="right" style="font-size:14px; width:100%; color:#2193D1"> <input  name="button" type="submit" class="btn" id="button" style="background-color: #03a9f4; color: white;" onclick="javascript:return notify_company(document.myform);" value="Download Lab Detail" /></td>
		  <td colspan="54" align="right" style="font-size:14px; width:100%; color:#2193D1"> <input  name="button" type="submit" class="btn" id="button" style="background-color: #03a9f4; color: white;" onclick="javascript:return notify_company(document.myform);" value="Download Confirm Center" /></td>
		</tr>
        <input name="projectId" type="hidden" value="<?php echo base64_encode($projectId); ?>" />
</thead>
</table>
</form>


<table class="table table-striped datatable" id="table-2">
 <thead>
        <tr bgcolor="#0099ff">
          <th style="background-color:#0099ff; color:#FFF" width="10%" nowrap="nowrap" >Exam Date</th>
          <th style="background-color:#0099ff; color:#FFF" width="10%" >City</th>
          <th style="background-color:#0099ff; color:#FFF" width="40%" >Center Name</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" nowrap="nowrap" >Batch1</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch2 </th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%">Batch3</th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch4 </th>
          <th style="background-color:#0099ff; color:#FFF; text-align:center" width="4%" >Batch5</th>
		  <th style="background-color:#0099ff; color:#FFF; text-align:center" width="20%" >Action</th>
          
      </tr>
    </thead>

    <tbody>
        <?php foreach ($booked_exam_list_data as $row) { 
				
				$status=$row['status'];
				if($status==0){
					$statusval="Pending";
				}
				if($status==1){
					$statusval="Confirm";
				}
				if($row['tp_commercial_mode']==1){
				 $tpmode='Candidate';
				 $tpcost=$row['tp_cost'];
				}
				if($row['tp_commercial_mode']==2){
				 $tpmode='System';
				 $tpcost=$row['tp_cost'];
				}
				if($row['tp_commercial_mode']==3){
					 $tpmode='Rate Slab';
					  $tpcost=$row['tp_cost'];
				}
				if($row['tp_commercial_mode']==4){
					 $tpmode='Lump Sum';
					  $tpcost=$row['tp_cost'];
				}
				
				if($row['cm_commercial_mode']==1){
				 $cmmode='Candidate';
				 $cmcost=$row['cm_cost'];
				}
				if($row['cm_commercial_mode']==2){
				 $cmmode='System';
				 $cmcost=$row['cm_cost'];
				}
				if($row['cm_commercial_mode']==3){
					 $cmmode='Rate Slab';
					  $cmcost=$row['cm_cost'];
				}
				if($row['cm_commercial_mode']==4){
					 $cmmode='Lump Sum';
					  $cmcost=$row['cm_cost'];
				}
				
				$batch_one=''; $batch_two=''; $batch_three=''; $batch_four=''; $batch_five='';
				if($status==0){ $batch_one=$row['req_batch1']; } else { $batch_one=$row['batch1']; }
				if($status==0){ $batch_two=$row['req_batch2']; } else { $batch_two=$row['batch2']; }
				if($status==0){ $batch_three=$row['req_batch3']; } else { $batch_three=$row['batch3']; }
				if($status==0){ $batch_four=$row['req_batch4']; } else { $batch_four=$row['batch4']; }
				if($status==0){ $batch_five=$row['req_batch5']; } else { $batch_five=$row['batch5']; }
		
		?>   
            <tr>
               
                 <td><?php echo $row['exam_date']; ?></td>
                <td><?php echo get_city_name($row['city_id']); ?></td>
				<td><?php echo $row['center_name']; ?></td>
				<td style="text-align:center"><?php echo $batch_one; ?></td>
				<td style="text-align:center"><?php echo $batch_two; ?></td>
				<td style="text-align:center"><?php echo $batch_three; ?></td>
                <td style="text-align:center"><?php echo $batch_four; ?></td>
                <td style="text-align:center"><?php echo$batch_five; ?></td>
				<td style="text-align:center"><?php if($status==0){ ?> <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/booking_confirm_popup/<?php echo $row['id'] ?>');" 
                        class="btn btn-green btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Confirm
                    </a>
                    <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/cancil_exam_popup/<?php echo $row['id'] ?>');" 
                        class="btn btn-red btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Cancel
                    </a>
                    
                 <?php    } else { ?>
                     
                        Booked
               <?php     } ?>
                    
                    </div>
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