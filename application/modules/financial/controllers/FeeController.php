<?php
/**
 *  Created September 6,2010
 */
class Financial_FeeController extends ZFController_Controller {

	/**
	 * Create fee
	 */
	public function createfeeAction() {
		$form = new Financial_Form_CreateFee();
		$form->setLegend( 'createFee' );
		$form->setForm();
		$this->view->form = $form;
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$fee = new Financial_Model_Fee($form->getValues());
			$result = $fee->save();
			if ($result) {
				$this->setFlashMessage('recordCreatedSuccessfully');
				$this->_helper->redirector('viewallfees', 'fee', 'financial');
			} else {
				//	TODO Generate a message showing why the insert failed
				$this->view->msg = $this->getMessage('errorSaving');
			}
		}
	}
	
	/**
	 *  Index - redirects to view all
	 */
	public function indexAction(){
		$this->_helper->redirector('viewallfees', 'fee', 'financial');	
	}

	/**
	 *  Update Fee
	 */
	public function updatefeeAction() {
		$id = $this->getRequest()->getParam('feeId');
		if ( !empty ($id) ) {
			$fee = new Financial_Model_Fee();
			$feeData = $fee->findById($id);
			if ( $feeData!==null ) {
				$form = new Financial_Form_CreateFee();
				$form->setLegend('updateFee');
				$form->setFeeId( $id );
				$form->setForm();

				//	Populate the data
				$form->setDefaults( $feeData->toArray() );
				$this->view->form = $form;

				// Saving form
				if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
					$newData = $form->getValues();
					$fee = new Financial_Model_Fee( $newData );
					$fee->setId( $feeData->getId() );
					$fee->setDateCreated( $feeData->getDateCreated() );

					$saved = $fee->save();

					if ($saved) {
						$this->setFlashMessage('recordUpdatedSuccessfully');
						$this->_helper->redirector('viewallfees', 'fee', 'financial');
					} else {
						//TODO provide a message that explains that the save couldn't be made
						$this->view->msg = $this->getMessage('errorSaving');
					}
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

	/**
	 *  View all fees
	 */
	public function viewallfeesAction() {
		$model = new Financial_Model_Fee();
		 
		$record = $model->fetchAll();

		if( $record ) {
		    $this->view->attached = $model->getAttachedFees();	
		    $this->view->paginator = $this->paginate( $record );
		}
	}

	/**
	 *  Display single fee
	 *
	 */
	public function viewfeeAction(){
		$id = $this->getRequest()->getParam('feeId');
		if ( !empty ($id) ) {
			$model = new Financial_Model_Fee();			
			$fee = $model->getFeeAndAccount( $id );
			if ( $fee!==null ) {
				$this->view->fee = $fee;				
			}
			else{
			    $this->view->msg = $this->getMessage('noRecordFound');
			}
		}
		else{
		    $this->view->msg = $this->getMessage('noRecordFound');
		}
	}
	
	/*
	 *  Delete Fee
	 */
	public function removeAction() {
		$feeId = $this->getRequest()->getParam('feeId');

		$model = new Financial_Model_Fee();
		$result = $model->delete( $feeId );				

                $this->setFlashMessage('recordDeleted');  
                $this->_helper->redirector('viewallfees', 'fee', 'financial');		
	}  // end addtounit function

} // end class