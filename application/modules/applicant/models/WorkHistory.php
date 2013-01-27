<?php
/**
 *
 * @author rnelson
 */
class Applicant_Model_WorkHistory extends ZFModel_ParentModel {

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_ApplicantWorkHistory');
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
	 * @var NO $employerName
	 */
	protected $employerName;

	/**
	 * Set employerName
	 */
	public function setEmployerName($employerName) {
		$this->employerName=$employerName;
		return $this;
	}
	/**
	 * Get employerName
	 */
	public function getEmployerName() {
		return $this->employerName;
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
	 * @var NO $employerPhone
	 */
	protected $employerPhone;

	/**
	 * Set employerPhone
	 */
	public function setEmployerPhone($employerPhone) {
		$this->employerPhone=$employerPhone;
		return $this;
	}
	/**
	 * Get employerPhone
	 */
	public function getEmployerPhone() {
		return $this->employerPhone;
	}
	/**
	 * @var NO $monthlyIncome
	 */
	protected $monthlyIncome;

	/**
	 * Set monthlyIncome
	 */
	public function setMonthlyIncome($monthlyIncome) {
		$this->monthlyIncome=$monthlyIncome;
		return $this;
	}
	/**
	 * Get monthlyIncome
	 */
	public function getMonthlyIncome() {
		return $this->monthlyIncome;
	}
	/**
	 * @var NO $dateStarted
	 */
	protected $dateStarted;

	/**
	 * Set dateStarted
	 */
	public function setDateStarted($dateStarted) {
		$this->dateStarted=$dateStarted;
		return $this;
	}
	/**
	 * Get dateStarted
	 */
	public function getDateStarted() {
		return $this->dateStarted;
	}
	/**
	 * @var NO $dateEnded
	 */
	protected $dateEnded;

	/**
	 * Set dateEnded
	 */
	public function setDateEnded($dateEnded) {
		$this->dateEnded=$dateEnded;
		return $this;
	}
	/**
	 * Get dateEnded
	 */
	public function getDateEnded() {
		return $this->dateEnded;
	}
	/**
	 * @var NO $supervisorName
	 */
	protected $supervisorName;

	/**
	 * Set supervisorName
	 */
	public function setSupervisorName($supervisorName) {
		$this->supervisorName=$supervisorName;
		return $this;
	}
	/**
	 * Get supervisorName
	 */
	public function getSupervisorName() {
		return $this->supervisorName;
	}
	/**
	 * @var NO $supervisorPhone
	 */
	protected $supervisorPhone;

	/**
	 * Set supervisorPhone
	 */
	public function setSupervisorPhone($supervisorPhone) {
		$this->supervisorPhone=$supervisorPhone;
		return $this;
	}
	/**
	 * Get supervisorPhone
	 */
	public function getSupervisorPhone() {
		return $this->supervisorPhone;
	}
	/**
	 * @var YES $isCurrentEmployer
	 */
	protected $isCurrentEmployer;

	/**
	 * Set isCurrentEmployer
	 */
	public function setIsCurrentEmployer($isCurrentEmployer) {
		$this->isCurrentEmployer=$isCurrentEmployer;
		return $this;
	}
	/**
	 * Get isCurrentEmployer
	 */
	public function getIscurrentEmployer() {
		return $this->isCurrentEmployer;
	}
}
