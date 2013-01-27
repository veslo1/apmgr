<?php
/**
 * Event model to handle the calendar events.
 * Subclass of Calendar_Model_Events
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * Zend_Date::setOptions(array('format_type' => 'php'));
 */

class Calendar_Model_EventsTime extends ZFModel_ParentModel implements Calendar_Model_Interface_Rules {
	/**
	 *
	 * @var double
	 */
	protected $startTime;

	/**
	 * @var double
	 */
	protected $endTime;

	/**
	 *
	 * @var double
	 */
	protected $startDate;

	/**
	 *
	 * @var double
	 */
	protected $endDate;

	/**
	 * List for an array of dates
	 * @var array
	 */
	protected $datePeriod;

	/**
	 * @param array $options
	 * @return
	 */
	public function __construct(array $options = null) {
		$this->setProperties(APPLICATION_PATH . "/modules/calendar/configs/application.ini", APPLICATION_ENV);
		parent::__construct( $options );
		$this->setDbTable('Calendar_Model_DbTable_EventsTime');
	}

	/**
	 * Return the time this event starts
	 * @return string
	 */
	public function getStartTime() {
		return $this->startTime;
	}

	/**
	 * Set the time , the specified value musy be an array, whith the following format.
	 * @example 'eventTimeFrom'=>array('hour'=>date('H'),'minute'=>date('i'),'seconds'=>date('s'))
	 * @param array $time
	 * @return Calendar_Model_Calendar
	 */
	public function setStartTime($time) {
		if( $time==null or empty($time) ) {
			throw new InvalidArgumentException('Unhandled time format');
		}
		Zend_Date::setOptions(array('format_type' => 'php'));
		$date = new Zend_Date();
		$date->setLocale(Zend_Registry::get('Zend_Locale'));
		if( stristr($time,':') ) {
			$tm = date_parse($time);
			$time = mktime($tm['hour'], $tm['minute'], $tm['second']);
		}
		$date->setTimestamp($time);
		$props = $this->getProperties();

		$this->startTime = $date->toString($props->time->sqlformat);
		return $this;
	}

	/**
	 * Set the time , the specified value musy be an array, whith the following format.
	 * @param double $time
	 * @return Calendar_Model_EventsTime
	 */
	public function setEndTime($time) {
		if( $time==null or empty($time) ) {
			throw new InvalidArgumentException('Unhandled timeTo format');
		}
		Zend_Date::setOptions(array('format_type' => 'php'));
		$date = new Zend_Date();
		$date->setLocale(Zend_Registry::get('Zend_Locale'));

		if( stristr($time,':') ) {
			$tm = date_parse($time);
			$time = mktime($tm['hour'], $tm['minute'], $tm['second']);
		}
		$date->setTimestamp($time);
		$props = $this->getProperties();
		$this->endTime = $date->toString($props->time->sqlformat);
		return $this;
	}

	/**
	 * Return the time this events ends
	 * @return string
	 */
	public function getEndTime() {
		return $this->endTime;
	}

