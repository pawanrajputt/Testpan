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
.row .col-md-12 .panel.panel-primary .panel-body #add_purchase_order .form-group .col-sm-12 table tr td #dynamic_field tr td {
	font-weight: bold;
}
</style>






<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
                <form role="form" name="add_purchase_order" id="add_purchase_order" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/modify_po_order_process" method="post" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
				<input name="oid" type="hidden" value="<?php echo $user_details->id; ?>" />
                    
<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:6px">	<strong>&nbsp;&nbsp;&nbsp;</strong></span>
	
</div>
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
	<div class="col-sm-12" align="center">
		<h4><strong>PURCHASE ORDER</strong></h4>
		
	</div>
</div>


<div class="form-group">

	
<!--</div>
<div class="form-group">-->
	<div class="col-sm-12">
	<!--<label for="field-1" class="col-sm-2 control-label">Name: </label>-->
	<table width="100%" border="0">
  <tr>
    <td width="54%" rowspan="6" valign="top">TESTPAN India Private Limted<br />WZ-1390/7,IInd Floor, Above MTNL Exchange) <br /> Pankha Road,Nangal Raya,
    <br />New Delhi 110046, India <br />
    GSTIN:07AAFCT9560Q1ZG
    
    
    </td>
    <td width="17%" height="37">&nbsp;&nbsp;&nbsp;P. O. Number</td>
    <td colspan="3"><!--<label for="field-1" class="col-sm-2 control-label">P.O. Number: </label>-->
	
		<input type="text" name="po_number" class="form-control" id="po_number" placeholder="" value="<?php echo $user_details->po_number;?>" style="height:30px; background:#FFF" disabled="disabled"></td>
  </tr>
  <tr>
    <td height="37">&nbsp;&nbsp;&nbsp;P.O. Date</td>
    <td colspan="3"><input type="date" name="po_date" class="form-control" id="po_date" placeholder="" value="<?php echo $user_details->po_date;?>" style="height:30px"></td>
  </tr>
  <tr>
    <td colspan="1">&nbsp;</td>
    </tr>
  <tr>
    <td height="35">&nbsp;&nbsp;&nbsp;Type of Services</td>
    <td colspan="3"><select name="service_type" class="form-control" style="height:30px">
      <option value="1">TESTCENTER SERVICES</option>
      <option value="2">Manpower</option>
      <option value="3">Miscellaneous</option>
    </select></td>
  </tr>
  <tr>
    <td height="39">&nbsp;&nbsp;&nbsp;Assessment Name</td>
    <td colspan="3"><input type="text" name="assesement_name" class="form-control" id="assesement_name" placeholder="" value="<?php echo $user_details->assesement_name;?>" style="height:30px; text-transform:uppercase"></td>
  </tr>
  <tr>
    <td height="37">&nbsp;&nbsp;&nbsp;Assessment Date</td>
    <td width="13%"><input type="date" name="assesment_date_from" class="form-control" id="assesment_date_from" placeholder="" value="<?php echo $user_details->assesment_date_from;?>" style="height:30px"></td>
    <td width="3%" align="center">To</td>
    <td width="13%"><input type="date" name="assesment_date_to" class="form-control" id="assesment_date_to" placeholder="" value="<?php echo $user_details->assesment_date_to;?>" style="height:30px" /></td>
  </tr>
