<?php
/**
 * Contains the Business Logic implementation for the Deactivate entity
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.library.implementation
 */
class User_Library_Implementation_DeactivateBo implements User_Library_Interface_DeactivateBo , ZFInterfaces_Messageable,ZFObserver_ILogeable
{
	/**
	 * @var ZFInterfaces_Dao $dao
	 */
	private $dao;

	/**
	 *
	 * Contains the token for the state
	 * @var string
	 */
	private $msg;

	/**
	 *
	 * Contains the UserDao implementation
	 * @var ZFInterface_Dao
	 */
	private $userDao;

	/**
	 * @var ZFObserver_Forensic
	 */
	private $log;

	/**
	 * 
	 * Used for logging
	 * @var string
	 */
	static $logname=__CLASS__;
	
	public function __construct()
	{
		$this->log = new ZFObserver_Forensic();
		$this->log->setStatus(ZFObserver_ILogeable::INFO);
		$this->log->attach(new ZFObserver_Observers_Text);
	}

	/**
	 *
	 * Sets the message state
	 * @param string $msg
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}

	/**
	 *
	 * Gets the message state
	 * @return string
	 */
	public function getMessageState()
	{
		return $this->msg;
	}

	/**
	 *
	 * Sets the dao that will be used to interact with the concrete implementation
	 * @param ZFInterfaces_Dao $dao
	 */
	public function setDao(ZFInterfaces_Dao $dao)
	{
		$this->dao = $dao;
	}

	/**
	 * Retrieve the dao implementation
	 * @return ZFInterfaces_Dao
	 */
	public function getDao()
	{
		return $this->dao;
	}

	/**
	 *
	 * Sets the concrete implementation of the UserDao
	 * @param ZFInterfaces_Dao $dao
	 */
	public function setUserDao(ZFInterfaces_Dao $dao)
	{
		$this->userDao = $dao;
	}

	/**
	 *
	 * Retrieves the userDao concrete object
	 * @return ZFInterfaces_Dao
	 */
	public function getUserDao()
	{
		return $this->userDao;
	}

	/**
	 *
	 * Validate the given records before hitting the entity
	 * @param array $args
	 * @return booleaan
	 */
	public function save(array $args)
	{
		$saved = false;
		if( $this->validateSave($args) == true )
		{
			$options = array('userId'=>$args['userId'],'description'=>$args['description'],'author'=>$args['author']);
			$saved = $this->getDao()->save(new User_Model_Deactivation($options));
			$this->log->notify(self::$logname, "We exit user deactivation with {$saved}");
		}
		return $saved;
	}

	/**
	 *
	 * Determines if the given id is a valid user
	 * @param int $target
	 */
	public function isValid($target)
	{
		return $this->getUserDao()->exists(array('table'=>'user','column'=>'id'), $target);
	}

	/**
	 * Validation rule applied to save
	 * @return boolean
	 */
	public function validateSave(array $args)
	{
		$validUser = false;
		$validAuthor = false;
		if( isset($args['userId']) )
		{
			$validUser = $this->isValid($args['userId']);
		}
		if($validUser===false)
		{
			$this->log->setStatus(ZFObserver_Forensic::ERR);
			$userid = isset ($args['userId']) ? $args['userId']:null;
			$this->log->notify(self::$logname, "The userId is missing or not valid.Received {$userid}");
			$this->log->setStatus(ZFObserver_Forensic::INFO);
			$this->setMessageState(array('msg'=>'userIdMissing','type'=>'error'));
			return false;
		}

		if( isset($args['author']) )
		{
			$validAuthor = $this->isValid($args['author']);
		}

		if($validAuthor===false)
		{
			$this->log->setStatus(ZFObserver_ILogeable::CRIT);
			$this->log->notify("DeactivateBusinessObject", "Unexpected behavior.A user that is not authenticated is trying to deacivate an account");
			$this->log->notify("DeactivateBusinessObject", "Affected account that was about to be deleted{$args['userId']}");
			$this->log->setStatus(ZFObserver_ILogeable::INFO);
			$this->setMessageState(array('msg'=>'missingUserId','type'=>'error'));
			return false;
		}

		if( !isset($args['description']) )
		{
			$this->log->setStatus(ZFObserver_Forensic::ERR);
			$this->log->notify(self::$logname, "The description is not valid , received.Received {$args['description']}");
			$this->log->setStatus(ZFObserver_Forensic::INFO);
			$this->setMessageState(array('msg'=>'missingdisableEnableDescription','type'=>'error'));
		}
		$valid = $validAuthor===true and $validUser===true?true:false;
		$this->log->notify(self::$logname, "We leave the validation with {$valid}");
		return $valid;
	}
}