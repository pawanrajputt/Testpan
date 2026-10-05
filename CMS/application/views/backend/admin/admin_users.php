<button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_admin_user');" 
    class="btn btn-primary pull-right">
        Add New Admin User
</button>

  <form role="form" name="usr_control" id="usr_control" action="<?php echo base_url(); ?>index.php?admin/usr_control_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
               
	<div class="col-sm-5" style="color:#039">
	
				<input type="radio" name="access" id="access" value="1" style="color:#00C"  /> ACTIVATE USERS
				<input type="radio"  name="access" id="access" value="2" style="color:#00C"  /> DEACTIVATE USERS
	
	
	<input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('usr_control','save_btn')" value="Go">
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p>
	</div>
	

  
                </form>

<div style="clear:both;"></div>
<br>

<table class="table table-striped datatable" id="table-2">
    <thead>
        <tr style="background-color:#0099ff">
		
            <th width="10%" style="color:#FFF">User Type</th>
			<th width="15%" nowrap="nowrap" style="color:#FFF">Name</th>
			<th width="12%" style="color:#FFF">Mobile</th>
			<th width="15%" style="color:#FFF">Email</th>
            <th width="8%" style="color:#FFF">Status</th>
			<th width="10%"  style="color:#FFF">Membership</th>
			<!--<th width="10%"  style="color:#FFF">Login City</th>-->
			
			<th width="25%" style="color:#FFF">Action</th>
		</tr>
    </thead>

    <tbody>
        <?php foreach ($admin_user_info as $row) { 
			if($row['log_status']==1 && $row['status']=='active')
			{
				$lock='Working';
			}
			if($row['log_status']==2 && $row['status']=='active')
			{
				$lock='Locked';
			}
			if($row['log_status']==1 && $row['status']=='blocked' )
			{
				$lock='Blocked';
			}
			if($row['log_status']==2 && $row['status']=='blocked' )
			{
				$lock='Blocked';
			}
			if($row['log_status']==3 && $row['status']=='blocked' )
			{
				$lock='Blocked';
			}
			
			$lg_qry = $this->db->query("SELECT ip_address FROM tt_admin_users_login_logs WHERE 1=1 AND user_id='".$row['id']."' ORDER BY id DESC LIMIT 1")->row();
			//echo 'a='.$gg="SELECT * FROM tt_admin_users_login_logs WHERE 1=1 AND user_id='".$row['id']."' ORDER BY id DESC LIMIT 1";
			$ipaddress=$lg_qry->ip_address;
			
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
			$start_date= date('d/m/Y', strtotime($qry_pkg->start_date));
			$end_date= date('d/m/Y', strtotime($qry_pkg->end_date));
			
			
			
		?>   
            <tr>
				
                <td <?php if($row['status']=='blocked'){ ?> style="color:#999" <?php } ?>><?php echo ucwords($this->common_options->get_role_type($row['role_id'])) ?></td>
				<td <?php if($row['status']=='blocked'){ ?> style="color: #0C6" <?php } ?>><?php echo ucwords($row['first_name']." ".$row['last_name']) ?></td>
				<td <?php if($row['status']=='blocked'){ ?> style="color: #0C6" <?php } ?>><?php echo $row['mobile_phone'] ?></td>
				<td <?php if($row['status']=='blocked'){ ?> style="color: #0C6" <?php } ?>><?php echo $row['email'] ?></td>
                <td <?php if($row['status']=='blocked'){ ?> style="color: #0C6" <?php } ?>><?php echo ucwords($lock) ?></td>
				
				<td> <?php if($row['coupon_add']==1){ ?> <?php echo $start_date; ?> - <?php echo $end_date; ?> <?php } if($row['coupon_add']==2) { ?> 
                        <?php echo $row['coupon_code'] ?>
                    <?php } ?></td>
				
				
				 
				
				
                <!--<td style="text-align:center; color: #0C6" <?php if($row['status']=='blocked'){ ?> <?php } ?>><?php echo ucwords($ipcity) ?></td>-->
                <td style="text-align:center; color: #0C6" <?php if($row['status']=='blocked'){ ?> <?php } ?>>
				
                    <?php if($row['id']>1){?><a href="<?php if($row['id']>1){?><?php echo base_url(); ?>index.php?admin/edit_admin_user/<?php echo $row['id']; ?><?php }else{?>#<?php }?>" class="btn btn-blue btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                   
                   
                  <a <?php if($deleted==1){?> disabled <?php } ?> onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/change_password/<?php echo $row['id'] ?>');" 
                        class="btn btn-green btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Password
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