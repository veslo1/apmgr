<?php
/**
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 * @package applicant
 * @subpackage model
 * @internal Model to define the applicant personal info
 */
class Applicant_Model_PersonalInfo extends ZFModel_ParentModel {

	/**
	 * @var string $fullName
	 */
	protected $fullName;
	
	/**
	 * @var string $phone
	 */
	protected $phone;

	/**
	 * @var integer $applicantId
	 */
	protected $applicantId;

	/**
	 * @var string $identification
	 */
	protected $identification;

	/**
	 * @var string $state
	 */
	protected $state;

	/**
	 * @var string $formerLastName
	 */
	protected $formerLastName;

	/**
	 * @var int $ssn
	 */
	protected $ssn;

	/**
	 * @var date $dob
	 */
	protected $dob;

	/**
	 * @var float $height
	 */
	protected $height;

	/**
	 * @var float $weight
	 */
	protected $weight;

	/**
	 * @var int $sex
	 */
	protected $sex;

	/**
	 * @var string $eyeColor
	 */
	protected $eyeColor;

	/**
	 * @var string $hairColor
	 */
	protected $hairColor;

	/**
	 * @var string $maritalStatus
	 */
	protected $maritalStatus;

	/**
	 * @var int $usCitizen
	 */
	protected $usCitizen;

	/**
	 * @var int $smoke
	 */
	protected $smoke;

	/**
	 * @var int $havePets
	 */
	protected $havePets;

	/**
	 * @var string $petDetails
	 */
	protected $petDetails;

	public function __construct( array $options=null ) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_PersonalInfo');
	}

	/**
	 * Set applicantId
	 */
	public function setApplicantId($applicantId) {
		$this->applicantId = $applicantId;
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
	 * Set phone
	 */
	public function setPhone($phone) {
		$this->phone=$phone;
		return $this;
	}

	/**
	 * Get phone
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Set state
	 */
	public function setState($state) {
		$this->state = $state;
		return $this;
	}

	/**
	 * Get state
	 */
	public function getState() {
		return $this->state;
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
	 * Set formerLastName
	 */
	public function setFormerLastName($formerLastName) {
		$this->formerLastName = $formerLastName;
		return $this;
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
	 * Get formerLastName
	 */
	public function getFormerLastName() {
		return $this->formerLastName;
	}

	/**
	 * Set dob
	 */
	public function setDob($dob) {
		$this->dob = $dob;
		return $this;
	}

	/**
	 * Get dob
	 */
	public function getDob() {
		return $this->dob;
	}

	/**
	 * Set height
	 */
	public function setHeight($height) {
		$this->height = (int)$height;
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
		$this->weight = (double)$weight;
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
		$this->sex = $sex;
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
		$this->eyeColor = $eyeColor;
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
		$this->hairColor = $hairColor;
		return $this;
	}

	/**
	 * Get hairColor
	 */
	public function getHairColor() {
		return $this->hairColor;
	}

	/**
	 * Set maritalStatus
	 * @var string $maritalStatus
	 */
	public function setMaritalStatus($maritalStatus) {
		$this->maritalStatus = $maritalStatus;
		return $this;
	}

	/**
	 * Get maritalStatus
	 */
	public function getMaritalStatus() {
		return $this->maritalStatus;
	}

	/**
	 * Set usCitizen
	 */
	public function setUsCitizen($usCitizen) {
		$this->usCitizen = $usCitizen;
		return $this;
	}

	/**
	 * Get usCitizen
	 */
	public function getUsCitizen() {
		return $this->usCitizen;
	}

	/**
	 * Set smoke
	 */
	public function setSmoke($smoke) {
		$this->smoke = $smoke;
		return $this;
	}

	/**
	 * Get smoke
	 */
	public function getSmoke() {
		return $this->smoke;
	}

	/**
	 * Set havePets
	 * @param int $havePets
	 */
	public function setHavePets($havePets) {
		$this->havePets = $havePets;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getHavePets() {
		return $this->havePets;
	}

	/**
	 * Set petDetails
	 * @var string $petDetails
	 */
	public function setPetDetails($petDetails) {
		$this->petDetails = $petDetails;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPetDetails() {
		return $this->petDetails;
	}
}
?>
