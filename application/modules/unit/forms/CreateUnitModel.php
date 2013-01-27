<?php
/**
 * Created on Dec 5, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.forms
 * <p>
 * Create form for unit models
 * </p>
 */
class Unit_Form_CreateUnitModel extends Zend_Form {
	protected $displayGroupArray;

	public function init() {
		$this->displayGroupArray = array();
	}

	public function setForm() {
		// Set the method for the display form to POST
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');
		 
		$this->addName();
		$this->addSize();
		$this->addNumBeds();
		$this->addNumBaths();
		$this->addNumFloors();
		//	$this->addDeposit();
		$this->addAmenity();
		$this->addSubmitButton();

		$this->addDisplayGroup( $this->displayGroupArray, 'createNewUnitModel',array('legend' => $this->getLegend()));
		$this->getDisplayGroup('createNewUnitModel')->setDecorators(array(
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

	private function addName() {
		$element = 'name';
		$this->addElement('text', $element, array (
			'label' => 'unitModelName',
			'required' => true,
			'filters' => array ( 'StringTrim' ),
			'validators' =>array(array ('validator' => 'StringLength','options' => array (1,50)))));   
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addSize() {
		$element = 'size';
		$this->addElement('text', $element, array (
			'label' => 'size',
			'required' => true,
			'filters' => array ( 'StringTrim'),
			'validators' => array(array ('validator' => 'Int'/*array( 'regex', false, array('/^[0-9]{1,11}$/'))*/))));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addNumBeds() {
		// numBeds
		$element = 'numBeds';
		$this->addElement('text', $element, array (
			'label' => 'beds',
			'required' => true,
			'filters' => array ( 'StringTrim'),
			'validators' => array(array ('validator'=>'Between','options' => array (0,255)))
		));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addNumBaths() {
		// numBaths
		$element = 'numBaths';
		$this->addElement('text', $element, array (
			'label' => 'baths',
			'required' => true,
			'filters' => array ( 'StringTrim'),			
			'validators' => array ('validator' => array( 'regex', false, array('pattern'=>'/^[0-9]{1,2}(\.\d{1,2})?$/',
											   'messages'=>array('regexNotMatch'=>'regexthreedigitstwodecimal'))
		))));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addNumFloors() {
		// numFloors
		$element = 'numFloors';
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => true,
			'filters' => array ( 'StringTrim'),
			'validators' => array (array ('validator' => 'Between','options' => array (0,255))
		)));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addAmenity() {
		// Amenities
		$amenity = new Unit_Model_Amenity();
		$allAmenities = $amenity->fetchAll();
	  
		$element = 'amenityId';
	  
		if( $allAmenities ) {
			$this->addElement('multiCheckbox',$element,array(
		        'id'=>'amenityId',
			'label' => 'amenities',
			'required' => false,
			'listsep'=>''
			));
			 
			foreach ($allAmenities as $a){
			    $this->getElement($element)->addMultiOption($a->getId(), $a->getName());
			}
			$this->getElement($element)->setAttrib('label_class','list');			
			$this->applyDecorator($element);
			$this->addToGroup($element);
		}
	}
}
?>
