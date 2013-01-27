<?php
/**
 *  Class created 9/11/10 to handle forfeited fees
 */
class Financial_Model_ForfeitedFee extends ZFModel_ParentModel {

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Financial_Model_DbTable_ForfeitedFee');
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
	 * @var NO $billId
	 */
	protected $billId;

	/**
	 * Set billId
	 */
	public function setBillId($billId) {
		$this->billId=$billId;
		return $this;
	}

	/**
	 * Get billId
	 */
	public function getBillId() {
		return $this->billId;
	}

	/**
	 * @var NO $amount
	 */
	protected $amount;

	/**
	 * Set amount
	 */
	public function setAmount($amount) {
		$this->amount=$amount;
		return $this;
	}

	/**
	 * Get amount
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * @var NO $feeId
	 */
	protected $feeId;

	/**
	 * Get feeId
	 */
	public function getFeeId() {
		return $this->feeId;
	}

	/**
	 * Set feeId
	 */
	public function setFeeId($feeId) {
		$this->feeId=$feeId;
		return $this;
	}

	/**
	 * @var NO $transactionId
	 */
	protected $transactionId;

	/**
	 * Get transactionId
	 */
	public function getTransactionId() {
		return $this->transactionId;
	}

	/**
	 * Set TransactionId
	 */
	public function setTransactionId($var) {
		$this->transactionId=$var;
		return $this;
	}
        
        /**
	 * @var NO $comment
	 */
	protected $comment; 
	/**
	 * Set Comment
	 */
	public function setComment($var) {
		$this->comment=$var;
		return $this;
	}        
        
        /**
	 * Get comment
	 */
	public function getComment() {
		return $this->comment;
	}	

	/**
	 *  Returns the summed forfeits for a specified bill.  Used for finding the max refund amount
	 */
	public function getForfeitSumByBillId(){
		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from( array('forfeitedFee') , array('forfeitedFee'=> new Zend_Db_Expr('SUM(amount)')))
		->where( 'billId=?',$this->getBillId() )
		->group('billId');

		$row = $db->fetchRow($select);

		if( $row )
		return $row['forfeitedFee'];
		else
		return 0;
	}

	/**
	 *  Process forfeits
	 */
	public function forfeit(){
		$creation = new Financial_Model_RefundCreation();
		$creation->setSetting('forfeitCashAccount');
		$creation->setObject( $this );
		
		$result = $creation->forfeit();
                $this->setMessageState( $creation->getMessageState() );
                return $result;
	}
} // end class
