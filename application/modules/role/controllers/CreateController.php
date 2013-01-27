<?php
/**
 * Created on Sep 13, 2009
 * CreateController.php
 * @author jvazquez
 */

class Role_CreateController extends ZFController_Controller {

	/**
	 * Create a role in the system
	 */
	public function indexAction() {
		$form = new Role_Form_Create();
		$form->setForm();
		if( $this->getRequest()->isPost() && $form->isValid( $this->getRequest()->getParams() ) ) {
			try {
				$role = new Role_Model_Role($form->getValues());
				$saved = $role->save();
				if( $saved ) {
					$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
					$this->_flashMessenger->addMessage('roleSaved');
					/**
					 * Retrieve properties. This code was in the constructor , and creating too much load time
					 * that's why we add the properties here
					 */
					$role->setProperties(APPLICATION_PATH . "/modules/role/configs/application.ini", APPLICATION_ENV);
					$props = $role->getProperties();
					$module = $props->event->saved->landing->module;
					$controller = $props->event->saved->landing->controller;
					$action = $props->event->saved->landing->action;
					$this->_helper->redirector($action,$controller,$module);
				}
			} catch(Zend_Db_Exception $e) {
				$this->view->messages = $this->getMessage('exceptionCaught');
			}
		}
		$this->view->form = $form;
	}

	/**
	 * Create an association between the Roles and the Modules and the Actions of each module.
	 * @todo Needs optimization load time is high , 80%. Discuss with rachael
	 */
	public function roleaccessAction() {
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$strMessage = $this->_flashMessenger->getMessages();
		$this->_flashMessenger->clearMessages();

		if( !empty($strMessage) ) {
			$this->view->msg = $this->getMessage($strMessage);
		}

		//  Pagination options
		$args = array();
		$args['sort'] = $this->getRequest()->getParam('sort')?$this->getRequest()->getParam('sort') : null;
		$args['column'] = $this->getRequest()->getParam('column')?$this->getRequest()->getParam('column') : null;
		$this->view->sort = ( $args['sort']=='ASC') ? 'DESC' : 'ASC';

		$permissions = new Permission_Model_Permission();
		$records = $permissions->getRoleAndPermissions($args);

		$this->view->records = $this->paginate($records['pages']);

		$roleAclModel = new Role_Model_RoleAclModel();
		$this->view->form = $roleAclModel->assembleForm($records['pages']);

		if( $this->getRequest()->isPost() ) {

			$rp = new Role_Model_RolePermissions();
			$result = $rp->prepareSave($this->getRequest()->getParams());
			if($result!=false) {
				$cache = Zend_Registry::get('cache');
				$cache->remove('rolesSelectAcl');
				$this->_flashMessenger->addMessage('roleSaved');
			} else {
				$this->_flashMessenger->addMessage('rolePermFailed');
			}
			$page = $this->_getParam('page',1);
			$this->_helper->redirector('roleaccess','create','role',array('page'=>$page,'column'=>$args['column'],'sort'=>$args['sort']) );
		}
	}
}
?>