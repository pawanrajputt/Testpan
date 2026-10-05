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
</style>






<link rel="stylesheet" href="assets/css/bootstrap-multiselect.css">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            

            <div class="panel-body">			
                <form role="form" name="add_project" id="add_project" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/add_notification_process" method="post" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />

                    
<div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp;EXAMINATION DETAIL</strong></span>
	
</div>
<div class="form-group">
  <div class="col-sm-7">
    <strong>Examination Name</strong>
    <input type="text" name="exam_name" class="form-control" id="exam_name" placeholder="Examination Name" style='text-transform:uppercase'>
	</div>

	
</div>
                    

<div class="form-group">
	
	
		
	<div class="col-sm-3">
		<strong>Examination Date:</strong>
		<input type="text" name="start_date" class="form-control datepicker" autocomplete="false" >
	</div>
	
	<div class="col-sm-3">
		<strong>Required Seat:</strong>
		<input type="text" name="req_seat" class="form-control" autocomplete="false" >
	</div>
</div>



<div class="form-group">
	
	<div class="col-sm-10"><strong>
	Select Examination City</strong>
		 <select tyle="display:none"  class="form-control select2" multiple="multiple"  name="city_name_val[]" id="city_name_val" style='text-transform:uppercase' >
		  <?php echo $this->common_options->center_city_name_option('');?>
        </select>  
	</div>


	
	
</div>










 












 <div class="form-group" style="background-color:#0099ff">
<span style="color:#FFFFFF; font-size:14px">	<strong>&nbsp;&nbsp;&nbsp</strong></span>
</div>   



    <div class="col-sm-5 control-label col-sm-offset-2">
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onClick="saveFrmDetails('add_project','save_btn')" value="Submit" style="width:150px; font-size:15px;">
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
