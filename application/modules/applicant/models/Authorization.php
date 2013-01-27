<?php
/**
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_Authorization extends ZFModel_ParentModel {
	/**
	 * @var int $applicantId
	 */
	protected $applicantId;

	/**
	 * @var string $spouseSignature
	 */
	protected $spouseSignature;

	/**
	 * @var string $applicantSignature
	 */
	protected $applicantSignature;

	/**
	 * @var int $acceptedContract
	 */
	protected $acceptedContract;

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_Authorization');
	}

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
	 * Set applicantSignature
	 */
	public function setApplicantSignature($applicantSignature) {
		$this->applicantSignature = $applicantSignature;
		return $this;
	}

	/**
	 * Get applicantSignature
	 * @return string
	 */
	public function getApplicantSignature() {
		return $this->applicantSignature;
	}

	/**
	 * Set spouseSignature
	 */
	public function setSpouseSignature($spouseSignature) {
		$this->spouseSignature=$spouseSignature;
		return $this;
	}

	/**
	 * Get spouseSignature
	 * @return string
	 */
	public function getSpouseSignature() {
		return $this->spouseSignature;
	}

	/**
	 * Set acceptedContract
	 * @param int $acceptedContract
	 */
	public function setAcceptedContract($acceptedContract) {
		$this->acceptedContract = $acceptedContract;
		return $this;
	}

	/**
	 * Get acceptedContract
	 * @return int
	 */
	public function getAcceptedContract() {
		return $this->acceptedContract;
	}
}