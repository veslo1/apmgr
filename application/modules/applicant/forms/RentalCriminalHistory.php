<?php
/**
 * @author Rachael Nelson
 *
 */
class Applicant_Form_RentalCriminalHistory extends ZFForm_ParentForm {

	protected $isSkippable;
	protected $instructionText;

	/**
	 *  Fetches/sets if form is skippable (true/false)
	 */
	public function getIsSkippable(){
		return $this->isSkippable;
	}
	public function setIsSkippable( $var ){
		$this->isSkippable = $var;
	}

	public function setInstructionText( $var ){
		$this->instructionText = $var;
	}

	public function getInstructionText(){
		return $this->instructionText;
	}
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init(){
		$this->displayGroupArray = array();
		$this->setIsSkippable(false);
	}

	public function setForm() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		
		$this->addPropertyInstructions();
		$this->addPropertyArea();
		$this->addFelonyInstructions();
		$this->addFelonyArea();		

		if( $this->getIsSkippable() ) {
			$this->addSkipButton();
		}
		$this->addSubmitButton();
		$this->setLegend('rentalCriminalHistory');
		$this->setFormTranslator();
		$this->setDisplayGroup();
	}

	/**
	 *  Adds skip button
	 */
	private function addSkipButton(){
		$this->addElement('submit', 'skip', array( 'ignore'   => true, 'label' => 'skip' ));
		$this->getElement('skip')->setAttrib('class','submit');
		$this->getElement('skip')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('skip')->setDecorators(array('FieldsetForm'));

		$this->addToGroup( 'skip' );
	}

	/**
	 *  Add property instructions
	 */
	private function addPropertyInstructions(){		
		// Add custom label
		$element= new ZFForm_CustomLabel('instructionText');
		$element->setContent( 'propertyInstructions');
		$element->setAttrib('class','instructions');
		$element->setDecorators(array('FieldsetForm'));
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
		$this->addToGroup( 'instructionText' );		
	}
	
	/**
	 *  Add Property text area
	 */
	private function addPropertyArea() {
		$elementName = 'propertyComment';
		$addressOpts = array(
                   			'required'=>false,		   			
                   			'validators' =>  array( array('stringLength', false, array(1, 1000) )	)
		);
		$this->addElement('textarea',$elementName,$addressOpts);
		$this->getElement($elementName)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->getElement($elementName)->setAttrib('class','inputAccesible');
		$this->getElement($elementName)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($elementName)->setDecorators(array('FieldsetForm'));

		$this->addToGroup( $elementName );
	}

	
	/**
	 *  Add felony instructions
	 */
	private function addFelonyInstructions(){		
		// Add custom label
		$element= new ZFForm_CustomLabel('instructionText2');
		$element->setContent( 'crimeInstructions');
		$element->setAttrib('class','instructions');
		$element->setDecorators(array('FieldsetForm'));
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
		$this->addToGroup( 'instructionText2' );		
	}

	/**
	 *  Add Felony text area
	 */
	private function addFelonyArea() {
		$elementName = 'crimeComment';
		$addressOpts = array(
                   			'required'=>false,		   			
                   			'validators' =>  array( array('stringLength', false, array(1, 1000) )	)
		);
		$this->addElement('textarea',$elementName,$addressOpts);
		$this->getElement($elementName)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->getElement($elementName)->setAttrib('class','inputAccesible');
		$this->getElement($elementName)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($elementName)->setDecorators(array('FieldsetForm'));

		$this->addToGroup( $elementName );
	}
}