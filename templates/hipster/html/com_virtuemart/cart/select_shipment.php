<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

if (VmConfig::get('oncheckout_show_steps', 1)) {
		echo '<div class="checkoutStep" id="checkoutStep2">' . JText::_('COM_VIRTUEMART_USER_FORM_CART_STEP2') . '</div>';
	}

	if ($this->layoutName!='default') {
		$headerLevel = 1;
		if($this->cart->getInCheckOut()){
			$buttonclass = 'button vm-button-correct';
		} else {
			$buttonclass = 'default';
		}
		?>
<form method="post" id="userForm" name="chooseShipmentRate" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate">
	<?php
	} else {
		$headerLevel = 3;
		$buttonclass = 'vm-button-correct';
	}

	echo "<h".$headerLevel.">".JText::_('COM_VIRTUEMART_CART_SELECT_SHIPMENT')."</h".$headerLevel.">";

	?>

	<div class="buttonBar-right">

	        <button  name="setshipment" class="<?php echo $buttonclass ?>" type="submit" ><?php echo JText::_('COM_VIRTUEMART_SAVE'); ?></button>  &nbsp;
		<?php   if ($this->layoutName!='default') { ?>
		<button class="<?php echo $buttonclass ?>" type="reset" onClick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart'); ?>'" ><?php echo JText::_('COM_VIRTUEMART_CANCEL'); ?></button>
		<?php  } ?>
	</div>

<?php
    if ($this->found_shipment_method  ) {

	   echo "<fieldset>\n";
	// if only one Shipment , should be checked by default
	    foreach ($this->shipments_shipment_rates as $shipment_shipment_rates) {
			if (is_array($shipment_shipment_rates)) {
			    foreach ($shipment_shipment_rates as $shipment_shipment_rate) {
					echo $shipment_shipment_rate."<br />\n";
			    }
			}
	    }
	    echo "</fieldset>\n";
    } else {
	 echo "<h".$headerLevel.">".$this->shipment_not_found_text."</h".$headerLevel.">";
    }


if ($this->layoutName!='default') {
?> <input type="hidden" name="option" value="com_virtuemart" />
    <input type="hidden" name="view" value="cart" />
    <input type="hidden" name="task" value="setshipment" />
    <input type="hidden" name="controller" value="cart" />
</form>
<?php
}