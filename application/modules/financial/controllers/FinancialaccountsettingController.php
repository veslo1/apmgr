<?php
/**
 *  Created September 6,2010
 */
class Financial_FinancialaccountsettingController extends ZFController_Controller {

        /**
	 *  Index - redirects to view all
	 */
	public function indexAction(){
		$this->_helper->redirector('viewallfinancialaccountsettings', 'financialaccountsetting', 'financial');	
	} 

	/**
	 *  Update financial account fee setting
	 */
	public function updatefinancialaccountsettingAction() {
		$id = $this->getRequest()->getParam('id');  // id of setting to edit
		$fasObj = new Financial_Model_FinancialAccountSetting();
		$fasItem = $fasObj->findById( $id );

		if($fasItem) {
			$form = new Financial_Form_UpdateFinancialAccountSetting();
			$form->populateValues( $fasItem->toArray() );
			$this->view->form = $form;
		}
		else{
			$this->view->msg = $this->getMessage('settingDoesNotExists');
		}
	  
		if ( $this->getRequest()->isPost()
		and $form->isValid($this->getRequest()->getParams())  ) {
				
		 $formValues = $form->getValues();
		 $fasItem->setAccountId( $formValues['accountId'] );
		 $saved = $fasItem->save();

		 if ($saved) {
		 	$this->_helper->redirector('viewallfinancialaccountsettings', 'financialaccountsetting', 'financial');
		 }
		 else{
		 	$this->view->msg = $this->getMessage('errorSaving');
		 }
		}
	}

	/**
	 *  Display all financial account settings
	 */
	public function viewallfinancialaccountsettingsAction() {
		$model = new Financial_Model_FinancialAccountSetting();
	 $this->view->records = $model->fetchAll();

	 if( $this->view->records )
	 $this->view->paginator = $this->paginate( $this->view->records );
	}
	/**
	 *  Display single financial account setting
	 */
	public function viewfinancialaccountsettingAction(){
		$id = $this->getRequest()->getParam('id');
		if ( !empty ($id) ) {
			$model = new Financial_Model_FinancialAccountSetting();
			$data = $model->findById($id);
			if ( $data!==null )
			$this->view->record = $data;
		}
	}

} // end class