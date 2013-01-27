<?php
/**
 * Created on September 13, 2010 by rnelson
 @name apmgr
 * <p>
 * Create form for the user to change the applicant's status
 * </p>
 */
class Applicant_Form_ChangeApplicantWorkflowStatus extends ZFForm_ParentForm {
	protected $currentStatus;

	public function setCurrentStatus( $var ){
		$this->currentStatus = $var;
	}
	 
	private function getCurrentStatus(){
		return $this->currentStatus;
	}

	public function init() {
		$this->setLegend('updateApplicantStatus');		
	}
	 
	/**
	 *  Set form
	 */
	public function setForm(){
		// Set the method for the display form to POST
		$this->setMethod('post');

		$this->addApplicantName();
		$this->addCurrentStatus();
		$this->addStatus();
		$this->addComment();
		$this->addSubmitButton();
		 
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
	}
	 
	/**
	 *  Add applicant name
	 */
	private function addApplicantName() {
		$element = 'applicantName';
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => false,			
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));	          
		$this->addDecoratorAndGroup( $element, true );
	}
	 
	/**
	 *  Add current status
	 */
	private function addCurrentStatus() {
		$element = 'currentStatus';
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => false,			
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));	          
		$this->addDecoratorAndGroup( $element, true );
	}
	 
	/**
	 *  Add status combo
	 */
	private function addStatus(){
		$element = 'applicantStatusId';
		// Status
		$this->addElement('select',$element,array(
		'label' => 'changeApplicantStatusTo',
	        'required' => true
		));

		$statusObj = new Applicant_Model_ApplicantStatus();
		$statuses = $statusObj->fetchAll();		

		$this->getElement($element)->addMultiOption( null,'--select--');

		foreach( $statuses as $id=>$status ){			
			$this->getElement($element)->addMultiOption( $status->getId(), $status->getName() );
		}
		$this->addDecoratorAndGroup( $element );
	}
	 
	/**
	 *  Add current status
	 */
	private function addComment() {
		$element = 'comment';
			
		$this->addElement('textarea', $element, array (
			'label' => $element,
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,255)))));		
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>30));
		$this->addDecoratorAndGroup( $element );
	}
}
?>
