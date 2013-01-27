<?php
/**
 * Created on Mar 12, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Stores the lease discount info
 * </p>
 */


class Unit_Model_LeaseSchedule extends ZFModel_ParentModel {

	/**
	 *@var month
	 */
	protected $month;

	/**
	 *@var discount
	 */
	protected $discount;

	/**
	 *@var leaseId
	 */
	protected $leaseId;

	/**
	 *@var billId
	 */
	protected $billId;
	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_LeaseSchedule');
	}

	/**
	 *  month
	 */
	public function setMonth( $var ) {
		$this->month = $var;
	}

	public function getMonth() {
		return $this->month;
	}

	/**
	 *  discount
	 */
	public function setDiscount( $var ) {
		$this->discount = $var;
	}

	public function getDiscount() {
		return $this->discount;
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
	 * billId
	 */
	public function setBillId( $var ) {
		$this->billId = $var;
	}

	public function getBillId() {
		return $this->billId;
	}
}
?>
