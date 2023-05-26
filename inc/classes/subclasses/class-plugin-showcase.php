<?php
class ShowCase extends ItemBase{
	public $title;
	public $desc;
	public $expdate;
	public $items;
	public $displayon;

	public function __construct(){
		parent::__construct();
		global $wpdb;
		$this->tablename = $wpdb->prefix .Plugin_Core::$current_plugin_data['TextDomain'].'_showcases';
		$this->items = array(); // [];
		$this->settings = new itemSettings();
	}
	
	private function getshowcase(){
		try {
			$_obj = Plugin_Utilities::extractDataToOjbect($this);
			if ($_obj == null) {
				echo json_encode(array('error'=>'Unable to extract object data'));
				exit;
			}
			global $wpdb;
			$__result = $wpdb->get_results("select * from ".$this->tablename." where uniqueid = '".$this->uniqueid."'",ARRAY_A);
			foreach ($__result as $value) {
				Plugin_Utilities::injectObjectData($value, $this);
			}
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}

	public function _getShowCase(){
		$this->getshowcase();
		echo json_encode($this);
		exit;
	}
	
	public function _getShowCaseByPage($_displayon){
		try {
			global $wpdb;
			$__result = $wpdb->get_results("select * from ".$this->tablename." where active ='1' and isdelete = 0 and  displayon = '".$_displayon."' order by createdate desc",ARRAY_A);			
			foreach ($__result as $value) {
				Plugin_Utilities::injectObjectData($value, $this);
				return $this;
			}
			return null;
		} catch (Exception $e) {
		}
	}

	public function _addShowCase() {
		$_obj = Plugin_Utilities::extractDataToOjbect($this);
		if ($_obj == null) {
			echo json_encode(array('error'=>'Unable to extract object data'));
			exit;
		}
		if (empty($this->uniqueid)) {
			$this->uniqueid = Plugin_Utilities::getUniqueKey(10);
		}
		else{
			$this->_updateShowCase();
		}
		if (empty($this->name)) {
			$this->name = $this->uniqueid;
		}
		global $wpdb;
		$data = array(
				'uniqueid' => $this->uniqueid,
				'name' => $this->name,
				'title' => $this->title,
				'desc' => $this->desc,
				'expdate' =>$this->expdate,
				'items' => maybe_serialize($this->items),
				'active' => $this->active,
				'displayon' => $this->displayon,
				'settings' => maybe_serialize((array)$this->settings)
		);
		$_result = $wpdb->insert($this->tablename, $data);
		if($_result){
			$showcaseitems = new ShowCaseItems($this->uniqueid);
			$showcaseitems->items = $this->items;
			$showcaseitems->_save();
		}
		echo json_encode($this);
		exit;
	}

	public function _updateShowCase() {
		$this->updateShowCase();
		echo json_encode($this);
		exit;
	}
	
	private function updateShowCase() {
		try {
			global $wpdb;
			$data = array(
					'name' => $this->name,
					'title' => $this->title,
					'desc' => $this->desc,
					'expdate' =>$this->expdate,
					'items' => maybe_serialize($this->items),
					'active' => $this->active,
					'displayon' => $this->displayon,
					'settings' => maybe_serialize((array)$this->settings)
			);
			$where = array(
					'uniqueid'=>$this->uniqueid
			);
			$__result = $wpdb->update($this->tablename, $data, $where);			
			if($__result){
				$showcaseitems = new ShowCaseItems($this->uniqueid);
				$showcaseitems->items = $this->items;
				$showcaseitems->_update();
			}
		} catch (Exception $e) {
			exit;
		}	
	}

	public function _getAllShowCases(){
		try {
			$showcases = new ArrayIterator();
			global $wpdb;
			$__result = $wpdb->get_results("select * from ".$this->tablename." where isdelete=0",ARRAY_A);
			foreach ($__result as $value) {
				$showcase = new ShowCase();
				Plugin_Utilities::injectObjectData($value, $showcase); //var_dump($item);
				$showcases->append($showcase);
			}
			$obj_array = (array)$showcases;
			echo json_encode($obj_array);
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
		exit;
	}

	public function _createShowCaseCopy(){
		try {
			$_obj = Plugin_Utilities::extractDataToOjbect($this);
			if ($_obj == null) {
				echo json_encode(array('error'=>'Unable to extract object data'));
				exit;
			}
			global $wpdb;
			$__result = $wpdb->get_results("select * from ".$this->tablename." where uniqueid = '".$this->uniqueid."'",ARRAY_A);
			foreach ($__result as $value) {
				Plugin_Utilities::injectObjectData($value, $this);
			}
			$this->uniqueid = Plugin_Utilities::getUniqueKey(10);
			$this->name = $this->name .' - Copy';
				
			$data = array(
					'uniqueid' => $this->uniqueid,
					'name' => $this->name,
					'title' => $this->title,
					'desc' => $this->desc,
					'expdate' =>$this->expdate,
					'items' => maybe_serialize($this->items),
					'active' => $this->active,
					'displayon' => $this->displayon,
					'settings' => maybe_serialize((array)$this->settings),
					'createdate' => date('Y-m-d H:i:s')
			);
			$__result = $wpdb->insert($this->tablename, $data);
			if($__result){
				$showcaseitems = new ShowCaseItems($this->uniqueid);
				$showcaseitems->items = $this->items;
				$showcaseitems->_save();
			}
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}
	
	public function _deleteShowCase() {
		try {
			$_obj = Plugin_Utilities::extractDataToOjbect($this);
			if ($_obj == null) {
				echo json_encode(array('error'=>'Unable to extract object data'));
				exit;
			}
			global $wpdb;
			$__result = $wpdb->get_results("select * from ".$this->tablename." where uniqueid = '".$this->uniqueid."'",ARRAY_A);
			foreach ($__result as $value) {
				Plugin_Utilities::injectObjectData($value, $this);
			}
			$data = array(
					'isdelete' => '1'
			);
			$where = array(
					'uniqueid'=>$this->uniqueid
			);
			$__result = $wpdb->update($this->tablename, $data, $where);
			if($__result){
				$showcaseitems = new ShowCaseItems($this->uniqueid);
				$showcaseitems->items = $this->items;
				$showcaseitems->_delete();
			}
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}
	
	public function _resetShowcaseAnalytics(){
		try {
			$this->getshowcase();
			$this->_resetAnalytics();
			echo json_encode(array('msg'=>'success'));
			exit;
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _updateDirectView(){
		try {
			$this->updateDirectViews();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _updateTotalView(){
		try {
			$this->updateViewCount();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
		}
	}
}

class ShowCaseItems{
	public $id;
	public $showcaseid;
	public $items;
	public $createdate;
	private $tablename;
	public function __construct($showcaseid = null){
		$this->showcaseid = $showcaseid;
		global $wpdb;
		$this->tablename = $wpdb->prefix .Plugin_Core::$current_plugin_data['TextDomain'].'_showcase_items';
		$this->items = array(); // [];
	}
	
	public function _save() {
		try {
			global $wpdb;
			foreach ($this->items as $key => $value) {
				$data = array(
					'showcaseid' => $this->showcaseid,
					'itemid' => $value		
				);
				$wpdb->insert($this->tablename, $data);
			}
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}
	
	public function _update() {
		try {
			$this->_delete();
			$this->_save();
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}
	
	public function _delete() {
		try {
			global $wpdb;
			$where = array(
					'showcaseid' => $this->showcaseid
			);
			$wpdb->delete($this->tablename, $where);
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}
	
	public function _load() {
		try {
			global $wpdb;
			$__result = $wpdb->get_results("select * from ".$this->tablename." where showcaseid = '".$this->showcaseid."'",ARRAY_A);
			foreach ($__result as $value) {
				array_push($this->items, $value);
			}
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}
	
	public function _inuse($itemid) {
		try {
			$showcaseids = array(); //[];
			global $wpdb;
			$__result = $wpdb->get_results("select distinct showcaseid from ".$this->tablename." where itemid = '".$itemid."'",ARRAY_A);
			foreach ($__result as $value) {
				array_push($showcaseids, $value);
			}
			return $showcaseids;
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}
}

