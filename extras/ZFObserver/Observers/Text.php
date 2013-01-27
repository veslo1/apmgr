<?php
/**
 * Direct implementation of the Text logging.
 * @author jvazquez
 *
 */
class ZFObserver_Observers_Text implements ZFObserver_ObserverController {

	/**
	 * (non-PHPdoc)
	 * @see ZFObserver/ZFObserver_ObserverController#update($controller, $message)
	 */
	public function update($controller, $message,$logLevel) {
		$logger = new Zend_Log();
		$filename = '';
		if( is_object($controller) )
		{
			$filename = APPLICATION_LOGS.DIRECTORY_SEPARATOR.'NotNamedLog';
		}
		else
		{
			$filename = APPLICATION_LOGS.DIRECTORY_SEPARATOR.$controller;
		}		
		$writer = new Zend_Log_Writer_Stream($filename.'_'.date('Ymd').'.log');
		$logger->addWriter($writer);
		$logger->log($message, $logLevel);
	}

	/**
	 * Our implementation of the magic method __toString.
	 * @return string
	 */
	public function __toString() {
		return "Text";
	}
}