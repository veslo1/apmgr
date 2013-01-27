<?php
/**
 * Created on Mar 16, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Attempt to handle the bill creation process and objects better so it's not a mess of shitty array passing like i had before
 * </p>
 */


class Financial_Model_BillCreation extends ZFModel_ParentModel {

	//  Objects and variables needed for bill creation
	protected $billModel;
	protected $transactionModel;
	protected $billTransactionModel;
	protected $accountTransactionModel;
	protected $db;

	protected $transactionId;  // set only in createBill
	protected $discount;

	protected $accountLink; // used to set the account link for saving bills
	protected $discountAccountLink; // used if discount needed

	/**
	 * Constructor of this object
	 */
	public function __construct( $options=array() ) {
	    if(isset( $options['db'] )){
	        $this->db = $options['db'];
	    }
	    else{
	        throw new Exception('missingDbAdapter');
	    }	  
	    $this->billModel = new Financial_Model_Bill( array( 'dbAdapter'=> $this->db) );
	    $this->transactionModel = new Financial_Model_Transaction( array( 'dbAdapter'=> $this->db ) );
	    $this->billTransactionModel = new Financial_Model_BillTransaction( array( 'dbAdapter'=> $this->db) );
	    $this->accountTransactionModel = new Financial_Model_AccountTransaction( array( 'dbAdapter'=> $this->db) );
	}

	public function setDueDate( $var ) {
		$this->billModel->setDueDate( $var );
		if( !$this->accountTransactionModel->getDatePosted() )
		$this->accountTransactionModel->setDatePosted( $var );
	}
	public function setBillAmountDue( $var ) {
		$this->billModel->setOriginalAmountDue( $var );

		// set acccounting amount to bill amount if not set.
		// the only time bill.originalAmountDue and accountTransaction.amount should differ is with discounts (so far)
		if( !$this->accountTransactionModel->getAmount() )
		    $this->accountTransactionModel->setAmount( $var );
	}

	// If not set, it defaults to the current date
	public function setDatePosted( $var ) {
		$this->accountTransactionModel->setDatePosted( $var );
	}

	public function setAccountingAmount( $var ) {
		$this->accountTransactionModel->setAmount( $var );
	}

	public function setAccountLink( $var ){
		$this->accountLink = $var;
	}
	public function getAccountLink(){
		return $this->accountLink;
	}

	public function setDiscountAccountLink( $var ){
		$this->discountAccountLink = $var;
	}
	public function getDiscountAccountLink(){
		return $this->discountAccountLink;
	}

	public function setDiscount( $var ){
		$this->discount = $var;
	}

	public function getTransactionId(){
		return $this->transactionId;
	}

	public function setTransactionId( $var ){
		$this->transactionId = $var;
	}

	/**
	 * Currently used for creating individual bills
	 */
	public function createBill(){

		/*  bill
		 transaction
		 billTransaction
		 accountTransaction
		 */

		try{
			//  1.  Bill.  Makes a new bill
			$this->billModel->setIsPaid(0);
			$billId = $this->billModel->save();
			 
			// 2.  Transaction.  If transactionId isn't set, make a new transactionId
			if( !isset( $this->transactionId ) )
			$this->transactionId = $this->transactionModel->save();
			 
			// 3.  Bill Transaction
			$this->billTransactionModel->setBillId( $billId );
			$this->billTransactionModel->setTransactionId( $this->getTransactionId() );
			$this->billTransactionModel->save();
			 
			// 3.  Account Transaction
			//$billObj = $this->billModel->findById( $billId );
			$this->accountTransactionModel->setTransactionId($this->getTransactionId());
			$this->accountTransactionModel->setAccountLink( $this->getAccountLink() );
			$this->accountTransactionModel->saveAccountTransaction();

			// set discount
			if( $this->discount ){
				$this->accountTransactionModel->setAmount( $this->discount );
				$this->accountTransactionModel->setAccountLink( $this->getDiscountAccountLink() );
				$this->accountTransactionModel->saveAccountTransaction();
			}
			 
			return $billId;
		}
		catch ( Exception $e) {
			// rollback here kills the entire transaction. (if a transaction exists in the calling function)
			//$this->db->rollBack();
			echo $e->getMessage();
			return false;
		}
	}
}
?>
