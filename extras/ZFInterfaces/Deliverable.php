<?php
/**
 * Interface that defines the behavior that the email senders may implement , allowing the use of
 * html emails or plain text emails
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package library.zfinterfaces
 */
interface ZFInterfaces_Deliverable
{
	/**
	 * Different types of encoding for emails
	 * @var string
	 */
	const UTF8='UTF-8';
	
	/**
	 * Constant that has the default email that we send emails on behalf of
	 * @var string
	 */
	const from='admins@vazney.com';
	
	/**
	 * We could configure the default from , right now is a constant
	 * @var string
	 */
	const name='Admin Vazney';
	
	/**
	 * Contains a constant that is used when we deliver emails using our site domain
	 * @var string
	 */
	const sitename='http://apmgr.com/';
	
	/**
	 * Receives a concrete object for delivering emails
	 * The implementation may choose to send via html or plain text
	 * @param array $args
	 * @return Zend_Mail
	 */
	public function build(array $args);
}