<?php
/**
 * Model for the background check
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_BackgroundCheck extends ZFModel_ParentModel {

	/**
	 * @var int $applicantId
	 */
	protected $applicantId;

	/**
	 * @var int $status
	 */
	protected $status;

	/**
	 * @var string $notes
	 */
	protected $notes;

	/**
	 * The user id that performed the operation
	 * @var int
	 */
	protected $userId;

	/**
	 * The default status that the background check has
	 * @var const
	 */
	const DEFAULTSTATUS='notrun';

	/**
	 * The default user that applies the changes
	 * @var const
	 */
	const DEFAULTUSER=1;

	/**
	 * Determine the current status of an applicant
	 * @var boolean
	 */
	protected $currentStatus;
	
	/**
	 * Constructor
	 * @param array $options
	 */
	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_BackgroundCheck');
	}

	/**
	 * Set the applicant id
	 * @param int $applicantId
	 * @return Applicant_Model_BackgroundCheck
	 */
	public function setApplicantId($applicantId) {
		$this->applicantId=$applicantId;
		return $this;
	}

	/**
	 * Retrieve the applicant id
	 * @return number
	 */
	public function getApplicantId() {
		return $this->applicantId;
	}

	/**
	 * Set the status for the applicant
	 * @param int $status
	 * @return Applicant_Model_BackgroundCheck
	 */
	public function setStatus($status) {
		$this->status=$status;
		return $this;
	}

	/**
	 * Retrieve the status of the applicant
	 * @return int:
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Set notes regarding his background check
	 * @param string $notes
	 * @return Applicant_Model_BackgroundCheck
	 */
	public function setNotes($notes) {
		$this->notes=$notes;
		return $this;
	}

	/**
	 * Enter description here ...
	 * @return string
	 */
	public function getNotes() {
		return $this->notes;
	}

	/**
	 * Set the userId that performed the change
	 * @param int $userId
	 * @return Applicant_Model_BackgroundCheck
	 */
	public function setUserId($userId){
		$this->userId = $userId;
		return $this;
	}

	/**
	 * Retrieve the id of the user that performed the operation
	 * @return number
	 */
	public function getUserId(){
		return $this->userId;
	}
	
	/**
	 * Set the current status
	 * @param boolean $currentStatus
	 */
	public function setCurrentStatus($currentStatus)
	{
		$this->currentStatus = $currentStatus;
	}
	
	/**
	 * Retrieve the current status
	 * @return boolean
	 */
	public function getCurrentStatus()
	{
		return $this->currentStatus;
	}
}
