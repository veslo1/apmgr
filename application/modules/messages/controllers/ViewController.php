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
class Messages_ViewController extends ZFController_Controller {

	/**
	 * Display all the messages in the system.
	 * @return Zend_View
	 */
	public function indexAction() {
		$this->getFlashMessages();
		$column = $this->_getParam('column');
		$sort = $this->_getParam('sort');
		$message = new Messages_Model_Messages();
		$this->view->messages = $this->paginate($message->fetchAll($column, $sort,true));
		$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
	}
}