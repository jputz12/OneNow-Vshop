<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2015 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined ( '_JEXEC' ) or die ();

$items = $order->getItems();
$taxes = $order->getOrderTaxrates();
$shipping = $order->getOrderShippingRate();
$coupons = $order->getOrderCoupons();
$vouchers = $order->getOrderVouchers();
$currency = J2Store::currency();
$params = J2Store::config();
?>
<style>

 .emailtemplate-table td {
   color: rgb(47, 47, 47); 
   font-style: normal; 
   font-variant: normal; 
   font-weight: normal; 
   font-size: 11px; 
   line-height: 1.35em;  
   padding: 7px 9px 9px; 
   border-width: 0px 1px 1px; 
   border-right: 1px solid rgb(190, 188, 183); 
   border-bottom: 1px solid rgb(190, 188, 183); 
   border-left: 1px solid rgb(190, 188, 183); 
   background-color: rgb(248, 247, 245);
   
 }
  
 .emailtemplate-table th {
   color:#FF8720; 
   padding: 5px 9px 6px; 
   border-top: 1px solid rgb(190, 188, 183); 
   border-right: 1px solid rgb(190, 188, 183); 
   border-left: 1px solid rgb(190, 188, 183); 
   border-style: solid solid none; 
   line-height: 1em;
 }
  
  .emailtemplate-table-footer td {
    text-align: right;    
  }

