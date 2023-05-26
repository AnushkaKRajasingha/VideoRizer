<?php
class Loader{
	public function __construct(){}
	public function classloader(){
		if (is_admin()) {

			$classes = array( 
					'ErrorLogger' => WPCVP_CLS_DIR.'/subclasses/class-plugin-errorlogger.php',
					'Plugin_Utilities' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-utilities.php',
					'Plugin_Settings' =>  WPCVP_CLS_DIR.'/subclasses/class-plugin-settings.php',
					'Plugin_lisense' =>  WPCVP_CLS_DIR.'/subclasses/class-plugin-licensing.php',
					'Plugin_Header' => WPCVP_CLS_DIR.'/subclasses/class-plugin-wpheader.php',					
					'Add_Hooks' 		 => WPCVP_CLS_DIR.'/subclasses/class-add-hooks.php',
					'Plugin_Menu' 		 => WPCVP_CLS_DIR.'/subclasses/class-plugin-menu.php',
					'Plugin_Scripts' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-script.php',
					'Plugin_Functions' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-functions.php',					
					'Plugin_page' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-pages.php',
					'Plugin_videooptin' 	=> WPCVP_CLS_DIR.'/subclasses/base-classes/class-plugin-optin.php',
					'Plugin_videosize' 	=> WPCVP_CLS_DIR.'/subclasses/base-classes/class-plugin-videosize.php',
					'Plugin_Calltoaction' 	=> WPCVP_CLS_DIR.'/subclasses/base-classes/class-plugin-calltoaction.php',
					'Plugin_PlayerOptions' 	=> WPCVP_CLS_DIR.'/subclasses/base-classes/class-plugin-playeroptions.php',
					'Plugin_video' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-video.php',
					'Plugin_videoCollection' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-video.php',
					'Plugin_splash' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-splash.php',					
					'Plugin_ShortCodes' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-shortcodes.php',
					'Plugin_splashTemplates' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-splashTemplate.php',
					'Plugin_videoSkins' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-video-skins.php',
					
			);
			
			$this->register_classes( $classes );
		}elseif (!is_admin()){
			$classes = array(
					'ErrorLogger' => WPCVP_CLS_DIR.'/subclasses/class-plugin-errorlogger.php',					
					'Plugin_Utilities' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-utilities.php',
					'Plugin_Settings' =>  WPCVP_CLS_DIR.'/subclasses/class-plugin-settings.php',
					'Plugin_lisense' =>  WPCVP_CLS_DIR.'/subclasses/class-plugin-licensing.php',
					'Plugin_Header' => WPCVP_CLS_DIR.'/subclasses/class-plugin-wpheader.php',											
					'Add_Hooks' 		 => WPCVP_CLS_DIR.'/subclasses/class-add-hooks.php',
					'Plugin_videooptin' 	=> WPCVP_CLS_DIR.'/subclasses/base-classes/class-plugin-optin.php',
					'Plugin_videosize' 	=> WPCVP_CLS_DIR.'/subclasses/base-classes/class-plugin-videosize.php',
					'Plugin_Calltoaction' 	=> WPCVP_CLS_DIR.'/subclasses/base-classes/class-plugin-calltoaction.php',
					'Plugin_PlayerOptions' 	=> WPCVP_CLS_DIR.'/subclasses/base-classes/class-plugin-playeroptions.php',
					'Plugin_video' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-video.php',
					'Plugin_videoCollection' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-video.php',
					'Plugin_splash' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-splash.php',					
					'Plugin_ShortCodes' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-shortcodes.php',
					'Plugin_ClientScripts' => WPCVP_CLS_DIR.'/subclasses/class-plugin-clientscripts.php',
					'Plugin_splashTemplates' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-splashTemplate.php',
					'Plugin_videoSkins' 	=> WPCVP_CLS_DIR.'/subclasses/class-plugin-video-skins.php',
				
			);
			$this->register_classes( $classes );
		}else{
			
		}
	}
}