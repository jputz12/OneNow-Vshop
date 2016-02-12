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
<div class="cart-wrap">
<?php if(!$this->userDetails->user_is_vendor){ ?>
<div class="buttonBar-right">
	<button class="button" type="submit" onclick="javascript:return myValidator(userForm, 'saveUser');" ><?php echo $this->button_lbl ?></button>
	&nbsp;
	<button class="button" type="reset" onclick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=user', FALSE); ?>'" ><?php echo JText::_('COM_VIRTUEMART_CANCEL'); ?></button>

</div>
<?php } ?>
<?php if( $this->userDetails->virtuemart_user_id!=0)  {
    echo $this->loadTemplate('vmshopper');
    } ?>
<?php echo $this->loadTemplate('address_userfields'); ?>



<?php if ($this->userDetails->JUser->get('id') ) {
  echo $this->loadTemplate('address_addshipto');
  }
  ?>
<?php if(!empty($this->virtuemart_userinfo_id)){
	echo '<input type="hidden" name="virtuemart_userinfo_id" value="'.(int)$this->virtuemart_userinfo_id.'" />';
}
?>
<input type="hidden" name="task" value="<?php echo $this->fTask; ?>" />
<input type="hidden" name="address_type" value="BT" />
</div>