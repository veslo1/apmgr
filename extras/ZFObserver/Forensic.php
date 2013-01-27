<?php
/**
 * @package library.ZFOBserver
 * @author jvazquez
 *<p>
 *This class represents the implementation that all the controllers will carry on.
 *The observer of the objects will be notified when an action happens on the application.
 *Each observer has his own strategy for logging.
 *</p>
 */
class ZFObserver_Forensic implements ZFObserver_ILogeable {

	/**
	 * @var array obseverves Collection of observers.
	 */
	protected $observers;

	/**
	 * The status that we set
	 * @var int status
	 */
	protected $status;

	/**
	 * List of Zend valid logs_levels
	 * @var static $enumStatus
	 */
	public static $enumStatus = array(
		Zend_Log::EMERG =>'emerg',
		Zend_Log::ALERT =>'alert',
		Zend_Log::CRIT  =>'crit',
		Zend_Log::ERR	=>'err',
		Zend_Log::WARN	=>'warn',
		Zend_Log::NOTICE =>'notice',
		Zend_Log::INFO =>'info',
		Zend_Log::DEBUG =>'debug'
	);

	/**
	 * Initialize member variables
	 */
	public function __construct()
	{
		$this->observers = null;
	}
	/**
	 * Attach observers to this class.
	 * @param ZFObserver_ObserverController $obs
	 */
	public function attach(ZFObserver_ObserverController $obs)
	{
		$this->observers["$obs"] = $obs;
	}

	/**
	 * Detach observers from this object.
	 * @param ZFObserver_ObserverController $obs
	 */
	public function detach(ZFObserver_ObserverController $obs)
	{
		delete($this->observers["$obs"]);
	}

	/**
	 * Notify the observers of all the changes in this object, only if we have the proper setting.
	 * @param Zend_Controller_Action $caller Who calls the notify.
	 * @param string $message The message that you want to log.
	 */
	public function notify($caller, $message)
	{
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini',APPLICATION_ENV);
		$status    = $this->status;
		$envStatus = array_flip( self::$enumStatus );
		foreach ($this->observers as $obs)
		{
			if(  $envStatus[$config->appsettings->logs->level]<=$status )
			{
				$obs->update($caller, $message,$status);
			}
		}
	}

	/**
	 * Sets the state of this object.
	 * @param int $status
	 */
	public function setStatus($status)
	{
		$this->status = $status;
	}

	/**
	 * Returns the status of this object.
	 * @return int
	 */
	public function getStatus()
	{
		return $this->status;
	}

}