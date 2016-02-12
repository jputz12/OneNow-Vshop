<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined ( '_JEXEC' ) or die ();
	$orderinfo = $this->orderinfo;
	JHTML::_('behavior.modal', 'a.modal');
?>
<div class="panel panel-default billing-address">
	<div class="panel-heading">
		<h4><?php echo JText::_('J2STORE_CUSTOMER_INFORMATION');?></h4>
	</div>
<div class="panel-body">
	<div class="row-fluid">
	<div class="span5">	
			<h4><?php echo JText::_('J2STORE_BILLING_ADDRESS');?> <?php echo J2StorePopup::popupAdvanced("index.php?option=com_j2store&view=orders&task=setOrderinfo&order_id=".$this->item->order_id."&address_type=billing&layout=address&tmpl=component",'<i class="icon-pencil-2"></i>',array('update'=>true,'width'=>700,'height'=>600));?></h4>
			
			
			<?php echo '<strong>'.$this->orderinfo->billing_first_name." ".$this->orderinfo->billing_last_name."</strong><br/>"; ?>
					<?php echo $this->orderinfo->billing_address_1;?>
					<br/>
					<?php echo $this->orderinfo->billing_address_2 ? $this->orderinfo->billing_address_2 : "<br/>";?>
					<?php echo $this->orderinfo->billing_city;?><br />
					<?php echo $this->orderinfo->billing_zone_name ? $this->orderinfo->billing_zone_name.'<br />' : "";?>
					<?php echo !empty($this->orderinfo->billing_zip) ? $this->orderinfo->billing_zip.'<br />': '';?>
					<?php echo $this->orderinfo->billing_country_name." <br/> ".JText::_('J2STORE_TELEPHONE').":";?>
					<?php echo $this->orderinfo->billing_phone_1;
										echo $this->orderinfo->billing_phone_2 ? '<br/> '.$this->orderinfo->billing_phone_2 : "<br/> ";
										echo '<br/> ';
										echo '<a href="mailto:'.$this->item->user_email.'">'.$this->item->user_email.'</a>';
										echo '<br/> ';
										echo $this->orderinfo->billing_company ? JText::_('J2STORE_ADDRESS_COMPANY_NAME').':&nbsp;'.$this->orderinfo->billing_company."</br>" : "";
										echo $this->orderinfo->billing_tax_number ? JText::_('J2STORE_ADDRESS_TAX_NUMBER').':&nbsp;'.$this->orderinfo->billing_tax_number."</br>" : "";
									?>
					<?php echo J2Store::getSelectableBase()->getFormatedCustomFields($this->orderinfo, 'customfields', 'billing'); ?>						
									
	</div>
	<div class="span5">	
		<div class="shipping-address">				
				<h4><?php echo JText::_('J2STORE_SHIPPING_ADDRESS');?>  <?php echo J2StorePopup::popupAdvanced("index.php?option=com_j2store&view=orders&task=setOrderinfo&order_id=".$this->item->order_id."&address_type=shipping&layout=address&tmpl=component",'<i class="icon-pencil-2"></i>',array('update'=>true,'width'=>800 , 'height'=>600));?></h4>
				
				<?php
					echo '<strong>'.$this->orderinfo->shipping_first_name." ".$this->orderinfo->shipping_last_name."</strong><br/>";
					echo $this->orderinfo->shipping_address_1;
					?>
					<?php
					echo $this->orderinfo->shipping_address_2 ? "<br/>".$this->orderinfo->shipping_address_2: "<br/>";
					echo $this->orderinfo->shipping_city.'<br/>';
					echo $this->orderinfo->shipping_zone_name ? $this->orderinfo->shipping_zone_name.'<br/>' : "";
					echo $this->orderinfo->shipping_zip."<br/>";
					echo $this->orderinfo->shipping_country_name."<br/>";
					echo JText::_('J2STORE_TELEPHONE') .': '; 
					echo $this->orderinfo->shipping_phone_1;
					echo $this->orderinfo->shipping_phone_2 ? "<br/>".$this->orderinfo->shipping_phone_2 : "<br/> ";
					echo '<br/> ';
					echo $this->orderinfo->shipping_company ? JText::_('J2STORE_ADDRESS_COMPANY_NAME').':&nbsp;'.$this->orderinfo->shipping_company."</br>" : "";
					echo $this->orderinfo->shipping_tax_number ? JText::_('J2STORE_ADDRESS_TAX_NUMBER').':&nbsp;'.$this->orderinfo->shipping_tax_number."</br>" : "";
				?>
				<?php echo J2Store::getSelectableBase()->getFormatedCustomFields($this->orderinfo, 'customfields', 'shipping'); ?>
		</div>
	</div>
	</div>
</div>
</div>	
	