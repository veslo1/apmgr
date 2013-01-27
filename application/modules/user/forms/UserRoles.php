<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.forms
 * @filesource
 */
class User_Form_UserRoles extends Zend_Form {
	/**
	 * Init function for form object
	 */
	public function init() {
		//i18n
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');

		$this->addElement('multiselect','role_id',array(
                                                    'label' => 'userrole',
                                                    'required' => true,
                                                    'translator'=>$translator
		)
		);

		$role = new Role_Model_Role();
		foreach ($role->fetchAll() as $roleData) {
			$this->getElement('role_id')->addMultiOption($roleData->getId(), $roleData->getName());
		}
		$this->addElement('submit', 'submit', array(
                'ignore'   => true,
                'label'    => 'changeRole',
		));
	}
}
?>