<?php
/**
 * @author Rachael Nelson
 *
 */
class Applicant_Form_EmergencyContact extends ZFForm_ParentForm {

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
		$this->addCheckboxInstructions1();
		$this->addContact();
		$this->addMainPhone();
		$this->addWorkPhone();
		$this->addRelationship();		

		if( $this->getIsSkippable() ) {
			$this->addSkipButton();
		}
		$this->setLegend('applicantEmergencyContact');
		$this->addSubmitButton();
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
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
	 *  Add checkbox instructions
	 */
	private function addCheckboxInstructions1(){
		//if( $this->getInstructionText() ) {
		// Add custom label
		$element= new ZFForm_CustomLabel('instructionTextOne');
		$element->setContent( 'choiceCheckboxInstructionsOne');
		$element->setAttrib('class','instructions');
		$element->setDecorators(array('FieldsetForm'));
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
		$this->addToGroup( 'instructionTextOne' );
		//}
	}

	/**
	 *  Add emergency contact
	 */
	private function addContact(){
		$this->addContactName();
		$this->addContactAddress();
	}

	/**
	 *  Add contact name
	 */
	private function addContactName() {
		$elementName = 'contactName';
		$nameOpts = array(
                   			'required'=>true,
                   			'label'=>$elementName,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text',$elementName,$nameOpts);
		$this->getElement($elementName)->setAttrib('class','inputAccesible');
		$this->getElement($elementName)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($elementName)->setDecorators(array('FieldsetForm'));

		$this->addToGroup( $elementName );
	}

	/**
	 * Add address information
	 */
	private function addContactAddress() {
		$this->addAddress();  //  Add address
		$this->addCity();  // Add city
		$this->addState();   // Add State
		$this->addZip();  // Add zip
	}

	/**
	 *  Add Address
	 */
	private function addAddress() {
		$element = 'address';
		$addressOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text',$element,$addressOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add city
	 */
	private function addCity(){
		$element = 'city';
		$cityOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text',$element,$cityOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add state
	 */
	private function addState(){
		$element = 'state';
		//	Not likely to change
		$states = array('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY');
		$selectOpts = array(
	            'label' => $element ,
	            'required' => true
		);
		$this->addElement('select',$element ,$selectOpts);
		$this->getElement($element )->addMultiOption(null);

		foreach($states as $id=>$stateAbbreviation) {
			$this->getElement($element )->addMultiOption(++$id, $stateAbbreviation);
		}
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add Zip code
	 */
	private function addZip(){
		$element = 'zip';
		$zipOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' => array ('validator' => array( 'regex', false, array('/^[0-9]{5}$/'))));
		$this->addElement('text',$element,$zipOpts);
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add main phone
	 */
	private function addMainPhone() {
		$element = 'mainPhone';
		$phoneOpts = array(     'required'=>false,
                   			'label'=>$element,
                   			'validators' => array ('validator' => array( 'regex', false, array('/^[0-9]{10}$/'))));

		$this->addElement('text',$element,$phoneOpts);
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add main phone
	 */
	private function addWorkPhone() {
		$element = 'workPhone';
		$phoneOpts = array(     'required'=>false,
                   			'label'=>$element,
                   			'validators' => array ('validator' => array( 'regex', false, array('/^[0-9]{10}$/'))));

		$this->addElement('text',$element,$phoneOpts);
		$this->addDecoratorAndGroup( $element );
	}
	/**
	 *  Add relationship
	 */
	private function addRelationship() {
		$element = 'relationship';
		$nameOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text',$element,$nameOpts);
		$this->addDecoratorAndGroup( $element );
	}
}