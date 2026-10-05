 <?php //print_r($_SESSION);exit;?>

<?php

$roleId=$this->session->userdata('role_id');

$role_query = $this->db->query("SELECT * FROM tt_roles WHERE 1=1 AND id='".$roleId."'")->row();	
$admin_access=$role_query->access_admin;
$access_vendor=$role_query->access_vendor;
$access_center=$role_query->access_center;
$access_client=$role_query->access_client;
$access_booking=$role_query->access_booking;
$access_project=$role_query->access_project;
$access_invoice=$role_query->access_invoice;
$access_manpower=$role_query->access_manpower;
$access_manpower_payment=$role_query->access_manpower_payment;
$access_center_excel=$role_query->access_center_download;

?>




<div class="sidebar-menu">
    <header class="logo-env">
        <!-- logo -->
        <div class="logo">
            <a href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url(); ?>assets/images/logo.png"  style="max-height:80px;"   alt="logo" title="Testpan logo"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs" align="right">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>
    


    <div style="border-top:1px solid rgba(69, 74, 84, 0.7);"></div>	
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/dashboard">
                <i class="fa fa-desktop"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
		
	<!--	  <li class="<?php if ($page_name == 'bookmytestcenter') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/bookmytestcenter">
                <i class="fa fa-mobile"></i>
                <span>BookMyTestCenter</span>
            </a>
        </li>-->
		
		  <?php if($access_booking=='1'){ ?>
	<li class="<?php if ($page_name == "add_notification" or $page_name == "manage_project" or $page_name == 'package' or $page_name == 'add_package' or $page_name == 'edit_package' or $page_name == 'coupon_code_generator') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/manage_project">
                <i class="fa fa-mobile"></i>
                <span> BookMyTestCenter</span>
            </a>
            
            <ul>
                <li class="<?php if ($page_name == 'manage_notification') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/manage_notification">
                        <span><i class="fa fa-trophy"></i> All Notification</span>
                    </a>
                </li>

                
               <li class="<?php if ($page_name == 'add_notification') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/add_notification">
                        <span><i class="fa fa-mobile"></i> Create Notification</span>
                    </a>
               </li>
			   
			    <li class="<?php if ($page_name == 'package' or $page_name == 'add_package' or $page_name == 'edit_package') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/package">
                        <span><i class="fa fa-crosshairs"></i> Package</span>
                    </a>
                </li>
				
				<li class="<?php if ($page_name == 'coupon_code_generator' or $page_name == 'coupon' or $page_name == 'coupon') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/coupon_code_generator">
                        <span><i class="fa fa-crosshairs"></i> Gift Coupon</span>
                    </a>
                </li>
				
				<li class="<?php if ($page_name == 'membership' or $page_name == 'membership' or $page_name == 'membership') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/membership">
                        <span><i class="fa fa-crosshairs"></i> Paid Members</span>
                    </a>
                </li>

       		</ul>
			
			 
				
				
			 
		
	<?php } ?>  
      
     <?php if($admin_access=='1'){ ?>  
               <li class="<?php if ($page_name == 'admin_users' or $page_name == "add_admin_user" or $page_name == "edit_admin_user" or $page_name == 'admin_users_role') echo 'active'; ?>") echo 'active'; ?>
		    <a href="<?php echo base_url(); ?>index.php?admin/admin_users">
                <i class="fa fa-users"></i>
                <span> Admin User</span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'admin_users' or $page_name == 'add_center' or $page_name == 'edit_center' or $page_name == 'admin_users_role' or $page_name == 'password') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/admin_users">
                        <span><i class="fa fa-user"></i> Users</span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'admin_users') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/admin_users_role">
                        <span><i class="fa fa-sitemap"></i> User Role</span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'password') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/password">
                        <span><i class="fa file-text"></i>Change Password</span>
                    </a>
                </li>
        </ul>
      <?php } ?>
	  		   <?php if($access_client=='1'){ ?>   
		   <li class="<?php if ($page_name == 'manage_client' or $page_name == 'add_client' or $page_name == 'edit_client') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/manage_client">
                        <span><i class="fa fa-crosshairs"></i> My Client</span>
                    </a>
                </li>
			 
		<?php } ?>
	    <?php if($access_vendor=='1'){ ?>  
           <li class="<?php if ($page_name == 'vendor_listing' or $page_name == 'add_vendor' or $page_name == 'edit_vendor' or $page_name == 'view_vendor') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/vendor_listing">
                        <span><i class="fa fa-cloud-upload"></i> My Vendor</span>
                    </a>
                </li>
      
      <?php } ?>	  
	  <?php if($access_center=='1'){ ?>  
		   <li class="<?php if ($page_name == 'add_center' or $page_name == "center_listing" or $page_name == "edit_center" or $page_name == "add_lab" or $page_name == "lab_listing" or $page_name == "center_summary") echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/center_listing">
                <i class="fa fa-dashboard"></i>
                <span> Manage Center</span>
            </a>
            
            <ul>
                <li class="<?php if ($page_name == 'center_listing' or $page_name == 'add_center' or $page_name == 'edit_center' or $page_name == 'add_lab' or $page_name == 'view_center') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/center_listing">
                        <span><i class="fa fa-folder-open"></i> My Center</span>
                    </a>
                </li>
				
				 <li class="<?php if ($page_name == 'center_listing' or $page_name == 'add_center' or $page_name == 'edit_center' or $page_name == 'add_lab' or $page_name == 'view_center' or $page_name == 'deleted_center') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/deleted_center">
                        <span><i class="fa fa-folder-open"></i> Deleted Center</span>
                    </a>
                </li>
				
                <li class="<?php if ($page_name == 'center_summary') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/center_summary">
                        <span><i class="fa fa-list"></i> Center Summary</span>
                    </a>
                </li>
	
				
        </ul>
		  
		   
		  <?php } ?>      	 
			    </li>
				
 <?php if($access_booking=='1'){ ?>
	<li class="<?php if ($page_name == 'manage_project' or $page_name == "add_project" or $page_name == "add_notification") echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/manage_project">
                <i class="fa fa-calendar"></i>
                <span> My Projects</span>
            </a>
            
            <ul>
                <li class="<?php if ($page_name == 'manage_project') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/manage_project">
                        <span><i class="fa fa-trophy"></i> All Project</span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'add_project') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/add_project">
                        <span><i class="fa fa-smile-o"></i> Add Project</span>
                    </a>
                </li>
                
               <li class="<?php if ($page_name == 'add_notification') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/add_notification">
                        <span><i class="fa fa-mobile"></i> Create Notification</span>
                    </a>
               </li>

        </ul>
		
		<li class="<?php if ($page_name == 'exam_listing') echo 'active'; ?>") echo 'active'; ?>
		    <a href="<?php echo base_url(); ?>index.php?admin/exam_listing">
                <i class="fa fa-users"></i>
                <span>Exam Calendar</span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'exam_listing') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/exam_listing">
                        <span><i class="fa fa-user"></i> Exam Schedule</span>
                    </a>
                </li>
               
        </ul>
		
	<?php } ?>
	<?php if($access_invoice=='1'){ ?>			
		<li class="<?php if ($page_name == 'invoice_listing' or $page_name == "client_invoice_listing" ) echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/invoice">
                <i class="fa fa-calendar"></i>
                <span> Invoice</span>
            </a>
			
			 <ul>
			 <li class="<?php if ($page_name == 'client_invoice_listing') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/center_invoice_listing">
                        <span><i class="fa fa-folder-open"></i> Center Invoice</span>
                    </a>
             </li>
            
                <li class="<?php if ($page_name == 'invoice_listing') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/invoice_listing">
                        <span><i class="fa fa-folder-open"></i> Vendor Invoice</span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'client_invoice_listing') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/client_invoice_listing">
                        <span><i class="fa fa-folder-open"></i> Client Invoice</span>
                    </a>
                </li>
               
        </ul>
        
         <li class="<?php if ($page_name == 'invoice_manual') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/invoice_manual">
                        <span><i class="fa fa-folder-open"></i> Manual Invoice</span>
                    </a>
                </li>
        
        
		<li class="<?php if ($page_name == 'cost_sheet') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/cost_sheet">
                        <span><i class="fa fa-file-text"></i> Cost Sheet</span>
                    </a>
                </li>		
		<?php } ?>		
        
        
         <?php if($access_manpower_payment=='1'){ ?>
         
         
         
         
		    <li class="<?php if ($page_name == 'manual_invoice') echo 'active'; ?> ">
                  <!--  <a href="<?php echo base_url(); ?>index.php?admin/manual_invoice">
                        <span><i class="fa fa-folder-open"></i> Manpower Payment Details</span>
                    </a>-->
                       <a href="<?php echo base_url(); ?>index.php?admin/manualinvoice">
                        <span><i class="fa fa-folder-open"></i> Manpower Payment Details</span>
                    </a>
                </li>
			 
		<?php } ?>
		
		<?php if($access_manpower=='1'){ ?>
		  
				
				<li class="<?php if ($page_name == 'manpower' or $page_name == 'add_manpower' or $page_name == 'edit_manpower') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/manpower">
                        <span><i class="fa fa-users"></i> Manpower </span>
                    </a>
                </li>	
                
                <li class="<?php if ($page_name == 'manpower_project' or $page_name == 'manpower_project' or $page_name == 'manpower_project') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/manpower_project">
                        <span><i class="fa fa-users"></i> Manpower Project </span>
                    </a>
                </li>	
				<?php } ?>	
				
				  <li class="<?php if ($page_name == 'porder' or $page_name == 'porder' or $page_name == 'porder') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/porder">
                        <span><i class="fa fa-users"></i> Purchase Order (PO) </span>
                    </a>
                </li>	

  <li>
               <a href="<?php echo base_url();?>index.php?login/logout">
					Log Out <i class="fa fa-power-off"></i></a>
		        </li>  				
</li>		
			
			

			
        
   
    
      
    


    </ul>

</div>