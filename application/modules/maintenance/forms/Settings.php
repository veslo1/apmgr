<?php
class Maintenance_Form_Settings extends Zend_Form {
	protected $displayGroupArray;
	protected $roleId;

	public function setRoleId( $var ){
		$this->roleId=$var;
	}

	public function getRoleId(){
		return $this->roleId;
	}

	public function init() {
		$this->displayGroupArray = array();
		$this->setLegend('maintenanceSettings');

		// Set the method for the display form to POST
		$this->setMethod('post');
	}

	public function setForm() {
		$this->addRole();
		$this->addDefaultAssignedTo();

		$this->addSubmitButton();
		$this->addDisplayGroup($this->displayGroupArray,'maintSetting',array('legend' => $this->getLegend()));
		$this->getDisplayGroup('maintSetting')->setDecorators(array('FormElements','Fieldset'));
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setTranslator($translator);
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
		$this->addElement('submit', 'submit', array( 'ignore'   => true, 'label' => 'save' ));
		$this->getElement('submit')->setAttrib('class','submit');
		$this->getElement('submit')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('submit')->setDecorators(array('FieldsetForm'));
		$this->addToGroup( 'submit' );
	}

	private function addRole(){
		$element = 'roleId';
		$roleOpts = array(
      			'required'=>true,
       			'id'=>$element,
			'label' =>$element
		);
		$this->addElement('select',$element,$roleOpts);
		$role = new Role_Model_Role();
		$this->getElement($element)->addMultiOption(null,'--select--');
		foreach ($role->fetchAll() as $r)
		$this->getElement($element)->addMultiOption($r->getId(), $r->getName());

		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));

		// populate the default assigned users based on the role selection
		$this->getElement($element)->setAttrib('onchange','populateDefaultAssigned()');
		$this->addToGroup( $element );
	}

	public function addDefaultAssignedTo(){
		$element = 'defaultAssignedTo';
		$roleOpts = array(
      			'required'=>true,
       			'id'=>$element,
			'label' =>$element
		);
		 
		$this->addElement('select',$element,$roleOpts);
		$this->$element->setRegisterInArrayValidator(false);

		if( $this->getRoleId() ){
			$userHelper = new User_Library_Helper_Utils();
			$users = $userHelper->getUsersByRoleId($this->getRoleId());
			if($users)
			{
				foreach ( $users as $id=>$user )
				{
					$this->getElement($element)->addMultiOption($user['id'], $user['fullName'] );
				}
			}
		}

		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		$this->addToGroup( $element );
	}
}
?>
