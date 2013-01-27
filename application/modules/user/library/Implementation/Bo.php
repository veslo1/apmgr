<?php
/**
 * Implementation of the Business Object logic for the user module
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @package application.modules.user.implementation
 */
class User_Library_Implementation_Bo implements User_Library_Interface_Bo,ZFInterfaces_Messageable
{
	/**
	 * Contains a set of valid columns that are used in this object
	 * @var array
	 */
	private $validColumns;

	/**
	 * Contains a string that is used wiht i18n to display a message state
	 * @var string
	 */
	private $msg;

	/**
	 * Access point to the DAO
	 * @var User_Library_Interface_Dao
	 */
	private $dao;

	/**
	 * Contains an agent to dispatch emails
	 * @var Zend_Mail_Transport_Abstract $emailAgent
	 */
	private $emailAgent;

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::save()
	 */
	public function save(array $args)
	{
		$saved = false;
		$param = array('search'=>array('username'=>$args['username']));
		$userList = $this->getDao()->findByKey($param);
		if( count($userList) > 0 )
		{
			$this->setMessageState('usernameExists');
		}
		else
		{
			try
			{
				$args['password'] = sha1($args['password']);
				$saved = $this->getDao()->save(new User_Model_User($args));
			}
			catch (Exception $e)
			{
				$this->setMessageState('unabletosaveuser');
			}
		}
		return $saved;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::update()
	 */
	public function update(array $args)
	{
		$updated = false;
		if( isset($args['id']) )
		{
			$args['password'] = sha1($args['password']);
			$updated = $this->getDao()->update(new User_Model_User($args));
		}
		else
		{
			$this->setMessageState('missingUserId');
		}
		return $updated;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::getCreateUserForm()
	 */
	public function getCreateUserForm()
	{
		$form = new User_Form_Create();
		$form->setForm();
		$form->clearElements();
		return $form;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::getUpdateUserForm()
	 */
	public function getUpdateUserForm(array $args)
	{
		$user = new User_Form_Create();
		$user->setUpdateMode(true);
		$utils = new User_Library_Helper_Utils();
		$isadmin = $utils->isRole('admin');
		$currentId = User_Library_Helper_Utils::currentUserId();
		$user->setForm();
		//	If we are not admin , then purge the roles. Only the admin should be able to perform role changes
		if($currentId===$args['id'] and $isadmin===false)
		{
			$user->removeElement('roleId');
		}
		unset($args['password']);
		$user->populate($args);
		return $user;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::setMessageState()
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::getMessageState()
	 */
	public function getMessageState()
	{
		return $this->msg;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::getDao()
	 */
	public function getDao()
	{
		return $this->dao;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::setDao()
	 */
	public function setDao(User_Library_Interface_Dao $dao)
	{
		$this->dao = $dao;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::delete()
	 */
	public function delete(array $data)
	{
		$deleted = false;
		if( !isset($data['id']) )
		{
			$this->setMessageState(array('msg'=>'missingUserId','type'=>'error'));
		}
		else if( !isset($data['confirm']) )
		{
			$this->setMessageState(array('msg'=>'missingConfirm','type'=>'error'));
		}
		else
		{
			$id = $data['id'];
			$confirm = $data['confirm'];
			$deleted = $this->getDao()->disable($id,$confirm);
			$this->setMessageState($this->getDao()->getMessageState());

		}
		return $deleted;
	}

	/**
	 * This method acts as a wrapper , allowing only the current user to view the proper information
	 * This rule is avoided if the current user is an admin
	 * @param int $id
	 */
	public function viewUserInformation($id)
	{
		$user = null;
		$utils = new User_Library_Helper_Utils();
		$isadmin = $utils->isRole('admin');
		$currentId = User_Library_Helper_Utils::currentUserId();
		if($isadmin==true or $id===$currentId)
		{
			$user = $this->getDao()->findById($id);
			if( !isset($user) )
			{
				$this->setMessageState('userNotFound');
			}
			else
			{
				$role = new Role_Model_Role();
				$roleName = $role->findById($user->getRoleId());
				$user = $user->toArray();
				$content = $this->getDao()->getDefinition();
				foreach($content as $id=>$key)
				{
					if(empty($user[$key]))
					{
						$user[$key] = 'n/a';
					}
				}
				$user['roleName'] = $roleName->getName();
			}
		}
		else
		{
			$this->setMessageState(array('msg'=>'accessRestricted','type'=>'error'));
		}
		return $user;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::viewAllUserInformation()
	 */
	public function viewAllUserInformation(array $options=null)
	{
		$userList = array();
		$sortHelper = new ZFDb_SortHelper($options);
		$sortHelper->setValidColumn($this->getDao()->getDefinition());
		if( $sortHelper->isSorting() )
		{
			$result = $this->getDao()->getTemplate()->fetchAll(null,$sortHelper->prepareOrderQuery());
		}
		else
		{
			$result = $this->getDao()->fetchAll();
		}

		if( count($result) > 0  )
		{
			$content = $this->getDao()->getDefinition();
			$role = new Role_Model_Role();
			foreach($result as $id=>$user)
			{
				$buffer = $user->toArray();
				foreach($content as $index=>$key)
				{
					if( empty($buffer[$key]))
					{
						$buffer[$key] = 'n/a';
					}
				}
				$roleName = $role->findById($buffer['roleId']);
				$buffer['roleName'] = $roleName->getName();
				$userList[] = $buffer;
				unset($buffer);
			}
		}
		else
		{
			$this->setMessageState('noUsersFound');
		}
		return $userList;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::updateUser()
	 */
	public function isValid(array $args)
	{
		$valid = false;
		if( isset($args['id']) )
		{
			$user = $this->getDao()->findById($args['id']);
			if($user!==null)
			{
				$valid = true;
			}
			else
			{
				$this->setMessageState('unknownuser');
			}
		}
		else
		{
			$this->setMessageState('userIdMissing');
		}
		return $valid;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::getDeleteUserForm()
	 */
	public function getDeleteUserForm()
	{
		$form = new User_Form_DeleteUser();
		$form->setForm();
		return $form;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Bo::recoverUserName()
	 */
	public function recoverUserName($email)
	{
		$recovered = false;
		if($email!==null)
		{
			$searchArgs = array('search'=>array('emailAddress'=>$email));
			$list = $this->getDao()->findByKey($searchArgs);
			if($list!=null)
			{
				$this->inspectResults($list);
				$recovered = true;
			}
			else
			{
				$this->setMessageState(array('msg'=>'noEmailFound' , 'type'=>'error'));
			}
		}
		else
		{
			$this->setMessageState(array('msg'=>'noEmailFound' , 'type'=>'error'));
		}
		return $recovered;
	}

	/**
	 * Forges the email retriever
	 * @param User_Model_User $user
	 * @return Zend_Mail
	 */
	public function forgeMail(User_Model_User $user)
	{
		$translate = Zend_Registry::get('Zend_Translate');
		$subject = $translate->_('userRecoverSubject');
		$body = str_replace('\n', '</br>', $translate->_('userRecoverEmailBody'));
		$args = array(
								'nameFrom'=>ZFInterfaces_Deliverable::name,
								'from'=>ZFInterfaces_Deliverable::from,
								'nameTo'=>$user->getFirstName().' '.$user->getLastName(),
								'to'=>$user->getEmailAddress(),
								'subject'=>$subject,
								'body'=>"Your username is ".$user->getUserName()
		);
		$email = new ZFEmail_Html();
		return $email->build($args);
	}

	/**
	 * Foreach of the list , prepare and deliver an email for each possible result on the list
	 * @param array $users
	 */
	public function inspectResults(array $users)
	{
		foreach($users as $id=>$user)
		{
			$this->getEmailAgent()->send($this->forgeMail($user));
		}
	}

	/**
	 * Retrieves the forgot username form
	 * @return User_Form_ForgotUserName
	 */
	public function getForgotUserNameForm()
	{
		$form = new User_Form_ForgotUserName();
		$form->setForm();
		return $form;
	}

	/**
	 * Setter for emailAgent
	 * @param Zend_Mail_Transport_Abstract $agent
	 */
	public function setEmailAgent(Zend_Mail_Transport_Abstract $agent)
	{
		$this->emailAgent = $agent;
	}

	/**
	 * Getter for emailAgent
	 * @return Zend_Mail_Transport_Abstract
	 */
	public function getEmailAgent()
	{
		return $this->emailAgent;
	}
}
?>