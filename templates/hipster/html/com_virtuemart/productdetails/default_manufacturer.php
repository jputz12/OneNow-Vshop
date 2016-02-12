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
<?php
    $link = JRoute::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $this->product->virtuemart_manufacturer_id . '&tmpl=component', FALSE);
    $text = $this->product->mf_name;

    /* Avoid JavaScript on PDF Output */
    if (strtolower(JRequest::getWord('output')) == "pdf") {
	echo JHTML::_('link', $link, $text);
    } else {
	?>
        <span><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL') ?></span><a class="modal" rel="{handler: 'iframe', size: {x: 700, y: 550}}" href="<?php echo $link ?>"><?php echo $text ?></a>
    <?PHP }