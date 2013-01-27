<?php
/**
 * Implementation of Zend_Email
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package library.ZFEmail
 */
class ZFEMail_Context extends  Zend_Mail_Transport_Abstract
{
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
	 * (non-PHPdoc)
	 * @see Zend/Mail/Transport/Zend_Mail_Transport_Abstract::_sendMail()
	 */
	public function _sendMail()
	{
		$email = "From next-message@example.com  Mon Jan 00 00:00:00 0000".$this->EOL.
		"Return-Path: ".$this->EOL.
		"Delivered-To: ".implode(' ', $this->_mail->getRecipients()).$this->EOL.
		"Received: by example.com".$this->EOL.
		"        id 1; Fri, 22 Oct 2010 15:43:03 +0300 (EEST)".$this->EOL.
		"To: to@example.com".$this->EOL.
		"Subject: {$this->_mail->getSubject()}".$this->EOL.
			$this->header.$this->EOL.
		"Message-Id: <20101028151045.06A7A5F735@example.com>".$this->EOL.
		$this->EOL . quoted_printable_decode($this->body) . $this->EOL;

		$file = @fopen($this->file, 'w');//open file for writing, try to create, truncate
		if (!$file) {
			throw new Zend_Mail_Transport_Exception('Unable to open file: '.$file);
		}
		fwrite($file, $email);
		fclose($file);
	}
}