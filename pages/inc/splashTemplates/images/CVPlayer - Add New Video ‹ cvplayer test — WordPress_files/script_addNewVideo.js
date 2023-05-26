(function($){
	var $curr_video = null;
	var myPlayer = null;
	var loadDefSettings = function(){
		//displayMsg('pw_modal_addNewVideo',7);
		laodingBar.show();
		$action = localize_var.TextDomain+'_getDefSettings';
		jQuery.post(
				localize_var.admin_ajaxurl +"?action="+$action,
				{},
				function( response ) {
					$_response = jQuery.parseJSON(response);
					_injectPageData($_response,'from_addNewVideo');
					//closeDialog("pw_modal_addNewVideo");
					$('input[type=hidden][data-field-name=uniqueid]').val('');
					$('button#btn_previewVideo').hide();
					laodingBar.hide();
				}
			);
	};
	
	var loadVideo = function($uniqueid){
		$action = localize_var.TextDomain+'_getVideo';
		laodingBar.show();
		jQuery.post(
				localize_var.admin_ajaxurl +"?action="+$action,
				{uniqueid:$uniqueid},
				function( response ) {
					$_response = jQuery.parseJSON(response);
					_injectPageData($_response,'from_addNewVideo');
					if($_response.uniqueid != ''){
						$('input[type=hidden][data-field-name=uniqueid]').val($_response.uniqueid);
						$('#btn_addNewVideo').html('Update Video');
						$curr_video = $_response;						
						laodingBar.hide();
					}
				}
			);
	};
	
	var trackvideoposition = function(){
		var whereYouAt = myPlayer.currentTime; 
		$('#vp_modal_addNewVideo #modalTitle').html(whereYouAt);
	};

	
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