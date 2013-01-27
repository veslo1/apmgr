<?php
/**
 * Created on Sep 13, 2009
 * RoleController.php
 * jvazquez
 * @package modules.role.controllers
 * <p>
 * This controller handles the Roles in the System
 * </p>
 */

class Role_IndexController extends ZFController_Controller {

	/**
	 * The main action of this application.
	 */
	public function indexAction() {
		//  Retrieve messages if we have them
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$strMessage = $this->_flashMessenger->getMessages();
		$this->_flashMessenger->clearMessages();
		if( !empty($strMessage) ) {
			$identifier = array_shift($strMessage);
			$this->view->messageResult = $this->getMessage($identifier);
		}
	}
}
?>