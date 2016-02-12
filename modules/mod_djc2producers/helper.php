<?php
/**
 * @version $Id: helper.php 375 2015-02-21 16:30:36Z michal $
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

defined ('_JEXEC') or die('Restricted access');

class DJCatalog2ModProducer{
	public $_producers = null;
	
	/*public static function getProducers($filter_catid = 0){
		
		$db = JFactory::getDBO();
		$query = 'SELECT *, '
				.' CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(":", id, alias) ELSE id END as prodslug '
				.' FROM #__djc2_producers ORDER BY name';
		$db->setQuery($query);
		$_producers = $db->loadAssocList();
		return $_producers;
	}
	*/
	function getProducers($filter_catid = 0){
		if(!$this->_producers) {
			$db = JFactory::getDbo();
			$query = null;
			if ($filter_catid > 0) {
				$categories = Djc2Categories::getInstance(array('state'=>'1'));
				if ($parent = $categories->get((int)$filter_catid) ) {
					$childrenList = array($parent->id);
					$parent->makeChildrenList($childrenList);
					$query = 'SELECT DISTINCT p.* '
							//. ' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as value '
							.' FROM #__djc2_producers as p '
							.' INNER JOIN #__djc2_items AS i ON p.id = i.producer_id AND i.published = 1'
							.' INNER JOIN #__djc2_items_categories AS c ON c.item_id = i.id '
							.' WHERE c.category_id IN ('.implode(',', $childrenList).') AND p.published=1 ORDER BY p.ordering ASC';
					
					
				}
			} else {
				$query = 'SELECT p.* '
						//. ' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as value '
						.' FROM #__djc2_producers as p WHERE p.published=1 ORDER BY p.ordering ASC';
			}
			$db->setQuery($query);
			$this->_producers = $db->loadAssocList();
		}
		return $this->_producers;
	}
	
	
} ?>