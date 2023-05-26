<?php

/**
 * @author Anushka Rajasingha
 * @url http://www.anushkar.com
 * @date 07/09/2014
 *
 */

interface ISize{
	public function setWidth($width);
	public function setHeight($height);
	public function setAspectRatio($aspectratio);	
}

class Size implements ISize{
	
	public function __construct(){}
	public $width;
	public $height;
	public $aspectratio;
	
	public function setWidth($width){$this->width = $width;}
	public function setHeight($height){$this->height = $height;}
	public function setAspectRatio($aspectratio){$this->aspectratio = $aspectratio;}
}