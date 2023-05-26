(function($){
	
	var save_update_video = function(){
		$_data = _getFieldData('from_addNewVideo');
		if($_data == null) return false;
		$action = localize_var.TextDomain+'_saveVideo';
		laodingBar.show();
		jQuery.post(
				localize_var.admin_ajaxurl +"?action="+$action,
				{				
					data : $_data
				},
				function( response ) {
					$_response = jQuery.parseJSON(response);
					laodingBar.hide();
					if($_response.uniqueid != ''){
						$('input[type=hidden][data-field-name=uniqueid]').val($_response.uniqueid);
						//$('#btn_addNewVideo').html('Update Video');
						//$curr_video = $_response;
						//window.location = location.protocol + '//' + location.host + location.pathname + '?page='+getUrlVars()['page']+'&uniqueid='+$_response.uniqueid;
						//http://localhost:8080/cvplayer/wp-admin/admin-ajax.php?action=CVPlayer_getideoPreviewDialog&uniqueid=6a0a06dfdb&timestamp=1412002980
						$('button#btn_previewVideo').attr('data-remote',localize_var.admin_ajaxurl +"?action=CVPlayer_getideoPreviewDialog&uniqueid="+$_response.uniqueid);
						$('button#btn_previewVideo').removeAttr('disabled');
					}
				}
			);
	};
	
	$(document).ready(function(){
		/*$uniqueid = getUrlVars()['uniqueid'];
		if($uniqueid != undefined){
			loadVideo($uniqueid);
		}
		else{
		//setTimeout(function(){
			loadDefSettings();
		//},1500);
		}*/
		
		$('.colorpicker-default').colorpicker();
		
		$('body').on('hidden.bs.modal', '#vp_modal_addNewVideo', function () {
		    $(this).removeData('bs.modal').find(".modal-dialog").empty();
		});
		
		$("#splashimageid").msDropdown();$("#playerOptionsskinid").msDropdown();
		
		$('#btn_backToVideo').click(function(){
			window.location = location.protocol + '//' + location.host + location.pathname + '?page='+localize_var.TextDomain;
		});
				
		$('#btn_addNewVideo').click(function(){
			save_update_video();
		});	
		
		$('input.custom-time').on('blur',function(){
			$(this).prev().val($(this).val());
		});
		
	});	
})(jQuery);