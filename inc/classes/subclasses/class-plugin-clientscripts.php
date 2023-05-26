<?php
class Plugin_ClientScripts extends Plugin_Core {
	public function __construct() {
		
	}
	
	public function _videojs(){
		$version = '4.6.4';
		wp_enqueue_style( 'VideoJS-Style',WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video-js.css',array(),$version);
		wp_enqueue_style( 'VideoJSReset-Style',WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video-js-reset.css',array('VideoJS-Style'),$version);
		wp_enqueue_script( 'VideoJS-Scripts',WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video.js',array('jquery'),$version,true);
		wp_enqueue_script( 'VideoJSYoutube-Scripts',WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/youtube.js',array('VideoJS-Scripts'),$version,true);
	}
}