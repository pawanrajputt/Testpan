<?php// echo current_url();?>

<?php //if($this->session->userdata('role_id')==1 or $this->session->userdata('role_id')==2){?>
<div class="row">

<div class="col-sm-3">
      <?php if($access_client=='1'){ ?>  <a href="<?php echo base_url(); ?>index.php?admin/manage_client"><?php } ?>
            <div class="tile-stats tile-white-red" style="background:  radial-gradient(#17A2B8 , #17A2B8 )">
                <div class="icon"><i class="fa fa-crosshairs"></i></div>
                <div class="num" data-start="0" data-end="No of Total client" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $cl_total;?></div>
                <h3 style="color:#FFFFFF">My Clients</h3>
            </div>
        </a>
  </div> 
	
	<div class="col-sm-3">
   <?php if($access_booking=='1'){ ?>     <a href="<?php echo base_url(); ?>index.php?admin/manage_project"><?php } ?>
            <div class="tile-stats tile-white-red" style="background: radial-gradient(#28A745 , #28A745 )">
                <div class="icon"><i class=""></i></div>
                <div class="num" data-start="0" data-end="No of Total Project" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $cprj_total;?></div>
                <h3 style="color:#FFFFFF">Projects in (2024-25)</h3>
            </div> 
        </a>
    </div>
	
	<div class="col-sm-3">
   <?php if($access_booking=='1'){ ?>     <a href="<?php echo base_url(); ?>index.php?admin/manage_project"><?php } ?>
            <div class="tile-stats tile-white-red" style="background: radial-gradient(#FB5714 , #FB5714 )">
                <div class="icon"><i class=""></i></div>
                <div class="num" data-start="0" data-end="No of Total Project" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $cprj_monthly;?></div>
                <h3 style="color:#FFFFFF">Project in <?php echo date('F Y', mktime(0, 0, 0, date('m'), 1, date('Y'))); ?></h3>
            </div> 
        </a>
    </div>
	
	 <div class="col-sm-3">
      <a href="#">      
            <div class="tile-stats tile-white tile-white-primary" style="background: radial-gradient(#007BFF , #007BFF)">
                <div class="icon"><i class="fa fa-user" style="font-size:75px"></i></div>
                <div class="num" data-start="0" data-end="No of Candidate"
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php if($totals_seat!=0){ echo $totals_seat; } else { echo "0"; }?></div>
                <h3 style="color:#FFFFFF">Assessed Candidate</h3>
            </div>
        </a>
    </div>
	 <div style="clear:both;"></div>
    <div class="col-sm-3">
     <?php if($access_vendor=='1'){ ?>      <a href="<?php echo base_url(); ?>index.php?admin/vendor_listing"><?php } ?>
            <div class="tile-stats tile-white tile-white-primary" style="background: radial-gradient(#8a2be2 , #8a2be2)">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="num" data-start="0" data-end="No of Total Vendor"
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $m_total;?></div>
                <h3 style="color:#FFFFFF">Vendors</h3>
            </div>
        </a>
    </div>
	
	  <div class="col-sm-3">
        <a href="<?php echo base_url(); ?>index.php?admin/dashboard">
            <div class="tile-stats tile-white-red" style="background: radial-gradient(#DC3545 , #DC3545 )">
                <div class="icon"><i class="fa fa-globe"></i></div>
                <div class="num" data-start="0" data-end="No of Total City" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $city_total;?></div>
                <h3 style="color:#FFFFFF">Mapped Cities</h3>
            </div>
        </a>
    </div> 

	  <div class="col-sm-3">
     <?php if($access_center=='1'){ ?>      <a href="<?php echo base_url(); ?>index.php?admin/center_listing"><?php } ?>
            <div class="tile-stats tile-white-red" style="background: radial-gradient(#f7347a , #f7347a )">
                <div class="icon"><i class="fa fa-dashboard"></i></div>
                <div class="num" data-start="0" data-end="No of Total Test Center" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $c_total;?></div>
                <h3 style="color:#FFFFFF">BMTC Venue</h3>
            </div>
        </a>
    </div> 
    
      <div class="col-sm-3">
     <?php if($access_center=='1'){ ?>      <a href="<?php echo base_url(); ?>index.php?admin/center_listing"><?php } ?>
            <div class="tile-stats tile-white-red" style="background: radial-gradient(#FFA07A , #FFA07A )">
                <div class="icon"></div>
                <div class="num" data-start="0" data-end="No of Total Test Center" 
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $app_query;?></div>
                <h3 style="color:#FFFFFF">BMTC Mobile APP Venue</h3>
            </div>
        </a>
    </div> 
 <div style="clear:both;"></div>
  <div class="col-sm-3">
     <a href="#">
            <div class="tile-stats tile-white tile-white-primary" style="background: radial-gradient(#FF8C00 , #FF8C00)">
                <div class="icon"><i class="fa fa-desktop" style="font-size:85px"></i></div>
                <div class="num" data-start="0" data-end="No of Total Vendor"
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php if($seat_total>0){ echo $seat_total; } else { echo "0"; } ?></div>
                <h3 style="color:#FFFFFF">Capacity</h3>
            </div>
        </a>
    </div>
	
	
	<div class="col-sm-3">
     <a href="<?php echo base_url(); ?>index.php?admin/manpower">
            <div class="tile-stats tile-white tile-white-primary" style="background: radial-gradient(#bc8e52 , #bc8e52)">
                <div class="icon"><i class="fa fa-users" style="font-size:85px"></i></div>
                <div class="num" data-start="0" data-end="No of Total Vendor"
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $mp_total;  ?></div>
                <h3 style="color:#FFFFFF">Manpower</h3>
            </div>
        </a>
    </div>
    
	<div class="col-sm-3">
     <a href="<?php echo base_url(); ?>index.php?admin/manpower_project">
            <div class="tile-stats tile-white tile-white-primary" style="background: radial-gradient(#FF7F50, #FF7F50)">
                <div class="icon"><i class="f" style="font-size:85px"></i></div>
                <div class="num" data-start="0" data-end="No of Total Vendor"
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $mpower_total;  ?></div>
                <h3 style="color:#FFFFFF">Manpower Project</h3>
            </div>
        </a>
    </div>
	
    <div class="col-sm-3">
     <a href="#">
            <div class="tile-stats tile-white tile-white-primary" style="background: radial-gradient(#6495ED , #6495ED)">
                <div class="icon"><i class="fa fa-globe"></i></div>
                <div class="num" data-start="0" data-end="No of Total Vendor"
                     data-duration="1500" data-delay="0" style="color:#FFFFFF"><?php echo $intr_query;  ?></div>
                <h3 style="color:#FFFFFF">Country Mapped</h3>
            </div>
        </a>
    </div>
	
	
	 <div style="clear:both;"></div>
