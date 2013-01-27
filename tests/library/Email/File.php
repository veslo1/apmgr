<?php
/**
 * @see Zend_Mail_Transport_Abstract
 */
require_once 'Zend/Mail/Transport/Abstract.php';

/**
 * This class was developed to trap and read emails through PHPUNIT
 */
class Email_File extends Zend_Mail_Transport_Abstract
{
	/**
	 * Subject
	 * @var string
	 * @access public
	 */
	public $subject = null;

	/**
	 * Config options for file path
	 *
	 * @var string
	 */
	public $file;

	/**
	 * EOL character string
	 * @var string
	 * @access public
	 */
	public $EOL = PHP_EOL;

	/**
	 * Setter for the sender
	 * @var string
	 */
	private $sender;
	
	/**
	 * Sets the receiver of this email
	 * @var string
	 */
	private $receiver;
	
	/**
	 * Constructor.
	 *
	 * @param  string $file
	 * @return void
	 */
	public function __construct($filePath)
	{
		$this->file = $filePath;
	}

	/**
	 * Sets the sender
	 * @param string $sender
	 */
	public function setSender($sender)
	{
		$this->sender = $sender;
	}
	
	/**
	 * Retrieves the sender
	 * @return string
	 */
	public function getSender()
	{
		return $this->sender;
	}
	
	/**
	 * Set's the receiver
	 * @param string $receiver
	 */
	public function setReceiver($receiver)
	{
		$this->receiver = $receiver;
	}
	
	/**
	 * Retrieve the receiver
	 * @return string
	 */
	public function getReceiver()
	{
		return $this->receiver;
	}
	
	/**
	 * Send mail using file
	 *
	 * First line "FROM" is necessary to read email through zend mailbox.
	 * Use message id=1 for fast access.
	 *
	 * @access public
	 * @return void
	 * @throws Zend_Mail_Transport_Exception on mail() failure
	 */
	public function _sendMail()
	{
		$email = "From {$this->sender}  Mon Jan 00 00:00:00 0000".$this->EOL.
"Return-Path: ".$this->EOL.
"Delivered-To: {$this->receiver}".$this->EOL.
"Received: by {$this->receiver}".$this->EOL.
"        id 1; Fri, 22 Oct 2010 15:43:03 +0300 (EEST)".$this->EOL.
"To: {$this->receiver}".$this->EOL.
"Subject: {$this->_mail->getSubject()}".$this->EOL.
		$this->header.$this->EOL.
"Message-Id: <20101028151045.06A7A5F735@example.com>".$this->EOL.
		$this->EOL . quoted_printable_decode($this->body) . $this->EOL;

		$file = @fopen($this->file, 'w');//open file for writing, try to create, truncate
		if (!$file)
		{
			throw new Zend_Mail_Transport_Exception('Unable to open file: '.$file);
		}
		fwrite($file, $email);
		fclose($file);
	}

	/**
	 * Format and fix headers
	 *
	 * mail() uses its $to and $subject arguments to set the To: and Subject:
	 * headers, respectively. This method strips those out as a sanity check to
	 * prevent duplicate header entries.
	 *
	 * @access  protected
	 * @param   array $headers
	 * @return  void
	 * @throws  Zend_Mail_Transport_Exception
	 */
	protected function _prepareHeaders($headers)
	{
		if (!$this->_mail)
		{
			/**
			 * @see Zend_Mail_Transport_Exception
			 */
			require_once 'Zend/Mail/Transport/Exception.php';
			throw new Zend_Mail_Transport_Exception('_prepareHeaders requires a registered Zend_Mail object');
		}

		// mail() uses its $to parameter to set the To: header, and the $subject
		// parameter to set the Subject: header. We need to strip them out.
		if (0 === strpos(PHP_OS, 'WIN'))
		{
			// If the current recipients list is empty, throw an error
			if (empty($this->recipients))
			{
				/**
				 * @see Zend_Mail_Transport_Exception
				 */
				require_once 'Zend/Mail/Transport/Exception.php';
				throw new Zend_Mail_Transport_Exception('Missing To addresses');
			}
		}
		else
		{
			// All others, simply grab the recipients and unset the To: header
			if (!isset($headers['To']))
			{
				/**
				 * @see Zend_Mail_Transport_Exception
				 */
				require_once 'Zend/Mail/Transport/Exception.php';
				throw new Zend_Mail_Transport_Exception('Missing To header');
			}

			unset($headers['To']['append']);
			$this->recipients = implode(',', $headers['To']);
		}

		// Remove recipient header
		unset($headers['To']);

		// Remove subject header, if present
		if (isset($headers['Subject']))
		{
			unset($headers['Subject']);
		}

		// Prepare headers
		parent::_prepareHeaders($headers);

		// Fix issue with empty blank line ontop when using Sendmail Trnasport
		$this->header = rtrim($this->header);
	}
}