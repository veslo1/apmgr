<?php
/**
 * Direct implementation of the Db logging.
 * @author jvazquez
 *
 */
class ZFObserver_Observers_Db implements ZFObserver_ObserverController
{

	/**
	 * (non-PHPdoc)
	 * @see ZFObserver/ZFObserver_ObserverController#update($controller, $message)
	 */
	public function update($controller, $message,$level)
	{
		$db = Zend_Registry::get('db');
		$columnMapping = array('message'=>'message','priorityLevel'=>'priority','priorityName'=>'priorityName');
		$writer = new Zend_Log_Writer_Db($db, 'logs', $columnMapping);
		$logger = new Zend_Log($writer);
		$logger->setEventItem('priorityLevel', $level);
		$logger->info($message);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return "ZFObserver_Observers_Db";
	}
}