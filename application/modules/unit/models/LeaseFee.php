<?php
/**
 * Created on April 25, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Fees tied to the lease
 * </p>
 */


class Unit_Model_LeaseFee extends ZFModel_ParentModel {

	/**
	 *@var leaseId
	 */
	protected $leaseId;

	/**
	 *@var feeId
	 */
	protected $feeId;

	/**
	 *@var amount
	 */
	protected $amount;

	/**
	 *@var billId
	 */
	protected $billId;

	/**
	 *@var dueDate
	 */
	protected $dueDate;

	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_LeaseFee');
	}
	 
	/**
	 * leaseId
	 */
	public function setLeaseId( $var ) {
		$this->leaseId = $var;
	}

	public function getLeaseId() {
		return $this->leaseId;
	}

	/**
	 * feeId
	 */
	public function setFeeId( $var ) {
		$this->feeId = $var;
	}

	public function getFeeId() {
		return $this->feeId;
	}

	/**
	 * amount
	 */
	public function setAmount( $var ) {
		$this->amount = $var;
	}

	public function getAmount() {
		return $this->amount;
	}

	/**
	 * billId
	 */
	public function setBillId( $var ) {
		$this->billId = $var;
	}

	public function getBillId() {
		return $this->billId;
	}

	/**
	 * dueDate - used for individual fee creation - not stoerd in db
	 */
	public function setDueDate( $var ) {
		$this->dueDate = $var;
	}

	public function getDueDate() {
		return $this->dueDate;
	}

	/**
	 *  Creates new fee for a lease
	 */
	public function createLeaseFee() {
		$db = Zend_Registry::get('db'); // used for all in transaction
		try {
			// fetch the amount of the fee
			$feeObj = new Financial_Model_Fee();
			$feeItem = $feeObj->findById( $this->getFeeId() );
			 
			// create and initialize the bill creation object
			$billCreation = new Financial_Model_BillCreation(array( 'db'=>$db ));
			$billCreation->setAccountLink( $feeItem->getAccountLink() );
			$billCreation->setDueDate( $this->getDueDate() );
			$billCreation->setBillAmountDue( $feeItem->getAmount() );
			 
			// create bill
			$billId = $billCreation->createBill();
			 
			// save to leaseFee
			$this->setDbAdapter( $db );
			$this->setBillId( $billId );
			$this->setAmount( $feeItem->getAmount() );
			$id = $this->save();
				
			return $id;
		}
		catch ( Exception $e) {
			$this->db->rollBack();
			$this->setMessageState( $e->getMessage() );
			return false;
		}
	}

	/**
	 *  Fetch lease fees
	 */
	/*
	public function getLeaseFees() {
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('lf'=>'leaseFee'), array('amount'=>'lf.amount', 'billId'=>'lf.billId') )
		->join( array('b'=>'bill'),'lf.billId=b.id',array('dueDate'=>'dueDate') )
		->join( array('f'=>'fee'),'lf.feeId=f.id',array('name'=>'f.name') )
		->where('lf.leaseId=?', $this->getLeaseId());

		$resultSet = $db->query( $query );
			
		$container = null;
		foreach ($resultSet as $row) {
		    $container[] = $row;
		}    

		return $container;
	}
	*/
}
?>
