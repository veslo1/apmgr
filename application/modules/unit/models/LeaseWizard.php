<?php
/**
 * Created on Mar 5, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Model to encapsulate wizard actions since lease contacts multiple models
 * Initially was gonna be apart from a table, but had to save to db in order
 * to access the wizard object (had issue with the registry retrieving the wizard obj)
 * </p>
 */


class Unit_Model_LeaseWizard extends ZFModel_ParentModel {

	//protected $wizardVariables;

	protected $effectiveDate;
	protected $unitId;
	protected $userId;
	protected $modelRentScheduleId;
	protected $modelRentScheduleItemId;
	protected $discount;
	protected $tenant;	 
	protected $fee;
	protected $recurringFee;
	protected $preleaseFee;
	protected $leaseFee;
	protected $moveInDate;
	protected $leaseId;
	protected $fromLeaseId;

	protected $rentAmount;  // used to easily compare for discounts and proration without storing the entire object.  not stored in database
	protected $prorationObj;

	protected $rentSettings;


	public function __construct(array $options = null) {
		$this->setProrationObj( new Unit_Model_Proration() );
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_LeaseWizard');
	}

	/**
	 *  Returns the lease wizard if the user has proper access
	 */
	public function getLeaseWizard(){
		$item = $this->findById( $this->id );
		if( !empty($item) && $item->getUserId()== User_Library_Helper_Utils::currentUserId() ) {			 
			return $item;
		}
		else {
		    return false;
		}
	}

	public function getEffectiveDate(){
		return $this->effectiveDate;
	}
	public function setEffectiveDate( $var ){
		$this->effectiveDate = $var;
		$this->getProrationObj()->setMoveInDate( $var );
	}

	public function setUnitId( $var ){
		$this->unitId = $var;
	}
	public function getUnitId(){
		return $this->unitId;
	}

	public function setUserId( $var ){
		$this->userId = $var;
	}
	public function getUserId(){
		return $this->userId;
	}

	public function setModelRentScheduleId( $var ){
		$this->modelRentScheduleId = $var;
	}
	public function getModelRentScheduleId(){
		return $this->modelRentScheduleId;
	}

	public function setModelRentScheduleItemId( $var ){
		$this->modelRentScheduleItemId = $var;
	}
	public function getModelRentScheduleItemId(){
		return $this->modelRentScheduleItemId;
	}

	public function getModelRentScheduleItemObj(){
		$item = new Unit_Model_ModelRentScheduleItem();
		$scheduleItem = $item->findById( $this->getModelRentScheduleItemId() );
		$this->getProrationObj()->setBaseRentAmount( $scheduleItem->getRentAmount() );
		return $scheduleItem;
	}

	public function getUnit(){
		$item = new Unit_Model_Unit();
		return $item->findById( $this->getUnitId() );
	}

	public function getAccountLink(){
		$item = new Financial_Model_AccountLink();
		return $item->findById( $this->getAccountLinkId() );
	}

	public function setDiscount( $var ){
		$temp=$var;

		if( is_array($var))
		$temp = serialize( $var );

		$this->discount = $temp;
	}

	public function getDiscount(){
		return unserialize( $this->discount );
	}

	// passes in a user object
	public function setTenant( $var ){
		$temp=$var;

		if( is_object($var) ) {
			$tenantArray = $this->getTenant();
			$name = $var->getFirstName() . ' ' . $var->getLastName();
			$tenantArray[$var->getId()] = $name;
			$temp = serialize( $tenantArray );
		}		
		$this->tenant = $temp;		
	}

	/**
	 *  Used for removing tenants from list in lease wizard
	 */
	public function removeTenant( $tenantId ){
		$tenantArray = $this->getTenant();
		unset($tenantArray[$tenantId]);
		$this->tenant = serialize( $tenantArray );		
	}

	public function getTenant( $format=false ){
		if($format){
			$temp = unserialize( $this->tenant );
			$return=array();			
			foreach( $temp as $id=>$name ) {
			    $return[] = array('id'=>$id, 'name'=>$name );
			}    
			return $return;
		}
		else {
		    return unserialize( $this->tenant );
		}
	}

