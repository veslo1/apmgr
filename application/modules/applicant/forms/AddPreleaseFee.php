<?php
/**
 * Created on Oct 7, 2010 by rnelson
 * @name apmgr
 * @package application.modules.applicant.forms
 * <p>
 * Add fee to prelease
 *
 * </p>
 */
class Applicant_Form_AddPreleaseFee extends ZFForm_ParentForm {
        protected $applicantId;
       
        public function setApplicantId($var){
		$this->applicantId = $var;
	}
	
	public function getApplicantId(){
		return $this->applicantId;
	}

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setLegend( 'addPreleaseFee' );
	}
	 
	public function setForm($fees) {
            $this->addFee($fees);	    
	    $this->addDueDate();	    
	    $this->addFeeToApply();
            $this->addSubmitButton();
	    $this->setDisplayGroup();  // add display group
	    $this->setFormTranslator();  // add translator
	}
	
	/**
	 *  Add fee
	 */
	private function addFee($fees){
	    $element = 'newFee';	
	    $this->addElement('select', $element, array (
	 	'label' => 'fee' ));	    		    

	   foreach ( $fees as $id=>$fee ){
	       $this->getElement($element)->addMultiOption($fee->getId(), $fee->getName() . ' - ' . $fee->getAmount() );
	   }    	    	    
	   $this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add due date
	 */
	private function addDueDate(){
	    $element = 'dueDate';	
	    $this->addElement('text', $element, array(
                'label'		 => "dueDate",
                'required'   => true,
                'filters'    => array('StringTrim'),
	        'readonly' => true
		));
	  
	    $dateCheck = new ZFForm_Datevalidate();
	    $this->getElement($element)->addValidator($dateCheck);	    
	    $this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *  Add paid applicant fee to apply against the selected fee ($40 app deposit towards required $200 sec deposit)
	 */
	private function addFeeToApply(){	    
            $applicantFeeObj = new Applicant_Library_PaymentHelper();  // paid applicant feeBills
	    $paidFees = $applicantFeeObj->getPaidFees($this->getApplicantId());	    	    
	    	    		
	    if( $paidFees ) {	
	        $element = 'feeBillIdToApply';	
	        $this->addElement('select', $element, array (
	 	    'label' => 'applicantFeeToApply' ));	    		    

                $this->getElement($element)->addMultiOption(null,'--select--'); 
	        foreach ( $paidFees as $id=>$fee ){
	            $this->getElement($element)->addMultiOption($fee['feeBillId'], $fee['name'] . ' - ' . $fee['paidAmount'] );
	        }     	    	    
	        $this->addDecoratorAndGroup( $element );
	    }
	}
	
}
?>