</style>

		<table class="emailtemplate-table" style="width: 100%;" border="0" cellspacing="" cellpadding="2">
			<tbody>
				<tr valign="top">
				<td rowspan="1" colspan="12">
					Thank you for your order! Your unique Order ID is:<strong>[ORDERID]</strong>, please keep this for your records.</p>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<table class="emailtemplate-table" width="100%" cellspacing="0" cellpadding="0" border="0">
			<thead class="">
				<tr class="">
					<th align="left" width="48.5%" style="color:#FF8720; padding: 5px 9px 6px; border-top: 1px solid rgb(190, 188, 183); border-right: 1px solid rgb(190, 188, 183); border-left: 1px solid rgb(190, 188, 183); border-style: solid solid none; line-height: 1em;">Order Information:</th>
					<th width="3%"></th>
					<th align="left" width="48.5%" style="color:#FF8720; padding: 5px 9px 6px; border-top: 1px solid rgb(190, 188, 183); border-right: 1px solid rgb(190, 188, 183); border-left: 1px solid rgb(190, 188, 183); border-style: solid solid none; line-height: 1em;">Customer Information:</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="color: rgb(47, 47, 47); font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: 1.35em; font-family: Verdana,Arial,Helvetica,sans-serif; padding: 7px 9px 9px; border-width: 0px 1px 1px; border-right: 1px solid rgb(190, 188, 183); border-bottom: 1px solid rgb(190, 188, 183); border-left: 1px solid rgb(190, 188, 183); background-color: rgb(248, 247, 245);">
						<p><strong>Order ID: </strong>[ORDERID]</p>
						<p><strong>Invoice Number: </strong>[INVOICENO]</p>
						<p><strong>Date: </strong>[ORDERDATE]</p>
						<p><strong>Order Amount: </strong>[ORDERAMOUNT]</p>
						<p><strong>Order Status: </strong>[ORDERSTATUS]</p>
						<p>&nbsp;</p>
					</td>
					<td style="color: rgb(47, 47, 47); font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: 1.35em; font-family: Verdana,Arial,Helvetica,sans-serif;"> </td>
					<td style="color: rgb(47, 47, 47); font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: 1.35em; font-family: Verdana,Arial,Helvetica,sans-serif; padding: 7px 9px 9px; border-width: 0px 1px 1px; border-right: 1px solid rgb(190, 188, 183); border-bottom: 1px solid rgb(190, 188, 183); border-left: 1px solid rgb(190, 188, 183); background-color: rgb(248, 247, 245);">
						<p>[BILLING_FIRSTNAME] [BILLING_LASTNAME]</p>
						<p>[BILLING_ADDRESS_1] [BILLING_ADDRESS_2]</p>
						<p>[BILLING_CITY], [BILLING_ZIP]</p>
						<p>[BILLING_STATE] [BILLING_COUNTRY]</p>
						<p>[BILLING_PHONE] [BILLING_MOBILE]</p>
						<p>[BILLING_COMPANY]</p>
                      	<p><strong>Email: </strong>[BILLING_EMAIL]</p>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<thead class="">
				<tr class="">
					<th align="left" width="48.5%" style="color:#FF8720; padding: 5px 9px 6px; border-top: 1px solid rgb(190, 188, 183); border-right: 1px solid rgb(190, 188, 183); border-left: 1px solid rgb(190, 188, 183); border-style: solid solid none; line-height: 1em;">Payment Information:</th>
					<th width="3%"></th>
					<th align="left" width="48.5%" style="color:#FF8720; padding: 5px 9px 6px; border-top: 1px solid rgb(190, 188, 183); border-right: 1px solid rgb(190, 188, 183); border-left: 1px solid rgb(190, 188, 183); border-style: solid solid none; line-height: 1em;">Shipping Information:</th>
				</tr>
			</thead>
			<tbody>
				<tr valign="top">
					<td style="color: rgb(47, 47, 47); font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: 1.35em;  padding: 7px 9px 9px; border-width: 0px 1px 1px; border-right: 1px solid rgb(190, 188, 183); border-bottom: 1px solid rgb(190, 188, 183); border-left: 1px solid rgb(190, 188, 183); background-color: rgb(248, 247, 245);">
						<p><strong>Payment Type: </strong>[PAYMENT_TYPE]</p>						
						<p>&nbsp;</p>
					</td>
					<td style="color: rgb(47, 47, 47); font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: 1.35em; "> </td>
					<td style="color: rgb(47, 47, 47); font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: 1.35em; padding: 7px 9px 9px; border-width: 0px 1px 1px; border-right: 1px solid rgb(190, 188, 183); border-bottom: 1px solid rgb(190, 188, 183); border-left: 1px solid rgb(190, 188, 183); background-color: rgb(248, 247, 245);">
						<p>[SHIPPING_FIRSTNAME] [SHIPPING_LASTNAME]</p>
						<p>[SHIPPING_ADDRESS_1] [SHIPPING_ADDRESS_2]</p>
						<p>[SHIPPING_CITY], [SHIPPING_ZIP]</p>
						<p>[SHIPPING_STATE] [SHIPPING_COUNTRY]</p>
						<p>[SHIPPING_PHONE] [SHIPPING_MOBILE]</p>
						<p>[SHIPPING_COMPANY]</p>
						<p>[SHIPPING_METHOD]</p>
					</td>
				</tr>
			</tbody>
		</table>

	<!-- Order items -->

	<h3><?php echo JText::_('J2STORE_ORDER_SUMMARY')?></h3>
	<table class="emailtemplate-table" width="100%" cellspacing="0" cellpadding="0" border="0">
		<thead>
			<tr>
				<th align="left"><?php echo JText::_('J2STORE_CART_LINE_ITEM'); ?></th>
              <th align="left"><?php echo JText::_('J2STORE_CART_LINE_ITEM_QUANTITY'); ?></th>
				<th align="left"><?php echo JText::_('J2STORE_CART_LINE_ITEM_TOTAL'); ?></th>
			</tr>
			</thead>
			<tbody>

				<?php foreach ($items as $item): ?>
				<?php
					$registry = new JRegistry;
					$registry->loadString($item->orderitem_params);
					$item->params = $registry;
					$thumb_image = $item->params->get('thumb_image', '');
				?>
				<tr valign="top">
					<td>
						<?php if($params->get('show_thumb_cart', 1) && !empty($thumb_image)): ?>
							<span class="cart-thumb-image">
								<?php if(JFile::exists(JPATH_SITE.'/'.$thumb_image)): ?>
								<img style="float: left;" width="120" src="<?php echo JUri::root(true).'/'.$thumb_image; ?>" >
								<?php endif;?>
							</span>
						<?php endif; ?>
						<span class="cart-product-name">
							<?php echo $item->orderitem_name; ?>
						</span>
						<br />
						<?php if(isset($item->orderitemattributes)): ?>
							<span class="cart-item-options">
							<?php foreach ($item->orderitemattributes as $attribute): ?>
								<small>
								- <?php echo JText::_($attribute->orderitemattribute_name); ?> : <?php echo $attribute->orderitemattribute_value; ?>
								</small>

								<br />
							<?php endforeach;?>
							</span>
						<?php endif; ?>

						<?php if($params->get('show_price_field', 1)): ?>

							<span class="cart-product-unit-price">
								<span class="cart-item-title"><?php echo JText::_('J2STORE_CART_LINE_ITEM_UNIT_PRICE'); ?></span>								
								<span class="cart-item-value">
									<?php if($params->get('checkout_price_display_options', 1)): ?>
										<?php 
										$price = $item->orderitem_finalprice_with_tax / $item->orderitem_quantity;
										echo $currency->format( $price, $order->currency_code, $order->currency_value); 
										?>
									<?php else: ?>
										<?php 
										$price = $item->orderitem_finalprice_without_tax / $item->orderitem_quantity;
										echo $currency->format($price, $order->currency_code, $order->currency_value); ?>
									<?php endif; ?>
								</span>
							</span>
						<?php endif; ?>

						<?php if(!empty($item->orderitem_sku)): ?>
						<br />
							<span class="cart-product-sku">
								<span class="cart-item-title"><?php echo JText::_('J2STORE_CART_LINE_ITEM_SKU'); ?></span>
								<span class="cart-item-value"><?php echo $item->orderitem_sku; ?></span>
							</span>

						<?php endif; ?>
					</td>
                  	<td><?php echo $item->orderitem_quantity; ?></td>
				   <td>	<?php echo $currency->format($order->get_formatted_lineitem_total($item, $params->get('checkout_price_display_options', 1)), $order->currency_code, $order->currency_value ); ?>					
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			</table>
			<table class="emailtemplate-table emailtemplate-table-footer" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td>
						<?php echo JText::_('J2STORE_CART_SUBTOTAL'); ?>
					</td>
					<td>
						<?php echo $currency->format($order->get_formatted_subtotal($params->get('checkout_price_display_options', 1)), $order->currency_code, $order->currency_value ); ?>
					</td>
				</tr>

				<!-- shipping -->
				<?php if(isset($order->order_shipping) && !empty($shipping->ordershipping_name)): ?>
                <tr>
                    <td>
                        <?php echo JText::_(stripslashes($shipping->ordershipping_name)); ?>
                    </td>
                     <td>
                        <?php echo $currency->format($order->order_shipping, $order->currency_code, $order->currency_value); ?>
                     </td>
                </tr>
				<?php endif; ?>
				<!-- shipping tax -->
				<?php if(isset($order->order_shipping_tax) && $order->order_shipping_tax > 0): ?>
                <tr>
                    <td>
                        <?php echo JText::_('J2STORE_ORDER_SHIPPING_TAX'); ?>
                    </td>
                     <td>
                        <?php echo $currency->format($order->order_shipping_tax, $order->currency_code, $order->currency_value); ?>
                     </td>
                </tr>
				<?php endif; ?>

				<!-- Surcharge -->
	        	<?php if ($order->order_surcharge > 0): ?>
	        	<tr>
	        		<td><?php echo JText::_("J2STORE_CART_SURCHARGE"); ?></td>
	        		<td><?php echo $currency->format($order->order_surcharge, $order->currency_code, $order->currency_value); ?></td>
	        	</tr>
	        	<?php endif; ?>


	        	<!-- Surcharge -->
	        	<?php if ($order->order_discount > 0): ?>
	        	<tr>
	        	<td>
	        	<?php echo JText::_('J2STORE_MINUS_SYMBOL'); ?> <?php echo JText::_('J2STORE_CART_DISCOUNT'); ?>
				 <!-- coupon -->
	
               <?php if(isset($coupons)): ?>
               <table>
               <?php foreach($coupons as $coupon): ?>
               	<tr>
               		<td>
 							<?php echo JText::sprintf('J2STORE_COUPON_TITLE', $coupon->coupon_code); ?>
 					</td>
 					 <td>
 						 <?php echo $currency->format($coupon->amount, $order->currency_code, $order->currency_value); ?>
 					 </td>
 				</tr>
 				<?php endforeach; ?>
 				</table>
 				<?php endif;?>

 				<!-- voucher -->

               <?php if(count($vouchers)): ?>
               <table>
               <?php foreach($vouchers as $voucher): ?>
               	<tr>
               		<td>
 							<?php echo JText::sprintf('J2STORE_VOUCHER_TITLE', $voucher->voucher_code); ?>
 					</td>
 					 <td>
 						 <?php echo $currency->format($voucher->amount, $order->currency_code, $order->currency_value); ?>

 					 </td>
 				</tr>
 				<?php endforeach; ?>
 				</table>
 				<?php endif;?>
 				</td>
 					<td><?php echo $currency->format($order->order_discount, $order->currency_code, $order->currency_value); ?></td>
				</tr>
				<?php endif; ?>
				<!-- taxes -->
				<?php if(isset($taxes) && count($taxes) ): ?>
				<tr>
					<td>
							<?php if($params->get('checkout_price_display_options', 1)): ?>
								<?php echo JText::_('J2STORE_CART_INCLUDING_TAX'); ?>
							<?php else: ?>
								<?php echo JText::_('J2STORE_CART_TAX'); ?>
							<?php endif; ?>
							<br />
							<?php foreach ($taxes as $tax): ?>
								<?php echo JText::_($tax->ordertax_title); ?> (<?php echo (float) $tax->ordertax_percent; ?> %)
								<br />
							<?php endforeach; ?>
					</td>
					<td>
					<?php foreach ($taxes as $tax): ?>
							<?php echo $currency->format($tax->ordertax_amount, $order->currency_code, $order->currency_value); ?>
							<br />
					<?php endforeach; ?>
					</td>
				</tr>
				<?php endif; ?>

				<tr class="j2store-grand-total">
					<td>
							<?php echo JText::_('J2STORE_CART_GRANDTOTAL'); ?>
					</td>
					<td><?php echo $currency->format($order->order_total, $order->currency_code, $order->currency_value); ?></td>
				</tr>              
			</table>

			<div>
				<br>
				<p>You can also view the order details by visiting [INVOICE_URL]</p>
				<p>You can use your email address and the following token to view the order [ORDER_TOKEN]</p>
			</div>