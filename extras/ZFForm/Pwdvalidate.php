<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Custom validator for password checking in zend forms.
 * This takes care of that validation process , it compares two fields and shows
 * a error message if both passwords aren't the same</p>
 */

class ZFForm_Pwdvalidate extends Zend_Validate_Abstract {

	const NOT_MATCH = 'notMatch';

	protected $_messageTemplates = array(self::NOT_MATCH => 'notmatch');

	/**
	 * @return boolean
	 */
	public function isValid($value, $context = null) {
		$value = (string) $value;
		$this->_setValue($value);

		if ( is_array($context) ) {
			//  This is the name of the field in the form that will validate against the password
			if ( isset($context['checkpassword']) && ($value == $context['checkpassword']) ) {
				return true;
			}
		} elseif (is_string($context) && ($value == $context)) {
			return true;
		}
		$this->_error(self::NOT_MATCH);
		return false;
	}
}
?>
