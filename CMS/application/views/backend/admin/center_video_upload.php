<?php /*?><script src="<?php echo base_url();?>assets/js/hindi_font.js"></script><?php */?>
<link href="assets/js/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
<script src="assets/js/dropzone/dropzone.js"></script>
<div class="row">

    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading" style="background:#CFC">
                <div class="panel-title">
                   
    <div class="form-group">
        <label for="field-1" class="col-sm-12 control-label"><strong> <h3> Center Name : <?php echo ucwords($center_details->center_name);?></h3></strong></label>
    </div>
    
     <div class="form-group">
         <label for="field-1" class="col-sm-12 control-label"><strong><h3> City : <?php echo $center_details->city;?></h3></strong></label>
     </div>
      <div class="form-group">
          <label for="field-2" class="col-sm-12 control-label"><strong><h3> State : <?php echo ucwords(get_state_name($center_details->state_id));?></h3></strong></label>
          </div>
           <div class="form-group">
           <label for="field-2" class="col-sm-12 control-label"><strong><h3> Total Lab : <?php echo $center_details->total_no_lab;?></h3></strong></label>
       </div>
      
</div>              
                 
               
       </div>     </div>
 <h3 style="margin-bottom:5px;">Upload Video</h3>
            <div class="panel-body">			
                <form role="form" name="add_video" id="add_video" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/center_video_upload_process" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submit_btn_id" id="submit_btn_id" value="save_btn" />
   
   				<input name="centre_id" type="hidden" value="<?php echo $center_details->id;?> " id="centre_id" />
 
		
<div class="form-group">
         <label for="field-1" class="col-sm-2 control-label"><strong>Upload Video:</strong></label>
        <div class="col-sm-10">
        <input type="file" name="video" id="video" style="border-color:#CCCCCC" /> <span style="color:#060; font-size:10px;">[Max: 20MB]</span>
        </div>
</div>

<div class="form-group">
         <label for="field-1" class="col-sm-2 control-label"><strong> About Video: </strong></label>
        <div class="col-sm-10">
        <textarea name="about_video" id="about_video"  class="form-control" style='text-transform:uppercase; border-color:#CCCCCC'></textarea>
        </div>
</div>




		
    <div class="col-sm-4 control-label col-sm-offset-2">
	
	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<< Back" class="btn btn-success" />
    
    
        <input type="button" name="save_btn" id="save_btn" class="btn btn-success" onclick="saveFrmDetails('add_video','save_btn')" value="Submit">
    </div><div class="col-sm-5"><p id="error_msg" style="color:#FF0000; position:relative; top:10px;"></p></div>
                </form>
            </div>

        </div>

    </div>
</div>
<!--<script type="application/javascript">		
	Dropzone.options.dropzoneFrm = {
	 	url: "<?php echo base_url(); ?>index.php?admin/center_video_upload_process/<?php echo $center_details->id;?>", // Set the url
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
</script>-->