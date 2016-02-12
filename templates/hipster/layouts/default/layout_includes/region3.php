<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

$doc = JFactory::getDocument(); 
$page_title = html_entity_decode(trim(strtoupper($doc->getTitle())));

        
$centerWidth = $tmplWidth;
	$left = $this->countModules( 'left' );
	$sidebarleft = (JRequest::getCmd('option') == 'com_content' && JRequest::getCmd('view') == 'article') ||
								 (JRequest::getCmd('option') == 'com_k2' && JRequest::getCmd('view') == 'item')
									? $this->countModules( 'sidebarleft' )
									: 0;
									
	$right = $this->countModules( 'right' ); 
	$sidebarright = (JRequest::getCmd('option') == 'com_content' && JRequest::getCmd('view') == 'article') ||
									(JRequest::getCmd('option') == 'com_k2' && JRequest::getCmd('view') == 'item')
									? $this->countModules( 'sidebarright' )
									: 0;
	$newsflash = $this->countModules( 'newsflash' ); 
	$breadcrumb = $this->countModules('breadcrumb' );
	$messages = JFactory::getApplication()->getMessageQueue();
        
//        $sidebarleft = $this->countModules('sidebarleft') && (JRequest::getCmd('view','') == 'article');
//        $sidebarright = $this->countModules('sidebarright') && (JRequest::getCmd('view','') == 'article');
        
        if ($this->countModules( 'left' ) || $sidebarleft) {
            $leftcolgrid 	= $gridParams->leftwidth;
        } else {
         $leftcolgrid  = "0";
        }
        //if (($this->countModules('left') == 0) || ($this->countModules('sidebarleft') == 0 && JRequest::getVar( 'view' ) !== 'article')){
        // $leftcolgrid  = "0";
        //}
        if ($this->countModules( 'right' ) || $sidebarright) {
            $rightcolgrid 	= $gridParams->rightwidth;
        } else {
         $rightcolgrid  = "0";
        }
        //if ($this->countModules('right') == 0 || $this->countModules('sidebarright') == 0){
         //$rightcolgrid  = "0";
        //}

        $areaWidth =  100;
	$order = 'user7,user8,user9,user10,user11,user12';
	$columnArray = array(
		'user7' => '<jdoc:include type="modules" name="user7" style="xtc" />',
		'user8' => '<jdoc:include type="modules" name="user8" style="xtc" />',
		'user9' => '<jdoc:include type="modules" name="user9" style="xtc" />',
		'user10' => '<jdoc:include type="modules" name="user10" style="xtc" />',
		'user11' => '<jdoc:include type="modules" name="user11" style="xtc" />',
		'user12' => '<jdoc:include type="modules" name="user12" style="xtc" />'
	);
	$customWidths = '';
	$columnClass = '';
	$columnPadding = '';
	$debug = 0;
	$user6_12 = xtcBootstrapGrid($columnArray,$order,'',$columnClass);
	
	    $areaWidth =  100;
	$order = 'showcase1,showcase2,showcase3,showcase4,showcase5,showcase6';
	$columnArray = array(
		'showcase1' => '<jdoc:include type="modules" name="showcase1" style="xtc" />',
		'showcase2' => '<jdoc:include type="modules" name="showcase2" style="xtc" />',
		'showcase3' => '<jdoc:include type="modules" name="showcase3" style="xtc" />',
		'showcase4' => '<jdoc:include type="modules" name="showcase4" style="xtc" />',
		'showcase5' => '<jdoc:include type="modules" name="showcase5" style="xtc" />',
		'showcase6' => '<jdoc:include type="modules" name="showcase6" style="xtc" />'
	);
	$customWidths = '';
	$columnClass = '';
	$columnPadding = '';
	$debug = 0;
	$showcase1_6 = xtcBootstrapGrid($columnArray,$order,'',$columnClass);
	
