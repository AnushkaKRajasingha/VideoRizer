<?php
class Plugin_videoBase extends Plugin_Core{
	public $id;
	public $uniqueid;
	public $title;
	public $description;
	public $youtubeurl;
	public $splashimageid;
	public $autoplay;
	public $showtimeline;
	public $enablehd;
	public $shortcode;
	public $copyof;
	public $active;
	public $createdate;
	public $isdelete;

	public $size;
	public $optin;
	public $calltoaction;
	public $playerOptions;

	protected $tablename = '_def_settings';

	public function __construct(){
		$this->__init();
	}

	private function __init(){
		global $wpdb;
		$this->tablename = $wpdb->prefix .self::$current_plugin_data['TextDomain'].$this->tablename;
		$this->uniqueid = Plugin_Utilities::getUniqueKey(10);
		$this->title = '';
		$this->description = '';
		$this->youtubeurl = '';
		$this->splashimageid = 0;
		$this->skinid = '001';
		$this->autoplay = 0;
		$this->showtimeline = 0;
		$this->enablehd = 0 ;
		$this->shortcode = '[cvplayer_default]';
		$this->copyof = 0;
		$this->active = 1;
		$this->isdelete = 0;
		$this->size = new Plugin_videosize();
		$this->optin = new Plugin_videooptin();
		$this->calltoaction= new Plugin_Calltoaction();
		$this->playerOptions = new Plugin_PlayerOptions();
	}

