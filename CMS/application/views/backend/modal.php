<?php $urlsegment = $this->uri->segment(2);  ?>
<script type="text/javascript">
	var frm_id = "<?php echo @$frm_id;?>";
	function showAjaxModal(url)
	{
		//code to manage modal vertical aligned middle
		/*var offset = jQuery(document).scrollTop();
		var viewportHeight = jQuery(window).height(),
		$myDialog = jQuery('#modal_ajax');
		$myDialog.css('top',  (offset  + (viewportHeight/2)) - ($myDialog.height()/2));*/
		//End Vertical aligned middle
		// SHOWING AJAX PRELOADER IMAGE
		
		jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/loader.gif" style="height:125px;" /></div>');
		
		//just scroll top to manage pop
		$("html, body").animate({ scrollTop: 0 }, "slow");		
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
		//return false;
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_ajax .modal-body').html(response);
			}
		});
	}
	
	//also add method for jquery form submittion
	function processAjaxFormRequest(data){	
		//console.log(data);
		//alert(data);return false;
		//alert(data.frm_btn_id);
		if(typeof data.btnlbl != 'undefined'){
			$("#"+data.frm_btn_id).val(data.btnlbl);
		}else{
			$("#"+data.frm_btn_id).val("Save");	
		}
		
		$("#"+data.frm_btn_id).attr("disabled", false);
		if(typeof data.status != 'undefined'){
			if(data.status == "fail"){
				//flash_message('danger', data.error, 5000);
				/*if(typeof data.redirect != 'undefined'){
					if(data.redirect){
						redirectPage(data.redirect);						
					}
				}*/
				$("#error_msg").text(data.error);
				return false;
					
			}
			
			if(data.status == "pass"){
				//reset form						
				//flash_message('success', data.error, 7000);
				if(typeof data.redirect != 'undefined'){
					if(data.redirect){
						redirectPage(data.redirect);						
					}
				}
				return false;
			}
		}
		//e.preventDefault();	
		return false;
	}
	
	function showAjaxFormRequest(formData, jqForm, options) {
		//debugger;	
		var queryString = $.param(formData);
		//console.log('About to submit: \n' + queryString + '\n');
		return true;
	}
	function saveFrmDetails(frm, btn){		
		$("#"+btn).val("Processing...");
		$("#"+btn).attr("disabled", true); 		
		//alert(url);		
		$("#"+frm).ajaxForm({
			dataType: 'json',
			beforeSubmit: showAjaxFormRequest,
			success: processAjaxFormRequest
		}).submit();
	}
		
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax">
        <div class="modal-dialog" <?php if($urlsegment == "center_listing" or $urlsegment == "lab_listing" or $urlsegment == "manpower_project" or $urlsegment == "exam_listing"){?> style="width:700px;"<?php } else if ($urlsegment == "cost_sheet_detail") ?>style="width:1350px;" <?php  { ?>style="width:600px;" <?php } ?>> 
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <img align="top" src="<?php echo base_url(); ?>assets/images/logo.png"  style="max-height:45px;"   alt="logo" title="Testpan logo"/>
                   <!-- <h4 align="center" class="modal-title" style="color:#003471"><strong><?php echo $system_name;?></strong></h4>-->
                   
                </div>
                
                <div class="modal-body" style="height:450px; overflow:auto;">
                
                    
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    <script type="text/javascript">
	function confirm_modal(delete_url , post_refresh_url)
	{
		$('#preloader-delete').html('');
		jQuery('#modal_delete').modal('show', {backdrop: 'static'});
		document.getElementById('delete_link').setAttribute("onClick" , "delete_data('" + delete_url + "' , '" + post_refresh_url + "')" );
		document.getElementById('delete_link').focus();
	}
	</script>
    
    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal_delete">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                	<span id="preloader-delete"></span>
                    </br>
                	  <button type="button" class="btn btn-danger" id="delete_link" onClick=""><?php echo get_phrase('delete');?></button>
                    <button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link"><?php echo get_phrase('cancel');?></button>
                    
                </div>
            </div>
        </div>
    </div>