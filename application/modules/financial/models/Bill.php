<?php
/**
 * Created on Jan 28, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Model for bills, bills, bills
 * </p>
 */


class Financial_Model_Bill extends ZFModel_ParentModel {

	/**
	 *@var amountDue
	 */
	protected $originalAmountDue;

	/**
	 *@var dueDate
	 */
	protected $dueDate;
	 
	/**
	 *@var isPaid
	 */
	protected $isPaid;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Financial_Model_DbTable_Bill');
	}

	/**
	 *  Original Amount Due
	 */
	public function setOriginalAmountDue( $var ) {
		$this->originalAmountDue = $var;
	}

	public function getOriginalAmountDue() {
		return $this->originalAmountDue;
	}

	/**
	 * Due Date
	 */
	public function setDueDate( $var ) {
		$this->dueDate = $var;
	}

	public function getDueDate() {
		return $this->dueDate;
	}

	/**
	 * isPaid
	 */
	public function setIsPaid( $var ) {
		$this->isPaid = $var;
	}

	public function getIsPaid() {
		return $this->isPaid;
	}

	public function getUnitBillsByNumber( $unitNumber ){
		$bills = null;

		if( isset($unitNumber) and is_numeric($unitNumber) ) {
			$um = new Unit_Model_Unit();
			$unit = $um->findByKey( array('search'=>array('number'=>$unitNumber)) );

			if( $unit ) {
				$unit=array_shift( $unit );
				$bills = $this->getUnitBills( $unit->getId() );
			}
		}

		return $bills;
	}


	// get unit bills
	// since db table can't handle joins, will query the db with fluent query
	/*
	public function getUnitBills( $unitId ) {
		$container = array();
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('b'=>'bill') )
		->join( array('bu'=>'billUnit'), 'b.id=bu.billId', array() )
		->where('bu.unitId=?', $unitId)
		->where( 'isPaid=0' )
		->order( "b.dueDate DESC" );

		$resultSet = $db->query( $query );
		//print "<pre>";var_dump($query->__toString());print"</pre>"; die;

		$container = null;
		foreach ($resultSet as $row)
		$container[] = new Financial_Model_Bill($row);

		return $container;
	}
	*/

	/**
	 *  Gets current amount due.  It takes the sum of the payment table for that bill
	 *  and subtracts the amount from the orignal amount due.  If <=0 ( in theory an
	 *  overpayment could result in a negative), return 9.
	 */
	public function getCurrentAmountDue(){
		$pmt = new Financial_Model_Payment();
		$pmt->setBillId( $this->getId() );
		$pmtSum = $pmt->getPaymentSumByBillId();

		$currentAmountDue = $this->getOriginalAmountDue() - $pmtSum;		

		if( $currentAmountDue <=0 ){  // if somehow they overpay, it could be negative....
		     $currentAmountDue = 0;
		}

		return number_format($currentAmountDue,2);
	}

	/**
	 *  Set the array of bills to paid if it passes the check
	 */
	public function updateIsPaid( $bills ){
		foreach( $bills as $id=> $billObj ){
			// check if bill is fully paid (amount is 0)
			if( !$billObj->getCurrentAmountDue() ){
				// if so, set the isPaid flag
				$billObj->setIsPaid(1);
				$billObj->save();
			}
		}
	}
}
?>
