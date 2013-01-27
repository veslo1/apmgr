<?php
/**
 * Created on Feb 11, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Stores the billTransaction
 * * </p>
 */


class Financial_Model_BillTransaction extends ZFModel_ParentModel {

	/**
	 *@var billId
	 */
	protected $billId;

	/**
	 *@var transactionId
	 */
	protected $transactionId;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Financial_Model_DbTable_BillTransaction');
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
	 * transactionId
	 */
	public function setTransactionId( $var ) {
		$this->transactionId = $var;
	}

	public function getTransactionId() {
		return $this->transactionId;
	}
}
?>
