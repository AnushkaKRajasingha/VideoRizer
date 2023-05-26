<?php
class Plugin_Scripts extends Plugin_Core{
	public function __construct() {		
	}
	
	public function scriptInit(){
		$this->_jquery();	
		$this->_media();
		$this->_adminStyleEnque();
		if (is_admin() && isset($_REQUEST['page'])) {
			if(strpos($_REQUEST['page'], self::$current_plugin_data['TextDomain']) === false) return false;
			$page_slug = str_replace(self::$current_plugin_data['TextDomain'], '', $_REQUEST['page']);			
			if(!empty($page_slug)){
				$page_settings =  init_var::_getMenuItems();//var_dump($page_settings);
				$this->_registerPageScript($page_slug, $page_settings);
			}
			else{				
				/* Nothing */
				$page_stylefile = 'option-page.css';
				if(file_exists(WPCVP_PLUGIN_PAGES.'/css/'.$page_stylefile))
					wp_enqueue_style( self::$current_plugin_data['TextDomain'].'-optionpage-style',WPCVP_PLUGIN_CSSDIR_URL.'/'.$page_stylefile,array(),self::$current_plugin_data['Version']);
				$page_scriptfile = 'option-page.js';
				if(file_exists(WPCVP_PLUGIN_PAGES.'/js/'.$page_scriptfile))
					wp_enqueue_script( self::$current_plugin_data['TextDomain'].'-option-page-script',WPCVP_PLUGIN_JSDIR_URL.'/'.$page_scriptfile,array('jquery','common-data','bootbox.min','plugin_utilities'),self::$current_plugin_data['Version'],true);
			}
			
			$this->enqueCommonScripts();
			wp_enqueue_style( self::$current_plugin_data['TextDomain'].'-style',WPCVP_PLUGINDIR_URL.'style.css',array(),self::$current_plugin_data['Version']);
			wp_enqueue_script( self::$current_plugin_data['TextDomain'].'-script',WPCVP_PLUGIN_JSDIR_URL.'/script.js',array('jquery'),self::$current_plugin_data['Version'],true);
			do_action(self::$current_plugin_data['TextDomain'].'_script_localiztion');	
				
		}
	}
	
	public function _adminStyleEnque(){
		if(is_admin())
		wp_enqueue_style( self::$current_plugin_data['TextDomain'].'-admin-css', WPCVP_PLUGIN_CSSDIR_URL.'/admin/style.css', array(), null, 'all' );
	}
	
	
	
	private function _registerPageScript($page_slug, $page_settings){
		if (array_key_exists($page_slug, $page_settings) ) {
			$current_p_set = $page_settings[$page_slug];
			//WPCVP_PLUGIN_CSSDIR_URL
		
			if(array_key_exists('bootstrap', $current_p_set)){
				$this->_bootstrap();
			}
			if(array_key_exists('jQuery-ui', $current_p_set)){
				$this->_jqueryUI();
			}
		
			if(array_key_exists('page-style',$current_p_set)){
				$page_stylefile = $current_p_set['page-style'];
				if(!file_exists(WPCVP_PLUGIN_PAGES.'/css/'.$page_stylefile)){
					$page_stylefile = 'style'.$page_slug.'.css';
				}
				//echo WPCVP_PLUGIN_PAGES.'/css/'.$page_stylefile;
				if(file_exists(WPCVP_PLUGIN_PAGES.'/css/'.$page_stylefile))
					wp_enqueue_style( self::$current_plugin_data['TextDomain'].'-'.$page_slug.'-style',WPCVP_PLUGIN_CSSDIR_URL.'/'.$page_stylefile,array(),self::$current_plugin_data['Version']);
			}
		
			if (array_key_exists('page-script',$current_p_set)) {
				$page_scriptfile = $current_p_set['page-script'];
				if(!file_exists(WPCVP_PLUGIN_PAGES.'/js/'.$page_scriptfile)){
					$page_scriptfile = 'script'.$page_slug.'.js';
				}
				
				if(file_exists(WPCVP_PLUGIN_PAGES.'/js/'.$page_scriptfile)) //var_dump(self::$current_plugin_data['TextDomain'].'-'.$page_slug.'-script');
					wp_enqueue_script( self::$current_plugin_data['TextDomain'].'-'.$page_slug.'-script',WPCVP_PLUGIN_JSDIR_URL.'/'.$page_scriptfile,$current_p_set['scriptDep'],self::$current_plugin_data['Version'],true);
			}
		}
		else{
			foreach ($page_settings as $key => $value) {
				if(is_array($value) && array_key_exists('subpages', $value)){
					$this->_registerPageScript($page_slug, $value['subpages']);//echo $page_slug ;  print_r($value);
				}
			}
		}
	} 