</table>
		
        
        <table width="100%" border="0">
  <tr style="background-color:#FCF">
    <td height="47" colspan="5" align="center" valign="middle"><hr style="margin-top:3px; margin-bottom:4px; font-weight: bold;" /><strong>Supplier Details </strong><hr style="margin-top:4px; margin-bottom:3px" />
      <!--<label for="field-1" class="col-sm-2 control-label">P.O. Number: </label>--></td>
    </tr>
  <tr>
    <td width="15%" height="37" valign="top">&nbsp;&nbsp;&nbsp;GSTIN : </td>
    <td colspan="2" valign="top">
    <input type="text" name="gst_number" class="form-control" id="gst_number" placeholder="" onchange="load_city_data();" style="height:30px" value="<?php echo $user_details->gst_number;?>"/>
    
    </td>
    <td width="17%">&nbsp;&nbsp;&nbsp;Contact Person Name</td>
    <td width="28%"><input type="text" name="contact_person_name" class="form-control" id="contact_person_name" placeholder="" value="<?php echo $user_details->contact_person_name;?>" style="height:30px; text-transform:uppercase"></td>
  </tr>
  <tr>
    <td width="15%" rowspan="3" valign="top">Name &amp; Address</td>
    <td width="33%" colspan="2" rowspan="3" align="center" valign="top"><textarea name="name_address" id="name_address" cols="50" rows="4" class="form-control" ><?php echo $user_details->name_address;?></textarea></td>
    <td>&nbsp;&nbsp;&nbsp;Contact No.</td>
    <td><input type="text" name="contact_number" class="form-control" id="contact_number" placeholder="" value="<?php echo $user_details->contact_number;?>" style="height:30px"></td>
    </tr>
  <tr>
    <td colspan="2"><table cellspacing="0" cellpadding="0">
      <tr>
        <td width="979" colspan="4" align="center">&nbsp;&nbsp;&nbsp;Terms of Delivery</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" colspan="2" align="center">Immediate</td>
    </tr>
  <tr>
    <td colspan="5" valign="top">&nbsp;</td>
    </tr>
   <!-- <div style="clear:both;"></div> -->
  <tr>
    <td colspan="5" valign="top">
     <table width="100%" border="1" id="dynamic_field">
  <tr>
    <td width="10%" align="center" valign="top"> S.N.</td>
    <td valign="top" width="40%">&nbsp;&nbsp;&nbsp;Description</td>
    <td width="10%" align="center">Quantity</td>
    <td width="10%" align="center">No. of Day</td>
    <td width="15%" align="center">Rate</td>
    <td colspan="15" width="15" align="center">Amount</td>
    
  </tr>
  
   <?php $count=0; foreach($po_order_info as $u){ $count++;  
   
   ?>
 <tr>
 	<input name="poid[]" type="hidden" value="<?php echo $u['id']; ?>" />
    <td width="10%" align="center" valign="top"><?php echo $count; ?></td>
    <td valign="top" width="40%">
    <textarea name="description[]" cols="45" rows="2" class="form-control" style="background-color:#FFF; text-transform:uppercase"><?php echo $u['description'];?></textarea></td>
    <td width="10%"><input type="number" name="quantity[]" class="form-control" id="" placeholder="" value="<?php echo $u['quantity'];?>" ></td>
    <td width="10%"><input type="number" name="no_of_days[]" class="form-control" id="" placeholder="" value="<?php echo $u['no_of_days'];?>" ></td>
    <td width="15%"><input type="text" name="rate[]" class="form-control" id="" placeholder="" value="<?php echo $u['rate'];?>" ></td>
    <td width="13%"><input type="text" name="amount[]" class="form-control" id="" placeholder="" value="<?php echo $u['amount'];?>" ></td>
    <td width="2%" align="center">
    <?php if($count==1){?><button type="button" name="add" id="add" class="btn-success" style="height:25px; width:25px">+</button><?php } ?></td>
  </tr>
 <?php } ?>
 
 
 </table>
    
    
    </td>
  </tr>
  
  <tr>
    <td colspan="5" valign="top">
    <table width="100%" border="1">
 <tr>
   <td colspan="7" valign="top" style="background-color:#0CF;" height="5px">&nbsp;</td>
   </tr>
 <tr>
   <td  width="10%" valign="top">&nbsp;</td>
   <td width="39%" align="right" valign="top">Amount:</td>
   <td width="10%">&nbsp;</td>
   <td width="10%">&nbsp;</td>
   <td width="15%">&nbsp;</td>
   <td width="13%"><?php echo $user_details->amount;?></td>
   <td width="3%">&nbsp;</td>
  
 </tr>
 <tr>
    <td  width="10%" valign="top">&nbsp;</td>
   <td width="39%" align="right" valign="top">GST @18%:</td>
   <td width="10%">&nbsp;</td>
   <td width="10%">&nbsp;</td>
   <td width="15%">&nbsp;</td>
   <td width="13%"><?php echo $user_details->gst_amount;?></td>
   <td width="2%">&nbsp;</td>
 </tr>
 <tr>
   <td  width="10%" valign="top">&nbsp;</td>
   <td width="39%" align="right" valign="top">Total Amount:</td>
   <td width="10%">&nbsp;</td>
   <td width="10%">&nbsp;</td>
   <td width="15%">&nbsp;</td>
   <td width="13%"><?php echo $user_details->total_amount;?></td>
   <td width="2%">&nbsp;</td>
   
  </tr>
 
 
 
 </table></td>
  </tr>
  <tr>
    <td colspan="5" valign="top"><table cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="7" width="2028">In Words: <?php echo $this->common_options->convert_number($user_details->total_amount);?> Rupees Only</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="5" align="right" valign="top">For Testpan India Private Limited </td>
    </tr>
  <tr>
    <td colspan="5" align="right" valign="top"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>Authorised Signature</p></td>
  </tr>
  <tr>
    <td colspan="5" valign="top">Declaration:  Testpan will be entitled to withhold payment against all subsequent invoices submitted by the Supplier/Service Provider, if the  Supplier/Service Provider by the tax authorities on Testpan for the tax amount already recovered by the Supplier/Service Provider along with interest and penalty defaults in payment of taxes recovered from Testpan with the tax authorities within the due date and any claims by the tax authorities on Testpan for the tax amount already recovered by the Supplier/Service Provider along with interest and penalty  and/or any rejection of input tax credit request of Testpan by the tax authorities.Provided the said tax liability will be recovered by Testpan   from the Supplier/Service Provider either from his outstanding invoices if available or by raising a debit note, in case the Supplier/Service Provider fails and/or neglects to make full payment of said tax amounts including interest and/or penalty to the tax authorities and submits  the tax paid challans as proof of discharge of the tax liability to Testpan, within thirty (30) days upon receipt of notice in writing from Testpan. </td>
    </tr>
  
