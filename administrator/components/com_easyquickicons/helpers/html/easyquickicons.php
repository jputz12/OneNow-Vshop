<?php
/**
 * @package		Easy QuickIcons
 * @author		Allan <allan@awynesoft.com>
 * @link		http://www.awynesoft.com
 * @copyright	Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license		GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: easyquickicons.php 18 2012-09-05 06:05:38Z allan $
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Utility class for creating HTML Grids
 *
 * @static
 * @package		Joomla.Administrator
 * @subpackage	com_easyquickicons
 * @since		1.6
 */
class JHtmlEasyquickicons
{
	/**
	 * @param	int $value	The state value.
	 * @param	int $i
	 * @param	string		An optional prefix for the task.
	 * @param	boolean		An optional setting for access control on the action.
	 */

	public static function published($value = 0, $i, $canChange = true)
	{
		// Array of image, task, title, action
		$states	= array(
		1	=> array('tick.png',		'easyquickicons.unpublish',	'JENABLED',	'COM_EASYQUICKICONS_DISABLE_ITEM'),
		0	=> array('publish_x.png',	'easyquickicons.publish',		'JDISABLED',	'COM_EASYQUICKICONS_ENABLE_ITEM'),
		2	=> array('disabled.png',	'easyquickicons.unpublish',	'JARCHIVED',	'JUNARCHIVE'),
		-2	=> array('trash.png',		'easyquickicons.publish',		'JTRASHED',	'COM_EASYQUICKICONS_ENABLE_ITEM'),
		);
		$state	= JArrayHelper::getValue($states, (int) $value, $states[0]);
		$html	= JHtml::_('image', 'admin/'.$state[0], JText::_($state[2]), NULL, true);
		if ($canChange) {
			$html	= '<a href="#" onclick="return listItemTask(\'cb'.$i.'\',\''.$state[1].'\')" title="'.JText::_($state[3]).'">'
			. $html.'</a>';
		}

		return $html;
	}
	/**
	 * Returns a custom image state on a grid
	 *
	 * @param   integer       $value			The state value.
	 * @param   integer       $i				The row index
	 * @param   boolean       $enabled		An optional setting for access control on the action.
	 * @param   string        $checkbox		An optional prefix for checkboxes.
	 *
	 * @return  string        The Html code
	 *
	 * @see JHtmlJGrid::state
	 *
	 * @since   2.5.5
	 */
	public static function custom_icon($value, $i, $enabled = true, $checkbox = 'cb')
	{
		$states	= array(
		1	=> array(
				'custom_iconx',
				'COM_EASYQUICKICONS_ENABLED_ICON',
				'COM_EASYQUICKICONS_HTML_ENABLE_ICON',
				'COM_EASYQUICKICONS_USED_CUSTOM_IMAGE',
		false,
				'publish',
				'publish'
				),
				0	=> array(
				'custom_icon',
				'COM_EASYQUICKICONS_DISABLED_ICON',
				'COM_EASYQUICKICONS_HTML_DISNABLE_ICON',
				'COM_EASYQUICKICONS_UNUSED_CUSTOM_IMAGE',
				false,
				'unpublish',
				'unpublish'
				),
				);

				return JHtml::_('jgrid.state', $states, $value, $i, 'easyquickicons.', $enabled, true, $checkbox);
	}
	
}
