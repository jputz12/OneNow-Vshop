<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined ( '_JEXEC' ) or die ();
class J2StoreModelCustomers extends F0FModel {


	public function buildQuery($overrideLimits=false) {
		$query = parent::buildQuery($overrideLimits);
	 	$query->select($this->_db->qn('#__j2store_orders.user_email'));
	 	$query->join('INNER','#__j2store_orders ON  #__j2store_addresses.email = #__j2store_orders.user_email');
	    $query->select('#__j2store_countries.country_name as country_name');
		$query->join('LEFT OUTER', '#__j2store_countries ON #__j2store_addresses.country_id = #__j2store_countries.j2store_country_id');
		$query->select('#__j2store_zones.zone_name as zone_name');
		$query->join('LEFT OUTER', '#__j2store_zones ON #__j2store_addresses.zone_id = #__j2store_zones.j2store_zone_id');
		$query->group('#__j2store_addresses.email');
		return $query;
	}



	/**
	 * This method can be overriden to automatically do something with the
	 * list results array. You are supposed to modify the list which was passed
	 * in the parameters; DO NOT return a new array!
	 *
	 * @param   array  &$resultArray  An array of objects, each row representing a record
	 *
	 * @return  void
	 */
	protected function onProcessList(&$resultArray)
	{
			foreach($resultArray as $result){
				$result->customer_name = $result->first_name .' '. $result->last_name;
			}
	}

	public function getAddressesByemail($email){
		$db = JFactory::getDbo();
		$query = parent::buildQuery($overrideLimits=false);
		$query->where($this->_db->qn('#__j2store_addresses.email').' LIKE '.$db->q('%'.$email.'%'));
		$db->setQuery($query);
		return $db->loadObject();
	}
}