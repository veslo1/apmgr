<?php
/**
 * Created on Oct 3, 2009. User index displays all the available actions for the user
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @package application.modules.user.controllers
 *
 */
class User_IndexController extends ZFController_Controller
{
	/**
	 * Main action for the user module
	 */
	public function indexAction()
	{
		$this->view->id = User_Library_Helper_Utils::currentUserId();
	}

	/**
	 * Main action to handle with the forgot password scenario
	 */
	public function forgotpasswordAction()
	{
		
		$retrieve = new User_Library_Implementation_RetrievalBo();
		$retrieve->setDao(new User_Library_Implementation_RetrieveDao());
		$retrieve->setUserDao(new User_Library_Implementation_Dao());
		$form = $retrieve->getForgotPasswordForm();
		if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) )
		{
			$retrieve->setEmailAgent(new Zend_Mail_Transport_Sendmail());
			$recovered = $retrieve->recoverPassword($this->getRequest()->getParams());
			if(true==$recovered)
			{
				$this->setMessage($retrieve->getMessageState());
				$this->_redirect('user/index/index');
			}
		}
		$this->setMessage($retrieve->getMessageState());
		$this->view->form = $form;
	}

	/**
	 * Displays a form so the user can provide an email
	 * If the email is found , we mail to the registered
	 * account the username information
	 */
	public function forgotusernameAction()
	{
		$bo = new User_Library_Implementation_Bo();
		$form = $bo->getForgotUserNameForm();
		if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) )
		{
			$bo->setDao(new User_Library_Implementation_Dao());
			$bo->recoverUserName($this->getRequest()->getParam('emailAddress'));
		}
		$this->view->form = $form;
		$args = $bo->getMessageState();
		$this->view->msg = $args['msg'];
		$this->view->type = $args['type'];
	}

	/**
	 * We display a brief information about what to do in case
	 * the user can't recover the information , how to contact us
	 */
	public function forgotinfoAction()
	{}

	public function infoAction()
	{
		$bo = new User_Library_Implementation_Bo();
		$bo->setDao(new User_Library_Implementation_Dao());
		$this->view->user = $bo->viewUserInformation($this->getRequest()->getParam('id'));
		$msg = $bo->getMessageState();
		$this->view->msg = $msg['msg'];
		$this->view->type = $msg['type'];
	}
	
	/**
	 * This action will take care of receiving the requests from the emails to reset the passwords
	 */
	public function resetpasswordAction()
	{
		$token = $this->getRequest()->getParam('token',null);
		$service = new User_Library_Implementation_RetrievalBo();
		$service->setDao(new User_Library_Implementation_RetrieveDao());
		if ($service->verifyToken($token)==true)
		{
			$form = $service->getResetPasswordForm();
			if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) )
			{
				$args['hashToken'] = $this->getRequest()->getParam('token');
				$args['password'] = $this->getRequest()->getParam('password');
				if ( $service->resetPassword($args)!==false )
				{
					$service->disableToken($args['hashToken']);
					$this->setMessage(array('msg'=>'passwordReseted','type'=>'success'));
					$this->_redirect('user/index/index');
				}
			}
			$this->view->form = $form;
		}
		$this->view->msg = $service->getMessageState();
	}
}
?>