</div>
<?php //}?>
<br />

<table class="table table-striped datatable" id="table-2">
    
     <thead >
        <tr align="center">
          <th colspan="7" style="color:#FFFFFF; background-color:#3399ff"><marquee behavior="scroll" direction="left" style="font-size:16px; color:#FFFFFF"><strong><?php echo strtoupper(date('M Y'));?> PROJECTS</strong></marquee></th>
        </tr>
        
        <tr>
            <th style="color:#FFFFFF; background-color:#F49520"><strong>Project Name</strong></th>
			<th style="color:#FFFFFF; background-color:#F49520"><strong>Client Name</strong></th>
			<th style="background-color:#F49520; color:#FFF; text-align:center"><strong>Start Date</strong> </th>
			<th style="background-color:#F49520; color:#FFF; text-align:center"><strong>End Date</strong> </th>
			<th style="background-color:#F49520; color:#FFF; text-align:center"><strong>Booked</strong> </th>
			<th style="background-color:#F49520; color:#FFF; text-align:center"><strong>Cities</strong></th>
            <th style="background-color:#F49520; color:#FFF; text-align:center"><strong>Created</strong></th>
        </tr>
    </thead>

    <tbody>

        <?php 
				
				$fd_month = date('Y-m-01'); 
				$ld_month  = date('Y-m-t');
				$new_projects=$this->db->query("SELECT * FROM tt_exam_booking_detail where 1=1 and deleted=0 and exam_date BETWEEN '$fd_month' AND '$ld_month' GROUP  BY project_id ORDER BY exam_date DESC")->result_array();
			
				//echo '<br>S='.$totalprj=$new_projects->num_rows();
				foreach ($new_projects as $row) 
				{ 
					$prjID =$row['project_id'];	
					$project_name =$row['project_name'];	
					$client_name =$row['client_name'];	
					$project_query = $this->db->query("SELECT * FROM tt_project_detail WHERE 1=1 AND project_id='".$prjID."'")->row();
					$exam_start_date = $project_query->start_date;
					$exam_end_date = $project_query->end_date;	
					
					$ct_query = $this->db->query("SELECT * FROM tt_project_detail WHERE 1=1 AND project_id='".$prjID."' and deleted=0 order by id")->result_array();	
					$cityCount=count($ct_query);
					$seat_query = $this->db->query("SELECT * FROM tt_exam_booking_detail WHERE 1=1 AND project_id='".$prjID."' and deleted=0 order by id")->result_array();	
					$seatCount=count($seat_query);
					$prjsep['req_book_seat']='';
					$totalSeat = 0;
					foreach($seat_query as $prjsep)
					{ 
						$totalSeat = $totalSeat + $prjsep['req_book_seat'];
					}
					$totalSeat;
					
					$bookedseat['total_seat']='';
					$totalbookedSeat = 0;
					foreach($seat_query as $prjbooked)
					{ 
						$totalbookedSeat = $totalbookedSeat + $prjbooked['total_seat'];
					}
					$totalbookedSeat;
				
		?>  
		
            <tr>
                <td><?php echo ucwords(($project_name)) ?></td>   
                <td><?php echo strtoupper(($client_name)) ?></td>
				<td style="text-align:center"><?php echo date("d M Y", strtotime($exam_start_date)); ?></td>
				<td style="text-align:center"><?php echo date("d M Y", strtotime($exam_end_date)); ?></td>
				<td style="text-align:center"><?php echo $totalbookedSeat; ?></td>
				<td style="text-align:center"><?php echo $cityCount; ?></td>
                <td style="text-align:center"><?php echo date("d M Y", strtotime($row['created_on'])); ?></td>
            </tr>
            
        <?php } ?>
        
    </tbody>
    
</table>

<script>
function count_dashboard_utility(str){
	//alert('aaa');return false;
	var datastring = "";		
	
	var url = "<?php echo base_url();?>index.php?admin/count_dashboard_utility/"+str;	
	//alert(url);
	
	$("#"+str+"_span").html("Please wait...");	
	
	$.ajax({		
		type: 'POST',
		url: url,
		data: datastring,		
		dataType: "html",
		cache: false,
		success: function(message) {			
			$("#"+str+"_span").html("");
			$("#"+str).html(message);	
		}		
	});	
}
</script>