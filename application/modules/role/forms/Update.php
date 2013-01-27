<?php
/**
 * Created on Sep 19, 2009 by jvazquez
 * datesite
 * application.modules.role.forms
 * <p>
 * Form to update the role object.
 * It uses Zend Forms
 * </p>
 */
class Role_Form_Update extends Zend_Form {

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

				//	Add the radio button for protected / not protected elements
				$this->addElement('radio','protected');
				$radio = $this->getElement('protected');
				$this->getElement('protected')->addMultiOption(0,"Not Protected");
				$this->getElement('protected')->addMultiOption(1,"Protected");

				$this->addElement('submit', 'submit', array (
			'ignore' => true,
			'label' => 'Update',

				));
	}

	/**
	 *	Activates or deactives the element protected, depending on the state
	 * @param int $state
	 */
	public function toggleState( $state ) {
		if( $state== 1 ) {
			$form->getElement('protected')->setAttrib('disabled','true');  // populate region based on country selection
		}
	}
}
?>
