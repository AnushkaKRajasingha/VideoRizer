<?php
class PluginTemplates extends Plugin_Core{
	public function __construct(){}
	public function _loadTemplate(){
		//require_once WPCVP_CLS_DIR.'/subclasses/class-plugin-showcase.php';
		$showcases = new ShowCase();
		$_result = null;
		if (is_home()){
			$_result = $showcases->_getShowCaseByPage('hp');
		}
		else{
			$page_id = get_the_ID();// get_query_var('page_id');
			$_result = $showcases->_getShowCaseByPage($page_id);			
			if($_result == null){
				$_result = $showcases->_getShowCaseByPage('ap');
			}
		}
		
		if($_result != null){
			if (!isset($_SERVER['HTTP_REFERER'])) {
				$_result->_updateDirectView();
			}
			$_result->_updateTotalView();
			//var_dump((array)$_result);
			extract((array)$_result);
			include_once WPCVP_PLUGIN_TEMPLATES.'/1/index.php';
			exit();
		}		
	}
}