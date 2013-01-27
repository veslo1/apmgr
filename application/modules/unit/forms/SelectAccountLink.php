<?php
/**
 * Created on March 15, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.controllers
 * <p>
 * Lease wizard to select account link for the bills
 *
 * </p>
 */
class Unit_Form_SelectAccountLink extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');
	}
	 
	public function setForm( $type = null ) {
	  
		// Rent Account Link
		/*
		$this->addElement('select','accountLinkId',array(
		'label' => 'Rent Revenue Account Link: ',
		'required' => true,
		));
		$accountLink = new Financial_Model_AccountLink();
		//foreach ($accountLink->fetchAll() as $al) {
		foreach ($accountLink->getAccountLinkByBillType( $type ) as $al) {
		$this->getElement('accountLinkId')->addMultiOption($al['id'], $al['name']);
		}
		*/

		// Reference Number
		$this->addElement('text', 'referenceNumber', array (
			'label' => 'referencenumber',
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' => array ('validator' => array( 'regex', false, array('/^[0-9]{1,11}$/')))));

		// Comment
		$this->addElement('textarea', 'comment', array (
			'label' => 'comment',
			'required' => false,
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

		//$this->addElement('submit', 'submit', array ('ignore' => true ,'label' => 'createbill'));
		//$submit = $this->getElement('submit');

		$this->addElement('submit', 'previous', array ('ignore' => true,'label' => 'Previous'));
		$this->addElement('submit', 'next', array ('ignore' => true,'label' => 'Next'));


		$this->setDecorators(
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