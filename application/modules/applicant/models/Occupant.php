<?php
/**
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_Occupant extends ZFModel_ParentModel {

	/**
	 * @var int $applicantId
	 */
	protected $applicantId;

	/**
	 * @var string $name
	 */
	protected $name;

	/**
	 * @var string $relationship
	 */
	protected $relationship;

	/**
	 * @var int $sex
	 */
	protected $sex;

	/**
	 * Adding the type of identification the user uses
	 * @var int
	 */
	protected $idIdentification;

	/**
	 * @var string $identification
	 */
	protected $identification;

	/**
	 * @var int $state
	 */
	protected $state;

	/**
	 * @var string $ssn
	 */
	protected $ssn;

	/**
	 * @var string $dob
	 */
	protected $dob;

	/**
	 * @param array $options
	 */
	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_Occupant');
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
	 * @return int
	 */
	public function getApplicantId() {
		return $this->applicantId;
	}

	/**
	 * Set name
	 */
	public function setName($name) {
		$this->name=$name;
		return $this;
	}

	/**
	 * Get name
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set relationship
	 */
	public function setRelationship($relationship) {
		$this->relationship=$relationship;
		return $this;
	}

	/**
	 * Get relationship
	 */
	public function getRelationship() {
		return $this->relationship;
	}

	/**
	 * Set sex
	 */
	public function setSex($sex) {
		$this->sex=$sex;
		return $this;
	}

	/**
	 * Get sex
	 */
	public function getSex() {
		return $this->sex;
	}

	/**
	 * Set driversLicense
	 */
	public function setDriversLicense($driversLicense) {
		$this->driversLicense=$driversLicense;
		return $this;
	}
	/**
	 * Get driversLicense
	 */
	public function getDriversLicense() {
		return $this->driversLicense;
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

	/**
	 * Set govtLicense
	 */
	public function setGovtLicense($govtLicense) {
		$this->govtLicense=$govtLicense;
		return $this;
	}
	/**
	 * Get govtLicense
	 */
	public function getGovtLicense() {
		return $this->govtLicense;
	}

	/**
	 * Set ssn
	 */
	public function setSsn($ssn) {
		$this->ssn=$ssn;
		return $this;
	}

	/**
	 * Get ssn
	 */
	public function getSsn() {
		return $this->ssn;
	}

	/**
	 * Set dob
	 */
	public function setDob($dob) {
		$this->dob=$dob;
		return $this;
	}

	/**
	 * Get dob
	 */
	public function getDob() {
		return $this->dob;
	}

	/**
	 * @param string $identification
	 */
	public function setIdentification($identification) {
		$this->identification = $identification;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getIdentification() {
		return $this->identification;
	}

	/**
	 * set the type of identification the user uses
	 * @param int $idIdentification
	 * @return Applicant_Model_Occupant
	 */
	public function setIdIdentification($idIdentification){
		$this->idIdentification = $idIdentification;
		return $this;
	}

	/**
	 * Retrieve the type of identification
	 * @return number
	 */
	public function getIdIdentification(){
		return $this->idIdentification;
	}
}