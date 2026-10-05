<?php   
        $financial_year = trim($this->input->post('financial_year')); 
		//$bill_date_from = trim($this->input->post('bill_date_from')); 
		 '<br>A1='.$bill_date_t = $_POST['bill_date_to'];
		 '<br>B1='.$bill_to_dates = explode("/", $bill_date_t);
		//echo '<br>C1='.$bill_date_too = $bill_to_dates[0]."/".$bill_to_dates[1]."/".$bill_to_dates[2];
		 '<br>Cs1='.$qr_to_date= $bill_to_dates[2]."-".$bill_to_dates[0]."-".$bill_to_dates[1];
		
		
		 '<br>A='.$bill_date_f = $_POST['bill_date_from'];
		 '<br>B='.$bill_dates = explode("/", $bill_date_f);
		//echo '<br>C='.$bill_date_froms = $bill_dates[0]."/".$bill_dates[1]."/".$bill_dates[2];
		 '<br>Cs='.$qr_from_date= $bill_dates[2]."-".$bill_dates[0]."-".$bill_dates[1];
		
		if(isset($bill_date_t) and !empty($bill_date_t) and isset($bill_date_f) and !empty($bill_date_f))
		{
			$qrystring.="and bill_date BETWEEN '".$qr_to_date."' and '".$qr_from_date."'";
		}
		 '<br>sZ='.$panNumber =$this->uri->segment(3);
		//foreach ($manual_invoice_info as $rowss)  { 
		//	echo '<br>Z='.$panNumber = $rowss['beneficiary_pan_no'];
		//}
		
		if(isset($_POST['financial_year']) and !empty($_POST['financial_year']))
		{
			$qrystring.= "and financial_year='".$financial_year."'";
		}
		
		$ext_labs = $this->db->query("SELECT sum(amount) as total_amount FROM tt_manual_invoice where 1=1 and beneficiary_pan_no='".$panNumber."' $qrystring  and deleted=0")->row();
		
		
//echo $this->db->last_query();
?>
<table class="table " style="vertical-align:middle; width:100%" >
    <form role="form" name="report" id="report" class="form-horizontal form-groups-bordered" action="" method="post" enctype="multipart/form-data">
         <?php foreach ($manual_invoice_info as $row)  { ?>
         <input type="hidden" name="pan_card" id="pan_card" value="<?php echo $row['beneficiary_pan_no'];?>" />
        <?php } ?>
        <tr style="color:#FFF; background-color:#0099ff">

            <td width="10%" valign="middle">
                <div align="right"><strong style="position:relative; top:7px;">Financial Year :</strong></div>
            </td>
            <td width="10%">
                <select class="form-control" name="financial_year" id="financial_year">
                    <?php echo $this->common_options->financial_year_options($financial_year);?>
                </select>
            </td>
        
            <td width="10%" valign="middle">
                <div align="center"><strong style="position:relative; top:7px;">Bill Date From :</strong></div>
            </td>
            <td width="10%">
                <input type="text" name="bill_date_from" id="bill_date_from"
                    class="form-control datepicker" autocomplete="off"
                    value="<?php echo $bill_date_f; ?>">
            </td>
        
            <td width="10%">
                <div align="center"><strong style="position:relative; top:7px;">Bill Date To :</strong></div>
            </td>
            <td width="10%">
                <input type="text" name="bill_date_to" id="bill_date_to"
                    class="form-control datepicker" autocomplete="off"
                    value="<?php echo $bill_date_t; ?>">
            </td>
        
            <td width="10%">
                <div align="center"><strong style="position:relative; top:7px;">Payment Status :</strong></div>
            </td>
            <td width="10%">
                <select class="form-control" name="payment_status" id="payment_status">
                    <option value="">Payment Status</option>
                    <option value="fullpaid" <?= (isset($_POST['payment_status']) && $_POST['payment_status']=='fullpaid') ? 'selected' : ''; ?>>Full Paid</option>
                    <option value="partial" <?= (isset($_POST['payment_status']) && $_POST['payment_status']=='partial') ? 'selected' : ''; ?>>Partial Payment</option>
                    <option value="unpaid" <?= (isset($_POST['payment_status']) && $_POST['payment_status']=='unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                </select>
            </td>
        
            <td width="10%" align="center">
                <input type="submit" name="save_btn" id="save_btn"
                    class="btn btn-success" value="Search">
            </td>
        
            <td width="10%" align="center">
                <input name="button" type="submit"
                    class="btn btn-success"
                    id="button"
                    style="color:white;"
                    onclick="javascript:return notify_company(document.myform);"
                    value="Download">
            </td>
        
        </tr>
     </form>
</table>


<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" >
    <thead>
        <tr>
            
            <th>S.No</th>
            <th>F.Y. & Bill Date</th>
            <th>Payment Date & Status</th>
			<th>Exam Name</th>
			<th>Manpower Name</th>
			<th>Mobile No</th>
			<th>Amount(&#x20B9;)</th>
            <th>Beneficiary </th>
            <th>Action </th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($manual_invoice_info as $row)  { 
		$count++;
		?>   
            <tr>
                <td><?php echo $count; ?></td>   
                 <td><?php echo $this->common_options->get_financial_year($row['financial_year']); ?><br /><?php echo date("d M Y", strtotime($row['bill_date'])); ?></td> 
                <td>Date: <?php echo date("d M Y", strtotime($row['payment_date'])); ?><br />
                	Status: <?php echo strtoupper($row['payment_status']) ?>
                
                </td> 
				<td><?php echo strtoupper($row['exam_name']) ?></td>
				<td><?php echo strtoupper($row['manpower_name']) ?></td>
				<td>Mobile: <?php echo $row['mobile_no'] ?> <br />
               Email: <?php echo strtoupper($row['email_id']) ?>
                </td>
				
				
				
				<td><?php echo $row['amount'] ?></td>
                <td>Name: <?php echo strtoupper($row['beneficiary_name']) ?> <br />
                A/c No.:<?php echo strtoupper($row['beneficiary_account_no']) ?><br />
                Pan No.: <?php echo strtoupper($row['beneficiary_pan_no']) ?></td>
               <td> <a href="<?php echo base_url(); ?>index.php?admin/edit_manual_invoice/<?php echo $row['id']; ?>" class="btn btn-blue btn-sm btn-icon icon-left"> <i class="entypo-pencil"></i>  Edit
                    </a></td>
            </tr>
        <?php } ?>
        <tr>
                <td>&nbsp;</td>
                 <td>&nbsp;</td> 
                <td>&nbsp;</td> 
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Total</td>
				
				
				
				<td><?php echo $ext_labs->total_amount; ?></td>
                <td>&nbsp;</td>
               <td>&nbsp; </td>
      </tr>
    </tbody>
     
</table>

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