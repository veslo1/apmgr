<?php
/**
 * Created on Mar 12, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Stores the main lease info
 * </p>
 */


class Unit_Model_Lease extends ZFModel_ParentModel {

	/**
	 *@var leaseStartDate
	 */
	protected $leaseStartDate;
	
	/**
	 *@var leaseEndDate
	 */
	protected $leaseEndDate;

	/**
	 *@var lastDay
	 */
	protected $lastDay;
	 
	/**
	 *@var unitId
	 */
	protected $unitId;

	/**
	 *@var apartmentId
	 */
	protected $apartmentId;

	/**
	 *@var modelRentScheduleId
	 */
	protected $modelRentScheduleId;

	/**
	 *@var modelRentScheduleItemId
	 */
	protected $modelRentScheduleItemId;

	/**
	 *@var userId
	 */
	protected $userId;

	/**
	 *@var isCancelled
	 */
	protected $isCancelled;

	/**
	 *@var cancellationDate
	 */
	protected $cancellationDate;
	
	/**
	 *@var cancelComment
	 */
	protected $cancelComment;
		 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		$this->setUserId( User_Library_Helper_Utils::currentUserId() );
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_Lease');
	}
	 
	/**
	 * leaseStartDate
	 */
	public function setLeaseStartDate( $var ) {
		$this->leaseStartDate = $var;
	}

	public function getLeaseStartDate() {
		return $this->leaseStartDate;
	}
	
	/**
	 * leaseEndDate
	 */
	public function setLeaseEndDate( $var ) {
		$this->leaseEndDate = $var;
	}

	public function getLeaseEndDate() {
		return $this->leaseEndDate;
	}

	/**
	 * lastDay
	 */
	public function setLastDay( $var ) {
		$this->lastDay = $var;
	}

	public function getLastDay() {
		return $this->lastDay;
	}

	/**
	 * unitId
	 */
	public function setUnitId( $var ) {
		$this->unitId = $var;
	}

	public function getUnitId() {
		return $this->unitId;
	}

	/**
	 * apartmentId
	 */
	public function setApartmentId( $var ) {
		$this->apartmentId = $var;
	}

	public function getApartmentId() {
		return $this->apartmentId;
	}

	/**
	 *  modelRentScheduleId
	 **/
	public function setModelRentScheduleId( $var ) {
		$this->modelRentScheduleId = $var;
	}

	public function getModelRentScheduleId() {
		return $this->modelRentScheduleId;
	}

	/**
	 *  modelRentScheduleItemId
	 **/
	public function setModelRentScheduleItemId( $var ) {
		$this->modelRentScheduleItemId = $var;
	}

	public function getModelRentScheduleItemId() {
		return $this->modelRentScheduleItemId;
	}


	/**
	 * userId
	 */
	public function setUserId( $var ) {
		$this->userId = $var;
	}

	public function getUserId() {
		return $this->userId;
	}

	/**
	 * isCancelled
	 */
	public function setIsCancelled( $var ) {
		$this->isCancelled = $var;
	}

	public function getIsCancelled() {
		return $this->isCancelled;
	}

	/**
	 * cancellationDate
	 */
	public function setCancellationDate( $var ) {
		$this->cancellationDate = $var;
	}

	public function getCancellationDate() {
		return $this->cancellationDate;
	}
	
	/**
	 * cancelComment
	 */
	public function setCancelComment( $var ) {
		$this->cancelComment = $var;
	}

	public function getCancelComment() {
		return $this->cancelComment;
	}	
	
	public function fetchCurrentPendingLeases(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('lease') )
		->where( 'unitId=?', $this->getUnitId() )
		->where( 'lastDay>=NOW()')
		->where( 'isCancelled=0')
		->order( 'leaseStartDate DESC' );
	  
		$results = $db->query( $query );

		$container = array();
		if( isset( $results ) ){
			foreach( $results as $id=>$row )
			$container[] = $row;
			return $container;
		}
		else
		return null;
	}

	/**
	 *  Fetches current lease
	 */
	public function fetchCurrentLease(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('lease') )
		->where( 'unitId=?', $this->getUnitId() )
		->where( 'leaseStartDate<=NOW()')
		->where( 'lastDay>=NOW()')
		->where( 'isCancelled=0')
		->order( 'leaseStartDate DESC' );
	  
		$results = $db->query( $query );

		$container = array();
		if( isset( $results ) ){
			$container = array_shift($results);
			return $container;
		}
		else
		return null;
	}
	
	public function fetchLeaseHistory(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('lease') )
		->where( 'unitId=?', $this->getUnitId())
		->Where( 'lastDay<NOW() OR isCancelled=1' )
		->order( 'leaseStartDate DESC' );

		$results = $db->query( $query );

		$container = array();
		if( isset( $results ) ){
			foreach( $results as $id=>$row )
			$container[] = $row;
			return $container;
		}
		else
		return null;
	}

	/**
	 *  Cancels lease
	 *
	 *  Original Notes
	 *
	 *  //  search for future bills that have not been paid
	 // select bills tied to lease through leaseSchedule
		// grab ones that are not paid with dueDate>=today
		//  loop and reverse the entries for these by pulling from leaseSchedule to fetch the discount and billIds
		//   and lease to modelRentSchedule to get base amount paid
		// TODO:  well, it could be a problem if they partial pay a future bill - disallow that action for now
	  
		TABLES:
		lease - need cancelled and modelRentScheduleId
		leaseSchedule - needs the discount on the bills and the bills on the lease
		bills - need to get the isPaid flag
		modelRentSchedule - grabs the base amount paid
		 
			
		// reverse entries and set to accounts
		// may need a nice helper function in the transaction/accountTransaction classes to assist with this
		*/
	public function cancelLease() {
		$db = Zend_Registry::get('db'); // used for all in transaction
		$db->beginTransaction();
		try {
			$ftc = new Financial_Model_FinancialTransactionCreation(array('db'=>$db));
			$this->setDbAdapter($db);
			$results = $this->fetchUnpaidFutureBills();	 // fetch bills to process
			$cancelLease = $this->fetchCancelAccountLink();
			
			// set lease to cancelled
			$this->setCancellationDate( date("Y-m-d H:i:s" ) );				
			$this->setIsCancelled(1);
			$this->save();
			
			// if unpaid bills, cancel them here 
			if( $results ){  
				if( !$cancelLease ){ // error if no account link set
					$this->setMessageState('errorCancellingLease');			  
				}
				else{   // account link and rows exist
				    // cancel lease
				    foreach( $results as $id=>$row ) {
					// cancel lease portion
		                        $ftc->setAccountLink( $cancelLease );
		                        $ftc->setAmount($row['originalAmountDue'] + $row['discount']);
		                        $ftc->setBillId($row['billId']);
		                        $result = $ftc->createFinancialRecord();  // create financial records

		                        // cancel discount portion
		                        if( $row['discount']>0){
		   	                    $cancelDiscount = $this->fetchCancelDiscountAccountLink();
		   	                    if ( $cancelDiscount ) {
			                        $ftc->setTransactionId(null);  //unset to make a new transacation id
			                        $ftc->setAccountLink( $cancelDiscount  );
			                        $ftc->setAmount($row['discount']);
			                        $ftc->setBillId($row['billId']);
			                        $result = $ftc->createFinancialRecord();
		   	                    }
		                        } 
				    }
				}
			}			
			$db->commit();
			return true;
		}
		catch ( Exception $e) {
			$db->rollBack();
			echo $e->getMessage();
			return false;
		}
	}

	/**
	 *  Fetches all unpaid bills with a due date greater than or equal to now.
	 *  Used in cancel lease
	 */
	private function fetchUnpaidFutureBills(){
		// Grab all unpaid bills on the lease so they can be cancelled
		// Do NOT allow partial payment on future bills
		$db=$this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('l'=>'lease'), array() )
		->join( array('ls'=>'leaseSchedule'),'ls.leaseId=l.id',array( 'discount', 'billId'))
		->join( array('b'=>'bill'),'b.id=ls.billId',array( 'originalAmountDue' ))
		->where( 'l.id=?', $this->getId() )
		->where( 'b.isPaid=?',0)
		->where( 'ls.billId=b.id')
		->where( 'b.dueDate>NOW()');
		 
		$results = $db->query( $query );
		$container=array();
		foreach( $results as $id=>$row ) {
			$container[] = $row;
		}
		return $container;
	}

	/**
	 *  fetch cancel account link
	 */
	private function fetchCancelAccountLink(){
		// pull account link		
		$alModel = new Financial_Model_AccountLink();
		$alCancelLease = $alModel->findByKey( array('search'=>array( 'name'=>'leaseCancellationRentPortion' )) );		
		
		$cancelLease=null;
		if( $alCancelLease ) {		
		    $cancelLease = array_shift($alCancelLease);
		}    

		if( !$cancelLease || !$cancelLease->getDebitAccountId() || !$cancelLease->getCreditAccountId() ) {
			$this->setMessageState( 'missingAccountLink' );		
			return false;
		}
		else{
			return $cancelLease;
		}
	}

	/**
	 *  fetch cancel account link
	 */
	private function fetchCancelDiscountAccountLink(){
		$alModel = new Financial_Model_AccountLink();
		$alCancelLeaseDiscount  = $alModel->findByKey( array('search'=>array( 'name'=>'leaseCancellationDiscountPortion' )) );
		$cancelDiscount = array_shift($alCancelLeaseDiscount);
			
		if( !$cancelDiscount->getDebitAccountId() || !$cancelDiscount->getCreditAccountId() ) {
			$this->setMessageState( 'missingAccountLink' );
			return false;
		}
		else{
			return $cancelDiscount;
		}
	}

}
?>
