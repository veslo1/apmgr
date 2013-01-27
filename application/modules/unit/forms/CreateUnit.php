<?php
/**
 * Created on Dec 5, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.controllers
 * <p>
 * Create form for units
 * </p>
 */
class Unit_Form_CreateUnit extends ZFForm_ParentForm {
	protected $models;
	protected $bulk;

	/**
	 *  Set unit models
	 */
	public function setModels( $models ){
		$this->models = $models;
	}
	 
	/**
	 *  Fetch models
	 */
	public function getModels(){
		return $this->models;
	}

	/**
	 *  Sets if the form is bulk (true false works ok here)
	 */
	public function setBulk($var){
		$this->bulk=$var;
	}

	public function getBulk(){
		return $this->bulk;
	}

	public function init() {
	}
	 
	public function setForm($bulk=false) {
		if( $this->getBulk() ){
		    $this->addNumUnits();
		}
		$this->addUnitModel();
		$this->addNumber();
		$this->addYearBuilt();
		$this->addYearRenovated();
		$this->addIsAvailable();
		$this->addDateAvailable();
		$this->addSubmitButton();
	  
		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
	}
	 
	/**
	 *  Used for bulk unit creation
	 */
	private function addNumUnits(){
		$element = 'numUnits';
		// # units to bulk create
		$this->addElement('text', $element, array (
		'label' => 'numUnitsToCreate',
		'required' => true,
		'filters' => array ( 'StringTrim' ),
		'validators' => array (array ('validator' => 'StringLength','options' => array (1,9)))));

		$this->addDecoratorAndGroup( $element );
	}
	 
	/**
	 *  Add unit model
	 */
	private function addUnitModel(){
		$element = 'unitModelId';
		$this->addElement('select',$element,array(
			'label' => 'unitModel',
			'required' => true,
		));
		foreach ($this->getModels() as $um) {
			$this->getElement($element)->addMultiOption($um->getId(), $um->getName());
		}
		$this->addDecoratorAndGroup( $element );
	}
	 
	/**
	 *  Add unit number
	 */
	private function addNumber(){
		$element = 'number';
		$this->addElement('text', $element, array (
			'label' => 'unitNumber',
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));		 
		$this->addDecoratorAndGroup( $element );
	}
	 
	/**
	 *  Add year built
	 */
	private function addYearBuilt(){
		$element = 'yearBuilt';
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => true,
			'filters' => array ( 'StringTrim','Digits'),			
			'validators' => array (array ('validator' => 'StringLength','options' => array (4,4)),
		array ('validator' => 'Between','options' => array (1820,2155))
		)
		));
		$this->addDecoratorAndGroup( $element );
	}
	 
	/**
	 *  Add year renovated
	 */
	private function addYearRenovated(){
		$element = 'yearRenovated';
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => false,
	                'filters' => array ( 'StringTrim','Digits'),			
			'validators' => array (array ('validator' => 'StringLength','options' => array (4,4)),
		array ('validator' => 'Between','options' => array (1901,2155))
		)
		));
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add  is available
	 */
	private function addIsAvailable(){
		$element = 'isAvailable';
		$this->addElement('checkbox',$element,array(
		    'label' => 'isAvailableForRenting',
		    'required' => false,
		    'description'=> 'isAvailableDesc'
		));
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	  *  Add date available
	  */
	private function addDateAvailable(){  
	    $element = 'dateAvailable';
	    $this->addElement('text', $element, array(
            'label'=> $element,
            'required'   => false,
            'filters'    => array('StringTrim'),
	        'readonly' => true
		));
	  
		$dateCheck = new ZFForm_Datevalidate();
		$this->getElement($element)->addValidator($dateCheck);
		$this->getElement($element)->setAttrib('class','inputAccesible');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		
		$this->addDecoratorAndGroup( $element );
	}	
}
?>
