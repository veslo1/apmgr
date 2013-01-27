<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @since May 30, 2010
 * User waitlist class
 */

class Applicant_Model_UserWaitList extends ZFModel_ParentModel  {

	/**
	 * The user requesting to join the wait list
	 * @var int
	 */
	protected $userId;

	/**
	 * The model id he's applying to
	 * @var int
	 */
	protected $modelId;

	/**
	 * @var string
	 */
	protected $comments;

	/**
	 *
	 * @param $args
	 */
	public function __construct(array $options=null) {
		parent::__construct( $options );
		$this->setDbTable('Applicant_Model_DbTable_UserWaitList');
	}

	/**
	 *
	 * @param int $userId
	 */
	public function setUserId($userId) {
		$this->userId =  $userId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param int $modelId
	 */
	public function setModelId($modelId) {
		$this->modelId = $modelId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getModelId() {
		return $this->modelId;
	}

	/**
	 *
	 * @param string $comments
	 */
	public function setComments($comments) {
		$this->comments = $comments;
		return $this->comments;
	}

	/**
	 * @return string
	 */
	public function getComments() {
		return $this->comments;
	}
}