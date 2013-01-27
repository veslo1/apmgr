<?php
/**
 *
 * @author <jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_Appliance extends ZFModel_ParentModel {
	/**
	 * @var int $applicantId
	 */
	protected $applicantId;

	/**
	 * @var int $unitId
	 */
	protected $unitId;

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_Appliance');
	}

	/**
	 * Set applicantId
	 * @param int $applicantId
	 */
	public function setApplicantId($applicantId) {
		$this->applicantId=$applicantId;
		return $this;
	}

	/**
	 * Get applicantId
	 * @return int
	 */
	public function getApplicantId() {
		return $this->applicantId;
	}

	/**
	 * Set unitId
	 * @param int $unitId
	 */
	public function setUnitId($unitId) {
		$this->unitId=$unitId;
		return $this;
	}

	/**
	 * Get unitId
	 * @return int
	 */
	public function getUnitId() {
		return $this->unitId;
	}
}
