<?php
class Plugin_Utilities extends Plugin_Core {
	public function __construct() {
	}
	public static function flattenArray($input, $maxdepth = NULL, $depth = 0) {
		if (! is_array ( $input )) {
			return $input;
		}
		
		$depth ++;
		$array = array ();
		foreach ( $input as $key => $value ) {
			if (($depth <= $maxdepth or is_null ( $maxdepth )) && is_array ( $value )) {
				$array = array_merge ( $array, self::flattenArray ( $value, $maxdepth, $depth ) );
			} else {
				array_push ( $array, $value );
				// or $array[$key] = $value;
			}
		}
		return $array;
	}
	
	/*
	 * public static function array_flatten($array) { $return = array(); array_walk_recursive($array, function($x) use (&$return) { $return[] = $x; }); return $return; }
	 */
	public static function getUniqueKey($lenght) {
		$unique_key = substr ( md5 ( rand ( 0, 1000000 ) ), 0, $lenght );
		return $unique_key;
	}
	
	
	public static function extractDataToOjbect(&$_object) {
		if (isset ( $_POST ['data'] ) && ! empty ( $_POST ['data'] )) {
			$data = $_POST ['data'];
			foreach ( $_object as $key => &$value ) {
				if (array_key_exists ( $key, $data ))
					$value = $data [$key];
			}
			return $_object;
		} else {
			return null;
		}
	}
	
	/*
	 * public static function injectObjectData($data,&$_object) { foreach($data as $key => $value) { if($value != null && ($value == '0' || !empty($value))) if(is_array($value) && is_object($_object->$key)){ $class = get_class($_object->$key); $obj = new $class(); foreach ($value as $key2 => $value2) { if($value2 != null && !empty($value2)) $obj->$key2 = $value2; } //$_object->$key = $obj; } else { $_object->$key = $value;} // $value = $optin_settings[$key]; } }
	 */
	public static function injectArrayData($data, &$_object, $key) {
		if (array_key_exists ( $key, $data ) && $data [$key] != null) {
			$__resultarr = unserialize ( $data [$key] );
			foreach ( $__resultarr as $value ) {
				array_push ( $_object->$key, $value );
			}
		}
	}
	public static function injectObjectData($data, &$_object) {
		try {
			// error_reporting(0);
			if($data == null){ echo json_encode(array('msgError' => 'Invalid data object','data' => $data)); exit;}
			foreach ( $_object as $key => $value ) {
				if ($data!= null && is_object ( $_object->$key ) && array_key_exists ( $key, $data )) {
					if(is_object($data [$key])){
						$__result = (array)$data [$key];
					}
					else if(is_array($data [$key])){
						$__result = $data [$key];
					}
						else
						$__result = unserialize ( $data [$key] );
					if ($__result && is_array ( $__result )) {
						foreach ( $_object->$key as $key2 => $value2 ) {
							if (is_object ( $_object->$key->$key2 )) {
								self::injectObjectData ( $__result, $_object->$key->$key2 ); // var_dump($__result);
							} elseif (is_array ( $_object->$key->$key2 )) {
								self::injectArrayData ( $__result, $_object->$key, $key2 );
							} else {
								if (array_key_exists ( $key2, $__result ) && $__result [$key2] != null)
									$_object->$key->$key2 = stripslashes ( $__result [$key2] );
							}
						}
					} else {
						/*
						 * echo 'Is not array'; var_dump($__result);
						 */
					}
				} elseif (is_array ( $_object->$key )) {
					self::injectArrayData ( $data, $_object, $key );
				} else {
					if ($data != null && array_key_exists ( $key, $data ) && $data [$key] != null)
						if(is_object($data [$key])){
							//var_dump($data [$key]); //$_object->$key = stripslashes($data->$key);							
							//var_dump($_object->$key);
							$_object->$key = call_user_func(array($data [$key],"toString"));
							//var_dump($_object->$key);
						}
						else
							$_object->$key = stripslashes ( $data [$key] );
				}
			}
		} catch ( Exception $e ) {
		}
	}
	public static function prepairUpdateArray(&$_object) {
		var_dump ( $_object );
		if (is_object ( $_object )) {
			$updateArray = array ();
			foreach ( $_object as $key => &$value ) {
				if (is_object ( $value )) {
					echo 'Object'; // $updateArray[$key] = maybe_serialize($value);
				} else {
					echo 'Not object'; // $updateArray[$key] = $value;
				}
			}
			return $updateArray;
		} else {
			return null;
		}
	}
}
class Plugin_Collection {
	private $items = array ();
	public function addItem($obj, $key = null) {
		if ($key == null) {
			$this->items [] = $obj;
		} else {
			if (isset ( $this->items [$key] )) {
				throw new KeyHasUseException ( "Key $key already in use." );
			} else {
				$this->items [$key] = $obj;
			}
		}
	}
	public function deleteItem($key) {
		if (isset ( $this->items [$key] )) {
			unset ( $this->items [$key] );
		} else {
			throw new KeyInvalidException ( "Invalid key $key." );
		}
	}
	public function getItem($key) {
		if (isset ( $this->items [$key] )) {
			return $this->items [$key];
		} else {
			throw new KeyInvalidException ( "Invalid key $key." );
		}
	}
	
	public function getItems(){
		return $this->items;
	}
	
	public function count(){return count($this->items);}
}