<?php
/**
 *
 * Simple form to display if the user will delete his information or not
 * @author jvazquez
 *
 */
class Applicant_Form_ConfirmDeleteInfo extends ZFForm_ParentForm {

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init(){}

	public function setForm()
	{
		$this->setMethod('post');
		$this->addRadioButtons();
		$this->addSubmitButton();
		$this->setLegend('deleteInfo');
		$this->setFormTranslator();
		$this->setDisplayGroup();
	}

	private function addRadioButtons(){
		$options = array('label'=>'deleteInfoConfirmation','required'=>true);
		$this->addElement('radio','deleteInfo',$options);
		$options = array_reverse(parent::$answer);
		foreach($options as $id=>$value){
			$this->getElement('deleteInfo')->addMultiOption($id,$value);
		}
		$this->applyDecorator('deleteInfo');
		$this->addToGroup('deleteInfo');
	}
}