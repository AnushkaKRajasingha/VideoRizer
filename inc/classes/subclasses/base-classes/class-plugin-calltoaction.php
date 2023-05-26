<?php
require_once 'class-plugin-actionbutton.php';
class Plugin_Calltoaction{
	public $include;
	public $linkbutton;
	public $autoredirect;
	public $location;
	public $customstyle;
	public $btncolor;
	public $allowskip;
	public $skiptext;
	public function __construct(){
		$this->include = false;
		$this->linkbutton = new LinkButton();
		$this->autoredirect = false;
		$this->location = "start";
	}
}