<?php
/**
 * Created on Sep 13, 2009
 * create.php
 * @author jvazquez
 * @package application.modules.role.forms
 */
class Role_Form_Search extends Zend_Form {

	public function init() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		$this->addElement('text', 'name', array (
			'label' => 'Name:',
			'required' => true,
			'filters' => array (
				'StringTrim'
				),
			'validators' => array (
				array (
					'validator' => 'StringLength',
					'options' => array (1,10)
				)
				)
				));

				$this->addElement('submit', 'submit', array (
			'ignore' => true,
			'label' => 'Search',
					
				));
	}
}
?>
