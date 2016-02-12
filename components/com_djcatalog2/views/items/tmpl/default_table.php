<?php
/**
 * @version $Id: default_table.php 450 2015-06-09 18:07:53Z michal $
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
$user		= JFactory::getUser();
$price_auth = ($this->params->get('price_restrict', '0') == '1' && $user->guest) ? false : true;

$show_location = (bool)((int)$this->params->get('show_location_details', true) > 0);
if ($show_location) {
	$show_location = false;
	$location_fields = array('location_country', 'location_city', 'location_address', 'location_postcode', 'location_phone', 'location_mobile', 'location_fax', 'location_website', 'location_email');
	foreach($location_fields as $param) {
		if ($this->params->get($param, '1') == '1' || $this->params->get($param, '1') == '2') {
			$show_location = true; 
			break;
		}
	}
}

$show_additional_data = false;
if ($this->params->get('items_show_attributes', '1') == '1') {
	foreach ($this->attributes as $attribute) {
		$show_additional_data = (bool)($show_additional_data || (int)$attribute->separate_column != 1);
	}
}

?>
<table width="100%" cellpadding="0" cellspacing="0" class="djc_items_table jlist-table category table table-condensed" id="djc_items_table">
	<thead>
		<tr>
			<?php if ((int)$this->params->get('image_link_item') != -1) { ?>
				<th class="djc_thead djc_th_image">&nbsp;</th>
			<?php } ?>
			<?php if ((int)$this->params->get('show_item_name','1') > 0 ) {?>
				<th class="djc_thead djc_th_title" nowrap="nowrap">
					<?php echo JText::_('COM_DJCATALOG2_NAME'); ?>
		        </th>
	        <?php } ?>
			<?php if ($this->params->get('items_show_intro')) {?>
                <th class="djc_thead djc_th_intro" nowrap="nowrap">
                    <?php echo JText::_('COM_DJCATALOG2_DESCRIPTION'); ?>
                </th>
			<?php } ?>
			<?php if ($this->params->get('show_category_name') > 0) { ?>
				<th class="djc_thead djc_th_category" nowrap="nowrap">
					<?php echo JText::_('COM_DJCATALOG2_CATEGORY'); ?>
				</th>
			<?php } ?>
			<?php if ($this->params->get('show_producer_name') > 0) { ?>
				<th class="djc_thead djc_th_producer" nowrap="nowrap">
					<?php echo JText::_('COM_DJCATALOG2_PRODUCER'); ?>
				</th>
			<?php } ?>
			<?php if ($price_auth && $this->params->get('show_price') > 0) { ?>
	                <th class="djc_thead djc_th_price" nowrap="nowrap">
	                	<?php echo JText::_('COM_DJCATALOG2_PRICE'); ?>
	                </th>
			<?php } ?>
			
			<?php if( $show_location) { ?>
				<?php if ((int) $this->params->get('location_table_combine', '1') == '1') { ?>
					<th class="djc_thead djc_th_location">
						<?php echo JText::_('COM_DJCATALOG2_LOCATION'); ?>
					</th>				
				<?php } else { ?>
					<?php if ($this->params->get('location_country', 1) == '1' || $this->params->get('location_country', 1) == '2') {?>
					<th class="djc_thead djc_th_country">
						<?php echo JText::_('COM_DJCATALOG2_UP_COUNTRY'); ?>
				    </th>
				    <?php } ?>
					<?php if ($this->params->get('location_city', 1) == '1' || $this->params->get('location_city', 1) == '2') {?>
					<th class="djc_thead djc_th_city">
						<?php echo JText::_('COM_DJCATALOG2_UP_CITY'); ?>
				    </th>
				    <?php } ?>
				    <?php if ($this->params->get('location_address', 1) == '1' || $this->params->get('location_address', 1) == '2') {?>
				   	<th class="djc_thead djc_th_street">
	                	<?php echo JText::_('COM_DJCATALOG2_UP_ADDRESS'); ?>
	                 </th>
	                 <?php } ?>
				    <?php if ($this->params->get('location_postcode', 1) == '1' || $this->params->get('location_postcode', 1) == '2') {?>
	                 <th class="djc_thead djc_th_postcode">
	                     <?php echo JText::_('COM_DJCATALOG2_UP_POSTCODE'); ?>
	                 </th>
	                 <?php } ?>
				    <?php if ($this->params->get('location_phone', 1) == '1' || $this->params->get('location_phone', 1) == '2') {?>
	                 <th class="djc_thead djc_th_phone">
	                     <?php echo JText::_('COM_DJCATALOG2_UP_PHONE'); ?>
	                 </th>
	                 <?php } ?>
				     <?php if ($this->params->get('location_mobile', 1) == '1' || $this->params->get('location_mobile', 1) == '2') {?>
	                 <th class="djc_thead djc_th_mobile">
	                     <?php echo JText::_('COM_DJCATALOG2_UP_MOBILE'); ?>
	                 </th>
	                 <?php } ?>
				     <?php if ($this->params->get('location_fax', 1) == '1' || $this->params->get('location_fax', 1) == '2') {?>
	                 <th class="djc_thead djc_th_fax">
	                     <?php echo JText::_('COM_DJCATALOG2_UP_FAX'); ?>
	                 </th>
	                 <?php } ?>
				     <?php if ($this->params->get('location_website', 1) == '1' || $this->params->get('location_website', 1) == '2') {?>
	                 <th class="djc_thead djc_th_website">
	                     <?php echo JText::_('COM_DJCATALOG2_UP_WEBSITE'); ?>
	                 </th>
	                 <?php } ?>
				     <?php if ($this->params->get('location_email', 1) == '1' || $this->params->get('location_email', 1) == '2') {?>
	                 <th class="djc_thead djc_th_email">
	                     <?php echo JText::_('COM_DJCATALOG2_UP_EMAIL'); ?>
	                 </th>
	                 <?php } ?>
				<?php } ?>
			<?php } ?>
			
			<?php if ($this->params->get('items_show_attributes', '1') && !empty($this->column_attributes)) { ?>
				<?php foreach ($this->column_attributes as $column) { ?>
					<th class="djc_thead djc_th_attributes djc_th_attribute_<?php echo $column->alias; ?>">
						<?php 
						echo $this->escape($column->name); 
						unset($this->attributes[$column->id]);
						?>
					</th>
				<?php } ?>
			<?php } ?>
			<?php if ($show_additional_data) { ?>
				<?php if (count($this->attributes)) { ?>
		            <th class="djc_thead djc_th_attribute" nowrap="nowrap">
	                	<?php echo JText::_('COM_DJCATALOG2_CUSTOM_ATTRIBUTES'); ?>
	                </th>
	            <?php } ?>
			<?php } ?>
			<?php if ($this->params->get('items_show_cart_button', '1') == 1 && ($this->params->get('cart_enabled', false) || $this->params->get('cart_query_enabled', 1) )) { ?>
				<th class="djc_thead djc_th_addtocart_cell">
				</th>
			<?php } ?>
	            </tr>
            </thead>
            <tbody>
        <?php
	$k = 1;
	foreach($this->items as $item){
		$k = 1 - $k;
		
		$this->item_cursor = $item;
		
		?>
        <tr class="cat-list-row<?php echo $k;?> djc_row<?php echo $k; if ($item->featured == 1) echo ' featured_item'; ?>">
            <?php if ((int)$this->params->get('image_link_item') != -1) { ?>
	            <td class="djc_image">
	                <?php if ($item->item_image) { ?>
		        	<div class="djc_image_in">
		        		<?php if ((int)$this->params->get('image_link_item') == 1) { ?>
							<a rel="djimagebox-djitem" class="djimagebox" title="<?php echo $item->image_caption; ?>" href="<?php echo DJCatalog2ImageHelper::getImageUrl($item->image_fullpath,'fullscreen'); ?>"><img class="img-polaroid" alt="<?php echo $item->image_caption; ?>" src="<?php echo DJCatalog2ImageHelper::getImageUrl($item->image_fullpath,'small'); ?>"/></a>
						<?php } else { ?>
							<a href="<?php echo JRoute::_(DJCatalogHelperRoute::getItemRoute($item->slug, (!isset($this->item) || (empty($this->item->catslug))) ? $item->catslug:$this->item->catslug)); ?>"><img class="img-polaroid" alt="<?php echo $item->image_caption; ?>" src="<?php echo DJCatalog2ImageHelper::getImageUrl($item->image_fullpath,'small'); ?>"/></a>
			        	<?php } ?>
		        	</div>
				<?php } ?>
	            </td>
            <?php } ?>
            <?php if ((int)$this->params->get('show_item_name','1') > 0 ) { ?>
				<td class="djc_td_title">
	           		<?php 
			        if ((int)$this->params->get('show_item_name','1') == 2 ) {
			        	echo $item->name;
			        } else {
			        	echo JHTML::link(JRoute::_(DJCatalogHelperRoute::getItemRoute($item->slug, (!isset($this->item) || (empty($this->item->catslug))) ? $item->catslug:$this->item->catslug)), $item->name);
			        } 
			        ?>
	                <?php if ($item->featured == 1) { 
						echo '<img class="djc_featured_image" alt="'.JText::_('COM_DJCATALOG2_FEATURED_ITEM').'" title="'.JText::_('COM_DJCATALOG2_FEATURED_ITEM').'" src="'.DJCatalog2ThemeHelper::getThemeImage('featured.png').'" />';
					}?>
					
					<?php if(!empty($item->event->afterDJCatalog2DisplayTitle)) { ?>
			        <div class="djc_post_title">
			            <?php echo $item->event->afterDJCatalog2DisplayTitle; ?>
			        </div>
			        <?php } ?>
	            </td>
            <?php } ?>
		<?php if ($this->params->get('items_show_intro')) {?>
		<td class="djc_introtext">
			<?php if ($this->params->get('items_intro_length') > 0 && $this->params->get('items_intro_trunc') == '1') {
					echo DJCatalog2HtmlHelper::trimText($item->intro_desc, $this->params->get('items_intro_length'));
				}
				else {
					echo $item->intro_desc; 
				}
			?>
		 </td>
		<?php } ?>
		<?php if ($this->params->get('show_category_name') > 0 && $item->publish_category) { ?>
				<td class="djc_category" >
					<?php 
						if ($this->params->get('show_category_name') == 2) {
	            			?><span><?php echo $item->category; ?></span> 
						<?php }
						else {
							?><a href="<?php echo JRoute::_(DJCatalogHelperRoute::getCategoryRoute($item->catslug)) ;?>"><span class="djcat_category"><?php echo $item->category; ?></span></a> 
						<?php } ?>
				</td>
			<?php } ?>
			<?php if ($this->params->get('show_producer_name') > 0) { ?>
				<td class="djc_producer">
				<?php if ($item->publish_producer && $item->producer) { ?>
					<?php 
						if ($this->params->get('show_producer_name') == 2 && $item->producer) {
	            			?><span><?php echo $item->producer;?></span>
						<?php }
						else if(($this->params->get('show_producer_name') == 3 && $item->producer)) {
							?><a class="modal" rel="{handler: 'iframe', size: {x: 800, y: 600}}" href="<?php echo JRoute::_(DJCatalogHelperRoute::getProducerRoute($item->prodslug).'&tmpl=component'); ?>"><span class="djcat_producer"><?php echo $item->producer; ?></span></a> 
						<?php }
						else if ($item->producer){
							?><a href="<?php echo JRoute::_(DJCatalogHelperRoute::getProducerRoute($item->prodslug)); ?>"><span class="djcat_producer"><?php echo $item->producer; ?></span></a>
						<?php } ?>
					<?php } ?>
				</td>
			<?php } ?>
		<?php if ($price_auth && $this->params->get('show_price') > 0) { ?>
            <td class="djc_price">
                <?php if ($item->price > 0.0) { ?>
	                <?php if ($item->price != $item->final_price ) { ?>
	                	<?php if ($this->params->get('show_old_price', '1') == '1') {?>
	        				<span class="djc_price_old"><?php echo DJCatalog2HtmlHelper::formatPrice($item->price, $this->params); ?></span><br /><span class="djc_price_new"><?php echo DJCatalog2HtmlHelper::formatPrice($item->final_price, $this->params); ?></span>
						<?php } else { ?>
							<span><?php echo DJCatalog2HtmlHelper::formatPrice($item->final_price, $this->params); ?></span>
						<?php } ?>
					<?php } else { ?>
						<span><?php echo DJCatalog2HtmlHelper::formatPrice($item->price, $this->params); ?></span>
					<?php } ?>
				<?php } ?>
            </td>
		<?php } ?>
		<?php if( $show_location) { ?>
			<?php if ((int) $this->params->get('location_table_combine', '1') == '1') { ?>
				<td class="djc_location">
					<?php
					$address = array();
					 
					if (($this->params->get('location_address', 1) == '1' || $this->params->get('location_address', 1) == '2') && $item->address) {
						$address[] = $item->address;
					}
					if (($this->params->get('location_postcode', 1) == '1' || $this->params->get('location_postcode', 1) == '2') && $item->postcode) {
						$address[] = $item->postcode;
					}
					if (($this->params->get('location_city', 1) == '1' || $this->params->get('location_city', 1) == '2') && $item->city) {
						$address[] = $item->city;
					}
					if (($this->params->get('location_country', 1) == '1' || $this->params->get('location_country', 1) == '2') && $item->country_name) {
						$address[] = $item->country_name;
					}
					
					if (count($address)) { ?>
					<p class="djc_address"><?php echo implode(', ', $address); ?></p>
					<?php }
					
					$contact = array();
					
					if (($this->params->get('location_phone', 1) == '1' || $this->params->get('location_phone', 1) == '2') && $item->phone) {
						$contact[] = JText::_('COM_DJCATALOG2_UP_PHONE').': <span>'.$item->phone.'</span>';
					}
					if (($this->params->get('location_mobile', 1) == '1' || $this->params->get('location_mobile', 1) == '2') && $item->mobile) {
						$contact[] = JText::_('COM_DJCATALOG2_UP_MOBILE').': <span>'.$item->mobile.'</span>';
					}
					if (($this->params->get('location_fax', 1) == '1' || $this->params->get('location_fax', 1) == '2') && $item->fax) {
						$contact[] = JText::_('COM_DJCATALOG2_UP_FAX').': <span>'.$item->fax.'</span>';
					}
					if (($this->params->get('location_website', 1) == '1' || $this->params->get('location_website', 1) == '2') && $item->website) {
						$item->website = (strpos($item->website, 'http') === 0) ? $item->website : 'http://'.$item->website;
	            		$item->website = preg_replace('#([\w]+://)([^\s()<>]+)#iS', '<a target="_blank" href="$1$2">$2</a>', htmlspecialchars($item->website));
	            		$contact[] = JText::_('COM_DJCATALOG2_UP_WEBSITE').': <span>'.$item->website.'</span>';
					}
					if (($this->params->get('location_email', 1) == '1' || $this->params->get('location_email', 1) == '2') && $item->email) {
						$item->email = preg_replace('#([\w.-]+(\+[\w.-]+)*@[\w.-]+)#i', '<a target="_blank" href="mailto:$1">$1</a>', htmlspecialchars($item->email));
						$contact[] = JText::_('COM_DJCATALOG2_UP_EMAIL').': <span>'.$item->email.'</span>';
					}
					
					if (count($contact)) { ?>
					<p class="djc_contact"><?php echo implode('<br />', $contact);?></p>
					<?php } ?>
				</td>
			<?php } else { ?>
				<?php if ($this->params->get('location_country', 1) == '1' || $this->params->get('location_country', 1) == '2') {?>
				<td class="djc_country">
	                <?php echo $item->country_name; ?>
	            </td>
	            <?php } ?>
	            <?php if ($this->params->get('location_city', 1) == '1' || $this->params->get('location_city', 1) == '2') {?>
			    <td class="djc_city">
	                <?php echo $item->city; ?>
	            </td>
	            <?php } ?>
	            <?php if ($this->params->get('location_address', 1) == '1' || $this->params->get('location_address', 1) == '2') {?>
	            <td class="djc_address">
	                <?php echo $item->address; ?>
	            </td>
	            <?php } ?>
	            <?php if ($this->params->get('location_postcode', 1) == '1' || $this->params->get('location_postcode', 1) == '2') {?>
	            <td class="djc_postcode">
	                <?php echo $item->postcode; ?>
	            </td>
	            <?php } ?>
	            <?php if ($this->params->get('location_phone', 1) == '1' || $this->params->get('location_phone', 1) == '2') {?>
	            <td class="djc_phone">
	                <?php echo $item->phone; ?>
	            </td>
	            <?php } ?>
	            <?php if ($this->params->get('location_mobile', 1) == '1' || $this->params->get('location_mobile', 1) == '2') {?>
	            <td class="djc_mobile">
	                <?php echo $item->mobile; ?>
	            </td>
	            <?php } ?>
	            <?php if ($this->params->get('location_fax', 1) == '1' || $this->params->get('location_fax', 1) == '2') {?>
	            <td class="djc_fax">
	                <?php echo $item->fax; ?>
	            </td>
	            <?php } ?>
	            <?php if ($this->params->get('location_website', 1) == '1' || $this->params->get('location_website', 1) == '2') {?>
	            <td class="djc_website">
	            <?php if (!empty($item->website)) { ?>
	            	<?php $item->website = (strpos($item->website, 'http') === 0) ? $item->website : 'http://'.$item->website; ?>
	            		<?php echo preg_replace('#([\w]+://)([^\s()<>]+)#iS', '<a target="_blank" href="$1$2">$2</a>', $item->website); ?>
					<?php } ?>
	            </td>
	            <?php } ?>
	            <?php if ($this->params->get('location_email', 1) == '1' || $this->params->get('location_email', 1) == '2') { ?>
	            <td class="djc_email">
	                <?php if (!empty($item->email)) { ?>
	                	<?php echo preg_replace('#([\w.-]+(\+[\w.-]+)*@[\w.-]+)#i', '<a target="_blank" href="mailto:$1">$1</a>', $item->email); ?>
	               	<?php } ?>
	            </td>
	            <?php } ?>
	    	<?php } ?>
		<?php } ?>
		<?php if ($this->params->get('items_show_attributes', '1') && !empty($this->column_attributes) && true) { ?>
			<?php foreach ($this->column_attributes as $column) { ?>
				<td class="djc_td_attribute_<?php echo $column->alias; ?>">
					<?php 
						$this->attribute_cursor = $column;
						
						echo $this->loadTemplate('column_attributes');
					?>
				</td>
			<?php } ?>
		<?php } ?>
		<?php if ($show_additional_data) { ?>
			<?php 
			if (count($this->attributes) > 0) { ?>
				<td class="djc_attributes">
				<?php
				$attributes_body = '';
				foreach ($this->attributes as $attribute) {
						$this->attribute_cursor = $attribute;
						$attributes_body .= $this->loadTemplate('items_attributes');
					}
				?>
				<?php if ($attributes_body != '') { ?>
					<div class="djc_attributes">
						<table class="table table-condensed">
						<?php echo $attributes_body; ?>
						</table>
					</div>
					<?php } ?>
				</td>
				<?php } ?>
		<?php } ?>
		<?php if ($this->params->get('items_show_cart_button', '1') == 1 && ($this->params->get('cart_enabled', false) || $this->params->get('cart_query_enabled', 1) )) { ?>
			<td class="djc_addtocart_cell">
			<?php if ((int)$item->available == 1) {
				echo $this->loadTemplate('addtocart');
			}?>
			</td>
		<?php } ?>
        </tr>
	<?php } ?>
	</tbody>
</table>
