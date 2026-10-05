
<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
--> <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            
            <div class="panel-body">
			<div class="form-horizontal form-groups-bordered">			
               <!-- <form role="form" name="edit_center" id="edit_center" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_center_process" method="post" enctype="multipart/form-data">-->
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Details</strong></span>	
</div>

<div class="form-group">

	<div class="col-sm-3"><strong>
	Center Unique Id : <span class="badge badge-idbackground"> <?php echo strtoupper($center_details->region_code);?>-<?php echo strtoupper($center_details->state_code);?>-<?php echo strtoupper($center_details->city_code);?>-<?php echo $center_details->center_id;?></strong>
	</div>
	
	<div class="col-sm-7"><strong>
		Center Name : <span class="badge badge-idbackground"> <?php echo ucwords($center_details->center_name);?></strong>
	</div>
    
      <div class="col-sm-2"><strong>
		Center Type : <span class="badge badge-idbackground"> <?php echo ucwords($center_details->center_type);?></strong>
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-9">
		<strong>Vendor Name : <span class="badge badge-idbackground"> <?php echo ucwords($this->common_options->get_vendorname($center_details->vendor_id));?></strong>
	</div>
    
    <div class="col-sm-3"><strong>
		Udyam Number : <span class="badge badge-idbackground">
        <?php if($center_details->udyam_number){ ?> <?php echo ucwords($center_details->udyam_number);?> <?php } else { ?> [ &#10006; ] <?php } ?>
        </strong>
        <?php if($center_details->udyam_document){?>
      <a href="<?php echo base_url(); ?>uploads/center_document/<?php echo $center_details->udyam_document;?>" target="_blank">&nbsp;&nbsp;<i class="entypo-eye"></i>[View] </a>
       <?php } else { ?>
       [ &#10006; ]
       <?php } ?>
	</div>
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Address</strong></span>	
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>City Code : <?php echo ucwords($center_details->city_code);?></strong>
	</div>
	
	<div class="col-sm-4">
	<strong>City  :  <?php echo ucwords($center_details->city);?></strong>
	</div>

	<div class="col-sm-4">
	<strong>Address1 : <?php echo ucwords($center_details->address);?></strong>
	</div>
	
</div>
	
<div class="form-group">

	<div class="col-sm-4">
	<strong>Address2 : <?php echo ucwords($center_details->address_second);?></strong>
	</div>
	
	<div class="col-sm-4">
	<strong>Landmark  :  <?php echo ucwords($center_details->landmark);?></strong>
	</div>
	
	<div class="col-sm-4">
	<strong>State :  <?php echo ucwords(get_state_name($center_details->state_id));?> </strong>
	</div>
    
    
	
</div>
	
<div class="form-group">

	<div class="col-sm-3">
	<strong>Country : <?php echo ucwords($this->common_options->get_country_name($center_details->country_id));?></strong>
    
	</div>

	<div class="col-sm-3">
	<strong>Pin Code : <?php echo $center_details->pin_code;?></strong>
	</div>

	<div class="col-sm-3">
	<strong>Latitude  :  <?php echo $center_details->address_lat;?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Longitude : <?php echo $center_details->address_long;?> </strong>
	</div>

</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Railway Station to Center</strong></span>	
</div>

<div class="form-group">

	<div class="col-sm-8">
	<strong>Nearest Railway Station Name  :  <?php echo ucwords($center_details->nearest_railway_station);?></strong>
	</div>
	
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Railway Station Latitude : <?php echo $center_details->station_lat;?></strong>
	</div>
	
	<div class="col-sm-4">
	<strong>Railway Station Longitude : <?php echo $center_details->station_long;?></strong>
	</div>
	
	<div class="col-sm-4">
	<strong>Distance from Railway Station : <?php echo $center_details->distance_from_station;?></strong>
	</div>	
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Bus Stand to Center</strong></span>	
</div>

<div class="form-group">

	<div class="col-sm-8">
	<strong>Nearest Bus Station Name : <?php echo ucwords($center_details->nearest_bus_stop);?></strong>
	</div>

</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Bus Station Latitude : <?php echo $center_details->bus_lat;?> </strong>
	</div>
	
	<div class="col-sm-4">
	<strong>Bus Station Longitude :  <?php echo $center_details->bus_long;?></strong>
	</div>
	
	<div class="col-sm-4">
	<strong>Distance from Bus Station : <?php echo $center_details->distance_from_bus_stop;?> </strong>
	</div>	
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Landline Number & Emergency Number</strong></span>	
</div>

<div class="form-group">

	<div class="col-sm-6">
	<strong>Landline No.  : <?php if($center_details->landline_country_code && $center_details->landline_number){ echo '+'.$center_details->landline_country_code.' '; }?>
		<?php if($center_details->landline_area_code && $center_details->landline_number){ echo '('.$center_details->landline_area_code.')'; }?>
		<?php echo $center_details->landline_number;?></strong>
	</div>
	
	<div class="col-sm-3">
		<strong>Emergency Primary  :  <?php if($center_details->emergency_counter_code && $center_details->emergency_contact_no){ echo '+'.$center_details->emergency_counter_code.' '; }?> 
		<?php if($center_details->emergency_contact_no){ echo $center_details->emergency_contact_no; }?></strong>
	</div>
	
	<div class="col-sm-3">
		<strong>Emergency Alternate : <?php if($center_details->emergency_counter_code){ echo '+'.$center_details->emergency_counter_code.' '; }?>
		<?php if($center_details->emergency_number_alternate){ echo $center_details->emergency_number_alternate; }?></strong>
	</div>
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Superintendent</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-6">
	<strong>Center Superintendent Name :  <?php echo ucwords($center_details->cs_name);?> </strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Primary Number :  <?php if($center_details->cs_country_code && $center_details->cs_contact_number){ echo '+'.$center_details->cs_country_code.' '; }?> <?php if($center_details->cs_contact_number){ echo $center_details->cs_contact_number; }?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Alternate Number : <?php if($center_details->cs_country_code){ echo '+'.$center_details->cs_country_code.' '; }?>
	<?php if($center_details->cs_phone_alternate){ echo $center_details->cs_phone_alternate; }?></strong>
	
	</div>
	
</div>

<div class="form-group">

	<div class="col-sm-6">
	<strong>CS Email id  :  <?php echo $center_details->cs_email;?> </strong>
	</div>
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Assistant Manager</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-6">
	<strong>Assistant Manager Name :  <?php echo ucwords($center_details->am_name);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Primary Number :  <?php if($center_details->am_country_code && $center_details->am_contact_no){ echo '+'.$center_details->am_country_code.' '; }?> <?php if($center_details->am_contact_no){ echo $center_details->am_contact_no; }?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Alternate Number : <?php if($center_details->am_country_code){ echo '+'.$center_details->am_country_code.' '; }?>
	<?php if($center_details->am_phone_alternate){ echo $center_details->am_phone_alternate; }?></strong>
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-6">
	<strong>Assistant Email id  :  <?php echo $center_details->am_email;?></strong>
	</div>
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Point of Contact</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-6">
	<strong>Point of Contact Name : <?php echo ucwords($center_details->poc_name);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Primary Number :  <?php if($center_details->poc_country_code && $center_details->poc_contact_no){ echo '+'.$center_details->poc_country_code.' '; }?> <?php if($center_details->poc_contact_no){ echo $center_details->poc_contact_no; }?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Alternate Number : <?php if($center_details->poc_country_code){ echo '+'.$center_details->poc_country_code.' '; }?>
	<?php if($center_details->poc_mobile_alternate){ echo $center_details->poc_mobile_alternate; }?></strong>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-6">
	<strong>POC Email id : <?php echo $center_details->poc_email;?></strong>
	</div>
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Technical Department</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-6">
	<strong>Technical Department Name : <?php echo ucwords($center_details->td_name);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Primary Number :  <?php if($center_details->td_country_code && $center_details->td_contact_no){ echo '+'.$center_details->td_country_code.' '; }?> <?php if($center_details->td_contact_no){ echo $center_details->td_contact_no; }?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Alternate Number : <?php if($center_details->td_country_code){ echo '+'.$center_details->td_country_code.' '; }?>
	<?php if($center_details->td_phone_alternate){ echo $center_details->td_phone_alternate; }?></strong>
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-6">
	<strong>Tech Email id : <?php echo $center_details->td_email;?></strong>
	</div>
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Lab Amenties</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Total System : <?php echo $center_details->total_no_system;?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Total Lab : <?php echo $center_details->total_no_lab;?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Partition : <?php echo ucwords($center_details->partitaion_each_lab);?></strong>
	</div>
	 
    <div class="col-sm-3">
	<strong>Single Network :  <?php echo ucwords($center_details->connected_single_network);?> </strong><br />
     <?php if($center_details->connected_single_network=="no"){ ?>
	
	<strong>No of Network :  <?php echo ucwords($center_details->how_many_network);?> </strong>
	
	<?php } ?>
	</div>
	
</div>
	
<div class="form-group">
	
    <div class="col-sm-3">
	<strong>AC in Each Lab : <?php echo ucwords($center_details->ac_in_each_lab);?></strong>
	</div>

	<div class="col-sm-3">
	<strong>Primary ISP : <?php echo ucwords($center_details->primary_isp_name);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Type : <?php echo ucwords($center_details->primary_isp_bband_or_lease);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Primary Speed : <?php echo $center_details->primary_isp_speed;?></strong>
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-3">
	<strong>Secondary ISP : <?php echo ucwords($center_details->secondary_isp_name);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Type : <?php echo ucwords($center_details->secondary_isp_bband_or_lease);?></strong>
	</div>

	<div class="col-sm-3">
	<strong>Secondary Speed : <?php echo $center_details->secondary_isp_speed;?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Generator (KVA) : <?php echo $center_details->power_backup_generator_kv;?></strong>
	</div>
		
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>UPS (KVA) : <?php echo $center_details->power_back_ups_kv;?></strong>
	</div>
		
	<div class="col-sm-3">
	<strong>Backup Unit : <?php echo $center_details->power_backup_hour;?> <?php echo $center_details->power_backup_unit;?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>CCTV DVR : <?php echo ucwords($center_details->cctv_dvr);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Network Printer : <?php echo ucwords($center_details->network_printer);?></strong>
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-3">
	<strong>Drinking Water : <?php echo ucwords($center_details->drinking_water_facility);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Projector & Sound System : <?php echo ucwords($center_details->projector_sound_system);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Fire Extinguisher : <?php echo ucwords($center_details->fire_extinguisher);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Locker Facility : <?php echo ucwords($center_details->locker_facility);?></strong>
	</div>

</div>

<?php
	$result = 1;
	foreach ($labDetail as $row) { 
	$count= $result;
	
?>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;<?php echo $count; ?>. Lab Matrix</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Lab Name :  <?php echo ucwords($row['lab_name']);?></strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>Floor Name  : <?php echo ucwords($row['floor_name']);?></strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>Total System :  <?php echo ucwords($row['no_of_computer']);?></strong><br />
	</div>
	
    <div class="col-sm-3">
	<strong>AC [Count] : <?php echo ucwords($row['no_of_ac']);?></strong><br />
	</div>

</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Monitor Type : <?php echo ucwords($row['monitor_type']);?></strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>Operating Sysytem  : <?php echo ucwords($row['operating_system']);?> </strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>Processor :  <?php echo ucwords($row['processor']);?> </strong><br />
	</div>
	
    <div class="col-sm-3">
	<strong>RAM : <?php echo ucwords($row['ram']);?> </strong><br />
	</div>

</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Hard Disk : <?php echo ucwords($row['hard_disk']);?></strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>CPU Model No  : <?php echo ucwords($row['model_no']);?> </strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>Ethernet Switch : <?php echo ucwords($row['no_of_ethernet_switch']);?> </strong><br />
	</div>
	
    <div class="col-sm-3">
	<strong>Ethernet [Port] : <?php echo ucwords($row['no_of_port_eth_switch']);?></strong><br />
	</div>

</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Switch Manage : <?php echo ucwords($row['switch_manage_status']);?> </strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>Lan Speed : <?php echo ucwords($row['lan_speed']);?> </strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>Ethernet Switch : <?php echo ucwords($row['ehternet_swtch_company']);?> </strong><br />
	</div>
	
    <div class="col-sm-3">
	<strong>Ethernet Switch [Model] : <?php echo ucwords($row['model_no_etherbet_swtch']);?> </strong><br />
	</div>

</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>UPS Connected : <?php echo ucwords($row['ups_connected']);?>  </strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>Partitation  : <?php echo ucwords($row['partitation']);?> </strong><br />
	</div>
	
	<div class="col-sm-3">
	<strong>CCTV [Count]:  <?php echo ucwords($row['no_of_cctv_each_lab']);?></strong><br />
	</div>
	
    <div class="col-sm-3">
	<strong>Fan [Count] : <?php echo ucwords($row['no_of_fan']);?> </strong><br />
	</div>

</div>

<?php $result++; } ?>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Entry Point</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Parking Facility : <?php echo ucwords($center_details->parking_facility);?></strong>
	</div>

	<div class="col-sm-3">
	<strong>Entry Point : <?php echo $center_details->entry_point;?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Exit Point : <?php echo $center_details->exit_point;?></strong>
	</div>

	<div class="col-sm-3">
	<strong>Guard [Male] :<?php echo $center_details->security_guard_male;?></strong>
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-3">
	<strong>Guard [Female] :<?php echo $center_details->security_guard_female;?></strong>
	</div>

	<div class="col-sm-3">
	<strong>Water Facility : <?php echo ucwords($center_details->drinking_water_facility);?></strong>
	</div>

	<div class="col-sm-3">
	<strong>Waiting [Parents] :<?php echo ucwords($center_details->parents_waiting_hall);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Waiting [Candidate] :<?php echo ucwords($center_details->candidates_waiting_hall);?></strong>
	</div>
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Category of Center</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-3">
	<strong>Type of Center : <?php echo ucwords($this->common_options->get_center_type($center_details->type_of_center));?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Approved By : <?php echo ucwords($center_details->center_approved_by);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Affiliation : <?php echo ucwords($center_details->center_affiliation_by);?></strong>
	</div>
	
	<div class="col-sm-3">
	<strong>Establish of Lab Year : <?php echo ucwords($center_details->center_lab_establish_year);?></strong>
	</div>
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Center Experience in Exam</strong></span>
</div>

<div class="form-group">

	<div class="col-sm-4">
	<strong>Client Name :  <?php echo ucwords($center_details->center_client_name);?></strong>
	</div>
	
	<div class="col-sm-4">
	<strong>Exams Name  :  <?php echo ucwords($center_details->center_prev_exam_name);?></strong>
	</div>
	
	<div class="col-sm-4">
	<strong>Feedback :  <?php echo ucwords($center_details->feedback);?></strong>
	</div>
	
</div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Image Gallery</strong></span>
</div>




<div class="form-group">	
<div class="container box">
  <h3 align="center">Center Images</h3>
  <br />
  <form method="post" name="imgfrm" id="imgfrm" action="<?php echo base_url(); ?>index.php?admin/createzip">
  <input name="id" type="hidden" value="<?php echo $center_details->id; ?>" />
  <input name="center_id" type="hidden" value="<?php echo strtoupper($center_details->region_code);?>-<?php echo strtoupper($center_details->state_code);?>-<?php echo strtoupper($center_details->city_code);?>-<?php echo $center_details->center_id;?>" />
  
  
  <?php
  foreach($center_images as $image)
  {
  		$ctImg = $rowimg['center_image'];
   echo '
   <div class="col-md-2" align="center" style="margin-bottom:24px;">
   
   <a onclick="showAjaxModal('.base_url().'index.php?modal/popup/center_image_viewer/'.$image['center_image'].'">
   
    <img src="'.base_url().'uploads/center_image/'.$image['center_image'].'" class="img-thumbnail img-responsive" style="height:100px; width:100%; border:medium; margin:5px; padding:5px; border:1px" alt="Center Image" /></a>
     <br />
    <input type="checkbox" name="but_createzip1[]" class="select" value="'.$image['center_image'].'"  />
   </div>
   ';
  }
  ?>
  
  </div>
  <div class="container box">
  <div align="center">
   <input type="submit" name="download" class="btn btn-primary" value="Download" />
  </div>
  </div><br />
  </form>
 </div>	
</div>
<div style="clear:both;"></div>
				
<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Documents Gallery</strong></span>
</div>
<div class="form-group">	

<?php foreach ($center_doc as $rowdoc) { ?>   
	<div class="col-sm-2">
    	
		
			<?php if($rowdoc['doc_name']!=''){ ?> <a  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/center_image_viewer/<?php echo $rowdoc['doc_name'] ?>');">
                <img src="<?php echo base_url(); ?>assets/images/docimg.png" style="height:50px; width:50px; margin:5px; padding:5px; border:1px" alt="Doc Image" title="Doc Image"/> 
                    </a>	 <?php } ?>	
		
		
		
		
	</div>
<?php } ?>   
   
</div>

 <div style="clear:both;"></div>

<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Video Gallery</strong></span>
</div>
<div class="form-group">	

<?php foreach ($center_video as $row_video) { ?>   
	<div class="col-sm-3">
    	
		<iframe src="<?php echo base_url(); ?>uploads/center_video/<?php echo $row_video['center_video']; ?>" title="description" width="200px;"></iframe>
		<p><?php echo ucwords($row_video['about_video']);?></p>
		
	</div>
<?php } ?>    
   
</div>

<div style="clear:both;"></div>


<div class="col-sm-4 control-label col-sm-offset-2" align="right"><br /><br />
	
 <a href="<?php echo base_url(); ?>index.php?admin/center_listing" class="btn btn-success"> Back</a>


</div> 
          </div>     <!-- </form>-->
            </div>

        </div>

    </div>
</div>
<script src="assets/js/bootstrap-multiselect.js"></script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function shownetwork(str){
	if($(str).is(':checked')){
		$("#no_of_network_div").show();
		loadOtherDepartment();
	}else{
		$("#no_of_network_div").hide();
	}
}
function hidenetwork(str){
	if($(str).is(':checked')){
		$("#no_of_network_div").hide();
		loadOtherDepartment();
	}else{
		$("#no_of_network_div").hide();
	}
}

</script>


<style>
* {
  box-sizing: border-box;
}

.zoom {
  padding: 50px;
  transition: transform .2s;
  width: 200px;
  height: 200px;
  margin: 0 auto;
}

.zoom:hover {
  -ms-transform: scale(4.5); /* IE 9 */
  -webkit-transform: scale(4.5); /* Safari 3-8 */
  transform: scale(4.5); 
}
</style>

<script>
$(document).ready(function(){
 $('.select').click(function(){
  if(this.checked)
  {
   $(this).parent().css('border', '5px solid #ff0000');
  }
  else
  {
   $(this).parent().css('border', 'none');
  }
 });
});
</script>
