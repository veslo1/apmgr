<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package library.ZFController
 * @subpackage Plugin
 * <p>On each request verify if the request is on the Docklet session.
 * When a match happens, wipe out that session possition.
 * </p>
 */

class ZFController_Plugin_Controller extends Zend_Controller_Plugin_Abstract {

	public function postDispatch(Zend_Controller_Request_Abstract $request) {
		//	In a modular application, the controller becames the action, keep this in mind
		$url = DIRECTORY_SEPARATOR.$request->getModuleName().DIRECTORY_SEPARATOR.$request->getControllerName().DIRECTORY_SEPARATOR.$request->getActionName();
		$docklet = new Zend_Session_Namespace('Docklet');
		if( is_array($docklet->icons) ) {
			foreach($docklet->icons as $id=>$value) {
				foreach($value as $index=>$urlsession) {
					if($index=='url' and $url==$urlsession) {
						unset($docklet->icons[$id]);
					}
				}
			}
		}
	}
}