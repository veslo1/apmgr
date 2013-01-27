<?php
/**
 * @author jorgeomarvazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.controllers
 * Displays the user information and lists all the users
 */
class User_ViewController extends ZFController_Controller
{

	/**
	 * Main action of this controller
	 * The main page , will always retrieve messages , since somewhat is the destination page
	 * for all the CRUD operations , so we will receive a message.
	 */
	public function indexAction()
	{
		$bo = new User_Library_Implementation_Bo();
		$bo->setDao(new User_Library_Implementation_Dao());
		$users = $bo->viewAllUserInformation($this->getRequest()->getParams());
		$this->view->users= $this->paginate($users);
		$this->view->msg = $bo->getMessageState();
	}

	/**
	 * Fetches the information of a particular user
	 */
	public function infoAction()
	{
		$bo = new User_Library_Implementation_Bo();
		$bo->setDao(new User_Library_Implementation_Dao());
		$this->view->user = $bo->viewUserInformation($this->getRequest()->getParam('id'));
		$msg = $bo->getMessageState();
		$this->view->msg = $msg['msg'];
		$this->view->type = $msg['type'];
	}
}
?>
