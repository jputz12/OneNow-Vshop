<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined('_JEXEC') or die;

class J2StoreControllerCustomers extends F0FController
{
	/**
	 *
	 * @return boolean
	 */
 	function viewOrder(){
		$email  = $this->input->getString('email_id');
		$user_id = $this->input->getInt('user_id');
		$this->layout='view';
		$this->display();
		return true;
	}

	/**
	 * Method to delete customer
	 */
function delete()
	{
		// Initialise the App variables
		$app=JFactory::getApplication();

		// Assign the get Id to the Variable
		$id=$app->input->getInt('id');

		if($id)
		{	// store the table in the variable
			$address = F0FTable::getInstance('Address', 'J2StoreTable');
			$address->load($id);
			$email = $address->email;
			try {
				$address->delete();
				$msg = JText::_('J2STORE_ITEMS_DELETED');
			} catch (Exception $error) {
				$msg = $error->getMessage();
			}
		}
		$link = 'index.php?option=com_j2store&view=customer&task=viewOrder&email='.$email;
		$this->setRedirect($link, $msg);

	}

}