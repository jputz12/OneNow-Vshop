<?php
/**
 * @version $Id: default_table.php 432 2015-05-21 10:36:05Z michal $
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
//$show_prices = false; //(bool)($price_auth && (int)$this->params->get('cart_show_prices', 0) == 1 && $this->total['gross'] > 0.0);
$show_prices = (bool)($price_auth && (int)$this->params->get('cart_show_prices', 0) == 1 && $this->total['gross'] > 0.0);
$tbl_class = ($show_prices) ? 'djc_cart_table withprices' : 'djc_cart_table noprices';

?>
<table width="100%" cellpadding="0" cellspacing="0" class="<?php echo $tbl_class; ?> jlist-table category table-condensed table" id="djc_cart_checkout_table">
	<thead>
		<tr>
			<th class="djc_thead djc_th_title">
				<?php echo JText::_('COM_DJCATALOG2_CART_NAME'); ?>
	        </th>
	        <th class="djc_thead djc_th_qty">
				<?php echo JText::_('COM_DJCATALOG2_QUANTITY'); ?>
	        </th>
	        <?php if ($show_prices) { ?>
	        <?php /*?>
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
	<?php if ($show_prices) { ?>
	<tfoot>
		<tr>
			<td colspan="2" class="djc_ft_total_label">
				<?php echo JText::_('COM_DJCATALOG2_CART_FOOTER_TOTAL'); ?>
			</td>
			 <?php /*?>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['net'], $this->params)?>
			</td>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['tax'], $this->params)?>
			</td>
			 <?php */?>
			<td>
				<?php echo DJCatalog2HtmlHelper::formatPrice($this->total['gross'], $this->params)?>
			</td>
		</tr>
	</tfoot>
	<?php } ?>
    <tbody>
        <?php
	$k = 1;
	$itemsImages = array();
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
            <td class="djc_td_qty" nowrap="nowrap">
            	<?php echo (int)$item->_quantity; ?>
            </td>
           	<?php if ($show_prices) { ?>
           	 <?php /*?>
            <td class="djc_td_price djc_td_price_net" nowrap="nowrap">
            	<?php echo DJCatalog2HtmlHelper::formatPrice($item->_prices['total']['net'], $this->params, false)?>
            </td>
            <td class="djc_td_price djc_td_price_tax" nowrap="nowrap">
            	<?php echo DJCatalog2HtmlHelper::formatPrice($item->_prices['total']['tax'], $this->params, false)?>
            </td>
             <?php */?>
            <td class="djc_td_price djc_td_price_gross" nowrap="nowrap">
            	<?php echo ($item->_prices['total']['gross'] > 0.0) ? DJCatalog2HtmlHelper::formatPrice($item->_prices['total']['gross'], $this->params, false) : '-';?>
            </td>
            <?php } ?>
        </tr>
	<?php } ?>
	</tbody>
</table>