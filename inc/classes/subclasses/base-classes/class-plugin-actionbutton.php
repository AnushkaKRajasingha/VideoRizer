<?php
require_once 'class-plugin-elements.php';
require_once 'class-plugin-links.php';
class Button extends element {
	public function __construct(){
		parent::__construct();
		$this->type = 'button';
		$this->addAttr('type', $this->type);
		$this->getMarkup();
	}
}
class LinkButton extends Links{
	public function __construct(){
		parent::__construct();
		$_button = new Button();
		$this->appendElement($_button->getMarkup());
	}
}