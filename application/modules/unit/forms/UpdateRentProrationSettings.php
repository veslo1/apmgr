<?php
/**
 * Created on Aug 21, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.forms
 * <p>
 * Create form for unit models
 * </p>
 */
class Unit_Form_UpdateRentProrationSettings extends Zend_Form {
	protected $displayGroupArray;

	public function init() {
		$this->displayGroupArray = array();
		$this->setForm();
	}

	public function setForm() {
		// Set the method for the display form to POST
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');
		 
		$this->addEnabled();
		$this->addRentDueDay();
		$this->addProrationType();
		$this->addProrationApplyMonth();
		$this->addSecondMonthDue();
		$this->addSubmitButton();

		$this->addDisplayGroup( $this->displayGroupArray, 'updateRentProrationSetting',array('legend' => 'rentProrationSettings'));
		$this->getDisplayGroup('updateRentProrationSetting')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));
	}

	/**
	 *  Pushes element to array group
	 */
	private function addToGroup($var){
		array_push( $this->displayGroupArray, $var );
	}

	/**
	 *  Adds Submit button
	 */
	private function addSubmitButton(){
		$element = 'submit';
		$this->addElement($element, 'submit', array( 'ignore'   => true, 'label' => 'save' ));
		$this->getElement($element)->setAttrib('class','submit');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		$this->addToGroup($element);
	}

	private function applyDecorator($element, $inaccessible=false){
		if( $inaccessible )
		$this->getElement($element)->setAttrib('class','inputNotAccesible');
		else
		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
	}

	private function addEnabled() {
		$element = 'prorationEnabled';
		$this->addElement('checkbox',$element,array(
		    'label' => $element,
		    'required' => false,
		));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addRentDueDay() {
		$element = 'rentDueDay';
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => false,
			'filters' => array ( 'StringTrim'),
			'validators' => array ('validator' => array( 'regex', false, array('/^[0-9]{1,2}$/')))));
		$this->applyDecorator($element,true);
		$this->addToGroup($element);
	}

	private function addProrationType() {
		$element = 'prorationType';
		$this->addElement('select',$element,array(
			'label' => $element,
			'required' => true,
		));
		$this->getElement($element)->addMultiOption('actual', $this->getTranslator()->translate('actual'));
		$this->getElement($element)->addMultiOption('thirtyday', $this->getTranslator()->translate('thirtyday'));
		$this->getElement($element)->addMultiOption('year', $this->getTranslator()->translate('year'));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addProrationApplyMonth(){
		$element = 'prorationApplyMonth';
		$this->addElement('select',$element,array(
			'label' => $element,
			'required' => true,
		));
		$this->getElement($element)->addMultiOption('1', '1');
		$this->getElement($element)->addMultiOption('2', '2');
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addSecondMonthDue() {
		$element = 'secondMonthDue';
		$this->addElement('checkbox',$element,array(
		    'label' => $element,
		    'required' => false,
		));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}
}
?>
