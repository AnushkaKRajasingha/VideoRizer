(function($){
	var loadDefSettings = function(){
		laodingBar.show();
		$action = localize_var.TextDomain+'_getDefSettings';
		jQuery.post(
				localize_var.admin_ajaxurl +"?action="+$action,
				{},
				function( response ) {
					$_response = jQuery.parseJSON(response);
					_injectPageData($_response,'from_defVideoSettings');
					laodingBar.hide();
				}
			);
	};
	
	$(document).ready(function(){
		$('.colorpicker-default').colorpicker();
		loadDefSettings();
		$('input.custom-time').on('blur',function(){
			$(this).prev().val($(this).val());
		});
		
		$('#btn_save_defsettings').click(function(){
			$_data = _getFieldData('from_defVideoSettings');
			if($_data == null) return false;
			$action = localize_var.TextDomain+'_saveDefSettings';
			laodingBar.show();
			jQuery.post(
					localize_var.admin_ajaxurl +"?action="+$action,
					{				
						data : $_data
					},
					function( response ) {
						$_response = jQuery.parseJSON(response);
						laodingBar.hide();
					}
				);
		});		
	});	
})(jQuery);
