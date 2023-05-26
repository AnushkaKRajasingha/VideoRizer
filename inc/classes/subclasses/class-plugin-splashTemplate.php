<?php
class Plugin_splashTemplates extends Plugin_Core{
	
	public static $default_headers = array(
					'ID' => 'ID',
	                'Name' => 'Template Name',
	                'Description' => 'Description',
	                'Version' => 'Version',
	  				'Create_Date' => 'Create Date',
					'Default_Values' => 'Default Values'
	);
	public $template_files = array();
	
	public function __construct(){		
		//$this->template_files = $this->getSplashTemplates();
		//var_dump($this->template_files);
	}
	
	public function _getSplashTemplates(){
		$_tempFiles = array();
	  $files =	scandir(WPCVP_PLUGIN_SPLASHTEMDIR_PATH);	  
	  foreach ($files as $key => $name) {
	  	$_pathInfo = pathinfo(WPCVP_PLUGIN_SPLASHTEMDIR_PATH.'/'.$name);
	  	//var_dump($_pathInfo);
	  	if ($name == '.' || $name == '..' || !is_array($_pathInfo) || !array_key_exists('extension', $_pathInfo) || $_pathInfo['extension'] != 'svg' ) {
	  		continue;
	  	}	  	
	  	$file_meta_data = get_file_data(WPCVP_PLUGIN_SPLASHTEMDIR_PATH.'/'.$name, self::$default_headers);	  	
	  	$file_meta_data['path'] = WPCVP_PLUGIN_SPLASHTEMDIR_PATH.'/'.$name;
	  	$file_meta_data['url'] = WPCVP_PLUGIN_SPLASHTEMDIR_URL.'/'.$name;
	  	//$file_meta_data['svg'] = file_get_contents(WPCVP_PLUGIN_SPLASHTEMDIR_PATH.'/parameterized/'.$name);
	  	$_svgData = file_get_contents(WPCVP_PLUGIN_SPLASHTEMDIR_PATH.'/parameterized/'.$name);
	  	$file_meta_data['svgData'] = $_svgData;
	  	$matches = array();	  
	  	$_regex = '/(\{)(\{)((?:[a-z0-9]*))(.)((?:[a-z0-9]*))(.)((?:[a-z0-9]*))(.)((?:[a-z0-9]*))(\})(\})/is';	
	  	preg_match_all($_regex, $_svgData,$matches) ;
	  	$file_meta_data['param'] = $matches;
	  	$_tempFiles[$file_meta_data['ID']] = $file_meta_data;
	  }	  
	  return $_tempFiles;
	}
	
	public function __splashTemplates($id){
		try {
			$_tempFiles = $this->_getSplashTemplates();
			if (isset($id)) {
				return $_tempFiles[$id];
			}
			return false;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _splashTemplates(){
		try {
			$_tempFiles = $this->_getSplashTemplates();
			if (isset($_POST['ID']) && $_POST['ID'] != '000') {
				echo json_encode($_tempFiles[$_POST['ID']]);
			}
			else echo json_encode($_tempFiles);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
}