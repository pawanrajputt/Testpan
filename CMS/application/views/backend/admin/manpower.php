<?php   $deleted = trim($this->input->post('deleted')); 
		$mp_type = trim($this->input->post('mp_type')); 
		$fl_type = trim($this->input->post('fl_type'));
		$vendor = trim($this->input->post('vendor'));
		$client = trim($this->input->post('client'));

		
		if(isset($_REQUEST['deleted']) and !empty($_REQUEST['deleted'])){
			$deleted = $_REQUEST['deleted'];
		}
		if(isset($_REQUEST['mp_type']) and !empty($_REQUEST['mp_type'])){
			$mp_type = $_REQUEST['mp_type'];
		}
		if(isset($_REQUEST['fl_type']) and !empty($_REQUEST['fl_type'])){
			$fl_type = $_REQUEST['fl_type'];
		}
			if(isset($_REQUEST['vendor']) and !empty($_REQUEST['vendor'])){
			$vendor = $_REQUEST['vendor'];
		}
			if(isset($_REQUEST['client']) and !empty($_REQUEST['client'])){
			$client = $_REQUEST['client'];
		}
?>











<table class="table " style="vertical-align:middle; width:100%" >


<form role="form" name="report" id="report" class="form-horizontal form-groups-bordered" action="" method="post" enctype="multipart/form-data">



  <tr style="color:#FFF; background-color:#0099ff">
  <td width="5%" valign="middle"><div align="left"><strong style="position:relative; top:7px;">Status :</strong></div></td>
  <td width="25%">	<select name="deleted" id="deleted" class="form-control">
						  <option value="">All</option>
						  <option value="3" <?php if($deleted==3){?> selected="selected"<?php } ?>>Active</option>
						  <option value="1" <?php if($deleted==1){?> selected="selected"<?php } ?>>Inactive</option>
						  <option value="2" <?php if($deleted==2){?> selected="selected"<?php } ?>>Deleted</option>
	  </select>  </td>
  <td width="10%" height="51" valign="middle"><div align="left"><strong style="position:relative; top:7px;">Manpower:</strong></div></td>
  <td width="25%">	
					
						<select  class="form-control" name="mp_type" id="mp_type" onchange="fl_select_option();" style='text-transform:uppercase'>
		  					<?php echo $this->common_options->select_manpower_category_options($mp_type);?>
        				</select>  </td>
  <td width="10%"><div align="left"><strong style="position:relative; top:7px;"><div <?php if($mp_type!=2){?> style="display:none;" <?php } ?>id="fl_one">Freelancer :</div></strong></div></td>
  <td colspan="2" width="25%">
  					<div <?php if($mp_type!=2){?> style="display:none;" <?php } ?> id="fl_two">
  					<select  class="form-control" name="fl_type" id="fl_type" style='text-transform:uppercase'>
		 			  <?php echo $this->common_options->manpower_sub_catg_option($fl_type);?>
	  </select>	 </div> </td>
  </tr>
  
  <tr style="color:#FFF; background-color:#0099ff">
  <td width="15%" valign="middle"><div align="left"><strong style="position:relative; top:7px;">Vendor  :</strong></div></td>
  <td width="20%">
  <select  class="form-control" name="vendor" id="vendor" style='text-transform:uppercase'>
    <?php echo $this->common_options->get_manpower_vendor_options($vendor);?>
  </select>
  </td>
  <td width="10%" height="51" valign="left"><div align="center"><strong style="position:relative; top:7px;">Client :</strong></div></td>
  <td width="27%">	
					
	    <select  class="form-control" name="client" id="client" style='text-transform:uppercase'>
    <?php echo $this->common_options->get_manpower_client_options($client);?>
  </select>  </td>
  <td colspan="3"><input type="button" name="save_btn" id="save_btn" onclick="search_redirect();" class="btn btn-success" value="Search" /></td>
  </tr>
  </form>
  <td width="15%" valign="middle"><button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_manpower');" 
    class="btn btn-primary pull-right">
        Add New
</button></td>

 
 
</table>
 
<table class="table table-striped datatable" id="table-2">

<thead>

        <tr>            
	<tr style="background-color:#0099ff">
             <th width="15%" style="color:#FFFFFF">Vendor Name</th>
            <th width="15%" style="color:#FFFFFF">Manpower Name</th>
            <th width="15%" style="color:#FFFFFF">Mobile</th>
			<th width="15%" style="color:#FFFFFF">Email</th>
            <th width="15%" style="color:#FFFFFF">City / State</th>
            <th width="15%" style="color:#FFFFFF">Experience</th>
			<th width="5%" align="center" style="color:#FFFFFF" >Status</th>
			<th width="10%" align="center" style="color:#FFFFFF" >Category</th>
			<th width="5%" style="color:#FFFFFF"> Action</th>
    </tr>

  </thead>



    <tbody>        

    </tbody>

