<?php
	$pageUrl=$_SERVER['REQUEST_URI']; 
	$newUrl=parse_url($pageUrl);
	$aurl=$newUrl[query];
	$hlink=explode('/',$aurl);
	$projId=base64_decode($hlink[2]);


	$project_query = $this->db->query("SELECT * FROM tt_project_detail WHERE 1=1 AND project_id='".$projId."'")->row();
	 '<br>EX1= '.$project_name = $project_query->exam_name;
	'<br>EX2= '.$cleint_id = $project_query->client_id;
	 '<br>EX3= '.$client_name = $project_query->client_name;
	
	$manage_project_info;
  	$centerCount= count($manage_project_info);
	
?>

<style>
.blinking{
    animation:blinkingText 1.0s infinite;
}
@keyframes blinkingText{
    0%{     color: #000;    }
    49%{    color: transparent; }
    50%{    color: transparent; }
    99%{    color:transparent;  }
    100%{   color: #000;    }
}
</style>
<div style="clear:both;"></div>
<br>
	
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input type="hidden" name="project_id" id="project_id" value="<?php echo $projId; ?>" />
				<input type="hidden" name="project_name" id="project_name" value="<?php echo $project_name; ?>" />
				<input type="hidden" name="cleint_id" id="cleint_id" value="<?php echo $cleint_id; ?>" />
				<input type="hidden" name="client_name" id="client_name" value="<?php echo $client_name; ?>" />

<table class="table table-striped datatable" id="table-2">


    <thead>
        <tr>
            <th width="10%" style="background-color:#0099ff; color:#FFF; text-align:center">City Name</th>
<!--            <th width="15%" style="background-color:#093; color:#FFF; text-align:center">Reqired Seat</th>
-->            <th width="60%" style="background-color:#0099ff; color:#FFF; text-align:center">Center Name</th>
			<th width="10%" style="background-color:#0099ff; color:#FFF; text-align:center">Total System</th>
			<th width="10%" style="background-color:#0099ff; color:#FFF; text-align:center">Total Lab</th>
			<th width="10%" style="background-color:#0099ff; color:#FFF; text-align:center">Action</th>
        </tr>
    </thead>

    <tbody>
	
<?php foreach ($manage_project_infos as $row) {
		$reqired_seat='';
		$reqired_system='';
		$total_lab='';
		$req_qry = $this->db->query("SELECT * FROM tt_project_detail WHERE 1=1 AND project_id='".$projId."' and exam_city_id='".$row['city_id']."'")->row();	   		$reqired_seat = $req_qry->exam_required_seat;
		//$reqired_day = $req_qry->exam_req_days;

		$lab_qry = $this->db->query("SELECT SUM(no_of_computer) as totalsystem FROM tt_lab where center_id='".$row['id']."' and deleted=0")->row();	   
		$reqired_system = $lab_qry->totalsystem;
	

		$lab__count_qry = $this->db->query("SELECT count(id) as total_lab FROM tt_lab where center_id='".$row['id']."' and deleted=0")->row();	   
		$total_lab = $lab__count_qry->total_lab;
		
		'<br>A='.$row['center_id'];
 ?>		
            <tr>
                <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo get_city_name($row['city_id']); ?></td>
<!--                 <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo $reqired_seat; ?></td>
-->                <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo ucwords($row['center_name']); ?> </td>
				  <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo $reqired_system; ?></td>
				    <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo $total_lab; ?></td>
					  <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">                      
       <a href='<?php echo base_url() ?>index.php?c=admin&m=center_booking&ct=<?php echo $row['city_id'];?>&pf=<?php echo $projId; ?>&cct=<?php echo $row['id'];?>'  target="_blank" class="btn btn-green btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>Book</a>               
                      
                      
                      </td>   
					   
            </tr>	
       
		
	<?php } ?>	
		
       
    </tbody>
</table>
</div>
	



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
    });
</script>