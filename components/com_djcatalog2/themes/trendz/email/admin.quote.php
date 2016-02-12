<?php
/**
 * @version $Id: admin.quote.php 450 2015-06-09 18:07:53Z michal $
 * @package DJ-Catalog2
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Michal Olczyk - michal.olczyk@design-joomla.eu
 *
 * DJ-Catalog2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Catalog2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Catalog2. If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die('Restricted access');

$params = JComponentHelper::getParams('com_djcatalog2');

$user = JFactory::getUser();
$show_prices = false; //(bool)((int)$params->get('cart_show_prices', 0) == 1);

JModelLegacy::addIncludePath(JPATH_BASE.DS.'components'.DS.'com_djcatalog2'.DS.'models', 'DJCatalog2Model');
$model = JModelLegacy::getInstance('Items', 'Djcatalog2Model', array('ignore_request'=>true));
$state		= $model->getState();
$model->setState('list.start', 0);
$model->setState('list.limit', 0);
$model->setState('filter.catalogue',false);
$model->setState('list.ordering', 'i.name');
$model->setState('list.direction', 'asc');
$model->setState('filter.parent', '*');
$model->setState('filter.state', '3');
$item_ids = array();
foreach ($data['items'] as $item) {
	$item_ids[] = $item['item_id'];
}
$model->setState('filter.item_ids', $item_ids);
$order_items = $model->getItems();


?>

<div style="width: 800px; margin: 0 auto">

<p>
<?php echo JText::_('COM_DJCATALOG2_EMAIL_QUOTE_ADMIN_HEADER'); ?>
</p>
<br />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="50%"><?php echo JText::_('COM_DJCATALOG2_DATE'); ?>
		</td>
		<td><?php echo JHtml::_('date', $data['created_date'], 'd-m-Y'); ?>
		</td>
	</tr>
	<tr>
		<td><?php echo JText::_('COM_DJCATALOG2_USER_PROFILE'); ?>
		</td>
		<td><?php 
		if ($data['company']) { ?><strong><?php echo $data['company']?>
		</strong><br /><?php } ?>
		<strong><?php echo $data['firstname'].' '.$data['lastname']; ?></strong><br />
		<a href="mailto:<?php echo $data['email']; ?>"><?php echo $data['email']; ?></a><br />
		<?php echo @$data['postcode'].' '.@$data['city']; ?><br /><?php echo @$data['address']; ?>
		<?php if (!empty($data['phone'])) { echo JText::_('COM_DJCATALOG2_UP_PHONE').': '.$data['phone'].'<br />'; } ?>
		<?php if (!empty($data['fax'])) { echo JText::_('COM_DJCATALOG2_UP_FAX').': '.$data['fax'].'<br />'; } ?>
		</td>
	</tr>
	<?php if ($data['customer_note']) {?>
		<tr>
			<td colspan="2"><?php echo JText::_('COM_DJCATALOG2_MESSAGE'); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2"><?php echo nl2br($data['customer_note']); ?>
			</td>
		</tr>
	<?php } ?>
</table>

<br /><br />

<table width="100%" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th width="30%"><?php echo JText::_('COM_DJCATALOG2_CART_NAME'); ?>
			</th>
			<th align="center"><?php echo JText::_('COM_DJCATALOG2_QUANTITY'); ?>
			</th>
			<?php if ($show_prices) {?>
			<th align="center"><?php echo JText::_('COM_DJCATALOG2_PRICE'); ?>
			</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php
		$total = 0;
		foreach($data['items'] as $item){
			$price = $item['quantity'] * $order_items[$item['item_id']]->final_price;
			$total += $price;
		?>
		<tr>
			<td><?php 
			echo '('.$item['item_id'].') '.$item['item_name'];
			?>
			</td>
			<td align="center"><?php echo (int)$item['quantity']; ?>
			</td>
			<?php if ($show_prices) {?>
			<td align="center"><?php echo $price; ?></td>
			<?php } ?>
		</tr>
		<?php } ?>
		<?php if ($show_prices) {?>
		<tr>
			<td colspan="2" align="right"><?php echo JText::_('COM_DJCATALOG2_TOTAL_VALUE'); ?></td>
			<td align="center"><?php echo $total; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<br />
<p>
<?php echo JText::_('COM_DJCATALOG2_EMAIL_QUOTE_ADMIN_FOOTER'); ?>
<a href="<?php echo JURI::base().'administrator/index.php?option=com_djcatalog2&amp;view=queries&amp;filter_search='.urlencode('id:'.$data['id']); ?>">
<?php echo JText::_('COM_DJCATALOG2_EMAIL_QUOTE_ADMIN_LINK');?></a>
</p>
</div>