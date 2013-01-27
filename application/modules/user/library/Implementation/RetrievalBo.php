<?php
/**
 * Concrete implementation for password retrieval
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.user.library.implementation
 */
class User_Library_Implementation_RetrievalBo implements User_Library_Interface_RetrievalBo , ZFInterfaces_Messageable,ZFObserver_ILogeable
{

	/**
	 * Contains the unique token that is sent to the user when he retrieves his password
	 * @var string
	 */
	private $token;

	/**
	 *
	 * Sets the communication with the persistance engine
	 * @var User_Library_Interface_Dao
	 */
	private $dao;

	/**
	 *
	 * Contains the user dao object to aid this implementation
	 * @var User_Library_Implementation_Bo
	 */
	private $userDao;

	/**
	 * Contains an agent to dispatch emails
	 * @var Zend_Mail_Transport_Abstract $emailAgent
	 */
	private $emailAgent;

	/**
	 *
	 * Contains the state after an operation , to be retrieved by the caller
	 * @var array
	 */
	private $msg;

	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_RetrievalBo::insert()
	 */
	public function insert(array $args)
	{
		$inserted = false;
		if($args!=null)
		{
			$retrieval = new User_Model_Recover($args);
			$inserted = $this->getDao()->save($retrieval);
		}
		return $inserted;
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_RetrievalBo::update()
	 */
	public function update(array $args)
	{
		$updated = false;
		if($args!=null)
		{
			$retrieval = new User_Model_Recover($args);
			$inserted = $this->getDao()->update($retrieval);
		}
		return $inserted;
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_RetrievalBo::findById()
	 */
	public function findById($id)
	{
		return $this->getDao()->findById($id);
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_RetrievalBo::delete()
	 */
	public function delete($id)
	{
		$deleted = $this->getDao()->delete($id);
		return $deleted;
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_RetrievalBo::setDao()
	 */
	public function setDao(User_Library_Interface_RetrieveDao $dao)
	{
		$this->dao = $dao;
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_RetrievalBo::getDao()
	 */
	public function getDao()
	{
		return $this->dao;
	}

	/**
	 * Contains a date that represents the maximum date that a password retrieval value is valid
	 * @var Zend_Date
	 */
	private $dateForRetrieval;

	/**
	 * Sets the unique token that represents a user
	 * @param string $token
	 */
	public function setToken($token)
	{
		$this->token = $token;
	}

	/**
	 * Gets the unique token
	 * @return string token
	 */
	public function getToken()
	{
		return $this->token;
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

	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_RetrievalBo::recoverPassword()
	 */
	public function recoverPassword(array $args)
	{
		$recovered = false;
		if( !isset($args['username']) )
		{
			$this->setMessageState(array('msg'=>'missingUsername','type'=>'error'));
			return $recovered;
		}

		if( !isset($args['emailAddress']) )
		{
			$this->setMessageState(array('msg'=>'missingEmail','type'=>'error'));
			return $recovered;
		}
		$search = array('username'=>$args['username'],'emailAddress'=>$args['emailAddress']);

		$user = $this->getUserDao()->findByKey(array('search'=>$search));
		if( $user!==null )
		{
			$user = array_shift($user);
			$mail = $this->yieldForgotPasswordEmail($user);
			$date = $this->dateForRetrieval->toString('Y-m-d');
			$args = array('hashToken'=>$this->getToken(),'receiver'=>$user->getEmailAddress(),'expiricyDate'=>$date,'attempts'=>0,'disabled'=>0);
			$recovered = $this->getDao()->save(new User_Model_Recover($args));
			if($recovered==true)
			{
				$this->getEmailAgent()->send($mail);
				$this->setMessageState(array('msg'=>'instructionsSent','type'=>'success'));
			}
		}
		else
		{
			$this->setMessageState(array('msg'=>'invalidCredentials','type'=>'error'));
		}
		return $recovered;
	}

	/**
	 * This method will receive a user , and will proceed to deal with the business logic that
	 * handles the retrieve password implementation
	 * @param User_Model_User $user
	 */
	public function yieldForgotPasswordEmail(User_Model_User $user)
	{
		$translate = Zend_Registry::get('Zend_Translate');
		$subject = $translate->_('passwordRecoverSubject');
		$body = str_replace('\\n', '<br/>', $translate->_('passwordRecoverBody'));
		$token = $this->generateUniqueToken();
		$body .= ZFInterfaces_Deliverable::sitename.'user/resetpassword/token/'.$token;
		$body .="<br/>".str_replace('\\n','<br/>',$translate->_('passwordRecoverBodyEndDate'));
		$this->setDateForRetrieval();
		$body .="{$this->dateForRetrieval->toString('m-d-Y')}<br/>";

		$args = array(
						'nameFrom'=>ZFInterfaces_Deliverable::name,
						'from'=>ZFInterfaces_Deliverable::from,
						'nameTo'=>$user->getFirstName().' '.$user->getLastName(),
						'to'=>$user->getEmailAddress(),
						'subject'=>$subject,
						'body'=>$body
		);

		$email = new ZFEmail_Html();
		//	For retrieval later
		$this->setToken($token);

		return $email->build($args);
	}

	/**
	 * Generates a random string that is used in the password retrieval site
	 * @return string
	 */
	public function generateUniqueToken()
	{
		//	We generate a random string
		$seed = '';
		for ($i=0; $i<6; $i++)
		{
			$d=rand(1,30)%2;
			$seed .=$d ? chr(rand(65,90)) : chr(rand(48,57));
		}
		//	And generate the SHA1 string
		return sha1($seed);
	}

	/**
	 *
	 * Sets the date that will be used to recover the last day a record is valid on the persistance engine
	 * @throws Exception
	 */
	public function setDateForRetrieval()
	{
		$settings = new Settings_Model_Settings();
		$setting = $settings->findByKey(array('search'=>array('name'=>'maxDatePassword')));
		if($setting==null)
		{
			throw new Exception('system is not properly set up');
		}
		$increment = array_shift($setting)->getValue();
		Zend_Date::setOptions(array('format_type' => 'php'));
		$date = new Zend_Date();
		$this->dateForRetrieval = $date->add(3,Zend_Date::DAY);
	}

	/**
	 * Retrieves the form to look up passwords
	 * @return User_Form_ForgotPassword
	 */
	public function getForgotPasswordForm()
	{
		$form = new User_Form_ForgotPassword();
		$form->setForm();
		return $form;
	}

	/**
	 *
	 * Inject the dependency
	 * @param User_Library_Interface_Dao $userDao
	 */
	public function setUserDao(User_Library_Interface_Dao $userDao)
	{
		$this->userDao = $userDao;
	}

	/**
	 *
	 * Retrieves the User Dao Helper
	 * @return User_Library_Interface_Dao
	 */
	public function getUserDao()
	{
		return $this->userDao;
	}

	/**
	 * Method to look up the token against the persistance engine
	 * @param string $token
	 * @return boolean
	 */
	public function verifyToken($token)
	{
		$exists = false;
		if( isset($token) and strlen($token)==40 )
		{
			//TODO Implement the ZFModel_ParentModel::exists solution at DbTable level
			$token = $this->getDao()->findByKey(array('search'=>array('hashToken'=>$token)));
			if(null!==$token)
			{
				$record = array_shift($token);
				$isDisabled = $record->getDisabled();
				if($isDisabled==1)
				{
					$this->setMessageState(array('msg'=>'tokenNotLongerValid','type'=>'error'));
				}
				else
				{
					$exists = true;
				}
			}
		}
		else
		{
			$this->setMessageState(array('msg'=>'missingToken','type'=>'error'));
		}
		return $exists;
	}

	/**
	 * Retrieves the reset password form
	 * @return ZFForm_ParentForm
	 */
	public function getResetPasswordForm()
	{
		$form = new User_Form_ResetPassword();
		$form->setForm();
		return $form;
	}

	/**
	 * Deals with the password reset functionality
	 * @param $args
	 * @return boolean
	 */
	public function resetPassword(array $args)
	{
		$reseted = false;
		if( isset($args['hashToken']) )
		{
			if( $this->verifyToken($args['hashToken'])==true )
			{
				$recoverMod = $this->getDao()->findByKey(array('search'=>array('hashToken'=>$args['hashToken'])));
				if($recoverMod!==null)
				{
					$password = sha1($args['password']);
					$recoverMod = array_shift($recoverMod);
					$usermodel = $this->getUserDao()->findByKey(array('search'=>array('emailAddress'=>$recoverMod->getReceiver() ) ) );
					if($usermodel!==null)
					{
						foreach($usermodel as $id=>$user)
						{
							$user->setPassword($password);
							$usermodel[$id] = $user;
						}
						$reseted = $this->getUserDao()->saveCollection($usermodel);
					}
				}
			}
			else
			{
				$this->setMessageState(array('msg'=>'tokenNotLongerValid','type'=>'error'));
			}
		}
		else
		{
			$this->setMessageState(array('msg'=>'missingToken','type'=>'error'));
		}
		return $reseted;
	}

	/**
	 * After reseting a password , wipe out the record
	 * @param string $token
	 * @return boolean
	 */
	public function disableToken($token)
	{
		$disabled = false;
		$retrieve = $this->getDao()->findByKey(array('search'=>array('hashToken'=>$token)));
		if($retrieve!==null)
		{
			$record = array_shift($retrieve);
			$record->setDisabled(1);
			$disabled = $this->getDao()->update($record);
			if( $disabled==false )
			{
				$log = new ZFObserver_Forensic();
				$log->setStatus(ZFObserver_ILogeable::ALERT);
				$log->attach(new ZFObserver_Observers_Text());
				$log->notify($this,"Unable to mark the hash {$token} as disabled. Please , log it as disabled");
			}
		}
		return $disabled;
	}

	/**
	 * Retrieves a string
	 * @return string
	 */
	public function __toString()
	{
		return "RetrievalBo";
	}
}