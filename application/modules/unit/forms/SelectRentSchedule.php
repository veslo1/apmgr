<?php
/**
 * Created on Mar 7, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Page 1 of lease wizard to select the rent schedule
 * </p>
 */
class Unit_Form_SelectRentSchedule extends Zend_Form {

	protected $instructionText;
	protected $translator;
	 
	public function setInstructionText( $var ){
		$this->instructionText = $var;
	}
	 
	public function getInstructionText(){
		return $this->instructionText;
	}

	public function init() {
		$this->translator = Zend_Registry::get('Zend_Translate');
		// Set the method for the display form to POST
		$this->setLegend('leaseWizardSelectrentschedule');
		$this->setMethod('post');
		$this->setInstructionText('rentScheduleInstructions');
	}

	public function setForm( $schedules ) {
		if( $schedules ) {
			if( $this->getInstructionText() ) {
				// Add custom label
				$element= new ZFForm_CustomLabel('instructionText');
				// sets label to 'Units for Apartment Name'
				$element->setContent( $this->getInstructionText() );
				$element->setAttrib('class','instructions');
				$element->setDecorators(array('FieldsetForm'));
				$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
				$this->addElement($element);
			}
			 
			$this->addElement('radio', 'modelRentScheduleItemId', array (
			//	'label' => 'monthsRentAmount',
			'required' => true
			));

			$this->getElement('modelRentScheduleItemId')->setAttrib('class','radio');
			$this->getElement('modelRentScheduleItemId')->setAttrib('label_class','list');
			$this->getElement('modelRentScheduleItemId')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
			$this->getElement('modelRentScheduleItemId')->setDecorators(array('FieldsetForm'));

			$this->addElement('hidden', 'modelRentScheduleId', array ( 'value' => $schedules[0]['id']  ));


			foreach ( $schedules as $s)
			$this->getElement('modelRentScheduleItemId')->addMultiOption( $s['modelRentScheduleItemId'], $s['numMonths'] . ' ' . $this->translator->translate('monthRentsFor') . ' ' . $s['rentAmount'] );

		} // end if schedules
		 
		$this->addElement('submit', 'previous', array ('ignore' => true));  // show even if no schedules so user can go back
		$this->getElement('previous')->setAttrib('class','submit');
		$this->getElement('previous')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('previous')->setDecorators(array('FieldsetForm'));

		// if model schedules exist, show button to move to the next step
		if( $schedules )	{
			$this->addElement('submit', 'next', array ('ignore' => true));
			$this->getElement('next')->setAttrib('class','submit');
			$this->getElement('next')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
			$this->getElement('next')->setDecorators(array('FieldsetForm'));
		}
		 
		$displayGroupArray = array();
		if( $this->getInstructionText() )
		array_push( $displayGroupArray, 'instructionText' );
		array_push( $displayGroupArray, 'modelRentScheduleItemId' );
		array_push( $displayGroupArray, 'modelRentScheduleId' );
		array_push( $displayGroupArray, 'previous' );
		array_push( $displayGroupArray, 'next' );
	  
		$this->addDisplayGroup($displayGroupArray,'leaseWizard',array('legend' => $this->getLegend()));

		$this->getDisplayGroup('leaseWizard')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));
		 
	} // end method

} //end class
?>
