<?php
/**
 * Display a form so the user can recover his username
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.forms
 */

class User_Form_ForgotUserName extends ZFForm_ParentForm
{
	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init()
	{
		$this->setMethod('post');
		$this->setFormTranslator();
	}

	public function setForm()
	{
		$this->addEmail();
		$this->addSubmitButton('recover');
		$this->setDisplayGroup();
	}
	
	public function addEmail()
	{
		$element = 'emailAddress';
		$opts = array(
				'label'=> $element,
                'required'   => true,
                'filters'    => array('StringTrim'),
                'validators' => array('EmailAddress')
		);
		$this->addElement('text', $element,$opts);
		$this->addDecoratorAndGroup($element);
	}
}