<?php
/**
 * Implementation of the form Forgot Password
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.user.form
 */
class User_Form_ForgotPassword extends ZFForm_ParentForm
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
		$this->addUserName();
		$this->addEmail();
		$this->addCaptcha();
		$this->addSubmitButton('recover');
		$this->setDisplayGroup();
	}

	public function addUserName()
	{
		$opts =  array(
                'label'      	=> 'username',
                'validators' 	=>  array('alnum',array('regex', false, array('/^[a-z]+/')),array('stringLength', false, array(1, 20))),
                'required'  	=>  true,
                'filters'   	=>  array('StringToLower')
		);
		$element = 'username';
		$this->addElement('text', $element,$opts);
		$this->addDecoratorAndGroup($element);
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
