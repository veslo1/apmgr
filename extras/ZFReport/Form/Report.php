<?php
/**
 * Form definition for reports
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 */

class ZFReport_Form_Report extends ZFForm_ParentForm
{

	/**
	 * Attribute that determines if we use date filters
	 * @var boolean
	 */
	private $useDateFilters;

    /**
     * Set the legend of the form
     * @var string
     */
    private $myLegend;

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init()
	{
		$this->setFormTranslator();
	}

	/**
	 * Form initialization
	 */
	public function setForm()
	{
		$useDateFilters = $this->getUseDateFilters();
		if( true==$useDateFilters )
		{
			$this->addDateFrom();
			$this->addDateTo();
		}

		$this->addSubmitButton('runReport');
		$legend = $this->getMyLegend();
		if( !isset($legend) ){
			$this->setMyLegend('report');
		}
		$this->setLegend($this->getMyLegend());
		$this->setDisplayGroup();
	}

	/**
	 * Determine if we will be filtering by dates
	 * @param boolean $enabled
	 */
	public function setUseDateFilters($enabled=false)
	{
		$this->useDateFilters = $enabled;
	}

	/**
	 * Retrieve the setting that determines if we use date filters
	 * @return boolean
	 */
	public function getUseDateFilters()
	{
		return $this->useDateFilters;
	}

    /**
     * Set the legend of the form
     * @param string $legend
     */
    public function setMyLegend($legend='report')
    {
    	$this->myLegend = $legend;
    }

    /**
     * Retrieve the legend that is going to be used for this form
     * @return string
     */
    public function getMyLegend()
    {
    	return $this->myLegend;
    }

	/**
	 * Adds a date input
	 */
	public function addDateFrom()
	{
		$dateCheck = new ZFForm_Datevalidate();
		$element = 'dateFrom';
		$dateFromOpts = array('label'=>$element,'required'=>true,'readonly' => true);
		$this->addElement('text',$element,$dateFromOpts);
		$this->getElement($element)->addValidator($dateCheck);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Adds a date input
	 */
	public function addDateTo()
	{
		$dateCheck = new ZFForm_Datevalidate();
		$element = 'dateTo';
		$dateToOpts = array('label'=>$element,'required'=>true,'readonly' => true);
		$this->addElement('text',$element,$dateToOpts);
		$this->getElement($element)->addValidator($dateCheck);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}
}
