<?php
/**
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 * Applicant spouse model
 */
class Applicant_Model_Spouse extends ZFModel_ParentModel {

	/**
	 * @var int $applicantId
	 */
	protected $applicantId;

	/**
	 * @var string $fullName
	 */
	protected $fullName;

	/**
	 * @var string $ssn
	 */
	protected $ssn;

	/**
	 * @var int $state
	 */
	protected $state;

	/**
	 * @var date $dob
	 */
	protected $dob;

	/**
	 * @var string $cityStateZip
	 */
	protected $cityStateZip;

	/**
	 * @var YES $height
	 */
	protected $height;

	/**
	 * @var double $weight
	 */
	protected $weight;

	/**
	 * @var YES $sex
	 */
	protected $sex;

	/**
	 * @var YES $eyeColor
	 */
	protected $eyeColor;

	/**
	 * @var string $hairColor
	 */
	protected $hairColor;

	/**
	 * @var YES $usCitizen
	 */
	protected $usCitizen;

	/**
	 * @var YES $workPhone
	 */
	protected $workPhone;

	/**
	 * @var YES $cellPhone
	 */
	protected $cellPhone;

	/**
	 * @var YES $position
	 */
	protected $position;

	/**
	 * @var YES $emailAddress
	 */
	protected $emailAddress;

	/**
	 * @var YES $dateBeganJob
	 */
	protected $dateBeganJob;

	/**
	 * @var YES $income
	 */
	protected $income;

	/**
	 * @var YES $superVisorName
	 */
	protected $superVisorName;

	/**
	 * @var YES $superVisorPhone
	 */
	protected $superVisorPhone;

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_ApplicantSpouse');
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
	 * Set fullName
	 */
	public function setFullName($fullName) {
		$this->fullName=$fullName;
		return $this;
	}

	/**
	 * Get fullName
	 */
	public function getFullName() {
		return $this->fullName;
	}

	/**
	 * Set ssn
	 * @param string $ssn
	 */
	public function setSsn($ssn) {
		$this->ssn=$ssn;
		return $this;
	}

	/**
	 * Get ssn
	 * @return string
	 */
	public function getSsn() {
		return $this->ssn;
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
	 * Set dob
	 * @param date $dob
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
	 * Set cityStateZip
	 */
	public function setCityStateZip($cityStateZip) {
		$this->cityStateZip=$cityStateZip;
		return $this;
	}

	/**
	 * Get cityStateZip
	 */
	public function getCitystateZip() {
		return $this->cityStateZip;
	}

	/**
	 * Set height
	 */
	public function setHeight($height) {
		$this->height=(int)$height;
		return $this;
	}

	/**
	 * Get height
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * Set weight
	 */
	public function setWeight($weight) {
		$this->weight=(double)$weight;
		return $this;
	}

	/**
	 * Get weight
	 */
	public function getWeight() {
		return $this->weight;
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
	 * Set eyeColor
	 */
	public function setEyeColor($eyeColor) {
		$this->eyeColor=$eyeColor;
		return $this;
	}

	/**
	 * Get eyeColor
	 */
	public function getEyeColor() {
		return $this->eyeColor;
	}

	/**
	 * Set hairColor
	 */
	public function setHairColor($hairColor) {
		$this->hairColor=$hairColor;
		return $this;
	}

	/**
	 * Get hairColor
	 */
	public function getHairColor() {
		return $this->hairColor;
	}

	/**
	 * Set usCitizen
	 */
	public function setUsCitizen($usCitizen) {
		$this->usCitizen=$usCitizen;
		return $this;
	}

	/**
	 * Get usCitizen
	 */
	public function getUscitizen() {
		return $this->usCitizen;
	}

	/**
	 * Set workPhone
	 */
	public function setWorkPhone($workPhone) {
		$this->workPhone=$workPhone;
		return $this;
	}

	/**
	 * Get workPhone
	 */
	public function getWorkPhone() {
		return $this->workPhone;
	}

	/**
	 * Set cellPhone
	 */
	public function setCellPhone($cellPhone) {
		$this->cellPhone=$cellPhone;
		return $this;
	}

	/**
	 * Get cellPhone
	 */
	public function getCellPhone() {
		return $this->cellPhone;
	}

	/**
	 * Set position
	 */
	public function setPosition($position) {
		$this->position=$position;
		return $this;
	}

	/**
	 * Get position
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * Set emailAddress
	 */
	public function setEmailAddress($emailAddress) {
		$this->emailAddress=$emailAddress;
		return $this;
	}

	/**
	 * Get emailAddress
	 */
	public function getEmailAddress() {
		return $this->emailAddress;
	}

	/**
	 * Set dateBeganJob
	 */
	public function setDateBeganJob($dateBeganJob) {
		if( empty($dateBeganJob) )
		$dateBeganJob='0000-00-00';
		$this->dateBeganJob=$dateBeganJob;
		return $this;
	}

	/**
	 * Get dateBeganJob
	 */
	public function getDateBeganJob() {
		return $this->dateBeganJob;
	}

	/**
	 * Set income
	 */
	public function setIncome($income) {
		if(empty($income))
		$income=0;
		$this->income=$income;
		return $this;
	}

	/**
	 * Get income
	 */
	public function getIncome() {
		return $this->income;
	}

	/**
	 * Set superVisorName
	 */
	public function setSuperVisorName($superVisorName) {
		$this->superVisorName=$superVisorName;
		return $this;
	}

	/**
	 * Get superVisorName
	 */
	public function getSuperVisorName() {
		return $this->superVisorName;
	}

	/**
	 * Set superVisorPhone
	 */
	public function setSuperVisorPhone($superVisorPhone) {
		$this->superVisorPhone=$superVisorPhone;
		return $this;
	}

	/**
	 * Get superVisorPhone
	 */
	public function getSuperVisorPhone() {
		return $this->superVisorPhone;
	}
}