	/**
	 * Sets the eventId that is the parent of this object
	 * @param integer $eventId
	 * @return Calendar_Model_EventsChilds
	 */
	public function setEventId($eventId) {
		$this->eventId = $eventId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getEventId() {
		return $this->eventId;
	}

	/**
	 * @return string
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * @param double $zDate
	 * @return Calendar_Model_Calendar
	 * Fixing bug in startDate, when we are called, and we do not receive a
	 * timestamp , the application fails.
	 * @throws Exception Zend_Date_Exception
	 */
	public function setStartDate($timestamp=null) {
		if( $timestamp==null or empty($timestamp) ) {
			throw new InvalidArgumentException('Unhandled date format');
		}

		Zend_Date::setOptions(array('format_type' => 'php'));
		$zDate = new Zend_Date();
		$zDate->setLocale(Zend_Registry::get('Zend_Locale'));

		if( stristr($timestamp, '-') or stristr($timestamp, '/') ) {
			$dte = date_parse($timestamp);
			$timestamp = mktime(null, null, null, $dte['month'], $dte['day'], $dte['year']);
		}
		$zDate->setTimestamp($timestamp);
		$props = $this->getProperties();
		$this->startDate = $zDate->toString($props->date->sqlformat);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEndDate() {
		return $this->endDate;
	}

	/**
	 * @param double $date
	 * @return Calendar_Model_Calendar
	 */
	public function setEndDate($timestamp) {
		if( $timestamp==null or empty($timestamp) ) {
			throw new InvalidArgumentException('Unhandled date format');
		}
		Zend_Date::setOptions(array('format_type' => 'php'));
		$date = new Zend_Date();
		$date->setLocale(Zend_Registry::get('Zend_Locale'));
		if( stristr($timestamp, '-') or stristr($timestamp, '/') ) {
			$dte = date_parse($timestamp);
			$timestamp = mktime(null, null, null, $dte['month'], $dte['day'], $dte['year']);
		}
		$date->setTimestamp($timestamp);
		$props = $this->getProperties();
		$this->endDate = $date->toString($props->date->sqlformat);
		return $this;
	}

	/**
	 * Determine if there are more dates between startDate and endDate
	 * The compare is done between dateFrom <strong>against</strong> dateTo
	 * @return boolean
	 */
	public function hasDates() {
		$startDate = $this->getStartDate();
		$endDate = $this->getEndDate();
		$zdFrom = new Zend_Date();
		$zdTo = new Zend_Date();
		$zdFrom->setLocale(Zend_Registry::get('Zend_Locale'));
		$zdTo->setLocale(Zend_Registry::get('Zend_Locale'));

		$dateArrayFrom = date_parse($startDate);
		$dateArrayTo = date_parse($endDate);
		$zdFrom->setTimestamp(mktime(0,0,0,$dateArrayFrom['month'],$dateArrayFrom['day'],$dateArrayFrom['year']));
		$zdTo->setTimestamp(mktime(0,0,0,$dateArrayTo['month'],$dateArrayTo['day'],$dateArrayTo['year']));
		$result = $zdFrom->compare($zdTo);
		return $result;
	}

	/**
	 * Determine if there are hours between startTime and endTime
	 * The compare is done between timeFrom <strong>against</strong> timeTo
	 * @return boolean
	 */
	public function hasTime() {
		$startTime = $this->getStartTime();
		$endTime = $this->getEndTime();
		$zdFrom = new Zend_Date();
		$zdTo = new Zend_Date();
		$zdFrom->setLocale(Zend_Registry::get('Zend_Locale'));
		$zdTo->setLocale(Zend_Registry::get('Zend_Locale'));

		$timeArrayFrom = date_parse($startTime);
		$timeArrayTo = date_parse($endTime);
		//mktime($hour, $minute, $second);
		$zdFrom->setTimestamp(mktime($timeArrayFrom['hour'],$timeArrayFrom['minute'],$timeArrayFrom['second']));
		$zdTo->setTimestamp(mktime($timeArrayTo['hour'],$timeArrayTo['minute'],$timeArrayTo['second']));
		$result = $zdFrom->compare($zdTo);
		return $result;
	}

	/**
	 * Using the dateTo and dateFrom generate an array of recursive dates.
	 */
	public function yieldDates() {
		$equals = false;
		$props = $this->getProperties();

		$startDate = $this->getStartDate();
		$endDate = $this->getEndDate();
		$zdFrom = new Zend_Date();
		$zdTo = new Zend_Date();
		$zdFrom->setLocale(Zend_Registry::get('Zend_Locale'));
		$zdTo->setLocale(Zend_Registry::get('Zend_Locale'));

		$dateArrayFrom = date_parse($startDate);
		$dateArrayTo = date_parse($endDate);
		$zdFrom->setTimestamp(mktime(0,0,0,$dateArrayFrom['month'],$dateArrayFrom['day'],$dateArrayFrom['year']));
		$zdTo->setTimestamp(mktime(0,0,0,$dateArrayTo['month'],$dateArrayTo['day'],$dateArrayTo['year']));

		while( $zdFrom->compare($zdTo)!=0 ) {
			$zdFrom->addDay(1, Zend_Registry::get('Zend_Locale'));
			$this->datePeriod[] = $zdFrom->toString($props->date->sqlformat);
		}
	}

	/**
	 * @return array
	 */
	public function getRecursiveDates() {
		return $this->datePeriod;
	}

	/**
	 * Prepare a save operation
	 * @param array $options
	 * @return boolean
	 */
	public function prepareSave(array $options=null) {
		$saved = false;
		//  Skip date parse from looping forever , maybe later check the retrieved pieces
		$predateFrom = explode("-", $options['startDate']);
		$predateTo = explode("-", $options['endDate']);
		$preTimeFrom = explode(":",$options['startTime']);
		$preTimeTo = explode(":",$options['endTime']);

		if( count($predateFrom)==3 and count($predateTo)==3 and count($preTimeFrom) and count($preTimeTo) ) {
			//  Set the Date info
			$startDate = date_parse($options['startDate']);
			$startDate = mktime(null, null, null, $startDate['month'], $startDate['day'],$startDate['year']);
			$endDate = date_parse($options['endDate']);
			$endDate = mktime(null, null, null, $endDate['month'], $endDate['day'],$endDate['year']);

			//  Set the time info. If we said it's a full day event, then just override whatever he wrote with the settings
			if($options['allDayEvent']==1) {
				$props = $this->getProperties();
				$startTime = date_parse($props->time->firsthour);
				$startTime = mktime($startTime['hour'], $startTime['minute'], $startTime['second']);
				$endTime = date_parse($props->time->lasthour);
				$endTime = mktime($endTime['hour'], $endTime['minute'], $endTime['second']);
			} else {
				$startTime = date_parse($options['startTime']);
				$startTime = mktime($startTime['hour'], $startTime['minute'], $startTime['second']);
				$endTime = date_parse($options['endTime']);
				$endTime = mktime($endTime['hour'], $endTime['minute'], $endTime['second']);
			}

			$this->setStartDate($startDate);
			$this->setEndDate($endDate);
			$this->setStartTime($startTime);
			$this->setEndTime($endTime);
			$this->setEventId($options['eventId']);

			//  Determine if we have to create multiple records
			if($this->hasDates()!=0) {
				//  Create the bigArray
				$this->yieldDates();
				$dates = $this->getRecursiveDates();
				$multipleSave = array();
				foreach($dates as $id=>$date) {
					$newDate = date_parse($date);
					$newDate = mktime(null, null, null, $newDate['month'], $newDate['day'], $newDate['year']);
					$this->setStartDate($newDate);
					$this->setEndDate($newDate);
					$multipleSave[] = $this->save();
				}
				$saved = !in_array(false,$multipleSave);
			} else {
				$saved = $this->save();
			}
		}
		return $saved;
	}

	/**
	 * Retrieve events for the given date
	 * @param int $userid
	 * @param string $date
	 * @param boolean $guestMode
	 * @return array
	 */
	public function fetchEvents($userId,$date,$guestMode=false) {
		$events = array();
		$props = $this->getProperties();

		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from(
		array('E' => 'events'),
		array('id'=>'E.id','title'=>'E.title','allDayEvent'=>'E.allDayEvent')
		)
		->join(
		array('ET'=>'eventsTime'),
                'E.id = ET.eventId',
		array(  'startTime'=>"TIME_FORMAT( `ET`.`startTime`, '%k:%i')",
                'pivotMinute'=>"TIME_FORMAT( `ET`.`startTime`, '%i')",
                'endTime'=>'ET.endTime',
                'startDate'=>'ET.startDate',
                'endDate'=>'ET.endDate',
                'domId'=>"CONCAT( DATE_FORMAT(`ET`.`startDate`,'%Y-%m-%d') , '-',TIME_FORMAT(`ET`.`startTime`, '%k:%i'))"
                )
                );

                if($guestMode==true) {
                	$select->join( array('EN' =>'eventsNotification'),
                    'E.id = EN.eventId',
                	array('guestId'=>'EN.guestId'))
                	->where('EN.guestId=?',$userId,'integer');
                } else {
                	$select->where('E.owner=?',$userId,'integer');
                }

                $select->where('ET.startDate=?',$date,'string');

                $resultSet = $db->query($select);

                if( count($resultSet) == 0 ) {
                	return $events;
                }

                foreach ( $resultSet as $row ) {
                	$events[] = $row;
                }

                return $events;
	}

	/**
	 * Retrieve all the events for a week for the given user, we seed the start
	 * date and the end date and the userid
	 * @internal The date formating in the date it's <strong>fundamental</strong>
	 * @param string $dateStart
	 * @param int $period
	 * @param int $userId
	 */
	public function fetchEventsForWeek( $dateStart, $period, $userId) {
		$events = array();
		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from(
		array('E' => 'events'),
		array('id'=>'E.id','title'=>'E.title','allDayEvent'=>'E.allDayEvent')
		)
		->join(
		array('ET'=>'eventsTime'),
                'E.id = ET.eventId',
		array(  'startTime'=>"TIME_FORMAT( `ET`.`startTime`, '%k:%i')",
                'pivotMinute'=>"TIME_FORMAT( `ET`.`startTime`, '%i')",
                'endTime'=>'ET.endTime',
                'startDate'=>'ET.startDate',
                'endDate'=>'ET.endDate',
                'domId'=>"CONCAT( DATE_FORMAT(`ET`.`startDate`,'%Y-%m-%d') , '-',TIME_FORMAT(`ET`.`startTime`, '%k:%i'))"
                )
                )
                ->where('E.owner=?',$userId,'integer')
                ->where('ET.startDate>=?',$dateStart,'string')
                ->where("ET.endDate<=DATE_ADD('$dateStart',INTERVAL $period WEEK)");
                $resultSet = $db->query($select);

                if( count($resultSet) == 0 ) {
                	return $events;
                }

                foreach ( $resultSet as $row ) {
                	$events[] = $row;
                }
                return $events;
	}

	/**
	 * Retrieve all the events for a week for the given user, we seed the start
	 * date and the end date and the userid
	 * @internal The date formating in the date it's <strong>fundamental</strong>. Fluent is broken
	 * if you split it with an if else block, the query is broken
	 * @param string $dateStart
	 * @param int $period
	 * @param int $userId
	 */
	public function fetchEventsForWeekGuest( $dateStart, $period, $userId) {
		$events = array();
		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from(
		array('E' => 'events'),
		array('id'=>'E.id','title'=>'E.title','allDayEvent'=>'E.allDayEvent')
		)
		->join(
		array('ET'=>'eventsTime'),
                'E.id = ET.eventId',
		array(  'startTime'=>"TIME_FORMAT( `ET`.`startTime`, '%k:%i')",
                'pivotMinute'=>"TIME_FORMAT( `ET`.`startTime`, '%i')",
                'endTime'=>'ET.endTime',
                'startDate'=>'ET.startDate',
                'endDate'=>'ET.endDate',
                'domId'=>"CONCAT( DATE_FORMAT(`ET`.`startDate`,'%Y-%m-%d') , '-',TIME_FORMAT(`ET`.`startTime`, '%k:%i'))"
                ))
                ->join( array('EN' =>'eventsNotification'),
                'E.id = EN.eventId',
                array('guestId'=>'EN.guestId'))
                ->where('EN.guestId=?',$userId,'integer')
                ->where('ET.startDate>=?',$dateStart,'string')
                ->where("ET.endDate<=DATE_ADD('$dateStart',INTERVAL $period WEEK)");

                $resultSet = $db->query($select);

                if( count($resultSet) == 0 ) {
                	return $events;
                }

                foreach ( $resultSet as $row ) {
                	$events[] = $row;
                }
                return $events;
	}

	/**
	 * Delete an eventTime record by the given eventId
	 * @param int $eventId
	 * @param int $eventTimeId
	 * @return boolean
	 */
	public function deleteByEventId($eventId,$eventTimeId) {
		$deleted = false;
		$stack = $this->findByKey( array('search'=>array('eventId'=>$eventId)) );

		if( count($stack)>1 ) {
			$deleted = $this->delete($eventTimeId);
		}

		return $deleted;
	}

	/**
	 * Determine if the given record exists
	 * @param <type> $id
	 * @return boolean
	 */
	public function exists($id) {
		$result = $this->findById($id);
		return !empty($result);
	}
	/**
	 * Determine if the given user is the owner of this event or he is an admin and can perform
	 * actions with the event
	 * @param array $args
	 * @example
	 * $args = array('user'=>$user,'eventId'=>1);
	 * $cal->eventOwnerShip($args);
	 */
	public function ownership(array $args=null) {
		$owner = false;
		if( !is_array($args) ) {
			$this->setMessageState('exceptionCaught');
		} else {
			$eventId = $args['eventId'];

			if( $this->exists($eventId)==true ) {
				$userHelper = new User_Library_Helper_Utils();
				$userId = User_Library_Helper_Utils::currentUserId();
				$isAdmin = $userHelper->isRole('admin');

				$eventData = $this->findById($eventId);
				$owner = $eventData->getOwner()==$userId or $isAdmin ? true:false;
			} else {
				$this->setMessageState('evdnexist');
			}
		}
		return $owner;
	}

}