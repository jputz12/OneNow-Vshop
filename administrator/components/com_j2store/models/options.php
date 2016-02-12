<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined('_JEXEC') or die;

class J2StoreModelOptions extends F0FModel {

	protected function onProcessList(&$resultArray)
	{
		foreach($resultArray as &$res){
			$res->optionvalues = $this->getOptionValues($res->j2store_option_id);
		}
	}

	protected function onAfterGetItem(&$record)
	{
		$record->optionvalues = $this->getOptionValues($record->j2store_option_id);
	}

	public function save($data) {

		if (parent::save ( $data )) {
			if ($this->otable->j2store_option_id) {
				if(is_object($data)) {
					$data = (array) $data; 
				}
				if (isset ( $data ['option_value'] ) && count ( $data ['option_value'] )) {
					$ovTable = F0FTable::getInstance ( 'optionvalue', 'Table' );
					$status = true;
					foreach ( $data['option_value'] as $optionvalue ) {
						$ovTable->load($optionvalue ['j2store_optionvalue_id']);
						$optionvalue ['option_id'] = $this->otable->j2store_option_id;
						if (! $ovTable->save ( $optionvalue )) {
							$status = false;
						}
					}
				}
				else {return true;}
			}
		}else{return false;}
		return true;
	}

	function getOptionValues($option_id){
		$db = $this->getDbo();
		$query = $db->getQuery(true)->select('*')
		->from('#__j2store_optionvalues')
		->where('option_id='.$db->q($option_id));
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	protected function onAfterDelete($id) {
		$model = $this->getTmpInstance('OptionValues', 'J2StoreModel');
		$db = $this->getDbo();
		$query = $db->getQuery(true)->select('j2store_optionvalue_id')
		->from('#__j2store_optionvalues')
		->where('option_id='.$db->q($id));
		$db->setQuery($query);
		$idlist= $db->loadColumn();
		if(count($idlist)) {
			$model->setIds($idlist);
			$model->delete();
		}
		return true;
	}

	public function getOptions($q){
		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
		$product_type = $app->input->getString('product_type');
		$query = $db->getQuery(true);
		$query->select('j2store_option_id, option_unique_name, option_name');
		$query->from('#__j2store_options');
		$query->where('LOWER(option_unique_name) LIKE '.$db->Quote( '%'.$db->escape( $q, true ).'%', false ));
		//based on the product type
		if(isset($product_type) && $product_type =='variable'){
			$query->where("type IN ('select' , 'radio' ,'checkbox')");
		}
		$query->where('enabled=1');
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	public function getParent($q=''){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('j2store_option_id, option_unique_name, option_name');
		$query->from('#__j2store_options');
		if(isset($q) && !empty($q)){
			$query->where('LOWER(option_unique_name) NOT LIKE '.$db->Quote( '%'.$db->escape( $q, true ).'%', false ));
		}
		$query->where("type IN ('select' , 'radio' ,'checkbox')");
		$query->where('enabled=1');
		$db->setQuery($query);
		return $db->loadObjectList();
	}




}
