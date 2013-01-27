<?php
/**
 * View all the applicants in the system
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_ViewController extends ZFController_Controller {

	public function indexAction() {
		//TODO This is reserved for whatever we decide to put here
	}

	public function feesAction() {
		//----- The fee table -- //
		$column = $this->getRequest()->getParam('column');
		$sort = $this->getRequest()->getParam('sort');
		$applicantFees = new Applicant_Model_FeeSetting();
		$fees = $applicantFees->retrieveEnabledFees(array('column'=>$column,'sort'=>$sort));
		//	Assign to the view and sort
		$this->view->fees = $this->paginate($fees);
		$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';

		//----- The add fee select box -- //
		$form = new Applicant_Form_CreateFeeSettings();
		if($form->getEnabledAccounts()){
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
		//----- The add fee select box -- //
	}

	/**
	 * Allow the lease agent to view the applicants that are on the system
	 * We will display if the user paid or not , allow the user to email, view status changes, change his status
	 * And take notes regarding background checks
	 */
	public function viewallapplicantsAction() {
		$args = array();
		$cache = Zend_Registry::get('cache');
		$values = $cache->load(Applicant_Library_LeaseAgent_Applicant::PERSISTFORM);
		$leaseAgent = new Applicant_Library_LeaseAgent_ControllerHelper($this->getRequest()->getParams());
		$form = $leaseAgent->getForm('view');
		$args['sort'] = $leaseAgent->getSort();
		$args['column'] = $leaseAgent->getColumn();
		/**
		 * @internal We need to differentiate between a post and a get
		 * If it is a post , then we need to clear the cache of the filter.
		 * If it's not a post , we need to differentiate between the get parameters in order to persist properly the options that were sent over query string
		 */
		if( $this->getRequest()->isPost() ) {
			if( $form->isValid( $this->getRequest()->getParams() ) ) {
				$cache->remove(Applicant_Library_LeaseAgent_Applicant::PERSISTFORM);
				$formArgs = $form->getValues();
				$args = array_merge($args,$formArgs);
				$cache->save($args,Applicant_Library_LeaseAgent_Applicant::PERSISTFORM);
			}
		} elseif($values!=false  ) {
			if( !isset($args['column']) ) {
				$args = array_merge($args,$values);
				$form->populate($args);
			} elseif(isset($args['column'])) {
				$args = array_merge($values,$args);
				$form->populate($args);
			}
		}

		$applicant = new Applicant_Library_LeaseAgent_Applicant();
		$applicant->setArguments($args);
		$records = $applicant->search();
		$this->view->applicants = $this->paginate($records);
		$this->view->form = $form;
		$this->view->error = $form->getErrors('filterByDates');
		$this->view->sort = $leaseAgent->switchSort();
	}

	/**
	 * This one will be complex, we have to display the 14 forms
	 */
	public function completedappsAction() {
		/**
		 * We retrieve the persist $_GET.
		 * If we do ,we will provide a link to go back
		 */
		$persist = $this->getRequest()->getParam('persist');
		if($persist==1){
			$this->view->restore = 1;
		}
		$agentMapper = new Applicant_Library_LeaseAgent_DataMapper();
		$this->view->appLinks = $agentMapper->getApplicantMap();

		$leaseAgentHelper = new Applicant_Library_LeaseAgent_ControllerHelper();
		$valid = $leaseAgentHelper->completedAppsValidation($this->getRequest()->getParams());
		if( $valid!==false ) {
			$args = $this->getRequest()->getParams();
			if ( isset($args['page']) ) {
				$agent = new Applicant_Library_LeaseAgent_FormHelper();

				$formName = $agent->mapApplicantFormName($agentMapper,$args);
				$form = new $formName();

				$modelData = $agentMapper->retrieveModelData($args);
				$agent->triggerAction($args['page'],$form);
				$form->setForm();
				$agent->dressForm($form,$modelData);

				$form->setFormReadOnly();
				$this->view->form = $form;
			}
		} else {
			$this->view->msg = $leaseAgentHelper->getMessageState();
		}
	}

	/**
	 * We will display a fancy html page showing the status changes
	 */
	public function statuschangeAction() {
		/**
		 * We retrieve the persist $_GET.
		 * If we do ,we will provide a link to go back
		 * @var int
		 */
		$persist = $this->getRequest()->getParam('persist');
		if($persist==1){
			$this->view->restore = 1;
		}

		$id = $this->getRequest()->getParam('id');
		if( !empty($id) ){
			$aws = new Applicant_Model_ApplicantWorkflowStatus();
			//	Retrieve all the status changes for this applicant , ordered by the dateCreated field
			$options = array('columnToSort'=>'dateCreated','sortDirection'=>'desc','returnClassObject'=>false,'search'=>array('applicantId'=>$id));
			$result = $aws->findByKey($options);
			if($result!==null){
				//	TODO Refactor ?
				$as = new Applicant_Model_ApplicantStatus();
				$resultCopy = array();
				foreach($result as $id=>$statusRow){
					$resultCopy[$id]=$statusRow->toArray();
					$resultCopy[$id]['properName'] = $as->findById($statusRow['applicantStatusId'])->getName();
					$resultCopy[$id]['currentStatus'] =$resultCopy[$id]['currentStatus']==1?'yes':'no';
				}
				$this->view->statusHistory = $resultCopy;
			} else{
				$this->view->statusHistory= array();
				$this->view->noRecords= "noRecordsToShow";
			}
		} else {
			$this->view->statusHistory= array();
			$this->view->msg = "applicantIdMissing";
		}
	}

	/*
	 Page to list the prelease fees the applicant has (paid or not)
	 */
	public function viewpreleaseapplicantfeesAction(){
		$this->getFlashMessages();
		$id = $this->getRequest()->getParam('applicantId');
		$appObj = new Applicant_Model_Applicant();
		$preObj = new Applicant_Model_Prelease();
		$appObj->setId( $id );
		$preObj->setApplicantId( $id );
		$this->view->fees = $preObj->fetchPreleaseFees();
		$this->view->applicant = $appObj->fetchApplicantUser();
	}

	public function waitlistAction(){
		$args = array();
		$cache = Zend_Registry::get('cache');
		$leaseAgent = new Applicant_Library_LeaseAgent_ControllerHelper($this->getRequest()->getParams());
		$form = $leaseAgent->getForm('waitlist');

		$restoreFormArguments = $leaseAgent->getRestore();
		$values = $cache->load(Applicant_Library_LeaseAgent_WaitList::PERSISTWAITLISTFORM);
		$args['sort'] = $leaseAgent->getSort();
		$args['column'] = $leaseAgent->getColumn();

		if( $this->getRequest()->isPost() ) {
			if( $form->isValid( $this->getRequest()->getParams() ) ) {
				$cache->remove(Applicant_Library_LeaseAgent_Applicant::PERSISTWAITLISTFORM);
				$formArgs = $form->getValues();
				$args = array_merge($args,$formArgs);
				ZFCache_Control::addIdentifier(Applicant_Library_LeaseAgent_Applicant::PERSISTWAITLISTFORM);
				$cache->save($args,Applicant_Library_LeaseAgent_Applicant::PERSISTWAITLISTFORM);
			}
		} elseif($values!=false and !isset($args['column']) ) {
			$args = array_merge($args,$values);
			$form->populate($args);
		} elseif($values!=false and isset($args['column']) ) {
			$args = array_merge($values,$args);
			$form->populate($args);
		}

		$applicant = new Applicant_Library_LeaseAgent_Waitlist();
		$applicant->setArguments($args);
		$records = $applicant->search();
		$this->view->applicants = $this->paginate($records);
		$this->view->form = $form;
		$this->view->error = $form->getErrors('filterByDates');
		$this->view->sort = $leaseAgent->switchSort();
	}

	public function bgcheckdetailsAction(){

	}
}
?>