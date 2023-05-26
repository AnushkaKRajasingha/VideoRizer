<?php 
require_once 'class-plugin-color.php';

interface ICss{
	public function _getStyle();
	public function _getCssRule();
}

interface IElement{
	public function setValue($value);
	public function setColor($color);
	public function setBackground($background);
	public function setFont($font);
	public function setBorder($border);
	public function changeValue($newValue);
	public function getMarkup();
	public function appendElement($element);
	public function addAttr($name,$vale);
}

class element implements IElement, ICss {
	public $id;
	public $elemuniqueid;
	public $name;
	public $title;
	public $value;
	public $color;
	public $background;
	public $font;
	public $border;
	public $style;
	public $class;
	public $type;
	public $tag;
	public $position;
	private $previousValue;
	private $dom;
	private $domend;
	private $_markup;
	private $innetHtml;
	private $cssdom;
	private $attrib = Array();
	private $childrens = Array();
	

	public function __construct(){
		$this->elemuniqueid = Plugin_Utilities::getUniqueKey(15);
		$this->value = 'Default Text';
		$this->color = new Color();
		$this->background = new Background();
		$this->font = new Fonts();
		$this->position = new Position();		
	}

	public function setValue($value){	$this->value = $value; $this->_buildMarkup();	}	
	public function setColor($color){	$this->color = $color; $this->_buildMarkup();	}
	public function setBackground($background){	$this->$background = $background; $this->_buildMarkup();}
	public function setFont($font){ $this->$font = $font; $this->_buildMarkup(); }
	public function setBorder($border){	$this->$border = $border; $this->_buildMarkup();}
	public function changeValue($newValue){ $this->previousValue = $this->value;	$this->value = $newValue; $this->_buildMarkup();}
	public function propertyChanged(){$this->_buildMarkup();}
	
	public function _getStyle(){
		return $this->color->_getCssProperty().$this->background->_getCssProperty().$this->font->_getCssProperty();
	}
	
	public function _getCssRule(){		
		if (isset($this->id)) {
			$this->cssdom .= "#".$this->id;
		}
		if (isset($this->class)) {
			$this->cssdom .= ".$this->class";
		}
		if (isset($this->name)) {
			$this->cssdom .="[name='$this->name']";
		}
		return $this->cssdom."{ ".$this->_getStyle()." }";
	}
	
	private function _buildMarkup($element = ""){
		$this->dom = "< "; $this->domend = "/>";
		if(!empty($element))		
			$this->innetHtml .= $element;
		if (!isset($this->tag)) {$this->tag ='input';}		
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
			$this->dom .= "style='$this->_getStyle()' ";
		}
		
		if (isset($this->value)) {
			if($this->tag != 'defs')
			$this->dom .="value='$this->value' ";
		}
		
		if (isset($this->type)) {
			$this->dom .="type='$this->type' ";
		}
		
		foreach ($this->attrib as $key => $value) {
			$this->dom .="$key='$value' ";
		}
		
		foreach ($this->childrens as $value) {
			$this->innetHtml .= $value." ";
		}
		
		$this->_markup =  $this->dom.">".$this->innetHtml.$this->domend;
		return $this->_markup;
	}
	
	public function addAttr($name,$value){
		if (isset($name) && isset($value)) {
			//return $this->dom." $name='$value' >".$this->innetHtml.$this->domend;
			$this->attrib[$name] = $value;
		}
		return $this->_buildMarkup();
	}
	
	public function getMarkup(){
		return $this->_buildMarkup();
	}
	
	public function appendElement($element){ 
		array_push($this->childrens,$element);
	}
	
	public function _save(){
		try {
			
		} catch (Exception $e) {
		}
	}
}