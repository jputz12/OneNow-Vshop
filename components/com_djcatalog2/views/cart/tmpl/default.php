<?php
/**
 * @version $Id: default.php 452 2015-06-09 18:14:02Z michal $
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
$cart = Djcatalog2HelperCart::getInstance();
$items = $cart->getItems();
$item_number = count($items);
$cartflag = 1;
echo $cartflag;
?>

<?php //if ($this->params->get( 'show_page_heading', 1)) { ?>
<h1 class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ) ?>">
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php //} ?>

<div id="djcatalog" class="djc_cart<?php echo $this->params->get( 'pageclass_sfx' ).' djc_theme_'.$this->params->get('theme','default') ?>">

<?php if (count($this->items) > 0){ ?>
	<div class="djc_cart djc_clearfix">
		<?php echo $this->loadTemplate('table2'); ?>
	</div>
<?php } else { ?>
<p class="djc_empty_cart"><?php echo JText::_('COM_DJCATALOG2_CART_IS_EMPTY'); ?></p>
<?php } ?>

<?php if (count($this->items) > 0){ ?>
	<?php /* ?>
	<form action="<?php echo JRoute::_(DJCatalogHelperRoute::getCheckoutRoute());?>" method="post">
		<input type="submit" value="<?php echo JText::_('COM_DJCATALOG2_CONFIRM_CART');?>" class="btn button btn-success djc_checkout_btn" />
		<input type="hidden" name="option" value="com_djcatalog2" />
		<input type="hidden" name="task" value="cart.checkout" />
		<?php echo JHtml::_( 'form.token' ); ?>
	</form>
	<?php */ ?>
	
	<?php if ($this->params->get('cart_query_enabled', '1') == '1') { ?>
		<form id="globalcheckoutform" method="post" action="https://secure1.cgwstage.com/vshop_checkout/global-check-out.do">
			<input type="submit" value="<?php echo JText::_('COM_DJCATALOG2_PROCEED_TO_CONTACT_FORM');?>" class="btn button btn-success djc_query_btn" />
			<input type="hidden" name="option" value="com_djcatalog2" />
			<input type="hidden" name="task" value="cart.query" />
			<?php echo JHtml::_( 'form.token' ); ?>
            
            <input type="hidden" name="merchant" value="vShop">
            <input type="hidden" name="merchantShoppingCart" value="http://203.116.15.222/development/index.php/cart">
            <input type="hidden" name="cartlockurl" value="http://203.116.15.222<?php echo JRoute::_('index.php?option=com_djcatalog2&task=cart.clear&'.JSession::getFormToken().'=1');?>">
            <input type="hidden" name="itemNumber" value="<?php echo $item_number;?>">
            <?php
            $i = 0;
            $shipping_charges = 0;
            foreach($this->items as $item)
            {
                $flagitem = $i + 1;
                //connect to db
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                $db->setQuery("SELECT * FROM  #__djc2_items_extra_fields_values_text WHERE item_id = '".$item->id."' AND field_id = 12");
                $item_attr = $db->loadAssoc();
                if($item_attr['value']>0)
                {
                    $shipping_charges = $shipping_charges + (3.25*2*$item_attr['value']);
                }
                
            ?>
            <input type="hidden" value="http://www.abc.com/product123" name="url1">
            <input type="hidden" value="<?php echo $item->name;?>" name="prodname<?php echo $flagitem;?>">
            <input type="hidden" value="<?php echo (int)$item->_quantity; ?>" name="prodnumb<?php echo $flagitem;?>">
            <input type="hidden" value="<?php echo $item->price;?>" name="unitprice<?php echo $flagitem;?>">
            <input type="hidden" value="<?php echo $item_attr['value'];?>" name="actualweight<?php echo $flagitem;?>">
            <input type="hidden" value="http://203.116.15.222/development/media/djcatalog2/images/<?php echo $item->image_fullpath;?>" name="imageurl<?php echo $flagitem;?>">
            <input type="hidden" value="" name="otherinfo<?php echo $flagitem;?>">
            <input type="hidden" value="" name="size<?php echo $flagitem;?>">
            <input type="hidden" value="" name="color<?php echo $flagitem;?>">
            <?php 
                $i = $i + 1;  
            }
            ?>
            <input type="hidden" value="<?php echo $shipping_charges;?>" name="domestichandling">
		</form>
	<?php } ?>
<?php } ?>

<?php 
	if ($this->params->get('show_footer')) echo DJCATFOOTER;
?>
</div>
