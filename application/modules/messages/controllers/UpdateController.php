<?php
/**
 * Created on Oct 31, 2009
 * CreateController.php
 * @author jvazquez
 * @package application.modules
 * @subpackage messages.controllers
 * <p>
 * Index Controller for the messages system
 * </p>
 */

class Messages_UpdateController extends Zend_Controller_Action implements ZFObserver_ILogeable {

	/**
	 * Display a form that allows the user to update the messages.
	 * @return Zend_View
	 */
	public function indexAction() {
		$form = new Messages_Form_Update();

		$messages = new Messages_Model_Messages();

		$category = $this->getRequest()->getParam('category');
		$id = $this->getRequest()->getParam('id');

		if ( empty($id) or !is_numeric($id) or $id<0 ) {
			//	We have a really funny problem. We are updating a message, and an error happened. Call the message factory and show an error message
			$errorMessage = array_shift( $messages->findByKey(array('returnClassObject'=>true,'search'=>array('identifier'=>'haveId'),'like'=>false ) ));
			$this->view->messages = $errorMessage;
		} else {
			//	Retrieve the data
			$info = $messages->findById($id);
			//	Populate the form
			$form->populate( array ( 'id'=>$info->getId(),'message'=>$info->getMessage(),'identifier'=>$info->getIdentifier(),'dateCreated'=>$info->getDateCreated(),'dateUpdated'=>$info->getDateUpdated(),'locked'=>$info->getLocked(),'language'=>$info->getLanguage() ) );
			if( $info->getLocked() ) {
				$form->getElement('locked')->setAttrib('disabled',true);
			}

			if ( $this->getRequest()->isPost() && $form->isValid( $this->getRequest()->getParams() ) ) {
				//	Retrieve the language of the user
				$locale = Zend_Registry::get('Zend_Locale');
				$language = $locale->getLanguage()."_".$locale->getRegion();
				//	Call the update method.
				$info->setMessage($form->getValue('message'));
				$info->setIdentifier($form->getValue('identifier'));
				$info->setLocked($form->getValue('locked'));
				$info->setLanguage($language);
				$result = $info->save();
				if ( $result ) {
					$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
					$this->_flashMessenger->addMessage( 'messageUpdated' );
					$this->_helper->redirector('index', 'view', 'messages');
				} else {
					$error = array_shift( $messages->findByKey(array('returnClassObject'=>true,'search'=>array('identifier'=>'msgUpdateFail'),'like'=>false ) ) );
					$this->view->messages = $error;
				}
			}
			$this->view->form = $form;
		}
	}
}