<?php
/**
 * Create Controller for the calendar
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Calendar_ViewController extends ZFController_Controller {

	/**
	 * Display the calendar month for the whole month
	 */
	public function indexAction() {
		$month = $this->getRequest()->getParam('month');
		$year =  $this->getRequest()->getParam('year');
		$options = array('month'=>$month,'year'=>$year,'action'=>'view/index');
		$calendar = new ZFHtml_Table($options);
		$this->view->calendar = $calendar->yield();
	}

	public function dailyviewAction() {
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$options = array();
		$month = $this->getRequest()->getParam('month');
		$year =  $this->getRequest()->getParam('year');
		$day =  $this->getRequest()->getParam('day');
		if( isset($month) and isset($year) and isset($day) ) {
			$options ['date'] = $year."-".$month."-".$day;
		}
		if($auth->getIdentity()) {
			$options['userid'] =(int) $auth->getIdentity()->id;
		}

		$calendar = new ZFHtml_TableDaily($options);
		$this->view->calendar = $calendar->yield();
	}

	/**
	 * View events for the week
	 */
	public function weekviewAction() {
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		if($auth->getIdentity()) {
			$options['userid'] =(int) $auth->getIdentity()->id;
		}
		$calendar = new ZFHtml_WeekTable($options);
		$this->view->calendar = $calendar->yield();
	}
	/**
	 * View the single event
	 */
	public function vieweventAction() {
		//	Retrieve messages
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$strMessage = $this->_flashMessenger->getMessages();
		$this->_flashMessenger->clearMessages();

		if( !empty($strMessage) ) {
			$message = new Messages_Model_Messages();
			$result = $message->findByKey(array('returnClassObject'=>true,'search'=>array('identifier'=>$strMessage[0])));
			if(!empty($result)) {
				$this->view->msg = array_shift( $result);
			}
		}

		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$event = new Calendar_Model_Events();
		$dbFields = array('dbTable'=>'events','column'=>'id');
		$props = $event->getProperties();
		$this->view->dateFormat = $props->date->format;

		$contactsColumn = $this->getRequest()->getParam('contacts');
		$contactsSort = $this->getRequest()->getParam('sortcontacs');
		$this->view->sortContacts = ( $contactsSort=='ASC') ? 'DESC' : 'ASC';
		$sortContacts = array('column'=>$contactsColumn,'sort'=>$contactsSort);

		$timeColumn = $this->getRequest()->getParam('time');
		$timeSort   = $this->getRequest()->getParam('timesort');
		$sortTime   = array('column'=>$timeColumn,'sort'=>$timeSort);
		$this->view->sortTime = ( $timeSort=='ASC') ? 'DESC' : 'ASC';

		$eventId = $this->getRequest()->getParam('id');
		$result = $event->showSingleDayEvent($eventId,$sortTime,$sortContacts);

		$this->view->lock = $result['invalid'];
		$this->view->lockcontact = !empty($result['eventNotification']);
		$this->view->event = $result['event'];
		$this->view->eventTime = $this->paginate($result['eventTime']);
		$this->view->eventNotification = $this->paginate($result['eventNotification']);
	}
}
?>