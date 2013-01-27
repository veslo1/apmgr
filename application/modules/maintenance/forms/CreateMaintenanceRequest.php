<?php
/**
 * Created on February 24, 2010 by rnelson
 * @name apmgr
 * @package application.modules.maintenance.controllers
 * <p>
 * Create form for the user to enter maintenance requests
 * For
 * </p>
 */
class Maintenance_Form_CreateMaintenanceRequest extends Zend_Form {
	protected $displayGroupArray;
	protected $instructionText;
	protected $isAdmin;

	public function setInstructionText( $var ){
		$this->instructionText = $var;
	}
	 
	public function getInstructionText(){
		return $this->instructionText;
	}

	/**
	 *  Sets admin
	 */
	public function setIsAdmin( $var ){
		$this->isAdmin = $var;
	}
	 
	public function getIsAdmin(){
		return $this->isAdmin;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init(){
		$this->displayGroupArray = array();
		$this->setLegend('createMaintenanceRequest');
	}

	public function setForm() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		if( $this->getIsAdmin() )
		$this->addUnits();
		$this->addTitle();
		$this->addDescription();
		$this->addPermissionToEnter();
		$this->addSubmitButton();

		$this->addDisplayGroup($this->displayGroupArray,
				       'createMaintenanceRequest',
		array('legend' => $this->getLegend()));
		$this->getDisplayGroup('createMaintenanceRequest')->setDecorators(array('FormElements','Fieldset'));
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

	/**
	 *  Add units for admin user
	 */
	private function addUnits(){
		$element = 'unitId';
		$this->addElement('select',$element,array(
	        'id'=>$element,
		'label' => 'unitNumber',
	        'required' => false
		));

		// Fetch criminal/rental questions
		$unitObj = new Unit_Model_Unit();

		foreach( $unitObj->fetchAll() as $id=>$unit ) {
			$this->getElement($element)->addMultiOption($unit->getId(), $unit->getNumber());
		}

		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->setAttrib('label_class','list');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));

		$this->addToGroup( $element );
	}

	/**
	 *  Title of request
	 */
	private function addTitle(){
		$element = 'title';
		$titleOpts = array(
                   			'required'=>true,
                   			'label'=>$element,		
                   			'validators' =>  array( array('stringLength', false, array(1, 20) )	)
		);
		$this->addElement('text',$element,$titleOpts);
		//$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));

		$this->addToGroup( $element );
	}

	/**
	 *  Description of request
	 */
	private function addDescription(){
		$element = 'description';
		$titleOpts = array(
                   			'required'=>true,
                   			'label'=>$element,		
                   			'validators' =>  array( array('stringLength', false, array(1, 20) )	)
		);
		$this->addElement('textarea',$element,$titleOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));

		$this->addToGroup( $element );
	}

	/**
	 *  Permission to enter
	 */
	private function addPermissionToEnter(){
		$element = 'permissionToEnter';
		$this->addElement('checkbox',$element,array(
		    'id'=>$element,
		    'label' => $element,
		    'required' => false
		));

		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->setAttrib('label_class','list');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));

		$this->addToGroup( $element );
	}
}
?>