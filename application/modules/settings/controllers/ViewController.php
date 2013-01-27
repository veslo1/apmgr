<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Settings_ViewController extends ZFController_Controller {

	public function indexAction() {
		$this->getFlashMessages();
		$settings = new Settings_Model_Settings();
		$column = $this->getRequest()->getParam('column');
		$sort = $this->getRequest()->getParam('sort');
		$this->view->settings = $this->paginate($settings->fetchAll($column, $sort,true));
		$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
	}

	public function viewAction() {
		if( $this->getRequest()->getParam('id') ) {
			$settings = new Settings_Model_Settings();
			$setting = $settings->findById($this->getRequest()->getParam('id'));
			if( empty($setting) ) {
				$this->view->msg = $this->getMessage('settingDoesNotExists');
			} else {
				$this->view->setting = $setting;
			}

		} else {
			$this->view->msg = $this->getMessage('settingDoesNotExists');
		}
	}
}