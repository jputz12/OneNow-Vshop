<?php
/**
 * @version $Id: default_filters.php 469 2015-07-07 07:04:30Z michal $
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

$jinput = JFactory::getApplication()->input;
?>
<div class="djc_filters_in thumbnail">
	<form name="djcatalogForm" id="djcatalogForm" method="post" action="<?php echo JRoute::_('index.php?option=com_djcatalog2&task=mapsearch'); ?>">
		<?php if ($this->params->get('show_category_filter_map', 1) > 0 || $this->params->get('show_producer_filter_map', 1) > 0) { ?>
			<ul class="djc_filter_list djc_clearfix">
				<li class="span3 djc_filter_label"><span><?php echo JText::_('COM_DJCATALOG2_FILTER'); ?></span></li>
				<?php if ($this->params->get('show_category_filter_map') > 0) { ?>
					<li class="djc_filter_input djc_filter_categories"><?php echo $this->lists['categories'];?>
					<script type="text/javascript">
					//<![CDATA[ 
					document.id('cid').addEvent('change',function(evt){
						if(document.id('pid')) {
							options = document.id('pid').getElements('option');
							options.each(function(option, index){
								if (option.value == "") {
									option.setAttribute('selected', 'true');
								} else {
									option.removeAttribute('selected');
								}
							});
						}

						document.djcatalogForm.submit();
					});
					//]]>
					</script>
					</li>
				<?php } ?>
				<?php if ($this->params->get('show_producer_filter_map') > 0) { ?>
					<li class="djc_filter_input djc_filter_producers"><?php echo $this->lists['producers'];?></li>
					<script type="text/javascript">
						//<![CDATA[ 
						document.id('pid').addEvent('change',function(evt){
							document.djcatalogForm.submit();
						});
						//]]>
					</script>
				<?php } ?>
			</ul>
			<div class="clear"></div>
		<?php } ?>
		<?php if ((int)$this->params->get('show_search_map', 1) > 0) { ?>
			<ul class="djc_filter_map_search djc_clearfix">
				<li class="span3 djc_filter_label"><span><?php echo JText::_('COM_DJCATALOG2_SEARCH_BY_ADDRESS'); ?></span></li>
				<li class="djc_filter_input"><input type="text" class="inputbox input" name="mapsearch" id="djcatsearch" value="<?php echo $this->lists['search'];?>" placeholder="<?php echo JText::_('COM_DJCATALOG2_SEARCH_BY_ADDRESS_PLCH');?>"/></li>
			</ul>
			<div class="clear"></div>
			<ul class="djc_filter_radius_search djc_clearfix">
				<li class="span3 djc_filter_label"><span><?php echo JText::_('COM_DJCATALOG2_SEARCH_RADIUS'); ?></span></li>
				<li class="djc_filter_input">
					<select class="inputbox input input-small" name="ms_radius" id="djcatsearch_radius">
						<?php 
						$radiuses = array(1,2,5,10,25,50,100,500,1000);
						$current_radius = $jinput->getInt('ms_radius', 25);
						foreach ($radiuses as $radius) { ?>
						<option value="<?php echo $radius; ?>"<?php if ($radius == $current_radius) {echo ' selected="selected"';} ?>><?php echo $radius; ?></option>
						<?php } ?>
					</select>
					<select class="inputbox input input-mini" name="ms_unit" id="djcatsearch_radius">
						<?php 
						$units = array('km', 'mi');
						$current_unit = $jinput->getString('ms_unit', 'km');
						foreach ($units as $unit) { ?>
						<option value="<?php echo $unit; ?>"<?php if ($unit == $current_unit) {echo ' selected="selected"';} ?>><?php echo $unit; ?></option>
						<?php } ?>
					</select>
				</li>
				<li class="djc_filter_button djc_filter_button djc_filter_button_go"><input type="submit" class="button btn" onclick="document.djcatalogForm.submit();" value="<?php echo JText::_( 'COM_DJCATALOG2_GO' ); ?>" /></li>
				<li class="djc_filter_button djc_filter_button djc_filter_button_reset"><input type="submit" class="button btn" onclick="document.getElementById('djcatsearch').value='';document.djcatalogForm.submit();" value="<?php echo JText::_( 'COM_DJCATALOG2_RESET' ); ?>" /></li>
			</ul>
		<?php } ?>
	<?php if (!($this->params->get('show_category_filter_map', 1) > 0)) { ?>
		<input type="hidden" name="cid" value="<?php echo $jinput->get('cid', null, 'string'); ?>" />
	<?php } ?>
	<?php if (!($this->params->get('show_producer_filter_map', 1) > 0)) { ?>
		<input type="hidden" name="pid" value="<?php echo $jinput->get('pid', null, 'string'); ?>" />
	<?php } ?>
	<input type="hidden" name="option" value="com_djcatalog2" />
	<input type="hidden" name="view" value="map" />
	<input type="hidden" name="task" value="mapsearch" />
	<input type="hidden" name="Itemid" value="<?php echo $jinput->get('Itemid'); ?>" />
	</form>
</div>