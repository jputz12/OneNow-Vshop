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
	<form name="djcatalogForm" id="djcatalogForm" method="post" action="<?php echo JRoute::_('index.php?option=com_djcatalog2&task=search'); ?>">
		<?php if ($this->params->get('show_category_filter') > 0 || $this->params->get('show_producer_filter') > 0) { ?>
			<ul class="djc_filter_list djc_clearfix">
				<li class="span2 djc_filter_label"><span><?php echo JText::_('COM_DJCATALOG2_FILTER'); ?></span></li>
				<?php if ($this->params->get('show_category_filter') > 0) { ?>
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
				<?php if ($this->params->get('show_producer_filter') > 0) { ?>
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
		<?php if ((int)$this->params->get('show_price_filter', 0) > 0) { ?>
			<?php 
			$price_from = str_replace(',', '.', $jinput->get('price_from', '', 'string'));
			if ($price_from != '') {
				$price_from = floatval($price_from);
			}
			$price_to = str_replace(',', '.', $jinput->get('price_to', '', 'string'));
			if ($price_to != '') {
				$price_to = floatval($price_to);
			}
			?>
			<ul class="djc_filter_list djc_price_filter djc_clearfix">
				<li class="span2 djc_filter_label">
					<span><?php echo JText::_('COM_DJCATALOG2_PRICE_FILTER'); ?></span>
				</li>
				<li class="djc_filter_input">
					<input class="inputbox input input-mini" id="djc_price_filter_from" type="text" value="<?php echo $price_from; ?>" name="price_from" placeholder="<?php echo JText::_('COM_DJCATALOG2_PRICE_FROM'); ?>" />
				</li>
				<li class="djc_filter_input">
					<input class="inputbox input input-mini" id="djc_price_filter_to" type="text" value="<?php echo $price_to; ?>" name="price_to" placeholder="<?php echo JText::_('COM_DJCATALOG2_PRICE_TO'); ?>"/>
				</li>
				<?php if ((int)$this->params->get('show_search') == 0) { ?>
					<li class="djc_filter_button djc_filter_button djc_filter_button_go"><input type="submit" class="button btn" onclick="document.djcatalogForm.submit();" value="<?php echo JText::_( 'COM_DJCATALOG2_GO' ); ?>" /></li>
					<li class="djc_filter_button djc_filter_button djc_filter_button_reset"><input type="submit" class="button btn" onclick="document.getElementById('djc_price_filter_from').value='';document.getElementById('djc_price_filter_to').value='';document.djcatalogForm.submit();" value="<?php echo JText::_( 'COM_DJCATALOG2_RESET' ); ?>" /></li>
				<?php } ?>
			</ul>
			<div class="clear"></div>
		<?php } ?>
		<?php if ((int)$this->params->get('show_search') > 0) { ?>
			<ul class="djc_filter_search djc_clearfix">
				<li class="span2 djc_filter_label"><span><?php echo JText::_('COM_DJCATALOG2_SEARCH'); ?></span></li>
				<li class="djc_filter_input"><input type="text" class="inputbox" name="search" id="djcatsearch" value="<?php echo $this->escape($this->lists['search']);?>" /></li>
				<li class="djc_filter_button djc_filter_button djc_filter_button_go"><input type="submit" class="button btn" onclick="document.djcatalogForm.submit();" value="<?php echo JText::_( 'COM_DJCATALOG2_GO' ); ?>" /></li>
				<li class="djc_filter_button djc_filter_button djc_filter_button_reset"><input type="submit" class="button btn" onclick="document.getElementById('djcatsearch').value='';document.djcatalogForm.submit();" value="<?php echo JText::_( 'COM_DJCATALOG2_RESET' ); ?>" /></li>
			</ul>
		<?php } ?>
	<?php if (!($this->params->get('show_category_filter') > 0)) { ?>
		<input type="hidden" name="cid" value="<?php echo $this->escape($jinput->get('cid', null, 'string')); ?>" />
	<?php } ?>
	<?php if (!($this->params->get('show_producer_filter') > 0)) { ?>
		<input type="hidden" name="pid" value="<?php echo $this->escape($jinput->get('pid', null, 'string')); ?>" />
	<?php } ?>
	<?php if ($jinput->getInt('aid') > 0) { ?>
        <input type="hidden" name="aid" value="<?php echo $this->escape($jinput->get('aid', null, 'string')); ?>" />
    <?php } ?>
	<input type="hidden" name="option" value="com_djcatalog2" />
	<input type="hidden" name="view" value="items" />
	<input type="hidden" name="order" value="<?php echo $this->escape($jinput->get('order',$this->params->get('items_default_order', 'i.ordering'), 'string')); ?>" />
	<input type="hidden" name="dir" value="<?php echo $this->escape($jinput->get('dir',$this->params->get('items_default_order_dir', 'asc'), 'cmd')); ?>" />
	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid'); ?>" />
	</form>
	
	<?php if (!empty($this->filter_modules)) {?>
		<p class="djc_adv_search_wrap">
			<span class="djc_adv_search_toggle"><?php echo JText::_('COM_DJCATALOG2_ADVANCED_SEARCH'); ?> <span class="icon-cog"></span></span>
		</p>
	<?php } ?>
	
</div>