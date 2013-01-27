<?php
/**
 * Created on May 10, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Class for handling proration stuff
 * </p>
 */

class Unit_Model_Proration extends ZFModel_ParentModel {

	/**
	 *@var rentSettings
	 */
	protected $rentSettings;  // object holding the row from the rentSetting table

	/**
	 *@var baseRentAmount
	 *the base amount of the rent to prorate
	 */
	protected $baseRentAmount;

	/**
	 *  @var moveInDate
	 *  The numerical day the person moves in
	 */
	protected $moveInDate;


	/**
	 *  @var monthSequence
	 *  The month in the sequence ( month 1, month 2, etc )
	 */
	protected $monthSequence;


	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$settings = new Unit_Model_RentSettings();
		$row = $settings->findById(1);  // should only return 1 row
		$this->setRentSettings( $row );
	}

	/**
	 * rentSettings
	 */
	public function setRentSettings( $var ) {
		$this->rentSettings = $var;
	}

	public function getRentSettings() {
		return $this->rentSettings;
	}

	/**
	 * baseRentAmount
	 */
	public function setBaseRentAmount( $var ) {
		$this->baseRentAmount = $var;
	}

	public function getBaseRentAmount() {
		return $this->baseRentAmount;
	}

	/**
	 * moveInDay
	 */
	public function setMoveInDate( $var ) {
		$this->moveInDate = $var;
	}

	public function getMoveInDate() {
		return $this->moveInDate;
	}

	/**
	 * monthSequence
	 */
	public function setMonthSequence( $var ) {
		$this->monthSequence = $var;
	}

	/**
	 *  If month sequence is not passed use the default month sequence as the current month sequence
	 *  This approach is used when wanting to find the month with the discount without looping through the array
	 */
	public function getMonthSequence() {
		if( $this->monthSequence )
		return $this->monthSequence;
		else
		return $this->getRentSettings()->getProrationApplyMonth();
	}

	/**
	 *  Returns the day of the move in date
	 */
	private function getDay(){
		$date = date_parse($this->getMoveInDate());
		return $date['day'];
	}

	/**
	 *  Returns the month of the move in date
	 */
	private function getMonth(){
		$date = date_parse($this->getMoveInDate());
		return $date['month'];
	}

	/**
	 *  Returns the days in the month
	 */
	private function getDaysInMonth(){
		return (integer)date("t",strtotime($this->getMoveInDate()));
	}

	/**
	 *  Function to determine the amount to return based on if the rentSettings table
	 *
	 *  Steps:
	 *
	 *  1.  Check if discount is on.  If not on, return the base amount
	 *  2.  Else if it is on
	 *
	 *      a.  check the day of the move in date to see if proration is needed (check against day in rentSettings)
	 *
	 *      b.  check setting for the month proration is applied towards.
	 *          If it is the current month (1 or 2), pull the proration amount.
	 *          Else return base amount
	 */
	public function getAmountDue(){
		if( $this->getDay() != $this->getRentSettings()->getRentDueDay()  // move in date is not the same as the rent due date in settings
		&& $this->getRentSettings()->getProrationEnabled()   // proration is enabled
		&& $this->getMonthSequence() == $this->getRentSettings()->getProrationApplyMonth()) {  // The month this is called for is 1 or 2 (the months rent can be prorated for)
			 
			return $this->calculateRentProration();
		}
		else
		return $this->getBaseRentAmount();
	}


	/**
	 *  Return rent calcuation
	 */
	public function calculateRentProration(){
		$prorationType = $this->getRentSettings()->getProrationType();
		$amount=null;

		switch( $prorationType ) {
			case 'thirtyday':
				$amount = $this->thirtyDayMonthCalcuation();
				break;
				 
			case 'actual':
				$amount = $this->actualMonthCalcuation();
				break;

			case 'year':
				$amount = $this->yearCalcuation();
				break;
		}

		return $amount;
	}

	/**
	 *  Calculates the amount due based on the number of days in the month
	 *  and the daily rent amount
	 */
	private function calculateAmount( $daysInMonth, $dailyRentAmount ){
		$proratedAmount = ( $daysInMonth - ($this->getDay()-1 ) ) * $dailyRentAmount;
		return $proratedAmount;
	}

	/**
	 *  Calculation for rent based on the thirty day method
	 *
	 *  (30 days - move in day -1 ) * daily rent amount
	 *
	 *  Ex: Monthly rent $500
	 *      Daily monthy rent $16.67
	 *      Move in Date:  April 2
	 *
	 *      (30 days - ( date of move in - 1 ) ) * daily rent amount
	 *
	 *      The -1 is used to count the day moved in as a day occupied
	 *
	 *      30 - (2-1) = 29 days living in the apartment
	 *
	 *      29 * 16.67 = 483.43 due
	 */
	private function thirtyDayMonthCalcuation() {
		$daysInMonth = 30;
		$dailyRentAmount = $this->getDailyRentAmountMonthBased( $daysInMonth );
		return $this->calculateAmount( $daysInMonth, $dailyRentAmount );
	}

	/**
	 *  Calculation for rent based on a yearly basis
	 *
	 *  (30 days - move in day -1 ) * daily rent amount
	 *
	 *  Ex: Monthly rent $500
	 *      Daily monthy rent $16.44
	 *      Move in Date:  April 2
	 *
	 *      (30 days - ( date of move in - 1 ) ) * daily rent amount
	 *
	 *      The -1 is used to count the day moved in as a day occupied
	 *
	 *      30 - (2-1) = 29 days living in the apartment
	 *
	 *      29 * 16.44 = 476.76 due
	 */
	private function yearCalcuation() {
		$daysInMonth = $this->getDaysInMonth();  //  uses actual days in month
		$dailyRentAmount = $this->getDailyRentAmountYearBased();
		return $this->calculateAmount( $daysInMonth, $dailyRentAmount );
	}

	 
	/**
	 *  Calculation for rent based on the actual days in the month
	 *
	 *  (30 days - move in day -1 ) * daily rent amount
	 *
	 *  Ex: Monthly rent $500
	 *      Move in Date:  July 2
	 *      Daily monthy rent $16.13
	 *
	 *      (30 days - ( date of move in - 1 ) ) * daily rent amount
	 *
	 *      The -1 is used to count the day moved in as a day occupied
	 *
	 *      31 - (2-1) = 29 days living in the apartment
	 *
	 *      30 * 16.13 = 483.90 due
	 */
	private function actualMonthCalcuation() {
		$daysInMonth = $this->getDaysInMonth();  //  uses actual days in month
		$dailyRentAmount = $this->getDailyRentAmountMonthBased( $daysInMonth );
		return $this->calculateAmount( $daysInMonth, $dailyRentAmount );
	}


	/**
	 *  Based on 30 day month
	 *
	 *  Ex:  $500 rent per month
	 *       30 days in a month
	 *
	 *       $500 / 30 = 16.67 daily rent amount (rounded)
	 */
	private function getDailyRentAmountMonthBased($daysInMonth){
		return round(($this->getBaseRentAmount() / $daysInMonth), 2);
	}

	/**
	 *  Calculates the rent based on a 365 day year
	 *
	 *  Ex: $500 rent per month
	 *      500 * 12 months = $6000 rent paid per year
	 *      $6000 / 365 = 16.44 per day
	 *      $6000 / 366 = 16.39 per day
	 */
	private function getDailyRentAmountYearBased() {
		$daysInYear = ( date("L",strtotime($this->getMoveInDate())) )? 366 : 365; // tests for leap year
		return round( (($this->getBaseRentAmount() * 12) / $daysInYear), 2);
	}
}
 
?>
