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
class Unit_Form_CreateLeaseDeposit extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setLegend( 'createLeaseDeposit' );
	}
	 
	public function setForm( $param ) {

		// pos zend forms lol
		$this->addElement('select', 'newdeposit', array (
			'label' => 'deposit' ));	    		    

		if( $param )  {
			foreach ( $param as $id=>$deposit )
			$this->getElement('newdeposit')->addMultiOption($deposit->getId(), $deposit->getName() . ' - ' . $deposit->getAmount() );
		}
		$this->getElement('newdeposit')->setAttrib('class','inputAccesible');
		$this->getElement('newdeposit')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('newdeposit')->setDecorators(array('FieldsetForm'));
	  

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
                    'newdeposit',
		    'dueDate',		    
		    'submit'
        
		    ),'createLeaseDeposit',array('legend' => $this->getLegend()));

		    $this->getDisplayGroup('createLeaseDeposit')->setDecorators(array(
                    'FormElements',
                    'Fieldset'                    
                    ));
	}
}
?>