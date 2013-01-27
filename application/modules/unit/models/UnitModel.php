<?php
/**
 * Created on Jan 16, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Simple model for the unitModel which stores the model of the unit (ex:  A-1, B-2) etc
 * </p>
 */


class Unit_Model_UnitModel extends ZFModel_ParentModel {

	protected $name;
	protected $size;
	protected $numBeds;
	protected $numBaths;
	protected $numFloors;
	//protected $depositId;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_UnitModel');
	}

	/**
	 * Name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setSize( $size ) {
		$this->size = $size;
	}

	public function getSize() {
		return $this->size;
	}

	public function setNumBeds( $var ) {
		$this->numBeds = $var;
	}

	public function getNumBeds() {
		return $this->numBeds;
	}

	public function setNumBaths( $var ) {
		$this->numBaths = $var;
	}

	public function getNumBaths() {

		return $this->numBaths;
	}

	public function setNumFloors( $var ) {
		$this->numFloors = $var;
	}

	public function getNumFloors() {
		return $this->numFloors;
	}

	public function setDepositId( $var ) {
		$this->depositId = $var;
	}
	/*
	 public function getDepositId() {
	 return $this->depositId;
	 }
	 */

	/**
	 *  Used for the model details view
	 */
	public function fetchUnitModelDetails(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('unitModel') )
		//->join( array('deposit'=>'deposit'),'unitModel.depositId=deposit.id',array('depositName'=>'name','amount'=>'amount'))
		->where( 'unitModel.id=?', $this->getId() );
	  
		$results = $db->fetchRow( $query );

		if( isset( $results ) )
		return $results;
		else
		return false;
	}

	/**
	 *  Needed to save unit model amenities
	 */
	public function saveUnitModel($amenities) {
		$db = Zend_Registry::get('db'); // used for all in transaction
		$this->setDbAdapter( $db );
		$db->beginTransaction();
		try {
			if($this->exists(array('table'=>'unitModel','column'=>'name'),$this->getName(),$this->getId())){  // if name exists, there is an error
			    $this->setMessageState('nameExists');
			    return false;
		        }
		        else{											
			    $id = $this->save();
			    $am = new Unit_Model_UnitModelAmenity( array( 'db'=>$db ) );
			    $am->setUnitModelId( $id );
			    if($amenities){
			        $am->saveAmenities( $amenities );
			    }    
			    $db->commit();
			    return $id;
			}
		}
		catch ( Exception $e) {
			$db->rollBack();
			echo $e->getMessage();
			return false;
		}
	}

      /**
	 *  Return unit model id of those used so they cannot be deleted
           Check if the unitModel exists in waitlist,  unit, model rent schedule 
	 */
	public function getAttachedModels(){
	    $db = $this->getDbTable()->getAdapter();	    
	    
           
	    $query = "SELECT um.id
	              FROM unitModel AS um
		       JOIN unit AS u ON u.unitModelId = um.id
		       UNION
		       SELECT um.id
	              FROM unitModel AS um
		       JOIN userWaitlist AS wl ON wl.modelId = um.id
		       UNION
		       SELECT um.id
                     FROM unitModel AS um
		       JOIN modelRentSchedule AS mrs ON mrs.unitModelId = um.id";
	     	      
            $resultSet = $db->query( $query );
			
	    $container = array();

	    foreach ($resultSet as $row){
		$container[$row['id']] = $row['id'];
	    }	    
	    return $container;	    
	}

}
?>
