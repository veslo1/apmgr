<?php
/**
 * Record the steps that the applicant fills
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Applicant_Model_ApplicantTransaction extends ZFModel_ParentModel {
	/**
	 * @var string $name Name of the step
	 */
	protected $name;

	/**
	 * @var int $applicantId The user id that is working on the workflow
	 */
	protected $applicantId;

	/**
	 * @var string $page Name of the page
	 */
	protected $page;

	/**
	 * @var int $complete Is this current step complete
	 */
	protected $complete;

	/**
	 * @var mixed $payload Query string parameters
	 */
	protected $payload;

	/**
	 * @var int $current Is this step the current one
	 */
	protected $current;

	/**
	 * @var string $action The url to go to after visiting one step
	 */
	protected $action;

	/**
	 * @var string $next The next step to take
	 */
	protected $next;

	/**
	 * @param $args
	 */
	public function __construct(array $options=null) {
		parent::__construct( $options );
		$this->setDbTable('Applicant_Model_DbTable_ApplicantTransaction');
	}

	/**
	 * @param string $action
	 */
	public function setAction($action) {
		$this->action = $action;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * @param int $complete
	 */
	public function setComplete($complete) {
		$this->complete = $complete;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getComplete() {
		return $this->complete;
	}

	/**
	 * @param int $current
	 */
	public function setCurrent($current) {
		$this->current = $current;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getCurrent() {
		return $this->current;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $next
	 */
	public function setNext($next) {
		$this->next = $next;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getNext() {
		return $this->next;
	}

	/**
	 * @param string $page
	 */
	public function setPage($page) {
		$this->page = $page;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * @param array $payload
	 */
	public function setPayload($payload) {
		$this->payload = $payload;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getPayload() {
		return $this->payload;
	}

	/**
	 * @param int $applicantId
	 */
	public function setApplicantId($applicantId) {
		$this->applicantId = $applicantId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getApplicantId() {
		return $this->applicantId;
	}
}

