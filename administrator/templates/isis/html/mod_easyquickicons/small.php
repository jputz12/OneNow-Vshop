<?php
/**
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version			$Id: default.php 142 2012-11-28 05:18:16Z allan $
 */
// No direct access.
defined('_JEXEC') or die;

$plugins = modEasyQuickIconsHelper::plugins();

//$html = JHtml::_('icons.buttons', $buttons);
//$html = JHtml::_('links.linksgroups', modEasyQuickIconsHelper::groupButtons($buttons)); ?>
<div class="sidebar-nav quick-icons">
<?php
$categories = EasyquickiconsHelper::eqiCategory();
$categoryCnt = count($categories);

?>

<?php
if($categoryCnt >= 1){

	echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => $categories[0]->alias));

	for($i = 0; $i < $categoryCnt; $i++){
		if(JFactory::getUser()->authorise('core.view', 'com_easyquickicons.category.'.$categories[$i]->id)) {
			echo JHtml::_('bootstrap.addTab', 'myTab', $categories[$i]->alias, JText::_($categories[$i]->category, true));

			$category[$i] = array();
			$category2[$i] = array();

			foreach($buttons as $pos => $button):
				if($button['category'] == $categories[$i]->category):
					$category[$i][] = $button;
				endif;
			endforeach;

			foreach($plugins as $a => $plugin):
				if($plugin['category'] == $categories[$i]->category):
					$category2[$i][] = $plugin;
				endif;
			endforeach;

			$allIcons = array_merge($category[$i], $category2[$i]);

			foreach($allIcons as $icon_array => $icon):

				$id      	 = empty($icon['id']) ? '' : (' id="' . $icon['id'] . '"');
				$target		 = empty($icon['target']) ? '' : (' target="' . $icon['target'] . '"');
				$onclick	 = empty($icon['onclick']) ? '' : (' onclick="' . $icon['onclick'] . '"');
				$title  	 = empty($icon['title']) ? '' : (' title="' . $this->escape($icon['title']) . '"');
				$text    	 = empty($icon['text']) ? '' : ('<span>' . $icon['text'] . '</span>');
				$displayIcon = $icon['custom_icon'] == 1 ? 'display:none;': 'display:inline;';
				$displayImg  = $icon['custom_icon'] == 1 ? 'display:inline;': 'display:none;';
				?>
				<div class="j-links-groups">
					<ul class="j-links-group nav nav-list">
						<li<?php echo $id; ?>>
							<a href="<?php echo $icon['link'];?>"<?php echo $target . $onclick . $title; ?>>
								<i class="icon-<?php echo $icon['image'];?>" style="<?php echo $displayIcon;?>"></i>
								<?php echo JHtml::_('image',$icon['image'], '', array('style' => $displayImg . 'padding-right:6px', 'width' => '16px', 'height' => '16px')); ?>
								<?php echo $text; ?>
							</a>
						</li>
					</ul>
				</div>
			<?php

			endforeach;

			echo JHtml::_('bootstrap.endTab');
		}
	}

	echo JHtml::_('bootstrap.endTabSet');

} else {

	echo JText::_('MOD_EASYQUICKICONS_NO_CATEGORY');

} ?>
</div>