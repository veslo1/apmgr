<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Settings_UpdateController extends ZFController_Controller {
	private static $success = "settings/index/index";

	public function indexAction() {
		$setting = new Settings_Model_Settings();
		$setting = $setting->findById($this->getRequest()->getParam('id'));
		if ( null!=$setting ) {
			$form = new Settings_Form_Create();
			$form->populate($setting->toArray());
			$form->removeElement('name');
			$this->view->form = $form;
			if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) ) {
				$setting->setValue($this->getRequest()->getParam('value'));
				$setting->setId($this->getRequest()->getParam('id'));
				$saved=$setting->save();
				$this->_redirector = $this->_helper->getHelper('Redirector');
				$this->_redirector->gotoUrl( self::$success );
			}
		} else {
			$this->view->msg = $this->getMessage('settingDoesNotExists');
		}
	}
}