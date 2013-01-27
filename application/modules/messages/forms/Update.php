<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Form to Update Messages</p>
 */
class Messages_Form_Update extends Zend_Form {

	public function init() {
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');
		//	The hidden id
		$this->addElement( 'hidden', 'id', array ('required' => false) );

		$this->addElement('text', 'identifier', array (
                'label'			=> 'msgidentifier',
                'required'		=> true,
                'filters' 		=> array ('StringTrim'),
                'validators'	=> array (
		array (
                                'validator' => 'StringLength',
                                'options' 	=> array (1,15)
		)
		)
		)
		);

		$this->getElement('identifier')->setAttrib('class','inputAccesible')
		->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator')
		->setDecorators(array('CustomForm'));

		$this->addElement('checkbox','locked',array('label'=>'deletelocked','required'=>false));
		$this->getElement('locked')->setAttrib('class','inputAccesible')
		->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator')
		->setDecorators(array('CustomForm'));

		$this->addElement('textarea', 'message', array (
                'label' 		=> 'msgCategory',
                'required' 		=> true,
                'filters' 		=> array ('StringTrim'),
                'validators' 	=> array ( array ( 'validator' => 'StringLength' ) )
		)
		);

		$this->getElement('message')->setAttrib('class','inputAccesible')
		->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator')
		->setDecorators(array('CustomForm'))
		->setAttribs(array('rows'=>10,'cols'=>25));

		$this->addElement('submit', 'submit', array ( 'ignore' => true, 'label' => 'Save'));
		$this->getElement('submit')->setDecorators(
		array(
                'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
	}
}