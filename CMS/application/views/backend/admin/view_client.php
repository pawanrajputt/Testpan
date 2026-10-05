<?php
//$query = $this->db->query("SELECT * FROM tt_client where 1=1 and id='".$this->db->escape_str($param2)."'");
//$client_details = $query->row();
?>

<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            
            <div class="panel-body">			
                <form role="form" name="edit_vendor" id="edit_vendor" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/edit_vendor_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Company Details</strong></span>	
</div>

<div class="form-group">
	<div class="col-sm-8"><strong>
	Company Name : <span class="badge badge-idbackground"> <?php echo strtoupper($client_details->company_name);?></strong>
	</div>
	
	<div class="col-sm-4"><strong>
	Company Type : <?php echo strtoupper($client_details->company_type);?></strong>
	</div>	
</div>

<div class="form-group">
	<div class="col-sm-8"><strong>
	Address : <?php echo strtoupper($client_details->address);?>,<?php echo strtoupper($client_details->address_second);?></strong>
	</div>	
	
	<div class="col-sm-4"><strong>
	Landmark : <?php echo strtoupper($client_details->landmark);?></strong>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-3"><strong>
	Pin Code : <?php echo strtoupper($client_details->pincode);?></strong>
	</div>
	
	<div class="col-sm-3"><strong>
	City : <?php echo get_city_name($client_details->city);?></strong>
	</div>
	
	<div class="col-sm-2"><strong>
	State : <?php echo get_state_name($client_details->state);?></strong>
	</div>
	
	<div class="col-sm-2"><strong>
	Country : <?php echo $this->common_options->get_country_name($client_details->country_id);?>  </strong>
	</div>
</div>

<div class="form-group">


<div class="col-sm-3"><strong>
	Landline No : <?php if($client_details->country_code && $client_details->landline_number){ echo '+'.$client_details->country_code.' '; }?>
		<?php if($client_details->area_code && $client_details->landline_number){ echo '('.$client_details->area_code.')'; }?>
		<?php echo $client_details->landline_number;?></strong>
	</div>
	<div class="col-sm-8"><strong>
	Website : <?php echo strtoupper($client_details->website);?></strong>
	</div>	
	
	
</div>


<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Contact Details</strong></span>	
</div>

<div class="form-group">
	<div class="col-sm-3"><strong>
	Name : <?php echo strtoupper($client_details->co_ordinator_name);?></strong>
	</div>

	<div class="col-sm-3"><strong>
	Mobile 1 : <?php echo strtoupper($client_details->mobile_no);?></strong>
	</div>
	
	<div class="col-sm-2"><strong>
	Mobile 2 : <?php echo strtoupper($client_details->mobile_alternate);?></strong>
	</div>
	
	<div class="col-sm-3"><strong>
	Email ID. : <?php echo strtolower($client_details->email_id);?></strong>
	</div>
</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Banking Details</strong></span>	
</div>

<div class="form-group">
	<div class="col-sm-3"><strong>
	GST State : <?php echo ucwords($client_details->gst_state_code);?></strong>
	</div>
	
	<div class="col-sm-3"><strong>
	GSTIN : <?php echo strtoupper($client_details->gst_number);?></strong>
	</div>
	
	<div class="col-sm-2"><strong>
	PAN : <?php echo strtoupper($client_details->pan_number);?></strong>
	</div>
	<div class="col-sm-3"><strong>
	Account Number : <?php echo strtoupper($client_details->bank_account_no);?></strong>
	</div>
	
</div>

<div class="form-group">
	
	<div class="col-sm-6"><strong>
	Beneficiary Name : <?php echo ucwords($client_details->bank_beneficial_name);?></strong>
	</div>
	
	<div class="col-sm-2"><strong>
	IFSC Code : <?php echo ucwords($client_details->bank_ifsc_code);?></strong>
	</div>
	
	<div class="col-sm-4"><strong>
	Bank Name : <?php echo ucwords($client_details->bank_name);?></strong>
	</div>

</div>

<div class="form-group" style="background-color:#17A2B8">
<span style="color:#FFFFFF">	<strong>&nbsp;&nbsp;&nbsp;Document Details</strong></span>	
</div>

<div class="form-group">
	
	<div class="col-sm-4"><strong>
	Upload Cancelled Cheque : <?php if($client_details->bank_doc!=''){ ?>[ &#10004; ]
  <span class="badge badge-idbackground"><a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->bank_doc; ?>"><i class="entypo-eye"></i> View </a></span>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong> 
	</div>
	
	<div class="col-sm-4"><strong>
	Upload Agreement : <?php if($client_details->agreement_doc!=''){ ?>[ &#10004; ]
  <span class="badge badge-idbackground"><a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->agreement_doc; ?>"><i class="entypo-eye"></i> View </a></span>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong> </strong>
	</div>
	
	<div class="col-sm-4"><strong>
	Upload MOU : <?php if($client_details->mou_doc!=''){ ?>[ &#10004; ]
  <span class="badge badge-idbackground"><a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->mou_doc; ?>"><i class="entypo-eye"></i> View </a></span>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong> </strong></strong>
	</div>
    
   

</div>

<div class="form-group">

	 <div class="col-sm-4"><strong>
	Upload GST Certificate : <?php if($client_details->gst_doc!=''){ ?>[ &#10004; ]
  <span class="badge badge-idbackground"><a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->gst_doc; ?>"><i class="entypo-eye"></i> View </a></span>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong>
	</div>
	
	<div class="col-sm-4"><strong>
	Udyam Aadhar Number : <?php echo $client_details->udyam_number; ?></strong> 
	</div>
	
	 <div class="col-sm-4"><strong>
	Upload Udyam : <?php if($client_details->udyam_doc!=''){ ?>[ &#10004; ]
 <span class="badge badge-idbackground"> <a target="_blank" href="<?php echo base_url(); ?>uploads/client_document/<?php echo $client_details->udyam_doc; ?>"><i class="entypo-eye"></i> View </a></span>
    <?php } else { ?> [ &#10006; ]<?php } ?></strong> 
	</div>

</div>


<div class="col-sm-3 control-label col-sm-offset-3" align="right"><br /><br />
	
 <a href="<?php echo base_url(); ?>index.php?admin/manage_client" class="btn btn-success"> << Back</a>
 
</div>

<div class="col-sm-8"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
       </div></div></div>
