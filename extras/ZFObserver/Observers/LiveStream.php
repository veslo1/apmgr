<?php
/**
 * Direct implementation of the live stream logging purposes.
 * @author jvazquez
 *
 */
class ZFObserver_Observers_LiveStream implements ZFObserver_ObserverController {

	/**
	 * (non-PHPdoc)
	 * @see ZFObserver/ZFObserver_ObserverController#update($controller, $message)
	 */
	public function update($controller, $message,$level) {
		$logger = new Zend_Log();
		$writer = new Zend_Log_Writer_Stream('php://output');
		$logger->addWriter($writer);
		$logger->log($message, $level);
	}

	/**
	 * Our implementation of the magic method __toString.
	 * @return string
	 */
	public function __toString() {
		return "LiveStream";
	}
}