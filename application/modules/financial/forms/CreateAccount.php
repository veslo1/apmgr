<?php
class Financial_Form_CreateAccount extends ZFForm_ParentForm {
	public function init() {
	}
	
	public function setForm() {
		$translator = Zend_Registry::get('Zend_Translate');
		// Set the method for the display form to POST
		$this->setMethod('post');
		
		$this->addAccountName();
		$this->addAccountNumber();
                $this->addOrientation();
		$this->addAccountType();
		$this->addSubmitButton();
		
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator		
	}
	
	/**
	 *  Add account name
	 */
	private function addAccountName() {		
		$element = 'name';
		$this->addElement('text', $element, array(
                              'label'      => 'accountName',
                              'required'   => true,
                              'filters'    => array('StringTrim'),
			      'size'=>30,
                               'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)) )
		));
                $this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add account number
	 */
	private function addAccountNumber() {
		$element = 'number';		
		$this->addElement('text', $element, array (
			'label' => 'accountNumber',
			'required' => true,
			'filters' => array ( 'StringTrim'),
			'validators' => array ('validator' => array( 'regex', false, array('pattern'=>'/^[0-9]{1,11}$/',
											   'messages'=>array('regexNotMatch'=>'regexelevendigits')
											   )))));
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add orientation
	 */
	private function addOrientation() {
		$element = 'orientation';
		$this->addElement('select',$element,array(
			'label' => 'accountOrientation',
			'required' => true,
		));
		$this->getElement($element)->addMultiOption( 'debit', 'debit' );
		$this->getElement($element)->addMultiOption( 'credit', 'credit' );
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add unit model
	 */
	private function addAccountType() {
		$element = 'accountTypeId';
		$this->addElement('select',$element,array(
			'label' => 'accountType',
			'required' => true,
		));
		
		$accountType = new Financial_Model_AccountType();
		
		foreach ($accountType->fetchAll() as $at) {
			$this->getElement($element)->addMultiOption($at->getId(), $at->getName());
		}
		$this->addDecoratorAndGroup( $element );
	}
}
?>
