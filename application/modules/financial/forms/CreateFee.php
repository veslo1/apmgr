<?php
/**
 * Created on April 23, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.controllers
 * <p>
 * Create form for fees
 * </p>
 */
class Financial_Form_CreateFee extends ZFForm_ParentForm {
	protected $feeId;

	public function getFeeId(){
		return $this->feeId;
	}

	public function setFeeId( $var ){
		$this->feeId = $var;
	}

	public function init() {
			
	}

	public function setForm() {
		$translator = Zend_Registry::get('Zend_Translate');
		 
		// Set the method for the display form to POST
		$this->setMethod('post');
		 
		$this->addName();
		$this->addAmount();
		$this->addDebitAccount();
		$this->addCreditAccount();
		$this->addRefundable();
		$this->addEnabled();
		$this->addSubmitButton();
		 
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
	}

	private function addName() {
		$element = 'name';
		$required=true;
		$inaccessible=false;
		 
		if( $this->feeId==1 ){ // makes the required fee name inaccessible for application settings
			$required=false;
			$inaccessible=true;
		}
		 
		$this->addElement('text', $element, array (
			'label' => 'feeName',
			'required' => $required,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));	

		$this->addDecoratorAndGroup( $element, $inaccessible );
	}
	 
	private function addDebitAccount(){
		$element = 'debitAccountId';
		// Debit Account
		$this->addElement('select',$element,array(
			'label' => 'debitAccount',
			'required' => true,
		));
			
		$account = new Financial_Model_Account();

		foreach ($account->fetchAll() as $a)
		$this->getElement($element)->addMultiOption( $a->getId(), $a->getName() );

		$this->addDecoratorAndGroup( $element );
	}

	private function addCreditAccount(){
		$element = 'creditAccountId';
		// Credit Account
		$this->addElement('select',$element,array(
			'label' => 'creditAccount',
			'required' => true,
		));

		$account = new Financial_Model_Account();
	  
		foreach ($account->fetchAll() as $a)
		$this->getElement($element)->addMultiOption( $a->getId(), $a->getName() );

		$this->addDecoratorAndGroup( $element );
	}

	public function addAmount(){
		$element = 'amount';
		// amount
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => true,
			'filters' => array ( 'StringTrim'),
			'validators' => array ('validator' => array( 'regex', false, array('/^\d+(\.\d{1,2})?$/')))));

		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add refundable checkbox
	 */
	private function addRefundable(){
		$element = 'refundable';
		$this->addElement('checkbox',$element,array(
		    'label' => 'refundable',
		    'required' => false
		));
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add enabled checkbox
	 */
	private function addEnabled(){
		$element = 'enabled';
		$this->addElement('checkbox',$element,array(
		    'label' => 'enabled',
		    'required' => false
		));
		$this->addDecoratorAndGroup( $element );
	}
}
?>
