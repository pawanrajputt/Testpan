<?php   $state_id = trim($this->input->post('state_id')); 
		$city = trim($this->input->post('city'));
		$seat_from = trim($this->input->post('seat_from'));
		$seat_to = trim($this->input->post('seat_to'));
		$vendor_id = trim($this->input->post('vendor_id'));
		$state_id = "";

		
		if(isset($_REQUEST['state_id']) and !empty($_REQUEST['state_id'])){
			$state_id = $_REQUEST['state_id'];
		}

		if(isset($_REQUEST['city']) and !empty($_REQUEST['city'])){
			$city = $_REQUEST['city'];
		}

		if(isset($_REQUEST['seat_from']) and !empty($_REQUEST['seat_from'])){
			$seat_from = $_REQUEST['seat_from'];
		}
		
		if(isset($_REQUEST['seat_to']) and !empty($_REQUEST['seat_to'])){
			$seat_to = $_REQUEST['seat_to'];
		}
		if(isset($_REQUEST['vendor_id']) and !empty($_REQUEST['vendor_id'])){
			$vendor_id = $_REQUEST['vendor_id'];
		}
		
?>











<!--<table class="table " style="vertical-align:middle; width:100%" >


<form role="form" name="report" id="report" class="form-horizontal form-groups-bordered" action="" method="post" enctype="multipart/form-data">


<tr style="color:#FFF; background-color:#0099ff">

  <td width="10%" valign="middle"><strong style="position:relative; top:7px;">State:</strong></td>

<td width="27%"><select  class="form-control" style='text-transform:uppercase' name="state_id" id="state_id" onchange="loadCity();">
		  <?php echo $this->common_options->state_options($state_id);?>
      </select></td>  

<td width="10%"><strong style="position:relative; top:7px;">City:</strong></td>  

<td width="25%" valign="middle"><select  class="form-control" style='text-transform:uppercase' name="city" id="city">
		   <?php echo $this->common_options->get_city_list($city);?>
      </select></td>

 <td width="10%" valign="middle"><strong style="position:relative; top:7px;">Vendor:</strong></td>
 <td colspan="3" width="30%" valign="middle"><select  class="form-control" name="vendor_id" id="vendor_id" style='text-transform:uppercase'>
   <?php echo $this->common_options->vendor_options($vendor_id);?>
 </select></td>
 </tr>

<tr style="color:#FFF; background-color:#0099ff">
  <td width="5%" valign="middle"><strong style="position:relative; top:7px;">Seat From  :</strong></td>
  <td><input name="seat_from" id="seat_from" type="number" maxlength="5" class="form-control" onkeypress="return isNumberKey(event)"  width="20px" value="<?php echo $seat_from; ?>" /></td>
  <td><strong style="position:relative; top:7px;"> Seat To:</strong></td>
  <td valign="middle"><input name="seat_to" id="seat_to" type="number" maxlength="5" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $seat_to; ?>"/></td>
  <td valign="middle">&nbsp;</td>
  <td width="10%" valign="middle"><input type="button" name="save_btn" id="save_btn" onclick="search_redirect();" class="btn btn-success" value="Search" /></td>
 <?php if($access_center_excel=='1'){ ?> <td width="10%" valign="middle">
   <input name="button" type="submit" class="btn btn-success" id="button" style="color: white;" onclick="javascript:return notify_company(document.myform);" value="Download" />  </td><?php } ?>
  </form>
  <td valign="middle"><button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_center');" 
    class="btn btn-success">
        Add New Center
</button></td>
</tr>

</table>-->
 
<table class="table table-striped datatable" id="table-2">

<thead>

        <tr>            
			<tr style="background-color:#0099ff">
             <th width="15%" style="color:#FFFFFF">Center ID</th>
            <th width="15%" style="color:#FFFFFF">App Data</th>
            <th width="20%" style="color:#FFFFFF">Center Name</th>
            <th width="10%" style="color:#FFFFFF">City</th>
            <th width="10%" style="color:#FFFFFF">Capacity</th>
			
			<th width="25%" style="color:#FFFFFF">Deletion Cause</th>
            <th width="0%" style="color:#FFFFFF">&nbsp;</th>
			<th width="15%" align="center" style="color:#FFFFFF" >Action</th>
        </tr>

  </thead>



    <tbody>        

    </tbody>

</table>

<script src="assets/js/new_data_table/jquery-2.1.4.min.js"></script>

<script src="assets/js/new_data_table/jquery.dataTables.min.js"></script>

<script type="text/javascript">	

	function search_redirect(){

		var state_id = $.trim($("#state_id").val());

		var city = $.trim($("#city").val());
		
		var seat_from = $.trim($("#seat_from").val());
		
		var seat_to = $.trim($("#seat_to").val());
		
		var vendor_id = $.trim($("#vendor_id").val());

		
		var url = '<?php echo base_url(); ?>index.php?c=admin&m=deleted_center&state_id='+state_id+"&city="+city+"&seat_from="+seat_from+"&seat_to="+seat_to+"&vendor_id="+vendor_id;
		
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

            "url": "<?php echo base_url()?>index.php?admin/ajax_deleted_center/<?php echo $state_id;?>",

            "type": "POST",

			data :{"state_id":'<?php echo $state_id;?>',"city":'<?php echo $city;?>', "seat_from":'<?php echo $seat_from;?>', "seat_to":'<?php echo $seat_to;?>', "vendor_id":'<?php echo $vendor_id;?>'}
			

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
function loadCity(){
	var state_id = $.trim($("#state_id").val());
	var city = $.trim($("#city").val());
	if(state_id==""){
		return false;
	}
	
	$("#save_btn").val("Please wait...");
	$("#save_btn").attr("disabled", true);
		
	var datastring = "state_id="+state_id+"&city="+city;	
	var url = "<?php echo base_url();?>index.php?admin/load_city_id";	
	//alert(url);	return false;	
	$.ajax({		
		type: 'POST',
		url: url,
		data: datastring,		
		dataType: "html",
		cache: false,
		success: function(message) {			
			//alert(message);	
			$("#save_btn").val("Search");
			$("#save_btn").attr("disabled", false);	
			$("#city").html(message);
		}		
	});
}
</script>