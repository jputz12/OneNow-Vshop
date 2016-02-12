<?php
/**
 * @version $Id: default.php 373 2015-02-10 08:41:53Z michal $
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

?>

<form action="<?php echo JRoute::_('index.php?option=com_djcatalog2&task=search'); ?>" method="post" name="DJC2searchForm" id="DJC2searchForm" style="padding-top: 15px;padding-left:5px;">
	<fieldset class="djc_mod_search djc_clearfix">
		<?php if ($params->get('show_label', 1) == 1) { ?>
		<label for="mod_djcatsearch"><?php echo JText::_('MOD_DJC2SEARCH_SEARCH'); ?></label>
		<?php } ?>
		
		<input type="text" class="inputbox" name="search" id="mod_djcatsearch" style="margin-bottom: 0px;" value="" <?php if ($params->get('show_label', 1) == 0) echo 'placeholder="'.JText::_('MOD_DJC2SEARCH_SEARCH').'"; '?>/>
		
		<?php if ($params->get('show_button', 1) == 1) { ?>
		<!-- <span style="padding: 6px 13px; vertical-align:inherit;background:#999;" onclick="document.DJC2searchForm.submit();"><i class="icon-zoom-in"></i></span> --> <!--button   class="button btn-xs" onclick="document.DJC2searchForm.submit();"><i class="icon-zoom-in"></i></button-->
		<span style="padding: 6px 13px; vertical-align:inherit;background:transparent;" onclick="document.DJC2searchForm.submit();"><img src="images/search_icon.png" alt="search" /></span> <!--button   class="button btn-xs" onclick="document.DJC2searchForm.submit();"><i class="icon-zoom-in"></i></button-->
		<?php } ?>
	</fieldset>
    
	<input type="hidden" name="option" value="com_djcatalog2" />
	<input type="hidden" name="view" value="items" />
	<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
	<input type="hidden" name="task" value="search" />
	<input type="submit" style="display: none;"/>
</form>