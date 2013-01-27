<?php
/**
 * Description of Comparetimevalidate
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
class ZFForm_Comparetimevalidate extends Zend_Validate_Abstract {
	/**
	 * @var Const
	 */
	const NOT_MATCH = 'notvalidtimerange';

	/**
	 * @var array
	 */
	protected $_messageTemplates = array(self::NOT_MATCH => 'notvalidtimerange');

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Validate/Zend_Validate_Interface#isValid($value)
	 */
	public function isValid($timeTo,$timeFrom=null) {
		$valid = false;
		$timeTo = date_parse($timeTo);
		$timeFrom = date_parse($timeFrom['startTime']);


		//  Just compare the timestamps
		$tf = mktime($timeTo['hour'], $timeTo['minute'], $timeTo['second']);

		$tt = mktime($timeFrom['hour'], $timeFrom['minute'], $timeFrom['second']);

		if($tt>$tf) {
			$valid = false;
			$this->_error(self::NOT_MATCH);
		} else {
			$valid = true;
		}


		return $valid;
	}

}
?>