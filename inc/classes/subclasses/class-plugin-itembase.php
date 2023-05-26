<?php
class ItemBase{
	public $id;
	public $uniqueid;
	public $name;
	public $settings;
	public $copyof;
	public $active;
	public $createdate;
	public $isdelete;
	protected $tablename;
	
	public function __construct(){
		$this->uniqueid = Plugin_Utilities::getUniqueKey(10);
		$this->settings = new itemSettings();
	}
	
	public function _resetAnalytics() {
		try {
			$this->settings->analytics->viewcount = 0;
			$this->settings->totalviewcount = 0;
			$this->settings->analytics->directviews = 0;
			$this->settings->directview = 0;
			$this->settings->analytics->submits = 0;
			$this->settings->noofsubmits = 0;
			$this->__update();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
		}
	}
	
	public function updateViewCount(){
		try {
			$this->settings->analytics->viewcount ++;
			$this->settings->totalviewcount ++;
			$this->__update();			
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
		}
	}
	
	public function updateDirectViews(){
		try {
			$this->settings->analytics->directviews ++;
			$this->settings->directview ++;
			$this->__update();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
		}
	}
	
	public function updateSubmits(){
		try {
			$this->settings->analytics->submits ++;
			$this->settings->noofsubmits ++;
			$this->__update();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
		}
	}
	
	private function __update(){
		try {
			global $wpdb;
			$data = array(
					'name' => $this->name,
					'copyof' => $this->copyof,
					'createdate' =>$this->createdate,
					'active' => $this->active,
					'isdelete'=>$this->isdelete,
					'settings' => maybe_serialize((array)$this->settings)
			);
			$where = array(
					'uniqueid'=>$this->uniqueid
			);
			$wpdb->update($this->tablename, $data, $where);
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
		}
	}
}

class itemSettings{
	public $imageUrl;
	public $linkText;
	public $linkUrl;
	public $desc;
	public $totalviewcount;
	public $directview;
	public $noofsubmits;
	public $analytics;
	public $bgcolor;
	public $bgimageurl;
	
	public function __construct(){
		$this->directview = 0;
		$this->totalviewcount = 0;
		$this->noofsubmits = 0;
		$this->analytics = new ItemAnalytics();
	}

	public function  analytics_reset(){
		$this->directview = 5;
		$this->noofsubmits = 3;
		$this->totalviewcount = 20;
	}
}

class ItemAnalytics{
	public $viewcount;
	public $directviews;
	public $submits;
	public function __construct(){
		$this->directviews = 0;
		$this->viewcount = 0;
		$this->submits = 0;
	}
	
	public function _reset() {
		$this->directviews = 10;
		$this->submits = 5;
		$this->viewcount = 25;
	}
}