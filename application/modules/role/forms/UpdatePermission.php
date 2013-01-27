<?php
/**
 * Created on August 24, 2010 by rnelson
 * @name apmgr
 * @package application.modules.role.forms
 * <p>
 * Update form for role permissions
 * </p>
 */
class Role_Form_UpdatePermission extends Zend_Form {
	protected $displayGroupArray;

	public function init() {
		$this->displayGroupArray = array();
		$this->setForm();
		//$this->populateCheckboxes();
	}

	public function setForm() {
		// Set the method for the display form to POST
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');

		$this->addRoles();
		$this->addSubmitButton();

		$this->addDisplayGroup( $this->displayGroupArray, 'updatePermission',array('legend' => 'updatePermission'));
		$this->getDisplayGroup('updatePermission')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		));
	}

	/**
	 *  Pushes element to array group
	 */
	private function addToGroup($var){
		array_push( $this->displayGroupArray, $var );
	}

	/**
	 *  Adds Submit button
	 */
	private function addSubmitButton(){
		$element = 'submit';
		$this->addElement($element, 'submit', array( 'ignore'   => true, 'label' => 'save' ));
		$this->getElement($element)->setAttrib('class','submit');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		$this->addToGroup($element);
	}

	private function applyDecorator($element){
		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
	}

	private function addRoles() {
		// Roles
		$rolesObj = new Role_Model_Role();
		$roles = $rolesObj->fetchAll('name', 'ASC');
	  
		$element = 'roleId';
	  
		if( $roles ) {
			$this->addElement('multiCheckbox',$element,array(
		    'id'=>$element,
		    'label' =>'roles',
	            'required' => false,
		    'listsep'=>''
			));

			foreach ($roles as $id=>$r) {
				$this->getElement($element)->addMultiOption($r->getId(), ucfirst($r->getName()));
			}
			$this->getElement($element)->setAttrib('label_class','list');
			$this->applyDecorator($element);
			$this->addToGroup($element);
		}
	}			
	
	/**
	 *  Populate the role checkboxes
	 */
	public function populateCheckboxes($permissionId){
		$rolePermissionObj = new Role_Model_RolePermissions();
		$rolePermissionObj->setPermissionId( $permissionId );
		$roles = $rolePermissionObj->fetchRoleByPermissionId();

		if( isset($roles) )
		$this->getElement('roleId')->setValue( array_values($roles) );
	}
}
?>
