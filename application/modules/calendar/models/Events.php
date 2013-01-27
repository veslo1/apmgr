<?php
/**
 * Event model to handle the calendar events.
 * This handles a parent event
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Calendar_Model_Events extends ZFModel_ParentModel implements Calendar_Model_Interface_Rules {

	/**
	 * The title of this event
	 * @var string $title
	 */
	protected $title;

	/**
	 * The data of this event
	 * @var string $data
	 */
	protected $data;

	/**
	 * Is this a whole day event
	 * @var boolean $allDayEvent
	 */
	protected $allDayEvent;

	/**
	 * The owner of this event
	 * @var integer $owner
	 */
	protected $owner;

	/**
	 * @param array $options
	 * @return
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Calendar_Model_DbTable_Events');
		$this->setProperties(APPLICATION_PATH . "/modules/calendar/configs/application.ini", APPLICATION_ENV);
	}

	/**
	 * Retrieve the userId that created this event
	 * @return integer
	 */
	public function getOwner() {
		return $this->owner;
	}

	/**
	 * @param int $owner
	 * @return Calendar_Model_Events
	 */
	public function setOwner( $owner) {
		$this->owner = $owner;
		return $this;
	}

	/**
	 * Sets the title of this event
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * Return the title of this event
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Set the data of this event
	 * @param string $data
	 */
	public function setData($data) {
		$this->data = $data;
		return $this;
	}

	/**
	 * Return the title of this event
	 * @return string
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 *
	 * @param bool $allDayEvent
	 */
	public function setAllDayEvent($allDayEvent) {
		$this->allDayEvent = $allDayEvent;
		return $this;
	}

	/**
	 *
	 * @return bool
	 */
	public function getAllDayEvent() {
		return $this->allDayEvent;
	}

	/**
	 * This is for the view , when you retrieve one single event.
	 * You retrieve the event , the eventTime and the eventNotification list.
	 * The eventTime contains an array of Events_Model_EventsTime objects.
	 * The eventNotification contains an array of User_Model_User objects.
	 * @param int $eventId The event you are trying to find information about
	 * @param array $sortNotifications Apply a sort filter in the notifications resultset
	 * @param array $sortGuests Apply a sort filter in the guest list
	 * @return array
	 */
	public function showSingleDayEvent($eventId, $sortEventTime,$sortGuests) {

		$end = array();
		$guestList = array();
		$result = array('event'=>null,'eventTime'=>null,'eventNotification'=>null,'invalid'=>true);

		$eventObject = $this->findById($eventId);

		$userHelper = new User_Library_Helper_Utils();
		$userId = User_Library_Helper_Utils::currentUserId();
		//  If we do find the event , mark it as valid
		if( !empty($eventObject) ) {
			$result['invalid'] = false;
			$guestList = array();
			$guestList = $this->getGuestList($eventId,$sortGuests);
			$guests = array_keys($guestList);
			if( $eventObject->getOwner()==$userId or
			$userHelper->isRole('admin')==true or in_array($userId, $guests) ) {
				$result['event'] = $eventObject;

				$eventTime = new Calendar_Model_EventsTime();

				$result['eventTime'] = $eventTime->findByKey(
				array(
                        'columnToSort'=>$sortEventTime['column'],
                        'sortDirection'=>$sortEventTime['sort'],
                        'returnClassObject'=>true,
                        'search'=> array( 'eventId' =>$eventId)
				)
				);

				$result['eventNotification'] = $guestList;
			} else {
				$result['invalid'] = true;
			}
		}
		return $result;
	}

	/**
	 * Retrieve the guests for the given eventId in an indexed key.
	 * The sortCriteria parameter allows us to sort this array
	 * The return value of this method contains the userId as the key , and a user object
	 * @param int $eventId
	 * @param array $sortCriteria
	 * @return array
	 */
	public function getGuestList($eventId,$sortCriteria) {
		$guestList = array();

		$db = $this->getDbTable()->getAdapter();

		$select = $db->select()
		->from(array('EN'=>'eventsNotification'))
		->join(array('U' => 'user'),'U.id = EN.guestId')
		->where('EN.eventId=?',$eventId,'integer');

		if( isset($sortCriteria['column']) ) {
			$select->order($sortCriteria['column'].' '.$sortCriteria['sort']);
		}

		$resultSet = $db->query($select);

		if( count($resultSet) == 0 ) {
			return $guestList;
		}

		foreach($resultSet as $id=>$row) {
			$guestList[$row['id']] = new User_Model_User($row);
		}
		return $guestList;
	}

	/**
	 * Determine if the given record exists
	 * @param int $id
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
				$utils = new User_Library_Helper_Utils();
				$userId = User_Library_Helper_Utils::currentUserId();
				$isAdmin = $utils->isRole('admin');

				$eventData = $this->findById($eventId);
				$owner = $eventData->getOwner()==$userId or $isAdmin ? true:false;
			} else {
				$this->setMessageState('evdnexist');
			}
		}
		return $owner;
	}
}
?>