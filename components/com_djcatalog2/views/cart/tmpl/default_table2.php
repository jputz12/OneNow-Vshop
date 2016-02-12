<?php
/**
 * @version $Id: default_table2.php 432 2015-05-21 10:36:05Z michal $
 * @package DJ-Catalog2
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Michal Olczyk - michal.olczyk@design-joomla.eu
 *
 * DJ-Catalog2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Catalog2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Catalog2. If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined ('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$return_url = base64_encode(JUri::getInstance()->__toString());

$price_auth = ($this->params->get('price_restrict', '0') == '1' && $user->guest) ? false : true;
$show_prices = (bool)($price_auth && (int)$this->params->get('cart_show_prices', 0) == 1 && $this->total['gross'] > 0.0);

$tbl_class = ($show_prices) ? 'djc_cart_table withprices' : 'djc_cart_table noprices';


?>
<form action="<?php echo DJCatalogHelperRoute::getCartRoute();?>" method="post" class="form-horizontal form">
<div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title" style="font-weight:bold;padding-left: 10px;font-size: 16px;">Your order</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <tbody>
				<?php
					$k = 1;
					$itemsImages = array();
				    $shipping_charges = 0;
					foreach($this->items as $item){
						$k = 1 - $k;
						
						if (!empty($item->parent)) {
							if (!$item->item_image && $item->parent->item_image) {
								$item->item_image = $item->parent->item_image;
								$item->image_caption = $item->parent->image_caption;
								$item->image_path = $item->parent->image_path;
								$item->image_fullpath = $item->parent->image_fullpath;
							}
							$item->name = $item->parent->name . ' ['.$item->name.']';
							$item->slug = $item->parent_id.':'.$item->parent->alias;
						}
				        
				                 $db = JFactory::getDbo();
				                $query = $db->getQuery(true);
				                $db->setQuery("SELECT * FROM  #__djc2_items_extra_fields_values_text WHERE item_id = '".$item->id."' AND field_id = 12");
				                $item_attr = $db->loadAssoc();
				                if($item_attr['value']>0)
				                {
				                    $shipping_charges = $shipping_charges + (3.25*2*$item_attr['value']);
				                }
						
						?>
				        <tr class="cat-list-row<?php echo $k;?> djc_row<?php echo $k; if ($item->featured == 1) echo ' featured_item'; ?>">
				            <td class="djc_td_title"  style="border-left: 0px;">
					            <?php if ($item->item_image) { ?>
						        	
								<a href="<?php echo JRoute::_(DJCatalogHelperRoute::getItemRoute($item->slug, $item->catslug)); ?>">
									<img class="img-polaroid" alt="<?php echo $item->image_caption; ?>" src="<?php echo DJCatalog2ImageHelper::getImageUrl($item->image_fullpath,'small'); ?>" height="100" width="100" style="float:left;"/>
								</a>
						        	
								<?php } ?>
								<strong> &nbsp; &nbsp;<a href="<?php echo JRoute::_(DJCatalogHelperRoute::getItemRoute($item->slug, $item->catslug)); ?>"><?php echo $item->name; ?></a></strong>
								<br/> &nbsp; &nbsp; &nbsp;	
				                <input type="text" name="quantity[<?php echo (int)$item->id; ?>]" class="input input-mini inputbox djc_qty_input" <?php /*?>onchange="this.form.submit();"<?php */ ?> value="<?php echo (int)$item->_quantity; ?>" style="float:left;margin-left:10px;margin-right:10px;" />
				            
					            <a class="button btn djc_cart_remove_btn" href="<?php echo JRoute::_('index.php?option=com_djcatalog2&task=cart.remove&item_id='.(int)$item->id); ?>" style="float:left;margin-top: 0px;font-weight: bold;padding: 4px 24px !important;" ><?php echo JText::_('COM_DJCATALOG2_CART_REMOVE_BUTTON_TITLE'); ?></a>
					          
				            </td>
				            <!--<td class="djc_td_update_qty" nowrap="nowrap">
				            		<input type="text" name="quantity[<?php echo (int)$item->id; ?>]" class="input input-mini inputbox djc_qty_input" <?php /*?>onchange="this.form.submit();"<?php */ ?> value="<?php echo (int)$item->_quantity; ?>" />
				            </td>
				            <td class="djc_td_cart_remove" nowrap="nowrap">
				            	<a class="button btn djc_cart_remove_btn" href="<?php echo JRoute::_('index.php?option=com_djcatalog2&task=cart.remove&item_id='.(int)$item->id); ?>"><?php echo JText::_('COM_DJCATALOG2_CART_REMOVE_BUTTON_TITLE'); ?></a>
				            </td> -->
				            <?php if ($show_prices) { ?>
				            <?php /*?>
				            <td class="djc_td_price djc_td_price_net" nowrap="nowrap">
				            	<?php echo DJCatalog2HtmlHelper::formatPrice($item->_prices['total']['net'], $this->params, false)?>
				            </td>
				            <td class="djc_td_price djc_td_price_tax" nowrap="nowrap">
				            	<?php echo DJCatalog2HtmlHelper::formatPrice($item->_prices['total']['tax'], $this->params, false)?>
				            </td>
				            <?php */ ?>
				            <td class="djc_td_price djc_td_price_gross text-right" nowrap="nowrap" style="border-left: 0px;">
				            	<?php echo ($item->_prices['total']['gross'] > 0.0) ? DJCatalog2HtmlHelper::formatPrice($item->_prices['total']['gross'], $this->params, false) : '-';?>
				            </td>
				            <?php } ?>
				        </tr>
					<?php } ?>
                  <!-- <tr>
                    <td><img src="images/cart-img.jpg" height="50" width="50"></td>
                    <td>Clarisonic SMART Pedi Transformation Set <br>
                      <div class="pull-left">
                        <select name="">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                      </div>
                      <div class="pull-left">
                        <div class="remove-btn">Remove</div>
                      </div></td>
                    <td class="text-right">$115.00</td>
                  </tr>
                  <tr>
                    <td><img src="images/cart-img.jpg" height="50" width="50"></td>
                    <td>Clarisonic SMART Pedi Transformation Set <br>
                      <div class="pull-left">
                        <select name="">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                      </div>
                      <div class="pull-left">
                        <div class="remove-btn">Remove</div>
                      </div></td>
                    <td class="text-right">$115.00</td>
                  </tr> -->
                </tbody>
              </table>
            </div>
            <div>
            <table width="100%">
            	<tr>
            		<td width="90%" height="50px;">
		            	<div class="clearfix subtotal" style="padding:10px;">
			              <div class="col-md-10 text-right">
			              	<b>Subtotal</b>
			              </div>
			            </div>
			        </td>
            		<td width="10%">
            			<div class="clearfix subtotal"  style="padding:10px; background-color:#CCC;">
	            			<div class="col-md-2 text-right subtotal-bg">
	            				<b><?php echo DJCatalog2HtmlHelper::formatPrice($this->total['gross'], $this->params); ?></b>
	            			</div>
            			</div>
            		</td>
            	</tr>
	            <tr>
            		<td width="90%" height="50px;">
		            	<div class="clearfix subtotal" style="padding:10px;">
			              <div class="col-md-10 text-right">
			              	(Calculated during checkout) <b>Tax:</b>
			              </div>
			            </div>
			        </td>
            		<td width="10%">
            			<div class="clearfix subtotal"  style="padding:10px;">
	            			<div class="col-md-2 text-right subtotal-bg">
	            				<b><?php echo DJCatalog2HtmlHelper::formatPrice($taxes, $this->params); ?></b>
	            			</div>
            			</div>
            		</td>
            	</tr>
            	<tr>
            		<td width="90%" height="50px;">
		            	<div class="clearfix subtotal" style="padding:10px;">
			              <div class="col-md-10 text-right">
			              	(Calculated after shipping address is indicated) <b>Shipping:</b>
			              </div>
			            </div>
			        </td>
            		<td width="10%">
            			<div class="clearfix subtotal"  style="padding:10px;">
	            			<div class="col-md-2 text-right subtotal-bg">
	            				<b><?php echo DJCatalog2HtmlHelper::formatPrice($shipping_charges, $this->params); ?></b>
	            			</div>
            			</div>
            		</td>
            	</tr>
            	<tr>
            		<td width="90%" height="50px;">
		            	<div class="clearfix subtotal" style="padding:10px;">
			              <div class="col-md-10 text-right">
			              	<b>Total</b>
			              </div>
			            </div>
			        </td>
            		<td width="10%">
            			<div class="clearfix subtotal"  style="padding:10px; background-color:#666;color:#FFF">
	            			<div class="col-md-2 text-right subtotal-bg">
	            				<b><?php echo DJCatalog2HtmlHelper::formatPrice($this->total['gross'] + $shipping_charges, $this->params); ?></b>
	            			</div>
            			</div>
            		</td>
            	</tr>
            	<?php echo JHtml::_( 'form.token' ); ?>
            	
	        </table>
	        </div>
          </div>
        </div>