	private function enqueCommonScripts(){
		
		$this->_bootstrap();
		//$this->_jqueryUI();
		$this->_fonts();
		$this->_animation();
		$this->_wpReset();
		$this->_dummyData();
		//$this->_chance();
		$this->_dataTable();
		$this->_dateFormat();
		$this->_fontAwsome();
		$this->_pluginUtilities();
		$this->_bootastrapChekBox();
		$this->_bootstrapDateTimePicker();	
		$this->_bootstrapBootbox();
		$this->_bootstrapColorPicker();
		$this->_videojs();
		$this->_canvg();
		$this->_jQuerySortable();
		$this->_canvas2image();
		$this->_msdropdown();
	}
	
	private function _canvg(){
		$version = '1.3';
		wp_enqueue_script( 'convg-rgbcolor',WPCVP_PLUGIN_PGDIR_URL.'/js/canvg/rgbcolor.js',array('jquery'),$version,true);
		wp_enqueue_script( 'convg-stackBlur',WPCVP_PLUGIN_PGDIR_URL.'/js/canvg/StackBlur.js',array('convg-rgbcolor'),$version,true);
		wp_enqueue_script( 'convg',WPCVP_PLUGIN_PGDIR_URL.'/js/canvg/canvg.js',array('convg-stackBlur'),$version,true);
	}
	
	private function _canvas2image(){
		$version = '0.1';
		wp_enqueue_script( 'base64',WPCVP_PLUGIN_PGDIR_URL.'/assets/canvas2image/base64.js',array(),$version,true);
		wp_enqueue_script( 'canvas2Image',WPCVP_PLUGIN_PGDIR_URL.'/assets/canvas2image/canvas2image.js',array('base64'),$version,true);
	}

