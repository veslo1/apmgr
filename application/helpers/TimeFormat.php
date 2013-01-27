<?php
/**
 * Format time strings
 *
 * @author jvazquez
 */
class Wulf_View_Helper_TimeFormat extends Zend_View_Helper_Abstract {

	/**
	 * The time to format
	 * @param string $time
	 */
	public function timeFormat($time) {
		$parsedDate = date_parse($time);
		$timestamp = mktime($parsedDate['hour'], $parsedDate['minute'], $parsedDate['second']);
		Zend_Date::setOptions(array('format_type' => 'php'));
		$zdate = new Zend_Date();
		$zdate->setTimestamp($timestamp);
		$props = new Zend_Config_Ini(APPLICATION_PATH.'/helpers/formats.ini',APPLICATION_ENV);
		return $zdate->toString($props->time->format->view);
	}
}
?>
