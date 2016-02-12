<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

// Category and Columns Counter
$iColumn = 1;
$iManufacturer = 1;

// Calculating Categories Per Row
$manufacturerPerRow = 3;
if ($manufacturerPerRow != 1) {
	$manufacturerCellWidth = ' width'.floor ( 100 / $manufacturerPerRow );
} else {
	$manufacturerCellWidth = '';
}

// Separator
$verticalSeparator = " vertical-separator";
$horizontalSeparator = '<div class="horizontal-separator"></div>';

// Lets output the categories, if there are some
if (!empty($this->manufacturers)) { ?>

<div class="manufacturer-view-default vmformwrap" align="center">

	<h1 style="text-transform:uppercase;letter-spacing:0px;">
	<?php echo JText::_('COM_VIRTUEMART_SEARCH_SELECT_ALL_MANUFACTURER') ?>
	</h1>

	<?php // Start the Output
	foreach ( $this->manufacturers as $manufacturer ) {

		// Show the horizontal seperator
		if ($iColumn == 1 && $iManufacturer > $manufacturerPerRow) {
			echo $horizontalSeparator;
		}

		// this is an indicator wether a row needs to be opened or not
		if ($iColumn == 1) { ?>
		<div class="row">
		<?php }

		// Show the vertical seperator
		if ($iManufacturer == $manufacturerPerRow or $iManufacturer % $manufacturerPerRow == 0) {
			$showVerticalSeparator = ' ';
		} else {
			$showVerticalSeparator = $verticalSeparator;
		}

		// Manufacturer Elements
		$manufacturerURL = JRoute::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id, FALSE);
		$manufacturerIncludedProductsURL = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id, FALSE);
		$manufacturerImage = $manufacturer->images[0]->displayMediaThumb("",false);

		// Show Category ?>
		<div class="manufacturer floatleft<?php echo $manufacturerCellWidth . $showVerticalSeparator ?>">
			<div class="spacer">
				
				<a title="<?php echo $manufacturer->mf_name; ?>" href="<?php echo $manufacturerURL; ?>"><?php echo $manufacturerImage;?></a>
                <h4>
					<a title="<?php echo $manufacturer->mf_name; ?>" href="<?php echo $manufacturerURL; ?>"><?php echo $manufacturer->mf_name; ?></a>
				</h4>
			</div>
		</div>
		<?php
		$iManufacturer ++;

		// Do we need to close the current row now?
		if ($iColumn == $manufacturerPerRow) {
			echo '<div class="clear"></div></div>';
			$iColumn = 1;
		} else {
			$iColumn ++;
		}
	}

	// Do we need a final closing row tag?
	if ($iColumn != 1) { ?>
		<div class="clear"></div>
	</div>
	<?php } ?>

</div>
<?php
}