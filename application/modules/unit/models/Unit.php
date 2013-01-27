<?php
/**
 * Created on Dec 5, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>The model for unit</p>
 * @internal I removed the search functionality from here, and moved to the search helper
 */


class Unit_Model_Unit extends ZFModel_ParentModel {

	/**
	 *@var apartment
	 */
	protected $apartment;
	protected $apartmentId;

	/**
	 *@var number
	 */
	protected $number;

	/**
	 *@var unitModelId
	 */

	protected $unitModel;
	protected $unitModelId;
	protected $isAvailable;


	protected $yearBuilt;
	protected $yearRenovated;
	protected $dateAvailable;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {		
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_Unit');
	}

	/**
	 * Apartment get and set
	 */
	public function setApartment( $apt ) {
		$this->apartment = $apt;
	}

	public function getApartment() {
		return $this->apartment;
	}

	public function setApartmentId( $apt ) {
		$this->apartmentId = $apt;
	}

	public function getApartmentId() {
		return $this->apartmentId;
	}

	/**
	 * Address Two get and set
	 */
	public function setNumber( $number ) {
		$this->number = $number;
	}

	public function getNumber() {
		return $this->number;
	}

	public function setUnitModelId( $model ) {
		$this->unitModelId = $model;
	}

	public function getUnitModelId() {
		return $this->unitModelId;
	}

	public function setUnitModel( $model ) {
		$this->unitModel = $model;
	}

	public function getUnitModel() {
		return $this->unitModel;
	}

	/**
	 *  Get/set for isAvailable
	 **/
	public function setIsAvailable( $var ) {
		$this->isAvailable = $var;
	}

	/**
	 *
	 * @return int
	 */
	public function getIsAvailable() {
		return $this->isAvailable;
	}

	public function getIsAvailableString() {
		return ( $this->isAvailable )? 'Yes' : 'No';
	}

	public function setYearBuilt( $var ) {
		$this->yearBuilt = $var;
	}

	public function getYearBuilt() {
		return $this->yearBuilt;
	}

	public function setYearRenovated( $var ) {
		$this->yearRenovated = $var;
	}

	public function getYearRenovated() {
		return $this->yearRenovated;
	}

	public function getDateAvailable(){
            return $this->dateAvailable;
        }

        public function setDateAvailable( $var ){		
                $this->dateAvailable = $var;	    
        }

	/**
	 *  Used in bulk create for validating the starting number fed to the page by the user
	 *  Used retarded cast because of the strings.  Existing strings with alpha will return as 0 so that works ok
	 **/
	private function validateNumberRange( $startNumber, $numUnits ) {
		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from( 'unit','COUNT(*) AS num')
		->where('CAST(number AS UNSIGNED) >= ?', $startNumber)
		->where('CAST(number AS UNSIGNED) < ?', $startNumber+$numUnits);

		$resultSet = array_shift($db->fetchAll( $select ));
		return $resultSet['num'];
	}

	

        /**
	 *  Apartment Id	   
	 */
	private function fetchApartmentId() {
		$apartmentModelObj = new Unit_Model_Apartment();
		$apt = $apartmentModelObj->findById(1);
		$return = false;		
		
		if( $apt ){			
			$return = $apt->getId();
		}
		return $return;	
	}	

	/**
	 *  Checks the  unit number to see if it exists on creation or is changed on edit to one that matches another unit
	 */
	public function checkNumber( $originalNumber=null ){
		$result = true;
		if( $this->getNumber()!=$originalNumber ) {

			if( $this->exists(array('table'=>'unit','column'=>'number'),$this->getNumber()) ) {
				$result=false;
				$this->setMessageState('numberExists');
			}
		}
		return $result;
	}
	
	/**
	 *  Save bulk units
	 */
	public function bulkSave( $numUnits ) {
		$return = false;
		$startNumber = $this->getNumber(); // fetch the starting number

		// validate that the number range is not already in the database
		if( $this->validateNumberRange( $startNumber, $numUnits ) ) {			
			$this->setMessageState('invalidNumberRange');
			$return = false;
		}
		else if( !$this->checkSetIsAvailable() ){			
			$return = false;
		}
		else {
			$id = $this->fetchApartmentId();			
			if( $id ){			
			    $this->setApartmentId(1);	
			    for($x=0; $x<$numUnits; $x++) {
				$this->setNumber( $startNumber + $x );  // increment the number for unitNumber
				$this->save();
			    }
			    $return = true;
			}
			else {
			    $this->setMessageState('noApartment');	
			    $return = false;	
			}
		}		
		return $return;
	}

	/**
	 *  Save single units
	 */
	public function singleSave($originalNumber=null) {
		$return=false;
		if($this->checkNumber($originalNumber)){			
		    if( !$this->checkSetIsAvailable() ){
		        $return = false;
		    } 
		    else{
			$id = $this->fetchApartmentId();			
			if( $id ){
			    $this->setApartmentId( $id );								
			    if($this->save()){
				$return = true;
			    }
			    else{
				$this->setMessageState('errorSaving');	
			        $return = false;	
			    }
			}
			else {
			    $this->setMessageState('noApartment');	
			    $return = false;	
			}
		    }	
		}		
		return $return;
	}
	
