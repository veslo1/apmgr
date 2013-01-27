<?php
/**
 * Why you rented here form
 * @author Jorge Omar Vazquez<Jorge.Vazquez@networksolutions.com>
 */

class Applicant_Form_Survey extends ZFForm_ParentForm {
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init() {}

	public function setForm() {
		$this->setMethod('post');
		$this->setFormTranslator();
		$this->addWereYouReferred();
		$this->addHowDidYouFindUs();
		$this->setLegend('whyYouRentedHere');
		$this->addSubmitButton();
		$this->setDisplayGroup();
	}
	
	private function addWereYouReferred() {
		$element = 'wereYouReferred';
		$selectOpts = array('label' => $element,'required' => true);
		$this->addElement('textarea',$element,$selectOpts);
		$this->getElement($element)->setAttribs(array('rows'=>5,'cols'=>17));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addHowDidYouFindUs() {
		$element = 'howDidYouFindUs';
		$options = array('label'=>$element,'required'=>true);
		$this->addElement('textarea',$element,$options);
		$this->getElement($element)->setAttribs(array('rows'=>5,'cols'=>17));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}
}
