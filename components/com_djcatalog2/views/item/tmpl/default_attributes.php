<?php
/**
 * @version $Id: default_attributes.php 447 2015-06-02 09:50:58Z michal $
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
<?php
$attribute = $this->attribute_cursor; 
$attributeName = '_ef_'.$attribute->alias; 
//print_r($this->item_cursor->$attributeName);
?>
<?php if (!empty($this->item_cursor->$attributeName)) { ?>
<div>
	<?php 
		if (is_array($this->item_cursor->$attributeName)){
			$this->item_cursor->$attributeName = implode(', ', $this->item_cursor->$attributeName);
		}
		if ($attribute->type == 'textarea' || $attribute->type == 'text'){
			$value = nl2br(htmlspecialchars($this->item_cursor->$attributeName));
			// convert URLs
			$value = preg_replace('#([\w]+://)([^\s()<>]+)#iS', '<a target="_blank" href="$1$2">$2</a>', $value);
			// convert emails
			$value = preg_replace('#([\w.-]+(\+[\w.-]+)*@[\w.-]+)#i', '<a target="_blank" href="mailto:$1">$1</a>', $value);
			echo $value;
		}
		else if ($attribute->type == 'html') {
			echo JHTML::_('content.prepare', $this->item_cursor->$attributeName, $this->params, 'com_djcatalog2.item.attributes');
		}
		else if ($attribute->type == 'calendar') {
			echo JHtml::_('date', $this->item_cursor->$attributeName, JText::_('DATE_FORMAT_LC4'));
		} 
		else {
			echo htmlspecialchars($this->item_cursor->$attributeName);
		}	
	?>
</div>
<?php } ?>