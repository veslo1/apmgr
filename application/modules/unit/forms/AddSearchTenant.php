<?php
class Unit_Form_AddSearchTenant extends Zend_Form {
	protected $instructionText;

	public function setInstructionText( $var ){
		$this->instructionText = $var;
	}
	 
	public function getInstructionText(){
		return $this->instructionText;
	}

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');
	}

	public function setForm() {
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

		// Search for first/last name
		$this->addElement('text', 'firstName', array(
                              'label'      => 'firstName',
                              'required'   => true,
                              'filters'    => array('StringTrim'),
                              'validators' => array( 'Alpha' )
		));

		$this->getElement('firstName')->setAttrib('class','inputAccessible');
		$this->getElement('firstName')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('firstName')->setDecorators(array('FieldsetForm'));

		$this->addElement('text', 'lastName', array(
                              'label'      => 'lastName',
                              'required'   => true,
                              'filters'    => array('StringTrim'),
                              'validators' => array( 'Alpha' )
		));

		$this->getElement('lastName')->setAttrib('class','inputAccessible');
		$this->getElement('lastName')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('lastName')->setDecorators(array('FieldsetForm'));

		// Add the submit button
		$this->addElement('submit', 'submit', array(
                              'ignore'   => true,
                              'label'    => 'searchForUser',
		));

		$this->getElement('submit')->setAttrib('class','submit');
		$this->getElement('submit')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('submit')->setDecorators(array('FieldsetForm'));

		$displayGroupArray = array();
		if( $this->getInstructionText() )
		array_push( $displayGroupArray, 'instructionText' );
		array_push( $displayGroupArray, 'firstName' );
		array_push( $displayGroupArray, 'lastName' );
		array_push( $displayGroupArray, 'submit' );
	  
		$this->addDisplayGroup($displayGroupArray,'searchAddTenant',array('legend' => $this->getLegend()));

		$this->getDisplayGroup('searchAddTenant')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));

	}

}
?>
