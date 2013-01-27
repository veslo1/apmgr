<?php
/**
 * Created on Sep 12, 2009
 * loggedin.php
 * jvazquez
 * application.controllers.helpers.loggedin
 * <p>
 * Html plugin that determines if the user is logged in or not and shows the proper link
 * </p>
 */
class Wulf_View_Helper_Loggedin extends Zend_View_Helper_Abstract {

	/**
	 * This method returns two different kinds of html strings.If we are loged in,we route to logout,else to login
	 * @return string
	 */
	public function loggedIn() {
		$auth = Zend_Auth::getInstance();
		$translator = Zend_Registry::get('Zend_Translate');
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$loggedIn = $auth->getIdentity();
		if ( $loggedIn ) {
			return "<a class='inline' href='/user/login/logout'><img src='/images/onebit_23.png' alt='".$translator->_("logout")."' title='".$translator->_("logout")."'/></a>";
		} else {
			return "<a class='inline' href='/user/login'><img src='/images/onebit_24.png' alt='".$translator->_("login")."' title='".$translator->_("login")."'/></a>";
		}
	}
}
?>
