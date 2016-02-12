<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

if ($this->category->haschildren) {

// Category and Columns Counter
$iCol = 1;
$iCategory = 1;

// Calculating Categories Per Row
$categories_per_row = VmConfig::get ( 'categories_per_row', 3 );
$category_cellwidth = ' width'.floor ( 100 / $categories_per_row );

// Separator
$verticalseparator = " vertical-separator";
?>

<div class="category-view">

<?php // Start the Output
if ($this->category->children ) {
    foreach ( $this->category->children as $category ) {

	    // Show the horizontal seperator
	    if ($iCol == 1 && $iCategory > $categories_per_row) { ?>
	    <div class="horizontal-separator"></div>
	    <?php }

	    // this is an indicator wether a row needs to be opened or not
	    if ($iCol == 1) { ?>
	    <div class="row">
	    <?php }

	    // Show the vertical separator
	    if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
		    $show_vertical_separator = ' ';
	    } else {
		    $show_vertical_separator = $verticalseparator;
	    }

	    // Category Link
	    $caturl = JRoute::_ ( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id , FALSE);

		    // Show Category ?>
		   	<div class="category floatleft<?php echo $category_cellwidth . $show_vertical_separator ?>">
    	    <div class="spacer">
    			<div class="vmwallwrap">
  <a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>" class="catlink">
 
	    <?php
	    if (!empty($category->images)) {
		echo $category->images[0]->displayMediaThumb("", false);
	    }
	    ?>
       
<div class="vmzoom"> 
<div class="vmnewstext"> <div class="vmnewstext2">
<h3> <?php echo $category->category_name ?></a></h3>
 <a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>" class="shopbutton"><?php echo JText::_ ('COM_VM_SHOPNOW') ?></a> 
</div></div></div>
</div>
    		  
       
         

    	</div>    	</div>
	    <?php
	    $iCategory ++;

	    // Do we need to close the current row now?
	    if ($iCol == $categories_per_row) { ?>
	    <div class="clear"></div>
	    </div>
		    <?php
		    $iCol = 1;
	    } else {
		    $iCol ++;
	    }
    }
}
// Do we need a final closing row tag?
if ($iCol != 1) { ?>
	<div class="clear"></div>
	</div>
<?php
}
?>
</div>
<?php }