<?php
/**
 * @package		Easy QuickIcons
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version			$Id: view.html.php 24 2012-09-22 05:30:05Z allan $
 */
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
/**
 * @subpackage Components
 */
class EasyquickiconsViewEasyquickicon extends JViewLegacy
{
	protected $item;

	protected $form;

	protected $state;

	function display($tpl = null)
	{
		// Assign the model data to the view
		$this->form 	= $this->get('Form');
		$this->item 	= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		//set the document
		$this->setDocument();
		//load the toolbar
		$this->addToolBar();

		parent::display($tpl);
	}
	protected function addToolBar(){

		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user	= JFactory::getUser();
		$isNew	= ($this->item->id == 0);
		$canDo	= EasyquickiconsHelper::getActions($this->item->id);

		JToolBarHelper::title($isNew ? JText::_('COM_EASYQUICKICONS_TOOLBAR_NEW')
		                             : JText::_('COM_EASYQUICKICONS_TOOLBAR_EDIT') , 'easyquickicons');
		// If not checked out, can save the item.
		if ($canDo->get('core.edit')) {
			JToolBarHelper::apply('easyquickicon.apply');
			JToolBarHelper::save('easyquickicon.save');
		}
		if ($canDo->get('core.edit') && $canDo->get('core.create')) {
			JToolBarHelper::save2new('easyquickicon.save2new');
		}
		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::save2copy('easyquickicon.save2copy');
		}
		JToolBarHelper::cancel('easyquickicon.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');

		$bar = JToolBar::getInstance( 'toolbar' );
		$bar->appendButton( 'Help', 'help', 'JTOOLBAR_HELP', 'http://awynesoft.com/documentation.html', 640, 480 );




	}
	protected function setDocument(){

		$script = array();

		$script[] = "function customIcon(img) {";
		$script[] = "	$('grid_img_view').src = '" . JURI::root() . "' + img;";
		$script[] = "	$('list_img_view').src = '" . JURI::root() . "' + img;";
		$script[] = "}";
		$script[] = "function setType(type){";
		$script[] = "	if(type == 1){";
		$script[] = "		$('icon_div').style.display = 'none';";
		$script[] = "		$('grid_icon_view').style.display = 'none';";
		$script[] = "		$('list_icon_view').style.display = 'none';";
		$script[] = "		$('icon_path_div').style.display = 'block';";
		$script[] = "		$('grid_img_view').style.display = 'block';";
		$script[] = "		$('list_img_view').style.display = 'inline';";
		$script[] = "		$('grid_txt').style.padding = '0';";
		$script[] = "	} else {";
		$script[] = "		$('icon_path_div').style.display = 'none';";
		$script[] = "		$('grid_img_view').style.display = 'none';";
		$script[] = "		$('list_img_view').style.display = 'none';";
		$script[] = "		$('icon_div').style.display = 'block';";
		$script[] = "		$('grid_icon_view').style.display = 'inline-block';";
		$script[] = "		$('list_icon_view').style.display = 'inline';";
		$script[] = "		$('grid_txt').style.padding = '10px 0';";
		$script[] = "	}";
		$script[] = "}";

		$document = JFactory::getDocument();
		$document->setTitle( JText::_( 'COM_EASYQUICKICONS_DOCUMENT_TITLE' ));
		$document->addScriptDeclaration(implode("\n", $script));
		$document->addStyleSheet('../administrator/components/com_easyquickicons/assets/css/icons.css');
	}
}