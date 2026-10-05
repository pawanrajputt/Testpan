<?php
//$query = $this->db->query("SELECT * FROM tt_invoice_manual where 1=1 and id='".$this->db->escape_str($param2)."'");
//$row = $query->row();
//$centerId=$row->center_id;

		$mp_qry_dt = $this->db->query("SELECT * FROM tt_invoice_manual WHERE 1=1 AND group_id='".$this->db->escape_str($param2)."'")->result_array();
		$groupId==$mp_qry->group_id;
		
		
		
		$mp_qry = $this->db->query("SELECT * FROM tt_invoice_manual where 1=1 and deleted=0 and group_id='".$this->db->escape_str($param2)."'")->row();
		$group_id=$mp_qry->group_id; 
		$invoice_number=$mp_qry->invoice_number;
		$manpower_name=$mp_qry->manpower_name;
		$address=$mp_qry->address;
		$contact_number=$mp_qry->contact_number;
		$email=$mp_qry->email;
		$account_holder_name=$mp_qry->account_holder_name;
		$bank_account_number=$mp_qry->bank_account_number;
		$ifsc_code=$mp_qry->ifsc_code;
		$pan_number=$mp_qry->pan_number;
		$bank_name=$mp_qry->bank_name;
		$bank_name=$mp_qry->bank_name;
		$branch_name=$mp_qry->branch_name;
		$bill_date=$mp_qry->doe;
		
	//	echo $this->db->last_query();exit;
		
		//$exam_date=$mp_qry->exam_date;
		//$exam_end_date=$mp_qry->exam_end_date;
		//$exam_name=$mp_qry->exam_name;
		//$no_of_manpower=$mp_qry->no_of_manpower;
		//$no_of_days=$mp_qry->no_of_days;
		
		
		
		//$total_price=$mp_qry->total_price;
	






?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

           
            <div class="panel-body">
				
                <!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BMTC</title>
</head>
<body>
  <div id="printableArea">
<h3 style="text-align:center;"><strong> MANPOWER INVOICE</strong></h3>
<table width="90%" border="1" cellspacing="0"  style="font-size:14px; color:#000" align="center">
 
  <tr>
    <td colspan="7" valign="top"><table width="100%" height="160">
        <tr>
          <td height="24" colspan="2">&nbsp;</td>
          <td width="176">Date :  <?php echo date('d/m/Y', strtotime($bill_date));?></td>   
        </tr>
        <tr>
          <td width="157" height="24" nowrap>&nbsp;&nbsp;&nbsp;Manpower Name :</td>
          <td width="696" valign="top"><?php echo strtoupper($manpower_name);?></td>
          <td valign="top">Invoice No: <?php echo $invoice_number;?></td>
        </tr>
        <tr>
          <td height="24">&nbsp;&nbsp;&nbsp;Address :</td>
          <td colspan="2"><?php echo ucwords($address);?></td>
        </tr>
        <tr>
          <td height="24" nowrap>&nbsp;&nbsp;&nbsp;Contact Number :</td>
          <td colspan="2"><?php echo $contact_number;?></td>
        </tr>
        <tr>
          <td height="24">&nbsp;&nbsp;&nbsp;Email Id :</td>
          <td colspan="2"><?php echo $email; ?></td>
        </tr>
        <tr>
          <td height="24" colspan="3"><hr></td>
        </tr>
        
      
        
    </table>    </td>
  </tr>
  <tr >
    <td colspan="2" align="center" style="font-size:16px"><strong>Examination Between</strong></td>
    <td width="30%" rowspan="2" align="center"  style="font-size:16px"><strong>Exam Name</strong></td>
    <td width="10%" rowspan="2" align="center"  style="font-size:16px"><strong>No. of <br>Manpower</strong></td>
    
    <td width="10%" rowspan="2" align="center"  style="font-size:16px"><strong>No. of Days</strong></td>
    <td width="15%" rowspan="2" align="center"  style="font-size:16px">
    
    <strong>
    
   <?php //echo $head; ?>Price</strong>
    
    
    </td>
    <td width="15%" rowspan="2" align="center"  style="font-size:16px"><strong>Total Price</strong></td>
  </tr>
  <tr >
    <td width="10%" align="center"  style="font-size:16px"><strong>Start Date</strong></td>
    <td width="10%" align="center"  style="font-size:16px"><strong>End Date</strong></td>
  </tr>
  <?php 
  $new_total_price='';
  $count=0; foreach($mp_qry_dt as $u){ $count++; 
				 
 			 $new_total_price=$new_total_price+$u['total_price'];
 			 $exam_date=$u['exam_date'];
 			 $exam_end_date=$u['exam_end_date'];
 			 $exam_name=$u['exam_name'];
			 $no_of_manpower=$u['no_of_manpower'];
			 $price_mode=$u['price_mode'];
			 $price_per_day=$u['price_per_day'];
		     $price_per_hour=$u['price_per_hour'];
		   //  $price_cost='';
			if($price_mode=='Per Day' )
			{
				$price_cost=$price_per_day;
			}
			if($price_mode=='Per Hour' )
			{
				$price_cost=$price_per_hour;
			}
			
			$no_of_days=$u['no_of_days'];
  ?>
  <tr>
    <td align="center"><?php echo $exam_date; ?></td>
    <td align="center"><?php echo $exam_end_date; ?></td>
    <td align="left"> &nbsp;&nbsp;&nbsp; <?php echo ucwords($exam_name);?></td>
    <td align="center"><?php echo $no_of_manpower; ?></td>
    
    <td align="center"><?php echo $no_of_days; ?></td>
    <td align="center"><?php //if($price_per_day!='0' && $price_per_hour==''){ echo $price_per_day; } ?>
    <?php //if($price_per_day=='0' && $price_per_hour!=''){ echo $price_per_hour; } ?>
    <?php echo $price_cost; ?> (<?php echo $price_mode; ?>)
     </td>  
    <td align="center"><?php echo $u['total_price']; ?></td>
  </tr>
  <?php } ?>
<tr>
    <td colspan="4">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="center">Total (Rs.)</td>
    <td align="center"><?php echo $new_total_price; ?></td>
  </tr>
  
  <tr>
    <td height="201" colspan="7"><table width="100%" cellpadding="5" border="1" cellspacing="0" style="border-collapse:collapse;" >
      
      <tr>
        <td width="20%">&nbsp;&nbsp;&nbsp;Account Holder Name</td>
        <td width="50%">&nbsp;&nbsp;<?php echo strtoupper($account_holder_name);?></td>
        <td width="30%" rowspan="6" align="center" valign="bottom"> Signature</td>
        </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;Account Number:</td>
        <td>&nbsp;&nbsp;<?php echo strtoupper($bank_account_number);?></td>
        </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;IFSC:</td>
        <td>&nbsp;&nbsp;<?php echo strtoupper($ifsc_code); ?></td>
        </tr>
      <tr>

        <td>&nbsp;&nbsp;&nbsp;Pan Number</td>
        <td>&nbsp;&nbsp;<?php echo strtoupper($pan_number); ?></td>
        </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;Bank Name:</td>
        <td>&nbsp;&nbsp;<?php echo strtoupper($bank_name);?></td>
        </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;Branch Name</td>
        <td>&nbsp;&nbsp;<?php echo strtoupper($branch_name);?></td>
      </tr>
    </table></td>
  </tr>
</table></div>
</div>
<div align="center">
 <input type="button" onclick="printDiv('printableArea')" value="Print Invoice" class="btn btn-space btn-primary" />


		
</body>
				</html>
            </div>

        </div>

    </div>
</div>

  <script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script> 