	public function _videojs(){
		$version = '4.6.4';
		wp_enqueue_style( 'VideoJS-Style',WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video-js.css',array(),$version);
		wp_enqueue_style( 'VideoJSReset-Style',WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video-js-reset.css',array('VideoJS-Style'),$version);
		wp_enqueue_script( 'VideoJS-Scripts',WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video.js',array('jquery'),$version,true);
		wp_enqueue_script( 'VideoJSYoutube-Scripts',WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/youtube.js',array('VideoJS-Scripts'),$version,true);
	}
	
	private function _jQuerySortable(){
		$version = '0.9.12';
		wp_enqueue_style( 'jquerySortable-style',WPCVP_PLUGIN_PGDIR_URL.'/js/jQuery-sortable/style.css',array(),$version);
		wp_enqueue_script( 'jquerySortable-scripts',WPCVP_PLUGIN_PGDIR_URL.'/js/jQuery-sortable/jquery-sortable.js',array('jquery'),$version,true);
	}

	private function _bootstrap(){
		$version = '3.0.3';
		wp_enqueue_style( 'Bootstrap-Style',WPCVP_PLUGIN_PGDIR_URL.'/bs3/css/bootstrap.min.css',array(),$version);
		wp_enqueue_style( 'Bootstrap-Reset-Style',WPCVP_PLUGIN_PGDIR_URL.'/bs3/css/bootstrap.reset.css',array('Bootstrap-Style'),$version);
		wp_enqueue_style( 'Bootstrap-Reset-Style1',WPCVP_PLUGIN_PGDIR_URL.'/bs3/css/bootstrap-reset.css',array('Bootstrap-Style'),$version);
		wp_enqueue_script( 'Bootstrap-Scripts',WPCVP_PLUGIN_PGDIR_URL.'/bs3/js/bootstrap.min.js',array('jquery'),$version,true);
	}
	
	private function _jquery(){
		//wp_enqueue_script( 'jquery',WPCVP_PLUGIN_JSDIR_URL.'/jquery.min.js',array(),'1.11.0',true);
		wp_enqueue_script('jquery');
		
	}
	
	private function _media(){
		if(is_admin() && isset($_REQUEST['page']) &&  $_REQUEST['page'] == self::$current_plugin_data['TextDomain'].'_splashCreator'){
			wp_enqueue_media();
		}
	}
	
	private function _chance(){
		wp_enqueue_script( 'chance','http://chancejs.com/chance.min.js',array('jquery'),'',true);
	}

	private function _jqueryUI(){
		$version = '1.10.1';
		wp_enqueue_style( 'jquery-ui',WPCVP_PLUGIN_PGDIR_URL.'/assets/jquery-ui/jquery-ui-1.10.1.custom.min.css',array(),$version);
		wp_enqueue_script( 'jquery-ui',WPCVP_PLUGIN_PGDIR_URL.'/assets/jquery-ui/jquery-ui-1.10.1.custom.min.js',array('jquery'),$version,true);
	}

	private function _fonts(){
		wp_enqueue_style( self::$current_plugin_data['TextDomain'].'-fonts',WPCVP_PLUGIN_CSSDIR_URL.'/fonts.css',array(),self::$current_plugin_data['Version']);
	}

	private function _animation(){
		wp_enqueue_style( self::$current_plugin_data['TextDomain'].'-animation',WPCVP_PLUGIN_CSSDIR_URL.'/animation.css',array(),self::$current_plugin_data['Version']);
	}

	private function _wpReset(){
		wp_enqueue_style( self::$current_plugin_data['TextDomain'].'-wp-reset',WPCVP_PLUGIN_CSSDIR_URL.'/wp-reset.css',array(),self::$current_plugin_data['Version']);
	}
	
	private function _dummyData(){
		$version = '1.0';
		wp_enqueue_script( 'demo_data',WPCVP_PLUGIN_JSDIR_URL.'/dummy-data/demo_data.js',array('jquery','date-format'),$version,true);
		wp_enqueue_script( 'common_page_ini',WPCVP_PLUGIN_JSDIR_URL.'/dummy-data/common_page_ini.js',array('jquery','demo_data'),$version,true);
		wp_enqueue_script( 'common-data',WPCVP_PLUGIN_JSDIR_URL.'/dummy-data/common-data.js',array('jquery','demo_data','common_page_ini'),$version,true);		
	}
	
	private function  _dataTable(){
		$version = self::$current_plugin_data['Version'];
		wp_enqueue_style( 'data-table',WPCVP_PLUGIN_PGDIR_URL.'/assets/data-tables/DT_bootstrap.css',array('Bootstrap-Style'),$version);
		wp_enqueue_style( 'data-table-custom',WPCVP_PLUGIN_PGDIR_URL.'/assets/data-tables/dataTableCustom.css',array('data-table'),$version);
		wp_enqueue_script( 'data-table',WPCVP_PLUGIN_PGDIR_URL.'/assets/data-tables/jquery.dataTables.js',array('jquery'),$version,true);
		wp_enqueue_script( 'jeditable',WPCVP_PLUGIN_PGDIR_URL.'/assets/data-tables/jquery.jeditable.mini.js',array('jquery','data-table'),$version,true);
		wp_enqueue_script( 'DT-bootstrap',WPCVP_PLUGIN_PGDIR_URL.'/assets/data-tables/DT_bootstrap.js',array('jquery'),$version,true);
	}
	
	private function _dateFormat(){
		$version = '1.0';
		wp_enqueue_script( 'date-format',WPCVP_PLUGIN_PGDIR_URL.'/assets/date-format/date.format.js',array('jquery'),$version,true);
	}
	
	private function _fontAwsome(){
		wp_enqueue_style( 'font-awesome',WPCVP_PLUGIN_PGDIR_URL.'/assets/font-awesome/css/font-awesome.css',array(),self::$current_plugin_data['Version']);
	}
	
	private function _pluginUtilities(){
		$version = '1.0';
		wp_enqueue_script( 'plugin_utilities',WPCVP_PLUGIN_JSDIR_URL.'/plugin_utilities.js',array('jquery','bootstrap-switch-master'),$version,true);
	}

	private function _bootastrapChekBox(){
		$version = '2.0.0';
		wp_enqueue_style( 'bootstrap-switch-master',WPCVP_PLUGIN_PGDIR_URL.'/assets/bootstrap-switch-master/build/css/bootstrap3/bootstrap-switch.css',array('Bootstrap-Style'),$version);
		wp_enqueue_script( 'bootstrap-switch-master',WPCVP_PLUGIN_PGDIR_URL.'/assets/bootstrap-switch-master/build/js/bootstrap-switch.js',array('jquery','Bootstrap-Scripts'),$version,true);
	}
	
	private function _bootstrapDateTimePicker(){
		$version = '2.0.0';
		wp_enqueue_style( 'bootstrap-datetimepicker',WPCVP_PLUGIN_PGDIR_URL.'/assets/bootstrap-datetimepicker/css/datetimepicker.css',array('Bootstrap-Style'),$version);
		wp_enqueue_script( 'bootstrap-datetimepicker',WPCVP_PLUGIN_PGDIR_URL.'/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js',array('jquery','Bootstrap-Scripts'),$version,true);
	}
	
	private function _bootstrapBootbox(){
		$version = '3.3.0';
		wp_enqueue_script( 'bootbox.min',WPCVP_PLUGIN_PGDIR_URL.'/assets/bootbox/bootbox.min.js',array('jquery','Bootstrap-Scripts'),$version,true);
	}
	
	private function _bootstrapColorPicker(){
		$version = '2.0.0';
		wp_enqueue_style( 'bootstrap-colorpicker',WPCVP_PLUGIN_PGDIR_URL.'/assets/bootstrap-colorpicker/css/colorpicker.css',array('Bootstrap-Style'),$version);
		wp_enqueue_script( 'bootstrap-colorpicker',WPCVP_PLUGIN_PGDIR_URL.'/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',array('jquery','Bootstrap-Scripts'),$version,true);
	}
	
	private function _msdropdown(){
		if(is_admin() && isset($_REQUEST['page']) &&  ( $_REQUEST['page'] == self::$current_plugin_data['TextDomain'].'_splashCreator' ||  $_REQUEST['page'] == self::$current_plugin_data['TextDomain'].'_addNewVideo')){
			$version = '3.0';
			wp_enqueue_style( 'msdropdown-style',WPCVP_PLUGIN_PGDIR_URL.'/assets/msdropdown/dd.css',array(),$version);
			wp_enqueue_script( 'msdropdown-script',WPCVP_PLUGIN_PGDIR_URL.'/assets/msdropdown/jquery.dd.min.js',array('jquery'),$version,true);
		}
	}

	public function _scriptLocalization(){
		$args = array(
				'TextDomain' =>self::$current_plugin_data['TextDomain'],
				'admin_ajaxurl' =>  admin_url( 'admin-ajax.php' ),				
				'imageDirUrl' => WPCVP_PLUGIN_IMGDIR_URL,
				'tempImgDirUrl' => WPCVP_PLUGIN_SPLASHTEMDIR_URL.'/images/'
		);
		wp_localize_script(self::$current_plugin_data['TextDomain'].'-script', 'localize_var',$args );
	}
}