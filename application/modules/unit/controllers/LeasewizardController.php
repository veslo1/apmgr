<?php
/**
 * Created on Mar 4, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * The controller for the lease wizard
 * </p>
 */

class Unit_LeasewizardController extends ZFController_Controller {

	/*
	 *  Add user to unit
	 */
	public function addusertolistAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		 
		$userId = $this->getRequest()->getParam('userId');

		$leaseWizardModel = new Unit_Model_LeaseWizard();
		$leaseWizardId = $this->getRequest()->getParam( 'leaseWizardId');
		$leaseWizardItem = $leaseWizardModel->findById( $leaseWizardId );

		$userModel = new User_Model_User();
		$tenant = $userModel->findById( $userId );
                
		$leaseWizardItem->setTenant( $tenant );
		$leaseWizardItem->save();
                
		echo Zend_Json::encode( $leaseWizardItem->getTenant(true) );
	}  // end addtounit function

	public function removeuserfromlistAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
			
		$userId = $this->getRequest()->getParam('userId');

		$leaseWizardModel = new Unit_Model_LeaseWizard();
		$leaseWizardId = $this->getRequest()->getParam( 'leaseWizardId');
		$leaseWizardItem = $leaseWizardModel->findById( $leaseWizardId );

		$leaseWizardItem->removeTenant( $userId );
		$leaseWizardItem->save();

		echo Zend_Json::encode( $leaseWizardItem->getTenant(true) );
	}  // end addtounit function


       /**
	 * Clones the lease
	 */
	public function cloneleaseAction() {
		$leaseId = $this->getRequest()->getParam('leaseId');
 
                if( $leaseId ){
                    $helper = new Unit_Library_LeaseWizardHelper();
		    $unitId = $helper->cloneRow( $leaseId );
		    if( $unitId ) {
		        $this->_helper->redirector('startleasewizard', 'leasewizard', 'unit', array('unitId'=>$unitId));
		    }
		    else{
			$this->view->message = array( 'msg'=>'errorSaving', 'type'=>'error' );	
		    }		    
		}
		// in theory this is only hit on missing leaseId
		$this->view->message = array( 'msg'=>'leaseNotFound', 'type'=>'error' );				
	} 

	/*  display stuff to screen
	 move in date
	 model rent schedule
	 rent discounts
	 tenants
	 comments, account link, etc
	 */
	public function confirmationAction()  {
		$leaseWizardItem = $this->getWizard();
		if( $leaseWizardItem ) {
			$form = new Unit_Form_Confirmation();
			$form->setLegend('leaseWizardConfirmation');
			$form->setInstructionText('leaseWizardConfirmationInstructions');
			$form->setForm( array('next'=>'finish') );
			$this->view->form = $form;
			$this->view->item = $leaseWizardItem;
			$this->view->scheduleItem = $leaseWizardItem->getModelRentScheduleItemObj();
			// proration
			$proration = $leaseWizardItem->getProrationObj();
			$this->view->prorationEnabled = $proration->getRentSettings()->getProrationEnabled();
			if( $proration->getRentSettings()->getProrationEnabled() ){		    			    
			    // if the proration month is set to 2 but the lease is only for 1 month, do not show proration information.  
			    if( $this->view->scheduleItem->getNumMonths()>=$proration->getMonthSequence()  ) {				
				$this->view->prorationCheck=1;
				$amount = $proration->getAmountDue();
				$this->view->proration = array( 'amount'=>$amount, 'month'=>$proration->getMonthSequence() );
			    }			    
			}			
	   
			if( $this->getRequest()->isPost() and $this->_getParam('next') ) {
				if( $leaseWizardItem->createLease() ) {
					$this->_helper->redirector('viewleaselist', 'lease', 'unit', array('unitId'=>$leaseWizardItem->getUnitId() ));
				}
				$this->view->messages = $this->getMessage('errorSaving');
			}
			else if( $this->_getParam('previous') ) {
			    $this->_helper->redirector('recurringfees', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
			}
		}
	}


	/**
	 *  User can enter discounts
	 **/
	public function enterdiscountsAction() {
		$leaseWizardItem = $this->getWizard();
		 
		if( $leaseWizardItem ) {
			// fetch model rent schedule item
			$model = new Unit_Model_ModelRentScheduleItem();
			$scheduleItem = $model->findById( $leaseWizardItem->getModelRentScheduleItemId() );
			$leaseWizardItem->setRentAmount( $scheduleItem->getRentAmount() );

			$form = new Unit_Form_EnterDiscounts();
			$form->setLeaseWizard( $leaseWizardItem );
			$form->setForm( $scheduleItem );
			$form->populate(array('rentAmount'=>$leaseWizardItem->getRentAmount() ));
	   
			$loadDiscount = $leaseWizardItem->getDiscount();
			if($loadDiscount) {
			    $form->populate( $loadDiscount );
			}
			$this->view->form = $form;

			if( $this->getRequest()->isPost()
			and $form->isValid($this->getRequest()->getParams())
			and $this->_getParam('next') ) {
				$discount = $form->getDiscountValues();
				$leaseWizardItem->setDiscount( $discount );
				if( $leaseWizardItem->save() ) {
				    $this->_helper->redirector('searchaddtenant', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
				}
				else {
				     $this->view->messages = $this->getMessage('errorSaving');
				}
			}
			else if( $this->_getParam('previous') ) {
			    $this->_helper->redirector('selectrentschedule', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
			}
		}
	}
	 
	/**
	 *  Enter Move In Date = effectiveDate
	 */
	public function entermoveindateAction() {
		$leaseWizardItem = $this->getWizard();

		if( $leaseWizardItem ) {
			$form = new Unit_Form_EnterMoveInDate();
			$form->setLegend( 'leaseWizardEntermoveindate' );
			$form->setForm();
			$form->populate( $leaseWizardItem->toArray() );
			$this->view->form = $form;
				
			if( $this->getRequest()->isPost()
			and $form->isValid($this->getRequest()->getParams()) ) {
				$date = $form->getValue('effectiveDate');
				$moveInDate = $form->getValue('moveInDate');
				$leaseWizardItem->setEffectiveDate( $date );
				$leaseWizardItem->setMoveInDate( $moveInDate );
				if( $leaseWizardItem->save() ) {				    
				    $this->_helper->redirector('selectrentschedule', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
				}
				else {				
				    $this->view->messages = $this->getMessage('errorSaving');
				}
			}
		}
	}

	/**
	 *  Fetches Access to the page
	 */
	private function getWizard(){
		$leaseWizardModel = new Unit_Model_LeaseWizard();
		$leaseWizardId = $this->getRequest()->getParam( 'leaseWizardId');
		$leaseWizardModel->setId( $leaseWizardId );
		 
		$item = $leaseWizardModel->getLeaseWizard();
		if( $item==false ) {
		    $this->view->messages = $this->getMessage('accessDenied');
		}
		return $item;
	}

	/**
	 *  Stolen from the unit/controllers/TenantController.php file
	 */
	public function searchaddtenantAction() {
		$leaseWizardItem = $this->getWizard();

		if( $leaseWizardItem ) {
			$form = new Unit_Form_AddSearchTenant();
			$form->setLegend( 'leaseWizardSearchAddTenant' );
			$form->setInstructionText('searchAddTenantInstructions');
			$form->setForm();

			$model = new User_Model_User();
			$first = $this->getRequest()->getParam('firstName');
			$last = $this->getRequest()->getParam('lastName');

			$user=null;
			if(isset($first) || isset($last)){
				$search=array();
				if(isset($first)) {
				    $search['firstName'] = $first;
				}
				if(isset($last)) {
				    $search['lastName'] = $last;
				}
					
				$user = $model->findByKey( array('search'=>$search,'like'=>true));
				$form->populate( $search );
			}

			if( $user ){
				$this->view->records = $user;
				$this->view->paginator=$this->paginate( $this->view->records );
			}
			$this->view->tenants = $leaseWizardItem->getTenant();
	   
			$nextForm    = new Unit_Form_Confirmation();
			$nextForm->setForm();
	   
			if( $this->getRequest()->getParam('previous') ) {
			    $this->_helper->redirector('enterdiscounts', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
			}
	   
			if( $this->getRequest()->getParam('next') ){
				if($leaseWizardItem->getTenant()) {
				    $this->_helper->redirector('selectleasefees', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
				}
				else {				    
				    $this->view->message = array( 'msg'=>'noTenantSelected', 'type'=>'error' );				   
				}
			}
			$this->view->nextForm = $nextForm;
			$this->view->form = $form;
		}
	}

	/**
	 *  Select fee and deposits
	 */
	public function selectfeedepositAction() {
		$leaseWizardItem = $this->getWizard();

		if( $leaseWizardItem ) {
			// fetch fees and deposits
			$form = new Unit_Form_SelectFeeDeposit();
			$form->setInstructionText('selectFeeDepositInstructions');
			$form->setLegend('leaseWizardSelectfeedeposit');
			$form->setForm();
			// sets any saved values
			$form->setFee( $leaseWizardItem->getFee() );			
			$this->view->form = $form;

			// if next, store data into the leasewizard table
			if( $this->getRequest()->isPost()
			and $form->isValid($this->getRequest()->getParams())
			and $this->_getParam('next')  ){
				$leaseWizardItem->setFee( $form->getFormFee() );				

				if( $leaseWizardItem->save() ) {
				    $this->_helper->redirector('recurringfees', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
				}    
				else{
				    $this->view->messages = $this->getMessage('errorSaving');
				}
			}
			if( $this->_getParam('previous') ) {
			    $this->_helper->redirector('selectpreleasefees', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
			}
		}
	}
	
	/**
	 *  Select lease fees - used to fetch fees created with the last lease
	 */
	public function selectleasefeesAction() {
		$leaseWizardItem = $this->getWizard();

		if( $leaseWizardItem ) {
			// fetch fees and deposits
			$form = new Unit_Form_SelectLeaseFee();
			$form->setInstructionText('selectLeaseFeesInstructions');
			$form->setLegend('leaseWizardLeaseFees');
			
                        // fetch fees 		
			$helper = new Unit_Library_LeaseWizardHelper();
			$fees = $helper->fetchLeaseFee( $leaseWizardItem->getFromLeaseId() );			
			$form->setForm( $fees );  // populate fees
			
			// sets any saved values
			$form->setFee( $leaseWizardItem->getLeaseFee() );
			
			$this->view->form = $form;

			// if next, store data into the leasewizard table
			if( $this->getRequest()->isPost()
			and $form->isValid($this->getRequest()->getParams())
			and $this->_getParam('next')  ){							
				$selectedFees = $form->getFormFee();
				if( $helper->saveSelectedLeaseFees( $leaseWizardItem, $fees, $selectedFees ) ) {				   
				    $this->_helper->redirector('selectpreleasefees', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
				}    
				else{
				    $this->view->messages = $this->getMessage('errorSaving');
				}				
			}
			if( $this->_getParam('previous') ) {
			    $this->_helper->redirector('searchaddtenant', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
			}
		}
	}
	
	/**
	 *  Select prelease fees and deposits
	 */
	public function selectpreleasefeesAction() {
		$leaseWizardItem = $this->getWizard();

		if( $leaseWizardItem ) {
			// fetch fees and deposits
			$form = new Unit_Form_SelectPreleaseFee();
			$form->setInstructionText('selectPreleaseFeesInstructions');						
			
                        // fetch fees 		
			$helper = new Unit_Library_LeaseWizardHelper();
			$fees = $helper->fetchPreleaseFee( $leaseWizardItem->getTenant(), $leaseWizardItem->getUnitId() );			
			$form->setForm( $fees );  // populate fees
			
			// sets any saved values
			$form->setFee( $leaseWizardItem->getPreleaseFee() );
			
			$this->view->form = $form;

			// if next, store data into the leasewizard table
			if( $this->getRequest()->isPost()
			and $form->isValid($this->getRequest()->getParams())
			and $this->_getParam('next')  ){							
				$selectedFees = $form->getFormFee();
				if( $helper->saveSelectedPreleaseFees( $leaseWizardItem, $fees, $selectedFees ) ) {
				    $this->_helper->redirector('selectfeedeposit', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
				}    
				else{
				    $this->view->messages = $this->getMessage('errorSaving');
				}				
			}
			if( $this->_getParam('previous') ) {
			    //$this->_helper->redirector('searchaddtenant', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
			    $this->_helper->redirector('selectleasefees', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
			}
		}
	}
	
	/**
	 *  Recurring Fees
	 */	
	public function recurringfeesAction() {
		$leaseWizardItem = $this->getWizard();

		if( $leaseWizardItem ) {
			// fetch fees and deposits
			$form = new Unit_Form_SelectFeeDeposit();
			$form->setLegend('leaseWizardRecurringfees');			
			// sets any saved values
			$form->setInstructionText('selectRecurringFeeInstructions');
			$form->setForm();
			$form->setFee( $leaseWizardItem->getRecurringFee() );			
			$this->view->form = $form;

			// if next, store data into the leasewizard table
			if( $this->getRequest()->isPost()
			and $form->isValid($this->getRequest()->getParams())
			and $this->_getParam('next')  ){

				$leaseWizardItem->setRecurringFee( $form->getFormFee() );				

				if( $leaseWizardItem->save() ) {
				    $this->_helper->redirector('confirmation', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
				}    
				else{
				    $this->view->messages = $this->getMessage('errorSaving');
				}
			}
			if( $this->_getParam('previous') ) {
			    $this->_helper->redirector('selectfeedeposit', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
			}
		}
	}	

	/**
	 *  Selects the rent amount to use
	 *
	 **/
	public function selectrentscheduleAction() {
		$leaseWizardItem = $this->getWizard();

		if( $leaseWizardItem ) {
			// Look for model rent schedules that are valid for the move in date
			$schedules = $leaseWizardItem->fetchLatestScheduleByUnitId();			
	   
			$form = new Unit_Form_SelectRentSchedule();
			$form->setForm( $schedules );
			$form->populate( $leaseWizardItem->toArray() );
			$this->view->form = $form;
	   
			// if no schedules are found, notify the user
			if( !$schedules ) {				
				$this->view->message = array( 'msg'=>'noModelScheduleExists', 'type'=>'error' );	
			}
			else {
				if( $this->getRequest()->isPost()
				and $form->isValid($this->getRequest()->getParams())
				and $this->_getParam('next')  ){
					 
					$item = $form->getValue('modelRentScheduleItemId');
					$modelRentScheduleId = $form->getValue('modelRentScheduleId');

					$leaseWizardItem->setModelRentScheduleItemId( $item );
					$leaseWizardItem->setModelRentScheduleId( $modelRentScheduleId );
					if( $leaseWizardItem->save() ) {
					    $this->_helper->redirector('enterdiscounts', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
					}
					else {
			                    $this->view->messages = $this->getMessage('errorSaving');
			                }
				}				        			
			}
			if( $this->_getParam('previous') ) {
			    $this->_helper->redirector('entermoveindate', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardItem->getId()));
			}
		}
	}

	/**
	 *  Start lease wizard
	 **/
	public function startleasewizardAction(){		 
		$form = new Unit_Form_Confirmation();
		$form->setLegend('leaseWizard');
		$form->setInstructionText('startInstructions');
		$form->setForm( array('hidePrevious'=>1) );
		$this->view->form = $form;
		 
		if( $this->getRequest()->isPost()
		and $form->isValid($this->getRequest()->getParams())
		and $this->_getParam('next')  ){		  
			$unitId = $this->getRequest()->getParam( 'unitId');
			$ul = new Unit_Model_LeaseWizard();
			$ul->setUnitId( $unitId );
			$leaseWizardId = $ul->getLeaseWizardId( $unitId );
			$this->_helper->redirector('entermoveindate', 'leasewizard', 'unit', array('leaseWizardId'=>$leaseWizardId));
		}
	}
}
?>
