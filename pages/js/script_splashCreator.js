(function($){

	var _getSvgData = function(){
		var $__canvas = document.getElementById('splash');
		if(arguments[0] != undefined ){
			$action = localize_var.TextDomain+'_getSvgData&uniqueid='+arguments[0];
			$url = localize_var.admin_ajaxurl +"?action="+$action;
			$__canvas.data = $url;
		}else
			$__canvas.data = $__canvas.data;
	};
	
	
	var saveSplash = function(){		
			$_data = _getFieldData('frm_createSplash');
			if($_data == null) return false;
			$action = localize_var.TextDomain+'_saveSplash';
			displayMsg('pw_modal_splashCreator',8);
			jQuery.post(
					localize_var.admin_ajaxurl +"?action="+$action,
					{				
						data : $_data
					},
					function( response ) {
						if(!_responseValidate_v1(response,'modal_splashCreator')) return;
						$_response = jQuery.parseJSON(response);						
						closeDialog("pw_modal_splashCreator");						
						if($_response.uniqueid != ''){
							$('input[type=hidden][data-field-name=uniqueid]').val($_response.uniqueid);
							$('.btnCreateSplash').html('Update Splash').val('Update Splash');
							_getSvgData($_response.uniqueid);
						}
					}
				);			
	};
	
	
	jQuery(document).ready(function($){
		
		OpenMideaLibDialog($('input.wp-media'));
		
		$('.colorpicker-default').colorpicker();
		$("#sortable-todo").sortable();
		injectBackBtn('new_item_dlg', 'New Items',$('.panel-heading > h4'),'?page='+localize_var.TextDomain+'_mySplash');
		$uniqueid = getUrlVars()['uniqueid'];
		
		$butText = $uniqueid != undefined ? 'Update splash' : 'Save splash';
		
		$('.panel-heading > h4').prepend('<input	class="btn btn-primary col-md-2  pull-right btnCreateSplash" style="margin-left:5px;" value="'+$butText+'"   type="button" >');
		$("#splashTemplateId").msDropdown();
		
		
		
		$('.btnCreateSplash').click(function(){
			saveSplash();
		});
		
		
		$('#splashTemplateId').on('change',function(){
			var $__canvas = document.getElementById('splash');
			if($(this).val() == '000'){
				$__canvas.data = '';
			}			
			//$__canvas.src = '#';
			$action = localize_var.TextDomain+'_splashTemplates';
			$.post(
					localize_var.admin_ajaxurl +"?action="+$action,
					{				
						ID : $(this).val()
					},
					function( response ) {
						if(!_responseValidate_v1(response,'modal_splashCreator')) return;
						$_response = jQuery.parseJSON(response);							
						$__canvas.data = $_response.url;		
						$varDef = jQuery.parseJSON($_response.Default_Values);
						genarateParmFields($_response.param,$varDef);
						OpenMideaLibDialog($('input.wp-media'));
					}
				);
		});
		
	});
	
})(jQuery);

