<?php
/**
 * @package			Easy QuickIcons
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version			$Id: easyquickicons.php 24 2012-09-22 05:30:05Z allan $
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Easyquickicons component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_easyquickicons
 * @since		1.6
 */
class EasyquickiconsHelper
{
	public static $extension = 'com_easyquickicons';

	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 */
	public static function addSubmenu($submenu)
	{
		$layout = JRequest::getCmd('layout', 'default');
		if($layout != 'welcome'){
			JHtmlSidebar::addEntry(
				JText::_('COM_EASYQUICKICONS'),
				'index.php?option=com_easyquickicons',
				$submenu == 'easyquickicons'
			);

			JHtmlSidebar::addEntry(
				JText::_('COM_EASYQUICKICONS_SUBMENU_CATEGORY'),
				'index.php?option=com_categories&view=categories&extension=com_easyquickicons',
				$submenu == 'categories'
			);
		}
		$document = JFactory::getDocument();

		if ($submenu == 'categories')
		{
			JToolbarHelper::title(
				JText::sprintf('COM_EASYQUICKICONS_ADMINISTRATION_CATEGORIES', JText::_('com_easyquickicons')),
				'easyquickicons-categories');
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 */
	public static function getActions($messageId = 0)
	{
		jimport('joomla.access.access');
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($messageId)) {
			$assetName = 'com_easyquickicons';
		} else {
			$assetName = 'com_easyquickicons.icons.'.(int) $messageId;
		}

		$actions = JAccess::getActions('com_easyquickicons', 'component');

		foreach ($actions as $action) {
			$result->set($action->name, $user->authorise($action->name, $assetName));
		}

		return $result;

	}

	/**
	 * Returns an array of standard published state filter options.
	 *
	 * @return	string			The HTML code for the select tag
	 */
	public static function publishedOptions()
	{
		// Build the active state filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option', '*', 'JALL');
		$options[]	= JHtml::_('select.option', '1', 'JPUBLISHED');
		$options[]	= JHtml::_('select.option', '0', 'JUNPUBLISHED');
		$options[]	= JHtml::_('select.option', '2', 'JARCHIVED');
		$options[]	= JHtml::_('select.option', '-2', 'JTRASHED');

		return $options;
	}

	/**
	 * Fix task and layout link
	 * @param the link to check
	 * @return the fixed link
	 */
	public static function eqiCheckLink($uri = '')
	{
		$link = JFactory::getURI($uri) ;
		if($link->getVar('layout') == 'edit'){
			$link->setVar('task', "{$link->getVar('view')}.{$link->getVar('layout')}") ;
			$link->delVar('view');
			$link->delVar('layout');
		}

		return JRoute::_($link->toString());
	}
	/**
	 * Returns an array quickicons items.
	 *
	 * @return	array of items from easyquickicons db
	 */
	public static function eqiItems()
	{

		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		// Select some fields
		$query->select('e.*');
		// From the easyquickicons table
		$query->from('#__easyquickicons as e');

		//join over the categories
		$query->select('c.title as category, c.id as cid');
		$query->join('LEFT', '#__categories AS c ON e.catid = c.id');
		//query conditions
		$query->where('e.published=1');
		$query->where('c.published=1');
		//order the result
		$query->order('e.ordering', 'ASC');

		$db->setQuery($query);
		$db->query();

		$items = $db->loadObjectList();

		return $items;

	}
	/**
	 * Returns a component name link to the quickicon.
	 * @param the id of the quickicon
	 * @return	the component name
	 */
	public static function eqiComponentName($id = null)
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		// Select some fields
		$query->select('link,component');
		// From the easyquickicons table
		$query->from('#__easyquickicons');
		$query->where(array('published=1', 'id=' . $id));

		$db->setQuery($query);
		$db->query();

		$item = $db->loadObject();

		//print_r($item);
		// find the com_ part of the link string to put in the access array
		$spos = stripos ($item->link, 'option=com_');

		if ($spos !== false ) {
			// option_com string found, find the end of the component string
			$component = substr ($item->link, $spos + 7);

			// check for & after the component name
			$epos = stripos ($component, '&');
			if ($epos !== false) {
				// & found, remove the remaining component string
				$component = substr ($component, 0, $epos);
			}

		} else {
			$component = trim($item->component);
		}

		return $component;
	}
	/**
	 * Returns the icon path of the quickicon.
	 * @param the id of the quickicon
	 * @param item state
	 * @param the display layout
	 * @return	the icon path
	 */
	public static function eqiImage($id = null, $published = null, $layout = '_:small')
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		// Select some fields
		$query->select('custom_icon,icon_path,icon');
		// From the easyquickicons table
		$query->from('#__easyquickicons');
		$query->where(array('id=' . $db->quote($id), $published == null ? 'published IN (0,1,2,-2)' : 'published=' . $db->quote($published)));

