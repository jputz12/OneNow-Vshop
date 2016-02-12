<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
?>
<div class="j2store">
<form class="form-horizontal form-validate" id="adminForm" name="adminForm" method="post" action="index.php">
	<!-- <input type="hidden" name="option" value="com_j2store">
	<input type="hidden" name="view" value="customer">
	<input type="hidden" name="task" value="">
	<input type="hidden" id="email" name="email" value="<?php // echo $this->item->email; ?>" />
	-->
		<?php echo J2Html::hidden('option','com_j2store');?>
		<?php echo J2Html::hidden('view','customer');?>
		<?php echo J2Html::hidden('task','',array('id'=>'task'));?>
		<?php echo J2Html::hidden('email',$this->email);?>
		<?php echo JHtml::_('form.token'); ?>

	<div class="row-fluid">

		<div class="span6">
		<h4><?php echo JText::_('J2STORE_ADDRESS_LIST');?></h4>
		<?php
		if($this->addresses && !empty($this->addresses)):
			foreach($this->addresses as $item):
			$this->item = $item;
		?>
		<?php echo $this->loadTemplate('addresses');?>
		<?php endforeach;?>
		<?php endif;?>
		</div>
		<div class="span6">
			<?php echo $this->loadTemplate('orderhistory');?>
		</div>
	</div>
</form>
</div>