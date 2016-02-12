<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

//JHTML::stylesheet ( 'menucss.css', 'modules/mod_virtuemart_category/css/', false );

/* ID for jQuery dropdown */
$ID = str_replace('.', '_', substr(microtime(true), -8, 8));
$js="
//<![CDATA[
jQuery(document).ready(function() {
		jQuery('#VMmenu".$ID." li.VmClose ul').hide();
		jQuery('#VMmenu".$ID." li .VmArrowdown').click(
		function() {

			if (jQuery(this).parent().next('ul').is(':hidden')) {
				jQuery('#VMmenu".$ID." ul:visible').delay(500).slideUp(500,'linear').parents('li').addClass('VmClose').removeClass('VmOpen');
				jQuery(this).parent().next('ul').slideDown(500,'linear');
				jQuery(this).parents('li').addClass('VmOpen').removeClass('VmClose');
			}
		});
	});
//]]>
" ;

$document = JFactory::getDocument();
$document->addScriptDeclaration($js);

$mobile = '';
?>

<ul class="VMmenu<?php echo $class_sfx ?>" id="<?php echo "VMmenu".$ID ?>" >
<?php foreach ($categories as $category) {
		 $active_menu = 'class="VmClose"';
		$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
		$cattext = $category->category_name;
		//if ($active_category_id == $category->virtuemart_category_id) $active_menu = 'class="active"';
		if (in_array( $category->virtuemart_category_id, $parentCategories)) $active_menu = 'class="VmOpen"';

		?>

<li <?php echo $active_menu ?>>
	
		<?php
			$mobile .= '<option value="'.$caturl.'">'.$cattext.'</option>';
		echo JHTML::link($caturl, $cattext);
		if ($category->childs) {
			?>
			<span class="VmArrowdown"> </span>
			<?php
		}
		?>
	
<?php if ($category->childs) { ?>
<ul class="menu<?php echo $class_sfx; ?>">
<?php
		foreach ($category->childs as $child) {

		$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
		$cattext = $child->category_name;
		?>

<li>
<?php echo JHTML::link($caturl, $cattext); $mobile .= '<option value="'.$caturl.'">'.$cattext.'</option>'; ?>
</li>
<?php		} ?>
</ul>
<?php 	} ?>
</li>
<?php
	} ?>
</ul>
<?php
	// Do Mobile version
?>
<div class="vmcat_responsive">
<select size="1" class="menu xtcmobilemenu" onchange="if (this.value != '') { location.href=this.value; }">
<?php echo $mobile; ?>
</select>
</div>