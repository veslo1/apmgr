<?php
/**
 * Created on Sep 13, 2009
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Role_Form_Create extends ZFForm_ParentForm  {

	/* (non-PHPdoc)
	 * @see Zend_Form::init()
	 */
	public function init(){}

	/**
	 * Initialize the form configuration
	 */
	public function setForm() {
		$this->setMethod('post');
		$this->addRoleName();
		$this->addRadioButtons();
		$this->addSubmitButton();
		$this->setDisplayGroup();
	}

	/**
	 * Add the input for the name
	 */
	protected function addRoleName(){
		$name = 'name';
		$validators = array ( array('validator'=>'StringLength','options' => array (1,250) )
							);
		$elementOptions =array ('label' => 'rolename',
								'required' => true,
								'filters' => array ('StringTrim','StripNewlines','StripTags','Alpha'),
								'validators' => $validators
								);
		$this->addElement('text', $name,$elementOptions);
		$this->addDecoratorAndGroup( $name, false );
	}

	/**
	 * Add the radio buttons
	 */
	protected function addRadioButtons(){
		$name = 'protected';
		$this->addElement('radio',$name);

		$this->getElement($name)->addMultiOption(0,"notprotected")
		->addMultiOption(1,"protected");
		$this->addDecoratorAndGroup( $name, false);
	}
}
?>
