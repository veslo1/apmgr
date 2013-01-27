<?php
/**
 * Create Controller for the calendar
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Calendar_CreateController extends ZFController_Controller {

	public function indexAction() {
		$form = new Calendar_Form_Create();
		if( $this->getRequest()->isPost() && $form->isValid( $this->getRequest()->getParams() ) ) {
			$userId = User_Library_Helper_Utils::currentUserId();
			$options = array('title'=>$this->getRequest()->getParam('title'),'data'=>$this->getRequest()->getParam('data'),'owner'=>$userId,'allDayEvent'=>$this->getRequest()->getParam('allDayEvent'));
			$events = new Calendar_Model_Events($options);
			$eventId = $events->save();
			if($eventId!=false) {
				$optionsChild = array('startDate'=>$this->getRequest()->getParam('startDate'),'endDate'=>$this->getRequest()->getParam('endDate'),'startTime'=>$this->getRequest()->getParam('startTime'),'endTime'=>$this->getRequest()->getParam('endTime'),'eventId'=>$eventId,'allDayEvent'=>$this->getRequest()->getParam('allDayEvent'));
				$eventsTime = new Calendar_Model_EventsTime();
				$savedTimes = $eventsTime->prepareSave($optionsChild);
				$eventsNotification = new Calendar_Model_EventsNotification();
				$savedNotification = $eventsNotification->prepareSave(array('attendees'=>$this->getRequest()->getParam('attendees'),'eventId'=>$eventId));
				if($savedTimes!=false and $savedNotification!=false) {
					$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
					$this->_flashMessenger->addMessage('eventSaved');
					$props = $events->getProperties();
					return $this->_redirect($props->event->saved->landing);
				}
				//  Purge all and notify
				$events->delete($eventId);
				$this->msg = $this->getMessage('eventSaveFail');
			}
			$this->msg = $this->getMessage('eventSaveFail');
		}
		$this->view->form = $form;
	}
}
?>