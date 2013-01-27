<?php
/**
 * Filter form for Lease Agent
 * @author Jorge Omar Vazquez <jorgeomar.vazquez@gmail.com>
 */

class Applicant_Form_LeaseAgentFilter extends ZFForm_ParentForm {
	/**
	 * Attribute that allows the form to be displayed or not
	 * @var boolean $lockStatus
	 */
	protected $lockStatus;

	/**
	 * Collection of arrays to be injected into the form
	 * @var array|Applicant_Model_ApplicantWorkflowStatus $statuses
	 */
	protected $statuses;

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init(){
		$this->lockStatus = false;
		$this->statuses = array();
	}

	/**
	 * Our implementation
	 */
	public function setForm(){
		if( true == $this->lockStatus ) {
			$this->addFilterByLabel();
			$this->addFilterByStatus();
			$this->addSelectStatuses();
		}
		$this->addFilterByUnitNumber();
		$this->addUnitNumberInput();
		$this->addFilterByDatesLabel();
		$this->addFilterByDateCheckbox();
		$this->addDateFromLabel();
		$this->addDateFromInput();
		$this->addDateToLabel();
		$this->addDateToInput();
		$this->addSubmitButton('search');
		$this->setDecorators(array('FormElements',array('HtmlTag',array('tag' =>'div','class'=>'roundcorner_32_grey_content')),'Form'));

	}

	/**
	 * Add the label for the checkbox
	 */
	private function addFilterByLabel() {
		$element= new ZFForm_CustomLabel('filterByStatusLabel');
		$element->setContent( 'filterByStatus');
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
	}

	/**
	 * Add a checkbox that allows the user to filter by status
	 */
	private function addFilterByStatus(){
		$name = 'filterByStatus';
		$this->addElement('multiCheckbox',$name,array('id'=>'filterByStatus','required'=>false));
		$this->getElement($name)->addMultiOption(1,null);
		$this->getElement($name)->addPrefixPath('ZFForm_Decorator','applicant/library/ZFForm/Decorator','decorator');
		$this->getElement($name)->setDecorators(array('LeaseAgentFormInput'));
	}

	/**
	 * Add the select to push statuses
	 */
	private function addSelectStatuses() {
		$name = 'filterValue';
		$this->addElement('multiselect',$name,array('id'=>'filterValue','required'=>false));
		$this->getElement($name)->addPrefixPath('ZFForm_Decorator','applicant/library/ZFForm/Decorator','decorator');
		$this->getElement($name)->setDecorators(array('LeaseAgentFormInput'));
		if( isset($this->statuses['type']) ) {
			unset($this->statuses['type']);
			foreach($this->statuses as $id=>$element){
				$this->getElement($name)->addMultiOption($element['id'],ucfirst($element['name']));
			}
		} else {
			foreach($this->statuses as $id=>$element){
				$this->getElement($name)->addMultiOption($id,$element);
			}
		}
	}

	/**
	 * Push into the select all the values that you want to display as valid statuses
	 * @param array|Applicant_Model_Statuses $args
	 */
	public function setStatuses($args=null){
		if ( $args!=null) {
			$this->statuses = $args;
			$this->lockStatus = true;
		}
		return $this->lockStatus;
	}

	private function addFilterByUnitNumber(){
		$element= new ZFForm_CustomLabel('filterByUnitNumber');
		$element->setContent( 'filterByUnitNumber');
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
	}

	private function addUnitNumberInput(){
		$name = 'unitNumber';
		$options = array('required'=>false);
		$this->addElement('text',$name,$options);
		$this->getElement($name)->addPrefixPath('ZFForm_Decorator','applicant/library/ZFForm/Decorator','decorator');
		$this->getElement($name)->setDecorators(array('LeaseAgentFormInput'))
		->setAttrib('size', 5);
	}

	/**
	 * Add the label for the checkbox that specifies that we are going to search by date
	 */
	private function addFilterByDatesLabel() {
		$element= new ZFForm_CustomLabel('filterByDatesLabel');
		$element->setContent( 'filterByDates');
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
	}

	/**
	 * Add a checkbox to indicate that we want to look up by date
	 */
	private function addFilterByDateCheckbox(){
		$name = 'filterByDates';
		$this->addElement('multiCheckbox',$name,array('id'=>'filterByDates','required'=>false));
		$this->getElement($name)->addMultiOption(1,null);
		$this->getElement($name)->addPrefixPath('ZFForm_Decorator','applicant/library/ZFForm/Decorator','decorator');
		$this->getElement($name)->setDecorators(array('LeaseAgentFormCheckbox'));
		$crossDateValidation = new Applicant_Library_ZFForm_Validator_CrossDateValidation();
		$this->getElement($name)->addValidator($crossDateValidation);
	}

	/**
	 * Add the label that indicates the name of the input
	 */
	private function addDateFromLabel() {
		$element= new ZFForm_CustomLabel('dateFromLabel');
		$element->setContent( 'dateFrom');
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
	}

	/**
	 * Add a dateFrom input
	 */
	private function addDateFromInput(){
		$name = 'dateFrom';
		$options = array('required'=>false,'readonly'=>true);
		$this->addElement('text',$name,$options);
		$this->getElement($name)->addPrefixPath('ZFForm_Decorator','applicant/library/ZFForm/Decorator','decorator');
		$this->getElement($name)->setDecorators(array('LeaseAgentFormInput'));
	}

	/**
	 * Add the label that indicates the name of the input
	 */
	private function addDateToLabel() {
		$element= new ZFForm_CustomLabel('dateToLabel');
		$element->setContent( 'dateTo');
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
		$this->addElement($element);
	}

	/**
	 * Add the date to input
	 */
	private function addDateToInput(){
		$name = 'dateTo';
		$options = array('required'=>false,'readonly'=>true);
		$this->addElement('text',$name,$options);
		$this->getElement($name)->addPrefixPath('ZFForm_Decorator','applicant/library/ZFForm/Decorator','decorator');
		$this->getElement($name)->setDecorators(array('LeaseAgentFormInput'));
	}
}