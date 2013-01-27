<?php
/**
 * Created on March 10, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Enter move in date for lease wizard
 * </p>
 */
class Unit_Form_EnterMoveInDate extends Zend_Form {

	protected $instructionText;	
	 
	public function setInstructionText( $var ){
		$this->instructionText = $var;
	}
	 
	public function getInstructionText(){
		return $this->instructionText;
	}

	public function init() {
		$this->setMethod('post');
		$this->setInstructionText('moveInInstructions');
	}

	public function setForm(){
		// Set the method for the display form to POST
		 
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

		$this->addElement('text', 'effectiveDate', array(
                    'label'	 => "effectiveDate",
                    'required'   => true,
                    'filters'    => array('StringTrim'),
	            'readonly' => true
		));
	  
		$dateCheck = new ZFForm_Datevalidate();
		$this->getElement('effectiveDate')->addValidator($dateCheck);
		$this->getElement('effectiveDate')->setAttrib('class','inputAccesible');
		$this->getElement('effectiveDate')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('effectiveDate')->setDecorators(array('FieldsetForm'));
		
		$this->addElement('text', 'moveInDate', array(
                    'label'		 => "expectedMoveInDate",
                    'required'   => true,
                    'filters'    => array('StringTrim'),
	            'readonly' => true
		));
	  
		$dateCheck = new ZFForm_Datevalidate();
		$this->getElement('moveInDate')->addValidator($dateCheck);
		$this->getElement('moveInDate')->setAttrib('class','inputAccesible');
		$this->getElement('moveInDate')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('moveInDate')->setDecorators(array('FieldsetForm'));

		$this->addElement('submit', 'next', array ('ignore' => true,'label' => 'next'));
		$this->getElement('next')->setAttrib('class','submit');
		$this->getElement('next')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('next')->setDecorators(array('FieldsetForm'));
	  
		$displayGroupArray = array();
		if( $this->getInstructionText() )
		array_push( $displayGroupArray, 'instructionText' );
		array_push( $displayGroupArray, 'effectiveDate' );
		array_push( $displayGroupArray, 'moveInDate' );
		array_push( $displayGroupArray, 'next' );
	  
		$this->addDisplayGroup($displayGroupArray,'leaseWizard',array('legend' => $this->getLegend()));

		$this->getDisplayGroup('leaseWizard')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));
	  
	}
}
?>
