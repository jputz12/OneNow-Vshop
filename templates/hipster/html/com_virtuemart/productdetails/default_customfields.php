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
<div class="product-fields">
	    <?php
	    $custom_title = null;
	    foreach ($this->product->customfieldsSorted[$this->position] as $field) {
	    	if ( $field->is_hidden ) //OSP http://forum.virtuemart.net/index.php?topic=99320.0
	    		continue;
			if ($field->display) {
	    ?><div class="product-field product-field-type-<?php echo $field->field_type ?>">
		    <?php if ($field->custom_title != $custom_title && $field->show_title) { ?>
			    <span class="product-fields-title" ><?php echo JText::_($field->custom_title); ?></span>
			    <?php
			    if ($field->custom_tip)
				echo JHTML::tooltip($field->custom_tip, JText::_($field->custom_title), 'tooltip.png');
			}
			?>
	    	    <span class="product-field-display"><?php echo $field->display ?></span>
	    	    <span class="product-field-desc"><?php echo jText::_($field->custom_field_desc) ?></span>
	    	</div>
		    <?php
		    $custom_title = $field->custom_title;
			}
	    }
	    ?>
        </div>