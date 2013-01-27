<?php
/**
 * Created on Sep 17, 2009 by jvazquez
 * @name datesite
 * @package modules.role.controllers
 * <p>
 * Handles the view for the roles and a single role and all the access of the roles to all the sections with the current access.
 * </p>
 */
//TODO Implement ajax updater for the viewAll method also.
class Role_ViewController extends ZFController_Controller {

	/**
	 * Show all the roles in the system
	 */
	public function indexAction() {
		$this->getFlashMessages();
		$role = new Role_Model_Role();
		$column = $this->getRequest()->getParam('column');
		$sort = $this->getRequest()->getParam('sort');

		$this->view->role = $this->paginate($role->fetchAll($column, $sort));
		$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
	}

	/**
	 *  View modules
	 */
	public function viewmodulesAction()
	{
		$moduleObj = new Modules_Model_Modules();
		$this->view->records = $moduleObj->fetchAll();
	}

	/**
	 *  View module controllers
	 */
	public function viewcontrollersAction(){
		$moduleId = $this->getRequest()->getParam('moduleId');
		$moduleObj = new Modules_Model_Modules();
		$moduleItem = $moduleObj->findById($moduleId);

		$permObj = new Permission_Model_Permission();
		$permObj->setModuleId( $moduleId );
		//$this->view->moduleId = $moduleId;
		$this->view->records = $permObj->fetchControllersByModuleId();
		$this->view->module = $moduleItem;
	}

	/**
	 *  View module controller actions
	 */
	public function viewactionsAction(){
		$moduleId = $this->getRequest()->getParam('moduleId');
		$moduleObj = new Modules_Model_Modules();
		$moduleItem = $moduleObj->findById($moduleId);
		
		$controllerId = $this->getRequest()->getParam('controllerId');
		$controllerObj = new Modules_Model_Controllers();
		$controllerItem = $controllerObj->findById($controllerId);

		$permObj = new Permission_Model_Permission();
		$permObj->setModuleId( $moduleId );
		$permObj->setControllerId( $controllerId );

		$this->view->module = $moduleItem;
		$this->view->controller = $controllerItem;
		$this->view->records = $permObj->fetchActionsByControllerModule();
	}

	/**
	 * The index action for view allows a user to view his role.
	 */
	public function viewAction() {
		$role = new Role_Model_Role();
		$this->view->record =  $role->findById($this->getRequest()->getParam('id'));
	}
}
?>
