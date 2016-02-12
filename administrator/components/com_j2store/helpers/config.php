<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined('_JEXEC') or die;

class J2Config extends JObject {
	public static $instance = null;	
	var $_data;

	public function __construct($properties=null) {

		if(!isset($this->_data) && !is_array($this->_data)) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)->select('*')->from('#__j2store_configurations');
			$db->setQuery($query);
			$this->_data = $db->loadObjectList('config_meta_key');
		}
	}

	public static function getInstance(array $config = array())
	{
		if (!self::$instance)
		{
			self::$instance = new self($config);
		}

		return self::$instance;
	}
	
	public function set($namekey,$value=null){		
		if(!isset($this->_data[$namekey]) || !is_object($this->_data[$namekey])) $this->_data[$namekey] = new stdClass();
		$this->_data[$namekey]->config_meta_value=$value;
		$this->_data[$namekey]->config_meta_key=$namekey;
		return true;
	}

	public function get($property, $default=null) {
		if(isset($this->_data[$property])) {			
			return $this->_data[$property]->config_meta_value;
		}
		return $default;
	}
	
	public function toArray() {
		$params = array ();
		if (count ( $this->_data )) {
			foreach ( $this->_data as $param ) {
				$params [$param->config_meta_key] = $param->config_meta_value;
			}
		}
		return $params;
	}
}
