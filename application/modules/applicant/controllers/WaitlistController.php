<?php
/**
 * Handle the communication between the user that wants to log in and apply for a house
 *
 * @author jvazquez
 */
class Applicant_WaitlistController extends ZFController_Controller implements ZFObserver_ILogeable {

	/**
	 * The main action for applicant that is applying to a unit or a wait list
	 */
	public function indexAction() {
		$id = $this->getRequest()->getParam('model');
		$unitModel = new Unit_Model_UnitModel();
		$exists = $unitModel->exists(array('table'=>'unitModel','column'=>'id'),$id);

		if( true==$exists ) {
			$form = new Default_Form_Authenticated();
			if( $this->getRequest()->isPost() and $form->isValid( $this->getRequest()->getParams() )) {
				$helper = new Applicant_Library_WaitListHelper();
				$helper->initSession();
				$orders = $helper->waitListCommand($this->getRequest()->getParams());
				$this->_redirector = $this->_helper->getHelper('Redirector');
				$this->_redirector->gotoUrl(join('/',array($orders['module'],$orders['controller'],$orders['action']) ) );
			}
			$this->view->form = $form;
		} else {
			$this->view->msg = $this->getMessage('haveId');
		}
	}

	/**
	 * Apply a user to the waitlist after he went through the workflow
	 */
	public function applyAction() {
		$workflowHelper = new Applicant_Library_WaitListHelper();
		$applied = false;
		if( $workflowHelper->isActive($workflowHelper->getSessionNameSpace()) ) {
			$userWaitList = new Applicant_Model_UserWaitList();
			$userId = $workflowHelper->getSessionStepsKey('userid');
			$modelId = $workflowHelper->getSessionStepsKey('modelId');
			$userWaitList->setUserId($userId);
			$userWaitList->setModelId($modelId);
			try {
				$applied=$userWaitList->save();
				$workflowHelper->terminateSession();
				//$this->view->msg = $applied!=false ? $this->getMessage('userAppliedToWaitlist') : $this->getMessage('errorSaving');				
				if( $applied!=false ) {
				    $this->view->msg = 'userAppliedToWaitlist';
				    $this->view->type = 'success';
				}
				else{
				    $this->view->msg = 'errorSaving';
				    $this->view->type = 'error';
				}				
			} catch (Exception $e) {
				$helper = new Applicant_Library_Helper_Apply();
				$helper->logFails($this, $e, __FUNCTION__);
				//$this->view->msg = $this->getMessage('errorSaving');
				$this->view->msg = 'errorSaving';
				$this->view->type = 'error';
			}
		}
	}

	/**
	 *@return string
	 */
	public function __toString()
	{
		return "WaitlistApply";
	}
}
?>