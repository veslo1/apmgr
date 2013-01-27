<?php
/**
 * Created on September 4, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * The controller for the apartment actions
 * </p>
 */

class Unit_LeaseController extends ZFController_Controller {

	public function indexAction(){
	}

	/**
	 *  Create Individual Lease Fee
	 */
	public function createleasefeeAction() {
		$leaseId = $this->getRequest()->getParam('leaseId');
		$this->view->leaseId = $leaseId;
		
		if ( empty ($leaseId) ) {
		    $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');		    
		}
		else {		   			    
		    // check that fees exist
		    $feeObj = new Financial_Model_Fee();
		    $fees = $feeObj->fetchAll();

		     if( !$fees ) {			
			$this->view->msg = array( 'msg'=>'noFeesFound', 'type'=>'error' );
		     }
		     else {
			$form = new Unit_Form_CreateLeaseFee();
			$form->setForm( $fees );
			$this->view->form = $form;

			if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
				$leaseFeeObj  = new Unit_Model_LeaseFee();

				$leaseFeeObj->setLeaseId( $leaseId );
				$leaseFeeObj->setFeeId( $form->getValue('newfee') );
				$leaseFeeObj->setDueDate( $form->getValue('dueDate') );
				$result = $leaseFeeObj->createLeaseFee();

				if ( $result) {
				    $this->_helper->redirector('viewlease', 'lease', 'unit', array('leaseId'=>$leaseId));
				}
				else {				   
				    $this->view->msg = array( 'msg'=>'errorCreatingRecord', 'type'=>'error' );	
				}
			}
		     }	
		}
	}	

	/**
	 * cancels the lease
	 */
	public function cancelleaseAction() {
		$form = new Unit_Form_CancelLease();
		$this->view->form = $form;

		if ( $this->getRequest()->isPost()
		and $form->isValid($this->getRequest()->getParams()) ) {

			$leaseModel = new Unit_Model_Lease();
			$leaseId = $this->getRequest()->getParam('leaseId');

			$leaseRow = $leaseModel->findById( $leaseId );
			$leaseRow->setLastDay( $form->getValue('cancellationLastDay') );
                        $leaseRow->setCancelComment( $form->getValue('cancelComment') );
                    
			$cancelled = $leaseRow->cancelLease();

			if ($cancelled) {				
				$this->_helper->redirector('viewleaselist', 'lease', 'unit', array('unitId'=>$leaseRow->getUnitId()));
			}
			else {
				$this->view->message = array( 'msg'=>$leaseRow->getMessageState(), 'type'=>'error' );				
			}
		}
	}		

	/**
	 * View lease details for a single lease	 
	 *
	 *  unit number
	 *  tenants
	 *  lease discounts
	 *  monthly rent	 
	 */
	public function viewleaseAction() {
		$leaseId = $this->getRequest()->getParam('leaseId');

		// lease model with start/end dates
		$leaseModel = new Unit_Model_Lease();
		$this->view->lease = $leaseRow = $leaseModel->findById( $leaseId );
		
		// Fees		
		$helper = new Unit_Library_LeaseHelper();
		$this->view->fees = $helper->getLeaseFees( $leaseId );

		// lease schedule with discounts
		$leaseScheduleModel = new Unit_Model_LeaseSchedule();
		$this->view->leaseSchedule = $leaseScheduleModel->findByKey( array( 'search'=>array('leaseId'=>$leaseId)) );

		// base model price.
		$modelRentScheduleItem = new Unit_Model_ModelRentScheduleItem();
		$this->view->modelRentScheduleItem = $modelRentScheduleItem->findById( $leaseRow->getModelRentScheduleItemId() );

		//tenants
		$tenantModel = new Unit_Model_Tenant();
		$tenantModel->setLeaseId( $leaseId );
		$this->view->tenants = $tenantModel->getTenants();
	}

	/**
	 *  Display grid with current lease info, and past lease info and buttons to add new lease or cancel lease
	 **/
	public function viewleaselistAction() {
		$unitId = $this->getRequest()->getParam('unitId');

		$leaseModel = new Unit_Model_Lease();
		$leaseModel->setUnitId( $unitId );

		$this->view->unitId = $unitId;
		$this->view->current = $leaseModel->fetchCurrentPendingLeases();
		$this->view->history = $leaseModel->fetchLeaseHistory();
	}
	
	/**
	 *  the following three functions are used in lease fee and rent payment
	 */
	
	/**
	 *  Fetch lease bills for manual payment
	 */
	public function selectleasebillsAction(){				
		$leaseId = $this->getRequest()->getParam('leaseId'); 	
		
		if ( empty ($leaseId) ) {
		    $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
		}
		else {
		    $this->view->leaseId = $leaseId;	
		    $leaseObj = new Unit_Model_Lease();
		    $leaseItem = $leaseObj->findById( $leaseId );
		
		    if( $leaseItem ) {			
		        $leaseHelper = new Unit_Library_ManualBillHelper();	                  
	                $leaseFees = $leaseHelper->fetchLeaseFeesToPay( $leaseId );		   
		        $leaseRentBills = $leaseHelper->fetchLeaseRentToPay( $leaseId );		    	            
		    
		        if( empty($leaseFees) && empty($leaseRentBills) ) {
			    $this->view->msg = array('msg'=>'noBillsDue','type'=>'error');
		        }
		        else {			
		            $form = new Unit_Form_PayRentBillsManual();		   		        
		            $form->setForm( $leaseRentBills, $leaseFees );
		            $this->view->form = $form;
			
			    if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {				
				$requestRentBills = $this->getRequest()->getParam('rentBills');				
				$requestLeaseFeeBills = $this->getRequest()->getParam('leaseFeeBills');							
				
				// check if empty
				if( empty($requestRentBills) && empty($requestLeaseFeeBills) ) {
					$this->view->msg = array('msg'=>'missingBillSelection','type'=>'error');
				}
				else {				
				    $rentBillArray = array();
				    $leaseFeeBillArray = array();								
												
				    if( $requestRentBills ) {									
					foreach( $requestRentBills as $id=>$rowId ){
						$rentBillArray[$rowId] = $leaseRentBills[$rowId];
					}				
				    } 
				
				    if( $requestLeaseFeeBills ) {																			
					foreach( $requestLeaseFeeBills as $id=>$rowId ){
						$leaseFeeBillArray[$rowId] = $leaseFees[$rowId];
					}					
				    }								
				
				    $billSession = new Zend_Session_Namespace('payLeaseBills');
		                    $billSession->initialized = true;
				    $billSession->rentBills = $rentBillArray;
				    $billSession->leaseFeeBills = $leaseFeeBillArray;																				
				    $this->_helper->redirector('payleasebills', 'lease', 'unit', array('leaseId'=>$leaseId));
				}    
			    }			
		        }
		    
		    }
		    else {
			$this->view->msg = $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
		    }
		}    
	}
	
	/**
	 *  pay lease bills for manual payment
	 */
	public function payleasebillsAction(){		
		$leaseId = $this->getRequest()->getParam('leaseId'); 	
		
		if ( empty ($leaseId) ) {
		    $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
		}
		else {
		    $leaseObj = new Unit_Model_Lease();
		    $leaseItem = $leaseObj->findById( $leaseId );
		
		    if( $leaseItem ) {			
		        $leaseHelper = new Unit_Library_ManualBillHelper();       
		        $billSession = new Zend_Session_Namespace('payLeaseBills');			
		        $leaseRentBills = $billSession->rentBills;
		        $leaseFees = $billSession->leaseFeeBills;	
		    
		        if( empty($leaseFees) && empty($leaseRentBills) ) {
			    $this->view->msg = array('msg'=>'noBillsDue','type'=>'error');
		        }			
		        else{								        
			    // sum the bill amounts
			    $sum = $leaseHelper->getBillSum( $leaseRentBills, $leaseFees ); // no check for 0 in case the fee amount = 0			
						    			    
			    $form = new Financial_Form_EnterPayments();    
			    $form->setSum( $sum );
			    $form->setForm();			
			    $this->view->form = $form;
			    
			    if( $this->getRequest()->getParam('next') ){
			        if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			            $billSession->paymentInfo = $this->getRequest()->getParams();
				    $this->_helper->redirector('payleasebillconfirmation', 'lease', 'unit', array('leaseId'=>$leaseId));
			        }
			    }
			    
			    if( $this->getRequest()->getParam('previous') ){
			        $this->_helper->redirector('selectleasebills', 'lease', 'unit', array('leaseId'=>$leaseId));
			    }			
		        }			
		    }
		    else {
			$this->view->msg = $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
		    }
		}    
	}
	
	/**
	 *  confirm applicant bills for manual payment
	 */
	public function payleasebillconfirmationAction(){
		$leaseId = $this->getRequest()->getParam('leaseId'); 	
		
		if ( empty ($leaseId) ) {
		    $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
		}
		else {
		    $leaseObj = new Unit_Model_Lease();
		    $leaseItem = $leaseObj->findById( $leaseId );
		
		    if( $leaseItem ) {		
		        $billSession = new Zend_Session_Namespace('payLeaseBills');			
			
		        $leaseRentBills = $billSession->rentBills;
		        $leaseFees = $billSession->leaseFeeBills;
		        $paymentInfo = $billSession->paymentInfo;				
				
		        $this->view->rentBills = $leaseRentBills;
		        $this->view->leaseFeeBills = $leaseFees;
		        $this->view->paymentInfo = $paymentInfo;
		
		        $form = new Unit_Form_Confirmation();
		        $form->setForm( array('next'=>'finish') );
		        $this->view->form = $form;
		
		        if( $this->getRequest()->getParam('previous') ){
			    $this->_helper->redirector('payleasebills', 'lease', 'unit', array('leaseId'=>$leaseId));
		        }			    	    		    
		   				    
		        if( $this->getRequest()->getParam('next') ){
		            if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ){
			        $leaseHelper = new Unit_Library_ManualBillHelper(); 	
		                    if( $leaseHelper->payBills( $paymentInfo, $leaseRentBills, $leaseFees ) ) {				
			                $this->_helper->redirector('viewlease', 'lease', 'unit', array('leaseId'=>$leaseId));			
			            }
			            else{
				        $this->view->msg = $this->view->msg = array('msg'=>'errorSaving','type'=>'error');
			            }
		             } 	
		        }		    
		     }
		     else {
			$this->view->msg = $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
		     }
		}     
	}	

        /**
	 *  view all documents
	 */
	public function viewalldocumentsAction(){
		$leaseId = $this->getRequest()->getParam('leaseId');		
		$leaseHelper = new Unit_Library_LeaseHelper();
		$this->view->document = $leaseHelper->fetchLeaseDocuments( $leaseId );
		$this->view->leaseId = $leaseId;
	}
	
	/**
	 *  view mylease documents - for tenants
	 */
	public function viewmyleasedocumentsAction(){
		$leaseId = $this->getRequest()->getParam('leaseId');		
		$leaseHelper = new Unit_Library_LeaseHelper();
		$this->view->document = $leaseHelper->fetchLeaseDocuments( $leaseId );
		$this->view->leaseId = $leaseId;
	}
	
	/**
	 *  view document
	 */
	public function viewdocumentAction(){
		$id = $this->getRequest()->getParam('id');		
		$helper = new File_Library_FileHelper();
		$doc = $helper->getFile($id);
				
		if( $doc ) {
		    $this->_helper->layout()->disableLayout();
		    $this->_helper->viewRenderer->setNoRender(true);
		    
		    $name = $doc['name'];
                    $type = $doc['type'];
                    $file = $doc['fullPath'];
		    
		    header("Cache-Control: must-revalidate");
                    header("Pragma: must-revalidate");
                    header("Content-disposition: attachment; filename=\"{$name}\"");
                    header("Content-Type: {$type}");
		    echo readfile( $doc['fullPath'] );		    
		}
		else {
			$leaseId = $this->getRequest()->getParam('leaseId');			
			$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');			
			$this->_flashMessenger->addMessage($helper->getMessageState());			
			$this->_helper->redirector('viewalldocuments', 'lease', 'unit', array('leaseId'=>$leaseId));			
		}
	}
	
	/**
	 *  view my lease document
	 */
	public function viewmyleasedocumentAction(){
		$id = $this->getRequest()->getParam('id');		
		$helper = new File_Library_FileHelper();
		$doc = $helper->getFile($id);
				
		if( $doc ) {
		    $this->_helper->layout()->disableLayout();
		    $this->_helper->viewRenderer->setNoRender(true);
		    
		    $name = $doc['name'];
                    $type = $doc['type'];
                    $file = $doc['fullPath'];
		    
		    header("Cache-Control: must-revalidate");
                    header("Pragma: must-revalidate");
                    header("Content-disposition: attachment; filename=\"{$name}\"");
                    header("Content-Type: {$type}");
		    echo readfile( $doc['fullPath'] );		    
		}
		else {
			$leaseId = $this->getRequest()->getParam('leaseId');			
			$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');			
			$this->_flashMessenger->addMessage($helper->getMessageState());			
			$this->_helper->redirector('viewmyleasedocuments', 'lease', 'unit', array('leaseId'=>$leaseId));			
		}
	}
	
	/**
	 *  view document
	 */
	public function viewevictiondocumentAction(){
		$id = $this->getRequest()->getParam('id');		
		$helper = new File_Library_FileHelper();
		$doc = $helper->getFile($id);
				
		if( $doc ) {
		    $this->_helper->layout()->disableLayout();
		    $this->_helper->viewRenderer->setNoRender(true);
		    
		    $name = $doc['name'];
                    $type = $doc['type'];
                    $file = $doc['fullPath'];
		    
		    header("Cache-Control: must-revalidate");
                    header("Pragma: must-revalidate");
                    header("Content-disposition: attachment; filename=\"{$name}\"");
                    header("Content-Type: {$type}");
		    echo readfile( $doc['fullPath'] );		    
		}
		else {
			
			$evictionId = $this->getRequest()->getParam('evictionId');			
			$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');			
			$this->_flashMessenger->addMessage($helper->getMessageState());		
			$this->_helper->redirector('viewallevictiondocuments', 'lease', 'unit', array('evictionId'=>$evictionId));					
		}
	}
	
	/**
	 *  Delete document
	 */
	public function deletedocumentAction(){
		$id = $this->getRequest()->getParam('id');
		$leaseId = $this->getRequest()->getParam('leaseId');
		$helper = new File_Library_FileHelper();
		$type='error';
		if( $helper->deleteFile($id) ) {
			$type = 'success';
		}					
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->_flashMessenger->addMessage($helper->getMessageState());
		$this->_helper->redirector('viewalldocuments', 'lease', 'unit', array('leaseId'=>$leaseId));
	}
	
	/**
	 *  Delete document
	 */
	public function deleteevictiondocumentAction(){
		$id = $this->getRequest()->getParam('id');
		$evictionId = $this->getRequest()->getParam('evictionId');
		$helper = new File_Library_FileHelper();
		$type='error';
		if( $helper->deleteFile($id) ) {
			$type = 'success';
		}					
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->_flashMessenger->addMessage($helper->getMessageState());
		$this->_helper->redirector('viewallevictiondocuments', 'lease', 'unit', array('evictionId'=>$evictionId));
	}
	
	/**
	 *  Add document to lease
	 */
	public function adddocumentAction(){		
		$helper = new Unit_Library_LeaseDocumentHelper();
		$leaseId = $this->getRequest()->getParam('leaseId');
		$this->view->leaseId = $leaseId;
		$valid = $helper->validateLeaseId($leaseId);		
		if( $valid )
		{			
			$helper->setProperties(APPLICATION_PATH.'/modules/unit/config/leaseConfig.ini',APPLICATION_ENV);			
			try
			{				
				$form = $helper->getAddPictureForm();				
				if( $this->getRequest()->isPost() and $form->isValid( $this->getRequest()->getParams() ) )
				{
					$result = $helper->transferFile(array('form'=>$form,'leaseId'=>$leaseId,'description'=>$this->getRequest()->getParam('description')));
					if( $result )
					{
						$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
						$this->_flashMessenger->addMessage( array('msg'=>'fileCreated','type'=>'success'));
						$this->_helper->redirector('viewalldocuments', 'lease', 'unit', array('leaseId'=>$leaseId));
					}
					else {
					    $this->view->msg = $helper->getMessageState();
					}
				}
				$this->view->form = $form;
			}
			catch(Zend_File_Transfer_Exception $e)
			{
				$this->view->msg = 'notWrittableError';
			}
		}
		$this->view->msg = $helper->getMessageState();
	}
	
	/**
	 *  Used for tenant to pull the current user's lease info
	 */
	public function myleaselistAction() {		
		$helper = new Unit_Library_LeaseHelper();
		$current = $helper->fetchMyCurrentLeases();
		$this->view->current = $current;
		$history = $helper->fetchMyLeaseHistory();
		$this->view->history = $history;
	}
	
	/**
	 * View lease details for a tenant	 	 	 
	 */
	public function myleaseAction() {
		$leaseId = $this->getRequest()->getParam('leaseId');		
		$helper = new Unit_Library_LeaseHelper();
		
		$leaseModel = new Unit_Model_Lease();		
		$leaseRow = $leaseModel->findById( $leaseId );
		
		if( $helper->verifyMyLease($leaseId) && !empty( $leaseRow )) {
		    // lease model with start/end dates		    					
		    $this->view->lease = $leaseRow;		   
		    $this->view->fees = $helper->getLeaseFees( $leaseId );

		    // lease schedule with discounts
		    $leaseScheduleModel = new Unit_Model_LeaseSchedule();
		    $this->view->leaseSchedule = $leaseScheduleModel->findByKey( array( 'search'=>array('leaseId'=>$leaseId)) );

		    // base model price.
		    $modelRentScheduleItem = new Unit_Model_ModelRentScheduleItem();
		    $this->view->modelRentScheduleItem = $modelRentScheduleItem->findById( $leaseRow->getModelRentScheduleItemId() );

		    //tenants
		    $tenantModel = new Unit_Model_Tenant();
		    $tenantModel->setLeaseId( $leaseId );
		    $this->view->tenants = $tenantModel->getTenants();
		}
		else {			
			$this->view->msg = $this->getMessage('noRecordFound');
		}
	}
	
	 /**
	 *  Display single bill for tenant
	 */
	public function viewmyleasebillAction(){		
		$id = $this->getRequest()->getParam('billId');		
		$helper = new Unit_Library_LeaseHelper();		 		
		$leaseId=$helper->verifyLeaseBill( $id );
		if ( !empty ($id) && $leaseId ) {
			$this->view->leaseId = $leaseId;
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
				$this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
			}	
		}
		else{
			$this->view->msg = array('msg'=>'noRecordFound','type'=>'error');
		}	
	}
	
	/**
	 *  View tenant payments
	 */
	public function viewmypaymentsAction(){
		$id = $this->getRequest()->getParam('paymentDetailId');
		$billId = $this->getRequest()->getParam('billId');
		$this->view->billId = $billId;
		
		$helper = new Unit_Library_LeaseHelper();		 				
		if ( !empty ($id) && $helper->verifyLeaseBill( $billId )) {
			$model = new Financial_Model_PaymentDetail();
			$pmtData = $model->findById($id);
			if ( $pmtData!==null ) {
				$this->view->pmtDetail = $pmtData;
			}
			else {
			    $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');  
			}
		}
		else {
		    $this->view->msg = array('msg'=>'noRecordFound','type'=>'error'); 
		}
	}

        /**
	 *  Pull eviction info for selected lease
	 */
        public function viewevictionsAction() {		
		$leaseId = $this->getRequest()->getParam('leaseId');
		if ( !empty ($leaseId) ) {
		    $helper = new Unit_Library_EvictionHelper();
		    $leaseEvictions = $helper->fetchLeaseEvictions($leaseId);
		    $this->view->evictions = $leaseEvictions;
		    $this->view->leaseId = $leaseId;
		}
		else {
		    $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');		    
		}
	}
	
	/**
	 *  Create eviction
	 */
        public function createevictionAction() {
		$leaseId = $this->getRequest()->getParam('leaseId');
		$this->view->leaseId = $leaseId;
		if ( !empty ($leaseId) ) {
		    // pull tenant names and id into dropdown
		    // checkbox for is he evicted (fully kicked out)
		    // text area for writing comments
		
		    $form = new Unit_Form_CreateEviction();
		    $form->setForm($leaseId);
		    $this->view->form = $form;		    
		    
		    if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			// save vars to eviction and evictionComment
			$helper = new Unit_Library_EvictionHelper();
			$args = $this->getRequest()->getParams();
			if( $helper->createEviction( $args ) ){
				$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
				$this->_flashMessenger->addMessage( 'recordSaved');
				$this->_helper->redirector('viewevictions', 'lease', 'unit', array('leaseId'=>$leaseId));
			}
			else {
				$this->view->msg = array('msg'=>'errorSaving','type'=>'error');
			}
		    }		    
		}
		else {
		    $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');		    
		}
	}
	
	 public function viewevictionAction() {
		$evictionId = $this->getRequest()->getParam('evictionId');
		if ( !empty ($evictionId) ) {
			$helper = new Unit_Library_EvictionHelper();
			$eviction = $helper->viewEviction($evictionId);			
		        $this->view->eviction = $eviction;
			$eviction = $helper->viewComments($evictionId);			
		        $this->view->comments = $eviction;
			
			// used for the action bar to navigate back
			$evictionHelper = new Unit_Library_EvictionHelper();
		        $leaseId = $evictionHelper->fetchLeaseIdByEvictionId( $evictionId );
		        $this->view->leaseId = $leaseId;
			
			$form = new Unit_Form_AddEvictionComment();
			$this->view->commentForm = $form;
			
			// If comments posted, handle here
		        if ( $this->getRequest()->isPost() and $this->_getParam('comment')  ) {			 
			    if( $form->isValid($this->getRequest()->getParams()) ) {
				$formValues = $form->getValues();
				$formValues['evictionId'] = $this->_getParam('evictionId');				
				
				if($helper->saveComment( $formValues ))	{		
				    $this->_helper->redirector('vieweviction', 'lease', 'unit',array('evictionId'=>$evictionId));
				}
				else {
				    $this->view->messages = $this->getMessage('errorSaving');
				}			     	
			    }
		        }			    
		}
		else {
		    $this->view->msg = array('msg'=>'noRecordFound','type'=>'error');		    
		}
	}
	
	/**
	 *  view all documents
	 */
	public function viewallevictiondocumentsAction(){
		$evictionId = $this->getRequest()->getParam('evictionId');		
		$leaseHelper = new Unit_Library_LeaseHelper();
		$this->view->document = $leaseHelper->fetchEvictionDocuments( $evictionId );
		
		$evictionHelper = new Unit_Library_EvictionHelper();
		$leaseId = $evictionHelper->fetchLeaseIdByEvictionId( $evictionId );
		$this->view->leaseId = $leaseId;
		$this->view->evictionId = $evictionId;
	}
	
	/**
	 *  Add document to eviction
	 */
	public function addevictiondocumentAction(){		
		$helper = new Unit_Library_EvictionDocumentHelper();
		$evictionId = $this->getRequest()->getParam('evictionId');		
		$valid = $helper->validateEvictionId($evictionId);
		$this->view->evictionId = $evictionId;
		if( $valid )
		{
			$helper->setProperties(APPLICATION_PATH.'/modules/unit/config/evictionConfig.ini',APPLICATION_ENV);
			try
			{				
				$form = $helper->getAddPictureForm();				
				if( $this->getRequest()->isPost() and $form->isValid( $this->getRequest()->getParams() ) )
				{
					$result = $helper->transferFile(array('form'=>$form,'evictionId'=>$evictionId,'description'=>$this->getRequest()->getParam('description')));
					if( $result )
					{
						$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
						$this->_flashMessenger->addMessage( array('msg'=>'fileCreated','type'=>'success'));
						$this->_helper->redirector('viewallevictiondocuments', 'lease', 'unit', array('evictionId'=>$evictionId));
					}
					else {
					    $this->view->msg = $helper->getMessageState();
					}
				}
				$this->view->form = $form;
			}
			catch(Zend_File_Transfer_Exception $e)
			{
				$this->view->msg = 'notWrittableError';
			}
		}
		$this->view->msg = $helper->getMessageState();
	}	
}
?>
