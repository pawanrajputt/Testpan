<!--<style>
input,textarea,select,.multiselect{border:1px solid #afdae2; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color:#6A6969;}
.multiselect{
	width:470px;
	padding:4px;
	height:96px;
	overflow-x:hidden;
	overflow-y:auto;
}
.multiselect{background-color:#eef3f4;}

</style>-->

<?php
$gstNumber=$user_details->gst_number;
$gstdel = substr($gstNumber, 0, 2);


?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<style type="text/css">
.multiselect {
    width:30em;
    height:15em;
    border:solid 1px #c0c0c0;
    overflow:auto;
}
 
.multiselect label {
    display:block;
}
 
.multiselect-on {
    color:#ffffff;
    background-color:#ACBA91;
}
.hintPanda{display:none; visibility:hidden;}

input[type="radio"]:checked+label { font-weight: bolder; color: #007a7a }
.row .col-md-12 .panel.panel-primary .panel-body #add_project .form-group .col-sm-12 table {
	font-weight: bold;
}
</style>






<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body" style="font-weight: bold;">			
                <form role="form" name="add_purchase_order" id="add_purchase_order" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_purchase_order_confirm_process" method="post" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input name="oid" type="hidden" value="<?php echo $user_details->id; ?>" />
                    
<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:6px">	<strong>&nbsp;&nbsp;&nbsp;</strong></span>
	
</div>
 
<div id="printableArea">

<div class="form-group">
  <div class="col-sm-12">
  <img align="left" src="<?php echo base_url(); ?>assets/images/logofe.png"  style="max-height:70px;"   alt="logo" title="Testpan logo"/>
   <img align="right" src="<?php echo base_url(); ?>assets/images/logo.png"  style="max-height:70px;"   alt="logo" title="Testpan logo"/>
	</div>

	
</div>
                    

<div class="form-group">
	<div class="col-sm-4">
		<strong>Telephone</strong>
		<p>+91-11-28520481<br />
           +91-11-44748200</p>
	</div>
	
	<div class="col-sm-4">
		<strong>Email</strong>
		<p>finance@testpanindia.com</p>
	</div>
    
    <div class="col-sm-4">
		<strong>Address</strong>
		<p>WZ-1390/7,IInd Floor, Above MTNL Exchange) Pankha Road,Nangal Raya,New Delhi 110046, India</p>
	</div>
</div>


<div class="form-group" style="border:thin; background-color:#FCF">
	<div class="col-sm-12" align="center" style="background-color:#FCF">
		<h4><strong>PURCHASE ORDER</strong></h4>
		
	</div>
</div>


<div class="form-group">

	
<!--</div>
<div class="form-group">-->
	<div class="col-sm-12" >
	<!--<label for="field-1" class="col-sm-2 control-label">Name: </label>-->
	<table width="100%" border="0" cellspacing="3">
  <tr >
    <td width="52%" rowspan="6" valign="top">TESTPAN India Private Limted<br />WZ-1390/7,IInd Floor, Above MTNL Exchange) <br /> Pankha Road,Nangal Raya,
    <br />New Delhi 110046, India <br />
    GSTIN:07AAFCT9560Q1ZG
    
    
    </td>
    <td width="16%">&nbsp;&nbsp;&nbsp;P. O. Number</td>
    <td colspan="3"><!--<label for="field-1" class="col-sm-2 control-label">P.O. Number: </label>-->
	<label>&nbsp;&nbsp;&nbsp;TIPL/2023-24/<?php echo $user_details->id;?></label>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;P.O. Date</td>
    <td colspan="3"><input type="date" name="po_date" class="form-control" id="po_date" placeholder="" value="<?php echo $user_details->po_date;?>" disabled="disabled" style="background-color:#FFF; height:30px"></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr>
    <td height="35">&nbsp;&nbsp;&nbsp;Type of Services</td>
    <td colspan="3"><select name="service_type" class="form-control" disabled="disabled" style="background-color:#FFF; height:30px">
      <option value="1" <?php if($user_details->service_type==1){ ?> selected="selected"<?php } ?>>TESTCENTER SERVICES</option>
      <option value="2" <?php if($user_details->service_type==2){ ?> selected="selected"<?php } ?>>Manpower</option>
      <option value="3" <?php if($user_details->service_type==3){ ?> selected="selected"<?php } ?>>Miscellaneous</option>
    </select></td>
  </tr>
  <tr>
    <td height="41">&nbsp;&nbsp;&nbsp;Assessment Name</td>
    <td colspan="3"><input type="text" name="assesement_name" class="form-control" id="assesement_name" placeholder="" value="<?php echo $user_details->assesement_name;?>" disabled="disabled" style="background-color:#FFF; text-transform:uppercase; height:30px"></td>
  </tr>
  
  <tr>
    <td height="33">&nbsp;&nbsp;&nbsp;Assessment Date</td>
    <td width="13%"><input type="date" name="assesment_date_from" class="form-control" id="assesment_date_from" placeholder="" value="<?php echo $user_details->assesment_date_from;?>" disabled="disabled" style="background-color:#FFF; height:30px"></td>
    <td width="4%" align="center"> To</td>
    <td width="15%"><input type="date" name="assesment_date_to" class="form-control" id="assesment_date_to" placeholder="" value="<?php echo $user_details->assesment_date_to;?>" disabled="disabled" style="background-color:#FFF; height:30px" /></td>
  </tr>
