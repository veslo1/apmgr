<?php
/**
 * Created on March 12, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Confirmation Page
 * </p>
 */
class Unit_Form_Confirmation extends Zend_Form {
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
	 
	public function setForm($initValues =array()){
		$nextLabel = (isset($initValues['next']))? $initValues['next'] : 'next';
	  
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
	  
		if( !isset($initValues['hidePrevious']) ){
			$this->addElement('submit', 'previous', array ('ignore' => true,'label' => 'previous'));
			$this->getElement('previous')->setAttrib('class','submit');
			$this->getElement('previous')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
			$this->getElement('previous')->setDecorators(array('FieldsetForm'));
		}
		$this->addElement('submit', 'next', array ('ignore' => true,'label' => $nextLabel ));
		$this->getElement('next')->setAttrib('class','submit');
		$this->getElement('next')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('next')->setDecorators(array('FieldsetForm'));

		$displayGroupArray = array();
		if( $this->getInstructionText() )
		array_push( $displayGroupArray, 'instructionText' );
		array_push( $displayGroupArray, 'previous' );
		array_push( $displayGroupArray, 'next' );
	  
		$this->addDisplayGroup($displayGroupArray,'startLeaseWizard',array('legend' => $this->getLegend()));

		$this->getDisplayGroup('startLeaseWizard')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));
	  
	}
}
?>
