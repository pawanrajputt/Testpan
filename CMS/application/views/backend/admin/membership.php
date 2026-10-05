

<div style="clear:both;"></div>
<br>

<table class="table table-striped datatable" id="table-2">
    <thead>
        <tr style="background-color:#0099ff">
		
			<th width="15%" nowrap="nowrap" style="color:#FFF">Name</th>
			<th width="11%" style="color:#FFF">Mobile</th>
			<th width="11%" style="color:#FFF">Email</th>
            <th width="11%" style="color:#FFF">Status</th>
			<th width="11%" style="color:#FFF">Type</th>
			  <th width="11%" style="color:#FFF">Order No.</th>
			<th width="11%"  style="color:#FFF">Package</th>
			<th width="11%"  style="color:#FFF">Validity</th>
			
			<th width="20%" style="color:#FFF">Action</th>
		</tr>
    </thead>

    <tbody>
        <?php foreach ($admin_user_info as $row) { 
			
			
			$lg_qry = $this->db->query("SELECT * FROM tt_admin_users WHERE 1=1 AND id='".$row['user_id']."'")->row();
			//echo 'a='.$gg="SELECT * FROM tt_admin_users_login_logs WHERE 1=1 AND user_id='".$row['id']."' ORDER BY id DESC LIMIT 1";
			//echo $this->db->last_query();//exit;
			$first_name=$lg_qry->first_name;
			$last_name=$lg_qry->last_name;
			$mobile_phone=$lg_qry->mobile_phone;
			$email=$lg_qry->email;
			$firstName=$lg_qry->ip_address;
			
			$query = @unserialize(file_get_contents('https://ip-api.com/php/'.$ipaddress));
			if($query && $query['status'] == 'success')
			{
				$ipcity = $query['city'];
				//echo 'Your State is ' . $query['region'];
			//	echo 'Your Zipcode is ' . $query['zip'];
			//	echo 'Your Coordinates are ' . $query['lat'] . ', ' . $query['lon'];
			}
			
			$qry_pkg = $this->db->query("SELECT * FROM tp_order WHERE 1=1 AND user_id='".$row['id']."' and status=0 and deleted=0")->row();
			//echo 'a='.$gg="SELECT * FROM tt_admin_users_login_logs WHERE 1=1 AND user_id='".$row['id']."' ORDER BY id DESC LIMIT 1";
			$package_name=$qry_pkg->order_type;
			//echo $this->db->last_query();exit;
			
			
			$order_status=$row['payment_status'];
			$order_type=$row['order_type'];
			$order_number=$row['order_id'];
			$package_id=$row['package_id'];
			
			$start_date= date('d/m/Y', strtotime($row['start_date'])); 
			$end_date= date('d/m/Y', strtotime($row['end_date']));
			  
		?>   
            <tr>
				
				<td><?php echo ucwords($first_name." ".$last_name) ?> </td>
				<td><?php echo $mobile_phone ?></td>
				<td><?php echo $email ?></td>
                <td><?php echo ucwords($order_status) ?></td>
				 <td><?php echo ucwords($order_type) ?></td>
				 <td><?php echo ucwords($order_number) ?></td>
				
				<td> 
				<?php echo ucwords($this->common_options->get_package_name($row['package_id'])) ?>
				</td>
				
				
				 <td> <?php echo $start_date ?> - <?php echo $end_date ?></td>
				
				<td> <?php echo $row['coupon_code'] ?></td>
              
               
				
                  
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