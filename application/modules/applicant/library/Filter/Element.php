<?php
/**
 * Implementation of the filter iterator for Zend_Form_Elements
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 */

class Applicant_Library_Filter_Element extends FilterIterator{

	public function __construct(Iterator $iterator){
		parent::__construct($iterator);
	}

	/* (non-PHPdoc)
	 * @see FilterIterator::accept()
	 */
	public function accept(){
		return $this->getInnerIterator()->current()->getType()==Applicant_Library_Interface_IForm::TARGETCASE;
	}
}