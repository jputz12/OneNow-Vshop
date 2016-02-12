<?php
/**
 * @package			Easy Quickicons
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012-2013 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 // No direct access
defined('_JEXEC') or die('Restricted access');

if($this->item->custom_icon == 1){
	$list_display = JUri::root() . $this->item->icon_path;
	$list_display_style = 'display:none';
} else {
 	$list_display = $this->item->icon;
 	$list_display_style = 'display:inline';
}
?>
<div class="j-links-groups">
	<ul class="j-links-group nav nav-list">
		<li>
			<a id="list_link" target="_blank" href="<?php echo $this->item->link; ?>" title="<?php echo isset($this->item->Title) ? JText::_($this->item->Title) : ''; ?>">
				<i id="list_icon_view" style="<?php echo $list_display_style;?>"><?php echo $this->item->icon; ?></i>
				<?php echo JHtml::_('image',$list_display, '', array('id' => "list_img_view", 'style' => 'display:inline;padding-right:6px', 'width' => '16px', 'height' => '16px')); ?>
				<span id="list_txt"><?php echo JText::_($this->item->name); ?></span>
			</a>
		</li>
	</ul>
</div>