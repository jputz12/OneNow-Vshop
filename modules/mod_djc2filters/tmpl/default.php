<?php
/**
 * @version $Id: default.php 375 2015-02-21 16:30:36Z michal $
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

$app = JFactory::getApplication();
$menu = $app->getMenu();
$active = $menu->getActive();

$option = null;
$view = null;
$cid = 0;
$catalogView = false;

if (isset($active->query['option'])) {
    if ($active->query['option'] == 'com_djcatalog2' && $app->input->get('option', null, 'string') == 'com_djcatalog2') {
        if (isset($active->query['view'])) {
            if ($active->query['view'] == 'items' && $app->input->get('view', null, 'string') == 'items') {
                $catalogView = true;
                if ($app->input->get('cid', false, 'string') !== false) {
                	$cid = $app->input->get('cid', false, 'string');
                }
                else if (isset($active->query['cid'])) {
                    $cid = $active->query['cid'];
                }
            }
        } 
    }
}

JURI::reset();

$uri = null;
$juri = JURI::getInstance();
if (!$catalogView) {
    $uri = JURI::getInstance(JRoute::_(DJCatalogHelperRoute::getCategoryRoute($cid).'&cm=0'));
} else {
	if ($active->id == $menu->getDefault()->id) {
		$uri = JURI::getInstance($juri->toString());
		$temp_query = $uri->getQuery(true);
		$temp_query['cm'] = '0';
		$temp_query['option'] = 'com_djcatalog2';
		$temp_query['view'] = 'items';
		$temp_query['cid'] = $cid;
		$temp_query['Itemid'] = $active->id;
		$uri->setQuery($temp_query);

		$uri = JURI::getInstance(JRoute::_('index.php?'.$uri->getQuery(false)));
		
	}
	else {
		$uri = JURI::getInstance($juri->toString());
	}
} 

$query = $uri->getQuery(true);
$query['djcf'] = array();
foreach($query as $param=>$value) {
	if (strstr($param, 'f_')) {
		$qkey = substr($param, 2);
		$qval = null;
		if (is_array($value)) {
			$qval = $value;
		} else {
			$qval = (strstr($value,',') !== false) ? explode(',',$value) : $value;
		}
		unset($query[$param]);
		if (!empty($qval)) {
            $query['djcf'][$qkey] = $qval;    
        }
	}
}
unset($query['limitstart']);
//unset($query['search']);
unset($query['start']);

$show_counter = (int)$params->get('show_counter', 0);
$module_float 	= (bool)($params->get('module_float','') != '');
$module_layout = $params->get('module_layout', 'simple');
$autosubmit = (bool)($params->get('autosubmit', 0) == 1);

?>
<div class="mod_djc2filters" id="mod_djc2filters-<?php echo $module_id; ?>" >
<?php require(JModuleHelper::getLayoutPath('mod_djc2filters', 'default_'.$module_layout)); ?>
</div>
<?php 
JURI::reset();
