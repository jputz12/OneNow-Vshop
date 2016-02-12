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
<center>
<h2><?php echo JText::_('COM_VIRTUEMART_ORDERS_VIEW_DEFAULT_TITLE'); ?></h2>
<?php
if (count($this->orderlist) == 0) {
	//echo JText::_('COM_VIRTUEMART_ACC_NO_ORDER');
	 echo shopFunctionsF::getLoginForm(false,true);
} else {
 ?>
<div id="editcell">

	<table class="adminlist" width="80%">
	<thead>
	<tr>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_ORDER_NUMBER'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_CDATE'); ?>
		</th>
		<!--th>
			<?php //echo JText::_('COM_VIRTUEMART_ORDER_LIST_MDATE'); ?>
		</th -->
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_STATUS'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_TOTAL'); ?>
		</th>
	</thead>
	<?php
		$k = 0;
		foreach ($this->orderlist as $row) {
			$editlink = JRoute::_('index.php?option=com_virtuemart&view=orders&layout=details&order_number=' . $row->order_number, FALSE);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="left">
					<a href="<?php echo $editlink; ?>" rel="nofollow"><?php echo $row->order_number; ?></a>
				</td>
				<td align="left">
					<?php echo vmJsApi::date($row->created_on,'LC4',true); ?>
				</td>
				<!--td align="left">
					<?php //echo vmJsApi::date($row->modified_on,'LC3',true); ?>
				</td -->
				<td align="left">
					<?php echo ShopFunctions::getOrderStatusName($row->order_status); ?>
				</td>
				<td align="left">
					<?php echo $this->currency->priceDisplay($row->order_total, $row->currency); ?>
				</td>
			</tr>
	<?php
			$k = 1 - $k;
		}
	?>
	</table>
</div>
<?php } ?>
</center>