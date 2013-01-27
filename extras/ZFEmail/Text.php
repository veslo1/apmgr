<?php
/**
 * Html implementation of emails
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package library.email
 */
class ZFEmail_Text implements ZFInterfaces_Deliverable
{
	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Communication::build()
	 */
	public function build(array $args)
	{
		$email = new Zend_Mail();
		$email->setSubject($args['subject']);
		$email->setBodyText($args['body'], ZFInterfaces_Deliverable::UTF8);
		$email->setFrom($args['from'],$args['nameFrom']);
		$email->addTo($args['to'],$args['nameTo']);
		return $email;
	}
}