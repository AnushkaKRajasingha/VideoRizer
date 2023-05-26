<?php
$WPCVP_var_array = array(
		WPCVP.'_PLUGINDIR' =>  dirname(dirname(plugin_dir_path(__FILE__))),
		WPCVP.'_PLUGIN_PAGES' =>  dirname(dirname(plugin_dir_path(__FILE__))).'/pages',
		WPCVP.'_PLUGIN_TEMPLATES' =>  dirname(dirname(plugin_dir_path(__FILE__))).'/pages/templates',
		WPCVP.'_PLUGINDIR_URL' => plugin_dir_url(dirname(dirname(__FILE__))),
		WPCVP.'_PLUGIN_PGDIR_URL' => plugin_dir_url(dirname(dirname(__FILE__))).'pages',
		WPCVP.'_PLUGIN_TMDIR_URL' => plugin_dir_url(dirname(dirname(__FILE__))).'pages/templates',
		WPCVP.'_PLUGIN_IMGDIR_URL' => plugin_dir_url(dirname(dirname(__FILE__))).'pages/images',
		WPCVP.'_PLUGIN_CSSDIR_URL' => plugin_dir_url(dirname(dirname(__FILE__))).'pages/css',
		WPCVP.'_PLUGIN_JSDIR_URL' => plugin_dir_url(dirname(dirname(__FILE__))).'pages/js',
		WPCVP.'_PLUGIN_SPLASHTEMDIR_PATH' =>  dirname(dirname(plugin_dir_path(__FILE__))).'/pages/inc/splashTemplates',
		WPCVP.'_PLUGIN_SPLASHTEMDIR_URL' => plugin_dir_url(dirname(dirname(__FILE__))).'pages/inc/splashTemplates',
		WPCVP.'_PLUGIN_VIDSKINSDIR_PATH' =>  dirname(dirname(plugin_dir_path(__FILE__))).'/pages/inc/skins',
		WPCVP.'_PLUGIN_VIDSKINSDIR_URL' => plugin_dir_url(dirname(dirname(__FILE__))).'pages/inc/skins',
		WPCVP.'_INC_DIR' => dirname(plugin_dir_path(__FILE__)),
		WPCVP.'_CLS_DIR' => dirname(plugin_dir_path(__FILE__)).'/classes'
);

$plugin_main_page =  array('_key'=>'_myVideos','Title'=>'My Videos','MenuText'=>'My Videos','capability'=> 'manage_options','callback' => '_option_page_sub','page-style'=>true,'page-script'=>true ,'scriptDep' => array('jquery','common-data','plugin_utilities','bootstrap-switch-master'),'cls'=>'page-main');

$plugin_menu_items = array(
		'_addNewVideo' => array('_key'=>'_addNewVideo','Title'=>'Add New Video','MenuText'=>'Add New Video','capability'=> 'manage_options','callback' => '_option_page_sub','page-style'=>true,'page-script'=>true ,'scriptDep' => array('jquery','common-data','plugin_utilities','bootstrap-switch-master')),
		'_defaultOptions' => array('_key'=>'_defaultOptions','Title'=>'Default Settings','MenuText'=>'Default options','capability'=> 'manage_options','callback' => '_option_page_sub','page-style'=>true,'page-script'=>true ,'scriptDep' => array('jquery','plugin_utilities','bootstrap-switch-master','bootstrap-datetimepicker','bootstrap-colorpicker')),
		'_mySplash' => array('_key'=>'_mySplash','Title'=>'My Splash Images','MenuText'=>'Splash Images','capability'=> 'manage_options','callback' => '_option_page_sub','page-style'=>true,'page-script'=>true ,'scriptDep' => array('jquery','common-data','plugin_utilities','bootstrap-datetimepicker','bootstrap-colorpicker'),),
		'_splashCreator' => array('_key'=>'_splashCreator','Title'=>'Splash Image Creator','MenuText'=>'Splash Creator','capability'=> 'manage_options','callback' => '_option_page_sub','page-style'=>true,'page-script'=>true,'scriptDep' => array('jquery','Bootstrap-Scripts','common-data','plugin_utilities')),
		'_supports' => array('_key'=>'_supports','Title'=>'Help and Supports','MenuText'=>'Help & Supports','capability'=> 'manage_options','callback' => '_option_page_sub','page-style'=>true,'page-script'=>true ,'scriptDep' => array('jquery','common-data','plugin_utilities','bootstrap-switch-master')),
		'_licenseSettings' => array('_key'=>'_licenseSettings','Title'=>'License Settings','MenuText'=>'License','capability'=> 'manage_options','callback' => '_option_page_sub','page-style'=>true,'page-script'=>true ,'scriptDep' => array('jquery')),	
);


