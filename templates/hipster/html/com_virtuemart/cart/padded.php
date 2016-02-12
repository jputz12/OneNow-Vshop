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

echo '<a class="continue" href="' . $this->continue_link . '" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
echo '<a class="showcart floatright" href="' . $this->cart_link . '">' . JText::_('COM_VIRTUEMART_CART_SHOW') . '</a>';
if($this->products){
	foreach($this->products as $product){
		echo '<p>'.JText::sprintf('COM_VIRTUEMART_CART_PRODUCT_ADDED',$product->product_name,$product->quantity).'</p>';
	}
}

if ($this->errorMsg) echo '<div>'.$this->errorMsg.'</div>';

if(VmConfig::get('popup_rel',1)){
	if($this->products and !empty($this->products[0]->customfieldsRelatedProducts)){
		?>
		<div class="product-related-products">
				<h4><?php echo JText::_('COM_VIRTUEMART_RELATED_PRODUCTS'); ?></h4>
		<?php
		foreach ($this->products[0]->customfieldsRelatedProducts as $field) {
			if(!empty($field->display)) {
				?><div class="product-field product-field-type-<?php echo $field->field_type ?>">
				<span class="product-field-display"><?php echo $field->display ?></span>
				</div>
			<?php }
		} ?>
		</div>
	<?php
	}
}

?><br style="clear:both">