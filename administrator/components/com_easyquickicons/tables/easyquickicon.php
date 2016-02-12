<?php
/**
 * @subpackage		Easy QuickIcons
 *
 * @author			Allan <allan@awynesoft.com>
 * @link			http://www.awynesoft.com
 * @copyright		Copyright (C) 2012 AwyneSoft.com All Rights Reserved
 * @license			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version			$Id: easyquickicon.php 24 2012-09-22 05:30:05Z allan $
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
// import Joomla table library
jimport('joomla.database.table');
class EasyquickiconsTableEasyquickicon extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$_db)
	{
		parent::__construct( '#__easyquickicons', 'id', $_db );
	}
	/**
	 * Overriden store method to set dates.
	 *
	 * @param	boolean	True to update fields even if they are null.
	 *
	 * @return	boolean	True on success.
	 * @see		JTable::store
	 * @since	1.6
	 */
	public function store($updateNulls = false)
	{
		// Initialise variables.
		$date = JFactory::getDate()->toSql();

		if ($this->id) {
			// Existing item
			$this->modified_date = $date;
		} else {
			// New record.
			$this->created_date = $date;
		}

		return parent::store($updateNulls);
	}
    /**
    * Overridden bind function
    *
    * @param       array           named array
    * @return      null|string     null if operation was satisfactory, otherwise returns an error
    * @see JTable:bind
    * @since 1.5
    */
    public function bind($array, $ignore = '')
    {
    	if (isset($array['params']) && is_array($array['params']))
   	 	{
    		// Convert the params field to a string.
     		$parameter = new JRegistry;
    		$parameter->loadArray($array['params']);
    		$array['params'] = (string)$parameter;
    	}
    	// Bind the rules.
   		if (isset($array['rules']) && is_array($array['rules']))
        {
          	$rules = new JAccessRules($array['rules']);
           	$this->setRules($rules);
        }

        return parent::bind($array, $ignore);
    }
	/**
	** Method to compute the default name of the asset.
	** The default name is in the form `table_name.id`
	** where id is the value of the primary key of the table.
	** @return      string
	** @since       2.5
	**/
    protected function _getAssetName()
    {
    	$k = $this->_tbl_key;
    	return 'easyquickicons.icons.'.(int) $this->$k;
    }

    /* Method to return the title to use for the asset table.
     * @return      string
     * @since       2.5
     */
    protected function _getAssetTitle()
    {
    	return $this->name;
	}
	/**
	 * Get the parent asset id for the record
	 *
	 * @return	int
	 * @since	2.5
	 */
	/*
	protected function _getAssetParentId()
	{
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = JTable::getInstance('Asset');
		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();
		// Find the parent-asset
		if (($this->catid)&& !empty($this->catid)) {
			// The item has a category as asset-parent
			$assetParent->loadByName('com_easyquickicons.category.' . (int) $this->catid);
		} else {
			// The item has the component as asset-parent
			$assetParent->loadByName('com_easyquickicons');
		}
		// Return the found asset-parent-id
		if ($assetParent->id){
			$assetParentId=$assetParent->id;
		}

		return $assetParentId;
	}
	*/
}
