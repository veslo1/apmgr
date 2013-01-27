<?php
/**
 * Created on October 16, 2010 by rnelson
 * @name apmgr
 * @package application.modules.applicant.forms
 * <p>
 * Pay bills manually for applicant fees and prelease fees
 * </p>
 */
class Applicant_Form_PayApplicantBillsManual extends ZFForm_ParentForm {	
	protected $applicantId;
	protected $instructionText;

	public function init() {
		$this->displayGroupArray = array();
	}
	
	public function setForm( $bills, $preleaseBills ) {				
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setLegend('selectApplicantBills');		
		$this->addCheckboxInstructions();		
		$this->addApplicantCheckboxes( $bills );
		$this->addPreleaseCheckboxes( $preleaseBills );
		$this->addSubmitButton('next');
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator		
	}
	
	/**
	 *  Add checkbox instructions
	 */
	private function addCheckboxInstructions(){		
		// Add custom label
		$element= new ZFForm_CustomLabel('instructionTextOne');
		$element->setContent( 'selectApplicantBillsInstructions');
		$element->setAttrib('class','instructions');
		$element->setDecorators(array('FieldsetForm'));
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
		$this->addToGroup( 'instructionTextOne' );		
	}
	
        /**
	 *  Add applicant fee bills
	 */
	private function addApplicantCheckboxes( $bills ) {	      	  
	      $element = 'applicantBills';
	  
	      if( $bills ) {
	          $this->addElement('multiCheckbox',$element,array(
		        'id'=>$element,			
			'required' => false,
			));
			 
	          foreach ($bills as $b) {		      
	              $this->getElement($element)->addMultiOption($b['applicantFeeBillId'], $b['feeName'] . ' - ' . $b['currentAmountDue']);
		      $this->getElement($element)->setAttrib('label_class','list');
	 	      $this->addDecoratorAndGroup( $element );
	          }
	      }	  	
	}
	
	/**
	 *  Add applicant preleasefee bills
	 */
	private function addPreleaseCheckboxes( $preleaseBills ) {	      	  
	      $element = 'preleaseBills';	  
	  
	      if( $preleaseBills ) {		     
		     $this->addElement('multiCheckbox',$element,array(
		        'id'=>$element,			
			'required' => false,
			));
		     
		  foreach ($preleaseBills as $b) {		      
	              $this->getElement($element)->addMultiOption($b['preleaseId'], $b['feeName'] . ' - ' . $b['currentAmountDue']);
		      $this->getElement($element)->setAttrib('label_class','list');
	 	      $this->addDecoratorAndGroup( $element );
	          }		  
	      }	  
	} 
}
?>
