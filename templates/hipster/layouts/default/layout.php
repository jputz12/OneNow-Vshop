<?php
/**
 * @version		1.0.2
 * @package		Hipster template for Joomla! 3.x
 * @author		JoomlaXTC http://www.joomlaxtc.com
 * @copyright	Copyright (C) 2014 Monev Software LLC. All rights reserved.
 * @license		http://opensource.org/licenses/GPL-2.0 GNU Public License, version 2.0
 */

defined( '_JEXEC' ) or die;

JHtml::_('behavior.framework');
$document =JFactory::getDocument();
$app = JFactory::getApplication();
$menu = $app->getMenu()->getActive();

$pageclass = is_object($menu) ? $menu->params->get('pageclass_sfx') : 'default';

$pageview = xtcIsFrontpage() ? '' : 'innerpage';
$user =JFactory::getUser();
$params = $templateParameters->group->$layout; // We got $layout from the index.php
// Use the Grid parameters to compute the main columns width
$grid = $params->xtcgrid;
$style = $params->xtcstyle;
$typo = $params->xtctypo;
$css3 = $params->xtccss3;

//Group parameters from grid.xml
$gridParams = $templateParameters->group->$grid;
$styleParams = $templateParameters->group->$style;
$typoParams = $templateParameters->group->$typo;
$tmplWidth = 100;

$stickyClass = $gridParams->stickyheader;
$hdwrapclass = $gridParams->hdwidth ? 'xtc-bodygutter' : '';
$hdclass = $gridParams->hdwidth ? 'xtc-wrapper' : '';
$hdpad = $gridParams->hdwidth ? 'xtc-wrapperpad' : '';

// Start of HEAD
JHtml::_('stylesheet', 'jui/bootstrap.min.css', array(), true);
if ($templateParameters->group->grid->responsive) { JHtml::_('stylesheet', 'jui/bootstrap-responsive.min.css', array(), true); }
JHtml::_('stylesheet', 'jui/bootstrap-extended.css', array(), true);
if ($typoParams->direction === 'rtl') { JHtml::_('stylesheet', 'jui/bootstrap-rtl.css', array(), true); }

JHtml::_('bootstrap.framework');
if ($templateParameters->jquery) { JHtml::_('jquery.framework',true); }?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php
// Include the CSS files using the groups as defined in the layout parameters
echo xtcCSS($params->xtctypo,$params->xtcgrid,$params->xtcstyle, $params->xtccss3);
// Get Xtc Menu library
$document->addScript($xtc->templateUrl.'js/xtcMenu.js'); 
$document->addScriptDeclaration("window.addEvent('load', function(){ xtcMenu(null, 'menu', 0, 50, 'h', new Fx.Transition(Fx.Transitions.Cubic.easeInOut), 0, true, false); });");
?>
  <link rel="stylesheet" href="media/jui/css/easy-responsive-tabs.css" type="text/css" />
  <link rel="stylesheet" href="media/jui/css/yamm.css" type="text/css" />
<jdoc:include type="head" />
<?php if (!$xtc->agent->isMobile && xtcIsFrontpage()) { ?>
<script src="<?php echo $xtc->templateUrl; ?>js/scrollReveal.js" type="text/javascript"></script>
<?php } ?>
<?php if ($stickyClass == 'sticky' && !$xtc->agent->isMobile) { ?>
<script>
  jQuery(window).scroll(function () {
      if (jQuery("#headerwrap").offset().top > 0) {
          jQuery("#headerwrap").addClass("stickyscroll")
      } else {
          jQuery("#headerwrap").removeClass("stickyscroll")
      }
  });
</script>
<?php } ?>

</head>
<?php
// End of HEAD
// Start of BODY
$extension = JFactory::getApplication()->input->get('option', '');
?>
<body class="<?php echo $pageview;?> <?php echo $stickyClass;?> <?php echo $pageclass; ?> <?php echo $extension; ?>">

	<div id="headerwrap" class="<?php echo $stickyClass;?>">
		<div id="header" class="<?php echo $hdclass; ?> clearfix">
			<div id="logo" class="hd2">
				<a class="hideTxt" href="index.php">
					<?php echo $app->getCfg('sitename');?>
				</a>
			</div>
			<?php if ($this->countModules('menuright2') || $this->countModules('menuright1')) : ?>
				<div id="menu2" class="hd2">
					<?php if ($this->countModules('menuright2')) : ?>
						<div id="menuright2">                           
							<jdoc:include type="modules" name="menuright2" style="xtc"/>
						</div>
					<?php endif; ?> 
					<?php if ($this->countModules('menuright1')) : ?>
						<div id="menuright1">                           
							<jdoc:include type="modules" name="menuright1" style="xtc"/>
						</div>
					<?php endif; ?> 
				</div>
			<?php endif; ?> 
			
		</div> 
		<div class="container">
			<div id="menuwrap" style="float:none;margin:0px;margin-left:100px;">
				<div id="menu" class="clearfix hd8 <?php echo $gridParams->menustyle;?>">
					<jdoc:include type="modules" name="menubarleft" style="raw" />
				</div>
			</div>
		</div>
	</div>
	<?php
		// Draw the regions in the specified order
		$regioncfg = $gridParams->regioncfg;
		foreach (explode(",",$regioncfg) as $region) {
			settype($region,'integer');
			$regionfile = __DIR__.'/layout_includes/region'.$region.'.php';
			if (file_exists($regionfile)) { require $regionfile; }
		}
		
		// Build footer grid
		$areaWidth = $tmplWidth;
		$gutter = 0;	
		$order = 'footer,legals';
		$columnArray = array();
		$columnArray['footer'] = '<jdoc:include type="modules" name="footer" style="xtc" />';
		$columnArray['legals'] = '<jdoc:include type="modules" name="legals" style="xtc" />';
		$customWidths = '';
		$columnClass = '';
		$columnPadding = '';
		$debug = '';
		$footer_legals = xtcBootstrapGrid($columnArray,$order,'',$columnClass);
		if ($footer_legals) {
			?>
				<div id="footerwrap" class="xtc-bodygutter">
					<div id="footerwrappad" class="xtc-wrapperpad">
						<div id="footerpad" class="row-fluid xtc-wrapper"><?php echo $footer_legals; ?></div>
					</div>
				</div>
			<?php
		}
	?>
    <?php if ($this->countModules('debug')) : ?>
	<jdoc:include type="modules" name="debug" />
    <?php endif; ?> 
  </body>
</html>
<?php if (!$xtc->agent->isMobile && xtcIsFrontpage()) { ?>
 <script>new scrollReveal</script>
 <?php }