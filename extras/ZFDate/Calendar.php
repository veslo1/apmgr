<?php
/**
 * Main class for calendar gui
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class ZFDate_Calendar {

	/**
	 * Contains all the days for the given period
	 * @var string
	 */
	protected $collection;

	public function  __construct() {

	}

	/**
	 * Generate the collection of data that is going to be used for the given
	 * calendar
	 * @param int $year
	 * @param int $month
	 * @return array $collection
	 */
	public function yieldCalendar($year,$month) {
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/modules/calendar/configs/application.ini", APPLICATION_ENV);
		$this->collection = array();
		$lastDayOfMonth = date($config->date->day, mktime(0, 0, 0, $month, 0, $year));
		for( $i=1 ; $i<=$lastDayOfMonth ; $i++ ) {
			$timestamp = mktime(0,0,0,$month,$i,$year);
			$day = date('j',$timestamp);
			$this->collection[$day] = $timestamp;
		}
		return $this->collection;
	}
}
?>