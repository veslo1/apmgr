<?php
/**
 * Created on March 15, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.controllers
 * <p>
 * Lease wizard to select account link for the bills
 *
 * </p>
 */
class Unit_Form_SelectFeeDeposit extends Zend_Form {
	protected $instructionText;
	protected $translator;
	protected $displayGroupArray;
	 
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
		$this->displayGroupArray = array();		
	}
	 
	public function setForm() {
		$this->addInstructionText();
		//$this->addDeposit();
		$this->addFee();
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
		 
	private function addFee(){
		$count=5;
		$feeObj = new Financial_Model_Fee();
		$fees = $feeObj->fetchAll();
		// display fee selections
		for( $i=0; $i < $count; $i++ ) {
			$txtId = 'fee'.($i+1);
			$strTxtId = (string)$txtId;
				
			// pos zend forms lol
			$this->addElement('select', (string)$txtId, array (
			'label' => $this->translator->translate('fee') .' ' . ($i+1) 
			));
			 
			if( $fees )  {
				$this->getElement($txtId)->addMultiOption(null, '--select--');
				foreach ( $fees as $id=>$fee )
				$this->getElement($txtId)->addMultiOption($fee->getId(), $fee->getName() . ' - ' . $fee->getAmount() );
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
	 *  Populates the deposit boxes with the values from the deposit table.
	 *  If the unit model has a set deposit (it should) then the first combobox
	 *  defaults to that deposit.  Allows the user to change from it just in case
	 */
	public function setDeposit( $deposit, $unitId ){
		$unitObj = new Unit_Model_Unit();
		$unitObj->setId($unitId);
		$unitItem = $unitObj->getUnit();
		$depositId = $unitItem->getUnitModel()->getDepositId();

		$count = 1;
		if($deposit) {  // if deposits have been saved in the lease wizard
			foreach( $deposit as $id=>$item ) {
				$this->populate( array( ('deposit'.$count)=>$id ) );
				$count++;
			}
		}
		else if($depositId) { // if unit model has a set deposit (it should)
			$this->populate( array( ('deposit'.$count)=>$depositId ) );
			$count++;
		}
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
		$feeArray[] = $this->getValue('fee1');
		$feeArray[] = $this->getValue('fee2');
		$feeArray[] = $this->getValue('fee3');
		$feeArray[] = $this->getValue('fee4');
		$feeArray[] = $this->getValue('fee5');
		$feeArray = array_filter( $feeArray );
	  
		$finObj = new Financial_Model_Fee();
		$temp=array();
		foreach( $feeArray as $id=>$key ) {
			$item = $finObj->findById( $key );
			if( is_object($item) ) {
			    $temp[$key] = array('name'=>$item->getName(), 'amount'=>$item->getAmount());
			}
		}
		return $temp;
	}	
}
?>