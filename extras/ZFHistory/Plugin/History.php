<?php
/**
 * Keep a record of the visitor's steps on our application
 * Push elements into the session stack and pop them out when we hit back
 */

class ZFHistory_Plugin_History extends Zend_Controller_Plugin_Abstract {

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Controller/Plugin/Zend_Controller_Plugin_Abstract#preDispatch($request)
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		//	The trace is the session object that holds the pages the user views
		$trace = new Zend_Session_Namespace('vazneyStorageTrace');
		//Yield the url
		$url = Zend_Controller_Front :: getInstance()->getBaseUrl() ? Zend_Controller_Front :: getInstance()->getBaseUrl() : "/";
		$url .= join("/",$this->getRequest()->getUserParams());
		//TODO can't work well with exceptions
		if( isset($trace->history) ) {
			$found = false;
			$backup = $trace->history;
			//	If we find it, then do not add it into the stack
			foreach($backup as $key=>$value) {
				if($value==$url) {
					$found = true;
					unset($backup[$key]);
					break;
				}
			}
			//	if it wasn't there , just add it
			if($found==false) {
				$trace->history[] = $url;
			} else {
				$trace->history = $backup;
			}
		} else {
			$trace->history = array();
			$trace->history[] = $url;
		}
	}

	/**
	 * When the user clicks just quickly determine if we have the special combination usingBack/yes in the query string
	 * @param string $url
	 */
	protected function cleanUpTrace(string $url){
	}
}