</table>
		
        
        <table width="100%" border="0" cellspacing="3">
  <tr style="background-color:#FCF">
    <td height="" colspan="4" align="center" valign="top" style="background-color:#FCF"><hr style="margin-top:3px; margin-bottom:4px" />Supplier Details <hr style="margin-top:4px; margin-bottom:3px" />
     </td>
    </tr>
  <tr>
    <td width="12%" rowspan="3" valign="middle" nowrap="nowrap">&nbsp;&nbsp;&nbsp;Name &amp; Address</td>
    <td width="39%" rowspan="3" valign="bottom">
      <textarea name="name_address" id="name_address" cols="45" rows="4" class="form-control" disabled="disabled" style="background-color:#FFF; text-transform:uppercase"><?php echo $user_details->name_address;?></textarea></td>
    <td width="17%" height="36">&nbsp;&nbsp;&nbsp;Contact Person Name</td>
    <td width="32%"><input type="text" name="contact_person_name" class="form-control" id="contact_person_name" placeholder="" value="<?php echo $user_details->contact_person_name;?>" disabled="disabled" style="background-color:#FFF; text-transform:uppercase; height:30px"></td>
  </tr>
  <tr>
    <td height="30">&nbsp;&nbsp;&nbsp;Contact No.</td>
    <td><input type="text" name="contact_number" class="form-control" id="contact_number" placeholder="" value="<?php echo $user_details->contact_number;?>" disabled="disabled" style="background-color:#FFF; height:30px"></td>
    </tr>
  <tr>
    <td height="29" colspan="2"><table cellspacing="0" cellpadding="0">
      <tr>
        <td width="979" colspan="3" align="center">&nbsp;&nbsp;&nbsp;Terms of Delivery</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="32" valign="top">&nbsp;&nbsp;&nbsp;GSTIN : </td>
    <td valign="center"><input type="text" name="gst_number" class="form-control" id="gst_number" placeholder="" value="<?php echo $user_details->gst_number;?>" disabled="disabled" style="background-color:#FFF; text-transform:uppercase; height:30px"></td>
    <td colspan="2" align="center">Immediate</td>
    </tr>
  <tr>
    <td colspan="4" valign="top">&nbsp;</td>
    </tr>
   <!-- <div style="clear:both;"></div> -->
  <tr>
    <td colspan="4" valign="top">
     <table width="100%" border="1" id="dynamic_field">
  <tr style="background-color:#FCF">
    <td width="10%" align="center" valign="top"> S.N.</td>
    <td valign="top" width="40%">&nbsp;&nbsp;&nbsp;Description</td>
    <td width="10%">&nbsp;&nbsp;&nbsp;Quantity</td>
    <td width="10%">&nbsp;&nbsp;&nbsp;No. of Day</td>
    <td width="15%">&nbsp;&nbsp;&nbsp;Rate (&#x20B9;)</td>
    <td colspan="15" width="15">&nbsp;&nbsp;&nbsp;Amount (&#x20B9;)</td>
    
  </tr>
  
   <?php $count=0; foreach($po_order_info as $u){ $count++;  ?>
 <tr>
    <td width="10%" align="center" valign="top"><?php echo $count; ?></td>
    <td valign="top" width="40%"><textarea name="description[]" cols="45" rows="2" class="form-control" disabled="disabled" style="background-color:#FFF; text-transform:uppercase"><?php echo $u['description'];?></textarea></td>
    <td width="10%"><input type="text" name="quantity[]" class="form-control" id="" placeholder="" value="<?php echo $u['quantity'];?>" disabled="disabled" style="background-color:#FFF"></td>
    <td width="10%"><input type="text" name="no_of_days[]" class="form-control" id="" placeholder="" value="<?php echo $u['no_of_days'];?>" disabled="disabled" style="background-color:#FFF"></td>
    <td width="15%"><input type="text" name="rate[]" class="form-control" id="" placeholder="" value="<?php echo $u['rate'];?>" disabled="disabled" style="background-color:#FFF"></td>
    <td width="13%"><input type="text" name="amount[]" class="form-control" id="" placeholder="" value="<?php echo $u['amount'];?>" disabled="disabled" style="background-color:#FFF"></td>
    <td width="2%" align="center" class="btn-orange">
   
    <?php if($user_details->confirm_po==1){?>
    <a href="<?php echo site_url('admin/remove_order/'.$u['id']);?>" title="Remove" onclick="return confirm('Are you sure you want to delete this item?');" class="btn-orange" style="height:25px; width:25px">X</a><br /><?php } ?></td>
  </tr>
 <?php } ?>
 
 
 </table>
    
    
    </td>
  </tr>
  
  <tr>
    <td colspan="4" valign="top">
    <table width="100%" border="1">
 <tr>
   <td colspan="6" valign="top" style="background-color:#0CF;" height="5px">&nbsp;</td>
   </tr>
 <tr>
   <td  width="10%" valign="top">&nbsp;</td>
   <td width="40%" align="right" valign="top">Amount:</td>
   <td width="10%">&nbsp;</td>
   <td width="10%">&nbsp;</td>
   <td width="15%" align="right">&#x20B9;&nbsp;&nbsp;</td>
   <td width="15%">&nbsp;&nbsp;&nbsp;<?php echo $user_details->amount;?></td>
   </tr>
    <?php 
	if($gstNumber!='')
	{
		if($gstdel==07 or $gstdel==7){ ?>
 <tr>
   <td valign="top">&nbsp;</td>
   <td align="right" valign="top">CGST @9%:</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td align="right">&#x20B9;&nbsp;&nbsp;</td>
   <td>&nbsp;&nbsp;&nbsp;<?php echo ($user_details->gst_amount)/2;?></td>
 </tr>
 <tr>
   <td valign="top">&nbsp;</td>
   <td align="right" valign="top">SGST @9%:</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td align="right">&#x20B9;&nbsp;&nbsp;</td>
   <td>&nbsp;&nbsp;&nbsp;<?php echo ($user_details->gst_amount)/2;?></td>
 </tr>
 <?php } ?>
 <?php if($gstdel!=07 or $gstdel!=7){ ?>
 <tr>
    <td  width="10%" valign="top">&nbsp;</td>
   <td width="39%" align="right" valign="top">IGST @18%:</td>
   <td width="10%">&nbsp;</td>
   <td width="10%">&nbsp;</td>
   <td width="15%" align="right">&#x20B9;&nbsp;&nbsp;</td>
   <td>&nbsp;&nbsp;&nbsp;<?php echo $user_details->gst_amount;?></td>
   </tr>
<?php } }?>
 <tr>
   <td  width="10%" valign="top">&nbsp;</td>
   <td width="39%" align="right" valign="top">Total Amount:</td>
   <td width="10%">&nbsp;</td>
   <td width="10%">&nbsp;</td>
   <td width="15%" align="right">&#x20B9;&nbsp;&nbsp;</td>
   <td>&nbsp;&nbsp;&nbsp;<?php echo $user_details->total_amount;?></td>
   </tr>
 
 
 
 </table></td>
  </tr>
  <tr>
    <td colspan="4" valign="top"><table cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="7" width="2028">&nbsp;&nbsp;&nbsp;In Words: <?php echo strtoupper($this->common_options->convert_number($user_details->total_amount));?> Only</td>
        </tr>
      </table></td>
  </tr>
  <tr style="background-color:#FFFF">
    <td colspan="4" align="right" valign="top">For Testpan India Private Limited </td>
    </tr>
  <tr style="background-color:#FFFF">
    <td colspan="4" align="right" valign="top"><p>&nbsp;</p>
      <p><?php if($user_details->service_type==1){ ?> <img align="" src="<?php echo base_url(); ?>assets/images/sign_tc.jpg"  style="max-height:110px;"   alt="Authorised Signature" title="Testpan logo"/> <?php } ?><?php if($user_details->service_type==2 or $user_details->service_type==3){ ?> <img align="" src="<?php echo base_url(); ?>assets/images/sign_mm.jpg"  style="max-height:110px;"   alt="Authorised Signature" title="Testpan logo"/> <?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <p>Authorised Signature&nbsp;&nbsp;&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="4" valign="top">Declaration:  Testpan will be entitled to withhold payment against all subsequent invoices submitted by the Supplier/Service Provider, if the  Supplier/Service Provider by the tax authorities on Testpan for the tax amount already recovered by the Supplier/Service Provider along with interest and penalty defaults in payment of taxes recovered from Testpan with the tax authorities within the due date and any claims by the tax authorities on Testpan for the tax amount already recovered by the Supplier/Service Provider along with interest and penalty  and/or any rejection of input tax credit request of Testpan by the tax authorities.Provided the said tax liability will be recovered by Testpan   from the Supplier/Service Provider either from his outstanding invoices if available or by raising a debit note, in case the Supplier/Service Provider fails and/or neglects to make full payment of said tax amounts including interest and/or penalty to the tax authorities and submits  the tax paid challans as proof of discharge of the tax liability to Testpan, within thirty (30) days upon receipt of notice in writing from Testpan. </td>
    </tr>
  
</table>
	</div>
   
</div>

 	<script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		$('#dynamic_field').append('<tr id="row'+i+'"><td valign="top" align="center">'+i+'</td><td valign="top"><input type="text" name="description[]" class="form-control" id="" placeholder="" ></td><td><input type="text" name="quantity[]" class="form-control" id="" placeholder="" ></td><td><input type="text" name="no_of_days[]" class="form-control" id="" placeholder="" ></td><td><input type="text" name="rate[]" class="form-control" id="" placeholder="" ></td><td width="12%"><input type="text" name="amount[]" class="form-control" id="" placeholder="" ></td><td width="3%" align="center"><button type="button" name="remove" id="'+i+'" class="btn-danger btn_remove" style="height:25px; width:25px">X</button></td></td></tr>');
	});
	
	 
	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
});
</script>












 












 <div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp</strong></span>
