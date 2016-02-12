<?php
/**
 * @package		Easy QuickIcons
 * @author		Allan <allan@awynesoft.com>
 * @link		http://www.awynesoft.com
 * @copyright	Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license		GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version		$Id: default.php 24 2012-09-22 05:30:05Z allan $
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
// load tooltip behavior
JHtml::_('bootstrap.tooltip');
//JHtml::_('behavior.tooltip'); j2.5
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select'); //j3.0

$user		= JFactory::getUser();
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$canOrder	= $user->authorise('core.edit.state', 'com_easyquickicons.category');
$saveOrder	= $listOrder == 'a.ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_easyquickicons&task=easyquickicons.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'quickiconsList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();

?>
<script type="text/javascript">
	Joomla.orderTable = function() {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_easyquickicons'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_EASYQUICKICONS_SEARCH');?></label>
				<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" placeholder="<?php echo JText::_('COM_EASYQUICKICONS_SEARCH'); ?>" title="<?php echo JText::_('COM_EASYQUICKICONS_SEARCH_ITEMS'); ?>" />
			</div>
			<div class="btn-group pull-left">
				<button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
				<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
					<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
					<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
				</select>
			</div>
			<div class="btn-group pull-right">
				<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
				<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
					<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
				</select>
			</div>
		</div>
		<div class="clearfix"> </div>

		<table class="table table-striped" id="quickiconsList">
			<thead>
				<tr>
					<th width="1%" class="nowrap center hidden-phone">

						<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'COM_EASYQUICKICONS_HEAD_ORDERING'); ?>
						<?php //if ($canOrder && $saveOrder): ?>
							<?php //echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'easyquickicons.saveorder'); ?>
						<?php //endif;?>
					</th>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th width="1%" class="nowrap center">
						<?php echo JHTML::_( 'grid.sort', 'COM_EASYQUICKICONS_HEAD_STATUS', 'a.published', $listDirn, $listOrder); ?>
					</th>
					<th class="title">
						<?php echo JHTML::_( 'grid.sort', 'COM_EASYQUICKICONS_HEAD_NAME', 'a.name', $listDirn, $listOrder); ?>
					</th>
					<th>
						<?php echo JHTML::_( 'grid.sort', 'COM_EASYQUICKICONS_HEAD_LINK', 'a.link', $listDirn, $listOrder); ?>
					</th>

					<th class="nowrap">
						<?php echo JHTML::_( 'grid.sort', 'COM_EASYQUICKICONS_HEAD_USE_CUSTOM_ICON', 'a.custom_icon', $listDirn, $listOrder);?>
					</th>
					<th class="nowrap center">
						<?php echo JHTML::_( 'grid.sort', 'COM_EASYQUICKICONS_HEAD_ICON_IMAGE', 'a.icon', $listDirn, $listOrder);?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHTML::_( 'grid.sort', 'COM_EASYQUICKICONS_HEAD_ID', 'a.id', $listDirn, $listOrder); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="10"><?php echo $this->pagination->getListFooter(); ?></td>
				</tr>
			</tfoot>
			<tbody>
				<?php
				$default_link = JUri::root() . 'images/easyquickicons/';
				//echo $default_path;
				foreach($this->items as $i => $item):
				$ordering	= ($listOrder == 'a.ordering');
				$canEdit	= $user->authorise('core.edit',	'com_easyquickicons');
				$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
				$canChange	= $user->authorise('core.edit.state', 'com_easyquickicons');

				//check if custom icon is used
				if($item->custom_icon == 1){

					$chk_img = stripos(strtolower($item->icon_path), 'http');

					if($chk_img === false){ //custom upload image

						$img_link = JURI::root() . trim($item->icon_path);

					} else { // external image link

						$img_link = trim($item->icon_path);

					}

				} else {
					$img_link = $default_link . trim($item->icon);
				}
				?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="order nowrap center hidden-phone">
					<?php if ($canChange) :
						$disableClassName = '';
						$disabledLabel	  = '';
						if (!$saveOrder) :
							$disabledLabel    = JText::_('JORDERINGDISABLED');
							$disableClassName = 'inactive tip-top';
						endif; ?>
						<span class="sortable-handler hasTooltip <?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
							<i class="icon-menu"></i>
						</span>
						<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering;?>" class="width-20 text-area-order " />
					<?php else : ?>
						<span class="sortable-handler inactive" >
							<i class="icon-menu"></i>
						</span>
					<?php endif; ?>
					</td>
					<td class="center hidden-phone">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td class="center hidden-phone">
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'easyquickicons.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
						<?php //echo JHtml::_('easyquickicons.published', $item->published, $i); ?>
					</td>
					<td class="nowrap has-context">
						<div class="pull-left">
							<?php if ($item->checked_out) : ?>
								<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'easyquickicons.', $canCheckin); ?>
							<?php endif; ?>
							<?php if ($canEdit) : ?>
								<a href="<?php echo JRoute::_('index.php?option=com_easyquickicons&task=easyquickicon.edit&id='.$item->id);?>" title="<?php echo $this->escape($item->name); ?>">
									<?php echo $this->escape($item->name); ?></a>
							<?php else: echo $this->escape($item->name); ?>
							<?php endif;?>
							<span class="small"><?php echo JText::sprintf('COM_EASYQUICKICONS_CATEGORY_SMALL', $this->escape($item->category_title));?></span>
							<div class="small">
								<?php echo $this->escape($item->description);?>
							</div>
						</div>
					</td>
					<td class="hidden-phone">
						<?php
						$link = empty($item->link) ? 'index.php?option=' . trim($item->component) : $item->link;
						echo '<a href="'.JRoute::_($this->escape($link)).'" target="_blank">' . $this->escape($link) . '</a>';
						?>
					</td>

					<td class="center">
						<?php echo JHtml::_('easyquickicons.custom_icon', $item->custom_icon, $i, $canChange); ?>
					</td>
					<td class="center">
						<?php
							$displayIcon = $item->custom_icon == 1 ? 'display:none': 'display:inline';
							$displayImg  = $item->custom_icon == 1 ? 'display:inline': 'display:none';
						?>
						<a target="_blank" href="<?php echo JRoute::_($link);?>" title="<?php echo $item->name;?>">
						<i style="<?php echo $displayIcon;?>"><?php echo $item->icon; ?></i>
						<?php  echo JHtml::_('image',JURI::root() . $item->icon_path, '', array('style' => $displayImg, 'width' => '14px', 'height' => '14px'));?>
						</a>
					</td>
					<td class="center hidden-phone">
						<?php echo (int) $item->id; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<div>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
</form>

<?php echo $this->loadTemplate('copyright');?>
