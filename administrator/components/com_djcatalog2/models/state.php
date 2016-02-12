<?php
/**
 * @version $Id: state.php 345 2014-09-26 11:39:50Z michal $
 * @package DJ-Catalog2
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Michal Olczyk - michal.olczyk@design-joomla.eu
 *
 * DJ-Catalog2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Catalog2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Catalog2. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// No direct access.
defined('_JEXEC') or die;

//jimport('joomla.application.component.modeladmin');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'modeladmin.php');

class Djcatalog2ModelState extends DJCJModelAdmin
{
	protected $text_prefix = 'COM_DJCATALOG2';

	public function __construct($config = array()) {
		parent::__construct($config);
	}

	public function getTable($type = 'States', $prefix = 'Djcatalog2Table', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_djcatalog2.state', 'state', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}

	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_djcatalog2.edit.state.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
	
	public function getItem($pk = null) {
		if ($item = parent::getItem($pk)) {
			if (!isset($item->country_id) || $item->country_id == 0) {
				$item->country_id = JFactory::getApplication()->input->getInt('country_id');
			}
			
			return $item;
		} else {
			return false;
		}
	}

	protected function _prepareTable(&$table)
	{
		jimport('joomla.filter.output');
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		$table->name		= htmlspecialchars_decode($table->name, ENT_QUOTES);
	}

	protected function getReorderConditions($table = null)
	{
		$condition = array();
		return $condition;
	}

	public function delete(&$cid) {
		return parent::delete($cid);
	}
	
	public function getParent() {
		$country_id = JFactory::getApplication()->input->get('country_id', $this->state->get('filter.country_id'));
		$country = null;
		if ($tax_rate_id > 0) {
			$this->_db->setQuery('select * from #__djc2_countries where id ='.(int)$country_id);
			$country = $this->_db->loadObject();
		}
		return $country;
	
	}
}