</table>
	</div>
   
</div>

 	<script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		$('#dynamic_field').append('<tr id="row'+i+'"><td valign="top" align="center">'+i+'</td><td valign="top"><textarea name="description[]" cols="45" rows="2" class="form-control" style="text-transform:uppercase"></textarea></td><td><input type="number" name="quantity[]" class="form-control" id="" placeholder=""></td><td><input type="number" name="no_of_days[]" class="form-control" id="" placeholder=""></td><td><input type="text" name="rate[]" class="form-control" id="" placeholder="" ></td><td width="12%"><input type="text" name="amount[]" class="form-control" id="" placeholder=""></td><td width="3%" align="center"><button type="button" name="remove" id="'+i+'" class="btn-danger btn_remove" style="height:25px; width:25px">X</button></td></td></tr>');
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



    <div class="col-sm-5 control-label col-sm-offset-2">
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onClick="saveFrmDetails('add_purchase_order','save_btn')" value="Modify PO" style="width:150px; font-size:15px;">
        
          <button type="button" onclick="history.back();" class="btn btn-orange"> Close</button>
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
function load_city_data(){
	var gst_number = $.trim($("#gst_number").val());
	//alert(gst_number);	
	if(gst_number==""){
		return false;
	}
	//show_signature
	var datastring = "gst_number="+gst_number;	
	var url = "<?php echo base_url();?>index.php?admin/load_dynamic_address_by_gst_data";	
	//alert(url);	return false;	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
	$.ajax({		
		type: 'POST',
		url: url,
		data: datastring,		
		dataType: "json",
		cache: false,
		success: function(message) {			
			//console.log(message)
			//alert(message.director_office_data.city);
			//var data = JSON.parse(message);  //this is required if dataType is html, not required for json
			//alert(message.office_head_signature_thumb);		
			
			
			if(message.ed_options){
				$("#name_address").html(message.ed_options);	
			}
			
			$("#save_btn").val("Submit");
			$("#save_btn").attr("disabled", false);		
		}		
		
	});
}
</script>
