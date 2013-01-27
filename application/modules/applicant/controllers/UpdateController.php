<?php
/**
 * This action can update the status of an applicant,regarding if he is rejected or not.
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_UpdateController extends ZFController_Controller {
	/**
	 *  Change applicant's status
	 */
	public function updateapplicantstatusAction(){
		$helper = new Applicant_Library_Helper_Update($this->getRequest()->getParams());
		$this->view->applicantId = $this->getRequest()->getParam('applicantId');
		$this->view->restore = $helper->getPersist();
		if( $helper->validApplicantWorkflow() ) {
			$form = $helper->getWorkflowStatusForm();
			if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
				$saved = $helper->saveWorkflowChange($form->getValues());
				if(false!=$saved){
					$this->_helper->redirector('viewallapplicants', 'view', 'applicant');  // may need to change where this redirects
				}
			}
			$this->view->form = $form;
			$this->view->msg = array($helper->getMessageState(),'error');
		} else {
			$this->view->msg = array($helper->getMessageState(),'error');
		}
	} // end function

	/**
	 *  function to pull the update form
	 */
	private function getUpdateForm($id,$data){
		// fetch user name
		$applicantObj = new Applicant_Model_Applicant();
		$applicantObj->setId($id);
		$appUser = $applicantObj->fetchApplicantUser();

		$data['applicantName'] = $appUser['firstName'] . ' ' . $appUser['lastName'];

		$form = new Applicant_Form_ChangeApplicantWorkflowStatus();
		$form->setForm();
		$form->setDefaults($data);
		return $form;
	}

	public function bgcheckAction(){
		$helper = new Applicant_Library_Helper_Update($this->getRequest()->getParams());
		$this->view->restore = $helper->getPersist();
		if( true==$helper->validApplicant() ){
			$form = $helper->getBackgroundCheckUpdateForm();
			if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
				$updated = $helper->save($this->getRequest()->getParams());
				if($updated!=false){
					$this->_helper->redirector('viewallapplicants', 'view', 'applicant');
				}
				$this->view->msg = array($helper->getMessageState(),'error');
			}
			$this->view->form = $form;
		} else {
			$this->view->msg = array($helper->getMessageState(),'error');
		}
	}
}
?>
