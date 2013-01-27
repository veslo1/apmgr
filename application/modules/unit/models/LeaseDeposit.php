<?php
/**
 * Created on April 25, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Deposits tied to the lease
 * </p>
 */


class Unit_Model_LeaseDeposit extends ZFModel_ParentModel {

	/**
	 *@var leaseId
	 */
	protected $leaseId;

	/**
	 *@var depositId
	 */
	protected $depositId;

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
		$this->setDbTable('Unit_Model_DbTable_LeaseDeposit');
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
	 * depositId
	 */
	public function setDepositId( $var ) {
		$this->depositId = $var;
	}

	public function getDepositId() {
		return $this->depositId;
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
	 * amount
	 */
	public function setAmount( $var ) {
		$this->amount = $var;
	}

	public function getAmount() {
		return $this->amount;
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
	public function createLeaseDeposit() {
		$db = Zend_Registry::get('db'); // used for all in transaction
		//print_r($db); die;;
		try {
			// fetch the amount of the fee
			$depositObj = new Financial_Model_Deposit();
			$depositItem = $depositObj->findById( $this->getDepositId() );
			 
			// create and initialize the bill creation object
			$billCreation = new Financial_Model_BillCreation(array( 'db'=>$db ));
			$billCreation->setAccountLink( $depositItem->getAccountLink() );
			$billCreation->setDueDate( $this->getDueDate() );
			$billCreation->setBillAmountDue( $depositItem->getAmount() );
			 
			// create bill
			$billId = $billCreation->createBill();
			 
			// save to leaseDeposit
			$this->setDbAdapter( $db );
			$this->setBillId( $billId );
			$this->setAmount( $depositItem->getAmount() );
			$id = $this->save();
				
			return $id;
		}
		catch ( Exception $e) {
			$this->db->rollBack();
			echo $e->getMessage();
			return false;
		}
	}

	/**
	 *  Fetch lease deposits
	 */
	public function getLeaseDeposits() {
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('ld'=>'leaseDeposit'), array('amount'=>'ld.amount', 'billId'=>'ld.billId') )
		->join( array('d'=>'deposit'),'ld.depositId=d.id',array('name'=>'d.name' ))
		->where('ld.leaseId=?', $this->getLeaseId());

		$resultSet = $db->query( $query );
			
		$container = null;
		foreach ($resultSet as $row)
		$container[] = $row;

		return $container;
	}
}
?>
