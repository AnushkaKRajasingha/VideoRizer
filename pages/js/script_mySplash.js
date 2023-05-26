jQuery(document).ready(function($){
	// tableTopActionButtons('year_quarters', 'New Year Quarters',$('#dummy_data_table_items_container'));
	injectBtn('', '',$('.panel-heading > h4'),'?page='+localize_var.TextDomain+'_splashCreator','Create Splash Image ');
	
	$action = localize_var.TextDomain+'_getAllsplash';
	
	var jqxhr = $.getJSON(localize_var.admin_ajaxurl+"?action="+$action, function (data) {
		
        var $aoColumns = [                          
                          { "sTitle": "Splash Image","sName":"video" ,"mData":"uniqueid" ,"sClass" :"item-thumb col-xs-6  col-md-2"},
                          { "sTitle": "Title","sName":"splashName" ,"mData":"splashName" ,"sClass" :"hidden-xs hidden-sm"},
                          { "sTitle": "Creation Date","sName":"createdate" ,"mData":"createdate" ,"sClass" :"hidden-xs hidden-sm"},
                         // { "sTitle": "URL","sName":"video" ,"mData":"settings.imageUrl" ,"sClass" :"col-md-3"},
                          { "sTitle": "","sName":"uniqueid" ,"mData":"uniqueid","sClass" : "action col-xs-6 col-md-1","bSortable":false  }
                          ];
       var $fnRowCallback =  function( nRow, aData, iDisplayIndex ) {
      	jQuery('td.action',nRow).empty().append(_getActionButtons(aData.uniqueid,'_splashCreator','_careatSplashCopy','_deleteSplash'));
    /*	jQuery('td.status',nRow).empty().append(_getStateLable(aData.active));*/
      	$url = localize_var.admin_ajaxurl +"?action="+localize_var.TextDomain+'_getSvgData&uniqueid='+aData.uniqueid;
    	jQuery('td.item-thumb',nRow).empty().append(_getItemThumbByDataURL($url));
    };
        _setupDataTable($('#splash_items'),$aoColumns,data,$fnRowCallback);
        
	})
       .done(function () {
           console.log("second success");
       })
     .fail(function () {
         console.log("error");
     })
     .always(function () {
         console.log("complete");
     });

    jqxhr.complete(function () {
        console.log("second complete");
    });
	
});