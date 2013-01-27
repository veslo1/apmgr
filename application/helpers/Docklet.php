<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Reads the session, and pulls the minimized applications that the user has</p>
 */

class Wulf_View_Helper_Docklet extends Zend_View_Helper_Abstract {

	/**
	 * The default action name that we follow
	 * @var string
	 */
	static $ACTION ='minimize';
	/**
	 * The default image if we don't have one
	 * @var string
	 */
	static $IMAGE = '/images/24/golden_offer.gif';

	public function docklet() {
		$translator = Zend_Registry::get('Zend_Translate');
		$docklet = new Zend_Session_Namespace('Docklet');
		if( is_array($docklet->icons) ) {
			$pieces = array();
			foreach($docklet as $id=>$info) {
				foreach($info as $icon=>$url) {
					$image = strlen($url['image'])==0 ? self::$IMAGE:$url['image'];
					$pieces = preg_split('/\//',$url['url'],0,PREG_SPLIT_NO_EMPTY);
					echo '<a href="'.$url['url'].'"><img src="'.$image.'" title="'.$translator->_($pieces[1]).'" alt="'.$translator->_($pieces[1]).'"></a>';
				}
			}
		}
	}
}