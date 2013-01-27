<?php
/**
 * Created on June 15, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Model for making payments
 * </p>
 */


class Financial_Model_PaymentCreation extends ZFModel_ParentModel {

	private $paymentObj;
	private $paymentDetailObj;
	private $accountLink;
	private $reuseDetailId;
	private $paid;
	private $transactionId;
	private $db;
	private $dbTransaction;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		$this->dbTransaction = false;  // used to start a transaction and rollback if a current transaction is not passed in
		if(isset( $options['db'] )){
			$this->db = $options['db'];
		}
		else{
			//throw new Exception('missingDbAdapter');
			$this->db = Zend_Registry::get('db');
			$this->dbTransaction = true;
		}
	  
		$this->paymentObj = new Financial_Model_Payment(array( 'dbAdapter'=> $this->db ));
		$this->paymentDetailObj = new Financial_Model_PaymentDetail(array( 'dbAdapter'=> $this->db ));
		$this->setPaid('1');
	}

	/**
	 * accountLink
	 */
	public function setAccountLink( $var ) {
		$this->accountLink = $var;
	}

	public function getAccountLink(){
		return $this->accountLink;
	}

	/**
	 * amountPaid
	 */
	public function setAmountPaid( $var ) {
		$this->paymentObj->setAmtPaid( $var );
	}

	/**
	 * billId
	 */
	public function setBillId( $var ) {
		$this->paymentObj->setBillId( $var );
	}

	/**
	 * payor
	 */
	public function setPayor( $var ) {
		$this->paymentDetailObj->setPayor( $var );
	}

	/**
	 * paymentType
	 */
	public function setPaymentType( $var ) {
		$this->paymentDetailObj->setPaymentType( $var );
	}

	/**
	 * totalAmount
	 */
	public function setTotalAmount( $var ) {
		$this->paymentDetailObj->setTotalAmount( $var );
	}

	/**
	 *  Get/Set payment detail id for reuse.
	 */
	public function setReuseDetailId($var){
		$this->reuseDetailId = $var;
	}

	public function getReuseDetailId(){
		return $this->reuseDetailId;
	}

	/**
	 *  Default to 1 in the constructor
	 *  Pass 1 or 0
	 */
	public function setPaid($var){
		$this->paid = $var;
	}

	/**
	 *  Who doesn't like getting paid?
	 */
	public function getPaid(){
		return $this->paid;
	}

	/**
	 *  returns created transactionId of the payment
	 */
	public function getTransactionId(){
		return $this->paymentObj->getTransactionId();
	}

	/**
	 *  Posts payment.  Currently assumes paid in full.  To partial pay, this will need a modification to not set isPaid
	 */
	public function postPayment() {
		$dbTransaction = false;  //
		if( $this->dbTransaction ){
			$this->db->beginTransaction();
		}

		// 1.  Transaction objects
		//       a)  Update payment table with transactionId
		//       b)  Create accountTransaction record
		// 2.  insert into payment detail
		// 3.  insert into payment table
		// 4.  update Bill table isPaid column

		try{
			// insert into accountTransaction table
			// debit Cash
			// credit Rent Receivable

			if( $this->getAccountLink() ) {
				$transactionId = $this->addAccountTransaction();
				$this->addPayment( $transactionId );
				$this->updateBill( $transactionId );
				if( $this->dbTransaction ){
					$this->db->commit();
				}
				return true;
			}
		}
		catch ( Exception $e) {
			if( $this->dbTransaction ){
				$this->db->rollback();
			}
			return false;
		}
	}

	/**
	 *  Add account transactions
	 */
	private function addAccountTransaction(){
		$acctTrans = new Financial_Model_AccountTransaction(array( 'dbAdapter'=> $this->db ));
		$acctTrans->setAmount( $this->paymentObj->getAmtPaid() );
		$acctTrans->setAccountLink( $this->getAccountLink() );
	  
		if( !$acctTrans->saveAccountTransaction() ) {
			$this->setMessageState( 'errorSavingAccountTransaction' );
			throw new Exception();
		}
		else{
			return $acctTrans->getTransactionId();
		}
	}

	/**
	 *  Add payment detail and payment rows
	 */
	private function addPayment($transactionId){
		// Creates payment detail records

		// used for if no reuse or reuse but no pmt id, make a new pmt detail record and use that id
		if( !$this->paymentDetailObj->getId() || !$this->getReuseDetailId()){
			$this->paymentDetailObj->setId(NULL);
			$pmtDetailId = $this->paymentDetailObj->save();

			if( !$pmtDetailId ) {
				$this->setMessageState( 'errorSavingPaymentDetail' );
				throw new Exception();
			}
			$this->paymentDetailObj->setId( $pmtDetailId );
		}
			
		// create payment record
		$this->paymentObj->setPaymentDetailId( $this->paymentDetailObj->getId() );
		$this->paymentObj->setTransactionId( $transactionId );
		if(!$this->paymentObj->save() ) {
			$this->setMessageState( 'errorSavingPayment' );
			throw new Exception();
		}
		else{
			return true;
		}
	}

	/**
	 *  Add bill information
	 */
	private function updateBill( $transactionId ){
		$result = $this->updateIsPaid();
		$result2 = $this->addBillTransaction( $transactionId );
	  
		if( $result && $result2 ) {
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 *  Update isPaid flag
	 */
	private function updateIsPaid(){
		// update isPaid flag on bill since these bills are paid in full
		$billObj = new Financial_Model_Bill(array( 'dbAdapter'=> $this->db ));
		$bill = $billObj->findById( $this->paymentObj->getBillId() );

		$bill->setIsPaid( $this->getPaid() );
		$savedBill = $bill->save();

		if( $savedBill==false ) {
			$this->setMessageState( 'errorSavingBill' );
			throw new Exception();
		}
		else{
			return true;
		}
	}

	/**
	 *  Add bill transaction record
	 */
	private function addBillTransaction( $transactionId ) {
		// Add bill transaction record
		$billTransObj = new Financial_Model_BillTransaction(array( 'dbAdapter'=> $this->db ));
		$billTransObj->setBillId( $this->paymentObj->getBillId() );
		$billTransObj->setTransactionId( $transactionId );
		$savedBillTrans = $billTransObj->save();

		if( $savedBillTrans==false ) {
			$this->setMessageState( 'errorSavingBillTransaction' );
			throw new Exception();
		}
		else{
			return true;
		}
	}
}
?>
