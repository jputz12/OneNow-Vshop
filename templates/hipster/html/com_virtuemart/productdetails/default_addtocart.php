<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

if (isset($this->product->step_order_level))
	$step=$this->product->step_order_level;
else
	$step=1;
if($step==0)
	$step=1;
$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
?>

<div class="addtocart-area">

	<form method="post" class="product js-recalculate" action="<?php echo JRoute::_ ('index.php',false); ?>">
		<input name="quantity" type="hidden" value="<?php echo $step ?>" />
		<?php // Product custom_fields
		if (!empty($this->product->customfieldsCart)) {
			?>
			<div class="product-fields">
				<?php foreach ($this->product->customfieldsCart as $field) { ?>
				<div class="product-field product-field-type-<?php echo $field->field_type ?>">
					<?php if ($field->show_title) { ?>
						<span class="product-fields-title-wrapper"><span class="product-fields-title"><strong><?php echo vmText::_ ($field->custom_title) ?></strong></span>
					<?php }
					if ($field->custom_tip) {
						echo JHTML::tooltip (vmText::_($field->custom_tip), vmText::_ ($field->custom_title), 'tooltip.png');
					} ?></span>
					<span class="product-field-display"><?php echo $field->display ?></span>
					<span class="product-field-desc"><?php echo vmText::_($field->custom_field_desc) ?></span>
				</div><br/>
				<?php } ?>
			</div>
			<?php
		}
		/* Product custom Childs
			 * to display a simple link use $field->virtuemart_product_id as link to child product_id
			 * custom_value is relation value to child
			 */

		if (!empty($this->product->customsChilds)) {
			?>
			<div class="product-fields">
				<?php foreach ($this->product->customsChilds as $field) { ?>
				<div class="product-field product-field-type-<?php echo $field->field->field_type ?>">
					<span class="product-fields-title"><strong><?php echo JText::_ ($field->field->custom_title) ?></strong></span>
					<span class="product-field-desc"><?php echo JText::_ ($field->field->custom_value) ?></span>
					<span class="product-field-display"><?php echo $field->display ?></span>

				</div><br/>
				<?php } ?>
			</div>
		<?php
		}

		if (!VmConfig::get('use_as_catalog', 0)  ) {
		?>

		<div class="addtocart-bar">

<script type="text/javascript">
		function check(obj) {
 		// use the modulus operator '%' to see if there is a remainder
		remainder=obj.value % <?php echo $step?>;
		quantity=obj.value;
 		if (remainder  != 0) {
 			alert('<?php echo $alert?>!');
 			obj.value = quantity-remainder;
 			return false;
 			}
 		return true;
 		}
</script> 

		<?php // Display the quantity box

			$stockhandle = VmConfig::get ('stockhandle', 'none');
			if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($this->product->product_in_stock - $this->product->product_ordered) < 1) {
				?>
				<a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' . $this->product->virtuemart_product_id); ?>" class="notify"><?php echo JText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?></a>
				<?php
			} else {
				$tmpPrice = (float) $this->product->prices['costPrice'];
				if (!( VmConfig::get('askprice', 0) and empty($tmpPrice) ) ) {
					?>
					<!-- <label for="quantity<?php echo $this->product->virtuemart_product_id; ?>" class="quantity_box"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
					<span class="quantity-box">
						<input type="text" class="quantity-input js-recalculate" name="quantity[]" onblur="check(this);"
							   value="<?php if (isset($this->product->step_order_level) && (int)$this->product->step_order_level > 0) {
									echo $this->product->step_order_level;
								} else if(!empty($this->product->min_order_level)){
									echo $this->product->min_order_level;
								}else {
									echo '1';
								} ?>"/>
					</span>
					<span class="quantity-controls js-recalculate">
					<input type="button" class="quantity-controls quantity-plus"  />
					<input type="button" class="quantity-controls quantity-minus" />
					</span>
					<?php // Display the quantity box END

					// Display the add to cart button ?>
          			<span class="addtocart-button">
          			<?php echo shopFunctionsF::getAddToCartButton ($this->product->orderable);
						// Display the add to cart button END  ?>
         			 </span>
                   
					<input type="hidden" class="pname" value="<?php echo htmlentities($this->product->product_name, ENT_QUOTES, 'utf-8') ?>"/>
					<input type="hidden" name="view" value="cart"/> 
					<noscript> <input type="hidden" name="task" value="add"/></noscript>
					<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $this->product->virtuemart_product_id ?>"/>
					<input type="hidden" name="Itemid" value="<?php echo vRequest::getInt('Itemid',0); ?>"/>
				<?php
				}
				?>
			<?php
			}
			?>
		<?php
// Ask a question about this product
if (VmConfig::get('ask_question', 0) == 1) {
    ?>
    		<div class="ask-a-question">
    		    <a class="ask-a-question" href="<?php echo $this->askquestion_url ?>" rel="nofollow" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
    		    <!--<a class="ask-a-question modal" rel="{handler: 'iframe', size: {x: 700, y: 550}}" href="<?php echo $this->askquestion_url ?>"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>-->
    		</div>
		<?php }
		?>	
		</div>
		<?php
		}
		?>
		<input type="hidden" name="option" value="com_virtuemart"/>

	</form>
    
</div>