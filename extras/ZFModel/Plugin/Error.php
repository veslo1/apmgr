<?php
/**
 * Created on Oct 4, 2009 by jvazquez
 * @name debserver
 * @package library.ZFModel
 * <p>
 * Theoritecally we need to inform the current module of our <strong>own</strong> error controller and avoid using the default.
 * Since the research of errors is not in our schedule I'm leaving this here.
 * </p>
 */

class ZFModel_Plugin_Error  extends Zend_Controller_Plugin_Abstract {

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Controller/Plugin/Zend_Controller_Plugin_Abstract#routeShutdown($request)
	 */
	public function routeShutdown( Zend_Controller_Request_Abstract $request ) {
		$front = Zend_Controller_Front::getInstance();

		//If the ErrorHandler plugin is not registered, bail out
		if( !($front->getPlugin('Zend_Controller_Plugin_ErrorHandler') instanceOf Zend_Controller_Plugin_ErrorHandler) )
		return;

		$error = $front->getPlugin('Zend_Controller_Plugin_ErrorHandler');

		//Generate a test request to use to determine if the error controller in our module exists
		$testRequest = new Zend_Controller_Request_HTTP();
		$testRequest->setModuleName($request->getModuleName())
		->setControllerName($error->getErrorHandlerController())
		->setActionName($error->getErrorHandlerAction());

		//Does the controller even exist?
		if( $front->getDispatcher()->isDispatchable($testRequest) ) {
			$error->setErrorHandlerModule($request->getModuleName() );
		}
	}
}
?>