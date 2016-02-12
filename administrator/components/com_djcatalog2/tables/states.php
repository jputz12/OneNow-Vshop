<?php
/**
 * @version $Id: states.php 345 2014-09-26 11:39:50Z michal $
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

// No direct access
defined('_JEXEC') or die;

class Djcatalog2TableStates extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__djc2_countries_states', 'id', $db);
	}
	function bind($array, $ignore = '')
	{	
		return parent::bind($array, $ignore);
	}
	public function store($updateNulls = false)
	{
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();
		$app = JFactory::getApplication();
		$db = JFactory::getDbo();
		
		
		
		$id = (int)$this->id;
		$country_id = (int)$this->country_id;
		$name = $this->name;
		
		$query = $db->getQuery(true);
		$where = array();
		
		$query->select('count(*)');
		$query->from('#__djc2_countries_states');
		
		if ($id) {
			$where[] = 'id != '.$id;
		}
		if ($country_id > 0) {
			$where[] = 'country_id='.$country_id;
		}
		
		$where[] = 'name='.$db->quote($name);
		
		$query->where($where);
		
		$db->setQuery($query);
		$count = $db->loadResult();

		if ($count > 0) {
			$this->setError(JText::_('COM_DJCATALOG2_ERROR_UNIQUE_NAME'));
			return false;
		}
	
		return parent::store($updateNulls);
	}
}
