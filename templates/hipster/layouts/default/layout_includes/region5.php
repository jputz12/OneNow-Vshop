<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

$centerWidth = $tmplWidth;
        $left5colgrid 	= $gridParams->left5width;
        $right5colgrid	= $gridParams->right5width;
        if ($this->countModules('left5') == 0){
         $left5colgrid  = "0";
        }

        if ($this->countModules('right5') == 0){
         $right5colgrid  = "0";
        }

        $left5 = $this->countModules( 'left5' );
	$right5 = $this->countModules( 'right5' );

        $areaWidth =  100;
	$order = 'user19,user20,user21,user22,user23,user24';
	$columnArray = array(
	        'user19' => '<jdoc:include type="modules" name="user19" style="xtc" />',
		'user20' => '<jdoc:include type="modules" name="user20" style="xtc" />',
		'user21' => '<jdoc:include type="modules" name="user21" style="xtc" />',
		'user22' => '<jdoc:include type="modules" name="user22" style="xtc" />',
		'user23' => '<jdoc:include type="modules" name="user23" style="xtc" />',
		'user24' => '<jdoc:include type="modules" name="user24" style="xtc" />'
	);

	$columnClass = '';
	$debug = 0;
	$user19_24 = xtcBootstrapGrid($columnArray,$order,'',$columnClass);
	
$r5wrapclass = $gridParams->r5width ? 'xtc-bodygutter' : '';
$r5class = $gridParams->r5width ? 'xtc-wrapper' : 'xtc-fluidwrapper';
$r5pad = $gridParams->r5width ? 'xtc-wrapperpad' : '';
echo '<a id="region5anchor" class="moveit"></a>';
	if ($left5 || $user19_24 || $right5) {
        echo '<div id="region5wrap" class="'.$r5wrapclass.'">';
        echo '<div id="region5pad" class="'.$r5pad.'">';
	echo '<div id="region5" class="row-fluid '.$r5class.'">';

        if ($left5) { echo '<div id="left5" class="span'.$left5colgrid.'"><jdoc:include type="modules" name="left5" style="xtc" /></div>';}
       if ($user19_24) {
echo '<div class="center span'.(12-$left5colgrid-$right5colgrid).'">';
     
        if ($user19_24) { echo '<div id="user19_24" class="clearfix r5spacer_top">'.$user19_24.'</div>'; }
	echo '</div>';
        }
	if ($right5) { echo '<div id="right5" class="span'.$right5colgrid.'"><jdoc:include type="modules" name="right5" style="xtc" /></div>';}
	echo '</div>';
        echo '</div>';
	echo '</div>';
	}