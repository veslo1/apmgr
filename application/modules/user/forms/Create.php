<?php
/**
 *
 * Displays a form that allows the user to create another user
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.forms
 */
class User_Form_Create extends ZFForm_ParentForm
{
	/**
	 * State that represents that this form is in update mode
	 * @var boolean
	 */
	private $mode;

	/**
	 * Toggles between insert and update labels
	 * @param boolean $state
	 */
	public function setUpdateMode($state)
	{
		$this->mode = $state;
	}

	public function init()
	{
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setFormTranslator();
	}

	public function setForm()
	{
		$this->addFirstName();
		$this->addLastName();
		$this->addEmailAddress();
		$this->addUserName();
		$this->addPassword();
		$this->addRole();
		if( $this->mode == true )
		{
			$this->addSubmitButton('updateUser');
			$this->setLegend('updateUserLabel');
		}
		else
		{
			$this->addSubmitButton('createaUser');
			$this->setLegend('createUserLabel');
		}
		$this->setDisplayGroup();
	}
	/**
	 * Adds the first name input
	 */
	public function addFirstName()
	{
		$options = array(
                'label'      => 'firstName',
                'required'   => true,
                'filters'    => array('StringTrim'),
                'validators' => array('Alpha'),
		);
		$element = 'firstName';
		$this->addElement('text',$element,$options);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Adds the lastname element
	 */
	public function addLastName()
	{
		$options = array(
                'label'      => 'lastName',
                'required'   => true,
                'filters'    => array('StringTrim'),
                'validators' => array('Alpha')
		);
		$element = 'lastName';
		$this->addElement('text',$element,$options);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *
	 * Adds the email input
	 */
	public function addEmailAddress()
	{
		$options = array(
                'label'      => 'email',
                'required'   => true,
                'filters'    => array('StringTrim'),
                'validators' => array('EmailAddress')
		);
		$element =  'emailAddress';
		$this->addElement('text',$element,$options);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Adds the username input
	 */
	public function addUserName()
	{
		$element = 'username';
		$options = array(
                'label'      => 'username',
                'validators' =>  array('alnum',array('regex',false,array('/^[a-z]+/') ),array('stringLength', false, array(3, 20))),
                'required'  =>  true,
                'filters'   =>  array('StringToLower')
		);
		$this->addElement('text',$element,$options);
		$this->applyDecorator($element);
		$this->addToGroup($element);
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
	 * Addd's a select box that is filled in with roles
	 */
	public function addRole()
	{
		$element = 'roleId';
		$options = array('label'=>'userrole','required'=>true,'listsep'=>'');
		$this->addElement('radio',$element,$options);
		$role = new Role_Model_Role();
		foreach ($role->fetchAll() as $roleData)
		{
			$this->getElement($element)->addMultiOption($roleData->getId(), $roleData->getName());
		}
		$this->getElement($element)->setAttrib('label_class','list');
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}
}
?>
