<?php

/**
 * Created on Sep 20, 2009 by jvazquez
 * @name datesite
 * @package application.modules.permission.controller
 * <p>
 * Controller class for the update page
 * </p>
 */
class Permission_UpdateController extends ZFController_Controller {

	/**
	 * Index action to update a permission
	 */
	public function indexAction() {
		$id = $this->getRequest()->getParam('id');
		$permission = new Permission_Model_Permission();
		$permissionData = $permission->findById($id);
		$form = new Permission_Form_Update();
		$this->view->form = $form;

		if ( $permissionData!==null or empty($id) ) {
			$data = array('id'=>$permissionData->getId(),'alias'=>$permissionData->getAlias());
			//	Populate the data
			$form->setDefaults($data);
			if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
				$permission->setId($id);
				$permission->setAlias($form->getValue('alias'));
				$saved = $permission->save();
				if ($saved) {
					$this->_helper->redirector('index', 'view', 'permission');
				} else {
					$this->view->msg = $this->getMessage('pmSaveFail');
				}
			}
		} else {
			//	Just disable the entire form
			$this->view->msg = $this->getMessage('pmsfakeId');
			foreach( $form->getElements() as $element ) {
				$element->setAttrib('disabled',true);
			}
		}
	}
}
?>