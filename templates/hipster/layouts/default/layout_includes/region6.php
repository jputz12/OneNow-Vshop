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
        $left6colgrid 	= $gridParams->left6width;
        $right6colgrid	= $gridParams->right6width;
        if ($this->countModules('left6') == 0){
         $left6colgrid  = "0";
        }

        if ($this->countModules('right6') == 0){
         $right6colgrid  = "0";
        }

        $left6 = $this->countModules( 'left6' );
	$right6 = $this->countModules( 'right6' );

       $areaWidth =  100;
	$order = 'user25,user26,user27,user28,user29,user30';
	$columnArray = array(
	        'user25' => '<jdoc:include type="modules" name="user25" style="xtc" />',
		'user26' => '<jdoc:include type="modules" name="user26" style="xtc" />',
		'user27' => '<jdoc:include type="modules" name="user27" style="xtc" />',
		'user28' => '<jdoc:include type="modules" name="user28" style="xtc" />',
		'user29' => '<jdoc:include type="modules" name="user29" style="xtc" />',
		'user30' => '<jdoc:include type="modules" name="user30" style="xtc" />'
	);

	$columnClass = '';
	$debug = 0;
	$user25_30 = xtcBootstrapGrid($columnArray,$order,'',$columnClass);
	
$r6wrapclass = $gridParams->r6width ? 'xtc-bodygutter' : '';
$r6class = $gridParams->r6width ? 'xtc-wrapper' : 'xtc-fluidwrapper';
$r6pad = $gridParams->r6width ? 'xtc-wrapperpad' : '';
echo '<a id="region6anchor" class="moveit"></a>';
	if ($left6 || $user25_30 || $right6) {
        echo '<div id="region6wrap" class="'.$r6wrapclass.'">';
        echo '<div id="region6pad" class="'.$r6pad.'">';
	echo '<div id="region6" class="row-fluid '.$r6class.'">';

       if ($left6) { echo '<div id="left6" class="span'.$left6colgrid.'"><jdoc:include type="modules" name="left6" style="xtc" /></div>';}
        
        if ($user25_30) {
	echo '<div class="center span'.(12-$left6colgrid-$right6colgrid).'">';

        if ($user25_30) { echo '<div id="user25_30" class="clearfix">'.$user25_30.'</div>'; }
	echo '</div>';
        }
	if ($right6) { echo '<div id="right6" class="span'.$right6colgrid.'"><jdoc:include type="modules" name="right6" style="xtc" /></div>';}

	echo '</div>';
        echo '</div>';
	echo '</div>';
	}