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
	<h1><?php echo JText::_('COM_VIRTUEMART_VENDOR_TOS').$this->vendor->vendor_store_name;
	if (!empty($this->vendor->images[0])) { ?>
		<div class="vendor-image">
		<?php echo $this->vendor->images[0]->displayMediaThumb('',false); ?>
		</div>
	<?php
	}
?>	</h1></div>


	<?php // vendor Description
	if(!empty($this->vendor->vendor_terms_of_service  )) { ?>
		<div class="vendor-description">
			<?php echo $this->vendor->vendor_terms_of_service   ?>
		</div>
	<?php } ?>

	<div class="clear"></div>


	<br class="clear" />
	<?php echo $this->linkdetails ?>

	<br class="clear" />

	<?php echo $this->linkcontact ?>

	<br class="clear" />
    </div>