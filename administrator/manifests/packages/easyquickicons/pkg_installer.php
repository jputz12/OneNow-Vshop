<?php
/**
 * Installer File
 *
 * @subpackage		Easy QuickIcons
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class pkg_easyquickiconsInstallerScript
{
	private $_manifest = null;
	function install( $parent ) {

		$app = JFactory::getApplication();

		$app->setUserState('com_installer.message', '');
		$app->setUserState('com_installer.extension_message', '');

	}
	function update(){
		$app = JFactory::getApplication();

		$app->setUserState('com_installer.message', '');
		$app->setUserState('com_installer.extension_message', '');

	}
}