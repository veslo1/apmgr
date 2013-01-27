<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_CreateController extends ZFController_Controller {

	public function indexAction() {
		//TODO Create a the action for this
	}

	public function feeAction() {
		$form = new Applicant_Form_CreateFeeSettings();
		$this->view->form = $form;
		if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) ) {
			$applicantFeeSetting = new Applicant_Model_FeeSetting();
			$result = $applicantFeeSetting->process($this->getRequest()->getParam('feeId'));
			if(false!=$result) {
				//TODO move this to settings
				$action = 'fees';
				$controller = 'view';
				$module = 'applicant';
				$this->_helper->redirector($action,$controller,$module);
			}
		}
	}

	/**
	 *  Add Prelease Fee
	 */
	public function addpreleasefeeAction() {
		// pull fees
		$feeObj = new Financial_Model_Fee();
		$fees = $feeObj->fetchAll();

		$applicantId = $this->getRequest()->getParam('applicantId');

		// verify applicantId is valid
		$applicantObj = new Applicant_Model_Applicant();

		if( !$applicantId ){
			$this->view->messages = $this->getMessage('missingApplicantId');
		}
		elseif( !$applicantObj->findById( $applicantId ) )	{
			$this->view->messages = $this->getMessage('noRecordFound');
		}
		elseif( !$fees ) {
			$this->view->messages = $this->getMessage('noFeesFound');
		}
		else {
			$form = new Applicant_Form_AddPreleaseFee();
			$form->setApplicantId( $applicantId );
			$form->setForm( $fees );
			$this->view->form = $form;

			if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {

				$createPreleaseObj = new Applicant_Model_PreleaseFeeCreation();
				$createPreleaseObj->setApplicantId( $applicantId );
				$createPreleaseObj->setFeeId( $form->getValue('newFee') );
				$createPreleaseObj->setDueDate( $form->getValue('dueDate') );

				$apply = $form->getValue('feeBillIdToApply');
				if( !empty($apply) ){
					$createPreleaseObj->setFeeBillIdToApply( $apply );
				}

				if ( $createPreleaseObj->createPreleaseFee() ) {
					$this->setFlashMessage( 'recordCreatedSuccessfully' );
					$this->_helper->redirector('viewpreleaseapplicantfees', 'view', 'applicant', array('applicantId'=>$applicantId));
				}
				else {
					$this->view->messages = $this->getMessage($createPreleaseObj->getMessageState());
				}
			}
		}
	}

	/**
	 * Notify the applicant. This action will send an email to the applicant
	 */
	public function applicantemailAction() {
		$helper = new Applicant_Library_Helper_Create($this->getRequest()->getParams());
		$exists = $helper->applicantExists();
		$this->view->msg = array(0=>null,1=>null);
		$params = $this->getRequest()->getParams();
		$this->view->restore = $helper->getPersist();

		if( $exists ) {
			$form = $helper->initFormApplicant();
			if( $this->getRequest()->isPost() and $form->isValid($params) ) {
				if( $helper->dispatchEmailApplicant($params) ) {
					$this->_helper->redirector('viewallapplicants', 'view', 'applicant');
				}
				$this->view->msg = array($helper->getMessageState(),'error');
			}
			$this->view->form = $form;
		} else {
			$this->view->msg = array('applicantIdMissing','error');
		}
	}

	/**
	 * This action will deliver an email to a user in a waitlist.
	 * The validation logic requires that the user is on waitlist
	 */
	public function waitlistemailAction(){
		$helper = new Applicant_Library_Helper_Create($this->getRequest()->getParams());
		$exists = $helper->userExists();
		$this->view->msg = array(0=>null,1=>null);
		$params = $this->getRequest()->getParams();
		$this->view->restore = 1;

		if( $exists ) {
			$form = $helper->initFormWaitlist();
			if( $this->getRequest()->isPost() and $form->isValid($params) ) {
				if( $helper->dispatchEmailApplicant($params) ) {
					$this->_helper->redirector('waitlist', 'view', 'applicant');
				}
				$this->view->msg = array($helper->getMessageState(),'error');
			}
			$this->view->form = $form;
		} else {
			$this->view->msg = array('userIdMissing','error');
		}
	}
	
	/**
	 *  Fetch applicant bills for manual payment
	 */
	public function selectapplicantbillsAction(){				
		$applicantId = $this->getRequest()->getParam('applicantId'); 	
		
		$applicantObj = new Applicant_Model_Applicant();
		$applicantItem = $applicantObj->findById( $applicantId );
		
		if( $applicantItem ) {			
		    $applicantBillsObj = new Applicant_Library_ManualBillHelper();
	            $preleaseBillsObj = new Applicant_Model_Prelease();	      
	            $bills = $applicantBillsObj->fetchManualBillsToPay( $applicantId );
		    $preleaseBillsObj->setApplicantId($applicantId);
	            $preleaseBills = $preleaseBillsObj->fetchManualBillsToPay();		
	            
		    if( empty($bills) && empty($preleaseBills) ) {
			$this->view->msg = $this->getMessage( 'noBillsDue' );
		    }
		    else {		
		        $form = new Applicant_Form_PayApplicantBillsManual();		   		        
		        $form->setForm( $bills, $preleaseBills );
		        $this->view->form = $form;
			
			if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {				
				$requestBills = $this->getRequest()->getParam('applicantBills');				
				$requestPreleaseBills = $this->getRequest()->getParam('preleaseBills');							
				
				$appBillArray = array();
				$preleaseBillArray = array();
				
				if( $requestBills ) {									
					foreach( $requestBills as $id=>$rowId ){
						$appBillArray[$rowId] = $bills[$rowId];
					}				
				}
				
				if( $requestPreleaseBills ) {																			
					foreach( $requestPreleaseBills as $id=>$rowId ){
						$preleaseBillArray[$rowId] = $preleaseBills[$rowId];
					}					
				}				
				$billSession = new Zend_Session_Namespace('payApplicantBills');
		                $billSession->initialized = true;
				$billSession->bills = $appBillArray;
				$billSession->preleaseBills = $preleaseBillArray;				
																
				$this->_helper->redirector('payapplicantbills', 'create', 'applicant', array('applicantId'=>$applicantId));				
			}			
		    }	
		}
		else {
			$this->view->msg = $this->getMessage( 'noRecordFound' );
		}		
	}
	
	/**
	 *  pay applicant bills for manual payment
	 */
	public function payapplicantbillsAction(){		
		$applicantId = $this->getRequest()->getParam('applicantId');
		
		$applicantObj = new Applicant_Model_Applicant();
		$applicantItem = $applicantObj->findById( $applicantId );
		
		if( $applicantItem ) {
			$billSession = new Zend_Session_Namespace('payApplicantBills');			
			$bills = $billSession->bills;
			$preleaseBills = $billSession->preleaseBills;			
			 						
			if( empty($bills) && empty($preleaseBills) ){
		            $this->view->msg = $this->getMessage( 'missingBills' );			    
			}   			
			else{
			    	
			    $paymentHelper = new Applicant_Library_ManualBillHelper();
			    // sum the bill amounts
			    $sum = $paymentHelper->getBillSum( $bills, $preleaseBills ); // no check for 0 in case the fee amount = 0
			    			    
			    $form = new Financial_Form_EnterPayments();    
			    $form->setSum( $sum );
			    $form->setForm();			
			    $this->view->form = $form;
			    
			    if( $this->getRequest()->getParam('next') ){
			        if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			            $billSession->paymentInfo = $this->getRequest()->getParams();
				    $this->_helper->redirector('payapplicantbillconfirmation', 'create', 'applicant', array('applicantId'=>$applicantId));
			        }
			    }
			    
			    if( $this->getRequest()->getParam('previous') ){
				$this->_helper->redirector('selectapplicantbills', 'create', 'applicant', array('applicantId'=>$applicantId));
			    }			    
			}			
		}
		else {
			$this->view->msg = $this->getMessage( 'noRecordFound' );
		}
	}
	
	/**
	 *  confirm applicant bills for manual payment
	 */
	public function payapplicantbillconfirmationAction(){
		$applicantId = $this->getRequest()->getParam('applicantId');
		
		$applicantObj = new Applicant_Model_Applicant();
		$applicantItem = $applicantObj->findById( $applicantId );
		
		if( $applicantItem ) {		
		    $billSession = new Zend_Session_Namespace('payApplicantBills');			
			
		    $bills = $billSession->bills;
		    $preleaseBills = $billSession->preleaseBills;
		    $paymentInfo = $billSession->paymentInfo;				
				
		    $this->view->bills = $bills;
		    $this->view->preleaseBills = $preleaseBills;
		    $this->view->paymentInfo = $paymentInfo;
		
		    $form = new Unit_Form_Confirmation();
		    $form->setForm( array('next'=>'finish') );
		    $this->view->form = $form;
		
		    if( $this->getRequest()->getParam('previous') ){
			$this->_helper->redirector('payapplicantbills', 'create', 'applicant', array('applicantId'=>$applicantId));
		    }			    	    		    
		   				    
		    if( $this->getRequest()->getParam('next') ){
		        if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ){
			    $paymentHelper = new Applicant_Library_ManualBillHelper();	
		            if( $paymentHelper->payBills( $paymentInfo, $bills, $preleaseBills ) ) {
				if( $preleaseBills ){
			            $this->_helper->redirector('viewpreleaseapplicantfees', 'view', 'applicant', array('applicantId'=>$applicantId));
				}
				else{
				    $this->_helper->redirector('viewfeespaid', 'view', 'applicant', array('applicantId'=>$applicantId));
				}	
			    }
			    else{
				$this->view->msg = $this->getMessage( 'errorSaving' );
			    }
		        } 	
		    }		    
		}
		else {
			$this->view->msg = $this->getMessage( 'noRecordFound' );
		}
	}	
}