	/**
	 *  Check the unit isAvailable  - used on save
	 */ 
	private function checkSetIsAvailable() {
		$return = false;
		if( !$this->getIsAvailable() ) {
			$this->setDateAvailable( null );
			$return=true;
		}
		else if( $this->getIsAvailable() && !$this->getDateAvailable() ) {
			$this->setMessageState('emptyDateAvailable');
			$return=false;
		}
		else{
			$return = true;
		}		
		return $return;
	}

	/**
	 *Saves a record in this model
	 */

	/*
	 public function save() {
	 $result = false;

	 $data = array_filter($this->toArray());

	 if (null === ($id = $this->getId())) {
		unset ($data['id']);
		$data['dateUpdated'] = $data['dateCreated'] = date('Y-m-d H:i:s');
		$result =(int) $this->getDbTable()->insert($data);
		}
		//  Editing existing unit
		else {
		$data['dateUpdated'] = date('Y-m-d H:i:s');
		$result = $this->getDbTable()->update($data, array ('id = ?' => $this->getId() ),integer);
		}
		$this->clearUnitCache();
		return $result;
		}
		*/
	// this is needed after creating new units
	/*
	private function clearUnitCache(){
	$cache = Zend_Registry::get('cache');
	$cache->remove('unitPaginatedViewNumberASC');
	$cache->remove('unitPaginatedViewNumberDESC');
	}
	*/

	/**
	 * Screw it...making a function for the paginated views
	 * Obtain all the units for the apartment
	 * @param string $column
	 * @param string $order
	 * @return array
	 */
	public function getApartmentUnits($column=null,$order=null) {
		//$cache = Zend_Registry::get('cache');
		$container=null;
		$db=$this->getDbTable();
		$queryString = 'SELECT * FROM unit';

		$sort=null;
		// http://stackoverflow.com/questions/153633/natural-sort-in-mysql    :/
		if(is_null($column) || ( $column=='number' )) {
			$sort = ' ORDER BY number+0, number ' . $order ;
			//http://www.mpopp.net/2006/06/sorting-of-numeric-values-mixed-with-alphanumeric-values/
			//$sort = ' ORDER BY CAST(number AS UNSIGNED), number ' . $order ;
		}
		else {
			$sort = $column.' '.$order;
		}
		$queryString = $queryString . $sort;
		$resultSet = $db->getAdapter()->query( $queryString );

		foreach ($resultSet as $row) {
			$container[] = $row;
		}

		//	$cache->save($container, $tag);
		//}
		return $container;
	}


	public function getUnit() {
		$unitData = $this->findById( $this->getId() );
		if ( $unitData!==null ) {
			// prolly needs to be in model
			$aptModel = new Unit_Model_Apartment();
			$unitModel = new Unit_Model_UnitModel();

			$um = $unitModel->findById( $unitData->getUnitModelId() );
			$apt = $aptModel->findById( $unitData->getApartmentId()  );

			$unitData->setUnitModel( $um );
			$unitData->setApartment( $apt );
		}
		return $unitData;
	}

	/**
	 *  fetch the unit bills
	 */
	public function fetchUnitBills() {
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('lease'=>'lease'),array() )
		->join(array( 'ls'=>'leaseSchedule' ), 'lease.id=ls.leaseId', array())
		->join(array( 'b'=>'bill' ), 'ls.billId=b.id', array( 'billId'=>'id',
			      'originalAmountDue'=>'originalAmountDue',
			      'dueDate'=>'dueDate'
			      ))
		->join(array( 'u'=>'unit' ), 'lease.unitId=u.id', array('unitId'=>'lease.unitId', 'number'=>'u.number'))
		->where( 'b.isPaid=0' )
		->where( 'u.id=?', $this->getId() );

		$resultSet = $db->query( $query );

		$container = array();
		$pmtObj = new Financial_Model_Payment();
		foreach ($resultSet as $row){
			$pmtObj->setBillId( $row['billId'] );
		      	$amount = $row['originalAmountDue'] - $pmtObj->getPaymentSumByBillId();
		      	if( $amount<0 ){
			      	$amount=0;
			}	
		      	$row['currentAmountDue'] = $amount;
		      	$container[] = $row;
		}
		return $container;
	}
	
	/**
	 *  Return unit id of those used so they cannot be deleted
	 */
	public function getAttachedUnits(){
	    $db = $this->getDbTable()->getAdapter();
	    
	    //  Would you believe it is strawberry milkshake?  Nooooooooaaa
	    $query = "SELECT u.id
	              FROM unit AS u
		      JOIN applicantAppliance AS aa ON aa.unitId = u.id
		      UNION
		      SELECT u.id
	              FROM unit AS u
		      JOIN lease AS l ON l.unitId = u.id
		      UNION
		      SELECT u.id
	              FROM unit AS u
	              JOIN maintenanceRequest AS mr ON mr.unitId = u.id
 		      UNION
 		      SELECT u.id
 	              FROM unit AS u
 		      JOIN leaseWizard AS lw ON lw.unitId = u.id";
		      
            $resultSet = $db->query( $query );
			
	    $container = array();

	    foreach ($resultSet as $row){
		$container[$row['id']] = $row['id'];
	    }	    
	    return $container;	    
	}
}
?>