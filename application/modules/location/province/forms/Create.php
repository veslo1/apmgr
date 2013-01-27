<?php
/**
 * Created on Sep 21, 2009 by jvazquez
 * @name datesite
 * @package application.modules.region.forms
 * <p>
 * Form to create a region
 * </p>
 */
class Province_Form_Create extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		$this->addElement('text', 'name', array (
			'label' => 'Name:',
			'required' => true,
			'filters' => array (
				'StringTrim'
				),
			'validators' => array (array ('validator' => 'StringLength','options' => array (3,90)))));

				$this->addElement('select','countryId',array(
			'label' => 'Country',
			'required' => true,
				));
				//	TODO Make a configurable option out of this.
				$country = new Country_Model_Country();
				foreach ($country->fetchAll() as $c) {
					$this->getElement('countryId')->addMultiOption($c->getId(), $c->getName());
				}

				$this->addElement('submit', 'submit', array ('ignore' => true,'label' => 'Save',));
	}
}
?>