	/**
	 *  Get and set fees
	 */
	public function setFee( $var ){
		$temp=$var;

		if( is_array($var) ) {
		    $temp = serialize( $var );
		}
		$this->fee = $temp;
	}
	public function getFee(){
		return ( $this->fee )? unserialize( $this->fee ) : null;
	}
	
	/**
	 *  Get and set recurring fees
	 */
	public function setRecurringFee( $var ){
		$temp=$var;
		if( is_array($var) ) { 
		    $temp = serialize( $var );
		}
		$this->recurringFee = $temp;
	}
	public function getRecurringFee(){
		if( $this->recurringFee ) {
		    return unserialize( $this->recurringFee );
		}
		else {
		    return null;
		}
	}
	
	/**
	 *  Get and set prelease fees
	 */
	public function setPreleaseFee( $var ){
		$temp=$var;
		if( is_array($var) ) { 
		    $temp = serialize( $var );
		}
		$this->preleaseFee = $temp;
	}
	public function getPreleaseFee(){
		if( $this->preleaseFee ) {
		    return unserialize( $this->preleaseFee );
		}
		else {
		    return null;
		}
	}	
        
	/**
	 *  Get and set lease fees - used for renewals and displays any fees created after the lease was made
	 */
	public function setLeaseFee( $var ){
		$temp=$var;
		if( is_array($var) ) { 
		    $temp = serialize( $var );
		}
		$this->leaseFee = $temp;
	}
	public function getLeaseFee(){
		if( $this->leaseFee ) {
		    return unserialize( $this->leaseFee );
		}
		else {
		    return null;
		}
	}	
	
	/**
	 *  Set move in date
	 */
        public function setMoveInDate( $var ){
		$this->moveInDate = $var;
	}
	public function getMoveInDate(){
		return $this->moveInDate;
	}
	
	/**
	 *  Stores the lease id generated from the wizard
	 */
	public function setLeaseId( $var ){
		$this->leaseId = $var;
	}
	public function getLeaseId(){
		return $this->leaseId;
	}
	
	/**
	 *  Stores the lease id that the wizard row was cloned from
	 */
	public function setFromLeaseId( $var ){
		$this->fromLeaseId = $var;
	}
	public function getFromLeaseId(){
		return $this->fromLeaseId;
	}

        /**
	 *  rent amount  
	 */
	public function getRentAmount(){
		if( !$this->rentAmount ) {
		    return $rentScheduleItem->getRentAmount();
		}
		else {
		    return $this->rentAmount;
		}
	}

	public function setRentAmount( $var ){
		$this->rentAmount = $var;
		$this->getProrationObj()->setBaseRentAmount( $var );
	}

	/**
	 *  Proration object
	 */
	public function getProrationObj(){
		return $this->prorationObj;
	}
	public function setProrationObj( $var ){
		$this->prorationObj = $var;
	}
	 

	/**
	 *  Used on the first page of the lease wizard.  I couldn't think of any other place that use the most recent
	 *  module schedules via unitId other than in the lease wizard.  The others would merely pull from model
	 *  or display the existing lease schedule already attached to a unit which is a seperate model and table.
	 */
	public function fetchLatestScheduleByUnitId()   {
		$unit = new Unit_Model_Unit();
		$unit = $unit->findById( $this->getUnitId() );

		$rentSchedule = new Unit_Model_ModelRentSchedule();
		$rentSchedule->setEffectiveDate( $this->getEffectiveDate() );
		$rentSchedule->setUnitModelId($unit->getUnitModelId());
		
		$latestSchedule = $rentSchedule->getLatestSchedule();				
		return $latestSchedule;
	}


