<?php
/**
 * Helper to translate texts in the views
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Wulf_View_Helper_Translator extends Zend_View_Helper_Abstract {

	/**
	 *
	 * @param string $text
	 * @return string
	 */
	public function translator($text) {
		$translated = '';
		if( strlen($text)>0 ) {
			$translator = Zend_Registry::get('Zend_Translate');
			$translated = $translator->_($text);
		}
		return $translated;
	}
}