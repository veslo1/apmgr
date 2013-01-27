<?php
/**
 * Description of DeleteController
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_DeleteController extends ZFController_Controller {

	public function feeAction() {
		$id = $this->getRequest()->getParam('id');
		$applicantFeeSetting = new Applicant_Model_FeeSetting();

		if( $applicantFeeSetting->exists(array('column'=>'id','table'=>'applicantFeeSetting'),$id)==true ) {
			$form = new Applicant_Form_DeleteFeeSetting();
			//	We don't validate, or you send yes or no
			if( $this->getRequest()->isPost() ) {
				//	If we confirm that we will delete, then proceed
				if( $this->getRequest()->getParam('delete')==Applicant_Form_DeleteFeeSetting::CONFIRMDELETE ) {
					$deleted = $applicantFeeSetting->delete($id);
					if( false!==$deleted ) {
						$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
						$this->_redirector = $this->_helper->getHelper('Redirector');
						$this->_flashMessenger->addMessage( 'settingDeleted' );
						//TODO move this to settings
						$action = 'fees';
						$controller = 'view';
						$module = 'applicant';
						$this->_helper->redirector($action,$controller,$module);
					}
					$this->view->msg = $this->getMessage('errorSettingDelete');
				} else {
					//	Just go back to the view
					//TODO move this to settings
					$action = 'fees';
					$controller = 'view';
					$module = 'applicant';
					$this->_helper->redirector($action,$controller,$module);
				}
			}
			$this->view->form = $form;
		} else {
			$this->view->msg = $this->getMessage('resourceExist');
		}
	}
}
?>