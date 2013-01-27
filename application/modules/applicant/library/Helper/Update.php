<?php
/**
 * Helper object for the UpdateController
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Library_Helper_Update extends Object_Instrospection implements ZFInterfaces_Messageable {

	/**
	 * An applicant id
	 * @var int
	 */
	protected $applicantId;

	/**
	 * Data mapper
	 * @var array
	 */
	static $dataMapper = array('applicantBackgroundCheck','applicantFeeBill','applicantWorkflowStatus');

	/**
	 * Parameter used to restore cache
	 * @var int
	 */
	protected $persist;

	/**
	 * Constructor of this helper
	 * @param array $options
	 */
	public function __construct(array $options=null){
		if($options!=null){
			$this->instrospect($options);
		}
	}

	/**
	 * Set the applicant id
	 * @param int $applicant
	 * @return Applicant_Library_Helper_Create
	 */
	public function setApplicantId($applicant){
		$this->applicantId = $applicant;
		return $this;
	}

	/**
	 * Get the applicant id
	 * @return number
	 */
	public function getApplicantId(){
		return $this->applicantId;
	}

	/**
	 * Set the persist attribute
	 * @param int $persist
	 */
	public function setPersist($persist){
		$this->persist = $persist;
	}

	/**
	 * Retrieve the persist element
	 * @return number
	 */
	public function getPersist(){
		return $this->persist;
	}

	/**
	 * Validate the applicant that we receive.
	 * The precondition to write notes on the background check, is that he paid the fee
	 * @return boolean
	 */
	public function validApplicant() {
		$valid = false;
		$afb = new Applicant_Model_FeeBill();
		$valid = $afb->exists(array('table'=>self::$dataMapper[1],'column'=>'applicantId'), $this->getApplicantId());
		if( false==$valid ) {
			$this->setMessageState('applicantIdNotValid');
		}
		return $valid;
	}

	/**
	 * Determine that the current applicant is valid
	 * @return boolean
	 */
	public function validApplicantWorkflow(){
		$valid = false;
		$applicantId = $this->getApplicantId();
		if( isset($applicantId) ){
			$aws = new Applicant_Model_ApplicantWorkflowStatus();
			$recordFound = $aws->exists(array('column'=>'applicantId','table'=>self::$dataMapper[2]), $this->getApplicantId());
			if(false==$recordFound){
				$this->setMessageState('noRecordFound');
			} else {
				$valid = true;
			}
		} else {
			$this->setMessageState('noRecordFound');
		}
		return $valid;
	}

	/**
	 * Retrieve the background check form
	 * @return Applicant_Form_BackgroundCheck
	 */
	public function getBackgroundCheckUpdateForm(){
		$form = new Applicant_Form_BackgroundCheck();
		$bgCheck = new Applicant_Model_BackgroundCheck();
		$param = array( 'search'=>array('applicantId'=>$this->getApplicantId()));
		$bgCheck = $bgCheck->findByKey($param);
		$form->setForm();
		$bgCheck = array_shift($bgCheck);
		$status = array_flip(Applicant_Form_BackgroundCheck::$status) ;
		//TODO Because we have it hardcoded
		$values = array('status'=>$status[$bgCheck->getStatus()],'notes'=>$bgCheck->getNotes());
		$form->populate($values);
		return $form;
	}

	/**
	 * Retrieve the form to update the workflow status
	 * @return Applicant_Form_ChangeApplicantWorkflowStatus
	 */
	public function getWorkflowStatusForm(){
		$applicantObj = new Applicant_Model_Applicant();
		$wfStatusObj = new Applicant_Model_ApplicantWorkflowStatus();
		$applicantObj->setId($this->getApplicantId());
		$appUser = $applicantObj->fetchApplicantUser();
		$wfStatusObj->setApplicantId($this->getApplicantId());
		$data = $wfStatusObj->getCurrentApplicantStatus();
		$data['applicantName'] = $appUser['firstName'] . ' ' . $appUser['lastName'];
		$translator = Zend_Registry::get('Zend_Translate');
		$data['currentStatus'] = $translator->_($data['currentStatus']); // hax
		$form = new Applicant_Form_ChangeApplicantWorkflowStatus();
		$form->setForm();
		$form->setDefaults($data);
		return $form;
	}

	/**
	 * Update the status of an applicant
	 * @return boolean
	 */
	public function save(array $args)
	{
		$saved = array();
		$valid = $this->prepareUpdate($args);
		if(true==$valid)
		{
			$bgCheck = new Applicant_Model_BackgroundCheck($args);
			//	We have to lookup which is the current record
			$previousStatus = $bgCheck->findByKey(array('search'=>array('applicantId'=>$bgCheck->getApplicantId(),'currentStatus'=>1)));
			if( $previousStatus!=null)
			{
				//	If he has a previous record then mark it as not current and perform the operation
				try
				{
					$previousStatus = array_shift($previousStatus);
					$previousStatus->setCurrentStatus(0);
					$previousStatus->setDateUpdated(date('Y-m-d H:i:s'));
					$update = $previousStatus->save() ;
					$saved[] = $update!=false;
				}
				catch (Exception $e)
				{
					//	Mail us
					$saved[] = false;
				}
			}
			$bgCheck->setCurrentStatus(1);
			$saved[]= $bgCheck->save();
		}
		else
		{
			$saved[] = false;
		}
		return !in_array(false, $saved);
	}

	private function prepareUpdate(array &$args)
	{
		$valid = false;
		if( !isset($args['status']) )
		{
			$this->setMessageState('missingStatusTo');
		}
		$userId = User_Library_Helper_Utils::currentUserId();
		if(false==$userId)
		{
			//	This is the weirdest case, because it means that the user reached the update, without credentials
			$this->setMessageState('missingUserId');
		}
		else
		{
			$args['userId'] = $userId;
		}
		$args['applicantId'] = $this->getApplicantId();
		if( !isset($args['notes']) )
		{
			$args['notes'] = 'No notes provided regarding this change';
		}
		$bgCheck = new Applicant_Model_BackgroundCheck();
		$exists = $bgCheck->exists(array('table'=>'applicantBackgroundCheck','column'=>'applicantId'),$args['applicantId']);
		if($exists==false)
		{
			$this->setMessageState('applicantIdNotValid');
		}
		$valid = isset($args['userId']) and isset($args['notes']) and isset($args['status']) and isset($args['applicantId']) and $exists==true;
		return $valid;
	}

	/**
	 * Update the workflow status
	 * @param array $args
	 * @return boolean
	 */
	public function saveWorkflowChange(array $args=null){
		$saved = false;
		if( !empty($args) ) {
			$wfStatusObj = new Applicant_Model_ApplicantWorkflowStatus();
			$wfStatusObj->setApplicantId($this->getApplicantId());
			$data = $wfStatusObj->getCurrentApplicantStatus();
			$args['applicantId'] = $this->getApplicantId();
			$args['comment'] = !isset($args['comment']) ?Applicant_Model_ApplicantWorkflowStatus::DEFAULTCOMMENT:$args['comment'];
			$dataObj = new Applicant_Model_ApplicantWorkflowStatus($args);
			$saved = $dataObj->saveStatus( $data['id'] );
			if(false==$saved){
				$this->setMessageState($dataObj->getMessageState());
			}
		} else {
			//	Basically , we managed to bypass the forms and validation never happened
			$this->setMessageState('unhandledMsg');
		}
		return $saved;
	}
}