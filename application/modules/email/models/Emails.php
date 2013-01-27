<?php
/**
 *
 * @author <jvazquez@debserverp4.com.ar>
 */
class Email_Model_Emails extends ZFModel_ParentModel {

	/**
	 * @var int $sender
	 */
	protected $sender;

	/**
	 * @var int $receiver
	 */
	protected $receiver;

	/**
	 * @var string $body
	 */
	protected $body;

	/**
	 * Persist email sent
	 * @param array $options
	 */
	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Email_Model_DbTable_Email');
	}

	/**
	 * Set sender
	 * @param int $sender
	 * @return
	 */
	public function setSender($sender) {
		$this->sender=$sender;
		return $this;
	}

	/**
	 * Get sender
	 */
	public function getSender() {
		return $this->sender;
	}

	/**
	 * Set receiver
	 */
	public function setReceiver($receiver) {
		$this->receiver=$receiver;
		return $this;
	}

	/**
	 * Get receiver
	 */
	public function getReceiver() {
		return $this->receiver;
	}

	/**
	 * Set body
	 */
	public function setBody($body) {
		$this->body=$body;
		return $this;
	}

	/**
	 * Get body
	 */
	public function getBody() {
		return $this->body;
	}
}
