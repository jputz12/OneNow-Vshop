<?php
/**
 * @package			Easy QuickIcons
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version			$Id: easyquickicons.php 51 2012-10-05 18:58:38Z allan $
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
//load css
$docs = JFactory::getDocument();
$docs->addStyleSheet(JURI::base() . '/components/com_easyquickicons/assets/css/style.css');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_easyquickicons')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// require helper file
JLoader::register('EasyquickiconsHelper', dirname(__FILE__) . '/helpers/easyquickicons.php');
// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by Easyquickicon
$controller = JControllerLegacy::getInstance('Easyquickicons');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();