<?php
/**
 * Created on Sep 21, 2009 by jvazquez
 * @name datesite
 * @package application.modules.region.controllers
 * <p>
 * Controller class for region, create page
 * </p>
 */
class Province_CreateController extends Zend_Controller_Action {

	/**
	 * Creates a region in the application
	 */
	public function indexAction() {
		$form = new Province_Form_Create();
		$this->view->form = $form;
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$region = new Province_Model_Province($form->getValues());
			$result = $region->save();
			if ($result) {
				$this->_helper->redirector('index', 'view', 'province');
			} else {
				//	TODO Generate a message showing why the insert failed
			}
		} else {
			//	TODO Generate a message showing why the insert failed
		}
	}
}
?>
