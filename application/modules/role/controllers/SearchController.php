<?php
/**
 * Created on Sep 13, 2009
 * SearchController.php
 * @author jvazquez
 * @package modules.role.controllers
 * <p>
 * Handles the Search Controller
 * </p>
 */

class Role_SearchController extends ZFController_Controller {

	public function indexAction() {
		$form = new Role_Form_Search();
		if( $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams()) ) {
			$role = new Role_Model_Role();
			$this->view->records =  $role->findByKey('name',$this->getRequest()->getParam('name'));
		} else {
			$this->view->message = "";
		}
		$this->view->form = $form;
	}
}
?>
