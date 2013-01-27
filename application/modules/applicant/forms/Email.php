<?php
/**
 * Form that allows the user to notify an applicant
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_Form_Email extends ZFForm_ParentForm {

	/**
	 * Used to determine the kind of flag we use
	 * @var boolean
	 */
	public $isWaitlist;

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init(){}

	public function setForm(){
		$this->setFormTranslator();
		$this->addTo();
		$this->addEmailText();
		$this->addSubmitButton('send');
		//$this->removeDecorator('HtmlTag');
		if($this->isWaitlist==true){
			$this->setLegend('emailUser');
		} else {
			$this->setLegend('emailApplicant');
		}		
		$this->setDisplayGroup();		
	}
	/**
	 * Add an add to that will contain the name of the applicant
	 */
	private function addTo(){
		$element = 'to';
		$options = array('required'=>false,'readonly' => true,'filters'=>array('StringTrim'),'label'=>'to');
		$this->addElement('text',$element,$options);
		//$prefix = array();
		//$decorator = array('DivForm');
		//$this->addCustomDecorator($prefix,$decorator,$element);
		$this->applyDecorator($element,true);
		$this->addToGroup($element);
	}

	/**
	 * Add the textarea that will allow the user to write the text of the email
	 */
	private function addEmailText(){
		$element = 'body';
		$opts = array('label'=>'emailMessage','required'=>true,'validators' =>  array( array('stringLength', false, array(1, 1000) )	));
		$this->addElement('textarea',$element,$opts);
		$this->getElement($element)->setAttribs(array('rows'=>20,'cols'=>30));
		//$prefix = array();
		//$decorator = array('DivForm');
		//$this->addCustomDecorator($prefix,$decorator,$element);
		$this->applyDecorator($element,false);
		$this->addToGroup($element);
	}
}