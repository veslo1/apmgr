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

class Province_DeleteController extends Zend_Controller_Action {

	public function indexAction() {
		$region = new Province_Model_Province();
		$this->view->record =  $region->fetchAll();
	}

	public function deleteAction() {
		$result = false;
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$id = $this->getRequest()->getParam('id');
		$region = new Province_Model_Province();
		$regionExists = $region->findById($id);

		if( !empty($regionExists ) ) {
			$result = $region->delete($id);
		}
			
		$msg = ($result)? $msg='Deleted' : $msg='Error';

		$this->_helper->redirector('index', 'view', 'province',array('msg'=> $msg) );
	}
}
?>
