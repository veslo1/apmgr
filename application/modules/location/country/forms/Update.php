<?php
class Country_Form_Update extends Zend_Form {
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
                              'label'    => 'Edit Country',
		));

		// And finally add some CSRF protection
		$this->addElement('hash', 'csrf', array(
                              'ignore' => true,
		));
	}

}
?>
