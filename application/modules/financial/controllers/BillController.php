<?php
/**
 *  Created September 6,2010
 */
class Financial_BillController extends ZFController_Controller { 
       
	/**
	 * Select the bill(s) that you are going to pay
	 */
	public function selectbillAction() {

		$unitId = $this->getRequest()->getParam('unitId');
		//	Retrieve the bills for that unit, if we fail, use cache
		$unitObj = new Unit_Model_Unit();
		$unitObj->setId( $unitId );
		$records = $unitObj->fetchUnitBills();
		$this->view->bills = $records;

		if( count($records)==0 ) {
			$message = new Messages_Model_Messages();
			$this->view->msg = array_shift( $message->findByKey( array('search'=>array('identifier'=>'nobillsforunit'),'returnClassObject'=>true)) );
		} else {
			$form = new Financial_Form_EnterPayments();			
			$this->view->form = $form;
		}

		if ( $this->getRequest()->isPost()
		and $this->_getParam('paymentType') ){
		    var_dump( $this->getRequest()->getParams() );
		}
	}

	/**
	 *  create bill - used for creating bills for individual units and testing the create bill functionality
	 */
	public function createbillAction(){
		$form = new Financial_Form_CreateBill();
		$this->view->form = $form;
	  
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ){
	   
			$formValues = $form->getValues();
			$formValues['unitId'] = $this->_getParam( 'unitId' );			

			/*
			 *  array
			 'accountLinkId' => string '1' (length=1)
			 'originalAmountDue' => string '100.11' (length=6)
			 'dueDate' => string '2009-01-01' (length=10)
			 string '5' (length=1)
			 */

			$bill = new Financial_Model_Bill();
			$bill->createBill( $formValues );
		}
	}

	//  needs to pass in apartment id in url and search on that with the unit
	public function searchunitAction() {
		// First, display the search form.
		$searchForm = new Unit_Form_SearchUnit();
		$this->view->form = $searchForm;
		//$searchForm->getElement('number')->setValue($unitNumber);
		if ( $this->getRequest()->isPost() and $this->getRequest()->getParam('number') and  $searchForm->isValid( $this->getRequest()->getParams() ) ) {
			$model = new Financial_Model_Bill();
			$records = $model->getUnitBillsByNumber( $this->getRequest()->getParam('number') );
			if( count($records)>0 ) {
				return $this->_redirect('financial/create/selectbill/unit/'.$this->getRequest()->getParam('number'));
			} else {
				$message = new Messages_Model_Messages();
				$this->view->msg = array_shift( $message->findByKey( array('search'=>array('identifier'=>'nobillsforunit'),'returnClassObject'=>true)) );
			}
		}
	}

	/**
	 *  Display single bill
	 */
	public function viewbillAction(){
		$id = $this->getRequest()->getParam('billId');
		//TODO at one point, we will like to handle this more dynamically
		$backUrl = $this->getRequest()->getParam('persist',0);
		if( $backUrl ) {
		    $this->view->returnLink = array('module'=>'applicant','controller'=>'view','action'=>'viewallapplicants','persist'=>$backUrl,'text'=>'backToPreviousPage');
		}
		
		if ( !empty ($id) ) {
			$model = new Financial_Model_Bill();
			$billData = $model->findById($id);
			if ( $billData!==null ) {
				$this->view->bill = $billData;
				$pmtObj = new Financial_Model_Payment();
				$refundObj = new Financial_Model_Refund();
				$forfeitObj = new Financial_Model_ForfeitedFee();
				$transferObj = new Financial_Model_BillTransfer();
				
		     	        $pmtObj->setBillId( $id );
				$transferObj->setFromBillId( $id );
				$transferObj->setToBillId( $id );
				
				$this->view->billCurrentDue = $billData->getCurrentAmountDue();
				$this->view->payments = $pmtObj->findByKey(array( 'search'=>array( 'billId'=>$id ) ));
				$this->view->refunds = $refundObj->findByKey(array( 'search'=>array( 'billId'=>$id ) ));
				$this->view->forfeits = $forfeitObj->findByKey(array( 'search'=>array( 'billId'=>$id ) ));
				$this->view->transfersOut = $transferObj->findByKey(array( 'search'=>array( 'fromBillId'=>$id ) ));				
			}
			else{
				$this->view->msg = $this->getMessage('noRecordFound'); 	//TODO create a error message because the record does not exists
			}	
		}
		else{
			$this->view->msg = $this->getMessage('errorSaving');   //TODO create a error message because the id is missing
		}	
	}       
} // end class