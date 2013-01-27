<?php
/**
 * Form to update the password
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class User_Form_Password extends Zend_Form {
	/**
	 * Init function for form object
	 */
	public function init() {
		//i18n
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');

		$passwordCheck = new ZFForm_Pwdvalidate();

		// Create and configure password element:
		$this->addElement('password', 'password', array(
                        'label'      => 'password',
                        'validators' => array (array('StringLength',false, array(6) )),
                        'translator' => $translator,
                        'required'  => true
		));
		//  Append to the form our custom validator
		$this->getElement('password')->addValidator($passwordCheck);
		$this->addElement('password', 'checkpassword', array(
                        'label'      => 'checkpassword',
                        'validators' => array (array('StringLength',false, array(6) )),
                        'translator' => $translator,
                        'required'  => true
		));
		//  And append it to the other element
		$this->getElement('checkpassword')->addValidator($passwordCheck);
		$this->addElement('submit', 'submit', array(
                              'ignore'   => true,
                              'label'    => 'changePassword',
		));
	}
}
?>
