<?php
//  User links the actions of the program to accounts so he knows rent payments go to xxx account
class Financial_Form_CreateAccountLink extends Zend_Form {
	public function init() {
	}

	public function setForm() {
		$translator = Zend_Registry::get('Zend_Translate');
		 
		// Set the method for the display form to POST
		$this->setMethod('post');

		// account name
		$this->addElement('text', 'name', array (
			'label' => 'accountName',			
			'readonly' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));		
		$this->getElement('name')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('name')->setDecorators(array('FieldsetForm'));
		$this->getElement('name')->setAttrib('class','inputNotAccesible');

		 
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
		    'name',		     
		    'debitAccountId',
		    'creditAccountId',				    
		    'submit',
                    'csrf' 
                    ),'createAccountTransaction',array('legend' => $this->getLegend()));

                    $this->getDisplayGroup('createAccountTransaction')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
                    ));

	}
}
?>
