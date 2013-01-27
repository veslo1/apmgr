<?php
/**
 * Created on November 14, 2010 by rnelson
 * @name apmgr
 * @package application.modules.maintenance.controllers
 * <p>
 * Consolidate controllers for maintenance
 * </p>
 */
class Maintenance_MaintenanceController extends ZFController_Controller {

	/**
	 *  Creates the request for the admin user.  Includes a list of units to selct from
	 */
	public function createmaintenancerequestadminAction(){
		$form = new Maintenance_Form_CreateMaintenanceRequest();
		$form->setIsAdmin(true); // sets form to allow admin to select unit for creating tickets
		$form->setForm();
		$this->view->form = $form;

		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {		  
			$formValues = $form->getValues();
			$maint = new Maintenance_Model_MaintenanceRequest( $formValues );
			if( $maint->saveNewMaintenanceRequest() ) {
			    $this->_helper->redirector('viewallmaintenancerequests', 'maintenance', 'maintenance');
			}
			else {
			    $this->view->msg = $this->getMessage($maint->getMessageState());
			}
		}
	}

	/**
	 *  Fetches the unit of the non admin user
	 */
	public function createmaintenancerequestAction(){		
		$tenantObj = new Unit_Model_Tenant();
		$unitId = $tenantObj->getTenantUnitId();			
		if( $unitId){
			$form = new Maintenance_Form_CreateMaintenanceRequest();
			$form->setForm();
			$this->view->form = $form;
		  
			if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
				$formValues = $form->getValues();
				$maint = new Maintenance_Model_MaintenanceRequest( $formValues );
				$maint->setUnitId($unitId);
					
				if ($maint->saveNewMaintenanceRequest()) {
				    $this->_helper->redirector('viewmymaintenancerequests', 'maintenance', 'maintenance');
				}    
				else {				    
				    $this->view->msg = array('msg'=>$maint->getMessageState(),'type'=>'error'); 	
				}
			}
		}
		else {
		    $this->view->msg = array('msg'=>'maintReqNoUnit','type'=>'error'); 			    
		}
	}
	
	/**
	 *  Index - redirects to view all
	 */
	public function indexAction(){		
	}
	
	/**
	 *  View all maintenance requests
	 */
	public function viewallmaintenancerequestsAction(){
		$maint = new Maintenance_Model_MaintenanceRequest();
		$records = $maint->fetchAllRequests();

		if( $records ){
		    $this->view->paginator = $this->paginate($records);
		}
	}


	/**
	 *  This action allows comment changing.  Intended for tenant usage to view requests
	 */
	public function viewmaintenancerequestAction(){
		$id = $this->_getParam( 'requestId' );
		$maint = new Maintenance_Model_MaintenanceRequest();
		$maint->setId( $id );
		$maint->setMineOnly(true); // only returns requests for this user
		$record = $maint->fetchRequestandComment( array( 'mineOnly'=>true ) );
		if( $record['request'] ) {
			$this->view->record = $record;
			$this->view->commentForm = $form = new Maintenance_Form_AddComment();
		}
		else{
		    $this->view->msg = $this->getMessage('invalidId');
		}    
	  
		// If comments posted, handle here
		if ( $this->getRequest()->isPost() and $this->_getParam('comment')  ) {			 
			if( $form->isValid($this->getRequest()->getParams()) ) {
				$formValues = $form->getValues();
				$formValues['maintenanceRequestId'] = $this->_getParam('requestId');
				 
				$maintComm = new Maintenance_Model_MaintenanceRequestComment( $formValues );
				if($maintComm->save()) {
				    $this->_helper->redirector('viewmaintenancerequest', 'maintenance', 'maintenance',array('requestId'=>$id));
				}
				else {
				    $this->view->messages = $this->getMessage('errorSaving');
				}
			}
		}
	} // end function

	/**
	 *  This action allows status and assigned changes along with comments.  Intended for admin usage
	 */
	public function viewmaintenancerequestadminAction(){
		$id = $this->_getParam( 'requestId' );
		$maint = new Maintenance_Model_MaintenanceRequest();
		$maint->setId( $id );
		$this->view->record = $maint->fetchRequestandComment();	  
		$this->view->commentForm = $form = new Maintenance_Form_AddComment();
		$this->view->statusForm = $statusForm = new Maintenance_Form_ChangeStatusAndAssignment();

		// If comments posted, handle here
		if ( $this->getRequest()->isPost() and $this->_getParam('comment')  ) {
			 
			if( $form->isValid($this->getRequest()->getParams()) ) {
				$formValues = $form->getValues();
				$formValues['maintenanceRequestId'] = $this->_getParam('requestId');
				 
				$maintComm = new Maintenance_Model_MaintenanceRequestComment( $formValues );
				if($maintComm->save()) {
				    $this->_helper->redirector('viewmaintenancerequestadmin', 'maintenance', 'maintenance',array('requestId'=>$id));
				}
				else {
				    $this->view->messages = $this->getMessage('errorSaving');
				}
			}
		}
	  
		// If status/assignedTo posted...handle here
		if ( $this->getRequest()->isPost() and $this->_getParam( 'statusassigned' ) ) {
			$ma = new Maintenance_Model_MaintenanceRequestAssignedStatus();
			$ma->setMaintenanceRequestId( $id );
			$row = $ma->getCurrentRow();

			// if status sent, set object
			if( $this->_getParam( 'status' ) and $statusForm->isValid($this->getRequest()->getParams() )) {
				$formValues = $statusForm->getValues();
				if( $formValues['status'] ) {
				    $ma->setMaintenanceStatusId( $formValues['status'] );
				}    
			}
			else {
			    $ma->setMaintenanceStatusId( $row['maintenanceStatusId'] );
			}
			 
			// if assignedTo sent, set object.
			if( $this->_getParam( 'assignedTo' ) and $statusForm->isValid($this->getRequest()->getParams() )) {
				$formValues = $statusForm->getValues();
				if( $formValues['assignedTo'] ) { // if set, assign.  otherwise default to existing value (for example only status was sent so set assignedTo to the existing person the ticket is assigned to)
				    $ma->setAssignedTo( $formValues['assignedTo'] );
				}
			}
			else {
			    $ma->setAssignedTo( $row['assignedTo'] );
			}

			// If sent data is different from current row (ie either the assignedTo or status changed) then save to table
			if(  ($row['assignedTo']!=$ma->getAssignedTo() and $ma->getAssignedTo()!=null )
			or ( $row['maintenanceStatusId']!=$ma->getMaintenanceStatusId() and $ma->getMaintenanceStatusId()!=null )){					
				//var_dump($ma);die;
				if($ma->saveRecord()) {
				    $this->_helper->redirector('viewmaintenancerequestadmin', 'maintenance', 'maintenance',array('requestId'=>$id));
				}
				else {
				    $this->view->messages = $this->getMessage('errorSaving');
				}
			}
			 
		}
	} // end function

	/**
	 *  View logged in user's maintenance requests on a per apartment level
	 */
	public function viewmymaintenancerequestsAction(){
		$maint = new Maintenance_Model_MaintenanceRequest();
		$records = $maint->fetchMyRequests();

		if( $records ) {
		    $this->view->paginator = $this->paginate($records);
		}
	}

        /**
	 *  View assigned requests
	 */
	public function viewassignedrequestsAction(){
		$maint = new Maintenance_Model_MaintenanceRequest();
		$records = $maint->fetchAssignedRequests();

		if( $records ) {
		    $this->view->paginator = $this->paginate($records);
		}
	}

} // end class
?>
