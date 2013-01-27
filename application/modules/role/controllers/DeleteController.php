<?php
/**
 * Created on Sep 27, 2009 by jvazquez
 * @package application.modules
 * @subpackage role.controllers
 * <p>
 * This class deletes a role.Is very important that you understand the concept of role and how <strong>tied</strong> is with the ACL and the ability to view this application working.
 * That means, that you instantiate this class and call the delete method, you are going to break the application just like that, and that is not a bug, is just that you don't understand what roles are or what ACL is.
 * We will not show a view for this, is a simple action, so it will be used via Ajax.
 * If you didn't read this at all, just restore via SQL the role that you deleted <strong>with the same id</strong> so everything goes back to normal
 * </p>
 */

class Role_DeleteController extends ZFController_Controller {
	/**
	 * Fetch all the roles that you can delete.
	 */
	public function indexAction() {
		$role = new Role_Model_Role();
		$this->view->record =  $role->fetchAll();
	}

	/**
	 * I can't stress much more the importance of this action.
	 * Delete a role will break the application.
	 * @return string
	 */
	public function deleteAction() {

		$result = false;
		//  Don't render the view, this is an ajax call.
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$id = $this->getRequest()->getParam('id');
		/**
		 * Our messages
		 * If we don't have the id, don't even continue, bail out.
		 * And prepare the flashmessenger to store messages
		 */
		$message = new Messages_Model_Messages();
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		if( empty($id) ) {
			$this->_flashMessenger->addMessage('haveId');
		} else {
			$role = new Role_Model_Role();
			$roleExists = $role->findById($id);
			//  The message exists, try to delete it.
			if( $roleExists!=null ) {
				$result = $role->delete($id);
				if( $result ) {
					$this->_flashMessenger->addMessage('roleDeleted');
					$this->_redirect('/role/view/index');
				} else {
					$this->_flashMessenger->addMessage('roleDeletedFail');
					$this->_redirect('/role/view/index');
				}
			} else {
				$this->_flashMessenger->addMessage('roleMissing');
				$this->_redirect('/role/view/index');
			}
		}

		$this->_redirect('/role/view/index');
	}

	/**
	 * Delete a page permission
	 * @return jsonresponse
	 */
	public function deletepagepermissionajaxAction() {
		$result = array();
		$buffer = '';
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$roleId = $this->getRequest()->getParam('roleId');
		$pageId = $this->getRequest()->getParam('pageId');
		$rolePermission = new Role_Model_RolePermissions();
		$messages = new Messages_Model_Messages();
		$rolePermData = $rolePermission->findByKey(array(
					  								  		'columnToSort'=>false,
					  										'sortDirection'=>false,
					  										'returnClassObject'=>true,
					  										'search'=>array('permissionId'=>$pageId,'roleId'=>$roleId),
					  										'like'=>false
		)
		);
		if( !empty($rolePermData) ) {
			$deleted = $rolePermission->delete(array_shift($rolePermData)->getId());
			if($deleted==true) {
				$buffer = $messages->findByKey(
				array(
	  								  		'columnToSort'=>false,
	  										'sortDirection'=>false,
	  										'returnClassObject'=>true,
	  										'search'=>array("identifier"=>'rolePermPass'),
	  										'like'=>false
				)
				);
				$result['deleted'] = true;
			} else {
				$buffer = $messages->findByKey(
				array(
	  								  		'columnToSort'=>false,
	  										'sortDirection'=>false,
	  										'returnClassObject'=>true,
	  										'search'=>array("identifier"=>'rolePermFail'),
	  										'like'=>false
				)
				);
				$result['deleted'] = false;
			}
		} else {
			$buffer = $messages->findByKey(
			array(
	  								  		'columnToSort'=>false,
	  										'sortDirection'=>false,
	  										'returnClassObject'=>true,
	  										'search'=>array("identifier"=>'resourceExists'),
	  										'like'=>false
			)
			);
			$result['deleted'] = false;
		}
		$result['message'] = array_shift( $buffer )->getMessage();
		echo Zend_Json::encode($result);
	}
}
?>
