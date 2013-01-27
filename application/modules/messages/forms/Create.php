<?php
/**
 * @package application.modules
 * @subpackage messages.forms
 * @author jvazquez
 * <p>
 * Form to create messages
 * </p>
 */
class Messages_Form_Create extends Zend_Form {

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init() {
		$this->setMethod('post');
		$translator = Zend_Registry::get('Zend_Translate');

		$this->addElement('text', 'identifier', array (
                'label' 		=> 'msgidentifier',
                'required' 		=> true,
                'filters' 		=> array ('StringTrim'),
                'validators'	=> array ( array ( 'validator' => 'StringLength', 'options' => array (1,30) ) ),
                'description'	=> 'identifierDescription'
                )
                );

                $this->getElement('identifier')->setAttrib('class','inputAccesible')
                ->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator')
                ->setDecorators(array('CustomForm'));

                $this->addElement('select','category',array('id'=>'category','label' => 'msgCategory','required' => true,'description'=>'categoryDescription'));
                $this->getElement('category')->addMultiOption(0," ");
                $this->getElement('category')->addMultiOption( Messages_Model_Messages::ERRTYPE  ,ucfirst( Messages_Model_Messages::ERRTYPE ) );
                $this->getElement('category')->addMultiOption( Messages_Model_Messages::SUCCESSTYPE  ,ucfirst( Messages_Model_Messages::SUCCESSTYPE ) );
                $this->getElement('category')->addMultiOption( Messages_Model_Messages::WARNTYPE   , ucfirst( Messages_Model_Messages::WARNTYPE ));
                $this->getElement('category')->setAttrib('class','inputAccesible')
                ->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator')
                ->setDecorators(array('CustomForm'));

                $this->addElement('checkbox','locked',array('label'=>'deletelocked','required'=>false,'description'=>'lockedDescription'));
                $this->getElement('locked')->setAttrib('class','inputAccesible')
                ->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator')
                ->setDecorators(array('CustomForm'));

                $this->addElement('textarea', 'message', array (
                'label' 		=> 'message',
                'required' 		=> true,
                'filters' 		=> array ('StringTrim'),
                'validators'	=> array ( array ( 'validator' => 'StringLength' ) ),
                'description'	=>'messageDescription'
                )
                );

                $this->getElement('message')->setAttrib('class','inputAccesible')
                ->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator')
                ->setDecorators(array('CustomForm'))
                ->setAttribs(array('rows'=>10,'cols'=>25));

                $this->addElement('submit', 'submit', array ( 'ignore' => true, 'label' => 'save'));
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
?>