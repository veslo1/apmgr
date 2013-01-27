<?php
/**
 * Persist an applicant operation in the feeBill object
 * @author <jvazquez@debserverp4.com.ar>
 */
class Applicant_Model_FeeBill extends ZFModel_ParentModel {

	/**
	 * @var double $amount
	 */
	protected $amount;

	/**
	 * @var int $feeId
	 */
	protected $feeId;

	/**
	 * @var int $billId
	 */
	protected $billId;

	/**
	 * @var int $applicantId
	 */
	protected $applicantId;

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_FeeBill');
	}

	/**
	 * Set the feeId value from applicatFeeSetting
	 * @param int $feeId
	 * @return Applicant_Model_FeeBill
	 */
	public function setFeeId($feeId) {
		$this->feeId=$feeId;
		return $this;
	}

	/**
	 * Get the used feeId for this operation
	 * @return int
	 */
	public function getFeeId() {
		return $this->feeId;
	}

	/**
	 * Set the billId for this operation
	 * @param int $billId
	 * @return Applicant_Model_FeeBill
	 */
	public function setBillId($billId) {
		$this->billId=$billId;
		return $this;
	}
	/**
	 * Get the used billId
	 * @return int
	 */
	public function getBillId() {
		return $this->billId;
	}


	/**
	 * Set the amount for the transaction
	 * @param double $amount
	 * @return Applicant_Model_FeeBill
	 */
	public function setAmount($amount) {
		$this->amount=$amount;
		return $this;
	}

	/**
	 * Get amount
	 * @return double
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 *
	 * Set the applicant id
	 * @param int $applicantId
	 * @return Applicant_Model_FeeBill::
	 */
	public function setApplicantId($applicantId) {
		$this->applicantId = $applicantId;
		return $this;
	}

	/**
	 *
	 * Return the applicantId
	 * @return int
	 */
	public function getApplicantId() {
		return $this->applicantId;
	}
}
