<?php
/**
 * Every object should be able to report his status
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package library.zfinterfaces
 */

interface ZFInterfaces_Messageable 
{
	/**
	 * Set an state
	 * @param string $msg The message token that you will send to this object, usually a translation key
	 */
	public function setMessageState($msg);
	
	/**
	 * Retrieve the state of this object
	 * @return string
	 */
	public function getMessageState();
}