<?php
/**
 * Created on Sep 19, 2009 by jvazquez
 * datesite
 * application.modules.role.controllers
 * <p>
 * Update controller for role object
 * </p>
 */
class Role_UpdateController extends ZFController_Controller {
	/**
	 * Fetch the list of roles to update
	 */
	public function indexAction(){
		$role = new Role_Model_Role();
		$args = $this->getRequest()->getParams();
		$column = isset($args['by'])?$args['by']:null;
		$order = isset($args['order'])?$args['order']:null;
		$this->view->roles =  $this->paginate($role->fetchAll($column,$order,true));
		$this->view->sort = $order=='ASC'?'DESC':'ASC';
	}

	/**
	 * Updates the given role
	 */
	public function updateAction() {
		$id = $this->getRequest()->getParam('id');
		if (!empty($id) ) {
			$role = new Role_Model_Role();
			$exists = $role->exists(array('table'=>'role','column'=>'id'), $id);
			if ( $exists!=false ) {
				$roleData = $role->findById($id);
				$form = new Role_Form_Create();
				$form->setForm();
				$form->populate(array('id'=>$roleData->getId(),'name'=>$roleData->getName(),'protected'=>$roleData->getProtected()));
				$this->view->form = $form;
				if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams()) ) {
					$role = new Role_Model_Role( array('id'=>$id,'name'=>$form->getValue('name'),'protected'=>$form->getValue('protected') ) );
					try {
						$saved = $role->save();
						if(true==$saved){
							$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
							$this->_flashMessenger->addMessage( 'roleupdatepass' );
							$this->_helper->redirector('index', 'view', 'role');
						}
						$this->view->msg ='roleupdatefail';
					} catch(Exception $e) {
						$this->view->msg ='roleupdatefail';
					}
				} else {
					$this->view->msg = 'roleMissing';
				}
			} else {
				$this->view->msg = 'haveId';
			}
		}
	}

	/**
	 *  Updates a permission for a role
	 */
	public function updatepermissionAction(){
		$permissionId = $this->getRequest()->getParam('permissionId');
		$form = new Role_Form_UpdatePermission();
		$form->populateCheckboxes($permissionId);
		$this->view->form = $form;
			
		// save role permissions
		if( $this->getRequest()->isPost()
		&& $form->isValid($this->getRequest()->getParams()) ) {

			$formValues = $form->getValues();
			$formValues['permission'] = $permissionId;

			$rolePermissionObj = new Role_Model_RolePermissions();

			if( $rolePermissionObj->prepareSave($formValues) ){
				$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
				$this->_flashMessenger->addMessage( 'rolePermSaved' );
				$this->_helper->redirector('viewmodules', 'view', 'role');
			}
		}
	}
}
?>
