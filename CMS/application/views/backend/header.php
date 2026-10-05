<div class="row" >
	<div class="col-md-12 col-sm-12 clearfix" style="text-align:center;">
    	
		
	<div class="col-md-12 col-sm-12 clearfix ">
		
        <ul class="list-inline links-list pull-right">
        <!-- Language Selector -->			
           <li class="dropdown language-selector">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        <i class="entypo-user"></i> <?php echo $this->session->userdata('name');?>
                    </a>
                    |   &nbsp;&nbsp;&nbsp;
                    <a href="<?php echo base_url();?>index.php?login/logout">
					Log Out <i class="fa fa-power-off"></i>
				</a
			></li>
        </ul>
        
         <ul class="list-inline links-list pull-center">
        <!-- Language Selector -->			
           <li class="dropdown language-selector">
                    <h3 style="font-weight:200; margin:0px; color:#003471"><strong><?php echo strtoupper($system_name);?></strong></h3>
			</li>
        </ul>
        
		
	</div>	
 
    </div>
	
	<!-- Raw Links -->
	
	
</div>

<hr style="margin-top:0px;" />