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
<div class="vmformwrap">
<div class="vendor-details-view">
	<h1><?php echo $this->vendor->vendor_store_name;
	if (!empty($this->vendor->images[0])) { ?>
		<div class="vendor-image">
		<?php echo $this->vendor->images[0]->displayMediaThumb('',false); ?>
		</div>
	<?php
	}
?>	</h1></div>

<div class="vendor-description">
<?php echo $this->vendor->vendor_store_desc.'<br><br>';
	if(!class_exists('ShopFunctions')) require(JPATH_VM_ADMINISTRATOR.'/helpers/shopfunctions.php');
	echo shopFunctions::renderVendorAddress($this->vendor->virtuemart_vendor_id);

	?></div>
<br><br>
<?php	echo $this->vendor->vendor_legal_info; ?>

	<br class="clear" />
	<?php echo $this->linktos ?>

	<br class="clear" />

	<?php echo $this->linkcontact ?>

	<br class="clear" />
</div>