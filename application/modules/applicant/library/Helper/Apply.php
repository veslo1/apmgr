<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package applicant
 * @subpackage library
 * @internal Helper for the Applicant_Controller_ApplyController
 */

class Applicant_Library_Helper_Apply {
	/**
	 * @var Default_Form_Authenticated
	 */
	private $authorizedForm;

	/**
	 * @var boolean
	 */
	private $hasModel;

	/**
	 * @var boolean
	 */
	private $hasUnit;

	/**
	 * @var boolean
	 */
	private $hasApartment;

	/**
	 * @var boolean
	 */
	private $isError;

	/**
	 * @var Zend_Validate_Int
	 */
	private $validator;

	/**
	 * @var array Contains a list of errors
	 */
	private $stackError;

	/**
	 * Injected object
	 * @var Applicant_Library_Interface_WorkFlow
	 */
	private $workFlowHelper;


	public function __construct(array $args=null) {
		$this->validator = new Zend_Validate_Int();
		if( isset($args['workFlowHelper']) ) {
			$this->setWorkflowHelper($args['workFlowHelper']);
		}
	}

	/**
	 * General business logic to consider the controller authenticated
	 */
	public function validateGetParams(array $request=null) {
		if( isset($request) ) {
			$this->validateUnit($request);
			$this->validateApartment($request);
			$this->validateModel($request);
		}
	}

	/**
	 * @return boolean
	 */
	public function getIsError() {
		return $this->isError;
	}

	/**
	 * Validate that the unit parameter is valid
	 * Validate that the unit is available for rent
	 * @param array $request
	 */
	private function validateUnit($request) {
		$this->hasUnit = in_array('unit',array_keys($request));
		if( false==$this->hasUnit ) {
			$this->isError = true;
			$this->stackError['hasUnit'] = 'unitIdMissing';
		} else {
			if( false==$this->validator->isValid($request['unit']) ) {
				$this->isError = true;
				$this->stackError['hasUnit'] = 'unitIdNotValid';
			} else {
				$unit = new Unit_Model_Unit();
				$exists = $unit->exists(array('column'=>'id','table'=>'unit'), $request['unit']);
				if( false==$exists ) {
					$this->isError = true;
					$this->stackError['hasUnit'] = 'unitIdNotValid';
				} else {
					$unit = $unit->findById($request['unit']);
					if( $unit->getIsAvailable() == 0) {
						$this->isError = true;
						$this->stackError['unitIsNotForRent'] = 'unitIsNotForRent';
					}
				}
			}
		}
	}

	/**
	 * Validate that the apartmentId is valid
	 * @param array $request
	 */
	private function validateApartment($request) {
		$this->hasApartment = in_array('apartment',array_keys($request));
		if( false==$this->hasApartment ) {
			$this->isError = true;
			$this->stackError['hasApartment'] = 'apartmentIdMissing';
		} else {
			$apartment = new Unit_Model_Apartment();
			$exists = $apartment->exists(array('column'=>'id','table'=>'apartment'), $request['apartment']);
			if( false==$exists ) {
				$this->isError = true;
				$this->stackError['hasApartment'] = 'apartmentIdNotValid';
			}
		}
	}

	/**
	 * Validate that the apartmentId is valid
	 * @param array $request
	 */
	private function validateModel($request) {
		$this->hasModel = in_array('model',array_keys($request));
		if( false==$this->hasModel ) {
			$this->isError = true;
			$this->stackError['hasModel'] = 'modelIdIsMissing';
		} else {
			$unitModel = new Unit_Model_UnitModel();
			$exists = $unitModel->exists(array('table'=>'unitModel','column'=>'id'), $request['model']);
			if( false==$exists ) {
				$this->isError = true;
				$this->stackError['hasModel'] = 'modelIdNotValid';
			}
		}
	}

	/**
	 * @return array
	 */
	public function getStackError() {
		return $this->stackError;
	}

	/**
	 * Validate Zend_Session_Namespace instance
	 */
	public function validateWorkflowStep()
	{
		$awh = $this->getWorkFlowHelper();
		if( $awh->isActive( $awh->getSessionNameSpace() )==false)
		{
			$this->isError = true;
		}
	}

	/**
	 * @return Applicant_Form_Address
	 * @deprecated
	 */
	public function getApplicantCurrentAddress() {
		$form = new Applicant_Form_Address();
		$form->setLegend('currentApplicantAddress');
		$form->setForm();
		return $form;
	}

	/**
	 * Command the workflow steps and encapsulate the work-flow helper
	 * @param array $args
	 * @return string The next destination
	 * @throws Applicant_Library_Exception
	 * @throws Zend_Db_Exception
	 */
	public function commandWorkFlow(array $args=null) {
		$awh = new Applicant_Library_WorkflowHelper();
		$awh->initSession();
		$awh->updateStep(array('payload'=>$args['payload'],'name'=>$args['name'],'current'=>$args['current'],'complete'=>$args['complete'],'applicantId'=>$awh->getApplicantId() ) );
		$destUrl = $awh->fetchNextStep($args['name']);
		return $destUrl;
	}

	/**
	 * Terminate the work flow after the user
	 * went through each step of the flow
	 */
	public function finalizeWorkflow() {
		$this->getWorkFlowHelper()->terminateSession();
	}

