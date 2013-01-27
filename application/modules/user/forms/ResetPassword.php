<?php
/**
 * Implementation of the reset password Form
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package user.forms
 */

class User_Form_ResetPassword extends ZFForm_ParentForm
{
	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init()
	{
		$this->setFormTranslator();
		$this->setMethod('post');
	}

	public function setForm()
	{
		$this->addPassword();
		$this->addCaptcha();
		$this->addSubmitButton('reset');
		$this->setLegend('resetPassword');
		$this->setDisplayGroup();
	}

	/**
	 * Adds the password element
	 */
	public function addPassword()
	{
		$element = 'password';
		$repassword= 'password2';
		$elementOptions =  array('label'=> $element,'validators' => array (array('StringLength',false, array(6))),'required'=>true);
		$repasswordOptions = array('label'=>$element,'description'=>'password2Desc','required'=>true);
		$this->addElement($element, $element,$elementOptions);
		$this->addElement($element,$repassword,$repasswordOptions);
		$validateEqual = new Zend_Validate_Identical(Zend_Controller_Front::getInstance()->getRequest()->getParam('password'));
		$this->getElement($repassword)->addValidator($validateEqual);
		$this->addDecoratorAndGroup($element);
		$this->addDecoratorAndGroup($repassword);
	}

	/**
	 * Add a captcha that uses the image
	 */
	public function addCaptcha() {
		$element ='captcha';
		$captchaImageOptions = array(
									'captcha' => 'Image',
                        			'font'	  => realpath(APPLICATION_PATH.'/../public/fonts/VeraMoBI.ttf'),
                        			'imgDir'  => realpath(APPLICATION_PATH.'/../public/fonts/image/captcha'),
                        			'imgUrl'  => '/fonts/image/captcha',
                        			'wordLen' => 4,
                        			'timeout' => 300,
									'dotnoiselevel'=>0,
									'width'=>256,
									'height'=>64,
									'fontsize'=>24
			
		);
		$captchaOptions = array('label' => 'captchainstruction',
                				'required'   => true,
                				'captcha'    => $captchaImageOptions);
		$this->addElement('captcha', $element,$captchaOptions);
		$this->addDecoratorAndGroup($element);
	}
}