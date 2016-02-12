<?php
/**
 *
 * @package		Easy QuickIcons
 *
 * @author		Allan <allan@awynesoft.com>
 * @link		http://www.awynesoft.com
 * @copyright	Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license		GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version		$Id: view.html.php 24 2012-09-22 05:30:05Z allan $
**/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


//import Joomla view library
//jimport( 'joomla.application.component.view' );
/**
 * @subpackage Components
 */
class EasyquickiconsViewEasyquickicons extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	protected $manifest;

		/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @since   1.6
	 */
	function display($tpl = null)
	{
		//get the Model data
		$items 		= $this->get('Items');
		$pagination = $this->get('Pagination');
		$state 		= $this->get('State');
		$manifest 	= $this->get('VersionInfo');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view

		$this->items 		= $items;
		$this->pagination 	= $pagination;
		$this->state 		= $state;
		$this->manifest		= $manifest;

				//set the document
		$this->setDocument();
		//load the toolbar
		$this->addToolBar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}
	protected function addToolBar(){

		$state	= $this->get('State');
		$canDo	= EasyquickiconsHelper::getActions();
		$layout = JRequest::getCmd('layout', 'default');

		if($layout != 'welcome'){

			JToolBarHelper::title( JText::_( 'COM_EASYQUICKICONS_TOOLBAR' ), 'easyquickicons' );

			if ($canDo->get('core.create')) {
				JToolBarHelper::addNew('easyquickicon.add');
			}
			if ($canDo->get('core.edit')) {
				JToolBarHelper::editList('easyquickicon.edit');
			}
			if ($canDo->get('core.edit.state')) {
				if ($state->get('filter.state') != 2){
					JToolBarHelper::divider();
					JToolBarHelper::publish('easyquickicons.publish', 'JTOOLBAR_ENABLE', true);
					JToolBarHelper::unpublish('easyquickicons.unpublish', 'JTOOLBAR_DISABLE', true);
				}
				if ($state->get('filter.state') != -1 ) {
					JToolBarHelper::divider();
					if ($state->get('filter.state') != 2) {
						JToolBarHelper::archiveList('easyquickicons.archive');
					}
					elseif ($state->get('filter.state') == 2) {
						JToolBarHelper::unarchiveList('easyquickicons.publish', 'JTOOLBAR_UNARCHIVE');
					}
				}
			}
			if ($canDo->get('core.admin'))
			{
				JToolbarHelper::checkin('easyquickicons.checkin');
			}
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
				JToolBarHelper::deleteList('', 'easyquickicons.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			} elseif ($canDo->get('core.edit.state')) {
				JToolBarHelper::trash('easyquickicons.trash');
				JToolBarHelper::divider();
			}
			if ($canDo->get('core.admin')) {
				JToolBarHelper::preferences('com_easyquickicons');
				JToolBarHelper::divider();
			}

			$bar = JToolBar::getInstance( 'toolbar' );
			$bar->appendButton( 'Help', 'help', 'JTOOLBAR_HELP', 'http://awynesoft.com/documentation.html', 640, 480 );

			JHtmlSidebar::setAction('index.php?option=com_easyquickicons&view=easyquickicons');

			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_state',
				JHtml::_('select.options', EasyquickiconsHelper::publishedOptions(), 'value', 'text', $this->state->get('filter.state'), true)
			);

			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_CATEGORY'),
				'filter_category_id',
				JHtml::_('select.options', JHtml::_('category.options', 'com_easyquickicons'), 'value', 'text', $this->state->get('filter.category_id'))
			);

		} else {

			JToolBarHelper::back('COM_EASYQUICKICONS', 'index.php?option='.JRequest::getCmd('option'));

		}

	}
	protected function setDocument(){

		$document = JFactory::getDocument();
		$document->setTitle( JText::_( 'Easy QuickIcons - Administration' ) );

		$document->addStyleSheet('../administrator/components/com_easyquickicons/assets/css/icons.css');
	}
	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.catid' => JText::_('COM_EASYQUICKICONS_CATEGORY'),
			'a.ordering' => JText::_('COM_EASYQUICKICONS_HEAD_ORDERING'),
			'a.published' => JText::_('COM_EASYQUICKICONS_HEAD_STATUS'),
			'a.name' => JText::_('COM_EASYQUICKICONS_HEAD_NAME'),
			'a.link' => JText::_('COM_EASYQUICKICONS_HEAD_LINK'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}