</table>

<script src="assets/js/new_data_table/jquery-2.1.4.min.js"></script>

<script src="assets/js/new_data_table/jquery.dataTables.min.js"></script>

<script type="text/javascript">	

	function search_redirect(){

		var deleted = $.trim($("#deleted").val());
		var mp_type = $.trim($("#mp_type").val());
		var fl_type = $.trim($("#fl_type").val());
		var vendor = $.trim($("#vendor").val());
		var client = $.trim($("#client").val());
		
		var url = '<?php echo base_url(); ?>index.php?c=admin&m=manpower&deleted='+deleted+"&mp_type="+mp_type+"&fl_type="+fl_type+"&vendor="+vendor+"&client="+client;
		
		
		//alert(url);return false;is_verified

		redirectPage(url);

	}

	

    var table;

	jQuery(window).load(function ()

    {

        var $ = jQuery;

     table = $('#table-2').DataTable({ 

 

        "processing": true, //Feature control the processing indicator.

        "serverSide": true, //Feature control DataTables' server-side processing mode.

        "order": [], //Initial no order.,

		 

        // Load data for the table's content from an Ajax source

        "ajax": {

            "url": "<?php echo base_url()?>index.php?admin/ajax_manpower/<?php echo $state_id;?>",

            "type": "POST",

			
			data :{"deleted":'<?php echo $deleted;?>',"mp_type":'<?php echo $mp_type;?>',"fl_type":'<?php echo $fl_type;?>',"vendor":'<?php echo $vendor;?>',"client":'<?php echo $client;?>'}   
			

        },

		"lengthMenu": [ 50, 100, 200, 400, 600 ],

 

        //Set column definition initialisation properties.

        "columnDefs": [

        { 

            "targets": [ 4, 5, 7 ], //first column / numbering column

            "orderable": false, //set not orderable

        },

        ],

 

    });

		//alert('asdf');

        $(".dataTables_wrapper select").select2({

            minimumResultsForSearch: -1

        });



  

    });

</script>





<script type="text/javascript">

function load_assistant_director_data(city){	

	//alert(city);

	if(city==""){

		return false;

	}

	var ed_id = '<?php echo $row->seat_from;?>';

	//show_signature

	var datastring = "city="+city+"&ed_id="+ed_id;	

	var url = "<?php echo base_url();?>index.php?admin/load_dynamic_assistant_director_office_data";	

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

			if(message.director_office_data.office_head_signature_thumb){

				$("#show_signature").html("<img src='<?php echo base_url();?>uploads/user_image/assistant_director_signature/thumb/"+message.director_office_data.office_head_signature_thumb+"'> Name: <strong>"+message.director_office_data.office_head_name+"</strong>");

				$("#assistant_director_signature_file_name").val(message.office_head_signature_thumb);

			}	

			

			if(message.ed_options){

				$("#seat_from").html(message.ed_options);	

			}

			

			$("#save_btn").val("Submit");

			$("#save_btn").attr("disabled", false);		

		}		

		

	});

}






function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}



$(document).ready(function(){

	//keep data in d/m/y format

	$('.datepicker').datepicker({

		format: 'dd/mm/yyyy'/*,

		startDate: '-3d'*/

	});

</script>

<script>
function fl_select_option(){
	var mp_type = $.trim($("#mp_type").val());
	var fl_type = $.trim($("#fl_type").val());
	
	if(mp_type==""){
		return false;
	}
	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
		
	var datastring = "mp_type="+mp_type+"&fl_type="+fl_type;	
	var url = "<?php echo base_url();?>index.php?admin/load_freelancer_type";	
	//alert(url);	return false;	
	$.ajax({		
		type: 'POST',
		url: url,
		data: datastring,		
		dataType: "html",
		cache: false,
		success: function(message) {			
			//alert(message);	
			$("#save_btn").val("Submit");
			$("#save_btn").attr("disabled", false);	
			$("#fl_type").html(message);
		}		
	});
}

</script>
<script type="text/javascript">
        $(function () {
            $("#mp_type").change(function () {
               if ($(this).val() == "0") {
                   
                } else {
					$("#fl_one").hide();
                    $("#fl_two").hide();
                }
			  
			  
			    if ($(this).val() == "1") {
                    $("#fl_one").hide();
					$("#fl_two").hide();
                }
				if ($(this).val() == "2") {
                    $("#fl_one").show();
					$("#fl_two").show();
                } 
				else {
					
                }
            });
        });
		</script>