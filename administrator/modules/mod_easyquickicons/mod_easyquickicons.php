<?php
/**
 *
 * @subpackage		Easy QuickIcons
 *
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access.
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$document->addStyleSheet("components/com_easyquickicons/assets/css/icons.css");
$layout = $params->get('layout', '_:small');

require_once dirname(__FILE__).'/helper.php';

$buttons = modEasyQuickIconsHelper::getButtons($params, $layout);

require JModuleHelper::getLayoutPath('mod_easyquickicons', $params->get('layout', $layout));