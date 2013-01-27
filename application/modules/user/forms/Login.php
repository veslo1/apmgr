<?php
/**
 * Created on Sep 26, 2009 by jvazquez
 * @name datesite
 * @package application.modules.user.forms
 * <p>
 * Form to login into the application
 * </p>
 */
class User_Form_Login extends ZFForm_ParentForm {

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init() {		
		$this->setMethod('post');
		$this->setLegend('login');
		$this->displayGroupArray = array();  // this is needing to be set here for some reason - isn't hitting parent constructor.  an explicit parent call loops and kills the system so using this terrible hack
		$this->setForm();
	}
	
	public function setForm() {
		//$translator = Zend_Registry::get('Zend_Translate');

		// Set the method for the display form to POST
		

		$this->addUsername();
                $this->addLogin();		

		// Add the submit button
		/*$this->addElement('submit', 'submit', array( 'ignore'   => true, 'label'    => 'login') );
		$this->getElement('submit')->setDecorators(
		array(
                'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		//		$this->addDisplayGroup(array('username', 'password'), 'userCredentials');
		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
		*/
		
		$this->addSubmitButton('login');
	  
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
	}
	
	private function addUsername() {
		$element = 'username';
		$this->addElement('text', $element, array(
                'label'      	=> 'username',
                'validators' 	=>  array(
                        'alnum',
		array('regex', false, array('/^[a-z]+/')),
		array('stringLength', false, array(1, 20))
		),
                'required'  	=>  true,
                'filters'   	=>  array('StringToLower')
		//'description'	=>	'descriptionUsername'
		)
		);
		//	Now we use our own decorators
		//$this->getElement('username')->setAttrib('class','inputAccesible');
		//$this->getElement('username')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		//$this->getElement('username')->setDecorators(array('CustomForm'));
		$this->addDecoratorAndGroup( $element );
	}
	
	private function addLogin() {
		$element = 'password';
		$this->addElement('password', $element, array(
                'label'		=> 'password',
                'validators' 	=> array ( array('StringLength',false, array(6) ) ),
                'required'  	=> true
		//'description'	=> 'descriptionPassword'
		));
		//$this->getElement('password')->setAttrib('class','inputAccesible');
		//$this->getElement('password')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		//$this->getElement('password')->setDecorators(array('CustomForm'));
		$this->addDecoratorAndGroup( $element );
	}

}
?>
