<?php
class Plugin_videoSkins extends Plugin_Core{

	public static $default_headers = array(
			'ID' => 'ID',
			'Name' => 'Skin Name',
			'Description' => 'Description',
			'Version' => 'Version',
			'Create_Date' => 'Create Date',
			'Paddings' => 'Paddings'
	);
	public function __construct(){}
	
	public function _getVideoSkins(){
		$_tempFiles = array();
		$files =	scandir(WPCVP_PLUGIN_VIDSKINSDIR_PATH);
		foreach ($files as $key => $name) {
			$_pathInfo = pathinfo(WPCVP_PLUGIN_VIDSKINSDIR_PATH.'/'.$name);
			//var_dump($_pathInfo);
			if ($name == '.' || $name == '..' || !is_array($_pathInfo) || !array_key_exists('extension', $_pathInfo) || $_pathInfo['extension'] != 'svg' ) {
				continue;
			}
			$file_meta_data = get_file_data(WPCVP_PLUGIN_VIDSKINSDIR_PATH.'/'.$name, self::$default_headers);
			$file_meta_data['path'] = WPCVP_PLUGIN_VIDSKINSDIR_PATH.'/'.$name;
			$file_meta_data['url'] = WPCVP_PLUGIN_VIDSKINSDIR_URL.'/'.$name;
			//$file_meta_data['svg'] = file_get_contents(WPCVP_PLUGIN_SPLASHTEMDIR_PATH.'/parameterized/'.$name);
			$_svgData = file_get_contents(WPCVP_PLUGIN_VIDSKINSDIR_PATH.'/'.$name);
			$file_meta_data['svgData'] = $_svgData;
			$_tempFiles[$file_meta_data['ID']] = $file_meta_data;
		}
		return $_tempFiles;
	}
	
	public static function _getSkinImageByID($id){	
		$pvs = new Plugin_videoSkins();	
		$_allskins = $pvs->_getVideoSkins();
		//var_dump($_allskins);
		return isset($_allskins[$id]) ? $_allskins[$id] : false;
	}
}