<?php
/**
 * Created on Sep 5, 2009 by jvazquez
 * The user controller object.
 * This object represents the user controller object, it defines the actions that a user may take
 * while looking the user page.
 * It calls the user model, and retrieves the information required for to show.
 * @package application.modules.user.controllers
 */
class User_CreateController extends ZFController_Controller
{
	/**
	 * Main controller to create a user
	 * @return Zend_View
	 */
	public function indexAction()
	{
		$bo = new User_Library_Implementation_Bo();
		$form = $bo->getCreateUserForm();
		if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) )
		{
			$bo->setDao(new User_Library_Implementation_Dao());
			$id = $bo->save($this->getRequest()->getParams());
			if( $id!=false )
			{
				$this->_redirector = $this->_helper->getHelper('Redirector');
				$url = "user/view/index/id/$id";
				$this->_redirector->gotoUrl($url);
			}
		}
		$this->view->msg = $bo->getMessageState();
		$this->view->form = $form;
	}
}
?>