</div>   
 </div>
       

    <div class="col-sm-5 control-label col-sm-offset-2"> <?php if($user_details->confirm_po==1){?>
        <input type="button" name="save_btn" id="save_btn" class="btn btn-orange" onClick="saveFrmDetails('add_purchase_order','save_btn')" value="Confirm Order & Submit"\>
       
     
        <a href="<?php echo site_url('admin/modify_po_order/'.$user_details->id);?>" title="Modify" class="btn btn-orange">Modify PO</a>
       <?php } ?> 
       
        <button type="button" onclick="history.back();" class="btn btn-orange"> Close</button>
         <?php if($user_details->confirm_po==2){?>
        <input type="button" onclick="printDiv('printableArea')" value="Print Invoice" class="btn btn-space btn-primary" />
        <?php }  ?>
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
               </form>
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

$(document).ready(function(){
	//keep data in d/m/y format
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy'/*,
		startDate: '-3d'*/
	})
});

</script>

<script type="text/javascript">
        $(function () {
            $("#adisel").change(function () {
               if ($(this).val() == "0") {
                   
                } else {
					$("#divexbatch1").hide();
                    $("#divexbatch2").hide();
					$("#divexbatch3").hide();
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
			  
			  
			    if ($(this).val() == "1") {
                    $("#divexbatch1").show();
                } else {
                    $("#divexbatch2").hide();
					$("#divexbatch3").hide();
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "2") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
                } else {
					$("#divexbatch3").hide();
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "3") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
					$("#divexbatch3").show();
                } else {
					$("#divexbatch4").hide();
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "4") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
					$("#divexbatch3").show();
					$("#divexbatch4").show();
                } else {
					$("#divexbatch5").hide();
                }
				if ($(this).val() == "5") {
                    $("#divexbatch1").show();
					$("#divexbatch2").show();
					$("#divexbatch3").show();
					$("#divexbatch4").show();
					$("#divexbatch5").show();
                } else {
					
                }
            });
        });
		
		/////show hide
	function shownetwork1(str){
	if($(str).is(':checked')){
		$("#govt_job_div").show();
		$("#pvt_job_div").hide();
	}}
	function shownetwork2(str){
		if($(str).is(':checked')){
			$("#pvt_job_div").show();
			$("#govt_job_div").hide();
	}}

	function exammodes1(str){
	if($(str).is(':checked')){
		$("#internet_div").show();
		$("#server_div").hide();
		$("#server_div1").hide();
	}}
	function exammodes2(str){
		if($(str).is(':checked')){
			$("#server_div").show();
			$("#server_div1").show();
			$("#internet_div").hide();
	}}	
		
	function cctvhdsh1(str){
	if($(str).is(':checked')){
		$("#cctvclp").show();
	}}
	function cctvhdsh2(str){
		if($(str).is(':checked')){
			$("#cctvclp").hide();
	}}	
    </script>
	
