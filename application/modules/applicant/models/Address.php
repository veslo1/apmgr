<?php

class Applicant_Model_Address extends ZFModel_ParentModel {

	/**
	 * @var string $applicantId
	 */
	protected $applicantId;

	/**
	 * @var integer $address
	 */
	protected $address;

	/**
	 * @var string $city
	 */
	protected $city;

	/**
	 * @var string $state
	 */
	protected $state;

	/**
	 * @var string $rent
	 */
	protected $rent;

	/**
	 * @var string $apartmentName
	 */
	protected $apartmentName;

	/**
	 * @var string $ownerName
	 */
	protected $ownerName;

	/**
	 * @var string $apartmentPhone
	 */
	protected $apartmentPhone;

	/**
	 * @var string $moveInDate
	 */
	protected $moveInDate;

	/**
	 * @var string $moveOutDate
	 */
	protected $moveOutDate;

	/**
	 * @var string $reasonForLeaving
	 */
	protected $reasonForLeaving;

	/**
	 * @var string $isCurrentResidence
	 */
	protected $isCurrentResidence;

	public function __construct( array $options=null ) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_ApplicantAddress');
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
	 * Set address
	 */
	public function setAddress($var) {
		$this->address=$var;
	}

	/**
	 * Get address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Set city
	 */
	public function setCity($var) {
		$this->city=$var;
	}

	/**
	 * Get city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Set state
	 */
	public function setState($var) {
		$this->state=$var;
	}

	/**
	 * Get state
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * Set rent
	 */
	public function setRent($var) {
		$this->rent=$var;
	}

	/**
	 * Get rent
	 */
	public function getRent() {
		return $this->rent;
	}

	/**
	 * Set apartmentName
	 */
	public function setApartmentName($var) {
		$this->apartmentName=$var;
	}

	/**
	 * Get apartmentName
	 */
	public function getApartmentName() {
		return $this->apartmentName;
	}

	/**
	 * Set ownerName
	 */
	public function setOwnerName($var) {
		$this->ownerName=$var;
	}

	/**
	 * Get ownerName
	 */
	public function getOwnerName() {
		return $this->ownerName;
	}

	/**
	 * Set apartment phone
	 */
	public function setApartmentPhone($var) {
		$this->apartmentPhone=$var;
	}

	/**
	 * Get apartment phone
	 */
	public function getApartmentPhone() {
		return $this->apartmentPhone;
	}

	/**
	 * Set move in date
	 */
	public function setMoveInDate($var) {
		$this->moveInDate=$var;
	}

	/**
	 * Get move in date
	 */
	public function getMoveInDate() {
		return $this->moveInDate;
	}

	/**
	 * Set move out date
	 */
	public function setMoveOutDate($var) {
		if( empty($var) ) {
			$var=null; // this is so null is stored in date field rather than '', which generates an error
		}
		
		//$var = '0000-00-00';
		$this->moveOutDate=$var;
	}

	/**
	 * Get move out date
	 */
	public function getMoveOutDate() {
		return $this->moveOutDate;
	}

	/**
	 * Set reason for leaving
	 */
	public function setReasonForLeaving($var) {
		$this->reasonForLeaving=$var;
	}

	/**
	 * Get reason for leaving
	 */
	public function getReasonForLeaving() {
		return $this->reasonForLeaving;
	}

	/**
	 * Set isCurrentResidence
	 */
	public function setIsCurrentResidence($var) {
		$this->isCurrentResidence=$var;
	}

	/**
	 * Get reason for leaving
	 */
	public function getIsCurrentResidence() {
		return $this->isCurrentResidence;
	}
}
?>