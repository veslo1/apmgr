<?php
/**
 * Custom date validator for zend form to use with dates
 * @author jvazquez
 *
 */
class ZFForm_Datevalidate extends Zend_Validate_Abstract {

	/**
	 *
	 * @var Const
	 */
	const NOT_MATCH = 'notADate';

	/**
	 * @var array
	 */
	protected $_messageTemplates = array(self::NOT_MATCH => 'notvaliddate');

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Validate/Zend_Validate_Interface#isValid($value)
	 */
	public function isValid($value) {
		$valid = false;
		//	Date must come in SQL format
		try {
			if( empty($value) ) {
				$valid = false;
			} else {
				$value = date_parse($value);
				if(isset($value['error_count']) and $value['error_count']>=1 )
				{
					$valid = false;
				}
				else
				{
					$timestamp = mktime(null, null, null, $value['month'], $value['day'], $value['year']);
					Zend_Date::setOptions(array('format_type' => 'php'));
					$events = new Calendar_Model_Events();
					$props = $events->getProperties();
					$format = $props->date->sqlformat;
					$zdate = new Zend_Date();
					$zdate->setLocale(Zend_Registry::get('Zend_Locale'));
					$zdate->setTimestamp($timestamp);
					if( $zdate->isDate($zdate->toString($format), $format, Zend_Registry::get('Zend_Locale') ) ) {
						$valid = true;
					} else {
						$valid = false;
					}
				} 
				//                $valid = Zend_Date::isDate($value,$format,Zend_Registry::get('Zend_Locale'))? true:false;
			}
		} catch(Exception $e) {
			$this->_error(self::NOT_MATCH);
		} catch(Zend_Date_Exception $e) {
			$this->_error(self::NOT_MATCH);
		} catch (Zend_Locale_Exception $e) {
			$this->_error(self::NOT_MATCH);
		}

		return $valid;
	}

}