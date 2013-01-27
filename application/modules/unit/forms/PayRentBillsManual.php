<?php
/**
 * Created on October 27, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.forms
 * <p>
 * Pay lease bills manually (rent, fees, deposits)
 * </p>
 */
class Unit_Form_PayRentBillsManual extends ZFForm_ParentForm {	
	protected $applicantId;
	protected $instructionText;

	public function init() {
		$this->displayGroupArray = array();
	}
	
	public function setForm( $rentBills, $leaseFeeBills ) {				
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setLegend('selectLeaseBills');		
		$this->addCheckboxInstructions();		
		$this->addRentCheckboxes( $rentBills );
		$this->addFeeCheckboxes( $leaseFeeBills );
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
		$element->setContent( 'selectLeaseBillsInstructions');
		$element->setAttrib('class','instructions');
		$element->setDecorators(array('FieldsetForm'));
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
		$this->addToGroup( 'instructionTextOne' );		
	}
	
        /**
	 *  Add rent bills
	 */
	private function addRentCheckboxes( $bills ) {	      	  
	      $element = 'rentBills';
	  
	      if( $bills ) {
	          $this->addElement('multiCheckbox',$element,array(
		        'id'=>$element,			
			'required' => false,
			));
			 
	          foreach ($bills as $b) {
		      $outputString = 'Rent for ' .  $this->formatDate($b['month']) . ' : ' .  $b['currentAmountDue'] . ' - Due Date: ' . $this->formatDate($b['dueDate']);
	              $this->getElement($element)->addMultiOption($b['billId'], $outputString );
		      $this->getElement($element)->setAttrib('label_class','list');
	 	      $this->addDecoratorAndGroup( $element );
	          }
	      }	  	
	}
	
	/**
	 *  Add lease fee bills
	 */
	private function addFeeCheckboxes( $fees ) {	      	  
	      $element = 'leaseFeeBills';	  
	  
	      if( $fees ) {		     
		     $this->addElement('multiCheckbox',$element,array(
		        'id'=>$element,			
			'required' => false,
			));
		     
		  foreach ($fees as $b) {
		      $outputString = $b['feeName'] . ' : ' . $b['currentAmountDue'] . ' - Due Date: ' . $this->formatDate($b['dueDate']);
	              $this->getElement($element)->addMultiOption($b['billId'], $outputString );
		      $this->getElement($element)->setAttrib('label_class','list');
	 	      $this->addDecoratorAndGroup( $element );
	          }		  
	      }	  
	}
	
	private function formatDate( $date ){
	      $format  = 'MM/dd/yyyy';
	      $zendDate = new Zend_Date($date, Zend_Date::ISO_8601);       
	      $formattedDate = $zendDate->toString($format);
	      return $formattedDate;
	}
}
?>
