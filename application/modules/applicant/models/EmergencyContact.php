<?php
/**
 *
 * @author rnelson
 */
class Applicant_Model_EmergencyContact extends ZFModel_ParentModel {
	//	TODO We use applicantId now
	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_ApplicantEmergencyContact');
	}

	/**
	 * @var NO $userId
	 */
	protected $applicantId;

	/**
	 * Set userId
	 */
	public function setApplicantId($userId) {
		$this->applicantId=$userId;
		return $this;
	}

	/**
	 * Get userId
	 */
	public function getApplicantId() {
		return $this->applicantId;
	}

	/**
	 * @var YES $contactName
	 */
	protected $contactName;

	/**
	 * Set contactName
	 */
	public function setContactName($contactName) {
		$this->contactName=$contactName;
		return $this;
	}
	/**
	 * Get contactName
	 */
	public function getContactName() {
		return $this->contactName;
	}
	/**
	 * @var NO $address
	 */
	protected $address;

	/**
	 * Set address
	 */
	public function setAddress($address) {
		$this->address=$address;
		return $this;
	}
	/**
	 * Get address
	 */
	public function getAddress() {
		return $this->address;
	}
	/**
	 * @var NO $city
	 */
	protected $city;

	/**
	 * Set city
	 */
	public function setCity($city) {
		$this->city=$city;
		return $this;
	}
	/**
	 * Get city
	 */
	public function getCity() {
		return $this->city;
	}
	/**
	 * @var YES $state
	 */
	protected $state;

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
	 * @var NO $zip
	 */
	protected $zip;

	/**
	 * Set zip
	 */
	public function setZip($zip) {
		$this->zip=$zip;
		return $this;
	}
	/**
	 * Get zip
	 */
	public function getZip() {
		return $this->zip;
	}
	/**
	 * @var NO $mainPhone
	 */
	protected $mainPhone;

	/**
	 * Set mainPhone
	 */
	public function setMainPhone($mainPhone) {
		$this->mainPhone=$mainPhone;
		return $this;
	}
	/**
	 * Get mainPhone
	 */
	public function getMainPhone() {
		return $this->mainPhone;
	}
	/**
	 * @var YES $workPhone
	 */
	protected $workPhone;

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
	 * @var NO $relationship
	 */
	protected $relationship;

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
}