	/**
	 * Set the Applicant_Library_Interface_WorkFlow for this helper
	 * @param Applicant_Library_Interface_WorkFlow $helper
	 */
	public function setWorkflowHelper(Applicant_Library_Interface_WorkFlow $helper) {
		$this->workFlowHelper = $helper;
	}

	/**
	 * @return Applicant_Library_Interface_WorkFlow
	 */
	public function getWorkFlowHelper() {
		return $this->workFlowHelper;
	}

	/**
	 * Determine if the user is authenticated clean his credentials
	 * @param array $user
	 * @param bool $authenticated
	 */
	public function authenticateUser($args,$authenticated) {
		$success = false;
		if( true==$authenticated )
		{
			$auth = Zend_Auth::getInstance();
			$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
			$auth->clearIdentity();
		}

		if( isset($args['username']) and isset($args['emailAddress']) and isset($args['password']) )
		{
			$user = new User_Model_User();
			$user = $user->findByKey(array( 'returnClassObject'=>true, 'search'=>array( 'username'=>$args['username'],'emailAddress'=>$args['emailAddress'],'password'=>sha1($args['password']) )) );
			if( !empty($user) )
			{
				$loginHelper = new User_Library_Helper_Login();
				$success = $loginHelper->authenticateUser($args['username'],$args['password']);
			}
		}

		return $success;
	}

	/**
	 * Determine the action to perform when the accepts or not the contract.
	 * If he accepts, create the default status and mark him as accepted
	 * @param array $args
	 * @return string
	 */
	public function routeUserContract(array $args=null) {
		$result = '';
		$steps = $this->getWorkFlowHelper()->getSteps();

		if($args['acceptedContract']==1) {
			$stack = array();
			//	Save the authorization
			$stack[] = $this->saveAuthorization($args);
			//	Set the workflow
			$stack[]= $this->initWorkFlowStatus($args);
			//	Set the initial background check value
			$stack[] = $this->initBackgroundCheckStatus($args);
			//	And save the appliance
			$appliance = new Applicant_Model_Appliance($args);
			$stack[] = $appliance->save();
			if( !in_array(false,$stack) ){
				$result = $this->commandWorkFlow(array('payload'=>$args,'name'=>'fourteen','current'=>0,'complete'=>1,'applicantId'=>$args['applicantId']) );
			}
		} else {
			$this->commandWorkFlow(array('payload'=>$args,'name'=>'fourteen','current'=>0,'complete'=>1,'applicantId'=>$args['applicantId']) );
			$result = $steps['fourteen']['action'];
		}
		return $result;
	}

	/**
	 * Save the authorization form into the applicantAuthorization
	 * @param array $args
	 * @return boolean
	 */
	private function saveAuthorization(array $args){
		$saved = false;
		$authorization = new Applicant_Model_Authorization();
		$authorization->setApplicantId($args['applicantId']);
		$authorization->setApplicantSignature($args['applicantSignature']);
		$authorization->setAcceptedContract($args['acceptedContract']);
		if( isset($args['spouseSignature']) ){
			$authorization->setSpouseSignature($args['spouseSignature']);
		}
		$saved = $authorization->save();
		return $saved;
	}
	/**
	 * Initialize the workflow status for the current applicant
	 * @param array $args
	 * @return boolean
	 */
	private function initWorkFlowStatus(array $args){
		$saved = false;
		$wfStatus = new Applicant_Model_ApplicantWorkflowStatus();
		$wfStatus->setApplicantId($args['applicantId']);
		$wfStatus->setComment(Applicant_Model_ApplicantWorkflowStatus::DEFAULTCOMMENT);
		$wfStatus->setUserId(Applicant_Model_ApplicantWorkflowStatus::DEFAULTUSER);
		$wfStatus->setApplicantStatusId(Applicant_Model_ApplicantWorkflowStatus::DEFAULTWORKFLOWSTATUS);
		$wfStatus->setCurrentStatus(1);
		$saved = $wfStatus->save();
		return $saved;
	}

	/**
	 * Initialize the values for the background check
	 * @param array $args
	 * @return boolean
	 */
	private function initBackgroundCheckStatus(array $args){
		$saved = false;
		$bgCheckArgs = array('applicantId'=>$args['applicantId'],'status'=>Applicant_Model_BackgroundCheck::DEFAULTSTATUS,'userId'=>Applicant_Model_BackgroundCheck::DEFAULTUSER,'currentStatus'=>1);
		$background = new Applicant_Model_BackgroundCheck($bgCheckArgs);
		$saved = $background->save();
		return $saved;
	}

	/**
	 * Confirm that the user wants to delete his account or go back to step 14
	 * @param array $args
	 * @return string
	 */
	public function confirmPurge(array $args) {
		$url = '';
		if ( 0==$args['deleteInfo'] ) {
			$steps = $this->getWorkFlowHelper()->getSteps();
			$url = $steps['fourteen']['url'];
		} else {
			//@todo set this up so users can determine the exit url ?
			$url = 'user/login/logout';
		}
		return $url;
	}

	/**
	 * Log the errors in the application
	 * @param Zend_Controller_Action $object
	 * @param Exception $e
	 * @param string $function
	 */
	public function logFails(Zend_Controller_Action $object,Exception $e,$function) {
		$log = new ZFObserver_Forensic();
		$log->attach( new ZFObserver_Observers_Text() );
		$log->setStatus(ZFObserver_ILogeable::ALERT);
		$log->notify($object,$function." said:".$e->getMessage()." at line ".$e->getLine());
	}
}
