<?php
/**
 * @subpackage			Easy QuickIcons
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version			$Id: helper.php 141 2012-11-28 05:17:26Z allan $
 */

// No direct access.
defined('_JEXEC') or die;

JLoader::register('EasyquickiconsHelper', '../administrator/components/com_easyquickicons/helpers/easyquickicons.php');

abstract class modEasyQuickIconsHelper
{
	/**
	 * Stack to hold buttons
	 *
	 * @since	1.6
	 */
	protected static $buttons = array();

	protected static $plugins = array();

	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @param	JRegistry	The module parameters.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function &getButtons($params, $layout)
	{

		self::$buttons = array();

		$context = $params->get('context', 'mod_easyquickicons');
		if ($context == 'mod_easyquickicons'){
			// Load mod_easyquickicons language file in case this method is called before rendering the module
			JFactory::getLanguage()->load('mod_easyquickicons');

			$app = JFactory::getApplication();
			$template = JFactory::getApplication()->getTemplate();

			//load the icons from the db
			$items = EasyquickiconsHelper::eqiItems();

			$quickicons = array();

			foreach($items as $i => $item){

				//if($item->module_group == 0 || $item->module_group == 2){

					// check layout and task links
					//$link = EasyquickiconsHelper::eqiCheckLink($item->link);
					$link = $item->link;
					$getAccess = EasyquickiconsHelper::eqiComponentName($item->id);
					$quickicons[$i]['category'] = $item->category;
					$quickicons[$i]['custom_icon'] = $item->custom_icon;

					if( $item->name == 'Edit Profile' AND $item->category == EasyQuickIconsHelper::standardCategory()){
						$quickicons[$i]['link'] = JRoute::_('index.php?option=com_admin&task=profile.edit&id='.JFactory::getUser()->id);
						$quickicons[$i]['access'] = true;
					} else {

						$quickicons[$i]['link'] = empty($item->link) ? JRoute::_('index.php?option=' . trim($item->component)) : $link;

						if(!is_numeric($getAccess)){

							$quickicons[$i]['access'] = array('core.manage', $getAccess);
						}
					}
					$quickicons[$i]['image'] = EasyquickiconsHelper::eqiImage($item->id, 1);
					$quickicons[$i]['text'] = JText::_($item->name);



					$quickicons[$i]['target'] = JText::_(trim($item->target));
					//$quickicons[$i]['group'] = JText::_($item->group);

					self::$buttons[$i] = $quickicons[$i];
				//}
			}
		} else {
			self::$buttons = array();
		}

		return self::$buttons;
	}
	public static function plugins(){

		JPluginHelper::importPlugin('quickicon');
		$app = JFactory::getApplication();
		$pluginIcons = array();

		//set context to "mod_quickicon" to render plugin icons

		$pluginArray = (array) $app->triggerEvent('onGetIcons', array('mod_quickicon'));

		if (!empty($pluginArray)) {

			foreach ($pluginArray as $plugin) {

				foreach ($plugin as $icon) {

					$pluginIcon['id'] = $icon['id'];
					$pluginIcon['link'] = $icon['link'];
					$pluginIcon['image'] = $icon['image'];
					$pluginIcon['text'] = $icon['text'];
					$pluginIcon['category'] = EasyQuickIconsHelper::standardCategory();
					$pluginIcon['target'] = '_self';
					$pluginIcon['custom_icon'] = (int)0;
					//$pluginIcon['group'] = 'MOD_EASYQUICKICONS_EXTENSIONS';

					$pluginIcons[] = $pluginIcon;

				}

			}
			self::$plugins = $pluginIcons;

		} else {

			self::$plugins = array();

		}
		return self::$plugins;
	}
	/**
	 * Get the alternate title for the module
	 *
	 * @param	JRegistry	The module parameters.
	 * @param	object		The module.
	 *
	 * @return	string	The alternate title for the module.
	 */
	public static function getTitle($params, $module)
	{
		$key = $params->get('context', 'mod_easyquickicons') . '_title';
		if (JFactory::getLanguage()->hasKey($key))
		{
			return JText::_($key);
		}
		else
		{
			return $module->title;
		}
	}
		/**
	 * Classifies the $buttons by group
	 *
	 * @param   array  $buttons  The buttons
	 *
	 * @return  array  The buttons sorted by groups
	 *
	 * @since   3.2
	 */
	 /*
	public static function groupButtons($buttons)
	{
		$groupedButtons = array();

		foreach ($buttons as $button)
		{
			$groupedButtons[$button['group']][] = $button;
		}
		return $groupedButtons;
	}
	*/
}