<?php
/**
 * Validation for times in forms
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */

class ZFForm_Timevalidate extends Zend_Validate_Abstract {
	/**
	 *
	 * @var Const
	 */
	const NOT_MATCH = 'notTime';

	/**
	 * @var array
	 */
	protected $_messageTemplates = array(self::NOT_MATCH => 'notvalidtime');

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Validate/Zend_Validate_Interface#isValid($value)
	 */
	public function isValid($value) {
		$valid = false;
		try {
			if(!empty($value) ) {
				$time = date_parse($value);
				Zend_Date::setOptions(array('format_type' => 'php'));
				$events = new Calendar_Model_Events();
				//  Retrieve the properties and fetch the time separator and the format that we handle with dates
				$props = $events->getProperties();
				$ts = $props->time->separator;
				$format = $props->time->format;
				$time = $time['hour'].$ts.$time['minute'].$ts.$time['second'];
				$valid = Zend_Date::isDate($time,$format,Zend_Registry::get('Zend_Locale'));

				if($valid==false) {
					$this->_error(self::NOT_MATCH);
				} else {
					$valid = true;
				}
			} else {
				//  Just flag it as ok
				$valid = true;
			}
		} catch(Zend_Date_Exception $e) {
			$this->_error(self::NOT_MATCH);
			$valid = false;
		}
		return $valid;
	}
}
?>