<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

$Itemid = '&Itemid='.vRequest::getInt('Itemid',0);

$virtuemart_category_id = shopFunctionsF::getLastVisitedCategoryId();
$categoryLink = '';
if ($virtuemart_category_id) {
	$categoryLink = '&virtuemart_category_id=' . $virtuemart_category_id;
}
$continue_link = JRoute::_('index.php?option=com_virtuemart&view=category' . $categoryLink . $Itemid, FALSE);

echo '<p>' . $this->cart->getError() . '</p>';
echo '<a class="continue" href="' . $this->continue_link . '" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
echo '<div>'.$this->errorMsg.'</div>';
?>
<br style="clear:both">