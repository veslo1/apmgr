<?php
class Applicant_Form_ApplicantReport extends ZFForm_ParentForm
{

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init(){}

	public function setForm()
	{
		$this->setMethod('post');
		$this->setFormTranslator();
		$this->addDateFromFilter();
		$this->addDateToFilter();
		$this->addSubmitButton('search');
		$this->setLegend('applicantpaidFees');
		$this->setCache(Zend_Registry::get('cache'));
		$this->setCacheKey('applicantReport');
		$this->setDisplayGroup();
	}

	private function addDateFromFilter()
	{
		$element = 'dateFrom';
		$dateFrom = array('label'=>$element,'required'=>false,'readonly' => true);
		$this->addElement('text',$element,$dateFrom);
		$this->getElement($element)->addValidator(new ZFForm_Datevalidate());
		$this->getElement($element)->addValidator(new ZFForm_Comparevalidate('dateTo'));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addDateToFilter()
	{
		$element = 'dateTo';
		$dateTo = array('label'=>$element,'required'=>false,'readonly' => true);
		$this->addElement('text',$element,$dateTo);
		$this->getElement($element)->addValidator(new ZFForm_Datevalidate());
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

}