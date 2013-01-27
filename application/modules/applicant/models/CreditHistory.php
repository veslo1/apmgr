<?php
/**
 *
 * @author rnelson
 */
class Applicant_Model_CreditHistory extends ZFModel_ParentModel {

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_ApplicantCreditHistory');
	}
	/**
	 * @var NO $id
	 */
	protected $id;

	/**
	 * Set id
	 */
	public function setId($id) {
		$this->id=$id;
		return $this;
	}
	/**
	 * Get id
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * @var NO $dateCreated
	 */
	protected $dateCreated;

	/**
	 * Set dateCreated
	 */
	public function setDateCreated($dateCreated) {
		$this->dateCreated=$dateCreated;
		return $this;
	}
	/**
	 * Get dateCreated
	 */
	public function getDateCreated() {
		return $this->dateCreated;
	}
	/**
	 * @var YES $dateUpdated
	 */
	protected $dateUpdated;

	/**
	 * Set dateUpdated
	 */
	public function setDateUpdated($dateUpdated) {
		$this->dateUpdated=$dateUpdated;
		return $this;
	}
	/**
	 * Get dateUpdated
	 */
	public function getDateUpdated() {
		return $this->dateUpdated;
	}

	/**
	 * @var NO $applicantId
	 */
	protected $applicantId;

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
	 * @var NO $bankName
	 */
	protected $bankName;

	/**
	 * Set bankName
	 */
	public function setBankName($bankName) {
		$this->bankName=$bankName;
		return $this;
	}
	/**
	 * Get bankName
	 */
	public function getBankName() {
		return $this->bankName;
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
	 * @var NO $creditCards
	 */
	protected $creditCards;

	/**
	 * Set creditCards
	 */
	public function setCreditCards($creditCards) {
		$this->creditCards=$creditCards;
		return $this;
	}
	/**
	 * Get creditCards
	 */
	public function getCreditCards() {
		return $this->creditCards;
	}
	/**
	 * @var NO $nonWorkIncome
	 */
	protected $nonWorkIncome;

	/**
	 * Set nonWorkIncome
	 */
	public function setNonWorkIncome($nonWorkIncome) {
		$this->nonWorkIncome=$nonWorkIncome;
		return $this;
	}
	/**
	 * Get nonWorkIncome
	 */
	public function getNonWorkIncome() {
		return $this->nonWorkIncome;
	}
	/**
	 * @var NO $creditProblems
	 */
	protected $creditProblems;

	/**
	 * Set creditProblems
	 */
	public function setCreditProblems($creditProblems) {
		$this->creditProblems=$creditProblems;
		return $this;
	}
	/**
	 * Get creditProblems
	 */
	public function getCreditProblems() {
		return $this->creditProblems;
	}
}
