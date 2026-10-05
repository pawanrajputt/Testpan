<?php
	$pageUrl=$_SERVER['REQUEST_URI']; 
	$newUrl=parse_url($pageUrl);
	$aurl=$newUrl[query];
	$hlink=explode('/',$aurl);
	$projId=base64_decode($hlink[2]);
	$project_query = $this->db->query("SELECT * FROM tt_exam_notification WHERE 1=1 AND project_id='".$projId."'")->row();
	 '<br>EX1= '.$project_name = $project_query->exam_name;
	'<br>EX1= '.$examn_date = $project_query->exam_date;
	'<br>EX1= '.$req_seat = $project_query->required_seat;
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
	<form role="form" name="nofify_form" id="nofify_form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/notification_send_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />				
				<input type="hidden" name="project_id" id="project_id" value="<?php echo $projId; ?>" />
				<input type="hidden" name="project_name" id="project_name" value="<?php echo $project_name; ?>" />
				<input type="hidden" name="examn_date" id="examn_date" value="<?php echo $examn_date; ?>" />
                <input type="hidden" name="req_seat" id="req_seat" value="<?php echo $req_seat; ?>" />
                
<table class="table table-striped datatable" id="table" align="center">  
    <tr>
        <td width="20%">        
        <div class="form-group">
	<label for="field-1" class="col-sm-1 control-label">Title<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-3">
		<input type="text" name="title" class="form-control" id="title" value="<?php echo $mp_details->title;?>" maxlength="20" placeholder="Title" >
	</div>
		<label for="field-1" class="col-sm-1 control-label">Message<em style="color:#C00;">*</em> : </label>
	<div class="col-sm-4">
		<input type="text" name="message" class="form-control" id="message" placeholder="Message" maxlength="50" value="<?php echo $mp_details->message;?>" >
	</div>
    <div class="col-sm-1">
		<input type="button" name="save_btn" id="save_btn" class="btn" onClick="saveFrmDetails('nofify_form','save_btn')" value="Send Notification" style="background-color: #03a9f4; color: white; width:150px; font-size:15px;">
		
		
		
		<p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p>
		                                               

</div>
</td></tr></table>
<table class="table table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th width="15%" style="background-color:#0099ff; color:#FFF; text-align:center">City Name</th>
<!--            <th width="15%" style="background-color:#093; color:#FFF; text-align:center">Reqired Seat</th>
-->         <th width="45%" style="background-color:#0099ff; color:#FFF; text-align:center">Center Name</th>
			<th width="10%" style="background-color:#0099ff; color:#FFF; text-align:center">Capacity</th>
			<th width="10%" style="background-color:#0099ff; color:#FFF; text-align:center">Labs</th>
			<th width="10%" style="background-color:#0099ff; color:#FFF; text-align:center">Available Seat</th>
			<th width="10%" style="background-color:#0099ff; color:#FFF; text-align:center">Notification</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($manage_notification_infos as $row) {
		$reqired_seat='';
		$reqired_system='';
		$total_lab='';
		
		$req_qry = $this->db->query("SELECT * FROM tt_exam_notification WHERE 1=1 AND project_id='".$projId."' and exam_city_id='".$row['city_id']."'")->row();							
		$reqired_seat = $req_qry->required_seat;
		$notificationId = $req_qry->id;

		$lab_qry = $this->db->query("SELECT SUM(no_of_computer) as totalsystem FROM tt_lab where center_id='".$row['id']."' and deleted=0")->row();	   
		$reqired_system = $lab_qry->totalsystem;
	

		$lab__count_qry = $this->db->query("SELECT count(id) as total_lab FROM tt_lab where center_id='".$row['id']."' and deleted=0")->row();	   
		$total_lab = $lab__count_qry->total_lab;
		
		'<br>A='.$row['center_id'];
		
		$seat_query = $this->db->query("SELECT id,total_seat FROM tt_exam_booking_detail WHERE 1=1 AND center_id='".$row['id']."' and  city_id='".$row['city_id']."' and exam_date='".$examn_date."' and deleted=0")->row();
		
		//echo '<br>QRY='.$ss = "SELECT id,total_seat FROM tt_exam_booking_detail WHERE 1=1 AND center_id='".$row['center_id']."' and  city_id='".$row['city_id']."' and exam_date='".$examn_date."' and deleted=0";
		$bookedSeat= $seat_query->total_seat;
		$availableSeat=$reqired_system-$bookedSeat;
		
		
		
 ?>		
            <tr>
                <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo get_city_name($row['city_id']); ?></td>
<!--                 <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo $row['center_id']; ?></td>
-->                <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo ucwords($row['center_name']); ?> </td>
				  <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo $reqired_system; ?></td>
				    <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo $total_lab; ?></td>
				    <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center"><?php echo $availableSeat; ?>&nbsp;</td>
					  <td style="color: #033; font-family:Verdana, Geneva, sans-serif; text-align:center">                      
					    <input name="notify[]" type="checkbox" value="<?php echo ucwords($row['id']); ?>_<?php echo $notificationId; ?>" />          
					    <!--<input name="notifyId[]" type="text" value="<?php echo ucwords($row['id']); ?>_<?php echo $notificationId; ?>" />-->   
				      </td>   
					   
            </tr>	
       
		
	<?php } ?>	
		
       
    </tbody>
</table>
</form>
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