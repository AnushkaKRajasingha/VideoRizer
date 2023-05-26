<?php

interface Attr{
	public function _getCssProperty();
} 
class Color implements Attr{
	public $R;
	public $G;
	public $B;
	public $Opacity;
	public function __construct(){$this->R = 255; $this->G = 255; $this->B = 255; $this->Opacity = 1;} 
	public function Color($r,$g,$b,$opacity = 1){$this->R = $r; $this->G = $g; $this->B = $b; $this->Opacity = $opacity;}
	public function _getCssProperty(){
		return "color: rgba($this->R,$this->G,$this->B,$this->Opacity);";
	}
	public function _getColorStr(){
		return "rgba($this->R,$this->G,$this->B,$this->Opacity)";
	}
	public function toString(){
		return "rgba($this->R,$this->G,$this->B,$this->Opacity)";
	}
}

class Background implements Attr{
	public $color;
	public $image;
	public $opacity;
	public $repate;
	public function __construct(){$this->color = "rgba(255,255,255,1)";$this->image = ""; $this->opacity = 1;$this->repate = "no-repeat";}
	public function Background($_color,$_image,$_opacity = 1, $_repeat = "no-repeat"){$this->color = $_color; $this->image = "url('$_image')"; $this->opacity = $_opacity;$this->repate = $_repeat; }
	public function _getCssProperty(){
		return "background:".$this->image." ".$this->color->_getColorStr()." ".$this->repate." ".$this->opacity.";";
	}
}

class Fonts implements Attr{
	
	public $fontfamily;
	public $fontsize;
	public $fontsizeadjust;
	public $fontstretch;
	public $fontstyle;
	public $fontvariant;
	public $fontweight;
	public $lineheight;
	
	public function __construct(){
		
		$default_css = init_var::_getDefaultCssSettings();
		$this->fontfamily = $default_css['fontfamily'];
		$this->fontsize =  $default_css['fontsize'];
		$this->fontsizeadjust =  $default_css['fontsizeadjust'];
		$this->fontstretch =  $default_css['fontstretch'];
		$this->fontstyle =  $default_css['fontstyle'];
		$this->fontvariant =  $default_css['fontvariant'];
		$this->fontweight =  $default_css['fontweight'];
		$this->lineheight =  $default_css['lineheight'];
		
	}
	public function _getCssProperty(){
		return "font:".$this->fontstyle." ".$this->fontvariant." ".$this->fontweight." ".$this->fontsize."/".$this->lineheight." ".$this->fontfamily.";";
	}
}

class Position implements Attr{
	public $x;
	public $y;
	public function __construct(){}
	public function _getCssProperty(){
		return "x:".$this->x."; y:".$this->y.";";
	}
}
