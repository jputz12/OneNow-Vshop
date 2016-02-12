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
	<a href="<?php echo $this->continue_link; ?>"><?php echo JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') ?></a>
	<a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart'); ?>"><?php echo JText::_('COM_VIRTUEMART_CART_SHOW') ?></a>
<br style="clear:both">