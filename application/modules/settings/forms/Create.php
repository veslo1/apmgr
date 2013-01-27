<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Settings_Form_Create extends Zend_Form {

	/* (non-PHPdoc)
	 * @see Zend_Form::init()
	 */
	public function init() {
		$this->setMethod('post');
		//	Create the inputs to put the name and the value
		$this->addSettingName();
		$this->addSettingValue();
		$this->addDescription();

		$this->addElement('submit','submit',array ('ignore' => true,'label' => 'save'));
		$this->getElement('submit')->setDecorators(array('ViewHelper', array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')), array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')), array(array('row' => 'HtmlTag'), array('tag'=>'tr'))));
		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
	}

	/**
	 * Add the name of the setting
	 */
	private function addSettingName() {
		$options = array(
						'label'=>'settingName',
						'description'=>'settingDescription',
						'required'=>true ,
						'validators'=> array(
		array('validator'=> 'NotEmpty','breakChainOnFailure' => true),
		array('validator' => 'stringLength','options'=> array(1, 30) )
		)
		);
		$this->addElement('text','name',$options);
		$this->getElement('name')->setAttrib('class','inputAccesible');
		$this->getElement('name')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('name')->setDecorators(array('CustomForm'));

	}

	/**
	 * Add the value for the setting
	 */
	private function addSettingValue() {
		$options = array(
						'label'=>'valueName',
						'description'=>'valueDescription',
						'required'=>true ,
						'validators'=> array(
		array('validator'=> 'NotEmpty','breakChainOnFailure' => true),
		array('validator' => 'stringLength','options'=> array(1, 90) )
		)
		);
		$this->addElement('text','value',$options);
		$this->getElement('value')->setAttrib('class','inputAccesible');
		$this->getElement('value')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('value')->setDecorators(array('CustomForm'));
	}

	/**
	 * Add a brief description
	 */
	private function addDescription() {
		$options = array('label'=>'description','description'=>'description');
		$this->addElement('textarea','description',$options);
		$this->getElement('description')->setAttribs(array('class'=>'inputAccesible','rows'=>10,'cols'=>15));
		$this->getElement('description')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('description')->setDecorators(array('CustomForm'));
	}
}