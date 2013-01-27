<?php
/**
 *  Created September 6,2010
 */
class Financial_AccountController extends ZFController_Controller {

	/**
	 *  Create Account
	 */
	public function createaccountAction() {
		$form = new Financial_Form_CreateAccount();
		$form->setLegend( 'createAccount' );  // set legend text since this form is shared with update
		$form->setForm();
		$this->view->form = $form;

		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$formValues = $form->getValues();
			$account = new Financial_Model_Account($formValues);

			$result = $account->save();

			if ($result){
				$this->setFlashMessage('recordCreatedSuccessfully');
				$this->_helper->redirector('viewallaccounts', 'account', 'financial');
			}
			else {				
				$this->view->msg = $this->getMessage('errorSaving');
			}
		}
	}

        /**
	 *  Index - redirects to view all
	 */
	public function indexAction(){
		$this->_helper->redirector('viewallaccounts', 'account', 'financial');	
	}
	
	/*
	 *  Delete Account
	 */
	public function removeAction() {
		$accountId = $this->getRequest()->getParam('accountId');

		$model = new Financial_Model_Account();
		$result = $model->delete( $accountId );				

        $this->setFlashMessage('recordDeleted');  
        $this->_helper->redirector('viewallaccounts', 'account', 'financial');		
	}  

	/**
	 *  Update account
	 */
	public function updateaccountAction() {
		$id = $this->getRequest()->getParam('accountId');
		if ( !empty ($id) ) {
			$account = new Financial_Model_Account();
			$accountData = $account->findById($id);
			if ( $accountData!==null ) {
				$form = new Financial_Form_CreateAccount();
				$form->setLegend( 'updateAccount' );  // set legend text since this form is shared with update
				$form->setForm();

				//	Populate the data
				$form->setDefaults( $accountData->toArray() );
				$this->view->form = $form;

				// Saving form
				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
					$formValues = $form->getValues();

					$formValues['id'] = $id;
					$account = new Financial_Model_Account($formValues);

					$saved = $account->save();

					if ($saved) {
						$this->setFlashMessage('recordUpdatedSuccessfully');
						$this->_helper->redirector('viewallaccounts', 'account', 'financial');
					} else {						
						$this->view->msg = $this->getMessage('errorSaving');
					}
				}

			} else {				
				$this->view->msg = $this->getMessage('noRecordFound');
			}
		} else {			
			$this->view->msg = $this->getMessage('noRecordFound');
		}
	}

	/**
	 *  Display single account
	 */
	public function viewaccountAction(){
		$id = $this->getRequest()->getParam('accountId');
		if ( !empty ($id) ) {
			$model = new Financial_Model_Account();
			//$actData = $model->findById($id);
			$model->setId( $id );
			$actData = $model->getAccount();
			if ( $actData!==null ) {
			    $this->view->account = $actData;
			}
			else {				
				$this->view->msg = $this->getMessage('noRecordFound');
			}
		} else {			
			$this->view->msg = $this->getMessage('noRecordFound');
		}
	}

	/**
	 *  Display all accounts
	 */
	public function viewallaccountsAction() {
		$model = new Financial_Model_Account();		 		
		
		$this->view->records = $model->getAccounts();

		if( $this->view->records ) {
		    $this->view->attached = $model->getAttachedAccounts();
		    $this->view->paginator = $this->paginate( $this->view->records );
		}
	}	
	
	/**
	 *  Create individual account transaction
	 */
	public function createaccounttransactionAction(){
		$form = new Financial_Form_CreateAccountTransaction();
		$this->view->form = $form;
			
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$al = new Financial_Model_AccountLink();
			$al->setCreditAccountId( $form->getValue('creditAccountId') );
			$al->setDebitAccountId( $form->getValue('debitAccountId') );
				
			$at = new Financial_Model_AccountTransaction();
			$at->setAmount( $form->getValue('amount') );
			$at->setComment( $form->getValue('comment') );
			$at->setDatePosted( $form->getValue('datePosted') );
			$at->setAccountLink( $al );

			$result = $at->saveAccountTransaction();
				
			if ($result) {
				$this->setFlashMessage('recordCreatedSuccessfully');
				$this->_helper->redirector('viewallaccounts', 'account', 'financial');
			} else {				
				$this->view->msg = $this->getMessage('errorSaving');
			}
		}
	}

	/**
	 *  Display account transactions for specified account
	 */
	public function viewaccounttransactionsAction() {
		$id = $this->_getParam('accountId');
		$this->view->accountId = $id;
	  
		if($id) {
			$model = new Financial_Model_Account();
			$actData = $model->findById($id);

			$this->view->account = $actData;
			 
			// Fetch the account transactions
			$at = new Financial_Model_AccountTransaction();
			$at->setAccountId( $id );

			$transactions = $at->getAccountTransactions();
			$balance = $at->getBalance();
			$this->view->balance = $balance;
			 
			if( $transactions ){
			    $this->view->paginator = $this->paginate($transactions);
			}
		}
		else{
			$this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
		}
	}

	/**
	 *  Displays transactions
	 */
	public function viewtransactionAction(){
		$id = $this->getRequest()->getParam('transactionId');
		$accountId = $this->getRequest()->getParam('accountId'); 
		$this->view->accountId = $accountId;
		if ( !empty ($id) && !empty($accountId)) {
			$model = new Financial_Model_AccountTransaction();
			$model->setTransactionId( $id );
			$transData = $model->getAccountTransactions();
			if ( count($transData)>0 ) {
				$this->view->transactionId = $id;
				$this->view->paginator = $this->paginate($transData);
			}
			else {
				$this->view->msg = array('msg'=>'noRecordFound','type'=>'error');  
			}
		}
		else{			
			$this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
		}
	}

} // end class