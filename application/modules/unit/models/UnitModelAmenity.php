<?php
/**
 * Created on Jan 25, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Ties units to amenities
 * </p>
 */


class Unit_Model_UnitModelAmenity extends ZFModel_ParentModel {

	/**
	 *@var unitModelId
	 */
	protected $unitModelId;

	/**
	 *@var unitId
	 */
	protected $amenityId;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_UnitModelAmenity');
	}
	 
	/**
	 * unitId functions
	 */
	public function setUnitModelId( $id ) {
		$this->unitModelId = $id;
	}

	public function getUnitModelId() {
		return $this->unitModelId;
	}

	/**
	 * apartmentId functions
	 */
	public function setAmenityId( $id ) {
		$this->amenityId = $id;
	}

	public function getAmenityId() {
		return $this->amenityId;
	}


	private function clearAmenities(){
		$result = false;
		if ( $this->getUnitModelId() ) {
			$db = $this->getDbTable()->getAdapter();
			$where = $db->quoteInto("unitModelId=?", $this->getUnitModelId(), 'integer');
			$result = $this->getDbTable()->delete($where);
		}
		return $result;
	}


	/**
	 * Save amenity-unit
	 */
	public function saveAmenities( $amenities=array() ){
		$this->clearAmenities();

		if(isset($amenities)) {
			foreach( $amenities as $id=>$value )  {
				$this->setAmenityId( $value );
				$this->save();
			}
			return true;
		}
		else
		return false;
	}
	 
	 
	public function getUnitModelAmenities(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('uma'=>'unitModelAmenity') )
		->join( array('a'=>'amenity'),'uma.amenityId=a.id',array('a.name'))
		->where('uma.unitModelId=?', $this->getUnitModelId() );

		$resultSet = $db->query( $query );
			
		$container = array();

		foreach ($resultSet as $row)
		$container[$row['amenityId']] = $row['name'];

		return $container;
	}
}
?>
