<?php
/**
 * Created on Feb 14, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Holds the base rent schedule for a given unit model
 * </p>
 */


class Unit_Model_ModelRentSchedule extends ZFModel_ParentModel {

	/**
	 *@var unitModelId
	 */
	protected $unitModelId;

	/**
	 *@var effectiveDate
	 */
	protected $effectiveDate;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_ModelRentSchedule');
	}
	 
	/**
	 * unitModelId
	 */
	public function setUnitModelId( $var ) {
		$this->unitModelId = $var;
	}

	public function getUnitModelId() {
		return $this->unitModelId;
	}
	 
	/**
	 * effectiveDate
	 */
	public function setEffectiveDate( $var ) {
		$this->effectiveDate = $var;
	}

	public function getEffectiveDate() {
		return $this->effectiveDate;
	}
	 
	/**
	 *  Get latest schedule via unitModelId
	 *
	 */
	public function getLatestSchedule()  {
		$id = $this->getEffectiveDateByModelId();
		$this->setId( $id );

		// if nothing is returned it means the model does not have a current schedule for the specified date
		return $this->getSchedule();    // fetches the individual months in the schedule.  false means no items (which in theory should never be the case)
	}

	/**
	 *  Returns the id of the current schedule that should be in use
	 */
	private function getEffectiveDateByModelId(){
		$db = $this->getDbTable()->getAdapter();

		/**
		 *
		 *  SELECT `rs`.`id`
		 *  FROM `modelRentSchedule` AS `rs`
		 *  where effectiveDate<=NOW()
		 *  and unitModelId=1
		 *  order by effectiveDate DESC
		 *
		 **/

		$date = $this->getEffectiveDate();

		$query = $db->select()
		->from( array('rs'=>'modelRentSchedule'), array('id') )
		->where( 'unitModelId=?', $this->getUnitModelId() );
	  
		if( $date )
		$query->where( 'effectiveDate<=?', $date );
		else
		$query->where( 'effectiveDate<=NOW()');

		$query->order( 'effectiveDate DESC' );

		$data = $db->fetchRow( $query );

		if( isset( $data ) )
		return $data['id'];
		else
		return null;
	}


	/**
	 *  Get individual schedule
	 */
	 
	public function getSchedule() {
		if( !$this->getId() ){  // if no schedule id set, don't run query
		    return false;
		}
		else {
			$db = $this->getDbTable()->getAdapter();
			$query = $db->select()
			->from( array('rs'=>'modelRentSchedule') )
			->join( array('rsi'=>'modelRentScheduleItem'),'rsi.modelRentScheduleId=rs.id', array('rentAmount','numMonths','modelRentScheduleItemId'=>'id') )
			->where('rs.id=?', $this->getId())
			->order( 'rsi.numMonths ASC' );
				
			//echo $query->__toString(); die;
			$resultSet = $db->query( $query );
			$container = array();

			foreach ($resultSet as $row) {
			    $container[] = $row;
			}
			
			return $container;
		}
	}
	
	/**
 	 *  Get attached rent schedules
 	*/
 	public function getAttachedSchedules(){
 	    $db = $this->getDbTable()->getAdapter();
 	    
 	    //  Naaaarwhaaaaaal
 	    $query = "SELECT mrs.id
 	              FROM modelRentSchedule AS mrs
 		          JOIN lease AS l ON l.modelRentScheduleId = mrs.id
 		          UNION
 		          SELECT mrs.id
 	              FROM modelRentSchedule AS mrs
 		          JOIN leaseWizard AS lw ON lw.modelRentScheduleId = mrs.id";
 		      
            $resultSet = $db->query( $query );
 			
 	    $container = array();
 
 	    foreach ($resultSet as $row){
 		$container[$row['id']] = $row['id'];
 	    }	    
 	    return $container;	    
 	}
} // end class
?>
