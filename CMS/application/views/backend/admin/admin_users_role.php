<button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_admin_role');" 
    class="btn btn-primary pull-right">
        Add Admin Role
</button>

<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th></th>
            <th>Role Name</th>
            <th>Admin Access</th>
            <th>Vendor Access</th>
			<th>Center Access</th>
			<th>Client Access</th>
			<th>Booking Access</th>
			<th>Project Access</th>
			<th>Invoice Access</th>
			<th>Manpower Access</th>
            <th>Manpower Payment Access</th>
			<th>Center Excel Download</th>
			<th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($admin_user_info as $row) { 
		
			if($row['access_admin']==2){
				$adminAccess="No";
			} else { $adminAccess="Yes"; }
			
			if($row['access_vendor']==2){
				$vendorAccess="No";
			} else { $vendorAccess="Yes"; }
			
			if($row['access_center']==2){
				$centerAccess="No";
			} else { $centerAccess="Yes"; }
			
			if($row['access_client']==2){
				$clientAccess="No";
			} else { $clientAccess="Yes"; }
			if($row['access_booking']==2){
				$bookingAccess="No";
			} else { $bookingAccess="Yes"; }
			
			if($row['access_project']==2){
				$projectAccess="No";
			} else { $projectAccess="Yes"; }
			
			if($row['access_invoice']==2){
				$invoiceAccess="No";
			} else { $invoiceAccess="Yes"; }
			
			if($row['access_manpower']==2){
				$manpowerAccess="No";
			} else { $manpowerAccess="Yes"; }
			
			if($row['access_manpower_payment']==2){
				$manpowerAccess="No";
			} else { $access_manpower_payment="Yes"; }
			
			if($row['access_center_download']==2){
				$centerExcelAccess="No";
			} else { $centerExcelAccess="Yes"; }
		
		?>   
            <tr>
                <td></td>
                 <td><?php echo $row['title'] ?></td>
                <td><?php echo $adminAccess ?></td>
				<td><?php echo $vendorAccess ?></td>
				<td><?php echo $centerAccess ?></td>
				<td><?php echo $clientAccess ?></td>
				<td><?php echo $bookingAccess ?></td>
				<td><?php echo $projectAccess ?></td>
				<td><?php echo $invoiceAccess ?></td>
				<td><?php echo $manpowerAccess ?></td>
                <td><?php echo $access_manpower_payment ?></td>
				<td><?php echo $centerExcelAccess ?></td>
                <td>
                    <?php if($row['id']>1){?><a href="<?php if($row['id']>1){?><?php echo base_url(); ?>index.php?admin/edit_admin_role/<?php echo $row['id']; ?><?php }else{?>#<?php }?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                   
                    <?php }else{?>
                    Super Admin
                    <?php }?>
                </td>
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