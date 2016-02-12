<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

?>
<table width="100%">
  <tr>
    <td width="50%" bgcolor="#ccc">
		<?php echo JText::_('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?> 
	</td>
	<td width="50%" bgcolor="#ccc">
		<?php echo JText::_('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL'); ?>
	</td>
  </tr>
  <tr>
    <td width="50%">

		<?php 	foreach($this->BTaddress['fields'] as $item){
					if(!empty($item['value'])){
						echo $item['title'].': '.$this->escape($item['value']).'<br/>';
					}
				} ?>

	</td>
    <td width="50%">
			<?php
			
			if(!empty($this->STaddress['fields'])){
				foreach($this->STaddress['fields'] as $item){
					if(!empty($item['value'])){
						echo $item['title'].': '.$this->escape($item['value']).'<br/>';
					}
				}
			} else {
				foreach($this->BTaddress['fields'] as $item){
					if(!empty($item['value'])){
						echo $item['title'].': '.$this->escape($item['value']).'<br/>';
					}
				}
			} ?>
	</td>
  </tr>
</table>