$r3wrapclass = $gridParams->r3width ? 'xtc-bodygutter' : '';
$r3class = $gridParams->r3width ? 'xtc-wrapper' : 'xtc-fluidwrapper';
$r3pad = $gridParams->r3width ? 'xtc-wrapperpad' : '';
echo '<a id="region3anchor" class="moveit"></a>';

	if (($left || $sidebarleft || $newsflash || $breadcrumb || $user6_12 || $right || $sidebarright || $messages || $showcase1_6 || xtcCanShowComponent())) { ?>
        
        <div id="region3wrap" class="<?php echo $r3wrapclass; ?>">
        <div id="region3pad" class="<?php echo $r3pad; ?>">
	<div id="region3" class="row-fluid <?php echo $r3class; ?> animated anistyle">
        <?php if (($left || $sidebarleft) && $page_title!='HOME' && $page_title!='CART') { ?> <div id="left" class="span<?php echo $leftcolgrid;?>" style="border: 1px solid rgb(189, 185, 185); margin-top: 30px;">

        <div class="module title-on  lightbox mobilehide">
			<h3 class="moduletitle">
			    <span class="first_word">Refine By:</span>
			</h3>
	        <div class="modulecontent"> 
	         <ul class="menu xtcdefaultmenu">
	        	<li class="item-737 subcol0"><a href="<?php echo JRoute::_( $orderUrl.'&order=i.price&dir=asc#tlb'); ?>">Price Low to High</a></li>
	        	<li class="item-736 subcol1"><a href="<?php echo JRoute::_( $orderUrl.'&order=i.price&dir=desc#tlb'); ?>">Price High to Low</a></li>
	        </ul>
	        </div>
        </div>
        <div class="module title-on  lightbox mobilehide">
			<h3 class="moduletitle">
			    <span class="first_word">Shop:</span>
			</h3>
	       <?php if($sidebarleft ){ ?><jdoc:include type="modules" name="sidebarleft" style="xtc" /><?php } ?><jdoc:include type="modules" name="left" style="xtc" />
	       <?php    
	       $pos = strpos($_SERVER['REQUEST_URI'], 'index.php/');
	       $getAliases = substr($_SERVER['REQUEST_URI'], $pos+strlen('index.php/'));
	       $aliasesArr = explode('/', $getAliases);   
	       //print_r($aliasesArr);
	       //echo "test";
	       $db = JFactory::getDbo();
	       $query = $db->getQuery(true);
	       $db->setQuery("SELECT * FROM  #__djc2_categories WHERE alias = '".$aliasesArr[2]."'");
	       $thirdcat = $db->loadAssoc();   
	       // print_r($thirdcat); 
	       ?>       
        </div>

        </div><?php }?> 
        
        
                <?php if ($user6_12 || $newsflash || $breadcrumb || $messages || xtcCanShowComponent()) { ?>
       
       
	<div class="span<?php echo (12-$leftcolgrid-$rightcolgrid);?>">
        <?php if ($user6_12) { ?><div id="user6_10" class="clearfix r3spacer_top"><?php echo $user6_12;?></div><?php }?>
	<?php if ($newsflash) {?><div id="newsflash" class="r3spacer_top"><jdoc:include type="modules" name="newsflash" style="xtc" /></div><?php }?>
       <?php if ($breadcrumb) {?><div id="breadcrumbs" class="r3spacer_top"><jdoc:include type="modules" name="breadcrumb" style="xtc" /></div><?php }?>	
       <?php if ( $messages ) { ?><div id="message" class="r3spacer_top"><jdoc:include type="message" /></div><?php }?>
	<?php if ( xtcCanShowComponent() ) { ?><div id="component" class="r3spacer_top"><jdoc:include type="component" /></div><?php }?> <?php if ($showcase1_6) {?><div id="showcase1_6" class="clearfix r3spacer_top"><?php echo $showcase1_6;?></div><?php }?>
	</div>
<?php }
?>
	 <?php if ($right || $sidebarright) { ?><div id="right" class="span<?php echo $rightcolgrid;?>"><?php if( $sidebarright ){ ?><jdoc:include type="modules" name="sidebarright" style="xtc" /><?php } ?><jdoc:include type="modules" name="right" style="xtc" /></div><?php }?>
	</div>
        </div>
	</div>
	<?php }