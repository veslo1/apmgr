<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Applicant_Form_UpdateSetting extends Zend_Form {

	public function init() {
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setTranslator($translator);
		$this->setMethod('post');

		$options = array('label' => 'disabled','required' => true,'multiple'=>false);
		$this->addElement('select','disabled',$options);
		$this->getElement('disabled')->addMultiOption(1, $translator->_('enabled'));
		$this->getElement('disabled')->addMultiOption(0, $translator->_('disabled'));
		$this->getElement('disabled')->setAttrib('class','inputAccesible');
		$this->getElement('disabled')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('disabled')->setDecorators(array('CustomForm'));

		$options = array(
						'label'=>'valueName',
						'description'=>'valueDescription',
						'required'=>true ,
						'validators'=>
		array(
		array('validator'=> 'NotEmpty','breakChainOnFailure' => true),
		array('validator' => 'stringLength','options'=> array(1, 90) )
		)
		);
		$this->addElement('text','value',$options);
		$this->getElement('value')->setAttrib('class','inputAccesible');
		$this->getElement('value')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('value')->setDecorators(array('CustomForm'));

		$this->addElement('submit','submit',array ('ignore' => true,'label' => 'save'));
		$this->getElement('submit')->setDecorators(array('ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
	}
}