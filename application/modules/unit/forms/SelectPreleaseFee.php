<?php
/**
 * Created on Dec 23, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.controllers
 * <p>
 * Lease wizard to select prelease fees for inclusion with the lease 
 * </p>
 */
class Unit_Form_SelectPreleaseFee extends Zend_Form {
	protected $instructionText;
	protected $translator;
	protected $displayGroupArray;
	private $count; // holds count of fees
	 
	public function setInstructionText( $var ){
		$this->instructionText = $var;
	}
	 
	public function getInstructionText(){
		return $this->instructionText;
	}

	public function init() {
		$this->translator = Zend_Registry::get('Zend_Translate');
		// Set the method for the display form to POST
		$this->setMethod('post');		
		$this->setLegend('leaseWizardPreleaseFees');
		$this->displayGroupArray = array();		
	}
	 
	public function setForm($fees) {
		$this->addInstructionText();		
		$this->addFee($fees);
		$this->addPrevious();
		$this->addNext();
		 
		$this->addDisplayGroup($this->displayGroupArray,'leaseWizard',array('legend' => $this->getLegend()));

		$this->getDisplayGroup('leaseWizard')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));
	}
	 
	/**
	 *  Pushes element to array group
	 */
	private function addToGroup($var){
		array_push( $this->displayGroupArray, $var );
	}

	private function applyDecorator($element){
		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
	}

	private function addInstructionText(){
		if( $this->getInstructionText() ) {
			// Add custom label
			$element= new ZFForm_CustomLabel('instructionText');
			 
			$element->setContent( $this->getInstructionText() );
			$element->setAttrib('class','instructions');
			$element->setDecorators(array('FieldsetForm'));
			$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
			$this->addElement($element);
			$this->addToGroup('instructionText');
		}
	}	 
		 
	private function addFee($fees){
		$this->count=count($fees);
		$feeObj = new Financial_Model_Fee();		
		// display fee selections
		for( $i=0; $i < $this->count; $i++ ) {
			$txtId = 'fee'.($i+1);
			$strTxtId = (string)$txtId;
				
			// pos zend forms lol
			$this->addElement('select', (string)$txtId, array (
			'label' => $this->translator->translate('fee') .' ' . ($i+1) 
			));
			 
			if( $fees )  {
				$this->getElement($txtId)->addMultiOption(null, '--select--');
				foreach ( $fees as $id=>$fee ) { 
				    $this->getElement($txtId)->addMultiOption($fee['preleaseId'], $fee['feeName'] . ' - ' . $fee['amount'] . ' - ' . $fee['firstName'] . ' ' . $fee['lastName'] );
				}
			}
			$this->applyDecorator($strTxtId);
			$this->addToGroup($strTxtId);
		}
	}
	 
	/**
	 *  Add previous button
	 */
	private function addPrevious(){
		$element = 'previous';
		$this->addElement('submit', $element, array ('ignore' => true));
		$this->getElement($element)->setAttrib('class','submit');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		$this->addToGroup($element);
	}
	 
	/**
	 *  Add next button
	 */
	private function addNext(){
		$element = 'next';
		$this->addElement('submit', $element, array ('ignore' => true));
		$this->getElement($element)->setAttrib('class','submit');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		$this->addToGroup($element);
	}	 
	
	/**
	 *  Populates Fee selects
	 */
	public function setFee( $fee ){
		$count = 1;
		if($fee) {
			foreach( $fee as $id=>$item ) {
				$this->populate( array( ('fee'.$count)=>$id ) );
				$count++;
			}
		}
	}

	/**
	 *  Return form fees
	 */
	public function getFormFee(){
		$feeArray = array();		
		
		for ( $i=0; $i<$this->count; $i++) {						
			$item = 'fee'.(string)($i+1);			
			$feeArray[] = $this->getValue($item);
		}
		$feeArray = array_filter( $feeArray );		
		return $feeArray;
	}	
}
?>