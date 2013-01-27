<?php
/**
 * Created on Oct 20, 2009 by jvazquez
 * @package wulf.library.ZFObserver
 * <p>
 * This interface defines the functionality to log all the messages from the Controllers.
 * @link http://devzone.zend.com/node/view/id/6 Implementation of the Observer pattern.
 * This interface defines the common functionality that all controller will implement.
 * </p>
 */

interface ZFObserver_ObserverController {
	/**
	 * The update action will take place only if we know what kind of level to log in the application.
	 * @example I set up the log level to debug, all the actions that are inside debug will be looged.Any other action won't be sent to the object
	 * @param controller The controller that notifies his observer about the change that is being done.
	 * @param string message A message that the observed class sends to his observer.
	 * @param Zend_Log $level
	 */
	public function update($controller, $message,$level) ;
}
?>