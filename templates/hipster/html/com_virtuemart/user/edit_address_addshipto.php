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


<fieldset>
    <legend>
	<?php echo '<span class="userfields_info">' .JText::_('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL').'</span>'; ?>
    </legend>
    <?php echo $this->lists['shipTo']; ?>

</fieldset>