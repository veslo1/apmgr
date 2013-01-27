<?php
/**
 * Created on Sep 27, 2009 by jvazquez
 * @name datesite
 * @package application.modules.controllers.role
 * <p>
 * This class deletes a role.Is very important that you understand the concept of role and how <strong>tied</strong> is with the ACL and the ability to view this application working.
 * That means, that you instantiate this class and call the delete method, you are going to break the application just like that, and that is not a bug, is just that you don't understand what roles are or what ACL is.
 * We will not show a view for this, is a simple action, so it will be used via Ajax.
 * If you didn't read this at all, just restore via SQL the role that you deleted <strong>with the same id</strong> so everything goes back to normal
 * </p>
 */

class Country_DeleteController extends Zend_Controller_Action {
	/**
	 * Fetch all the roles that you can delete.
	 */
	public function indexAction() {
		$country = new Country_Model_Country();
		$this->view->record =  $country->fetchAll();
	}

	/**
	 * I can't stress much more the importance of this action.
	 * Delete a role will break the application.
	 */
	public function deleteAction() {
		$result = false;
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$id = $this->getRequest()->getParam('id');
		$country = new Country_Model_Country();
		$countryExists = $country->findById($id);

		if( !empty($countryExists ) ) {
			$result = $country->delete($id);
		}
			
		$msg = ($result)? $msg='Deleted' : $msg='Error';

		$this->_helper->redirector('index', 'view', 'country',array('msg'=> $msg) );
	}
}
?>
