<?php
/**
 * Install script
 *
 * @package         Advanced Module Manager
 * @version         5.1.3
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2015 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/script.install.helper.php';

class PlgSystemAdvancedModulesInstallerScript extends PlgSystemAdvancedModulesInstallerScriptHelper
{
	public $name = 'ADVANCED_MODULE_MANAGER';
	public $alias = 'advancedmodulemanager';
	public $extname = 'advancedmodules';
	public $extension_type = 'plugin';

	public function uninstall($adapter)
	{
		$this->uninstallComponent($this->extname);
	}
}
