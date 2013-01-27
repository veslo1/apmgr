<?php
/**
 * Created on Oct 31, 2009
 * CreateController.php
 * @author jvazquez
 * @package application.modules
 * @subpackage messages.controllers
 * <p>
 * Create Controller for the messages system
 * </p>
 */

class Messages_CreateController extends Zend_Controller_Action implements ZFObserver_ILogeable {

	public function indexAction() {
		$form = new Messages_Form_Create();
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$messages = new Messages_Model_Messages();

		if ( $this->getRequest()->isPost() && $form->isValid( $this->getRequest()->getParams() ) ) {
			$category = $form->getValue('category');
			if( !empty($category) ) {
				//				//	Build an object of this category, since I don't have enums in php, I've got to do it this way.
				$locale = Zend_Registry::get('Zend_Locale');
				$language = $locale->getLanguage()."_".$locale->getRegion();
				$messages->setIdentifier($form->getValue('identifier'));
				$messages->setMessage($form->getValue('message'));
				$messages->setCategory($category);
				$messages->setLocked($form->getValue('locked'));
				$messages->setLanguage($language);

				$saved = $messages->save();
				if( $saved ) {
					$this->_flashMessenger->addMessage( 'messageCreated' );
					$this->_helper->redirector('index', 'view', 'messages');
				}
			}
		}

		$this->view->form = $form;
		//	If the messages stack is empty, just check to see if we have something
		$this->view->messages = array_shift( $this->_flashMessenger->getMessages() );
	}

	/**
	 * Returns the name of this module.
	 * @return string
	 */
	public function __toString() {
		return "Messages, DeleteController";
	}
}
