<?php
/**
 * Provide a back putton wherever possible
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Wulf_View_Helper_Back extends Zend_View_Helper_Abstract {
	public function back() {
		$translator = Zend_Registry::get('Zend_Translate');
		$img = "<a href='#'><img src='/images/24/arrow_left_green_48.gif' alt='".$translator->_('back')."' title='".$translator->_('back')."'/></a>";
		$trace = new Zend_Session_Namespace('vazneyStorageTrace');
		$lastPage = count($trace->history)-2;

		if( isset($trace->history[$lastPage]) ) {
			$img = str_replace('#',$trace->history[$lastPage],$img);
		}
		echo $img;
	}
}