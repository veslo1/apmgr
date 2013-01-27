<?php
/**
 * Created on Jan 25, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Simple model for the unitModel which stores the model of the unit (ex:  A-1, B-2) etc
 * </p>
 */


class Unit_Model_Amenity extends ZFModel_ParentModel {

	/**
	 *@var name
	 */
	protected $name;
	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_Amenity');
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

	/**
	 *  Save amenity
	 */
	public function saveAmenity(){
		if($this->exists(array('table'=>'amenity','column'=>'name'),$this->getName(),$this->getId())){  // if name exists, there is an error
			$this->setMessageState('nameExists');
			return false;
		}
		else{
			return $this->save();
		}
	}
	
	/**
	 *  Return amenity id of those used so they cannot be deleted
	 */
	public function getAttachedAmenities(){
	    $db = $this->getDbTable()->getAdapter();			    	   
	    $query = "SELECT DISTINCT amenityId FROM unitModelAmenity";
	    $resultSet = $db->query( $query );
			
	    $container = array();

	    foreach ($resultSet as $row){
		$container[$row['amenityId']] = $row['amenityId'];
	    }	    
	    return $container;	    
	}
}
?>
