<?php
class City_Form_Update extends Zend_Form {
	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		// Add an email element
		$this->addElement('text', 'name', array(
                              'label'      => 'City Name:',
                              'required'   => true,
                              'filters'    => array('StringTrim'),
                              'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)) )
		));

		$this->addElement('select','countryId',array(
		    'id'=>'countryId',
			'label' => 'Country',
			'required' => true,
		));


		//	TODO Make a configurable option out of this.
		$country = new Country_Model_Country();

		$this->getElement('countryId')->addMultiOption(0,'');
		foreach ($country->fetchAll() as $c) {
			$this->getElement('countryId')->addMultiOption($c->getId(), $c->getName());
		}

		$this->getElement('countryId')->setAttrib('onchange','FillRegion()');  // populate region based on country selection

		$this->addElement('select','provinceId',array(
		    'id'=>'provinceId',
			'label' => 'Province',
			'required' => true,
		));

		$this->provinceId->setRegisterInArrayValidator(false);

		// Add the submit button
		$this->addElement('submit', 'submit', array(
                              'ignore'   => true,
                              'label'    => 'Update City',
		));

		// And finally add some CSRF protection
		$this->addElement('hash', 'csrf', array(
                              'ignore' => true,
		));
	}

}
?>
