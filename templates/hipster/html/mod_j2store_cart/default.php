<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

$app = JFactory::getApplication();
$ajax = $app->getUserState('mod_j2store_mini_cart.isAjax');
$hide = false;
if($params->get('check_empty',0) && $list['product_count'] < 1) {
$hide = true;
}
?>

	<?php if(!$ajax): ?>
	<div id="miniJ2StoreCart">
	<?php endif; ?>
		<?php if(!$hide): ?>
			<?php if($list['product_count'] > 0): ?>
				<?php echo JText::sprintf('J2STORE_CART_TOTAL', $list['product_count'], $list['total']); ?>
			<?php else : ?>
					<?php echo JText::_('J2STORE_NO_ITEMS_IN_CART'); ?>
			<?php endif; ?>

			<div class="j2store-minicart-button">
			<?php if($link_type =='link'):?>
			<a class="cartlink" href="<?php echo JRoute::_('index.php?option=com_j2store&view=mycart');?>">
			<?php echo JText::_('J2STORE_VIEW_CART');?>
			</a>
			<?php else: ?>
			<input type="button" class="btn btn-primary button" onClick="window.location='<?php echo JRoute::_('index.php?option=com_j2store&view=mycart');?>'"
			value="<?php echo JText::_('J2STORE_VIEW_CART');?>"
			/>
			<?php endif;?>
			</div>
		<?php endif; ?>
			<?php if(!$ajax):?>
		</div>
			<?php else: ?>
				<?php $app->setUserState('mod_j2store_mini_cart.isAjax', 0); ?>
			<?php endif;