<style type="text/css">
#table-2 thead tr th {
}
</style>
<button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_invoice_manual');" 
    class="btn btn-primary pull-right">
       Create New
</button>

<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
          <th width="5%" valign="middle">S.No</th>
          <th width="15%" valign="middle">Manpower Name</th>
          <th width="10%" valign="middle">Exam Date</th>
          <th width="15%" valign="middle">Exam Name</th>
          <th width="7%" valign="middle">No. of Manpower</th>
          <th width="7%" valign="middle">No. of Days</th>
          <th width="7%" valign="middle">Price Per Day</th>
          <th width="7%" valign="middle">Price Per Hour</th>
          <th width="7%" valign="middle">Amount (&#x20B9;)</th>
          <th width="15%" valign="middle">Beneficiary </th>
          <th width="5%" valign="middle">Invoice</th>
      </tr>
    </thead>

    <tbody>
        <?php foreach ($invoice_manual_info as $row)  { 
		$count++;
			
		?>   
            <tr>
                <td><?php echo $count; ?></td>
                 <td><?php echo ucwords($row['manpower_name']) ?></td> 
                <td><strong style="background-color:#C7FF8F">Start Date:<br /><?php echo date("d M Y", strtotime($row['exam_date'])); ?></strong><br />
                <strong style="background-color:#8FECFF">End Date:<br /><?php  echo date("d M Y", strtotime($row['exam_end_date']));?></strong></td> 
				<td><?php echo ucwords($row['exam_name']); ?></td>
				<td><?php echo $row['no_of_manpower'] ?></td>
				<td><?php echo $row['no_of_days'] ?></td>
				<td><?php echo $row['price_per_day'] ?></td>
				<td><?php echo $row['price_per_hour'] ?></td>	
				<td><?php echo $row['total_price'] ?></td>
                <td><strong style="background-color:#A9FCA1">Name: <?php echo ucwords($row['account_holder_name']) ?> </strong><br />
               <strong style="background-color:#ECF365"> A/c No.:<?php echo $row['bank_account_number'] ?></strong><br />
               <strong style="background-color:#65E5F7"> Pan No.: <?php echo $row['pan_number'] ?></strong><br />
               <strong style="background-color:#E3FD61"> Invoice No.: <br /><?php echo $row['invoice_number'] ?></strong></td>
                
               <td>
                <a href="<?php echo base_url(); ?>index.php?admin/edit_invoice_manual/<?php echo $row['group_id']; ?>" class="btn btn-blue btn-sm icon-left"> <i class="entypo-pencil"></i> Edit </a>&nbsp;
               <br />
               <br />
               <a  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/print_invoice_manual/<?php echo $row['group_id'] ?>');" 
                        class="btn btn-orange btn-sm icon-left">
                        <i class="entypo-pencil"></i>
                        Print
                    </a></td>
               
               
               
               
               
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