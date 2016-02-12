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

<table width="100%" cellspacing="2" cellpadding="4" border="0">
	<tr align="left" class="sectiontableheader">
		<th align="left" ><?php echo JText::_('COM_VIRTUEMART_DATE') ?></th>
		<th align="left" ><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PO_STATUS') ?></th>
		<th align="left" ><?php echo JText::_('COM_VIRTUEMART_ORDER_COMMENT') ?></th>
	</tr>
<?php
	foreach($this->orderdetails['history'] as $_hist) {
		if (!$_hist->customer_notified) {
			continue;
		}
?>
		<tr valign="top">
			<td align="left">
				<?php echo vmJsApi::date($_hist->created_on,'LC2',true); ?>
			</td>
			<td align="left" >
				<?php echo $this->orderstatuses[$_hist->order_status_code]; ?>
			</td>
			<td align="left" >
				<?php echo $_hist->comments; ?>
			</td>
		</tr>
<?php
	}
?>
</table>