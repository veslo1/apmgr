<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class ZFForm_Petvalidator extends Zend_Validate_Abstract {

	const NO_DESCRIPTION = 'noDescriptionForPets';
	/**
	 * @var array
	 */
	protected $_messageTemplates = array(self::NO_DESCRIPTION => 'noDescriptionForPets');
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Validate/Zend_Validate_Interface#isValid($value)
	 */
	public function isValid($petOption,$form=null) {
		$valid = true;
		if( $petOption==1 and strlen($form['petDetails'])<4 ) {
			$this->_error(self::NO_DESCRIPTION);
			$valid = false;
		}
		return $valid;
	}
}