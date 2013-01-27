<?php
/**
 * Created on January 27, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.controllers
 * <p>
 * Create form for the user to enter payments
 * Refactored October 17, 2010
 * </p>
 */
class Financial_Form_EnterPayments extends ZFForm_ParentForm {      
        protected $sum;
	
	public function setSum( $var ){
		$this->sum = $var;
	}
	
	public function getSum(){
		return $this->sum;
	}

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');                 
               	$this->displayGroupArray = array();
	}
	
        public function setForm() {			
		$this->setLegend('payApplicantBills');
		$this->addCheckboxInstructions();
		$this->addTotalAmount();		
		$this->addPayor();
		//$this->addReferenceNumber();      						
		$this->addDatePosted();
		//$this->addPaymentNumber();
		$this->addPaymentType();
		$this->addComment();
		$this->addPreviousButton();
		//$this->addSubmitButton();
		$this->addNextButton();
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
	}
	
	/**
	 *  Adds the Previous button to form
	 *  @param string $label The label to use in this element
	 */
	protected function addPreviousButton(){
		$element = 'previous';
		$this->addElement('submit', $element, array('ignore'=> true, 'label' =>$element) );
		$this->getElement($element)->setAttrib('class','submit');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		$this->addToGroup($element);
	}
	
	/**
	 *  Adds the Next button to form
	 *  @param string $label The label to use in this element
	 */
	protected function addNextButton(){
		$element = 'next';
		$this->addElement('submit', $element, array('ignore'=> true, 'label' =>$element) );
		$this->getElement($element)->setAttrib('class','submit');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		$this->addToGroup($element);
	}
	
	/**
	 *  Add checkbox instructions
	 */
	private function addCheckboxInstructions(){		
		// Add custom label
		$element= new ZFForm_CustomLabel('instructionTextOne');
		$element->setContent( 'payApplicantBillsInstructions');
		$element->setAttrib('class','instructions');
		$element->setDecorators(array('FieldsetForm'));
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
		$this->addToGroup( 'instructionTextOne' );		
	}
	
	/**
	 *  Adds textbox that is the sum of the bills amounts due
	 */
	private function addTotalAmount(){		
		$element = 'totalAmount';
		$this->addElement('text', $element, array(
		     'label' => 'totalAmountToPay',		    
		     'readonly' => true		     
		));		
		$this->addDecoratorAndGroup( $element, true );		
		$this->getElement($element)->setValue( number_format($this->getSum(),2) );
	}	
	
	/**
	 *  Add payor
	 */
	private function addPayor(){
		// Payor Name	- the name signed on the check
		$element = 'payor';
		$this->addElement('text', $element, array (
			'label' => 'payorname',
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add reference number
	 */
	private function addReferenceNumber(){
		// Reference Number
		$element = 'referenceNumber';
		$this->addElement('text', $element, array (
			'label' => 'referencename',
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *   Add  Date Posted
	 */
	private function addDatePosted(){
		// Date Posted
		$dateCheck = new ZFForm_Datevalidate();
		$element = 'datePosted';
		$this->addElement('text', $element, array(
		     'label' => 'dateposted',
		     'required'   => true,
		     'readonly' => true		     
		));
		$this->getElement($element)->addValidator($dateCheck);
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add Payment Number
	 */
	private function addPaymentNumber() {
		//  payment number - this will need to populate depending on the pmtType above
		$element = 'paymentNumber';
		$this->addElement('text', $element, array (
			'label' => 'paymentmethodnumber',
			'required' => true,
			'filters' => array ( 'StringTrim'),
			'validators' => array ('validator' => array( 'regex', false, array('/^[0-9]+$/')))));
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add Payment Type
	 */
	private function addPaymentType(){
		//type of payment
		$element = 'paymentType';
		$this->addElement('select',$element,array( 'id'=>$element, 'label' => 'paymentmethod', 'required' => true ));
		$this->getElement($element)->setAttrib('onChange','disableFields();');
		// ('cash','creditcard','check','moneyorder'
		$this->getElement($element)->addMultiOption( 'cash','cash' );
		$this->getElement($element)->addMultiOption( 'check','check' );
		$this->getElement($element)->addMultiOption( 'creditcard','creditcard' );				
		$this->getElement($element)->addMultiOption( 'moneyorder','moneyorder' );
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add Comment
	 */
	private function addComment(){
		// Comment
		$element = 'comment';
		$this->addElement('textarea', $element, array (
			'label' => $element,
			'required' => false,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>50));
		$this->addDecoratorAndGroup( $element );
	}
}
?>