	/**
	 * Format vars for the lease model save function
	 */
	public function createLease() {
		$db = Zend_Registry::get('db'); // used for all in transaction
		$this->setDbAdapter( $db );

		/* lease
		 lease schedule
		 tenant
		 create bills - manipulate accounting - date posted
		 reverse accounting on bill cancellation
		 */

		try {
			$db->beginTransaction();
			// save lease
			$leaseId = $this->saveLease();			
			
			// Set and save discounts to leaseDiscount table
			$leaseSchedule = new Unit_Model_LeaseSchedule(array( 'db'=>$db));
			$leaseSchedule->setLeaseId( $leaseId );

			// set discounts
			$discount = $this->getDiscount();
			 
			// get proration object
			$proration = $this->getProrationObj();
			 
			// create and initialize the bill creation object
			$billCreation = new Financial_Model_BillCreation(array( 'db'=> $db ));			
			$billCreation->setAccountLink( $this->getRentAccountLink() );
			$billCreation->setDiscountAccountLink( $this->getDiscountAccountLink() );
			
			$dateArray = array();  // used for storing dates for the recurring fees

			for ( $month=1;  $month <= $this->getLeaseNumMonths(); $month++ ) {
				// Set the amount due
				// amount from rent model - discount = original amount due
				$disc = ( isset( $discount[$month] ) )? $discount[$month] : 0;
				$proration->setMonthSequence( $month );
				$baseAmount = $proration->getAmountDue();
				$amountDue = $baseAmount - $disc;
				$billCreation->setBillAmountDue( $amountDue );

				//  Set the due date and posted date
				//  Second param needed or else 2010-05-1 is being read as Jan 5 2010 instead of May 1 2010
				//  Sets the date to the 1st for rent				
				$date = new Zend_Date($this->getMoveInDate(),'YYYY-MM-dd' );
				$date->add( $month-1, Zend_Date::MONTH); // increment date
				if( $month!=1 ) {
				    $date->set( $this->getRentDueDate(), Zend_Date::DAY); // increment date
				}

				$billCreation->setDueDate( $date->toString('YYYY-MM-dd') );
				$billCreation->setAccountingAmount( $baseAmount );

				// create bill
				$billCreation->setDiscount( $disc );										
				$billId = $billCreation->createBill();

				// save lease schedule item
				$leaseSchedule->setMonth( $date->toString('YYYY-MM-dd') );
				$leaseSchedule->setDiscount( $disc );
				$leaseSchedule->setBillId( $billId );
				$leaseScheduleItemId = $leaseSchedule->save();
				
				$dateArray[] = $date->toString('YYYY-MM-dd');
			}
			// save recurring fees
 			$this->saveRecurringFees( $billCreation, $leaseId, $dateArray );			 
			$billCreation->setDiscount(null);
			 
			// saves lease fees
			$this->saveLeaseFees($leaseId); 
			
			// saves prelease fees
			$this->savePreleaseFees($leaseId); 
			 
			// save fees and deposits
			$this->saveFees($billCreation, $leaseId);			
			 
			$this->saveTenants( $leaseId );  // save tenants
			//	And finally, update the unit and show it as taken
			$this->updateUnit(); // update unit row dateAvailable and isAvailable						
            		
			// set leaseId created with the wizard
			$this->setLeaseId( $leaseId ); 
			$this->save();
										
			$db->commit();
			return true;
		}
		catch ( Exception $e) {
			$db->rollBack();
			echo $e->getMessage();			
			return false;
		}
	} // end function

	/**
	 *  Return account link for rent revenue
	 */
	private function getRentAccountLink(){
		$linkName = 'rentRevenue';
		$alModel = new Financial_Model_AccountLink();
		$accountLink = $alModel->findByKey( array('search'=>array( 'name'=>$linkName )) );
		if( $accountLink ) {
		    return $accountLink[0];
		}
		else{
			$this->setMessageState('noAccountLinkSet');
			throw new Exception( 'noRentAccountLinkSet' );
		}
	}

	/**
	 *  Return account link for rent discount
	 */
	private function getDiscountAccountLink(){
		$linkName = 'rentDiscount';
		$alModel = new Financial_Model_AccountLink();
		$accountLink = $alModel->findByKey( array('search'=>array( 'name'=>$linkName )) );
		if( $accountLink ) {
		return $accountLink[0];
		}
		else{
			$this->setMessageState('noAccountLinkSet');
			throw new Exception( 'noDiscountAccountLinkSet' );
		}
	}
        
