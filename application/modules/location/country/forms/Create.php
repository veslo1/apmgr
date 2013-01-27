<?php
class Country_Form_Create extends Zend_Form {
	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		// Add an email element
		$this->addElement('text', 'name', array(
                              'label'      => 'Country Name:',
                              'required'   => true,
                              'filters'    => array('StringTrim'),
                               'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)) )
		));

		// Add the submit button
		$this->addElement('submit', 'submit', array(
                              'ignore'   => true,
                              'label'    => 'Create Country',
		));

		// And finally add some CSRF protection
		$this->addElement('hash', 'csrf', array(
                              'ignore' => true,
		));
	}

}
?>