		$db->setQuery($query);
		$db->query();

		$row = $db->loadObject();

		if($row->custom_icon == 1){

			$chk_img = stripos(strtolower($row->icon_path), 'http');

			if($chk_img === false){ //custom image
				$img = JURI::root() . trim($row->icon_path);
			} else { // external image link
				$img = trim($row->icon_path);
			}

		} else {
			if($layout == '_:small'){
				$img = self::eqiIconsClass(trim($row->icon));
			}else {
				$img = trim($row->icon);
			}
			//$img = trim($row->icon);
		}

		return $img;
	}
	/**
	 * Returns the list of easyquickicons categories.
	 */
	public static function eqiCategory(){

		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		// Select some fields
		$query->select('id, alias, title as category');
		// From the easyquickicons table
		$query->from('#__categories');
		$query->where(array('published=1', 'extension=' . $db->quote('com_easyquickicons')));
		$db->setQuery($query);

	    if (!$db->query()) {
			throw new Exception($db->getErrorMsg());
		}
		$result = $db->loadObjectList();

		return $result;
	}
	/**
	 * Get the category title for default Joomla! quickicons
	 */
	public static function standardCategory(){
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		// Select some fields
		$query->select('title as category');
		// From the easyquickicons table
		$query->from('#__categories');
		$query->where('extension=' . $db->quote('com_easyquickicons'));
		$db->setQuery($query);

	    if (!$db->query()) {
			throw new Exception($db->getErrorMsg());
		}
		$category = $db->loadResult();

		return $category;

	}
	/**
	 * Get the category id for default Joomla! quickicons
	 */
	public static function standardCategoryId(){
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		// Select some fields
		$query->select('id as categoryId');
		// From the easyquickicons table
		$query->from('#__categories');
		$query->where('extension=' . $db->quote('com_easyquickicons'));
		$db->setQuery($query);

	    if (!$db->query()) {
			throw new Exception($db->getErrorMsg());
		}
		$category = $db->loadResult();

		return $category;

	}
	public static function eqiIconsClass($symbol) {
		switch ($symbol) {
			case "!":
				$class = 'home';
				break;
			case "\"":
				$class = 'user';
				break;
			case "#":
				$class = 'lock';
				break;
			case "$":
				$class = 'comment';
				break;
			case "%":
				$class = 'comments-2';
				break;
			case "&":
				$class = 'share-alt';
				break;
			/*
			case "'":
				$class = 'redo';
				break;
			*/
			case "(":
				$class = 'undo';
				break;
			case ")":
				$class = 'file-add';
				break;
			case "*":
				$class = 'new';
				break;
			case "+":
				$class = 'edit';
				break;
			case ",":
				$class = 'pencil-2';
				break;
			case "-":
				$class = 'folder-open';
				break;
			case ".":
				$class = 'folder-close';
				break;
			case "/":
				$class = 'picture';
				break;
			case "0":
				$class = 'pictures';
				break;
			case "1":
				$class = 'list';
				break;
			case "2":
				$class = 'power-cord';
				break;
			case "3":
				$class = 'cube';
				break;
			case "4":
				$class = 'puzzle';
				break;
			case "5":
				$class = 'flag';
				break;
			case "6":
				$class = 'tools';
				break;
			case "7":
				$class = 'cogs';
				break;
			case "8":
				$class = 'options';
				break;
			case "9":
				$class = 'equalizer';
				break;
			case ":":
				$class = 'wrench';
				break;
			case ";":
				$class = 'brush';
				break;
			case "<":
				$class = 'eye-open';
				break;
			case "K":
				$class = 'eye-close';
				break;
			case "=":
				$class = 'checkbox-unchecked';
				break;
			case ">":
				$class = 'checkbox';
				break;
			case "?":
				$class = 'checkbox-partial';
				break;
			case "@":
				$class = 'star-empty';
				break;
			case "A":
				$class = 'star-2';
				break;
			case "B":
				$class = 'star';
				break;
			case "C":
				$class = 'calendar';
				break;
			case "D":
				$class = 'calendar-2';
				break;
			case "E":
				$class = 'help';
				break;
			case "F":
				$class = 'support';
				break;
			case "G":
				$class = 'checkmark';
				break;
			case "H":
				$class = 'warning';
				break;
			case "J":
				$class = 'cancel';
				break;
			case "L":
				$class = 'trash';
				break;
			case "M":
				$class = 'envelope';
				break;
			case "N":
				$class = 'mail-2';
				break;
			case "O":
				$class = 'drawer';
				break;
			case "P":
				$class = 'drawer-2';
				break;
			case "Q":
				$class = 'box-add';
				break;
			case "R":
				$class = 'box-remove';
				break;
			case "S":
				$class = 'search';
				break;
			case "T":
				$class = 'filter';
				break;
			case "U":
				$class = 'camera';
				break;
			case "V":
				$class = 'play';
				break;
			case "W":
				$class = 'music';
				break;
			case "X":
				$class = 'grid-view';
				break;
			case "Y":
				$class = 'grid-view-2';
				break;
			case "Z":
				$class = 'menu';
				break;
			case "[":
				$class = 'thumbs-up';
				break;
			case "\\":
				$class = 'thumbs-down';
				break;
			case "I":
				$class = 'delete';
				break;
			case "]":
				$class = 'plus-2';
				break;
			case "^":
				$class = 'minus-sign';
				break;
			case "_":
				$class = 'key';
				break;
			case "`":
				$class = 'quote';
				break;
			case "a":
				$class = 'quote-2';
				break;
			case "b":
				$class = 'database';
				break;
			case "c":
				$class = 'location';
				break;
			case "d":
				$class = 'zoom-in';
				break;
			case "e":
				$class = 'zoom-out';
				break;
			case "f":
				$class = 'expand';
				break;
			case "h":
				$class = 'expand-2';
				break;
			case "g":
				$class = 'contract';
				break;
			case "i":
				$class = 'contract-2';
				break;
			case "j":
				$class = 'health';
				break;
			case "k":
				$class = 'wand';
				break;
			case "l":
				$class = 'refresh';
				break;
			case "m":
				$class = 'vcard';
				break;
			case "n":
				$class = 'clock';
				break;
			case "o":
				$class = 'compass';
				break;
			case "p":
				$class = 'address';
				break;
			case "q":
				$class = 'feed';
				break;
			case "r":
				$class = 'flag-2';
				break;
			case "s":
				$class = 'pin';
				break;
			case "t":
				$class = 'lamp';
				break;
			case "u":
				$class = 'chart';
				break;
			case "v":
				$class = 'bars';
				break;
			case "w":
				$class = 'pie';
				break;
			case "x":
				$class = 'dashboard';
				break;
			case "y":
				$class = 'lightning';
				break;
			case "z":
				$class = 'move';
				break;
			case "{":
				$class = 'next';
				break;
			case "|":
				$class = 'previous';
				break;
			case "}":
				$class = 'first';
				break;
			case "î€€":
				$class = 'last';
				break;
			case "î€�":
				$class = 'loop';
				break;
			case "î€‚":
				$class = 'shuffle';
				break;
			case "î€ƒ":
				$class = 'arrow-first';
				break;
			case "î€„":
				$class = 'arrow-last';
				break;
			case "î€…":
				$class = 'arrow-up';
				break;
			case "î€‡":
				$class = 'arrow-down';
				break;
			case "î€ˆ":
				$class = 'arrow-left';
				break;
			case "î€†":
				$class = 'arrow-right';
				break;
			case "î€‰":
				$class = 'arrow-up-2';
				break;
			case "î€‹":
				$class = 'arrow-down-2';
				break;
			case "î€Œ":
				$class = 'arrow-left-2';
				break;
			case "î€Š":
				$class = 'arrow-right-2';
				break;
			case "î€�":
				$class = 'arrow-up-3';
				break;
			case "î€‘":
				$class = 'arrow-down-3';
				break;
			case "î€’":
				$class = 'arrow-left-3';
				break;
			case "î€�":
				$class = 'arrow-right-3';
				break;
			case "î€�":
				$class = 'play-2';
				break;
			case "î€Ž":
				$class = 'menu-2';
				break;
			case "î€“":
				$class = 'printer';
				break;
			case "î€”":
				$class = 'color-palette';
				break;
			case "î€•":
				$class = 'camera-2';
				break;
			case "î€–":
				$class = 'file';
				break;
			case "î€—":
				$class = 'file-remove';
				break;
			case "î€˜":
				$class = 'copy';
				break;
			case "î€™":
				$class = 'cart';
				break;
			case "î€š":
				$class = 'basket';
				break;
			case "î€›":
				$class = 'broadcast';
				break;
			case "î€œ":
				$class = 'screen';
				break;
			case "î€�":
				$class = 'tablet';
				break;
			case "î€ž":
				$class = 'mobile';
				break;
			case "î€Ÿ":
				$class = 'users';
				break;
			case "î€ ":
				$class = 'briefcase';
				break;
			case "î€¡":
				$class = 'download';
				break;
			case "î€¢":
				$class = 'upload';
				break;
			case "î€£":
				$class = 'bookmark';
				break;
			case "î€¤":
				$class = 'out-2';
				break;
			default:
				$class = "";
		}
		return $class;
	}
}
