<?php
/**
 * Update controller for the user module.
 * Handles the update actions for the user.
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.controllers
 * TODO Remvoe changepwd and changerole here , and in the ACL
 */

class User_UpdateController extends ZFController_Controller
{
	/**
	 * Update action for the user
	 * @return Zend_View
	 */
	public function indexAction()
	{
		$bo = new User_Library_Implementation_Bo();
		$bo->setDao(new User_Library_Implementation_Dao());
		$params = $this->getRequest()->getParams();
		$this->view->id = $params['id'];
		if($bo->isValid($params))
		{
			$form = $bo->getUpdateUserForm($bo->getDao()->findById($params['id'])->toArray());
			if( $this->getRequest()->isPost() and $form->isValid( $this->getRequest()->getParams() ) )
			{
				if( $bo->update($this->getRequest()->getParams()) )
				{
					$this->setFlashMessage(array('msg'=>'userUpdated','type'=>'success'));
					$helper = new User_Library_Helper_Utils();
					if ( $helper->isRole('admin') )
					{
						$this->_helper->redirector('index', 'view', 'user');
					}
					else
					{
						$this->_helper->redirector('index', 'index', 'user');
					}
				}
			}
			$this->view->form = $form;
		}
		$this->view->msg = $bo->getMessageState();
	}

	/**
	 * 
	 * Deletes a user. If the action works properly , it will just update his record
	 * and mark it as `deleted`
	 */
	public function deleteAction()
	{
		$bo = new User_Library_Implementation_Bo();
		$dao = new User_Library_Implementation_Dao();
		$bo->setDao($dao);
		if( $bo->isValid($this->getRequest()->getParams()) == true  )
		{
			$form = $bo->getDeleteUserForm();
			$data = $this->getRequest()->getParams();
			if( $this->getRequest()->isPost() and $form->isValid($data) )
			{
				$data['confirm'] = $this->getRequest()->getParam('confirm');
				$data['description'] = $this->getRequest()->getParam('description');
				if ( $bo->delete($data) !== false )
				{
					$this->log->setStatus(ZFObserver_Forensic::DEBUG);
					$this->log->notify(__CLASS__,"The delete operation succeded , performing the save in Deactivate");
					$deactivate = new User_Library_Implementation_DeactivateBo();
					$deactivate->setDao(new User_Library_Implementation_DeactivateDao());
					$deactivate->setUserDao($dao);
					$deactivate->save(array('author'=>ZFUtil_Utils::currentUserId(),'userId'=>$data['id'],'description'=>$data['description']));
					$this->setMessageState(array('msg'=>'userDeleted','type'=>'success'));
					$this->_helper->redirector('index', 'view', 'user');
				}
			}
			$this->view->form = $form;
		}
		$this->view->msg = $bo->getMessageState();
				
	}
	
}
?>