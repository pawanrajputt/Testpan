<div style="clear:both;"></div><br> 
<form id="myform" name="myform" method="post" action="">
<table class="table table-striped datatable" id="table-2">
<thead>
        <tr>
          <th style="background-color:#0099ff; color:#FFF" width="30%" nowrap="nowrap" >CENTER NAME</th>
          <th style="background-color:#0099ff; color:#FFF" width="15%">CITY NAME</th>
	 <!--<th style="background-color:#0099ff; color:#FFF; text-align:center" width="15%">Exam Date</th>-->
          <th style="background-color:#0099ff; color:#FFF" width="11%">SENT</th>
          <th style="background-color:#0099ff; color:#FFF" width="11%">STATUS</th>
		  <th style="background-color:#0099ff; color:#FFF" width="11%">RESPONSE</th>
          <th style="background-color:#0099ff; color:#FFF" width="11%">DATE</th>
		  <th style="background-color:#0099ff; color:#FFF" width="11%">TIME</th>
		</tr>
</thead>
		<?php foreach ($view_notification_info as $rows) {
			$c_qry = $this->db->query("SELECT center_name FROM tt_center where id='".$rows['center_id']."'")->row();	   
			$center_name = $c_qry->center_name;
				if($rows['read_by']==0){ $readby='UnRead';	} else { $readby='READ'; }
				if($rows['send_flag']==0){ $sent='Not Delivered';	} else { $sent='DELIVERED'; }
				if($rows['center_responce']==0){ $center_responce='WAITING';	} else { $center_responce='ACCEPTED'; }	?>
        <tr>
			<td><?php echo ucfirst($center_name); ?></td>
			<td><?php echo get_city_name($rows['city_id']); ?></td>
		<!--<td style="text-align:center"><?php echo date("d M Y", strtotime($rows['exam_date'])); ?></td>-->
			<td><?php echo $sent; ?></td>
			<td><?php echo $readby; ?></td>
			<td><?php echo $center_responce; ?></td>
			<td style="text-transform:uppercase"><?php if($rows['center_responce_date']!='0000-00-00'){ echo date("d M Y", strtotime($rows['center_responce_date']));} else { echo "-- / -- / ----"; }?>
			<td><?php if($rows['center_responce_time']!='00:00:00'){ echo date("h:i:s A", strtotime($rows['center_responce_time']));} else { echo "-- : -- : --"; }?>
        <!--<td style="text-align:center"><?php if($rows['sent_date_time']!='0000-00-00 00:00:00'){ echo date("d M Y", strtotime($rows['sent_date_time']));} else { echo "--"; }?></td>-->
        </tr> <?php } ?>
</table>
</form>
<script src="assets/js/bootstrap-multiselect.js"></script>
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
		  function closeWin() {
		  myWindow.close();
		}
    });
</script>