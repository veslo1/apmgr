<?php
/**
 *
 * @author rnelson
 */
class Applicant_Model_RentalCriminalHistory extends ZFModel_ParentModel {
	//	TODO We use applicantId
	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_ApplicantRentalCriminalHistory');
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
	 * @var NO $crimeComment
	 */
	protected $crimeComment;

	/**
	 * Set crimeComment
	 */
	public function setCrimeComment($crimeComment) {
		$this->crimeComment=$crimeComment;
		return $this;
	}
	/**
	 * Get crimeComment
	 */
	public function getCrimeComment() {
		return $this->crimeComment;
	}
	
	/**
	 * @var NO $propertyComment
	 */
	protected $propertyComment;

	/**
	 * Set propertyComment
	 */
	public function setPropertyComment($propertyComment) {
		$this->propertyComment=$propertyComment;
		return $this;
	}
	/**
	 * Get propertyComment
	 */
	public function getPropertyComment() {
		return $this->propertyComment;
	}	
}
