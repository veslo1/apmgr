<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * Update the info on regarding this event
 */
class Calendar_UpdateController extends ZFController_Controller {

	/**
	 * Update a single event
	 *
	 */
	public function updateeventAction() {
		$error = false;
		$userHelper = new User_Library_Helper_Utils();

		$userid = User_Library_Helper_Utils::currentUserId();
		$isAdmin = $userHelper->isRole('admin');

		$eventid = $this->getRequest()->getParam('id');

		//  If we don't have the eventid , just fail
		if( !isset($eventid) ) {
			$this->view->msg = $this->getMessage('missingid');
			$error = true;
		} else {
			$event = new Calendar_Model_Events();
			$eventData = $event->findById($eventid);
			//  If we have the event information
			if( !empty($eventData) ) {
				$owner = $eventData->getOwner();
				//  And if we are the owner or we are an admin
				if( $userid==$owner or $isAdmin==true) {

					$form = new Calendar_Form_UpdateEvent();

					$args = array('title'=>$eventData->getTitle(),'allDayEvent'=>$eventData->getAllDayEvent(),'data'=>$eventData->getData());

					if( $this->getRequest()->isPost() and
					$form->isValid( $this->getRequest()->getParams() ) ) {
						$args = $this->getRequest()->getParams();

						$eventData->setTitle($args['title'])
						->setData($args['data'])
						->setAllDayEvent($args['allDayEvent']);
						$saved = $eventData->save();
						if( $saved!=false ) {
							$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
							$this->_flashMessenger->addMessage('eventSaved');
							$props = $event->getProperties();
							return $this->_redirect($props->event->updated->landing);
						}
					} else {
						$form->populate($args);
					}
					$this->view->form = $form;
				} else {
					$error = true;
					$this->view->msg = $this->getMessage('notYourRecord');
				}
			} else {
				$error = true;
				$this->view->msg = $this->getMessage('resourceExist');
			}
		}
		$this->view->error = $error;
	}
}