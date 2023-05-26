jQuery(document).ready(function($){
	// tableTopActionButtons('year_quarters', 'New Year Quarters',$('#dummy_data_table_items_container'));
	injectBtn('', '',$('.panel-heading > h4'),'?page='+localize_var.TextDomain+'_addNewVideo','Add New Video ');
	
	$action = localize_var.TextDomain+'_getVideos';
	
	var jqxhr = $.getJSON(localize_var.admin_ajaxurl+"?action="+$action, function (data) {
		
        var $aoColumns = [                          
                          { "sTitle": "Video","sName":"video" ,"mData":"youtubeurl" ,"sClass" :"video-thumb col-xs-4  col-md-1"},
                          { "sTitle": "Title","sName":"title" ,"mData":"title" ,"sClass" :"hidden-xs hidden-sm col-md-3"},
                          { "sTitle": "Creation Date","sName":"createdate" ,"mData":"createdate" ,"sClass" :"hidden-xs hidden-sm col-md-1 date"},
                          { "sTitle": "Embeded Code","sName":"embededcode" ,"mData":"uniqueid" ,"sClass" :"embededcode col-md-4 code"},
                          { "sTitle": "Shortcode","sName":"shortcode" ,"mData":"shortcode" ,"sClass" :"code col-md-2 code"},
                          { "sTitle": "","sName":"uniqueid" ,"mData":"uniqueid","sClass" : "action col-xs-6 col-md-1","bSortable":false  }
                          ];
       var $fnRowCallback =  function( nRow, aData, iDisplayIndex ) {
       	jQuery('td.action',nRow).empty().append(_getActionButtons(aData.uniqueid,'_addNewVideo','_copyVedio','_deleteVedio'));
    	//jQuery('td.status',nRow).empty().append(_getStateLable(aData.active));
    	jQuery('td.video-thumb',nRow).empty().append(_getVideoThumb(aData.youtubeurl,aData.uniqueid));
    	jQuery('td.code',nRow).empty().append(jQuery('<code/>').append(aData.shortcode));
    	jQuery('td.embededcode',nRow).empty().append(jQuery('<textarea id="txt_embededcode_'+aData.uniqueid+'" class="col-md-12 code"/>').val(_getVideoEmbededCode(aData.uniqueid)));
    	//jQuery('td.date',nRow).empty().append(date("jS F Y", aData.createdate));
    	/*setTimeout(function(){
    	videojs(aData.uniqueid, { 
    	    'techOrder': ['youtube', 'html5'], 
    	    'src': aData.youtubeurl,
    	    "controls": false, "autoplay": false
    	  });
    	},2000);*/
    };
        _setupDataTable($('#data_table_videos'),$aoColumns,data,$fnRowCallback);
        
	})
       .done(function () {
          // console.log("second success");
       })
     .fail(function () {
       //  console.log("error");
     })
     .always(function () {
        // console.log("complete");
     });

    jqxhr.complete(function () {
       // console.log("second complete");
    });
	
});
