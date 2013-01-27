<?php
/**
 * Created on February 11, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.controllers
 * <p>
 * Create form for the user to enter bills - crude and preliminary
 * For
 * </p>
 */
class Financial_Form_CreateBill extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		// Account Link
		$this->addElement('select','accountLinkId',array(
			'label' => 'Account Link: ',
			'required' => true,
		));
		$accountLink = new Financial_Model_AccountLink();
		foreach ($accountLink->fetchAll() as $al) {
			$this->getElement('accountLinkId')->addMultiOption($al->getId(), $al->getName());
		}
		// originalAmountDue
		$this->addElement('text', 'originalAmountDue', array (
			'label' => 'Bill Amount: ',
			'required' => true,
			'filters' => array ( 'StringTrim'),
			'validators' => array ('validator' => array( 'regex', false, array('/^\d+(\.\d{1,2})?$/')))));

		// Due Date
		$this->addElement('text', 'dueDate', array(
		     'label' => 'Due Date: ',
		     'required'   => true,
		     'filters'    => array('StringTrim'),
		     'validators' => array(
		array('validator' => 'StringLength', 'options' => array(10,10)),
		array('validator' => 'Date', 'options'=>array('format'=>'Y-m-d'))
		)));

		// Reference Number
		$this->addElement('text', 'referenceNumber', array (
			'label' => 'referencename',
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));
		 

		// sets decorators for form elements added to this point
		$this->setElementDecorators(array(
			'ViewHelper',
			'Errors',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array( 'Label', array('tag' => 'td'), array( array('row' => 'HtmlTag'), array('tag' => 'tr') ) ),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		));

		$this->addElement('submit', 'submit', array ('ignore' => true ,'label' => 'createbill'));
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