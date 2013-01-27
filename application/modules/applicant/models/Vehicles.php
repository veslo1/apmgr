<?php
/**
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_Vehicles extends ZFModel_ParentModel {
	/**
	 * @var int $applicantId
	 */
	protected $applicantId;

	/**
	 * @var string $brand
	 */
	protected $brand;

	/**
	 * @var string $license
	 */
	protected $license;

	/**
	 * @var int $state
	 */
	protected $state;

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_Vehicles');
	}

	/**
	 * Set applicantId
	 */
	public function setApplicantid($applicantId) {
		$this->applicantId=$applicantId;
		return $this;
	}

	/**
	 * Get applicantId
	 */
	public function getApplicantid() {
		return $this->applicantId;
	}

	/**
	 * Set brand
	 */
	public function setBrand($brand) {
		$this->brand=$brand;
		return $this;
	}

	/**
	 * Get brand
	 */
	public function getBrand() {
		return $this->brand;
	}

	/**
	 * Set license
	 */
	public function setLicense($license) {
		$this->license=$license;
		return $this;
	}
	/**
	 * Get license
	 */
	public function getLicense() {
		return $this->license;
	}

	/**
	 * Set state
	 */
	public function setState($state) {
		$this->state=$state;
		return $this;
	}
	/**
	 * Get state
	 */
	public function getState() {
		return $this->state;
	}
}