<!--<table width="100%" cellpadding="0" cellspacing="0" class="<?php echo $tbl_class; ?>  jlist-table table-condensed table category" id="djc_cart_table">
	<thead>
		<tr>
			<th class="djc_thead djc_th_title">
				<?php echo JText::_('COM_DJCATALOG2_CART_NAME'); ?>
	        </th>
	        <th class="djc_thead djc_th_qty" colspan="2">
				<?php echo JText::_('COM_DJCATALOG2_QUANTITY'); ?>
	        </th>
	        <?php if ($show_prices) { ?>
	        <?php /* ?>
	        <th class="djc_thead djc_th_price djc_th_price_net">
				<?php echo JText::_('COM_DJCATALOG2_NET_VALUE'); ?>
	        </th>
	        <th class="djc_thead djc_th_price djc_th_price_tax">
				<?php echo JText::_('COM_DJCATALOG2_TAX'); ?>
	        </th>
	        <?php */ ?>
	        <th class="djc_thead djc_th_price djc_th_price_gross">
				<?php echo JText::_('COM_DJCATALOG2_TOTAL_VALUE'); ?>
	        </th>
	        <?php } ?>
	    </tr>
	</thead>
    <tbody>
        <?php
	$k = 1;
	$itemsImages = array();
    $shipping_charges = 0;
	foreach($this->items as $item){
		$k = 1 - $k;
		
		if (!empty($item->parent)) {
			if (!$item->item_image && $item->parent->item_image) {
				$item->item_image = $item->parent->item_image;
				$item->image_caption = $item->parent->image_caption;
				$item->image_path = $item->parent->image_path;
				$item->image_fullpath = $item->parent->image_fullpath;
			}
			$item->name = $item->parent->name . ' ['.$item->name.']';
			$item->slug = $item->parent_id.':'.$item->parent->alias;
		}
        
                 $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                $db->setQuery("SELECT * FROM  #__djc2_items_extra_fields_values_text WHERE item_id = '".$item->id."' AND field_id = 12");
                $item_attr = $db->loadAssoc();
                if($item_attr['value']>0)
                {
                    $shipping_charges = $shipping_charges + (3.25*2*$item_attr['value']);
                }
		
		?>
        <tr class="cat-list-row<?php echo $k;?> djc_row<?php echo $k; if ($item->featured == 1) echo ' featured_item'; ?>">
            <td class="djc_td_title">
            <?php if ($item->item_image) { ?>
	        	<span class="djc_image">
					<a href="<?php echo JRoute::_(DJCatalogHelperRoute::getItemRoute($item->slug, $item->catslug)); ?>"><img class="img-polaroid" alt="<?php echo $item->image_caption; ?>" src="<?php echo DJCatalog2ImageHelper::getImageUrl($item->image_fullpath,'small'); ?>"/></a>
	        	</span>
			<?php } ?>
			<strong><a href="<?php echo JRoute::_(DJCatalogHelperRoute::getItemRoute($item->slug, $item->catslug)); ?>"><?php echo $item->name; ?></a></strong>
            </td>
            <td class="djc_td_update_qty" nowrap="nowrap">
            		<input type="text" name="quantity[<?php echo (int)$item->id; ?>]" class="input input-mini inputbox djc_qty_input" <?php /*?>onchange="this.form.submit();"<?php */ ?> value="<?php echo (int)$item->_quantity; ?>" />
            </td>
            <td class="djc_td_cart_remove" nowrap="nowrap">
            	<a class="button btn djc_cart_remove_btn" href="<?php echo JRoute::_('index.php?option=com_djcatalog2&task=cart.remove&item_id='.(int)$item->id); ?>"><?php echo JText::_('COM_DJCATALOG2_CART_REMOVE_BUTTON_TITLE'); ?></a>
            </td>
            <?php if ($show_prices) { ?>
            <?php /*?>
            <td class="djc_td_price djc_td_price_net" nowrap="nowrap">
            	<?php echo DJCatalog2HtmlHelper::formatPrice($item->_prices['total']['net'], $this->params, false)?>
            </td>
            <td class="djc_td_price djc_td_price_tax" nowrap="nowrap">
            	<?php echo DJCatalog2HtmlHelper::formatPrice($item->_prices['total']['tax'], $this->params, false)?>
            </td>
            <?php */ ?>
            <td class="djc_td_price djc_td_price_gross" nowrap="nowrap">
            	<?php echo ($item->_prices['total']['gross'] > 0.0) ? DJCatalog2HtmlHelper::formatPrice($item->_prices['total']['gross'], $this->params, false) : '-';?>
            </td>
            <?php } ?>
        </tr>
	<?php } ?>
	</tbody> -->
	<!--<tfoot>
		<?php if ($show_prices) { ?>
        <tr class="djc_cart_foot">
			<td colspan="3" class="djc_ft_total_label">
				Subtotal:
			</td>
			<?php /* ?>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['net'], $this->params)?>
			</td>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['tax'], $this->params)?>
			</td>
			<?php */ ?>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['gross'], $this->params); ?>
			</td>
		</tr>
        <tr class="djc_cart_foot">
			<td colspan="3" class="djc_ft_total_label">
				Shipping Charges:
			</td>
			<?php /* ?>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['net'], $this->params)?>
			</td>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['tax'], $this->params)?>
			</td>
			<?php */ ?>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($shipping_charges, $this->params); ?>
			</td>
		</tr>
		<tr class="djc_cart_foot">
			<td colspan="3" class="djc_ft_total_label">
				<?php echo JText::_('COM_DJCATALOG2_CART_FOOTER_TOTAL'); ?>
			</td>
			<?php /* ?>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['net'], $this->params)?>
			</td>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['tax'], $this->params)?>
			</td>
			<?php */ ?>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['gross'] + $shipping_charges, $this->params); ?>
			</td>
		</tr>
		<?php } ?> -->
		<!-- <tr class="djc_cart_buttons">
			<td colspan="4">
				<input type="submit" class="button btn" value="<?php echo JText::_('COM_DJCATALOG2_CART_UPDATE_BUTTON'); ?>" />
				<input type="hidden" name="task" value="cart.update_batch"/>
				<input type="hidden" name="return" value="<?php echo $return_url; ?>" />
				<a class="button btn" href="<?php echo JRoute::_('index.php?option=com_djcatalog2&task=cart.clear&'.JSession::getFormToken().'=1');?>"><?php echo JText::_('COM_DJCATALOG2_CART_CLEAR_BUTTON'); ?></a>
				<?php echo JHtml::_( 'form.token' ); ?>
			</td>
		</tr>
	</tfoot>
    
</table> -->
</form>