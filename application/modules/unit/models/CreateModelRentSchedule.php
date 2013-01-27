<?php
/**
 * Created on May 30, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Class to create rent model schedules
 * </p>
 */


class Unit_Model_CreateModelRentSchedule extends ZFModel_ParentModel {

	protected $numMonths;  // used for saving to item table
	protected $rentAmount;  // used for saving to item table

	protected $rs;  // rent schedule object
	protected $rsi;  // rent schedule item object

	protected $db; // db object

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		//parent::__construct( $options );
		$this->db = Zend_Registry::get('db');
		$this->rs = new Unit_Model_ModelRentSchedule(array( 'dbAdapter'=> $this->db));
		$this->rsi = new Unit_Model_ModelRentScheduleItem(array( 'dbAdapter'=> $this->db));
	}
	 
	/**
	 * unitModelId
	 */
	public function setUnitModelId( $var ) {
		$this->rs->setUnitModelId( $var );
	}
	/**
	 * effectiveDate
	 */
	public function setEffectiveDate( $var ) {
		$this->rs->setEffectiveDate( $var );
	}
	 
	/**
	 *  These functions are used for passing the items to the rent schedule item from the form (in array form)
	 */
	private function getNumMonths() {
		return $this->numMonths;
	}

	public function setNumMonths( $var ) {
		$this->numMonths = $var;
	}

	private function getRentAmount() {
		return $this->rentAmount;
	}

	public function setRentAmount( $var ) {
		$this->rentAmount = $var;
	}
	 
	/**
	 *  Validates that the effective date exists
	 */
	private function effectiveDateExists() {
	    if($this->exists(array('table'=>'modelRentSchedule','column'=>'effectiveDate'),$this->rs->getEffectiveDate())){
	        return $this->setMessageState('effectiveDateExists');
	    } 	
	    else {
	        return false;
	    }
	}
	 
	/**
	 *  Saves the rent schedule
	 */
	public function saveRentSchedule(){
		if( !$this->effectiveDateExists() ) {  // if the name doesn't exist, continue
			$this->db->beginTransaction();

			try{
				$id = $this->rs->save();   // save schedule
				$this->rsi->setModelRentScheduleId( $id );
				$this->checkMonths( $this->getNumMonths() );	
				if($this->saveScheduleItems( $this->getNumMonths(), $this->getRentAmount() ))  { // save schedule items
				    $this->db->commit();
				}
				return $id;
			}
			catch ( Exception $e) {  // return error message to model state if save fails
				$this->db->rollBack();								
				return false;
			}
		}  // end validate if
		else {   // name exists, set message
			$this->setMessageState( 'duplicateName' );
			return false;
		}
	}    // end save schedule function
	 
	/**
	 *  Save schedule items from the save form ( multiple rows )
	 *  Receives the form month and rent info
	 */
	private function saveScheduleItems( $months, $rentAmounts ){
	    // modelrentscheduleitem - rentamount and nummonths
	    try{		
	 	foreach( $months as $id => $numMonth ){
	 		$this->rsi->setNumMonths( $numMonth );
	 		$this->rsi->setRentAmount( $rentAmounts[$id] );
	 		$this->rsi->save();
	 	}
	 	return true;
	    }
	    catch ( Exception $e) {			        
		return false;
	    }
	} // end save schedule item
	
	/**
	 *  Checks that there are no duplicates in the months 
	 */	
	private function checkMonths( $months ){		
	    $count = array_count_values($months);
	    /* the count should equal the number of items in the array
	     array{
		    1=>2
		    2=>1		    
	     }	     
	     and count($months) would return 3 so there is a duplicate.
	     
	     A non duplicate would be
	     
	     array{
		    1=>1
		    2=>1
		    3=>1
	     }	     
	     and count($months) would return 3 so the is no duplicate.
	     
	    */	   
	    if( count($months)!=count($count) ){		
		$this->setMessageState('duplicateMonth');
	        throw new Exception();	
	    }
	    return true;
	}	
	
} // end class
?>
