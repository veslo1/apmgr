<?php
/**
 * Applicant background check form
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @internal The statuses names are hardcoded, thus, if you add more statuses, this will need to be reworked
 */

class Applicant_Form_BackgroundCheck extends ZFForm_ParentForm {

	/**
	 * Identifier for passed
	 * @var const
	 */
	const PASSED = 1;

	/**
	 * Identifier for not run
	 * @var const
	 */
	const NOTRUN = 2;

	/**
	 * Identifier for rejected
	 * @var const
	 */
	const REJECTED = 3;
	/**
	 * The keys that we use in the form
	 * @var array
	 */
	static $status = array(self::PASSED=>'passed',self::NOTRUN=>'notrun',self::REJECTED=>'rejected');

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init() {
		$this->setFormTranslator();
	}

	/**
	 * Initialize the form
	 */
	public function setForm(){
		$this->setLegend('backgroundCheck');
		$this->addBackgroundCheckSelect();
		$this->addComments();
		$this->addSubmitButton('change');
		$this->removeDecorator('HtmlTag');
		$this->setDisplayGroup();
	}

	public function addBackgroundCheckSelect(){
		$element = 'status';
		$statusesValidator = array(array('validator'=> 'NotEmpty',array('integer','zero')));
		$statusesOpts = array('label'=>'status','required'=>true,'validators'=>$statusesValidator);
		$this->addElement('select',$element,$statusesOpts);
		foreach(self::$status as $id=>$key){
			$this->getElement($element)->addMultiOption($id, $key);
		}
//		$prefix = array();
//		$decorator = array('DivForm');
//		$this->addCustomDecorator($prefix,$decorator,$element);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	public function addComments(){
		$element = 'notes';
		$opts = array('label'=>'notes','required'=>true,'validators' =>  array( array('stringLength', false, array(1, 1000) )	));
		$this->addElement('textarea',$element,$opts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>30));
		$this->applyDecorator($element);
//		$prefix = array();
//		$decorator = array('DivForm');
//		$this->addCustomDecorator($prefix,$decorator,$element);
		$this->addToGroup($element);
	}
}