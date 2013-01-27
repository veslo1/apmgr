<?php
/**
 * Events notification model.
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Model for the EventsNotification table</p>
 */

class Calendar_Model_EventsNotification extends ZFModel_ParentModel implements Calendar_Model_Interface_Rules {

	/**
	 * The event id we are using.
	 * @var integer
	 */
	protected $eventId;

	/**
	 * The user id that will retrieve this notification
	 * @var integer
	 */
	protected $guestId;

	/**
	 * Is this event mark as readed
	 * @var integer
	 */
	protected $confirmed;

	/**
	 * @param array $options
	 * @return
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Calendar_Model_DbTable_EventsNotification');
	}

	/**
	 * @return integer
	 */
	public function getEventId() {
		return $this->eventId;
	}

	/**
	 * @param integer $eventId
	 */
	public function setEventId($eventId) {
		$this->eventId = $eventId;
		return $this;
	}

	/**
	 * @param integer $confirmed
	 */
	public function setConfirmed($confirmed) {
		$this->confirmed = $confirmed;
		return $this;
	}

	/**
	 * @return integer
	 */
	public function getConfirmed() {
		return $this->confirmed;
	}

	/**
	 * @param int $guestid
	 */
	public function setGuestId($guestid) {
		$this->guestId = $guestid;
		return $this;
	}

	/**
	 * @return integer
	 */
	public function getGuestId() {
		return $this->guestId;
	}

	/**
	 * Retrieve all the guests and save.
	 * @param array $options
	 * @return boolean
	 */
	public function prepareSave(array $options=null) {
		$saved = true;
		if( !empty($options['attendees']) ) {
			$this->setEventId($options['eventId']);
			$savedNotifications = array();
			foreach($options['attendees'] as $id=>$guestId) {
				$this->setGuestId($guestId);
				$savedNotifications[] = $this->save();
			}
			$saved = !in_array(false,$savedNotifications);
		}
		return $saved;
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

	/**
	 * Delete the given guest from the given event
	 * @param $guestId
	 * @return boolean
	 */
	public function deleteGuest($guestId,$eventId) {
		$deleted = false;
		$db = $this->getDbTable()->getAdapter();

		$select = $db->select()
		->from(array('EN'=>'eventsNotification'))
		->where('eventId=?',$eventId,'integer')
		->where('guestId=?',$guestId,'integer');
		$resultSet = $db->query($select);

		if( count($resultSet) > 0 ) {
			foreach($resultSet as $id=>$row) {
				$deleted = $this->delete($row['id']);
			}
		}
		return $deleted;
	}

	/**
	 * Delete all the guests from your event
	 * @param int $eventId
	 * @return boolean
	 */
	public function deleteAllGuests($eventId) {
		$stackDeleted = array();
		$db = $this->getDbTable()->getAdapter();

		$select = $db->select()
		->from(array('EN'=>'eventsNotification'))
		->where('eventId=?',$eventId,'integer');
		$resultSet = $db->query($select);

		if( count($resultSet) > 0 ) {
			foreach($resultSet as $id=>$row) {
				$stackDeleted[] = $this->delete($row['id']);
			}
		} else {
			$stackDeleted[] = false;
		}

		return !in_array(false,$stackDeleted);
	}
}
?>