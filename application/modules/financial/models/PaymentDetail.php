<?php
/**
 * Created on Feb 3, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Model for payment detail
 * </p>
 */


class Financial_Model_PaymentDetail extends ZFModel_ParentModel {

	/**
	 *@var payor
	 */
	protected $payor;

	/**
	 *@var paymentType
	 */
	protected $paymentType;
	 
	/**
	 *@var totalAmount
	 */
	protected $totalAmount;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		if( isset($options['selPmt']) )
		$options['totalAmount'] = array_sum($options['selPmt']);
		parent::__construct( $options );
		$this->setDbTable('Financial_Model_DbTable_PaymentDetail');
	}
	 
	/**
	 * payor
	 */
	public function setPayor( $var ) {
		$this->payor = $var;
	}

	public function getPayor() {
		return $this->payor;
	}
	 
	/**
	 * paymentType
	 */
	public function setPaymentType( $var ) {
		$this->paymentType = $var;
	}

	public function getPaymentType() {
		return $this->paymentType;
	}

	/**
	 * totalAmount
	 */
	public function setTotalAmount( $var ) {
		$this->totalAmount = $var;
	}

	public function getTotalAmount() {
		return $this->totalAmount;
	}
}
?>
