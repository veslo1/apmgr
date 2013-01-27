<?php
/**
 * Created on Oct 31, 2009
 * CreateController.php
 * @author jvazquez
 * @package application.modules
 * @subpackage messages.controllers
 * <p>
 * Delete Controller for the messages system
 * The following actions are on this page.
 * <ul>
 * 	<li>Help</li>
 * <li>Delete</li>
 * </ul>
 * </p>
 */

class Messages_DeleteController extends Zend_Controller_Action {

	public function helpAction() {

	}

	/**
	 * This action is called via Ajax. We don't render a page for this one, and there's no associated view for this.
	 * @return string
	 */
	public function indexAction() {
		//	Result of the operation.
		$result = false;

		//	We don't use a view
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$messageProduct = new Messages_Model_Messages();

		$id = $this->getRequest()->getParam('messageId');
		if( !empty($id) ) {
			//	Do a small check to verify that the specified record exists
			$exists = $messageProduct->findById($id);

			if( empty($exists) ) {
				$errorMessage = array_shift( $messageProduct->findByKey(array('returnClassObject'=>true,'search'=>array('identifier'=>'resourceExist'),'like'=>false ) ) );
				echo $errorMessage->getMessage();
			} else {
				//	The resource exists.
				$success = $exists->delete($id);
				if( $success ) {
					$succesMessage = array_shift( $messageProduct->findByKey(array('returnClassObject'=>true,'search'=>array('identifier'=>'msgDeleted'),'like'=>false ) ) );
					echo $succes->getMessage();
				} else {
					$succesMessage = array_shift( $messageProduct->findByKey(array('returnClassObject'=>true,'search'=>array('identifier'=>'msgDeleted'),'like'=>false ) ) );
					echo $succes->getMessage();
				}
			}
		}
	}

	public function __toString(){
		return "Messages, DeleteController";
	}

}
?>