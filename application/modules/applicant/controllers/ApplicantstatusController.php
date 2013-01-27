<?php
/**
 * Created on September 13, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * The controller for the applicant statuses
 * </p>
 */

class Applicant_ApplicantstatusController extends ZFController_Controller {

	public function indexAction(){
	}

	/**
	 * Creates a status
	 */
	public function createstatusAction() {
		$form = new Applicant_Form_CreateApplicantStatus();
		$form->setLegend( 'createApplicantStatus' );  // set legend text since this form is shared with update
		$form->setForm();
		$this->view->form = $form;
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$status = new Applicant_Model_ApplicantStatus($form->getValues());
			$result = $status->save();
			if ($result) {
				$this->setFlashMessage('recordCreatedSuccessfully');
				$this->_helper->redirector('viewallstatuses', 'applicantstatus', 'applicant');
			} else {
				//	TODO Generate a message showing why the insert failed
				$this->view->msg = $this->getMessage('errorSaving');
			}
		}
	}

	/**
	 *  Update status
	 */
	public function updatestatusAction() {
		$id = $this->getRequest()->getParam('id');
		if ( !empty ($id) ) {
			$status = new Applicant_Model_ApplicantStatus();
			$statusData = $status->findById($id);
			if ( $statusData!==null ) {
				$form = new Applicant_Form_CreateApplicantStatus();
				$form->setLegend( 'updateApplicantStatus' );  // set legend text since this form is shared with update
				$form->setForm();

				//	Populate the data
				$form->setDefaults( $statusData->toArray() );
				$this->view->form = $form;

				// Saving form
				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
					$statusData->setName( $form->getValue('name') );
					$saved = $statusData->save();

					if ($saved) {
						$this->setFlashMessage('recordCreatedSuccessfully');
						$this->_helper->redirector('viewallstatuses', 'applicantstatus', 'applicant');
					} else {
						$this->view->msg = $this->getMessage('errorSaving');
						//TODO provide a message that explains that the save couldn't be made
					}
				} else {
					//TODO create a error message because the record does not exists
					$this->view->msg = $this->getMessage('noRecordFound');
				}
			} else {
				//TODO create a error message because the id is missing
				$this->view->msg = $this->getMessage('noRecordFound');
			}
		}
	}

	/**
	 *  View all statutses
	 */
	public function viewallstatusesAction() {
		$model = new Applicant_Model_ApplicantStatus();
		$this->view->records = $model->fetchAll('name','ASC');

		if( $this->view->records )
		$this->view->paginator = $this->paginate( $this->view->records );
	}
}
?>