<!--<script type="text/javascript"> 
	
function showMe (it) { 
	
var cnt=$('.citybox').html();
//alert(cnt.indexOf('div'+it));
if(cnt.indexOf('div'+it)>0){
$('#div'+it).remove();
}
else
{
	var myJavascriptVar = it;
	var inputElems = document.querySelectorAll("input:checked").length;
	
	<?php 
	//	$counts='';
	//	$myPhpVar =  "'+it+'";
	//	$counts="'+inputElems+'";
	?>

	
           $('.citybox').append('<div class="form-group row" id="div'+it+'" style="display: block;"><div class="col-sm-1"><strong><?php  // echo $counts ?> </strong><input type="hidden" name="exam_city_name[]" class="form-control" id="exam_city_name" value="'+ it +'" ></div><div class="col-sm-2"><strong>City :     <?php // echo $myPhpVar; ?></strong></div><div class="col-sm-2"><strong>Required Seat</strong><input type="text" name="exam_required_seat[]" class="form-control" id="exam_required_seat" required></div><div class="col-sm-2"><strong>No of Days</strong><input type="text" name="exam_req_days[]" class="form-control" id="exam_req_days" required></div></div> ');
}
	} 
	
</script>
<script>
(function($){
  $(".key_serch_city").on('keyup', function(e) {
    var $this = $(this);
    var exp = new RegExp($this.val(), 'i');
    $(".srch_opt li label").each(function() {
      var $self = $(this);
      if(!exp.test($self.text())) {
        $self.parent().hide();
      } else {
        $self.parent().show();
      }
    });
  });
})(jQuery);
</script>-->

  <script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script> 
    

