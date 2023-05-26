<?php
class Plugin_ShortCodes extends Plugin_Core {
	public function __construct() {
		
	}
	
	public function _getVideoPlayer($attr){
		if(isset($attr['vid'])){
			$video = new Plugin_video();
			$video->uniqueid = $attr['vid'];
			$video->_getVideoPreview();
		}
	}
}