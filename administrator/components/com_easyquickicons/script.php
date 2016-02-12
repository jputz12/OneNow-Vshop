<?php
/**
 * Installer File
 *
 * @subpackage			Easy QuickIcons
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class com_easyquickiconsInstallerScript
{
	/**
	 * @var JXMLElement
	 */
	private $_manifest = null;

	/*
	 * $parent is the class calling this method.
	 * install runs after the database scripts are executed.
	 * If the extension is new, the install method is run.
	 * If install returns false, Joomla will abort the install and undo everything already done.
	 */

	function install( $parent ) {

		$db = JFactory::getDbo();
		$app = JFactory::getApplication();

		$app->setUserState('com_installer.message', '');
		$app->setUserState('com_installer.extension_message', '');

		$this->installImages();
		$this->disableQuickicon();
		$this->enableEasyquickiconsModule();

	}
	function update( $parent ) {

		$db = JFactory::getDbo();
		//check backwards compatibility for previous versions
		$subQueries = array();
		$columns = $db->getTableColumns('#__easyquickicons');

		if (empty( $columns['created_by'])) {
			$subQueries[] = ' ADD `created_by` int(10) unsigned NOT NULL';
		}
		if (empty( $columns['created_by_alias'])) {
			$subQueries[] = ' ADD `created_by_alias` varchar(255) NOT NULL';
		}
		if(!empty( $columns['module_group'])){
			$subQueries[] = ' DROP `module_group`';
		}
		if (!empty( $subQueries1)) {
			$subQueries = implode( ', ', $subQueries1);

			$query = 'alter table ' . $db->quoteName('#__easyquickicons') . $subQueries;
			$db->setQuery($query);
			$db->query();
		}
		$app = JFactory::getApplication();

		$app->setUserState('com_installer.message', '');
		$app->setUserState('com_installer.extension_message', '');

		$this->installImages();
		$this->disableQuickicon();
		$this->enableEasyquickiconsModule();

		$app->enqueueMessage('Easy Quickicon files successfully updated');

	}
	function postflight( $type, $parent ) {

		// always create or modify these parameters

		$params['version'] = $this->release;
		$params['license'] = '';

		// define the following parameters
		if ( $type == 'install' ) {
			$params['install_type'] = 'install';
			$this->addStandardCategory();
			$this->addCustomCategory();
		} else if($type == 'update'){
			$params['install_type'] = 'update';
		} else {
			$params['install_type'] = '';
		}

		$this->setParams( $params );


	}

	/*
	 * $parent is the class calling this method
	 * uninstall runs before any other action is taken (file removal or database processing).
	 */
	function uninstall( $parent ) {

		//enable Standard quickicon
		$this->enableQuickicon();
		echo '<p>' . JText::_('COM_EASYQUICKICONS_UNINSTALL') . '</p>';
	}

	/*
	 * get a variable from the manifest file (actually, from the manifest cache).
	 */
	function getParam( $name ) {
		$db = JFactory::getDbo();
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE element = "com_easyquickicons"');
		$manifest = json_decode( $db->loadResult(), true );
		return $manifest[ $name ];
	}
	/*
	 * Disable Joomla Quickicons and the easyquickicon plugin*/
	function disableQuickicon(){

		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
		$query = $db->getQuery(true);

		$query->select('id');
		$query->from('#__modules');
		$query->where('module = '. $db->Quote('mod_quickicon'));

		$db->setQuery($query);
		if($id=$db->loadResult()) {
			$query = $db->getQuery(true);
			$query->update('#__modules');
			$query->set('published = 0');
			$query->where('id = '. $db->Quote($id));
			$db->setQuery($query);
			if ($db->query()) {
				$app->enqueueMessage('Standard Joomla Quickicons has been successfully disabled');
			}
		}

	}
	/* Enable Joomla Quickicons*/
	function enableQuickicon(){

		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
		$query = $db->getQuery(true);

		$query->select('id');
		$query->from('#__modules');
		$query->where('module = '. $db->Quote('mod_quickicon'));

		$db->setQuery($query);
		if($id=$db->loadResult()) {
			$query = $db->getQuery(true);
			$query->update('#__modules');
			$query->set('published = 1');
			$query->where('id = '. $db->Quote($id));
			$db->setQuery($query);
			if ($db->query()) {
				$app->enqueueMessage('Standard Joomla Quickicons has been successfully enabled');
			}
		}
	}
	/* Method to enable the easyquickicons module */
	function enableEasyquickiconsModule(){
		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
		$query = $db->getQuery(true);

		$query->select('id');
		$query->from('#__modules');
		$query->where('module = '. $db->Quote('mod_easyquickicons'));

		$db->setQuery($query);
		if($id=$db->loadResult()) {
			$query = $db->getQuery(true);
			$query->update('#__modules')
				->set('title=' . $db->quote('Easy Quickicons'))
				->set('position=' . $db->quote('icon'))
				->set('published=' . $db->quote((int)1))
				->set('access=' . $db->quote((int)3))
				->where('id = '. $db->Quote($id));
			$db->setQuery($query);
			$db->query();

			$query = $db->getQuery(true);
			$query->select('moduleid')
				->from('#__modules_menu')
				->where('moduleid=' . $db->quote($id));
			$db->setQuery($query);
			$db->query();

			$mid = $db->loadResult();

			if(empty($mid)){
				$query = $db->getQuery(true);
				$query->insert('#__modules_menu')
					->columns('moduleid')
					->values($id);
				$db->setQuery($query);
				if ($db->query()) {
					$app->enqueueMessage('Easy Quickicons module has been successfully enabled');
				}
			}
		}
	}
	/* method to create a custom quickicon category
	 * */
	function addStandardCategory(){

		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$app = JFactory::getApplication();

		JTable::addIncludePath(JPATH_PLATFORM . 'joomla/database/table');
		// Initialize a new category
		$category = JTable::getInstance('Category');
		$category->extension = 'com_easyquickicons';
		$category->title = 'Standard';
		$category->description = 'Default Joomla! quickicons';
		$category->published = 1;
		$category->access = 1;
		$category->params = '{"category_layout":"","image":""}';
		$category->metadata = '{"page_title":"","author":"","robots":""}';
		$category->language = '*';

		// Set the location in the tree
		$category->setLocation(1, 'last-child');
		$category->setRules('{"core.view":{"1":1},"core.delete":[],"core.edit":[],"core.edit.state":[]}');
		// Check to make sure our data is valid
		if (!$category->check())
		{
			JError::raiseNotice(500, $category->getError());
			return false;
		}

		// Now store the category
		if ($category->store(true))
		{
			$app->enqueueMessage('Easy Quickicons Standard category has been successfuly created.');

			//Get category ID
			$query = $db->getQuery(true);
			$query->select('id');
			$query->from('#__categories');
			$query->where('extension = ' . $db->quote('com_easyquickicons'));
			$query->where('title = ' . $db->quote('Standard'));

			$db->setQuery($query);
			$catid = (int)$db->loadResult();

			$icons = array();
			$icons[] = array('catid' => $catid, 'name' => 'Add New Article', 'link' => 'index.php?option=com_content&task=article.add', 'target' => '_self', 'icon' => ')', 'access' => 1, 'published' => 1, 'ordering' => 1, 'description' => 'Adds new Joomla! article');
			$icons[] = array('catid' => $catid, 'name' => 'Article Manager', 'link' => 'index.php?option=com_content', 'target' => '_self', 'icon' => ',', 'access' => 1, 'published' => 1, 'ordering' => 2, 'description' => 'Joomla! article manager');
			$icons[] = array('catid' => $catid, 'name' => 'Category Manager', 'link' => 'index.php?option=com_categories&extension=com_content', 'target' => '_self', 'icon' => '-', 'access' => 1, 'published' => 1, 'ordering' => 3, 'description' => 'Joomla! category manager');
			$icons[] = array('catid' => $catid, 'name' => 'Media Manager', 'link' => 'index.php?option=com_media', 'target' => '_self', 'icon' => 0, 'access' => 1, 'published' => 1, 'ordering' => 4, 'description' => 'Joomla! media manager');
			$icons[] = array('catid' => $catid, 'name' => 'Menu Manager', 'link' => 'index.php?option=com_menus', 'target' => '_self', 'icon' => 1, 'access' => 1, 'published' => 1, 'ordering' => 5, 'description' => 'Joomla! menu manager');
			$icons[] = array('catid' => $catid, 'name' => 'User Manager', 'link' => 'index.php?option=com_users', 'target' => '_self', 'icon' => 'p', 'access' => 1, 'published' => 1, 'ordering' => 6, 'description' => 'Joomla! user manager');
			$icons[] = array('catid' => $catid, 'name' => 'Module Manager', 'link' => 'index.php?option=com_modules', 'target' => '_self', 'icon' => 3, 'access' => 1, 'published' => 1, 'ordering' => 7, 'description' => 'Joomla! module manager');
			$icons[] = array('catid' => $catid, 'name' => 'Extension Manager', 'link' => 'index.php?option=com_installer', 'target' => '_self', 'icon' => 4, 'access' => 1, 'published' => 1, 'ordering' => 8, 'description' => 'Joomla! extension manager');
			$icons[] = array('catid' => $catid, 'name' => 'Language Manager', 'link' => 'index.php?option=com_languages', 'target' => '_self', 'icon' => '%', 'access' => 1, 'published' => 1, 'ordering' => 9, 'description' => 'Joomla! language manager');
			$icons[] = array('catid' => $catid, 'name' => 'Global Configuration', 'link' => 'index.php?option=com_config', 'target' => '_self', 'icon' => 8, 'access' => 1, 'published' => 1, 'ordering' => 10, 'description' => 'Joomla! global configuration');
			$icons[] = array('catid' => $catid, 'name' => 'Template Manager', 'link' => 'index.php?option=com_templates', 'target' => '_self', 'icon' => '<', 'access' => 1, 'published' => 1, 'ordering' => 11, 'description' => 'Joomla! template manager');
			$icons[] = array('catid' => $catid, 'name' => 'Edit Profile', 'link' => 'index.php?option=com_admin&task=profile.edit', 'target' => '_self', 'icon' => 'm', 'access' => 1, 'published' => 1, 'ordering' => 12, 'description' => 'Joomla! profile editor');

			require_once JPATH_BASE.'/components/com_easyquickicons/tables/easyquickicon.php';

			foreach ($icons as $icon) {

				$iconsTable = new EasyquickiconsTableEasyquickicon($db);
				$iconsTable->setRules('{"core.view":{"1":1},"core.delete":[],"core.edit":[],"core.edit.state":[]}');

				if(!$iconsTable->save($icon)){
					$app->enqueueMessage('Standard category icons cannot be created.', 'error');
				}

			}
		} else {
			JError::raiseNotice(500, $category->getError());
			return false;
		}

		// Build the path for our category
		$category->rebuildPath($category->id);

	}
	/* method to create a custom quickicon category
	 * */
	function addCustomCategory(){

		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$app = JFactory::getApplication();

		JTable::addIncludePath(JPATH_PLATFORM . 'joomla/database/table');
		// Initialize a new category
		$customCat = JTable::getInstance('Category');
		$customCat->extension = 'com_easyquickicons';
		$customCat->title = 'Custom';
		$customCat->description = 'Custom quickicon category';
		$customCat->published = 1;
		$customCat->access = 1;
		$customCat->params = '{"category_layout":"","image":""}';
		$customCat->metadata = '{"page_title":"","author":"","robots":""}';
		$customCat->language = '*';
		$customCat->setLocation(1, 'last-child');
		$customCat->setRules('{"core.view":{"1":1},"core.delete":[],"core.edit":[],"core.edit.state":[]}');
		// Check to make sure our data is valid
		if (!$customCat->check())
		{
			JError::raiseNotice(500, $customCat->getError());
			return false;
		}

		// Now store the category
		if ($customCat->store(true))
		{
			//get custom category id
			$query = $db->getQuery(true);
			$query->select('id');
			$query->from('#__categories');
			$query->where('extension = ' . $db->quote('com_easyquickicons'));
			$query->where('title = ' . $db->quote('Custom'));
			$db->setQuery($query);
			$cid = (int)$db->loadResult();

			$cicons = array();
			$cicons[] = array('catid' => $cid, 'name' => 'Easy Quickicons', 'link' => 'index.php?option=com_easyquickicons', 'target' => '_self', 'custom_icon' => 1, 'icon' => '', 'icon_path' => 'images/easyquickicons/icon-48-easyquickicons.png', 'access' => 1, 'published' => 1, 'ordering' => 1, 'description' => 'Easy Quickicons Manager');

			require_once JPATH_BASE.'/components/com_easyquickicons/tables/easyquickicon.php';

			foreach ($cicons as $cicon) {

				$customTable = new EasyquickiconsTableEasyquickicon($db);
				$customTable->setRules('{"core.view":{"1":1},"core.delete":[],"core.edit":[],"core.edit.state":[]}');

				if(!$customTable->save($cicon)){
					$app->enqueueMessage('Custom category icons cannot be created.', 'error');
				}
			}
		} else {
			JError::raiseNotice(500, $customCat->getError());
			return false;
		}
		// Build the path for our category
		$customCat->rebuildPath($customCat->id);
	}
	function installImages(){
		$app = JFactory::getApplication();
		//Copy images to folder
		$fromDir = JPATH_ADMINISTRATOR.'/components/com_easyquickicons/images';
		$toDir = JPATH_SITE.'/images/easyquickicons';

		if (!(JFolder::exists($toDir))) {
			if (JFolder::copy($fromDir, $toDir)) {
				JFolder::delete($fromDir);
				$app->enqueueMessage('Custom quickicon images successfully installed.');
			} else {
				$app->enqueueMessage('Cannot install custom quickicon images.', 'error');
			}
		}
	}
	/*
	 * sets parameter values in the component's row of the extension table
	 */
	function setParams($param_array) {
		if ( count($param_array) > 0 ) {
			// read the existing component value(s)
			$db = JFactory::getDbo();
			$db->setQuery('SELECT params FROM #__extensions WHERE element = "com_easyquickicons"');
			$params = json_decode( $db->loadResult(), true );
			// add the new variable(s) to the existing one(s)
			foreach ( $param_array as $name => $value ) {
				$params[ (string) $name ] = (string) $value;
			}
			// store the combined new and existing values back as a JSON string
			$paramsString = json_encode( $params );
			$db->setQuery('UPDATE #__extensions SET params = ' .
			$db->quote( $paramsString ) .
				' WHERE element = "com_easyquickicons"' );
			$db->query();
		}
	}
}