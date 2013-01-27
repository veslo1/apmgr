<?php
/**
 * Created on Apr 2, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Controller class for unit, update page
 * </p>
 */

class Unit_Form_CancelLease extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');				
		
		$element = 'cancellationLastDay';
		$this->addElement('text', $element, array(
                    'label'	 => $element,
                    'required'   => true,
                    'filters'    => array('StringTrim'),
	            'readonly' => true
		));
	  
		$dateCheck = new ZFForm_Datevalidate();
		$this->getElement($element)->addValidator($dateCheck);
		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		
		$element2 = 'cancelComment';
		$this->addElement('textarea', $element2, array (
			'label' => 'cancelComment',
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,500)))));
		
		$this->getElement($element2)->setAttrib('class','inputAccesible');
		$this->getElement($element2)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element2)->setDecorators(array('FieldsetForm'));
		
		$button = 'submit';
		$this->addElement($button, $button, array ('ignore' => true,'label' => 'Cancel Lease'));
		$this->getElement($button)->setAttrib('class','submit');
		$this->getElement($button)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($button)->setDecorators(array('FieldsetForm'));
		
		$displayGroupArray = array();
		array_push( $displayGroupArray, $element );
		array_push( $displayGroupArray, $element2 );
		array_push( $displayGroupArray, $button );
		
		$this->addDisplayGroup($displayGroupArray,'cancelLease',array('legend' => 'cancelLease'));

		$this->getDisplayGroup('cancelLease')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));
	}
}