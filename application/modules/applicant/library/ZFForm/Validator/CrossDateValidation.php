<?php
/**
 * Implementation of date validation for the custom form
 * @author Jorge Vazquez <jorgeomar.vazquez@gmail.com>
 */

class Applicant_Library_ZFForm_Validator_CrossDateValidation extends Zend_Validate_Abstract {
	/**
	 * Identifier for the constant
	 * @var const
	 */
	const DATENOTSET='datesNotSet';

	/**
	 * Enter description here ...
	 * @var unknown_type
	 */
	const DATENOTVALID = 'dateToLowerThanDateFrom';
	/**
	 * Attribute that pushes information into the view
	 * @var array $_messageTemplates
	 */
	protected $_messageTemplates = array(self::DATENOTVALID=> 'dateToLowerThanDateFrom',self::DATENOTSET=>'datesNotSet');

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Validate/Zend_Validate_Interface#isValid($value)
	 */
	public function isValid($filterByDate,$form=null) {
		$valid = true;
		if( $filterByDate==1 ) {
			$prepared = $this->requiredValues($form);
			//	If we do have the dates , the continue to validate it
			if( true==$prepared ) {
				Zend_Date::setOptions(array('format_type' => 'php'));
				$dateTo = new Zend_Date();
				$dateTo->setDate($form['dateFrom'],'Y-m-d',Zend_Registry::get('Zend_Locale'));
				$result = $dateTo->compareDate($form['dateTo'],'Y-m-d',Zend_Registry::get('Zend_Locale'));
				if( $result==1 ) {
					$valid = false;
					$this->_error(self::DATENOTVALID);
				}
			} else {
				$valid = false;
				$this->_error(self::DATENOTSET);
			}
		}
		return $valid;
	}

	/**
	 * Validate the two required date inputs
	 * @param array $args
	 * @return boolean
	 */
	protected function requiredValues(array $args=null){
		$stack = false;
		if( $args!=null ) {
			$stack = !empty($args['dateTo']) and !empty($args['dateFrom']) ? true:false;
		}
		return $stack;
	}
}
