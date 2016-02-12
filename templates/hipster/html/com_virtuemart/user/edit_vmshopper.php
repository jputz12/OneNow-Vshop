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
<div class="cart-view">
<fieldset>
	<span class="userfields_info">
		<?php echo JText::_('COM_VIRTUEMART_SHOPPER_FORM_LBL') ?>
	</span>
	<table class="adminForm user-details">
<?php	if(Vmconfig::get('multix','none')!=='none'){ ?>

		<tr>
			<td class="key">
				<label for="virtuemart_vendor_id">
					<?php echo JText::_('COM_VIRTUEMART_PRODUCT_FORM_VENDOR') ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['vendors']; ?>
			</td>
		</tr>
<?php } ?>


		<tr>
			<td class="key">
				<label for="customer_number">
					<?php echo JText::_('COM_VIRTUEMART_USER_FORM_CUSTOMER_NUMBER') ?>:
				</label>
			</td>
			<td>
			 <?php if(Permissions::getInstance()->check('admin')) { ?>
				<input type="text" class="inputbox" name="customer_number" id="customer_number" size="40" value="<?php echo  $this->lists['custnumber'];
					?>" />
			<?php } else {
				echo $this->lists['custnumber'];
			} ?>
			</td>
		</tr>
		 <?php if($this->lists['shoppergroups']) { ?>
		<tr>
			<td class="key">
				<label for="virtuemart_shoppergroup_id">
					<?php echo JText::_('COM_VIRTUEMART_SHOPPER_FORM_GROUP') ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['shoppergroups']; ?>
			</td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
</div>