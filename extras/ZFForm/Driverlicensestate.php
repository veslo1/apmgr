<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * For the about you located at
 * @see /usr/local/www/apmgr/application/modules/applicant/forms/AboutYou.php
 * @internal If the user selects a drivers license id, validate that he selects a state.
 * Also, if he doesn't picks the driver, he has to fill the govt id card
 *
 */
class ZFForm_Driverlicensestate extends Zend_Validate_Abstract {
	/**
	 * Driver selected and no state
	 * @var const
	 */
	const NOT_MATCH = 'driverandstatefail';

	/**
	 * No kind of identification selected
	 * @var const
	 */
	const NO_ID_SELECTED = 'noidSelected';

	/**
	 * Invalid govt card
	 * @var const
	 */
	const INVALID_GOVT_CARD = 'invalidgovtcard';

	/**
	 * @var const
	 */
	const INVALID_DRIVERS_LICENSE = 'invaliddriverslicense';
	/**
	 * Drivers license kind of identification
	 * @var const
	 */
	const DRIVERS_LICENSE = 1;

	/**
	 * Use a goverment card
	 * @var const
	 */
	const GOVT_CARD = 2;

	/**
	 * @var array
	 */
	protected $_messageTemplates = array(self::NOT_MATCH => 'driverandstatefail',self::NO_ID_SELECTED=>'noidSelected',self::INVALID_GOVT_CARD=>'invalidgovtcard', self::INVALID_DRIVERS_LICENSE =>'invaliddriverslicense');

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Validate/Zend_Validate_Interface#isValid($value)
	 * @deprecated
	 */
	public function isValid($identificationMethod,$form=null) {
		$valid = true;

		$zendInt = new Zend_Validate_Int();

		//	If we choose driver's license
		if( $form['idIdentification']==self::DRIVERS_LICENSE ) {
			if( empty($form['state']) ) {
				$this->_error(self::NOT_MATCH);
				$valid = false;
			}
			//	And he has the identification
			if( empty($form['identification']) ) {
				$this->_error(self::NO_ID_SELECTED);
				$valid = false;
			}

			if( $zendInt->isValid($form['identification'])==false ) {
				$this->_error(self::INVALID_DRIVERS_LICENSE);
				$valid = false;
			}

			if( strlen($form['identification'])>9 ) {
				$this->_error(self::INVALID_DRIVERS_LICENSE);
				$valid = false;
			}
		}

		if( $form['idIdentification']==self::GOVT_CARD ) {
			if( empty($form['identification']) ) {
				$this->_error(self::NO_ID_SELECTED);
				$valid = false;
			}

			if( strlen($form['identification'])>9 or $zendInt->isValid($form['identification'])==false ) {
				$this->_error(self::INVALID_GOVT_CARD);
				$valid = false;
			}

		}

		return $valid;
	}

}