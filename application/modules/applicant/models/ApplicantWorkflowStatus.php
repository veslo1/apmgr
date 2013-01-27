<?php
/**
 *
 * @author Complete with your name <andyouremail@debserverp4.com.ar>
 */
class Applicant_Model_ApplicantWorkflowStatus extends ZFModel_ParentModel {

	/**
	 * The default workflow status. We don't allow configuration for this
	 * @var const
	 */
	const DEFAULTWORKFLOWSTATUS=1;

	/**
	 * The default comment used while creating records
	 * @var const
	 */
	const DEFAULTCOMMENT='systemAutomatedAction';

	/**
	 * The default user that approves transitions
	 * @var const
	 */
	const DEFAULTUSER=1;

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_ApplicantWorkflowStatus');
	}
	/**
	 * @var NO $id
	 */
	protected $id;

	/**
	 * Set id
	 */
	public function setId($id) {
		$this->id=$id;
		return $this;
	}
	/**
	 * Get id
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * @var NO $dateCreated
	 */
	protected $dateCreated;

	/**
	 * Set dateCreated
	 */
	public function setDateCreated($dateCreated) {
		$this->dateCreated=$dateCreated;
		return $this;
	}
	/**
	 * Get dateCreated
	 */
	public function getDateCreated() {
		return $this->dateCreated;
	}
	/**
	 * @var YES $dateUpdated
	 */
	protected $dateUpdated;

	/**
	 * Set dateUpdated
	 */
	public function setDateUpdated($dateUpdated) {
		$this->dateUpdated=$dateUpdated;
		return $this;
	}
	/**
	 * Get dateUpdated
	 */
	public function getDateUpdated() {
		return $this->dateUpdated;
	}
	/**
	 * @var NO $applicantId
	 */
	protected $applicantId;

	/**
	 * Set applicantId
	 */
	public function setApplicantId($applicantId) {
		$this->applicantId=$applicantId;
		return $this;
	}
	/**
	 * Get applicantId
	 */
	public function getApplicantId() {
		return $this->applicantId;
	}
	/**
	 * @var NO $applicantStatusId
	 */
	protected $applicantStatusId;

	/**
	 * Set applicantStatusId
	 */
	public function setApplicantStatusId($applicantStatusId) {
		$this->applicantStatusId=$applicantStatusId;
		return $this;
	}
	/**
	 * Get applicantStatusId
	 */
	public function getApplicantStatusId() {
		return $this->applicantStatusId;
	}
	/**
	 * @var NO $userId
	 */
	protected $userId;

	/**
	 * Set userId
	 */
	public function setUserId($userId) {
		$this->userId=$userId;
		return $this;
	}
	/**
	 * Get userId
	 */
	public function getUserId() {
		return $this->userId;
	}
	/**
	 * @var NO $comment
	 */
	protected $comment;

	/**
	 * Set comment
	 */
	public function setComment($comment) {
		$this->comment=$comment;
		return $this;
	}
	/**
	 * Get comment
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * Set currentStatus
	 */
	public function setCurrentStatus($var) {
		$this->currentStatus=$var;
		return $this;
	}
	/**
	 * Get userId
	 */
	public function getCurrentStatus() {
		return $this->currentStatus;
	}

	/**
	 *  Returns applicants current status
	 */
	public function getCurrentApplicantStatus(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('a'=>'applicantStatus'), array('id'=>'id','currentStatus'=>'a.name' ))
		->join( array('aws'=>'applicantWorkflowStatus'),'aws.applicantStatusId=a.id',array())
		->where( 'aws.applicantId=? AND aws.currentStatus=1', array( $this->getApplicantId() ) );

		$resultSet = $db->query( $query );

		$container = null;

		foreach ($resultSet as $row){
			$container[] = $row;
		}

		return $container[0];
	}


	/**
	 * Enter description here ...
	 * @param unknown_type $priorStatus
	 * @return boolean
	 */
	public function saveStatus( $priorStatus=null ){
		$db = Zend_Registry::get('db'); // used for all in transaction
		$this->setDbAdapter($db);

		$userId = User_Library_Helper_Utils::currentUserId();
		if($userId){
			$this->setUserId( $userId );
		} else{
			$this->setMessageState( 'missingUserId');
			return false;
		}
		if( $priorStatus === $this->getApplicantStatusId() ){
			$this->setMessageState( 'sameApplicantId');
			return false;
		}

		if( !$this->getApplicantId() ){
			$this->setMessageState( 'missingApplicantId');
			return false;
		}
		else{
			try{
				$db->beginTransaction();
				$this->unsetCurrent();
				$this->setCurrentStatus(1);
				$id = $this->save();
				$db->commit();
				return $id;
			}
			catch ( Exception $e) {
				$db->rollBack();
				echo $e->getMessage();
				$this->setMessageState('errorSaving');
				return false;
			}
		}
	}

	/**
	 *  Unsets current statuses
	 */
	private function unsetCurrent(){
		$db = $this->getDbTable()->getAdapter();
		$data = array('currentStatus'=>0);
		$where = "applicantId=" . $this->getApplicantId();
		return $db->update('applicantWorkflowStatus', $data, $where );
	}

}
