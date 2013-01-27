<?php
/**
 * Form to allow the user to join
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class User_Form_Join extends ZFForm_ParentForm {

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init() {		
	}

	/**
	 * Init this form
	 */
	public function setForm() {		
		$this->addFirstName();
		$this->addLastName();
		$this->addEmail();
		$this->addUserName();
		$this->addPassword();
		$this->addCaptcha();
		$this->addSubmitButton('join');
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
		// And finally add some CSRF protection
		//		$this->addElement('hash', 'csrf', array('ignore' => true));
	}
	/**
	 * Add the element firstName
	 */
	private function addFirstName() {
		$element = 'firstName';
		$this->addElement(
				'text', $element, array(
                'label' => $element,
                'required'  => true,
                'filters'  => array('StringTrim'),
                'validators' => array('Alpha'))
		);
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 * Add the last name
	 */
	private function addLastName() {
		$element = 'lastName';
		$this->addElement('text', $element, array(
                'label'      => $element,
                'required'   => true,
                'filters'    => array('StringTrim'),
                'validators' => array('Alpha')));
		$this->addDecoratorAndGroup($element);
	}

	/**
	 * Add the email
	 */
	private function addEmail() {
		$element = 'emailAddress';
		$this->addElement('text', $element, array(
                'label'      => $element,
                'required'   => true,
                'filters'    => array('StringTrim'),
                'validators' => array('EmailAddress')
		));
		$this->addDecoratorAndGroup($element);
	}

	/**
	 * Add the UserName
	 */
	private function addUserName() {
		$element ='username';
		$this->addElement('text', $element, array(
                		  'label' => $element,
                		  'validators'=>array('alnum',array('regex', false, array('/^[a-z]+/')),
		array('stringLength', false, array(3, 20))
		),
                		'required'  =>  true,
                		'filters'   =>  array('StringToLower')) );
		$this->addDecoratorAndGroup($element);
	}

	/**
	 * Create and configure password element
	 */
	private function addPassword() {
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
	 * Add a captcha that uses Gd to generate a challenge
	 */
	private function addCaptcha() {
		$element ='captcha';
		//var_dump( APPLICATION_PATH ); die;
		//var_dump( APPLICATION_PATH.'/../../public_html/fonts/VeraMoBI.ttf' ); die;
		$captchaImageOptions = array(
						'captcha' => 'Image',
                        			'font'	  => realpath(APPLICATION_PATH.'/../../public_html/fonts/VeraMoBI.ttf'),
                        			'imgDir'  => realpath(APPLICATION_PATH.'/../../public_html/fonts/image/captcha'),
                        			'imgUrl'  => '/fonts/image/captcha',
                        			'wordLen' => 4,
                        			'timeout' => 300,
									'dotnoiselevel'=>0,
									'width'=>256,
									'height'=>64,
									'fontsize'=>24,
									'class'=>'captchaelement'
			
		);
		
		$captchaOptions = array('label' => 'captchainstruction',
                				'required'   => true,
                				'captcha'    => $captchaImageOptions,
								
		);
		$this->addElement('captcha', $element,$captchaOptions);
		$this->addDecoratorAndGroup($element);
	}
}
?>