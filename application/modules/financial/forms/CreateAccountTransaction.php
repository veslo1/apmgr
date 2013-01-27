<?php
/**
 * Created on April 29, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.controllers
 * <p>
 * Enter individual account transactions
 * </p>
 */
class Financial_Form_CreateAccountTransaction extends Zend_Form {
	public function init() {
		$translator = Zend_Registry::get('Zend_Translate');
		// Set the method for the display form to POST
		$this->setMethod('post');

		$this->setLegend( 'createAccountTransaction' );

		$this->addElement('text', 'datePosted', array(
            'label'		 => "datePosted",
            'required'   => true,
            'filters'    => array('StringTrim'),
	    'readonly' => true
		));
	  
		$dateCheck = new ZFForm_Datevalidate();
		$this->getElement('datePosted')->addValidator($dateCheck);
		$this->getElement('datePosted')->setAttrib('class','inputAccesible');
		$this->getElement('datePosted')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('datePosted')->setDecorators(array('FieldsetForm'));
		 
		// Name of the link account such as rents

		// Debit Account
		$this->addElement('select','debitAccountId',array(
			'label' => 'debitAccount',
			'required' => true,
		));
		$account = new Financial_Model_Account();

		foreach ($account->fetchAll() as $a) {
			$this->getElement('debitAccountId')->addMultiOption( $a->getId(), $a->getName() );
		}
		$this->getElement('debitAccountId')->setAttrib('class','inputAccesible');
		$this->getElement('debitAccountId')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('debitAccountId')->setDecorators(array('FieldsetForm'));

		// Credit Account
		$this->addElement('select','creditAccountId',array(
			'label' => 'creditAccount',
			'required' => true,
		));

		foreach ($account->fetchAll() as $a) {
			$this->getElement('creditAccountId')->addMultiOption( $a->getId(), $a->getName() );
		}

		$this->getElement('creditAccountId')->setAttrib('class','inputAccesible');
		$this->getElement('creditAccountId')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('creditAccountId')->setDecorators(array('FieldsetForm'));

		// Amount
		$this->addElement('text', 'amount', array (
			'label' => 'amount',
			'required' => true,
			'filters' => array ( 'StringTrim'),
			'validators' => array ('validator' => array( 'regex', false, array('/^\d+(\.\d{1,2})?$/')))));

		$this->getElement('amount')->setAttrib('class','inputAccesible');
		$this->getElement('amount')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('amount')->setDecorators(array('FieldsetForm'));

		$this->addElement('textarea', 'comment', array(
            'label'		 => 'comment',
            'required'   => true,
            'filters'    => array('StringTrim'),	    
		));


		$this->getElement('comment')->setAttrib('class','inputAccesible');
		$this->getElement('comment')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('comment')->setDecorators(array('FieldsetForm'));

		// Add the submit button
		$this->addElement('submit', 'submit', array(
                              'ignore'   => true,                             
			      'label'    => 'save',
		));
		$this->getElement('submit')->setAttrib('class','submit');
		$this->getElement('submit')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('submit')->setDecorators(array('FieldsetForm'));


		// And finally add some CSRF protection
		$this->addElement('hash', 'csrf', array(
                              'ignore' => true,                                                           
		));

		$this->addDisplayGroup(array(
                    'datePosted',
		    'debitAccountId',
		    'creditAccountId',
		    'amount',
		    'comment',
		    'submit'        
		    ),'createAccountTransaction',array('legend' => $this->getLegend()));

		    $this->getDisplayGroup('createAccountTransaction')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		    ));
	}
}
?>
