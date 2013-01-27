<?php
/**
 * Created on May 10, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Stores the info from the rentSettings table
 * Should only have one setting row
 * </p>
 */


class Unit_Model_RentSettings extends ZFModel_ParentModel {

	/**
	 *@var prorationEnabled
	 */
	protected $prorationEnabled;  // is proration enabled?

	/**
	 *@var rentDueDate
	 */
	protected $rentDueDay;  // the day of the month rent is due in the system (1st of month for example)
	 
	/**
	 *@var prorationType
	 */
	protected $prorationType;  // thirtyday, actual, yearly

	/**
	 *@var prorationApplyMonth
	 */
	protected $prorationApplyMonth;  // the month to apply the proration (1st month, 2nd month, etc)

	/**
	 *@var secondMonthDue
	 */
	protected $secondMonthDue;  // is the second month due on lease signing?
	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_RentSettings');
	}
	 
	/**
	 * prorationEnabled
	 */
	public function setProrationEnabled( $var ) {
		$this->prorationEnabled = $var;
	}

	public function getProrationEnabled() {
		return $this->prorationEnabled;
	}

	/**
	 * rentDueDay
	 */
	public function setRentDueDay( $var ) {
		$this->rentDueDay = $var;
	}

	public function getRentDueDay() {
		return $this->rentDueDay;
	}

	/**
	 * prorationType
	 */
	public function setProrationType( $var ) {
		$this->prorationType = $var;
	}

	public function getProrationType() {
		return $this->prorationType;
	}

	/**
	 * prorationApplyMonth
	 */
	public function setProrationApplyMonth( $var ) {
		$this->prorationApplyMonth = $var;
	}

	public function getProrationApplyMonth() {
		return $this->prorationApplyMonth;
	}

	/**
	 * secondMonthDue
	 */
	public function setSecondMonthDue( $var ) {
		$this->secondMonthDue = $var;
	}

	public function getSecondMonthDue() {
		return $this->secondMonthDue;
	}

	/**
	 *  Returns the setting row
	 */
	public function getSetting(){
		return $this->findById(1);
	}
}
?>
