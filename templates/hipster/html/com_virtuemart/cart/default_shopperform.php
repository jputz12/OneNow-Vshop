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


<h3><?php echo JText::_ ('COM_VIRTUEMART_CART_CHANGE_SHOPPER'); ?></h3>

<form action="<?php echo JRoute::_ ('index.php'); ?>" method="post" class="inline">
	<table cellspacing="0" cellpadding="0" border="0">
		<tr style="border:0px;">
			<td  style="border:0px;">
				<?php 
				if (!class_exists ('VirtueMartModelUser')) {
					require(JPATH_VM_ADMINISTRATOR . '/models/user.php');
				}

				$userList = $this->getUserList();
				$currentUser = $this->cart->user->_data->virtuemart_user_id;

				echo JHTML::_('Select.genericlist', $userList, 'userID', 'class="vm-chzn-select" style="width: 200px"', 'id', 'displayedName', $currentUser); 

				$adminID = JFactory::getSession()->get('vmAdminID');
				$instance = JFactory::getUser();
				?>
			</td>
			<td style="border:0px;">
				<input type="submit" name="changeShopper" title="<?php echo JText::_('COM_VIRTUEMART_SAVE'); ?>" value="<?php echo JText::_('COM_VIRTUEMART_SAVE'); ?>" class="button"  style="margin-left: 10px;"/>
				<?php if(isset($adminID) && $instance->id != $adminID) { ?>
					<span style="margin-left: 20px;"><b><?php echo JText::_('COM_VIRTUEMART_CART_ACTIVE_ADMIN') .' '.JFactory::getUser($adminID)->name; ?></b></span>
				<?php } ?>
				<?php echo JHTML::_( 'form.token' ); ?>
				<input type="hidden" name="view" value="cart"/>
				<input type="hidden" name="task" value="changeShopper"/>
			</td>
		</tr>
	</table>
</form>
<br />