<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * Update the info on regarding this event
 */
class Calendar_DeleteController extends ZFController_Controller {

	/**
	 * Delete all the occurences of an event.
	 */
	public function deleteeventAction() {
		$eventId = $this->getRequest()->getParam('eventId');

		$event = new Calendar_Model_Events();
		$args = array('user'=>new User_Model_User(),'eventId'=>$eventId);
		//  Determine, we can perform the operation
		if( $event->ownership($args) == true ) {
			$deleted = $event->delete($eventId);
			if($deleted!=false) {
				$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
				$this->_flashMessenger->addMessage('eventDeleted');
				$props = $event->getProperties();
				return $this->_redirect($props->event->saved->landing);
			}
			$event->setMessageState('etDeleteBlock');
		} else {
			$event->setMessageState('notYourRecord');
		}
		//  If we reach this point , something failed
		$this->view->msg = $this->getMessage($event->getMessageState());
	}

	/**
	 * Delete a guest from your event
	 */
	public function deleteguestAction() {
		$eventId = $this->getRequest()->getParam('eventId');
		$eventGuestId = $this->getRequest()->getParam('guestId');

		$event = new Calendar_Model_Events();
		$args = array('user'=>new User_Model_User(),'eventId'=>$eventId);
		//  Determine, we can perform the operation
		if( $event->ownership($args) == true ) {
			$eventNotification = new Calendar_Model_EventsNotification();
			$deleted = $eventNotification->deleteGuest($eventGuestId, $eventId);
			if($deleted!=false) {
				$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
				$this->_flashMessenger->addMessage('eventGuestDeleted');
				$props = $event->getProperties();
				$landing = $props->event->deleted->landing."/$eventId";
				return $this->_redirect($landing);
			}
			$event->setMessageState('etDeleteBlock');
		} else {
			$event->setMessageState('notYourRecord');
		}
		//  If we reach this point , something failed
		$this->view->msg = $this->getMessage($event->getMessageState());
	}

	/**
	 * Delete all guests
	 */
	public function deleteallguestsAction() {
		$eventId = $this->getRequest()->getParam('eventId');
		$eventGuestId = $this->getRequest()->getParam('guestId');

		$event = new Calendar_Model_Events();
		$args = array('user'=>new User_Model_User(),'eventId'=>$eventId);
		//  Determine, we can perform the operation
		if( $event->ownership($args) == true ) {
			$eventNotification = new Calendar_Model_EventsNotification();
			$deleted = $eventNotification->deleteAllGuests($eventId);
			if($deleted!=false) {
				$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
				$this->_flashMessenger->addMessage('eventGuestsDeleted');
				$props = $event->getProperties();
				$landing = $props->event->deleted->landing."/$eventId";
				return $this->_redirect($landing);
			}
			$event->setMessageState('etDeleteBlock');
		}
		//  If we reach this point , something failed
		$this->view->msg = $this->getMessage($event->getMessageState());
	}

	/**
	 * Delete an occurence of a eventTime record
	 */
	public function deleteeventtimeAction() {
		$eventId = $this->getRequest()->getParam('eventId');
		$eventTimeId = $this->getRequest()->getParam('id');

		$event = new Calendar_Model_Events();
		$args = array('user'=>new User_Model_User(),'eventId'=>$eventId);
		//  Determine, we can perform the operation
		if( $event->ownership($args) == true ) {
			$eventTime = new Calendar_Model_EventsTime();
			$deleted = $eventTime->deleteByEventId($eventId, $eventTimeId);
			if($deleted!=false) {
				$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
				$this->_flashMessenger->addMessage('eventDeleted');
				$props = $event->getProperties();
				$landing = $props->event->deleted->landing."/$eventId";
				return $this->_redirect($props->event->deleted->landing);
			}
			$event->setMessageState('etDeleteBlock');
		} else {
			$event->setMessageState('notYourRecord');
		}
		//  If we reach this point , something failed
		$this->view->msg = $this->getMessage($event->getMessageState());
	}
}
?>