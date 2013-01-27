<?php
/**
 * Model implementation for the Recover DAO
 * @author <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.models
 */
class User_Model_Recover extends ZFModel_ParentModel
{
	/**
	 * @var string $hashToken
	 */
	protected $hashToken;

	/**
	 * @var string $receiver
	 */
	protected $receiver;

	/**
	 * @var date $expiricyDate
	 */
	protected $expiricyDate;

	/**
	 * @var int $attempts
	 */
	protected $attempts;

	/**
	 * @var boolean $disabled
	 */
	protected $disabled;

	public function __construct(array $options=null)
	{
		parent::__construct($options);
		$this->setDbTable('User_Model_DbTable_Recover');
	}

	/**
	 * Set hashToken
	 * @param string $hashToken
	 */
	public function setHashToken($hashToken)
	{
		$this->hashToken=$hashToken;
		return $this;
	}

	/**
	 * Get hashToken
	 * @return string
	 */
	public function getHashToken()
	{
		return $this->hashToken;
	}

	/**
	 * Set receiver
	 * @param string $receiver
	 */
	public function setReceiver($receiver)
	{
		$this->receiver=$receiver;
		return $this;
	}

	/**
	 * Get receiver
	 * @return string
	 */
	public function getReceiver()
	{
		return $this->receiver;
	}

	/**
	 * Set expiricyDate
	 * @param date $expiricyDate
	 */
	public function setExpiricyDate($expiricyDate)
	{
		$this->expiricyDate=$expiricyDate;
		return $this;
	}

	/**
	 * Get expiricyDate
	 * @return string
	 */
	public function getExpiricyDate()
	{
		return $this->expiricyDate;
	}

	/**
	 * Set attempts
	 * @param int $attempts
	 */
	public function setAttempts($attempts)
	{
		$this->attempts=$attempts;
		return $this;
	}

	/**
	 * Get attempts
	 * @return int
	 */
	public function getAttempts()
	{
		return $this->attempts;
	}

	/**
	 * Set disabled
	 * @param boolean $disabled
	 */
	public function setDisabled($disabled)
	{
		$this->disabled=$disabled;
		return $this;
	}

	/**
	 * Get disabled
	 * @return boolean
	 */
	public function getDisabled()
	{
		return $this->disabled;
	}
}
