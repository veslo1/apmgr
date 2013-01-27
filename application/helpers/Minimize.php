<?php
/**
 *@author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *<p>
 *Helper class to minimize the page that you are seeing.
 *This helper will store in session (for persistance across different pages) the page that you were seeing.
 *Once it's reopened, it should wipe that entry, cleaning that entry from the docklet
 *</p>
 */
class Wulf_View_Helper_Minimize extends Zend_View_Helper_Abstract {

	/**
	 * The default action name that we follow
	 * @var string
	 */
	static $ACTION ='minimize';

	public function minimize($referrer) {
		$baseurl = Zend_Controller_Front::getInstance()->getBaseUrl() ? Zend_Controller_Front::getInstance()->getBaseUrl() : "/";
		$module = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
		$controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$url = $baseurl.$module."/".$controller."/".self::$ACTION."/referrer/$referrer";
		$translator = Zend_Registry::get('Zend_Translate');
		return '<a href="'.$url.'"><img src="/images/dashboard/onebit_32.gif" title="'.$translator->_('minimize').'" alt="'.$translator->_('minimize').'"></a>';
	}
}