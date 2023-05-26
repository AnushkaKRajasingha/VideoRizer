<?php
require_once 'class-plugin-elements.php';
class Links extends element{
	public $url;
	public $target;
	public function __construct(){
		parent::__construct();
		$this->tag = "a"; 
		$this->target = '_self';
		$this->addAttr('target', $this->target);
	}
}