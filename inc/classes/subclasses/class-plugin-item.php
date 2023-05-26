<?php
class Plugin_item extends ItemBase {
	public function __construct(){
		parent::__construct();
		global $wpdb;
		$this->tablename = $wpdb->prefix .Plugin_Core::$current_plugin_data['TextDomain'].'_items';
	}
	
	private function getItems(){
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
	
	public function _getItems(){
		$this->getItems();
		echo json_encode($this);
		exit;
	}
	
	public function _getItemByUniqueid($uniqueid){
		try {
			global $wpdb;
			$__result = $wpdb->get_results("select * from ".$this->tablename." where uniqueid = '".$uniqueid."'",ARRAY_A);
			foreach ($__result as $value) {
				Plugin_Utilities::injectObjectData($value, $this);
			}			
		} catch (Exception $e) {
			exit;
		}
	}

	public function _addItems(){
		$_obj = Plugin_Utilities::extractDataToOjbect($this);
		if ($_obj == null) {
			echo json_encode(array('error'=>'Unable to extract object data'));
			exit;
		}
		if (empty($this->uniqueid)) {
			$this->uniqueid = Plugin_Utilities::getUniqueKey(10);
		}
		else{
			$this->__update();
			echo json_encode($this);
			exit;
		}
			
		if (empty($this->name)) {
			$this->name = $this->uniqueid;
		}
		global $wpdb;
		$data = array(
				'uniqueid' => $this->uniqueid,
				'name' => $this->name,
				'active' => $this->active,
				'settings' => maybe_serialize($this->settings)
		);
		$wpdb->insert($this->tablename, $data);
		echo json_encode($this);
		exit;
	}

	public function _updateItem(){
		$this->__update();
		echo json_encode($this);
		exit;
	}
	
	protected function __update(){
		try {
			global $wpdb;
			$data = array(
					'name' => $this->name,
					'active' => $this->active,
					'settings' => maybe_serialize((array)$this->settings)
			);
			$where = array(
					'uniqueid'=>$this->uniqueid
			);
			$wpdb->update($this->tablename, $data, $where);
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message('Update From Item');
		} catch (Exception $e) {
			exit;
		}
	}

	public function _changeStatus(){
		$_obj = Plugin_Utilities::extractDataToOjbect($this);
		if ($_obj == null) {
			echo json_encode(array('error'=>'Unable to extract object data'));
			exit;
		}
		global $wpdb;
		$data = array(
				'active' => $this->active
		);
		$where = array(
				'uniqueid'=>$this->uniqueid
		);
		$wpdb->update($this->tablename, $data, $where);
		exit;
	}

	public function _careatItemCopy(){
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
					'active' => $this->active,
					'settings' => maybe_serialize((array)$this->settings),
					'createdate' => date('Y-m-d H:i:s')
			);
			$wpdb->insert($this->tablename, $data);
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}
	
	public function _deleteItem() {
		try {
			$_obj = Plugin_Utilities::extractDataToOjbect($this);
			if ($_obj == null) {
				echo json_encode(array('error'=>'Unable to extract object data'));
				exit;
			}
			
			$showcaseitems = new ShowCaseItems();
			$showcaseids = $showcaseitems->_inuse($this->uniqueid);
			if (count($showcaseids)>0) {
				echo json_encode(array('error'=>"Sorry, this item can't be deleted. In order to delete it, you have to exclude it from all Pages first."));
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
			$wpdb->update($this->tablename, $data, $where);
			echo json_encode($this);
			exit;
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			exit;
		}
	}
	
	public function _resetItemAnalytics(){
		try {
			$this->getItems();
			$this->_resetAnalytics();
			echo json_encode(array('msg','success'));
			exit;
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
	
	public function _updateTotaleView(){
		try {			
			$this->updateViewCount();
		} catch (Exception $e) {
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
		}
	}
	
	public function _updateItemSubmitView() {
		try {	
			$this->getItems();
			$this->updateSubmits();
			exit;
		} catch (Exception $e) {
			echo json_encode(array('error'=>$e->getMessage()));
			$errorlogger = new ErrorLogger();
			$errorlogger->add_message($e->getMessage());
			exit;
		}
	}
}


class itemCollection{
	private $items;
	public function __construct(){
		$this->items = new ArrayIterator();

	}
	public function _getAllItems(){
		try {
			global $wpdb;
			$this->tablename = $wpdb->prefix .Plugin_Core::$current_plugin_data['TextDomain'].'_items';
			$__result = $wpdb->get_results("select * from ".$this->tablename." where isdelete=0",ARRAY_A);
			foreach ($__result as $value) {
				$item = new Plugin_item();
				Plugin_Utilities::injectObjectData($value, $item); //var_dump($item);
				$this->items->append($item);
			}
			$obj_array = (array)$this->items;
			echo json_encode($obj_array);
			exit;
		} catch (Exception $e) {
			echo $e;
		}
	}
}
