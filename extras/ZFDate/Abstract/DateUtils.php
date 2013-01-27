<?php
/**
 * Abstract class that implements the basic functionality for creating
 * html calendars.
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
abstract class ZFDate_Abstract_DateUtils {
	/**
	 * The number of days in each month. You're unlikely to want to change this...
	 * The first entry in this array represents January.
	 */
	protected $daysInMonth;

	/**
	 * The initial day of this month
	 * @var integer
	 */
	protected $startDay;

	/**
	 * The labels to display for the months of the year. The first entry in
	 * this array represents January.
	 * @var array
	 */
	protected $monthNames;

	/**
	 * @var integer
	 */
	protected $year;

	/**
	 * @var integer
	 */
	protected $month;

	/**
	 *
	 * @var Zend_Config
	 */
	private $properties;

	/**
	 * The labels to display for the days of the week. The first entry in this
	 * arrayrepresents Sunday.
	 */
	protected $dayNames;

	/**
	 * Used for pagination
	 * @var string
	 */
	protected $action;

	/**
	 *
	 * Adjust dates to allow months > 12 and < 0. Just adjust the years
	 * appropriately.
	 * @example Month 14 of the year 2001 is actually month 2 of year 2002.
	 * @param integer $month
	 * @param integer $year
	 * @return integer
	 */
	public function adjustDate($month=0,$year=0) {
		$a = array();
		if($month==0) {
			$month = $this->getMonth();
		}

		if($year==0) {
			$year = $this->getYear();
		}

		$a[0] = $month;
		$a[1] = $year;

		while ($a[0] > 12) {
			$a[0] -= 12;
			$a[1]++;
		}

		while ($a[0] <= 0) {
			$a[0] += 12;
			$a[1]--;
		}

		return $a;
	}

	/**
	 * Get the current month
	 * @param integer $month
	 */
	public function setMonth($month) {
		$this->month = $month;
	}

	/**
	 * Set the current month
	 * @return integer
	 */
	public function getMonth() {
		return $this->month;
	}

	/**
	 * Set the year
	 * @param integer $year
	 */
	public function setYear($year) {
		$this->year = $year;
	}

	/**
	 * Return the current year
	 * @return integer
	 */
	public function getYear() {
		return $this->year;
	}

	/**
	 * Calculate the number of days in a month, taking into account leap years.
	 * @return integer
	 */
	public function getDaysInMonth() {

		$month = $this->getMonth();
		$year = $this->getYear();

		if ($month < 1 or $month > 12) {
			return 0;
		}
		$d = $this->daysInMonth[$month];

		if ($month == 2) {
			// Check for leap year
			// Forget the 4000 rule, I doubt I'll be around then...

			if ($year%4 == 0) {
				if ($year%100 == 0) {
					if ($year%400 == 0) {
						$d = 29;
					}
				}
				else {
					$d = 29;
				}
			}
		}

		return $d;
	}

	/**
	 * Init the month dates depending on the locale of the user
	 */
	public function setMonthNames() {

		//  Tell zend that we want to use php date formats
		Zend_Date::setOptions(array('format_type' => 'php'));
		$zd = new Zend_Date();
		$zd->setLocale(Zend_Registry::get('Zend_Locale'));
		$properties = $this->getProperties();
		$this->monthNames = array();
		for($i=1;$i<=12;$i++) {
			$zd->setMonth($i);
			$this->monthNames[$i] = $zd->toString($properties->calendar->month->longmonthname);
		}
	}

	/**
	 * Return the Translated month names
	 * @return array
	 */
	public function getMonthNames() {
		return $this->monthNames;
	}

	public function setProperties() {
		//  Load our settings
		$this->properties = new Zend_Config_Ini(APPLICATION_PATH . "/modules/calendar/configs/application.ini", APPLICATION_ENV);
	}

	/**
	 *
	 * @return Zend_Config
	 */
	public function getProperties() {
		if($this->properties==null) {
			$this->setProperties();
		}
		return $this->properties;
	}

	/**
	 * Build the link for the previous months
	 * @param int $month
	 * @param int $year
	 * @param string $action
	 * @return string
	 */
	public function getCalendarLink($month, $year,$action='view') {
		$baseurl = Zend_Controller_Front :: getInstance()->getBaseUrl() ? Zend_Controller_Front :: getInstance()->getBaseUrl() : "/calendar/view/index/";
		$baseurl .="month/$month/year/$year";
		return $baseurl;
	}

	/**
	 * Set the name of the days
	 */
	public function setDayNames() {
		$properties = $this->getProperties();
		$this->dayNames = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
	}

	/**
	 *
	 * @return array
	 */
	public function getDayNames() {
		return $this->dayNames;
	}

	/**
	 * Gets the start day of the week. This is the day that appears in the
	 * first column of the calendar. Sunday = 0.
	 * @return integer
	 */
	public function getStartDay() {
		return $this->startDay;
	}

	/**
	 * Sets the start day of the week. This is the day that appears in the
	 * first column of the calendar. Sunday = 0.
	 * @param integer $day
	 */
	public function setStartDay($day=0) {
		$this->startDay = $day;
	}


	/**
	 * Gets the start month of the year. This is the month that appears first
	 * in the year view. January = 1.
	 * @return integer
	 */
	public function getStartMonth() {
		return $this->startMonth;
	}

	/**
	 * Sets the start month of the year. This is the month that appears first
	 * in the year view. January = 1.
	 * @param integer $month
	 */
	public function setStartMonth($month=1) {
		$this->startMonth = $month;
	}

	/**
	 * Return the URL to link to  for a given date.
	 * You must override this method if you want to activate the date linking
	 * feature of the calendar.
	 * Note: If you return an empty string from this function, no navigation
	 * link will be displayed. This is the default behaviour.
	 * @todo finish
	 * @return string
	 */
	public function getDateLink($day, $month, $year,$action='view') {
		$baseurl = Zend_Controller_Front :: getInstance()->getBaseUrl() ? Zend_Controller_Front :: getInstance()->getBaseUrl() : "/calendar/";
		$baseurl .= "view/dailyview/day/$day/month/$month/year/$year";
		return $baseurl;
	}

	/**
	 * Set the days per month
	 */
	public function setDaysInMonth() {
		$properties = $this->getProperties();
		$this->daysInMonth = array();
		for($i=1;$i<=12;$i++) {
			$this->daysInMonth[$i] = cal_days_in_month(CAL_GREGORIAN, $i, $this->year);
		}
	}

	/**
	 * Set the action in the links
	 * Do not send the leading / , we take care of that
	 * @param string $action
	 */
	public function setAction($action) {
		$baseurl = Zend_Controller_Front :: getInstance()->getBaseUrl() ? Zend_Controller_Front :: getInstance()->getBaseUrl() : "/";
		$this->action = $baseurl.$action;
	}

	/**
	 * Return the action that we are going to have in the links
	 * @return string
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * Produce an array of time according to what is set in the configuration.
	 * @deprecated This is killing php totally , <strong>do not use at all</strong>
	 * If left alone running , can generate a dump of 100 megs
	 * @return array
	 */
	public function yieldIntervalHours() {
		$result = array();
		$props = $this->getProperties();
		$startHour = $props->time->firsthour;
		$endHour = $props->time->lasthour;

		//  Create the timestamps
		$timestampStart = date_parse($startHour);
		$timestampStart = mktime($timestampStart['hour'], $timestampStart['minute'], $timestampStart['second']);

		//  Create the endTimestamp
		$timestampEnd = date_parse($endHour);
		$timestampEnd = mktime($timestampEnd['hour'], $timestampEnd['minute'], $timestampEnd['second']);
		//  @todo Last checks , all the number issue.
		Zend_Date::setOptions(array('format_type' => 'php'));
		$timeStart = new Zend_Date();
		$timeStart->setLocale(Zend_Registry::get('Zend_Locale'));
		$timeStart->setTimestamp($timestampStart);

		//  Fetch the first hour
		$result[] = $timeStart->toString($props->time->format);
		while( $timeStart->isEarlier($timestampEnd) ) {
			$timeStart->addMinute($props->time->interval->mode);
			$result[] = $timeStart->toString($props->time->format);
		}
		return $result;
	}

	/**
	 * Retrieve the next int days for a week.
	 * This method depends on the configuration option week.long value
	 */
	public function fetchWeekDays() {
		$weekDays = array();
		$i = 1;
		Zend_Date::setOptions(array('format_type' => 'php'));
		$date = new Zend_Date();
		$date->setLocale(Zend_Registry::get('Zend_Locale'));
		$date->setDate(Zend_Date::now(Zend_Registry::get('Zend_Locale')));
		$props = $this->getProperties();
		$week = $props->calendar->week->long;

		while( $i<$week ) {
			$weekDays[] = new Zend_Date($date);
			$date->addDay(1);
			$i++;
		}
		return $weekDays;
	}

	/**
	 * Determine the proper time range for this event.
	 * @param int $timeFix The hour that the event occurs
	 * @param array $timeRange The time range that we use to generate the event
	 */
	public function fixTime($timeFix,$timeRange) {
		//  This is the time of the event
		$currentTime = date_parse($timeFix);
		$timeFix = false;

		if( empty($currentTime['errors']) ) {
			//  Try to generate an array with the matches of hours
			$timeFilter = new ZFDate_Filters_HourFilter($timeRange);
			$timeFilter->setTarget($currentTime['hour']);

			$hourMatch = array();
			foreach($timeFilter as $id=>$key) {
				$hourMatch[] = $key;
			}

			/**
			 * Determine the calculations , if we don't find anything similar try to
			 * push this event in a slot where you have at least events
			 * where the <strong>hour</strong> difference is equal to 1 hour
			 */
			if ( count($hourMatch) == 0 ) {
				$timeFix = $this->timeCalc('hour',$timeRange,$currentTime );
			} else {
				//  We found at least a couple of slots that are in the same hour
				$timeFix = $this->timeCalc('minute',$hourMatch,$currentTime );
			}
		}
		return $timeFix;
	}

	/**
	 *
	 * @param string $mode
	 * @param array $hourMatch
	 * @return mixed
	 */
	private function timeCalc($mode,$hourMatch,$currentTime) {
		//  We will use this to store the differences
		$difference = array();
		$timeFix = false;
		//  Retrieve the settings to determine which difference it's acceptable
		//  in terms of minutes, hours
		$props = $this->getProperties();
		$hourLowerValue = $props->timediff->hour->lowervalue;
		$hourUpperValue = $props->timediff->hour->uppervalue;
		$minuteLowerValue = $props->timediff->minute->lowervalue;
		$minuteUpperValue = $props->timediff->minute->uppervalue;
		$format = $props->time->calc->id;

		foreach($hourMatch as $id=>$hour) {
			$range = date_parse($hour);
			if( empty($range['errors']) ) {

				$result = $currentTime[$mode] - $range[$mode];
				switch($mode) {
					case 'hour':
						if( $result >= $hourLowerValue and $result<$hourUpperValue ) {
							$difference[] = date($format,mktime($range['hour'],$range['minute'],null));
						}
						break;
					case 'minute':

						if( $result >= $minuteLowerValue and $result<=$minuteUpperValue ) {
							$difference[] = date($format,mktime($range['hour'],$range['minute'],null));
						}
						break;
					default:
						throw Exception('This case has not been implemented');
						break;
				}
			}
		}

		/**
		 * Sort the array to retrieve the lowest value
		 * and after sorting the array say , the lowest difference is where
		 * I'm going to place the array. If the array was empty , just return false
		 * because we couldn't find a proper place to store this event
		 */
		if( !empty($difference) ) {
			asort($difference);
			$timeFix = $difference[0];
		}

		return $timeFix;
	}

	/**
	 * Helper method , we have a recordset and a domdocument object
	 * that we need to push information into. The times have to be fixed
	 * so we can push them inside the domobject.
	 * @param DOMDocument $dom
	 * @param array $records
	 * @param array $constrains
	 */
	abstract public function fixTimeAndIntegrate($dom,$records,$constrains);
}
?>