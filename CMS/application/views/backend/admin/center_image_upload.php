<?php /*?><script src="<?php echo base_url();?>assets/js/hindi_font.js"></script><?php */?>
<link href="assets/js/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
<script src="assets/js/dropzone/dropzone.js"></script>
<div class="row">

    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                   
                  
                   <h3> Center Name : <?php echo ucwords($center_details->center_name);?><br />
                    City : <?php echo $center_details->city;?> <br />
                    State : <?php echo ucwords(get_state_name($center_details->state_id));?> <br /> 
                    Total Lab : <?php echo $center_details->total_no_lab;?> 
              </p></h3><br />
                </div>
            </div>
 <h3 style="margin-bottom:5px;">Drop files to below box </h3>
            <div class="panel-body">
            <div>			
                <form role="form" name="dropzone_frm" id="dropzone-frm" class="dropzone" method="post" enctype="multipart/form-data">
                </form>
                </div>
            </div>

        </div>

    </div>
</div>
<script type="application/javascript">		
	Dropzone.options.dropzoneFrm = {
	 	url: "<?php echo base_url(); ?>index.php?admin/center_image_upload_process/<?php echo $center_details->id;?>", // Set the url
		method: 'post',
	  	acceptedFiles: 'image/*',
		/*maxFiles:200,	*/	
		//maxFilesize:4  //each file size IN MB		
		/*init: function() {
			this.on('success', function( file, resp ){
			 	// This is running on each success
				alert(resp);
			});
		  },
		  
		   init: function() {
			this.on("complete", function(file) { alert("completed."); });
		  }*/
		 
		  init: function() {
			/*this.on('success', function( file, resp ){
			 	// This is running on each success
				alert('aa');
			});*/
			this.on("queuecomplete", function(file) { alert("Center Images uploaded successfully."); redirectPage("<?php echo base_url(); ?>index.php?admin/center_listing/<?php echo $_REQUEST['id'];?>"); });
		  }
	};
</script>