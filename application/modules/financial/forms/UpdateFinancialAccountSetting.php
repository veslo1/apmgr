<?php
class Financial_Form_UpdateFinancialAccountSetting extends Zend_Form {
	protected $displayGroupArray;
	protected $translator;

	public function init() {
		$this->displayGroupArray = array();
		$this->translator = Zend_Registry::get('Zend_Translate');
		$this->setTranslator($this->translator);
		$this->setLegend('updateFASetting');
		$this->setForm();
	}

	public function setForm() {
		$translator = Zend_Registry::get('Zend_Translate');
		// Set the method for the display form to POST
		$this->setMethod('post');

		$this->addSettingName(); // read only
		$this->addSettingDescription(); // read only
		$this->addAccount(); // editable
		$this->addSubmitButton();

		$this->addDisplayGroup( $this->displayGroupArray, 'updateFinancialAccountSetting',array('legend' => $this->getLegend()));
		$this->getDisplayGroup('updateFinancialAccountSetting')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));
	}

	private function addToGroup($var){
		array_push( $this->displayGroupArray, $var );
	}

	private function applyDecorator($element){
		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
	}

	private function applyDecoratorInaccessible($element){
		$this->getElement($element)->setAttrib('class','inputNotAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
	}

	/**
	 *  Adds Submit button
	 */
	private function addSubmitButton(){
		$element = 'submit';
		$this->addElement($element, $element, array ('ignore' => true, 'label' => 'save','translator'=>$this->getTranslator()));
		$this->getElement($element)->setAttrib('class','submit');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		$this->addToGroup($element);
	}

	/**
	 *  Adds setting name element
	 */
	private function addSettingName() {
		$element = 'settingName';
		$this->addElement('text', $element, array(
                              'label'      => $element,
                              'required'   => false,
			      'readOnly'=>true,
			      'translator'=>$this->getTranslator(),
			      'size'=>50
		));
		$this->applyDecoratorInaccessible($element);
		$this->addToGroup($element);
	}

	/**
	 *  Adds setting description element
	 */
	private function addSettingDescription() {
		$element = 'description';
		$this->addElement('text', $element, array(
                              'label'      => 'description',
                              'required'   => false,
			      'readOnly'=>true,
			      'validators' => array (array ('validator' => 'StringLength','options' => array (1,50))),
			      'translator'=>$this->getTranslator(),
			      'size'=>50
		));
		$this->applyDecoratorInaccessible($element);
		$this->addToGroup($element);
	}

	private function addAccount(){
		$element = 'accountId';
		$this->addElement('select',$element,array(
			'label' => 'accountName',
			'required' => true,
		));
			
		$account = new Financial_Model_Account();
		$this->getElement($element)->addMultiOption( NULL, '--select--' );
		foreach ($account->fetchAll() as $a)
		$this->getElement($element)->addMultiOption( $a->getId(), $a->getName() );

		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	public function populateValues( $values ){
		$values['settingName'] = $this->translator->translate($values['settingName']);
		$values['description'] = $this->translator->translate($values['description']);
		$this->populate($values);
	}

}
?>
