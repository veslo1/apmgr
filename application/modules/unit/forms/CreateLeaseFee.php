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
class Unit_Form_CreateLeaseFee extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setLegend( 'createLeaseFee' );
	}
	 
	public function setForm( $param ) {

		// pos zend forms lol
		$this->addElement('select', 'newfee', array (
			'label' => 'fee' ));	    		    

		if( $param )  {
			foreach ( $param as $id=>$fee )
			$this->getElement('newfee')->addMultiOption($fee->getId(), $fee->getName() . ' - ' . $fee->getAmount() );
		}
		$this->getElement('newfee')->setAttrib('class','inputAccesible');
		$this->getElement('newfee')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('newfee')->setDecorators(array('FieldsetForm'));

		$this->addElement('text', 'dueDate', array(
                'label'		 => "dueDate",
                'required'   => true,
                'filters'    => array('StringTrim'),
	        'readonly' => true
		));
	  
		$dateCheck = new ZFForm_Datevalidate();
		$this->getElement('dueDate')->addValidator($dateCheck);
		$this->getElement('dueDate')->setAttrib('class','inputAccesible');
		$this->getElement('dueDate')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('dueDate')->setDecorators(array('FieldsetForm'));

		$this->addElement('submit', 'submit', array ('ignore' => true,'label' => 'save'));
		$this->getElement('submit')->setAttrib('class','submit');
		$this->getElement('submit')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('submit')->setDecorators(array('FieldsetForm'));
	  
		$this->addDisplayGroup(array(
                    'newfee',
		    'dueDate',		    
		    'submit'
        
		    ),'createLeaseFee',array('legend' => $this->getLegend()));

		    $this->getDisplayGroup('createLeaseFee')->setDecorators(array(
                    'FormElements',
                    'Fieldset'                    
                    ));
	}
}
?>