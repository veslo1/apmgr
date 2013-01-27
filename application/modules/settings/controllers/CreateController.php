<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Settings_CreateController extends ZFController_Controller {
	private static $success = "settings/index/index";

	public function indexAction() {
		$form = new Settings_Form_Create();
		$this->view->form = $form;
		if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$settings = new Settings_Model_Settings($this->getRequest()->getParams());
			$saved = $settings->save();
			$this->_redirector = $this->_helper->getHelper('Redirector');
			$this->_redirector->gotoUrl( self::$success );
		}
	}
}