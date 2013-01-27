<?php
/**
 * Created on Mar 7, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Page 2 of lease wizard for entering the rent schedule discounts
 * </p>
 */
class Unit_Form_EnterDiscounts extends Zend_Form {
	 
	protected $instructionText;
	private $leaseWizard;
	 
	private function getMaxDiscountBoundary($month){
		$proration = $this->getLeaseWizard()->getProrationObj();
		$proration->setMonthSequence( $month );

		$amount = $proration->getAmountDue();
		if( $amount!=$this->leaseWizard->getRentAmount() ){
			$translator = Zend_Registry::get('Zend_Translate');
			$this->getElement('prorationAmount')->setValue( $translator->translate('month').' ' . $month . ': '  . $amount );
		}

		return $amount;
	}
	 
	public function setInstructionText( $var ){
		$this->instructionText = $var;
	}

	public function getInstructionText(){
		return $this->instructionText;
	}
	 
	/**
	 *  Sets the lease wizard
	 */
	public function setLeaseWizard( $var ){
		$this->leaseWizard = $var;
	}
	 
	public function getLeaseWizard(){
		return $this->leaseWizard;
	}

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setInstructionText('enterDiscountInstructions');
		$this->setLegend('leaseWizardEnterdiscounts');
	}

	public function setForm( $scheduleItem ) {
		$displayGroupArray = array();
		 
		if( $this->getInstructionText() ) {
			// Add custom label
			$element= new ZFForm_CustomLabel('instructionText');
			 
			$element->setContent( $this->getInstructionText() );
			$element->setAttrib('class','instructions');
			$element->setDecorators(array('FieldsetForm'));
			$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
			$this->addElement($element);

			array_push( $displayGroupArray, 'instructionText' );
		}
		 
		 
		$this->addElement('text', 'rentAmount', array(
            'label'		 => "baseRentAmount",
            'required'   => false,
		//'filters'    => array('StringTrim'),
	    'readonly' => true
		));

		$this->getElement('rentAmount')->setAttrib('class','inputNotAccesible');
		$this->getElement('rentAmount')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('rentAmount')->setDecorators(array('FieldsetForm'));
		array_push( $displayGroupArray, 'rentAmount' );
	  
		//  Proration Amount
		$this->addElement('text', 'prorationAmount', array(
                    'label' => "prorationAmount",
                    'required'   => false,		    
	            'readonly' => true
		));

		$this->getElement('prorationAmount')->setAttrib('class','inputNotAccesible');
		$this->getElement('prorationAmount')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('prorationAmount')->setDecorators(array('FieldsetForm'));
		array_push( $displayGroupArray, 'prorationAmount' );
		 
		// Loop through the selected schedule and print labels and textboxes for each month.  The labels display the
		// month and each rent for that month.  The textbox contains the rent discount (default to empty)
		$count = (int)$scheduleItem->getNumMonths();

		for( $i=0; $i < $count; $i++ ) {
			$txtId = $i+1;
				
			$strTxtId = (string)$txtId;
		  
			$max = $this->getMaxDiscountBoundary($i+1);
			// pos zend forms lol
			$this->addElement('text', $strTxtId, array (
			//'belongsTo'=>'discount',
			'label' => $i+1,
			'required'=>false,
			'filters'    => array('StringTrim'),			
			'validators' => array (
			array( 'Between', false, array( 'min'=>0, 'max'=> $max ))
			)));
	   
			$this->getElement($strTxtId)->setAttrib('class','inputAccessible');
			$this->getElement($strTxtId)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
			$this->getElement($strTxtId)->setDecorators(array('FieldsetForm'));
			array_push( $displayGroupArray, $strTxtId );
		}


		$this->addElement('submit', 'previous', array ('ignore' => true));
		$this->getElement('previous')->setAttrib('class','submit');
		$this->getElement('previous')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('previous')->setDecorators(array('FieldsetForm'));


		$this->addElement('submit', 'next', array ('ignore' => true));
		$this->getElement('next')->setAttrib('class','submit');
		$this->getElement('next')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('next')->setDecorators(array('FieldsetForm'));
		 
	  
	  
		array_push( $displayGroupArray, 'previous' );
		array_push( $displayGroupArray, 'next' );
		 
		$this->addDisplayGroup($displayGroupArray,'leaseWizard',array('legend' => $this->getLegend()));

		$this->getDisplayGroup('leaseWizard')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));
		 
	}

	public function getDiscountValues(){
		$formValues = $this->getValues();
		unset($formValues['rentAmount']);
		unset($formValues['prorationAmount']);
		return array_filter($formValues);
	}
}
?>
