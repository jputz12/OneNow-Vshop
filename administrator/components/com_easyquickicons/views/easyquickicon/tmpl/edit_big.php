<?php
/**
 * @subpackage		Easy Quickicons
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012-2013 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 defined('_JEXEC') or die('Restricted access');

 if($this->item->custom_icon == 1){
	$icon_display = JUri::root() . $this->item->icon_path;
	$icon_display_style = 'display:none';
	$img_display_style = 'display:block';
 } else {
 	$icon_display = $this->item->icon;
 	$icon_display_style = 'display:block';
 	$img_display_style = 'display:none';
}

 ?>
<div class="box">
	<a id="grid_link" target="_blank" href="<?php echo JRoute::_($this->item->link);?>" title="<?php echo $this->item->name;?>">
		<i id="grid_icon_view" class="big" style="<?php echo $icon_display_style; ?>"><?php echo $this->item->icon;?></i>
		<?php echo JHtml::_('image',$icon_display, '', array('id' => "grid_img_view", 'style' => $img_display_style)); ?>
		<span id="grid_txt"><?php echo JText::_($this->item->name); ?></span>
	</a>
</div>