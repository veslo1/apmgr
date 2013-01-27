<?php
/**
 * Created on Feb 3, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Model for payment
 * </p>
 */


class Financial_Model_Payment extends ZFModel_ParentModel {

	/**
	 *@var billId
	 */
	protected $billId;

	/**
	 *@var amtPaid
	 */
	protected $amtPaid;

	/**
	 *@var transactionId
	 */
	protected $transactionId;
	 
	/**
	 *@var paymentDetailId
	 */
	protected $paymentDetailId;
	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Financial_Model_DbTable_Payment');
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
	 * amtPaid
	 */
	public function setAmtPaid( $var ) {
		$this->amtPaid = $var;
	}

	public function getAmtPaid() {
		return $this->amtPaid;
	}

	/**
	 * transactionId
	 */
	public function setTransactionId( $var ) {
		$this->transactionId = $var;
	}

	public function getTransactionId() {
		return $this->transactionId;
	}
	 
	/**
	 * paymentDetailId
	 */
	public function setPaymentDetailId( $var ) {
		$this->paymentDetailId = $var;
	}

	public function getPaymentDetailId() {
		return $this->paymentDetailId;
	}

	/**
	 *  returns the summed payments for a specified bill.  Used for current amount due calculation on a bill
	 *  and determining if a bill is paid (bill class)
	 */
	public function getPaymentSumByBillId(){
		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from( array('payment') , array('paymentSum'=> new Zend_Db_Expr('SUM(amtPaid)')))
		->where( 'billId=?',$this->getBillId() )
		->group('billId');

		$row = $db->fetchRow($select);
		
                return ($row)?$row['paymentSum']:0; 		
	}
}
?>
