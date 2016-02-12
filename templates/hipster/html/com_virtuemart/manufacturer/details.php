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

	<h2><?php echo $this->manufacturer->mf_name; ?></h2>

	<div class="spacer">

	<?php // Manufacturer Image
	if (!empty($this->manufacturerImage)) { ?>
		<div>
		<?php echo $this->manufacturerImage; ?>
		</div>
	<?php } ?>
<br><br>
	<?php // Manufacturer Email
	if(!empty($this->manufacturer->mf_email)) { ?>
		<div>
		<?php // TO DO Make The Email Visible Within The Lightbox
		echo JHtml::_('email.cloak', $this->manufacturer->mf_email,true,JText::_('COM_VIRTUEMART_EMAIL'),false) ?>
		</div>
	<?php } ?>
<br><br>
	<?php // Manufacturer URL
	if(!empty($this->manufacturer->mf_url)) { ?>
		<div>
			<a target="_blank" href="<?php echo $this->manufacturer->mf_url ?>"><?php echo JText::_('COM_VIRTUEMART_MANUFACTURER_PAGE') ?></a>
		</div>
	<?php } ?>
<br><br>
	<?php // Manufacturer Description
	if(!empty($this->manufacturer->mf_desc)) { ?>
		<div>
			<?php echo $this->manufacturer->mf_desc ?>
		</div>
	<?php } ?>
<br><br>
	<?php // Manufacturer Product Link
	$manufacturerProductsURL = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturer_id=' . $this->manufacturer->virtuemart_manufacturer_id, FALSE);

	if(!empty($this->manufacturer->virtuemart_manufacturer_id)) { ?>
		<div>
			<a target="_top" class="btn" href="<?php echo $manufacturerProductsURL; ?>"><?php echo JText::sprintf('COM_VIRTUEMART_PRODUCT_FROM_MF',$this->manufacturer->mf_name); ?></a>
		</div>
	<?php } ?>
<br><br>
	<div class="clear"></div>

</div>
</div>