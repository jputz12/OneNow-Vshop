<?php
/**
 * @package			Easy QuickIcons
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version			$Id: edit.php 98 2012-09-03 05:41:04Z allan $
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'easyquickicon.cancel' || document.formvalidator.isValid(document.id('easyquickicon-form'))) {
			Joomla.submitform(task, document.getElementById('easyquickicon-form'));
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_easyquickicons&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="easyquickicon-form" class="form-validate form-horizontal">

	<div class="row-fluid">
		<!-- Begin quickicon edit -->
		<div class="span8 form-horizontal">

	<fieldset>
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_EASYQUICKICONS_NEW_ICON') : JText::sprintf('COM_EASYQUICKICONS_EDIT_ICON', $this->item->id, true)); ?>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('published'); ?></div>
			</div>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('custom_icon'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('custom_icon'); ?></div>
			</div>
			<div class="control-group" id="icon_div" style="<?php if($this->item->custom_icon == 0){echo 'display:block;';}else{echo 'display:none';}?>">
				<div class="control-label"><?php echo $this->form->getLabel('icon'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('icon'); ?></div>
			</div>
			<div class="control-group" id="icon_path_div" style="<?php if($this->item->custom_icon == 1){echo 'display:block;';}else{echo 'display:none';}?>">
				<div class="control-label"><?php echo $this->form->getLabel('icon_path'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('icon_path'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('component'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('component'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('link'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('link'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('target'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('target'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
			</div>
			<?php //echo JHtml::_('bootstrap.endTab'); ?>
			<?php //echo JHtml::_('bootstrap.addTab', 'myTab', 'display', JText::_('COM_EASYQUICKICONS_EASYQUICKICON_DISPLAY_OPTIONS', true)); ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('COM_EASYQUICKICONS_PUBLISHING_OPTIONS', true)); ?>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by_alias'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by_alias'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_date'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_date'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('modified_date'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('modified_date'); ?></div>
			</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('COM_EASYQUICKICONS_FIELDSET_RULES', true)); ?>
			<div class="control-group">
				<fieldset>
					<?php echo $this->form->getInput('rules'); ?>
				</fieldset>
			</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	</fieldset>
	<input type="hidden" name="task" value="easyquickicon.edit" />
	<?php echo JHtml::_('form.token'); ?>
		</div>
		<!-- End quickicon -->
		<div class="span2">
			<div>
				<h4><?php echo JText::_('COM_EASYQUICKICONS_ICON_PREVIEW_BIG');?></h4>
				<hr />
				<?php echo $this->loadTemplate('big'); ?>
			</div>
			<div style="clear:both">
				<h4><?php echo JText::_('COM_EASYQUICKICONS_ICON_PREVIEW_SMALL');?></h4>
				<hr />
				<div class="sidebar-nav quick-icons">
				<?php echo $this->loadTemplate('small'); ?>
				</div>
			</div>
		</div>
	</div>
</form>