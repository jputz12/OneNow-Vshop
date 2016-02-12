<?php
/**
 * @version $Id: default_search.php 373 2015-02-10 08:41:53Z michal $
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
	<form name="djcatalogForm" id="djcatalogForm" method="post" action="<?php echo JRoute::_('index.php?option=com_djcatalog2&view=myitems&Itemid='.$jinput->getInt('Itemid')); ?>">
			<ul class="djc_filter_search djc_clearfix">
				<li class="span2"><span><?php echo JText::_('COM_DJCATALOG2_SEARCH'); ?></span></li>
				<li><input type="text" class="inputbox" name="search" id="djcatsearch" value="<?php echo $this->escape($jinput->getString('search',''));?>" /></li>
				<li><input type="submit" class="button btn" onclick="document.djcatalogForm.submit();" value="<?php echo JText::_( 'COM_DJCATALOG2_GO' ); ?>" /></li>
				<li><input type="submit" class="button btn" onclick="document.getElementById('djcatsearch').value='';document.djcatalogForm.submit();" value="<?php echo JText::_( 'COM_DJCATALOG2_RESET' ); ?>" /></li>
			</ul>
	<input type="hidden" name="option" value="com_djcatalog2" />
	<input type="hidden" name="view" value="myitems" />
	<input type="hidden" name="order" value="<?php echo $this->escape($jinput->get('order',$this->params->get('items_default_order', 'i.ordering'), 'string')); ?>" />
	<input type="hidden" name="dir" value="<?php echo $this->escape($jinput->get('dir',$this->params->get('items_default_order_dir', 'asc'), 'cmd')); ?>" />
	<input type="hidden" name="Itemid" value="<?php echo $jinput->getInt('Itemid'); ?>" />
	</form>
</div>