<?php
/**
 * Created on Sep 20, 2009 by jvazquez
 * datesite
 * application.modules.permission.forms
 * <p>
 * Extends Zend form object and creates a form
 * </p>
 */

class Permission_Form_Update extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		$this->addElement('text', 'alias', array (
													'label' 	=> 'aliasHeader',
													'required' 	=> true,
													'validators' => array (
		array (
																					'validator' => 'StringLength',
																					'options' 	=> array (1,50)
		)
		)
		)
		);
		$this->getElement('alias')->setAttrib('class','inputAccesible');
		$this->getElement('alias')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('alias')->setDecorators(array('CustomForm'));

		$this->addElement('submit', 'submit', array ('ignore' => true,'label' => 'save'));
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
