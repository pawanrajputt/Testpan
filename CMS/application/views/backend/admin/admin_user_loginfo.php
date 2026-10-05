

<div style="clear:both;"></div>

<br>

<table class="table table-bordered table-striped datatable" id="table-2">

    <thead>

        <tr>

            <th></th>

            <th>Fullname</th>

            <th>Email</th>
 			<th>Mobile</th>
            <th>Status</th>
 			 <th>Role</th>
             <th>Last Login</th>

			<th>IP Address</th>

			<th>Current Status</th>

        </tr>

    </thead>



    <tbody>

        <?php foreach ($admin_user_log_info as $row) { 
		
		$today=date("Y-m-d");
	
		
		?>   

            <tr>

                <td><?php if($row['log_status']=='1' && $row['log_date']==$today) { ?> <img src="<?php echo base_url(); ?>assets/images/online.png" alt="" style="height:10px;"> <?php } ?></td>

                 <td><?php echo ucwords($row['first_name']." ".$row['last_name']) ?></td>

                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['mobile_phone'] ?></td>
                

				<td><?php echo ucfirst($row['status']) ?></td>
                <td><?php if($row['role_id']=='1'){ ?> Super Admin <?php } ?>
                <?php if($row['role_id']=='2'){ ?> Administrator <?php } ?>
                <?php if($row['role_id']=='3'){ ?> Resource <?php } ?>
                
                </td>

                <td><?php echo date("d M Y", strtotime($row['last_login_date'])); ?></td>

				<td><?php  
				if($row['log_status']=='1')
				{
				$ip = $row['ip_address'];
                $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
                echo $details->city; ?>
                <br />
                <div style="font-size:10px"><?php 
				     echo $row['ip_address'];
				    ?>
				    <div>
				<?php 
				    
				} else
                {
                    echo $row['ip_address'];
                    
                }
				//$geoPlugin_array = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $row['ip_address']) );
			//	echo $geoPlugin_array[geoplugin_city].', '.$geoPlugin_array[geoplugin_region];
				 
				
				
				?></td>

                <td>

            <?php if($row['log_status']=='1' && $row['log_date']==$today) { ?> <div style="color:#000099"> Online </div> <?php } ?>
			 <?php if($row['log_status']=='0') { ?> Logout <?php } ?>		
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