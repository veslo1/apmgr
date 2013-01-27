<?php
/**
 *  Created September 6,2010
 */
class Financial_AccountlinkController extends ZFController_Controller {

	/**
	 *  Form for selecting the account link for the bill
	 */
	public function createaccountlinkAction(){
		$form = new Financial_Form_CreateAccountLink();
		$this->view->form = $form;

		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$formValues = $form->getValues();
			$accountLink = new Financial_Model_AccountLink($formValues);
			$result = $accountLink->save();

			if ($result){
				$this->setFlashMessage('recordCreatedSuccessfully');
				$this->_helper->redirector('viewallaccountlinks', 'accountlink', 'financial');
			}
			else {
				//	TODO Generate a message showing why the insert failed
				$this->view->msg = $this->getMessage('errorSaving');
			}
		}
	}
	
	/**
	 *  Index - redirects to view all
	 */
	public function indexAction(){
		$this->_helper->redirector('viewallaccountlinks', 'accountlink', 'financial');	
	}
	

	/**
	 *  Form for selecting the account link for the bill
	 */
	public function updateaccountlinkAction(){
		$id = $this->getRequest()->getParam('accountLinkId');

		if ( !empty ($id) ) {
			$alModel = new Financial_Model_AccountLink();
			$alData = $alModel->findById($id);

			if ( $alData!==null ) {
				$this->view->data = $alData;
				$form = new Financial_Form_CreateAccountLink();
				$form->setLegend('updateAccountLink');
				$form->setForm();

				//	Populate the data on the form
				$data=$alData->toArray();
				$data['name'] = $form->getTranslator()->translate($data['name']);				
				$form->setDefaults($data);
				$this->view->form = $form;

				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
					$formValues = $form->getValues();
					$formValues['id'] = $id;
					$accountLink = new Financial_Model_AccountLink($formValues);
					$result = $accountLink->save();

					if ($result){
						$this->setFlashMessage('recordUpdatedSuccessfully');
						$this->_helper->redirector('viewallaccountlinks', 'accountlink', 'financial');
					}
					else {
						//	TODO Generate a message showing why the insert failed
						$this->view->msg = $this->getMessage('errorSaving');
					}
				}
			}
		}
	}

	/**
	 *  Form for selecting the account link for the bill
	 */
	public function updatefeeaccountlinkAction(){
		$id = $this->getRequest()->getParam('feeId');

		if ( !empty ($id) ) {
			$feeModel = new Financial_Model_Fee();
			$feeData = $feeModel->findById($id);

			if ( $feeData!==null ) {
				$this->view->data = $feeData;
				$form = new Financial_Form_CreateFee();
				$form->setLegend( 'updateFee' );
				$form->setForm();

				//	Populate the data on the form
				$form->setDefaults($feeData->toArray());
				$this->view->form = $form;

				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
					$formValues = $form->getValues();
					$formValues['id'] = $id;
					$fee = new Financial_Model_Fee($formValues);
					$result = $fee->save();

					if ($result){
						$this->setFlashMessage('recordUpdatedSuccessfully');
						$this->_helper->redirector('viewallaccountlinks', 'accountlink', 'financial');
					}
					else {
						//	TODO Generate a message showing why the insert failed
						$this->view->msg = $this->getMessage('errorSaving');
					}
				}
			}
		}
	}

	/**
	 *  Display all account links
	 */
	public function viewallaccountlinksAction() {
		$model = new Financial_Model_AccountLink();
		$feeModel = new Financial_Model_Fee();		
		 
		$this->view->fee = $feeModel->getFeeAndAccount();		
	  
		$this->view->records = $model->fetchAllAccountLinks();
		 
		if( $this->view->records ) {
		    $this->view->paginator = $this->paginate( $this->view->records );
		}
	}


} // end class