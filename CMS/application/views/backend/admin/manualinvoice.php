<?php   $financial_year = trim($this->input->post('financial_year')); 
		$bill_date_from = trim($this->input->post('bill_date_from')); 
		$bill_date_to = trim($this->input->post('bill_date_to'));
		
//echo "hiii";
		
		if(isset($_REQUEST['financial_year']) and !empty($_REQUEST['financial_year'])){
			$financial_year = $_REQUEST['financial_year'];
		}
		if(isset($_REQUEST['bill_date_from']) and !empty($_REQUEST['bill_date_from'])){
			$bill_date_from = $_REQUEST['bill_date_from'];
		}
		if(isset($_REQUEST['bill_date_to']) and !empty($_REQUEST['bill_date_to'])){
			$bill_date_to = $_REQUEST['bill_date_to'];
		}
		
?>











<table class="table " style="vertical-align:middle; width:100%" >


<form role="form" name="report" id="report" class="form-horizontal form-groups-bordered" action="" method="post" enctype="multipart/form-data">



  <tr style="color:#FFF; background-color:#0099ff">
  <td width="15%" valign="middle"><div align="right"><strong style="position:relative; top:7px;">Financial Year  :</strong></div></td>
  <td width="15%">	<select  class="form-control" name="financial_year" id="financial_year">
		 		  <?php echo $this->common_options->financial_year_options($financial_year);?>
         		</select>  </td>
                
  <td width="15%" height="51" valign="middle"><div align="center"><strong style="position:relative; top:7px;">Bill Date From:</strong></div></td>
  <td width="15%">	
					
						<input type="text" name="bill_date_from" id="bill_date_from" class="form-control datepicker" autocomplete="off" value="<?php echo $bill_date_from; ?>">  </td>
  <td width="15%"><div align="center"><strong style="position:relative; top:7px;">Bill Date To :</strong></div></td>
  <td width="15%"><input type="text" name="bill_date_to" id="bill_date_to" class="form-control datepicker" autocomplete="off" value="<?php echo $bill_date_to; ?>" /></td>
  
  
 
  <td width="10%" valign="middle"><input type="button" name="save_btn" id="save_btn" onclick="search_redirect();" class="btn btn-success" value="Search" />
  
  </td><td width="10%" valign="middle">&nbsp;
  
  </td>
  <tr style="color:#FFF; background-color:#0099ff">
    <td valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td height="51" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="middle"><input name="button" type="submit" class="btn btn-success" id="button" style="color: white;" onclick="javascript:return notify_company(document.myform);" value="Download" /></td>
  
   </form>
  <td width="15%" valign="middle"><button onclick="redirectPage('<?php echo base_url(); ?>index.php?admin/add_manual_invoice');" 
    class="btn btn-primary pull-right">
        Add New
</button></td>
 
 
 
</table>
 
<table class="table table-striped datatable" id="table-2">

<thead>

        <tr>            
	<tr style="background-color:#0099ff">
    		<th width="5%" style="color:#FFFFFF">S.No.</th>
      <th width="20%" style="color:#FFFFFF">Exam Name</th>
	  <th width="20%" style="color:#FFFFFF">Manpower Name</th>
      <th width="10%" style="color:#FFFFFF">Mobile No</th>
      <th width="10%" style="color:#FFFFFF">Amount(&#x20B9;)</th>
	  <th width="15%" align="center" style="color:#FFFFFF" >Pan Number</th>
<th width="15%" style="color:#FFFFFF">Bill Date</th>
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

		var financial_year = $.trim($("#financial_year").val());
		var bill_date_from = $.trim($("#bill_date_from").val());
	    var bill_date_to = $.trim($("#bill_date_to").val());
		//alert(bill_date_from);
		var url = '<?php echo base_url(); ?>index.php?c=admin&m=manualinvoice&financial_year='+financial_year+"&bill_date_from="+bill_date_from+"&bill_date_to="+bill_date_to;
		
		
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

            "url": "<?php echo base_url()?>index.php?admin/ajax_manpowerinvoice/<?php echo $state_id;?>",

            "type": "POST",

			
			data :{"financial_year":'<?php echo $financial_year;?>',"bill_date_from":'<?php echo $bill_date_from;?>',"bill_date_to":'<?php echo $bill_date_to;?>'}   
			

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