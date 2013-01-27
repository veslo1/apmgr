<?php
/**
 * Created on Feb 18, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Holds the base rent schedule items for a given unit model
 * </p>
 */


class Unit_Model_ModelRentScheduleItem extends ZFModel_ParentModel {

	/**
	 *@var modelRentScheduleId
	 */
	protected $modelRentScheduleId;

	/**
	 *@var rentAmount
	 */
	protected $rentAmount;

	/**
	 *@var numMonths
	 */
	protected $numMonths;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_ModelRentScheduleItem');
	}
	 
	/**
	 * modelRentScheduleId
	 */
	public function setModelRentScheduleId( $var ) {
		$this->modelRentScheduleId = $var;
	}

	public function getModelRentScheduleId() {
		return $this->modelRentScheduleId;
	}

	/**
	 * rentAmount
	 */
	public function setRentAmount( $var ) {
		$this->rentAmount = $var;
	}

	public function getRentAmount() {
		return $this->rentAmount;
	}
	 
	/**
	 *  numMonths
	 */
	public function setNumMonths( $var ) {
		$this->numMonths = $var;
	}

	public function getNumMonths() {
		return $this->numMonths;
	}
}
?>