	public function _saveDefSettings(){
		try {
			$_obj = Plugin_Utilities::extractDataToOjbect($this);
			if ($_obj == null) {
				echo json_encode(array('error'=>'Unable to extract object data'));
				exit;
			}

			//var_dump($this);

			global $wpdb;
			$this->tablename = '_def_settings';
			$this->tablename = $wpdb->prefix .self::$current_plugin_data['TextDomain'].$this->tablename;
			$dbdata = array(
				'uniqueid' => $this->uniqueid,
				'title' => $this->title,
				'description' => $this->description,
				'youtubeurl' => $this->youtubeurl,
				'splashimageid' => $this->splashimageid,
				'autoplay' => $this->autoplay,
				'showtimeline' => $this->showtimeline,
				'enablehd' => $this->enablehd,
				'shortcode' => $this->shortcode,
				'copyof' => $this->copyof,
				'active' => $this->active,
				'isdelete' => $this->isdelete,
				'size' => maybe_serialize( $this->size),
				'optin' =>  maybe_serialize( $this->optin),
				'calltoaction' =>  maybe_serialize( $this->calltoaction),
				'playerOptions' => maybe_serialize($this->playerOptions)
			);

			$wpdb->insert($this->tablename, $dbdata);
			$lastId = $wpdb->insert_id;
			$wpdb->query("update ".$this->tablename." set active = 0 where id != ".$lastId);
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function __getDefSettings(){
		try {
			global $wpdb;
			$this->tablename = '_def_settings';
			$this->tablename = $wpdb->prefix .self::$current_plugin_data['TextDomain'].$this->tablename;

			$result = $wpdb->get_row("select * from ".$this->tablename." where active = 1",ARRAY_A);
			//var_dump($result);
			if($result == null) { return false;}
			Plugin_Utilities::injectObjectData($result, $this);
			$__calltoaction = unserialize($result['calltoaction']);
			//var_dump($__calltoaction);
			//Plugin_Utilities::injectObjectData($__calltoaction, $this->calltoaction);
			$this->calltoaction->autoredirect =  $__calltoaction['autoredirect'];
			$this->calltoaction->location =  $__calltoaction['location'];
			$this->calltoaction->linkbutton->value =  $__calltoaction['linkbutton']['value'];
			$this->calltoaction->linkbutton->url =  $__calltoaction['linkbutton']['url'];
			$this->calltoaction->linkbutton->target =  $__calltoaction['linkbutton']['target'];
			return $this;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _getDefSettings(){
		try {
			$this->__getDefSettings();
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
}

class Plugin_video extends Plugin_videoBase {

	public function __construct() {
		$this->tablename = '_videos';
		parent::__construct();
	}

	public function _videoShortcode($attr){
		echo 'Test Cvplayer Short code';
	}

	private function _validateId(){
		try {
			if (isset($_POST['uniqueid']) && !empty($_POST['uniqueid'])) {
				$this->uniqueid = $_POST['uniqueid'];
			}
			else if(isset($_POST['data']['uniqueid']) && !empty($_POST['data']['uniqueid'])) {
				$this->uniqueid = $_POST['data']['uniqueid'];
			}
			else if(isset($this->uniqueid)) return true;
			else{
				echo json_encode(array('msgError' => 'Invalid unique id'));
				exit;
			}

		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function __getVideo(){
		try {
			$this->_validateId();
			global $wpdb;
			$__result = $wpdb->get_row("select * from ".$this->tablename." where uniqueid='".$this->uniqueid."'",ARRAY_A);
			Plugin_Utilities::injectObjectData($__result, $this);
			//var_dump($__result);
			Plugin_Utilities::injectObjectData((array)unserialize($__result['calltoaction']), $this->calltoaction);
			Plugin_Utilities::injectObjectData((array)unserialize($__result['optin']), $this->optin);
			Plugin_Utilities::injectObjectData((array)unserialize($__result['size']), $this->size);

			return $this;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	private function __copy(){
		try {
			$this->uniqueid = Plugin_Utilities::getUniqueKey(10);
			$this->title = 'Copy of '.$this->title;
			$this->_save();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	private function _save(){
		try {
			global $wpdb;
			$dbdata = array(
					'uniqueid' => $this->uniqueid,
					'title' => $this->title,
					'description' => $this->description,
					'youtubeurl' => $this->youtubeurl,
					'splashimageid' => $this->splashimageid,
					'autoplay' => $this->autoplay,
					'showtimeline' => $this->showtimeline,
					'enablehd' => $this->enablehd,
					'shortcode' => $this->shortcode,
					'copyof' => $this->copyof,
					'active' => $this->active,
					'size' => maybe_serialize( $this->size),
					'optin' =>  maybe_serialize( $this->optin),
					'calltoaction' =>  maybe_serialize( $this->calltoaction),
					'playerOptions' => maybe_serialize($this->playerOptions)
			);

			$wpdb->insert($this->tablename, $dbdata);
			$this->id = $wpdb->insert_id;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	private function _update(){
		try {
			//var_dump($this);
			global $wpdb;
			$dbdata = array(
					'title' => $this->title,
					'description' => $this->description,
					'youtubeurl' => $this->youtubeurl,
					'splashimageid' => $this->splashimageid,
					'autoplay' => $this->autoplay,
					'showtimeline' => $this->showtimeline,
					'enablehd' => $this->enablehd,
					'shortcode' => $this->shortcode,
					'copyof' => $this->copyof,
					'active' => $this->active,
					'isdelete' => $this->isdelete,
					'size' => maybe_serialize( $this->size),
					'optin' =>  maybe_serialize( $this->optin),
					'calltoaction' =>  maybe_serialize( $this->calltoaction),
					'playerOptions' => maybe_serialize($this->playerOptions)
			);

			$wpdb->update($this->tablename, $dbdata, array('uniqueid' => $this->uniqueid));
			//var_dump($wpdb->last_query);
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _genShortcode(){
		try {
			$this->shortcode = '[cvplayer vid="'.$this->uniqueid.'"]';
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _updateVideo(){
		try {
			$this->_update();
//			echo json_encode($this->last_query);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _saveVideo(){
		try {
			$_obj = Plugin_Utilities::extractDataToOjbect($this);
			if ($_obj == null) {
				echo json_encode(array('error'=>'Unable to extract object data'));
				exit;
			}
			if (empty($this->uniqueid)) {
				$this->uniqueid = Plugin_Utilities::getUniqueKey(10);
			}
			else{
				$this->_update();
				echo json_encode($this);
				exit;
			}
			$this->_save();
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _getVideo(){
		try {
			$this->__getVideo();
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _deleteVedio(){
		try {
			$this->__getVideo();
			$this->isdelete = 1 ;
			$this->_update();
			echo json_encode(array('msg'=>init_var::getSysMsg(2)));
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _copyVedio(){
		try {
			$this->__getVideo();
			$this->__copy();
			echo json_encode(array('msg'=>init_var::getSysMsg(3)));
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	private function _getReferences(){
		try {
			if(isset($_POST['uniqueid']) || isset($_REQUEST['uniqueid']) || isset($this->uniqueid)){
				$this->uniqueid = isset($_POST['uniqueid']) ? $_POST['uniqueid'] : isset($_REQUEST['uniqueid']) ? $_REQUEST['uniqueid'] : $this->uniqueid;
				$_timestamp = '';
				if(isset($_POST['timestamp']) || isset($_REQUEST['timestamp'])){
					$_date = new DateTime();
					$_timestamp = '&timestamp=';
					$_timestamp .= $_date->getTimestamp();
				}
				echo '<div class="cvplayer video-widget" id="vid_widget_id_'.$this->uniqueid.'" data-vid="'.$this->uniqueid.'"></div>'.PHP_EOL;
//				echo '<link media="all" type="text/css" href="'.WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video-js.css'.'" rel="stylesheet"/>'.PHP_EOL;
				echo '<link media="all" type="text/css" href="'.WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video-js-reset.css'.'" rel="stylesheet"/>'.PHP_EOL;
				echo '<link media="all" type="text/css" href="'.admin_url( 'admin-ajax.php' ).'?action='.Plugin_Core::$current_plugin_data['TextDomain'].'_getVideoEmbededStyle&uniqueid='.$this->uniqueid.$_timestamp.'" rel="stylesheet"/>'.PHP_EOL;
				echo '<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>'.PHP_EOL;
				echo '<script src="'.WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video.dev.js'.'" type="text/javascript"></script>'.PHP_EOL;
				echo '<script src="'.WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/youtube.js'.'" type="text/javascript"></script>'.PHP_EOL;
				echo '<script src="'.WPCVP_PLUGIN_PGDIR_URL.'/js/TouchEvents.class.js'.'" type="text/javascript"></script>'.PHP_EOL;
				echo '<script src="'.admin_url( 'admin-ajax.php' ).'?action='.Plugin_Core::$current_plugin_data['TextDomain'].'_getVideoScripts&uniqueid='.$this->uniqueid.$_timestamp.'" type="text/javascript"></script>'.PHP_EOL;
			}
			else{
				echo 'Unable to genarate embeded code';
			}
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _getVideoPreview(){
		try {
			$this->_getReferences();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _getideoPreviewDialog(){
		try {
			header('Content-type: text/html');
			echo '<div class="modal-dialog">';
			echo '<div class="modal-content">';
			echo '<div class="modal-header"><h4 class="modal-title" id="modalTitle">Video Preview</h4></div>';
			echo '<div class="modal-body">';
			$this->_getVideoPreview();
			echo '</div>';
			echo '<div class="modal-footer"><button class="btn btn-primary" type="button" id="btn_previewClose"  data-dismiss="modal">Close</button></div>';
			echo '</div>';
			echo '</div>';
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _getEmbededCode(){
		try {
			header('Content-type: text/html');
			$this->_getReferences();
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _getVideoEmbededStyle(){
		try {
			if(isset($_POST['uniqueid']) || isset($_REQUEST['uniqueid'])){
				$this->uniqueid = isset($_POST['uniqueid']) ? $_POST['uniqueid'] : $_REQUEST['uniqueid'];
				$this->__getVideo();

				$_defVidSettings = new Plugin_videoBase();
				$_defVidSettings->__getDefSettings();

				header("Content-type: text/css");
				$_skin = Plugin_videoSkins::_getSkinImageByID($this->playerOptions->skinid);
				$_paddings = "0,0,0,0";
				$skinurl = '';
				if($_skin){
				$_paddings = explode(',', $_skin['Paddings']);
				$skinurl = $_skin['url'];
				}
				$_factor_width = $this->size->width / 640;
				$_factor_height = $this->size->height / 360;
				$_aspect_ratio = ( $this->size->height +  $_paddings[0] + $_paddings[2] ) / ($this->size->width + $_paddings[1] + $_paddings[3]) * 100;
				$_totalheight = 360 + $_paddings[0] + $_paddings[2] ;
				$_totalwidth = 640 + $_paddings[1] + $_paddings[3] ;
				//var_dump($_aspect_ratio);
				$_width_offset_left = $_paddings[1] * $_factor_width;
				$_width_offset_right = $_paddings[3] * $_factor_width;
				$_heght_offset_top = $_paddings[0] * $_factor_height;
				$_heght_offset_bottom = $_paddings[2] * $_factor_height;
				$_paddingtop = ($_paddings[0] / $_totalheight )*$_aspect_ratio;
				$_paddingright = ($_paddings[1] / $_totalwidth)* 100;
				$_paddingbottom = ($_paddings[2] / $_totalheight) * $_aspect_ratio;
				$_paddingleft = ($_paddings[3] / $_totalwidth )* 100 ;
				$_width = 100 - $_paddingright - $_paddingleft;
				$_heght = 100 - ($_paddingbottom + $_paddingtop ) -  ($_paddingtop * 2);

//				echo '@import "'.WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video-js-01.css";'.PHP_EOL;
				echo '@import "https://vjs.zencdn.net/4.9.1/video-js.css";'.PHP_EOL;
				echo '@import "'.WPCVP_PLUGIN_PGDIR_URL.'/js/video-js/video-js-reset.css";'.PHP_EOL;
				echo "/* Vedio Containers Settings */";
				echo "div#vid_widget_id_{$this->uniqueid}.cvplayer.video-widget:after { content: ''; display: block; padding-top: {$_aspect_ratio}%; }";
				echo "div#vid_widget_id_{$this->uniqueid}.cvplayer.video-widget {  display: inline-block;  position: relative;  width: 100%;}";
				echo "div#vidskinholder_{$this->uniqueid}{position:absolute;top:0;right:0;left:0;bottom:0;
							background: url('{$skinurl}');
							 background-repeat: no-repeat;
							background-size: 100% 100%;
							background-color: rgba(0, 0, 0, 0);
							background-position: center center;
							 }";
				echo "div#vidCtrl_{$this->uniqueid}.cvplayer.videoContainer{width:100%;height:100%;padding:{$_paddingtop}% {$_paddingright}% {$_paddingbottom}% {$_paddingleft}%;box-sizing:border-box;}";
				//echo "div#vid_widget_id_{$this->uniqueid}{ width: calc({$this->size->width}px + {$_width_offset_left}px + {$_width_offset_right}px); }";
				//echo "div#vidskinholder_{$this->uniqueid}{ position:relative; width: calc({$this->size->width}px + {$_width_offset_left}px + {$_width_offset_right}px); }";
				//echo "div#vidCtrl_{$this->uniqueid}.cvplayer.videoContainer{  background: url('{$skinurl}') no-repeat scroll center center / 100% 100% rgba(0, 0, 0, 0);  padding:{$_heght_offset_top}px {$_width_offset_left}px {$_heght_offset_bottom}px {$_width_offset_right}px ; }";
				echo "div#vid_{$this->uniqueid}.video-js{/*display:none;*/}";
				echo "#vp_modal_addNewVideo div.modal-dialog{ width:calc({$this->size->width}px + {$_width_offset_left}px + {$_width_offset_right}px + 40px) !important; } ";
				echo "div#vid_widget_id_{$this->uniqueid} .splash { height: 100% !important; width: 100% !important; }";
				echo "/* Vedio Containers Settings ends*/";
				echo "/* optin styles */";
				if($this->optin->include != 'no'){
					if($this->optin->include == 'yes') $_optinSet = $this->optin; else $_optinSet = $_defVidSettings->optin;
					echo "div.vid-optin-ctrl-container {  bottom: 0;  box-sizing: border-box;  left: 0;  position: absolute;  right: 0;  top: 0;  display:none;}";
					echo "div.optin-ctrl-default{	z-index: 9999; text-align: center; width: 100%; height: 100%; box-sizing: border-box; padding: 20px; }" ;
					echo "div#vidOptinContainer_{$this->uniqueid}.vid-optin-ctrl-container{padding:{$_paddingtop}% {$_paddingright}% {$_paddingbottom}% {$_paddingleft}%;}";
					echo "div#vidOptin_{$this->uniqueid}{";
						echo "background: url('".WPCVP_PLUGIN_PGDIR_URL."/images/calltoactionbg.png') !important;";
						echo "background-color:{$_defVidSettings->playerOptions->hoverColor} !important;";
					echo "}";
					if($this->optin->upoif){

						echo "
						.cvplayer-optin-form input.optin-elements {
							padding: 2% !important;
						}

						.optin-element-{$this->uniqueid}.optin-submit-button,
						div.submit-container .optin-elements.optin-element-{$this->uniqueid}{
							background: url('".WPCVP_PLUGIN_PGDIR_URL."/images/bottombg.png') repeat-x scroll left bottom !important;
							background-color: {$_optinSet->btncolor} !important;
							border-color: -moz-use-text-color -moz-use-text-color {$_optinSet->btncolor} !important;
							color: white;
						}
						";



						$optin_style = file_get_contents(WPCVP_PLUGIN_CSSDIR_URL.'/plugin-optin-style.css');
						$optin_style = str_replace(array("\r\n", "\r","\n"), "", $optin_style);
						echo $optin_style;
					}
					echo $_optinSet->customstyle;
				}
				else{
					echo "/* No optin has beed setup */";
				}

				echo "/* optin styles ends */";

				echo "/* call to action styles */";
				if($this->calltoaction->include != 'no'){
					if($this->calltoaction->include == 'yes') $_calltoactSet = $this->calltoaction; else $_calltoactSet = $_defVidSettings->calltoaction;
					echo "div#vidCalltoactContainer_{$this->uniqueid}.vid-calltoact-ctrl-container{padding:{$_paddingtop}% {$_paddingright}% {$_paddingbottom}% {$_paddingleft}%;}";
					echo "div#vidCalltoact_{$this->uniqueid}{";
					echo "background-color:{$_defVidSettings->playerOptions->calltoactColor} !important;";
					echo "}";
					echo "input#btn_calltoaction_{$this->uniqueid} {";
					echo "
							background: url('".WPCVP_PLUGIN_PGDIR_URL."/images/bottombg.png') repeat-x scroll left bottom !important;
							background-color: {$_calltoactSet->btncolor} !important;
							border-color:{$_calltoactSet->btncolor} !important;
							padding-bottom: 3%;
							border-color: -moz-use-text-color -moz-use-text-color {$_calltoactSet->btncolor} !important;
							border-bottom: none !important;
							color: white;
					";

					echo "}";
					$calltoact_style = file_get_contents(WPCVP_PLUGIN_CSSDIR_URL.'/plugin-calltoact-style.css');
					$calltoact_style = str_replace(array("\r\n", "\r","\n"), "", $calltoact_style);
					echo $calltoact_style;
					echo $_calltoactSet->customstyle;
				}
				else{
					echo "/* No call to action has beed setup */";
				}
				echo " /* call to action styles ends */";
				if($this->showtimeline == '0'){
				echo "/* play button custom */ ";
				echo "div#vid_{$this->uniqueid} div.vjs-big-play-button {display:table;background-color: rgba(0, 0, 0, 0) !important;  border: medium none !important;  border-radius: 0 !important;  height: 100% !important;  top: 0 !important;  width: 100% !important;}";
				echo "div#vid_{$this->uniqueid} div.vjs-big-play-button *{display:none !important;}";
				echo " /* play button custom ends */ ";
				}

			}
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	public function _getVideoScripts(){
		try {
			if(isset($_POST['uniqueid']) || isset($_REQUEST['uniqueid'])){
				$this->uniqueid = isset($_POST['uniqueid']) ? $_POST['uniqueid'] : $_REQUEST['uniqueid'];
				$this->__getVideo();
				$_defVidSettings = new Plugin_videoBase();
				$_defVidSettings->__getDefSettings();
				$common_functions = file_get_contents(WPCVP_PLUGIN_JSDIR_URL.'/external-use/common_func.js');
				//$common_functions = str_replace(array("\r\n", "\r","\n"), "", $common_functions);
				header("Content-type: text/javascript");
				echo "(function($){";
				echo PHP_EOL;
				echo $common_functions;
				echo PHP_EOL;

				echo "//check is mobile
					var isIos = /(iPad|iPhone|iPod)/g.test( navigator.userAgent ),
					isAndroid = /(Android)/g.test( navigator.userAgent );";

				//echo "$('#vid_widget_id_{$this->uniqueid}').append($('<h2/>').html('{$this->title}'));";
				echo "$('#vid_widget_id_{$this->uniqueid}').append($('<div/>').attr({'id':'vidskinholder_{$this->uniqueid}','class':'cvplayer vidskinholder'}));";
				echo "$('#vidskinholder_{$this->uniqueid}').append($('<div/>').attr({'id':'vidCtrl_{$this->uniqueid}','class':'cvplayer videoContainer'}));";
				//echo "$('#vidCtrl_{$this->uniqueid}').append($('<video/>').attr({'id':'vid_{$this->uniqueid}','class':'video-js vjs-default-skin','preload':'none','width':'{$this->size->width}','height':'{$this->size->height}'}));";
				echo "$('#vidCtrl_{$this->uniqueid}').append($('<video/>').attr({'id':'vid_{$this->uniqueid}','class':'video-js vjs-default-skin','preload':'none','width':'100%','height':'100%'}));";
				//echo "$('#vid_widget_id_{$this->uniqueid}').append($('<p/>').attr({'class':'modalText'}).html('{$this->description}'));";

				/* opt-in function define */
				if($this->optin->include != 'no'){
					if($this->optin->include == 'yes') $_optinSet = $this->optin; else $_optinSet = $_defVidSettings->optin;
					$optin_code = addslashes($_optinSet->optincode);
					$optin_code = str_replace(array("\r\n", "\r","\n"), "", $optin_code);
					echo "$('#vidCtrl_{$this->uniqueid}').append($('<div/>').attr({'class':'vid-optin-ctrl-container','id':'vidOptinContainer_{$this->uniqueid}'}));";
					echo "$('#vidOptinContainer_{$this->uniqueid}').append($('<div/>').attr({'class':'vid-optin-ctrl optin-ctrl-default','id':'vidOptin_{$this->uniqueid}','data-skip':'0'}));";
					echo "$('div#vidOptin_{$this->uniqueid}').append($('<h2/>').html('{$_optinSet->headline}'));";
					echo "$('div#vidOptin_{$this->uniqueid}').append($('<p/>').html('{$_optinSet->text}'));";
					echo PHP_EOL;
					echo "/* test - {$this->optin->upoif} */ ";
					echo PHP_EOL;
					if($this->optin->upoif){
						if($this->optin->eefonly){
							echo "var __optin_code = genarateEmailOnlyOptinForm('{$optin_code}','{$this->uniqueid}');";
						}
						else{
							echo "var __optin_code = genaratePluginOptinForm('{$optin_code}','{$this->uniqueid}');";
						}

						echo "__optin_code.attr({'target':'iframe_{$this->uniqueid}'});
								var iframe = $('<iframe/>').attr({'name': 'iframe_{$this->uniqueid}'}).hide();
							__optin_code.append(iframe);";

						echo "$('div#vidOptin_{$this->uniqueid}').append($('<div/>').attr({'id':'optin-container-{$this->uniqueid}','class':'optin-container'}).append(__optin_code));";
					}
					else{
					echo "$('div#vidOptin_{$this->uniqueid}').append($('<div/>').attr({'id':'optin-container-{$this->uniqueid}','class':'optin-container'}).html('{$optin_code}'));";
					}
					if($_optinSet->allowskip == '1'){
						echo "$('div#vidOptin_{$this->uniqueid}').append($('<div/>').attr({'class':'element-container'}).append($('<a/>').attr({'href':'#','class':'skip-text','id':'optin_st_{$this->uniqueid}'}).html('{$_optinSet->skiptext}')));";
					}
					echo "function optinClose_{$this->uniqueid}(){ $('div#vidOptin_{$this->uniqueid}').parent().hide(); $('div#vidOptin_{$this->uniqueid}').attr('data-skip','1'); }";
					echo "$('document').ready(function(){ $('a#optin_st_{$this->uniqueid}').click(function(){
								optinClose_{$this->uniqueid}();
								videojs_{$this->uniqueid}.play();
								return false;
							});
					});";
				}

				/* call to action function define */
				if($this->calltoaction->include != 'no'){
					if($this->calltoaction->include == 'yes') $_calltoactSet = $this->calltoaction; else $_calltoactSet = $_defVidSettings->calltoaction;
						echo "$('#vidCtrl_{$this->uniqueid}').append($('<div/>').attr({'id':'vidCalltoactContainer_{$this->uniqueid}','class':'vid-calltoact-ctrl-container'}));";
						echo "$('#vidCalltoactContainer_{$this->uniqueid}').append($('<div/>').attr({'id':'vidCalltoact_{$this->uniqueid}','class':'vid-calltoact-ctrl calltoact-ctrl-default','data-skip':'0'}));";
						echo "$('div#vidCalltoact_{$this->uniqueid}').append($('<div/>').attr({'id':'element_container_{$this->uniqueid}','class':'element-container'}));";
						echo "$('div#element_container_{$this->uniqueid}').append($('<input>/').attr({'type':'button','value':'{$_calltoactSet->linkbutton->value}','class':'calltoact-button','id':'btn_calltoaction_{$this->uniqueid}'}));";
						if($_calltoactSet->allowskip == '1'){
							echo "$('div#vidCalltoact_{$this->uniqueid}').append($('<div/>').attr({'class':'element-container-skip'}).append($('<a/>').attr({'href':'#','class':'skip-text','id':'calltoact_st_{$this->uniqueid}'}).html('{$_calltoactSet->skiptext}')));";
							echo "function calltoactClose_{$this->uniqueid}(){ $('div#vidCalltoact_{$this->uniqueid}').parent().hide(); $('div#vidCalltoact_{$this->uniqueid}').attr('data-skip','1'); }";
							echo "$('document').ready(function(){ $('a#calltoact_st_{$this->uniqueid}').click(function(){
									calltoactClose_{$this->uniqueid}();
									videojs_{$this->uniqueid}.play();
									return false;
								});
							});";
						}
						echo "function calltoactRedirect_{$this->uniqueid}(){";
						if($_calltoactSet->linkbutton->target == '_blank'){
						echo "window.open('{$_calltoactSet->linkbutton->url}');";
						echo "$('div#vidCalltoact_{$this->uniqueid}').parent().hide();";
						echo "videojs_{$this->uniqueid}.play();";
						}
						else{
						echo "window.location = '{$_calltoactSet->linkbutton->url}';";
						}
						echo "}";
						echo "$('document').ready(function(){";
						echo "$('input#btn_calltoaction_{$this->uniqueid}').click(function(){";
						echo "calltoactRedirect_{$this->uniqueid}();";
						//echo "$('a#calltoact_st_{$this->uniqueid}').click(function(){ calltoactClose_{$this->uniqueid}();  videojs_{$this->uniqueid}.play();});";
						echo "});";
						echo "});";
				}


				/* Function define ends */

				/* Document Redy */

				echo "$('document').ready(function(){";
				/****************************************/
				$controls = $this->showtimeline == '1' ? 'true' : 'false';
				$muted = $this->enablehd == '1' ? 'true' : 'false';
				$_isAdmin = is_admin();
				echo "/* {$_isAdmin} */";
				$autoplay = $this->autoplay == 1 ? 'true' : 'false';

				//define vars has OPT and has Call
				echo "var hasOpt = ".(isset($_optinSet) ? '1' : '0').",
						  hasCall = ".(isset($_calltoactSet) ? '1' : '0').";";


				echo "videojs_{$this->uniqueid}  = videojs('vid_{$this->uniqueid}', { ";
				echo "'techOrder': ['youtube', 'html5'], ";
				echo '"src":"'.$this->youtubeurl.'",';
				echo "'controls': {$controls}, 'autoplay': {$autoplay} ,'muted' : {$muted}";
				echo " });";

				if($autoplay && is_admin()){
					echo "$('div#vidCtrl_{$this->uniqueid} div#vid_{$this->uniqueid} div.vjs-poster').css({'background-image':'none','z-index':'999999'}); $('div#vidCtrl_{$this->uniqueid} div#vid_{$this->uniqueid} div.vjs-poster').empty();";
				}


				echo "videojs_{$this->uniqueid}.on('firstplay', function() {";
				//echo "$('#post-1 .entry-content').css('background-color','red');";
				//echo "$('#vid_{$this->uniqueid}').addClass('video-started');";
				if(isset($_optinSet) && $_optinSet->location == 'start'){
					echo "if(!isIos) {";
						echo "videojs_{$this->uniqueid}.pause(); $('div#vidOptin_{$this->uniqueid}').parent().show();";
					echo "}";
				}

				if(isset($_calltoactSet) && $_calltoactSet->location == 'start'){
					echo "if(!isIos) {";
						echo "videojs_{$this->uniqueid}.pause();";
						echo "$('div#vidCalltoact_{$this->uniqueid}').parent().show();";
						if($_calltoactSet->autoredirect == '1'){
							echo "$('input#btn_calltoaction_{$this->uniqueid}').trigger('click');";
						}
					echo "}";
				}

				echo "});";
				//echo PHP_EOL;
				echo "videojs_{$this->uniqueid}.on('ended', function() {";
				//echo PHP_EOL;
				//echo "alert('ended');";
				if(isset($_optinSet) && $_optinSet->location == 'end') {
					echo "videojs_{$this->uniqueid}.pause(); $('div#vidOptin_{$this->uniqueid}').parent().show();";
				}
				if(isset($_calltoactSet) && $_calltoactSet->location == 'end') {
				echo "videojs_{$this->uniqueid}.pause(); $('div#vidCalltoact_{$this->uniqueid}').parent().show();";
				if($_calltoactSet->autoredirect == '1'){
				echo "$('input#btn_calltoaction_{$this->uniqueid}').trigger('click');";
				} }
				//echo PHP_EOL;
				echo "});";
				//echo PHP_EOL;

				echo "videojs_{$this->uniqueid}.on('timeupdate', function() {";
				echo "if (!isIos) {";
					if(isset($_optinSet) && $_optinSet->location != 'start' && $_optinSet->location != 'end'){
						echo "if( $('div#vidOptin_{$this->uniqueid}').attr('data-skip') == '0' && videojs_{$this->uniqueid}.currentTime() > {$_optinSet->location} ){";
							echo "videojs_{$this->uniqueid}.pause();";
							echo "$('div#vidOptin_{$this->uniqueid}').parent().show();";
						echo "} ";
					}
				if(isset($_calltoactSet) && $_calltoactSet->location != 'start' && $_calltoactSet->location != 'end'){
					echo "if( $('div#vidCalltoact_{$this->uniqueid}').attr('data-skip') == '0' && videojs_{$this->uniqueid}.currentTime() > {$_calltoactSet->location} ){";
						echo "videojs_{$this->uniqueid}.pause();";
						echo "$('div#vidCalltoact_{$this->uniqueid}').parent().show(); ";
						echo "$('div#vidCalltoact_{$this->uniqueid}').attr('data-skip','1');";
						if($_calltoactSet->autoredirect == '1'){
							echo "$('input#btn_calltoaction_{$this->uniqueid}').trigger('click');";
						}
					echo "}";
					echo "}";
				}
				echo "});";

				if(!empty($_defVidSettings->playerOptions->playButtonText)){
					echo "$('div#vidCtrl_{$this->uniqueid} div.vjs-big-play-button span').html('{$_defVidSettings->playerOptions->playButtonText}');";
					echo "$('div#vidCtrl_{$this->uniqueid} div.vjs-big-play-button').addClass('withText');";
					echo "$('div#vidCtrl_{$this->uniqueid} div.vjs-big-play-button').removeClass('emptyText');";
				} else {
					echo "$('div#vidCtrl_{$this->uniqueid} div.vjs-big-play-button').removeClass('withText');";
					echo "$('div#vidCtrl_{$this->uniqueid} div.vjs-big-play-button').addClass('emptyText'); ";
					}

				echo "$('#vp_modal_addNewVideo').attr('data-autoplay',{$autoplay});";

				//Splash sucker play
		 		if($this->splashimageid != 'none'){
					echo "var _splashObject = $('<object/>').attr({";
					echo "'style' : 'object-fit: contain; display: inline-block;',";
					echo "'id' : 'splash_{$this->splashimageid}',";
					echo "'class' : 'splash',";
					echo "'data' : '".admin_url( 'admin-ajax.php' ).'?action='.Plugin_Core::$current_plugin_data['TextDomain'].'_getSvgData&uniqueid='.$this->splashimageid."'";
					echo ",});";
					echo "
					if ( isAndroid || isIos ) {
						if ( (hasOpt && !isIos) || (!hasOpt && isIos) ) {
							var image = new Image;
							image.src = '".admin_url( 'admin-ajax.php' ).'?action='.Plugin_Core::$current_plugin_data['TextDomain'].'_getSvgForImage&uniqueid='.$this->splashimageid."';

							image.onload = function() {
								$('div#vidCtrl_{$this->uniqueid} div.vjs-poster').append(image);
							};
						}
						else {
							$('div#vidOptin_{$this->uniqueid}').parent().show().css({'z-index':'999999999999'});
						}
					}
					else {
						$('div#vidCtrl_{$this->uniqueid} div.vjs-poster').append(_splashObject);
					}";
		 		}
				/*****************************************/
				echo "});";

				/* Document Ready end */

				echo "})(jQuery);";
			exit;
		}
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
}

class Plugin_videoCollection{
	private $videos;
	private $tablename = '_videos';
	public function __construct(){$this->videos = new ArrayIterator(); }
	public function _getVideos(){
		try {
			global $wpdb;
			$this->tablename = $wpdb->prefix .Plugin_Core::$current_plugin_data['TextDomain'].$this->tablename;
			$__result = $wpdb->get_results("select * from ".$this->tablename." where isdelete=0",ARRAY_A);
			foreach ($__result as $value) {
				$video = new Plugin_video();
				Plugin_Utilities::injectObjectData($value, $video);
				$video->_genShortcode();
				$this->videos->append($video);
			}
			//var_dump($this->videos);
			$obj_array = (array) $this->videos;
			echo json_encode($obj_array);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
}

