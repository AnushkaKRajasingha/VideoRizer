<?php
class Plugin_splash extends Plugin_Core{
	public $id;
	public $uniqueid;
	public $splashName;
	/*public $splashElemsIds;	
	public $splashMargins;
	public $splashPaddings;
	public $splashBackground;
	public $splashSize;
	public $splashBorder;
	public $splashDataURL;*/
	public $splashTemplateId;
	public $paramFields;	
	public $splashCustStyles;
	public $copyof;
	public $createdate;
	public $active;
	public $deleted;

	private $tablename = '_splash';
	 
	public function __construct(){
		$this->_init();		
	}
	
	private function _validateId(){
		try {
			if (isset($_POST['uniqueid']) && !empty($_POST['uniqueid'])) {
				$this->uniqueid = $_POST['uniqueid'];
			}
			else if(isset($_POST['data']['uniqueid']) && !empty($_POST['data']['uniqueid'])) {
				$this->uniqueid = $_POST['data']['uniqueid'];
			}
			else if (isset($_REQUEST['uniqueid'])){
				$this->uniqueid = $_REQUEST['uniqueid'];
			}
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
	
	private function _init(){
		try {
			$this->splashName = '';
			$this->splashTemplateId = '';
			$this->paramFields = Array();	
			/*$this->splashElemsIds = Array();
			$this->splashMargins = 0;
			$this->splashPaddings = 0;
			$this->splashBackground = new Background();
			$this->splashSize = new Size();
			$this->splashBorder = Array();
			$this->splashDataURL = "";*/
			$this->copyof = 0;			
			$this->splashCustStyles ="";	
			global $wpdb;
			$this->tablename = $wpdb->prefix .Plugin_Core::$current_plugin_data['TextDomain'].$this->tablename;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	private function _save(){
		try {		
			//var_dump($this->splashSize);
			/*if(is_object($this->splashSize)){
				$this->splashSize = (array) $this->splashSize;
			}
			if(is_object($this->splashBackground)){
				$this->splashBackground = (array) $this->splashBackground;
			}*/
			/*if(is_object($this->paramFields)){
				$this->paramFields = (array) $this->paramFields;
			}*/
				
			global $wpdb;
			$dbdata = array(
					'uniqueid' => $this->uniqueid,
					'splashName' => $this->splashName,
					/*'splashElemsIds' => maybe_serialize($this->splashElemsIds),
					'splashMargins' => $this->splashMargins,
					'splashPaddings' => $this->splashPaddings,
					'splashBackground' => maybe_serialize($this->splashBackground),
					'splashBorder' => maybe_serialize($this->splashBorder),
					'splashSize' => maybe_serialize($this->splashSize),
					'splashDataURL' => $this->splashDataURL,*/
					'copyof' => $this->copyof,					
					'splashCustStyles' => $this->splashCustStyles,
					'splashTemplateId' =>$this->splashTemplateId,
					'paramFields' => maybe_serialize((array)$this->paramFields)
			);
			
			$wpdb->insert($this->tablename, $dbdata);
			$this->id = $wpdb->insert_id;
			//var_dump($wpdb->last_error);
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	private function _copy(){
		try {
			global $wpdb;
			$this->uniqueid = Plugin_Utilities::getUniqueKey(10);
			$this->splashName = 'Copy of '.$this->splashName;
			/*$splash_elem_tbl = $wpdb->prefix .Plugin_Core::$current_plugin_data['TextDomain']."_splashElement";
			$new_splashElemsIds = Array();
			$copyelem = false;
			foreach ($this->splashElemsIds as $value) {
				$new_unique_id = Plugin_Utilities::getUniqueKey(10);
				$create_tmptbl_query = "CREATE TEMPORARY TABLE temptbl_splashelement SELECT * FROM $splash_elem_tbl WHERE elemuniqueid = '$value'; ";
				$update_temptbl_query = "UPDATE temptbl_splashelement SET elemuniqueid = '$new_unique_id' ,id = NULL; ";
				$insert_data_query = "INSERT INTO $splash_elem_tbl SELECT * FROM temptbl_splashelement;";
				$drop_temptbl_query = "DROP TEMPORARY TABLE IF EXISTS temptbl_splashelement;";
				//echo $element_copy_query;
				if($wpdb->query($create_tmptbl_query) && $wpdb->query($update_temptbl_query) && $wpdb->query($insert_data_query) && $wpdb->query($drop_temptbl_query)){
					$new_splashElemsIds[] = $new_unique_id;
					$copyelem = true;
				}else{$copyelem = false; break;}
			}
			$this->splashElemsIds = $new_splashElemsIds;*/			
			$this->_save();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	private function _delete(){
		try {
			$this->deleted = 1;
			$this->_updateSplash();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _getSvgForImage(){
		try {
				$this->_validateId();
				$this->__getSplash();			
				header("Content-type: image/svg+xml");				
				$splashTemp = new Plugin_splashTemplates();
				$tempFile = $splashTemp->__splashTemplates($this->splashTemplateId);
				$_varSvgData = $tempFile['svgData'];
				$defaultValues = json_decode($tempFile['Default_Values']);
				foreach ($tempFile['param'][0] as $key => $value) {
					$var_value =   str_replace('{', '', $value);
					$var_value =   str_replace('}', '', $var_value);
					$var_value_type = substr($var_value, strripos($var_value, ' ')+1);
					$var_value_fieldName = str_replace(' ', '_', $var_value);
					$replaceValue = isset($this->paramFields[$var_value_fieldName] ) ?  $this->paramFields[$var_value_fieldName] :  $defaultValues[$var_value];
					if($var_value_type == 'image'){
						$replaceValue = 'data:image/png;base64,'.base64_encode(file_get_contents($replaceValue));
					}
					$_varSvgData = str_replace($value, $replaceValue, $_varSvgData);
				}
			header('Content-type: image/svg+xml');
			print($_varSvgData);exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _getSvgData(){
		try {
			$this->_validateId();
			$this->__getSplash();
			header("Content-type: image/svg+xml");
			header("X-Frame-Options: GOFORIT");
			$splashTemp = new Plugin_splashTemplates();
			$tempFile = $splashTemp->__splashTemplates($this->splashTemplateId);
			$_varSvgData = $tempFile['svgData'];
			$defaultValues = json_decode($tempFile['Default_Values']);
			foreach ($tempFile['param'][0] as $key => $value) {
				$var_value =   str_replace('{', '', $value);
				$var_value =   str_replace('}', '', $var_value);
				$var_value_type = substr($var_value, strripos($var_value, ' ')+1);
				$var_value_fieldName = str_replace(' ', '_', $var_value);
				$replaceValue = isset($this->paramFields[$var_value_fieldName] ) ?  $this->paramFields[$var_value_fieldName] :  $defaultValues[$var_value];				
				$_varSvgData = str_replace($value, $replaceValue, $_varSvgData);
			}
			header('Content-type: image/svg+xml');
			print($_varSvgData);exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function __getSplash(){
		try {
			if(isset($this->uniqueid)){
				global $wpdb;
				$__result = $wpdb->get_row("select * from ".$this->tablename." where uniqueid='".$this->uniqueid."'",ARRAY_A);
				Plugin_Utilities::injectObjectData($__result, $this);
				$_paramfields = unserialize($__result['paramFields']);
				$this->paramFields = $_paramfields;
				//Plugin_Utilities::injectObjectData($__result['paramFields'], $this->paramFields);
				//echo json_encode($this);
			}
			else{
				json_encode(array('msgError' => 'Invalid unique id'));
				exit;
			}
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	
	public function _getSplash(){
		try {
			$this->_validateId();
			$this->__getSplash();
			echo json_encode($this);
			//$_svg = $this->genSVG();			
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _updateSplash(){
		try {
			/*if(is_object($this->splashSize)){
				$this->splashSize = (array) $this->splashSize;
			}
			if(is_object($this->splashBackground)){
				$this->splashBackground = (array) $this->splashBackground;
			}*/
			/*if(is_object($this->params)){
				$this->params = (array) $this->params;
			}*/
			
			global $wpdb;
			$dbdata = array(
					'splashName' => $this->splashName,
					/*'splashElemsIds' => maybe_serialize($this->splashElemsIds),		
					'splashMargins' => $this->splashMargins,
					'splashPaddings' => $this->splashPaddings,
					'splashBackground' => maybe_serialize($this->splashBackground),
					'splashBorder' => maybe_serialize($this->splashBorder),
					'splashSize' => maybe_serialize($this->splashSize),
					'splashDataURL' => $this->splashDataURL,*/
					'copyof' => $this->copyof,					
					'splashCustStyles' => $this->splashCustStyles,
					'active' => $this->active,
					'deleted' => $this->deleted,
					'splashTemplateId' =>$this->splashTemplateId,
					'paramFields' => maybe_serialize((array)$this->paramFields)
			);
			$wpdb->update($this->tablename, $dbdata, array('uniqueid' => $this->uniqueid));
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _saveSplash(){
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
				$this->_updateSplash();
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
	
	public function _updatesplashDataURL(){
		/*try {
			$this->_validateId();
			if (isset($_POST['DataURL']) && !empty($_POST['DataURL'])) {
				$this->splashDataURL = $_POST['DataURL'];
			}
			global $wpdb;
			$dbdata = array(					
					'splashDataURL' => $this->splashDataURL
			);
			$wpdb->update($this->tablename, $dbdata, array('uniqueid' => $this->uniqueid));
			echo json_encode(array('msg' => init_var::getSysMsg(1)));
			exit;
			
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}*/
		exit;
	}
	
	
	public function __getAllsplash(){
		try {
			$splash_col = new ArrayIterator();
			global $wpdb;
			$__result = $wpdb->get_results("select * from ".$this->tablename." where deleted=0",ARRAY_A);
			foreach ($__result as $value) {
				$__splash = new Plugin_splash();
				Plugin_Utilities::injectObjectData($value, $__splash);
				$splash_col->append($__splash);
			}
			//var_dump($this->videos);
			$obj_array = (array) $splash_col;
			return $obj_array;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _getAllsplash(){		
		try {
			$splash_col = new ArrayIterator();
			global $wpdb;			
			$__result = $wpdb->get_results("select * from ".$this->tablename." where deleted=0",ARRAY_A);
			foreach ($__result as $value) {
				$__splash = new Plugin_splash();
				Plugin_Utilities::injectObjectData($value, $__splash);				
				$splash_col->append($__splash);
			}
			//var_dump($this->videos);
			$obj_array = (array) $splash_col;
			echo json_encode($obj_array);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _careatSplashCopy(){
		try {
			$this->_validateId();
			$this->__getSplash();
			$this->_copy();
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _deleteSplash(){
		try {
			$this->_validateId();
			$this->__getSplash();
			$this->_delete();
			exit;	
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function __getParmFields(){
		try {
			$prefix = 'paramFields.';
			$splashTemp = new Plugin_splashTemplates();
			$tempFile = $splashTemp->__splashTemplates($this->splashTemplateId);
			//var_dump($this->paramFields);
			$paramFieldList = '';
			$formgroup = '<div class="form-group">';
			$formgroup_end = '</div>';
			$fieldContainer = '<div class="col-lg-8">';
			$fieldContainer_end = '</div>';
			foreach ($tempFile['param'][0] as $key => $value) {
				$var_value =   str_replace('{', '', $value);
				$var_value =   str_replace('}', '', $var_value);
				$var_value_type = substr($var_value, strripos($var_value, ' ')+1);
				$var_value_fieldName = str_replace(' ', '_', $var_value);
				$var_field ='';
				$fieldlable = '<label class="control-label col-md-3" for="'.$var_value_fieldName.'">'.$var_value.'</label>';
				$var_textfield_type = $var_value_type == 'size' || $var_value_type == 'x' || $var_value_type == 'y' || $var_value_type == 'x2' || $var_value_type == 'y2' || $var_value_type == 'width' || $var_value_type == 'height' || $var_value_type == 'duration'  ? 'number' : 'text';
				$field_value = $this->paramFields[$var_value_fieldName];
				switch ($var_value_type) {
					case 'color':
						{
							$var_field = '<div data-color-format="rgba" data-color="'.$field_value.'" class="input-append colorpicker-default color">'
											.'<input type="text" readonly="readonly" class="form-control paramField" data-field-value="yes" data-type="color" data-field-name="'.$prefix.$var_value_fieldName.'" required="required" placeholder="'.$var_value.'" name="'.$prefix.$var_value_fieldName.'" value="'.$field_value.'"/>'
											.'<span class="input-group-btn add-on"><button class="btn btn-white" type="button" style="padding:8px"><i style="background-color: '.$field_value.';"></i></button></span></div>';
						}
					break;					
					default:
						{
							$extra_css_class = $var_value_type == 'image' ? 'wp-media' : '';
							$var_field = '<input type="'.$var_textfield_type.'" class="form-control paramField '.$extra_css_class.'" data-field-value="yes" data-field-name="'.$prefix.$var_value_fieldName.'" name="'.$prefix.$var_value_fieldName.'" placeholder="'.$var_value.'"  value="'.$field_value.'"/>';
						}
					break;
				}
				
				//var_dump($var_value_type);
				echo $formgroup.$fieldlable.$fieldContainer.$var_field.$fieldContainer_end.$formgroup_end;			
			}
			//echo $paramFieldList;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
}

class Plugin_splashElement extends element{
	public $size;
	public $textanchor;
	public $xlinkhref;
	public $fontcolor;
	
	private $previousValue;
	private $dom;
	private $domend;
	private $_markup;
	private $innetHtml;
	private $cssdom;
	private $tablename = '_splashElement';
	private $attrib = Array();
	private $childrens = Array();
	public function __construct(){
		parent::__construct();
		$this->size = new Size();
		$this->textanchor = 'start';
		global $wpdb;
		$this->tablename = $wpdb->prefix .Plugin_Core::$current_plugin_data['TextDomain'].$this->tablename;
	}
	
	private function _buildMarkup($element = ""){
		$this->dom = "< "; $this->domend = "/>";
		if(!empty($element))
			$this->innetHtml .= $element;
		if (!isset($this->tag)) {$this->tag ='text';}
		if (isset($this->tag)) {
			$this->dom = "<$this->tag ";
			$this->domend = "</$this->tag>";
		}
		if (isset($this->id)) {
			$this->dom .= "id='$this->id' ";
		}
		if (isset($this->name)) {
			$this->dom .= "name='$this->name' ";
		}
		if (isset($this->class)) {
			$this->dom .= "class='$this->class' ";
		}
		if (isset($this->style)) {
			$this->dom .= "style='$this->style' ";
		}
	
		if (isset($this->value) && $this->tag == 'text') {
			$this->innetHtml = $this->value;
		}
	
		if (isset($this->type)) {
			$this->dom .="type='$this->type' ";
		}

		if (isset($this->size->width)) {
			if($this->tag == 'line'){
				$this->dom .="x2='".$this->size->width."' ";
			}
			else if($this->tag == 'circle'){
				$this->dom .="r='".$this->size->width."' ";
			}
			else
				$this->dom .="width='".$this->size->width."' ";
		}
		if (isset($this->size->height)) {
			if($this->tag == 'line'){
				$this->dom .="y2='".$this->size->height."' ";
			}
			else
			$this->dom .="height='".$this->size->height."' ";
		}
		if (isset($this->position->x)) {
			if($this->tag == 'line'){
				$this->dom .="x1='".$this->position->x."' ";
			}
			else if($this->tag == 'circle'){
				$this->dom .="cx='".$this->position->x."' ";
			}
			else
			$this->dom .="x='".$this->position->x."' ";
		}
		if (isset($this->position->y)) {
			if($this->tag == 'line'){
				$this->dom .="y1='".$this->position->y."' ";
			}
			else if($this->tag == 'circle'){
				$this->dom .="cy='".$this->position->y."' ";
			}
			else
			$this->dom .="y='".$this->position->y."' ";
		}
		if (isset($this->xlinkhref) && !empty($this->xlinkhref)) {			
			$this->dom .="xlink:href='$this->xlinkhref' ";
		}		
		if(isset($this->fontcolor)){
			if($this->tag == 'line'){
				$this->dom .= "stroke='$this->fontcolor' ";
			}else
			$this->dom .= "fill='$this->fontcolor' ";
		}
		
		if(isset($this->font->fontsize)){
			if($this->tag == 'line'){
				$this->dom .= "stroke-width='".$this->font->fontsize."' ";
			}else
			$this->dom .= "font-size='".$this->font->fontsize."px' ";
		}
		
		if(isset($this->font->fontweight)){
			$this->dom .= "font-wieght='".$this->font->fontweight."' ";
		}
		
		foreach ($this->attrib as $key => $value) {
			$this->dom .="$key='$value' ";
		}
		
		if(isset($this->textanchor)){
			$this->dom .= "text-anchor='".$this->textanchor."' ";
		}
		
		if(isset($this->border)){
			if($this->border == 'dotted'){
				$this->dom .= "stroke-dasharray='".$this->font->fontsize.",".$this->font->fontsize."' ";
			}
			if($this->border == 'dashed'){
				$this->dom .= "stroke-dasharray='".$this->font->fontsize * 2 .",".$this->font->fontsize * 2 ."' ";
			}
		}
		
		
		foreach ($this->childrens as $value) {
			$this->innetHtml .= $value." ";			
		}
		
		//$this->dom .= "transform = 'scale(0.5)'";
		
		$this->_markup =  $this->dom.">".$this->innetHtml.$this->domend;
		return $this->_markup;
	}
	
	
	public function _getMarkup(){
		return $this->_buildMarkup();
	}
	
	public function getMarkup(){
		try {			
			return parent::getMarkup();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	
	private function _updateSplashElement(){
		try {
			global $wpdb;
			$dbdata = array(					
					'name' => $this->name,
					'title' => $this->title,
					'value' => $this->value,
					'fontcolor' => $this->fontcolor,
					'background' => maybe_serialize($this->background),
					'font' => maybe_serialize($this->font),
					'border' => $this->border,
					'style' => $this->style,
					'class' => $this->class,
					'type' => $this->type,
					'tag' => $this->tag,
					'position' =>  maybe_serialize( $this->position),
					'size' => maybe_serialize( $this->size),
					'textanchor' =>   $this->textanchor,
					'xlinkhref' => $this->xlinkhref
			);
			$wpdb->update($this->tablename, $dbdata, array('elemuniqueid' => $this->elemuniqueid));
			echo json_encode($this);;
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}

	public function _saveSplashElement(){
		try {
			$_obj = Plugin_Utilities::extractDataToOjbect($this);
			if ($_obj == null) {
				echo json_encode(array('error'=>'Unable to extract object data'));
				exit;
			}
			if (empty($this->elemuniqueid)) {
				$this->elemuniqueid = Plugin_Utilities::getUniqueKey(10);
			}
			else{
				$this->_updateSplashElement();
				echo json_encode($this);
				exit;
			}
			
			global $wpdb;
			$dbdata = array(
					'elemuniqueid' => $this->elemuniqueid,
					'name' => $this->name,
					'title' => $this->title,					
					'value' => $this->value,
					'fontcolor' => $this->fontcolor,
					'background' => maybe_serialize($this->background),
					'font' => maybe_serialize($this->font),
					'border' => $this->border,
					'style' => $this->style,
					'class' => $this->class,
					'type' => $this->type,
					'tag' => $this->tag,
					'position' =>  maybe_serialize( $this->position),
					'size' => maybe_serialize( $this->size),					
					'textanchor' =>   $this->textanchor,
					'xlinkhref' => $this->xlinkhref
			);
				
			$wpdb->insert($this->tablename, $dbdata);				
			$this->id = $wpdb->insert_id;
			$this->__getSplashElement();
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function __getSplashElement(){
		try {			
			if(isset($this->elemuniqueid)){
				global $wpdb;
				$__result = $wpdb->get_row("select * from ".$this->tablename." where elemuniqueid='".$this->elemuniqueid."'",ARRAY_A);
				Plugin_Utilities::injectObjectData($__result, $this);
				//echo json_encode($this);
			}
			else{
				json_encode(array('msgError' => 'Invalid unique id'));
				exit;
			}
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _getSplashElement(){
		try {
			if (isset($_POST['elemuniqueid'])) {
				$this->elemuniqueid = $_POST['elemuniqueid'];
			}
			$this->__getSplashElement();
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
}
