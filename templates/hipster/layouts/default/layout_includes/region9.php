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

	$order = 'bottom1,bottom2,bottom3,bottom4,bottom5,bottom6';

	$columnArray = array(

		'bottom1' => '<jdoc:include type="modules" name="bottom1" style="xtc" />',

		'bottom2' => '<jdoc:include type="modules" name="bottom2" style="xtc" />',

		'bottom3' => '<jdoc:include type="modules" name="bottom3" style="xtc" />',

		'bottom4' => '<jdoc:include type="modules" name="bottom4" style="xtc" />',

		'bottom5' => '<jdoc:include type="modules" name="bottom5" style="xtc" />',

		'bottom6' => '<jdoc:include type="modules" name="bottom6" style="xtc" />'

	);



	$customWidths = '';

        $customSpans = '';

	$columnClass = '';

	$columnPadding = '';

	$debug = 0;

	$bottom1_6 = xtcBootstrapGrid($columnArray,$order,$customSpans,$columnClass,$debug);

	
$r9wrapclass = $gridParams->r9width ? 'xtc-bodygutter' : '';
$r9class = $gridParams->r9width ? 'xtc-wrapper' : 'xtc-fluidwrapper';
$r9pad = $gridParams->r9width ? 'xtc-wrapperpad' : '';	
echo '<a id="region9anchor" class="moveit"></a>';
	if ($bottom1_6) {

        echo '<div id="region9wrap" class="'.$r9wrapclass.'">';

        echo '<div id="region9pad" class="'.$r9pad.'">';

	echo '<div id="region9" class="row-fluid '.$r9class.'">';

        

	echo $bottom1_6;

        echo '</div>';

	echo '</div>';

        echo '</div>';

	}