	/**
	 *  Saves lease fees
	 */
        private function saveLeaseFees( $leaseId ) {
		if( $this->getLeaseFee() ) {
			// save fees
			$leaseFeeObj = new Unit_Model_LeaseFee();
			$leaseFeeObj->setDbAdapter( $this->getDbAdapter() );
			 
			foreach( $this->getLeaseFee() as $id=>$item ){				
				$leaseFeeObj->setFeeId( $item['feeId'] );
				$leaseFeeObj->setLeaseId( $leaseId );
				$leaseFeeObj->setAmount( $item['amount'] );
				$leaseFeeObj->setBillId( $item['billId'] );
				$leaseFeeObj->save();
			}
		}
	} 
	
	/**
	 *  Saves prelease fees
	 */
        private function savePreleaseFees( $leaseId ) {
		if( $this->getPreleaseFee() ) {
			// save fees
			$leaseFeeObj = new Unit_Model_LeaseFee();
			$leaseFeeObj->setDbAdapter( $this->getDbAdapter() );
			 
			foreach( $this->getPreleaseFee() as $id=>$item ){				
				$leaseFeeObj->setFeeId( $item['feeId'] );
				$leaseFeeObj->setLeaseId( $leaseId );
				$leaseFeeObj->setAmount( $item['amount'] );
				$leaseFeeObj->setBillId( $item['billId'] );
				$leaseFeeObj->save();
			}
		}
	} 

	private function saveFees( $billCreation, $leaseId ) {
		if( $this->getFee() ) {
			// save fees
			$leaseFeeObj = new Unit_Model_LeaseFee();
			$leaseFeeObj->setDbAdapter( $this->getDbAdapter() );
			 
			foreach( $this->getFee() as $id=>$item ){
				$billCreation->setBillAmountDue( $item['amount'] );
				$billCreation->setDueDate( date("Y-m-d"));

				$billId = $billCreation->createBill();
				
				$leaseFeeObj->setFeeId( $id );
				$leaseFeeObj->setLeaseId( $leaseId );
				$leaseFeeObj->setAmount( $item['amount'] );
				$leaseFeeObj->setBillId( $billId );
				$leaseFeeObj->save();
			}
		}
	}
	
	/**
	  *    Save recurring fees
	  */
	private function saveRecurringFees( $billCreation, $leaseId, $dateArray ) {		
		if( $this->getRecurringFee() ) {
			// save recurring fees
			$leaseFeeObj = new Unit_Model_LeaseFee();
			$leaseFeeObj->setDbAdapter( $this->getDbAdapter() );
			 
			// cycle through each fee... 
			foreach( $this->getRecurringFee() as $id=>$item ){
				$billCreation->setBillAmountDue( $item['amount'] );
				$leaseFeeObj->setFeeId( $id );
				$leaseFeeObj->setLeaseId( $leaseId );
				$leaseFeeObj->setAmount( $item['amount'] );
				
				// ... and create a bill for each month of the lease
				foreach ( $dateArray as $index=>$dueDate ) {				    
				    $billCreation->setDueDate( $dueDate );
				    $billId = $billCreation->createBill();		
				    $leaseFeeObj->setBillId( $billId );
				    $leaseFeeObj->save();
				}    
			}
		}
	}	

	/* Litle functions to clean up the createLease function */
	// saves the lease to the table
	private function saveLease(){
		$unitObj = new Unit_Model_Unit();
		$unitItem = $unitObj->findById( $this->getUnitId() );
		$endDate = $this->getEndDate();  // fetches end date of the lease

		$lease = new Unit_Model_Lease();
		$lease->setDbAdapter( $this->getDbAdapter() );
		//$lease->setEffectiveDate( $this->getEffectiveDate() );
		$lease->setLeaseStartDate( $this->getMoveInDate() );
		$lease->setLeaseEndDate( $endDate );
		$lease->setLastDay( $endDate );
		$lease->setApartmentId( $unitItem->getApartmentId() );
		$lease->setUnitId( $this->getUnitId() );
		$lease->setModelRentScheduleId( $this->getModelRentScheduleId()  );
		$lease->setModelRentScheduleItemId( $this->getModelRentScheduleItemId() );
		//$lease->setLastDay( $endDate);
		$lease->setIsCancelled(0);
		return $lease->save();
	}

