<?php
/**
 * Created on Oct 31, 2009
 * IndexController.php
 * @author jvazquez
 * @package application.modules
 * @subpackage messages.controllers
 * <p>
 * Index Controller for the messages system
 * </p>
 */

class Messages_IndexController extends Zend_Controller_Action implements ZFObserver_ILogeable {
	public function indexAction() {
		//TODO Create a help file
	}

	public function __toString(){
		return "Messages, IndexController";
	}
}
