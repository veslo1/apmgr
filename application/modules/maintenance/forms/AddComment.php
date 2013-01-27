<?php
/**
 * Created on March 2, 2010 by rnelson
 * @name apmgr
 * @package application.modules.maintenance.controllers
 * <p>
 * Create form for the user to enter comments
 * </p>
 */
class Maintenance_Form_AddComment extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');
			
		// comment
		$this->addElement('textarea','comment', array(
								  'label' => 'comment',
								  'rows' => '15',
								  'required' => true,
								  'filters' => array ( 'StringTrim' ),
								  'validators' => array (
		array (
												'validator' => 'StringLength',
												'options' => array (1,1000))))
		);
		 

		// sets decorators for form elements added to this point
		$this->setElementDecorators(array(
			'ViewHelper',
			'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array( 'Label', array('tag' => 'td'), array( array('row' => 'HtmlTag'), array('tag' => 'tr') ) ),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		));

		$this->addElement('submit', 'submit', array ('ignore' => true ,'label' => 'addComment'));
		$submit = $this->getElement('submit');
		$submit->setDecorators(
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