	// calculates the end date of the lease
	public function getEndDate(){
		$day = $this->getRentDueDate();
		$months = $this->getLeaseNumMonths();
		//$endDate = new Zend_Date($this->getEffectiveDate(),'YYYY-MM-dd' );
		$endDate = new Zend_Date($this->getMoveInDate(),'YYYY-MM-dd' );
		$endDate->add( $months, Zend_Date::MONTH);
		$endDate->set( $day-1, Zend_Date::DAY);
	  
		return $endDate->toString('YYYY-MM-dd');
	}

	/**
	 *  For  now is configured as the first of the month
	 */
	private function getRentDueDate(){
		if( !$this->rentSettings ) {
			$settings = new Unit_Model_RentSettings();
			$this->rentSettings = $settings->findById(1);
		}
		return $this->rentSettings->getRentDueDay();
	}

	// saves tenants to table and updates the role to tenant
	private function saveTenants( $leaseId ){
		$tenantModel = new Unit_Model_Tenant();
		$tenantModel->setDbAdapter( $this->getDbAdapter() );
		$tenantModel->setLeaseId( $leaseId );		
				
		// set the user to the tenant role					
		$role = new Role_Model_Role();
		$roleId = null;
		$results = $role->findByKey(array('search'=>array('name'=>'tenant')));
		if( $results ) {
			$role = array_shift( $results );			
			if( $role ) {
			     $roleId = $role->getId();
			}
			else {
				throw new Exception( 'Error fetching Tenant Role' );
			}
		}
		else {
			throw new Exception( 'Error fetching Tenant Role' );
		}		
		$userObj = new User_Model_User();
		$userObj->setDbAdapter( $this->getDbAdapter() );
		foreach( $this->getTenant() as $id=>$user ) {
			$tenantModel->setUserId( $id );
			$user = $userObj->findById( $id );
			if( $user ){
				$user->setRoleId( $roleId ); 
			}
			else {
				throw new Exception( 'Error fetching user in saveTenants' );
			}
			$tenantModel->save();
			$user->save();
		}
	}	
	
	/**
	 *  Fetches the leaseWizardId for the start of the wizard
	 */
	public function getLeaseWizardId( $unitId ){
		$result = $this->getUnfinishedRow( $unitId );				
			
                // if unfinished row exists, return it - should only be one per user since it should pull and save over any unfinished rows		
		if( $result ) {
			$leaseWizard = array_shift($result);
			return $leaseWizard['id'];						
		}
		// Otherwise an unfinished row does not exist, so make a new row for use in the wizard
		else {
			$userId = User_Library_Helper_Utils::currentUserId();  //pull current user	
			$this->setUserId( $userId );
			return $this->save();
		}
	}
	
	/**
	 *  Fetches unfinished rows
	 */
	public function getUnfinishedRow( $unitId ){
		$userId = User_Library_Helper_Utils::currentUserId(); //pull current user					
		
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('LW'=>'leaseWizard'))			
		->where( 'LW.unitId=?', $unitId )
		->where( 'LW.userId=?', $userId )
		->where( 'LW.leaseId IS NULL' );										
		
		$resultStmt = $db->query($query);
		$result = $resultStmt->fetchAll();
		return $result;
	}
	
	
	/**
	 * Returns the number of months in the lease
	 */
	private function getLeaseNumMonths(){
		$item = $this->getModelRentScheduleItemObj();
		return $item->getNumMonths();
	}

	/**
	 *  validates the rent discounts entered
	 */
	public function validateDiscount(){
		//var_dump($this->getDiscount()); die;
		$temp = array();

		foreach( $this->getDiscount() as $month=>$amount ) {
			if( $amount > $this->getRentAmount() )
			$temp[$month] = true;
		}
		return $temp;
	}
	
	/**
	 *  Function to update the unit dateAvailable and isAvailable information
	 */
	private function updateUnit(){	    
		$unit = new Unit_Model_Unit();
		$unit->setDbAdapter( $this->getDbAdapter() );
		$unit = $unit->findById($this->getUnitId());
		$unit->setIsAvailable(0);
		$unit->setDateAvailable(NULL);
		$unit->save();
	}		
}
?>
