<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

$centerWidth = $tmplWidth;;	
$areaWidth =  $centerWidth;
$order = 'bottom7,bottom8,bottom9,bottom10,bottom11,bottom12';
$columnArray = array(
	'bottom7' => '<jdoc:include type="modules" name="bottom7" style="xtc" />',
	'bottom8' => '<jdoc:include type="modules" name="bottom8" style="xtc" />',
	'bottom9' => '<jdoc:include type="modules" name="bottom9" style="xtc" />',
	'bottom10' => '<jdoc:include type="modules" name="bottom10" style="xtc" />',
	'bottom11' => '<jdoc:include type="modules" name="bottom11" style="xtc" />',
	'bottom12' => '<jdoc:include type="modules" name="bottom12" style="xtc" />'
);

$customWidths = '';
$customSpans = '';
$columnClass = '';
$columnPadding = '';
$debug = 0;
$bottom7_12 = xtcBootstrapGrid($columnArray,$order,$customSpans,$columnClass,$debug);

$r10wrapclass = $gridParams->r10width ? 'xtc-bodygutter' : '';
$r10class = $gridParams->r10width ? 'xtc-wrapper' : 'xtc-fluidwrapper';
$r10pad = $gridParams->r10width ? 'xtc-wrapperpad' : '';	

echo '<a id="region10anchor" class="moveit"></a>';
if ($bottom7_12) {
	echo '<div id="region10wrap" class="'.$r10wrapclass.'">';
	echo '<div id="region10pad" class="'.$r10pad.'">';
	echo '<div id="region10" class="row-fluid '.$r10class.'">';
	
	echo $bottom7_12;
	echo '</div>';
	echo '</div>';
	echo '</div>';
}