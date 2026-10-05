<?php   $state_id = trim($this->input->post('state_id')); 
		$city = trim($this->input->post('city'));
		$seat_from = trim($this->input->post('seat_from'));
		$start_date = trim($this->input->post('start_date'));
		$end_date = trim($this->input->post('end_date'));
		$center_ids_list = trim($this->input->post('center_ids_list'));
		
		if(isset($_REQUEST['state_id']) and !empty($_REQUEST['state_id'])){
			 '<br>T='.$state_id = $_REQUEST['state_id'];
		}

		if(isset($_REQUEST['city']) and !empty($_REQUEST['city'])){
			 '<br>T='.$city = $_REQUEST['city'];
		}

		if(isset($_REQUEST['seat_from']) and !empty($_REQUEST['seat_from'])){
			$seat_from = $_REQUEST['seat_from'];
		}
		
		if(isset($_REQUEST['start_date']) and !empty($_REQUEST['start_date'])){
			 '<br>S='.$start_date = $_REQUEST['start_date'];
		}
		
		if(isset($_REQUEST['end_date']) and !empty($_REQUEST['end_date'])){
			 '<br>T='.$end_date = $_REQUEST['end_date'];
		}
		
		if(isset($_REQUEST['center_ids_list']) and !empty($_REQUEST['center_ids_list'])){
			 '<br>T='.$center_ids_list = $_REQUEST['center_ids_list'];
		}
		
		
?>



<table class="table " style="vertical-align:middle; width:100%" >


<form role="form" name="report" id="report" class="form-horizontal form-groups-bordered" action="" method="post" enctype="multipart/form-data">



<tr style="color:#FFF; background-color:#0099ff">

  <td width="10%" valign="middle"><strong style="position:relative; top:7px;">State:</strong></td>

<td width="20%"><select  class="form-control" name="state_id" id="state_id" onchange="loadCity();">
		   <?php echo $this->common_options->state_options($state_id);?>
         </select></td>  

<td width="5%"><strong style="position:relative; top:7px;">City:</strong></td>  

<td width="20%" valign="middle"><select  class="form-control" name="city" id="city" onchange="load_assistant_director_data();">
		   <?php echo $this->common_options->get_city_list($city);?>
         </select></td>



 <td width="5%" valign="middle"><strong style="position:relative; top:7px;">Center</strong></td>
 <td colspan="3" valign="middle">
 	<!--<select  class="form-control" name="center_ids_list" id="center_ids_list">
		  <option value="">Select One</option>
      </select>-->
	  

	  
	  
	 <?php   
	 		$cnt_qry = $this->db->query("SELECT id,center_name FROM tt_center where city_id='".$city."'")->result_array();	
	 ?> 
	  <select class="form-control" name="center_ids_list" id="center_ids_list">
	    <option value="">Select One</option>
		<?php foreach($cnt_qry as $row) { ?>
		<option value="<?php echo $row['id'] ?>" <?php if($row['id']==$center_ids_list){ ?> selected="selected"<?php } ?>><?php echo $row['center_name']?></option>
		<?php } ?>
		</select>
	  
	  
	<!--  
	<select  class="form-control" name="center_ids_list" id="center_ids_list">
		   <?php echo $this->common_options->center_list_options($center_ids_list);?>
     </select>  -->	  </td>
 </tr>

<tr style="color:#FFF; background-color:#0099ff">
  <td valign="middle"><strong style="position:relative; top:7px;">From:</strong></td>
  <td><input type="text" name="start_date" id="start_date" class="form-control datepicker" autocomplete="off" value="<?php if($start_date){ echo $start_date;}?>"></td>
  <td><strong style="position:relative; top:7px;">To:</strong></td>
  <td valign="middle"><input type="text" name="end_date" id="end_date" class="form-control datepicker" autocomplete="off" value="<?php if($end_date){ echo $end_date;}?>"></td>
  <td valign="middle">&nbsp;</td>
  <td width="22%" valign="middle">&nbsp;</td>
  <td width="8%" valign="middle"><input type="button" name="save_btn" id="save_btn" onclick="search_redirect();" class="btn btn-success" value="Search" /></td>
  <td width="10%" valign="middle"><input name="button" type="submit" class="btn btn-success" id="button" style="color: white;" onclick="javascript:return notify_company(document.myform);" value="Download" /></td>
</tr>



 <?php if($access_center_excel=='1'){ ?> <td width="10%" valign="middle">&nbsp;</td><?php } ?>
  </form>
</table>

 
<table class="table table-striped datatable" id="table-2">

<thead>

        <tr>            
	<tr style="background-color:#0099ff">
              	<th style="color:#FFF">Booked By</th>
				<th style="color:#FFF">City Name</th>
				<th style="color:#FFF">Center Name</th>
				<th style="color:#FFF">Exam Name</th>
				<th style="color:#FFF">Exam Date</th>
				<th style="color:#FFF"></th>
				<th style="color:#FFF">Booked System</th>
				<th style="color:#FFF">Action</th>
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
		var start_date = $.trim($("#start_date").val());
		var end_date = $.trim($("#end_date").val()); 
		var center_ids_list = $.trim($("#center_ids_list").val());
				
	var url = '<?php echo base_url(); ?>index.php?c=admin&m=exam_listing&state_id='+state_id+"&city="+city+"&seat_from="+seat_from+"&start_date="+start_date+"&end_date="+end_date+"&center_ids_list="+center_ids_list;
	//	alert(url);return false;
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

            "url": "<?php echo base_url()?>index.php?admin/ajax_exam_listing/<?php echo $state_id;?>",

            "type": "POST",

			data :{"state_id":'<?php echo $state_id;?>',"city":'<?php echo $city;?>', "seat_from":'<?php echo $seat_from;?>', "start_date":'<?php echo $start_date;?>', "end_date":'<?php echo $end_date;?>', "center_ids_list":'<?php echo $center_ids_list;?>'}
			

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
function load_assistant_director_data(){
	var city = $.trim($("#city").val());	
	if(city==""){
		return false;
	}
	//show_signature
	var datastring = "city="+city;	
	var url = "<?php echo base_url();?>index.php?admin/load_dynamic_city_center_data";	
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
				$("#center_ids_list").html(message.ed_options);	
			}
			
			$("#save_btn").val("Submit");
			$("#save_btn").attr("disabled", false);		
		}		
		
	});
}

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
			$("#save_btn").val("Submit");
			$("#save_btn").attr("disabled", false);	
			$("#city").html(message);
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
	})
});

</script>