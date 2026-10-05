<link href="../../../../assets/css/neon.css" rel="stylesheet" type="text/css">
<button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_manpower_project');" 
    class="btn btn-primary pull-right">
        Add Project
</button>


<div style="clear:both;"></div>
<br>
<form id="myform" name="myform" method="post" action="">
<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />




<table class="table table-bordered datatable color-blue" id="table-2">
    <thead>
        <tr>
            <th width="15%">Exam Name</th>
            <th width="20%">Client Name</th>
            <th width="15%">Exam Date </th>
			<th width="10%">Exam Type</th>
            <th width="25%">Exam Location</th>
			<th width="15%" align="center">Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($all_po_info as $row) { 
		
				
						
						
					
					 
							
		?>  
		
            <tr>
                 <td><?php echo ucwords($row['exam_name']) ?></td>
                 <td><?php echo ucwords($this->common_options->get_client_name($row['client_id'])); ?></td>
				 <td>Start Date:<?php echo ucwords($row['start_date']); ?> <br />End Date: <?php echo ucwords($row['end_date']); ?></td>
                 <td><?php echo ucwords($row['exam_type']); ?></td>
				 <td><?php 
				 $exam_city_ar = json_decode($row['exam_city']);
				// print_r($exam_city_ar);
				 foreach($exam_city_ar as $cityname){ 
				 $count++;
					 	$stateId=$this->common_options->get_state_id($cityname);
			 echo '> '.$city= ucwords($this->common_options->get_city_name($cityname)).' - ['.$this->common_options->get_state_name($stateId).'])'.'<br>';
					   
				 }
               $count='';

                 ?>
                </td>
				 <td align="center"><a href="<?php echo base_url(); ?>index.php?admin/edit_manpower_project/<?php echo $row['id']; ?>" class="btn btn-default btn-sm btn-blue">
                    Edit</a>
                                        
                    <a  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/view_manpower_project/<?php echo $row['id'] ?>');" 
                        class="btn btn-default btn-sm btn-green">
                       
                        View
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
            "sPaginationType": "bootstrap",
            <?php /*?>"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"<?php */?>
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

