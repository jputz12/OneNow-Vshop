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

        <div class="product-related-categories">
    	<h4><?php echo JText::_('COM_VIRTUEMART_RELATED_CATEGORIES'); ?></h4>
	    <?php foreach ($this->product->customfieldsRelatedCategories as $field) { ?>
		<div class="product-field product-field-type-<?php echo $field->field_type ?>">
		    <span class="product-field-display"><?php echo $field->display ?></span>
		</div>
	<?php } ?>
        </div>