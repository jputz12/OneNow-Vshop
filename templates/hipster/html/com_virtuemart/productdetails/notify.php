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


<form method="post" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$this->product->virtuemart_product_id.'&virtuemart_category_id='.$this->product->virtuemart_category_id, FALSE) ; ?>" name="notifyform" id="notifyform">
	<h4><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?></h4>

	<div class="list-reviews">
		<?php echo JText::sprintf('COM_VIRTUEMART_CART_NOTIFY_DESC', $this->product->product_name); ?>
		<br /><br />
	<div class="clear"></div>
	</div>
	
	<div><span class="floatleft"><input type="text" name="notify_email" value="<?php echo $this->user->email; ?>" /></span>
		 <span class="addtocart-button"><input type="submit" name="notifycustomer"  class="notify-button" value="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>" /></span>
	</div>

	<input type="hidden" name="virtuemart_product_id" value="<?php echo $this->product->virtuemart_product_id; ?>" />
	<input type="hidden" name="option" value="com_virtuemart" />
	<input type="hidden" name="virtuemart_category_id" value="<?php echo JRequest::getInt('virtuemart_category_id'); ?>" />
	<input type="hidden" name="virtuemart_user_id" value="<?php echo $this->user->id; ?>" />
	<input type="hidden" name="task" value="notifycustomer" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<br />
<br />
<br />