$db_tables = array(
		"_videos" => "CREATE TABLE IF NOT EXISTS @table_name (
		 			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
					`uniqueid` varchar(10) NOT NULL,
					`title` varchar(50) NOT NULL,
					`description` varchar(200) NOT NULL,
					`youtubeurl` varchar(150) NOT NULL,
					`splashimageid`  varchar(15) NOT NULL DEFAULT 'none',
					`autoplay` int(11) NOT NULL DEFAULT '0',
					`showtimeline` int(11) NOT NULL DEFAULT '0',
					`enablehd` int(11) NOT NULL DEFAULT '0',
					`shortcode` varchar(200) NOT NULL,
					`copyof` int(11) NOT NULL DEFAULT '0',
					`active` int(11) NOT NULL DEFAULT '1',
					`isdelete` int(11) NOT NULL DEFAULT '0',
					`createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					`size` longtext NOT NULL,
					`optin` longtext NOT NULL,
					`calltoaction` longtext NOT NULL,
					`playerOptions` longtext NOT NULL,
					UNIQUE KEY `id` (`id`),KEY `uniqueid` (`uniqueid`)) ;"
					,
		"_def_settings" => "CREATE TABLE IF NOT EXISTS @table_name (
		 			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
					`uniqueid` varchar(10) NOT NULL,
					`title` varchar(50) NOT NULL,
					`description` varchar(200) NOT NULL,
					`youtubeurl` varchar(150) NOT NULL,
					`splashimageid`  varchar(15) NOT NULL DEFAULT 'none',
					`autoplay` int(11) NOT NULL DEFAULT '0',
					`showtimeline` int(11) NOT NULL DEFAULT '0',
					`enablehd` int(11) NOT NULL DEFAULT '0',
					`shortcode` varchar(200) NOT NULL,
					`copyof` int(11) NOT NULL DEFAULT '0',
					`active` int(11) NOT NULL DEFAULT '1',
					`isdelete` int(11) NOT NULL DEFAULT '0',
					`createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					`size` longtext NOT NULL,
					`optin` longtext NOT NULL,
					`calltoaction` longtext NOT NULL,
					`playerOptions` longtext NOT NULL,
					UNIQUE KEY `id` (`id`),KEY `uniqueid` (`uniqueid`)) ;"
					,
		"_splashElement" => "CREATE TABLE IF NOT EXISTS @table_name (
		 			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
					`elemuniqueid` varchar(10) NOT NULL,
					`name` varchar(50) NOT NULL,
					`title` varchar(50) NOT NULL,
					`value` longtext NULL,
					`fontcolor` varchar(50) NULL,
					`background` longtext NULL,
					`font` longtext NULL,
					`border` varchar(50) NULL,
					`style` longtext NULL,
					`class` varchar(50) NULL,
					`type` varchar(50) NULL,
					`tag` varchar(50) NULL,
					`position` longtext NULL,
					`size` longtext NULL,
					`textanchor` longtext NULL,
					`xlinkhref` longtext NULL,
					UNIQUE KEY `id` (`id`),KEY `elemuniqueid` (`elemuniqueid`)) ;"
		,
		"_splash" => "CREATE TABLE IF NOT EXISTS @table_name (
		 			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
					`uniqueid` varchar(10) NOT NULL,
					`splashName` varchar(50) NOT NULL,
					
					`splashCustStyles` longtext NULL,
					`splashTemplateId` varchar(10) NULL,	
					`paramFields` longtext NULL,
					`active` int(11) NOT NULL DEFAULT '1',
					`deleted` int(11) NOT NULL DEFAULT '0',
					`copyof` int(11) NOT NULL DEFAULT '0',
					`createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					UNIQUE KEY `id` (`id`),KEY `uniqueid` (`uniqueid`)) ;"
		/*`splashElemsIds` longtext NULL,						
					`splashMargins` int(11) NOT NULL DEFAULT '0',
					`splashPaddings` int(11) NOT NULL DEFAULT '0',					
					`splashBackground` longtext NULL,
					`splashBorder` longtext NULL,
					`splashSize` longtext NULL,
					`splashDataURL` longtext NULL,*/
		
);

$methods_ajax = array(
	"_activateLicense" => array('func'=>'_activateLicense','user'=>false),
	"_getSettings" => array('func'=>'_getSettings','user'=>true),
	"_saveSettings" => array('func'=>'_saveSettings','user'=>false),
	"_deactivateLicense" => array('func'=>'_deactivateLicense','user'=>false),
	"_saveVideo" => array('func'=>'_saveVideo','user' => true),	
	"_getVideos" => array('func'=>'_getVideos','user' => true),
	"_saveDefSettings" => array('func'=>'_saveDefSettings','user' => true),
	"_getDefSettings" => array('func'=>'_getDefSettings','user' => true),
	"_getVideo" => array('func'=>'_getVideo','user' => true),
	"_saveSplash" => array('func'=>'_saveSplash','user' => true),
	"_getSplash" => array('func'=>'_getSplash','user' => true),
	"_saveSplashElement" => array('func'=>'_saveSplashElement','user' => true),
	"_getSplashElement" => array('func'=>'_getSplashElement','user' => true),
	"_getSvgData" => array('func'=>'_getSvgData','user' => true),
	"_getSvgForImage" => array('func'=>'_getSvgForImage','user' => true),
	"_getAllsplash" => array('func'=>'_getAllsplash','user' => true),
	"_updatesplashDataURL" => array('func'=>'_updatesplashDataURL','user' => true),
	"_careatSplashCopy" => array('func'=>'_careatSplashCopy','user' => true),
	"_deleteSplash" => array('func'=>'_deleteSplash','user' => true),
	"_deleteVedio" => array('func'=>'_deleteVedio','user' => true),
	"_copyVedio" => array('func'=>'_copyVedio','user' => true),
	"_splashTemplates" => array('func'=>'_splashTemplates','user' => true),
	"_getEmbededCode" => array('func'=>'_getEmbededCode','user' => true),
	"_getVideoEmbededStyle" => array('func'=>'_getVideoEmbededStyle','user' => true),
	"_getVideoScripts" => array('func'=>'_getVideoScripts','user' => true),
	"_getideoPreviewDialog" => array('func'=>'_getideoPreviewDialog','user' => true),
	/*"_getItems" => array('func' => '_getItems' ,'user' => true),	
	"_addItems" => array('func' => '_addItems' ,'user' => false),
	"_getAllItems"	=> array('func' => '_getAllItems' ,'user' => false),
	"_addShowCase" => array('func'=>'_addShowCase','user'=>false),	
	"_getShowCase" => array('func'=>'_getShowCase','user'=>false),
	"_getAllShowCases" => array('func'=>'_getAllShowCases','user'=>false),
	"_careatItemCopy" => array('func'=>'_careatItemCopy','user'=>false),
	"_createShowCaseCopy" => array('func'=>'_createShowCaseCopy','user'=>false),
	"_deleteItem" => array('func'=>'_deleteItem','user'=>false),
	"_deleteShowCase" => array('func'=>'_deleteShowCase','user'=>false),
	"_resetItemAnalytics" => array('func'=>'_resetItemAnalytics','user'=>false),
	"_resetShowcaseAnalytics" => array('func'=>'_resetShowcaseAnalytics','user'=>false),
	"_updateItemSubmitView" => array('func'=>'_updateItemSubmitView','user'=>true),
	*/
);

$ShortCodeSettings = array(
	'cvplayer' => '_getVideoPlayer'
);

$default_css_settings = array(
	"fontfamily" => "plugin-default",
	"fontsize" => "12px",
	"fontsizeadjust" => "none",
	"fontstretch" => "normal",
	"fontstyle" => "normal",
	"fontvariant" => "normal",
	"fontweight" => "normal",
	"lineheight" => "12px"
);

$sysMsg = array(
	0 => "Successfully Saved",
	1 => "Successfully Updated",
	2 => "Successfully Deleted",
	3 => "Successfully Copied"
);



