<?php
/**
 * @version $Id: default_filter_radio.php 375 2015-02-21 16:30:36Z michal $
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

$onchange = $autosubmit ? 'onchange="this.form.submit();"' : '';
?>

<?php foreach ($item->optionsArray as $key=>$optionId) {
	$optionAlias = JFilterOutput::stringURLSafe($item->optionValuesArray[$key]);
	$optionIdAlias = $optionId;//.':'.$optionAlias;
	$active = (in_array($optionId, $item->selectedOptions)) ? true:false;
	$checked = ($active) ? 'checked="checked"' : '';

	if ($active || $item->optionCounterArray[$key] > 0 || $item->selected) { ?>
<label><input type="radio" name="<?php echo 'f_'.$item->alias; ?>"
	value="<?php echo $optionIdAlias?>" <?php echo $checked; ?> <?php echo $onchange; ?> /> <?php echo $item->optionValuesArray[$key]; 
	if ($show_counter == 1 /*&& !$item->selected*/) {
		echo ' ['.$item->optionCounterArray[$key].']';
	}
	?></label>
<?php } ?>
<?php } ?>