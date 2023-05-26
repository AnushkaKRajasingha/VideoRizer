$(document).ready(function(){	
	$('div.box').each(function(){
		var _uniqueid = $(this).attr('data-uniqueid');
		var $data = {};
		$data['uniqueid'] = _uniqueid;
		$(this).children().find('a').each(function(){
			$(this).click(function(event ){
				jQuery.post(
						ajaxurl+"?action="+TextDomain+"_updateItemSubmitView",
						{				
							data : $data
						},
						function( response ) {
							$_response = jQuery.parseJSON(response);
							if($_response.error != undefined)
							{
								return false;
							}
						}
					);
			});
		});
	});
});