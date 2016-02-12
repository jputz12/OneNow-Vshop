<?php
/**
 * @version $Id: default_filter_label.php 415 2015-05-06 06:03:51Z michal $
 * @package DJ-Catalog2
 * @copyright Copyright (C) 2010 Blue Constant Media LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://design-joomla.eu
 * @author email contact@design-joomla.eu
 * @developer $Author: michal $ Michal Olczyk - michal.olczyk@design-joomla.eu
 *
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

?>

<?php if (!empty($item->selectedOptions) || $item->selected) {
	$filter_query = $query;
	unset($filter_query['djcf'][$item->alias]);
	if (empty($filter_query['djcf'])) {
		unset($filter_query['cm']);
	} else {
		$isEmpty = true;
		foreach ($filter_query['djcf'] as $k=>$v) {
			if (!empty($filter_query['djcf'][$k])) {
				$isEmpty = false;
				break;
			}
		}
		if ($isEmpty) {
			unset($filter_query['cm']);
		}
	}
	if (!empty($filter_query['djcf'])) {
		$filters = array();
		foreach ($filter_query['djcf'] as $a => $v) {
			if (is_array($v)){
				foreach ($v as $k=>$p) {
					$v[$k] = ($p == '') ? '' : (int)$p;
				}
				$val = implode(',', $v);
				if ($val == ',') {
					continue;
				}
				$filters['f_'.$a] = $val;
			} else if ($v != '') {
				$filters['f_'.$a] = (int)$v;
			}
		}
		unset($filter_query['djcf']);
		$filter_query = array_merge($filter_query, $filters);
	}

	$uri->setQuery($filter_query);
	?>
<a title="<?php echo JText::_('MOD_DJC2FILTERS_RESET_LABEL'); ?>"
	class="button field_reset_button"
	href="<?php echo htmlspecialchars($uri->toString()); ?>"> <?php echo JText::_('MOD_DJC2FILTERS_RESET')?>
</a>
<?php } ?>
<label class="mod_djc2filters_group_label"><?php echo $item->name; ?> </label>
