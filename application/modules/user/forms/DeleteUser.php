<?php
/**
 * Displays a form with a confirm question
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @package application.modules.user.forms
 */
class User_Form_DeleteUser extends ZFForm_ParentForm
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
		$this->setLegend('deleteUser');
		$this->addQuestion();
		$this->addDescription();
		$this->addSubmitButton('accept');
		
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
	}
	
	public function addDescription()
	{
		$element = 'description';
		$options = array(
							'label'=>'description',
                   			'required'=>true,		   			
                   			'validators' =>  array( array('stringLength', false, array(10, 1000) )	),
							'description'=>'disableEnableDescription'
		);
		$this->addElement('textarea',$element,$options);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		//$this->addToGroup($element);
		$this->addDecoratorAndGroup( $element );
	}
	
	public function addQuestion()
	{
		$element = 'confirm';
		$options = array('label'=>'confirmDelete','required'=>true,'listsep'=>'');
		$this->addElement('radio',$element,$options);
		$this->getElement($element)->addMultiOption('0','no')
			 		   ->addMultiOption('1','yes');
		$this->getElement($element)->setAttrib('label_class','list');			   
		$this->addDecoratorAndGroup( $element );				   
	}
}