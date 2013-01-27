<?php
/**
 * Created on Dec 3, 2009 by rnelson
 * @name apmgr
 * @package application.modules.apartment.controllers
 * <p>
 * Create form for apartments
 * </p>
 */
class Unit_Form_CreateApartment extends ZFForm_ParentForm {
		
	public function init() {
	}

	public function setForm() {
		// add fields
		$this->addName();
		$this->addAddressOne();
		$this->addAddressTwo();
		$this->addCity();
		$this->addState();
		$this->addZip();
		$this->addCountry();
		$this->addPhone();
		$this->addSubmitButton();

		$this->setDisplayGroup();  // add display group
		$this->setFormTranslator();  // add translator
	} // end method

	/**
	 *  Add  apartment name
	 */
	private function addName(){
		$element = 'name';
		$this->addElement('text', $element, array (
			'label' => 'apartmentName',
			'required' => true,
			'filters' => array (
				'StringTrim'
				),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));
				$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add  first address field
	 */
	private function addAddressOne(){
		$element = 'addressOne';
		$this->addElement('text', $element, array (
	        'label' => $element,
		'required' => true,
		'filters' => array ('StringTrim'),
		'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add  second address field
	 */
	private function addAddressTwo(){
		$element = 'addressTwo';
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => false,
			'filters' => array ('StringTrim'),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));	
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add  first address city
	 */
	private function addCity(){
		$element = 'city';
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => true,
			'filters' => array ('StringTrim'),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));	
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add address state
	 */
	private function addState(){
		$element = 'state';
		//	Not likely to change
		$states = array('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY');
		$selectOpts = array(
	           'label' => $element,
	            'required' => true
		);

		$this->addElement('select',$element,$selectOpts);
		$this->getElement($element)->addMultiOption(null);

		foreach($states as $id=>$stateAbbreviation)
		$this->getElement($element)->addMultiOption(++$id, $stateAbbreviation);

		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add  first address zip
	 */
	private function addZip(){
		$element = 'zip';
		$this->addElement('text', $element, array (
			'label' => $element,
			'required' => true,
			'filters' => array ('StringTrim'),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));	

		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add  first address country
	 */
	private function addCountry(){
		$element = 'country';
		$this->addElement('text', 'country', array (
			'label' => 'country',
			'required' => true,
			'filters' => array (
				'StringTrim'
				),
			'validators' => array (array ('validator' => 'StringLength','options' => array (1,50)))));	

				$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Add address phone
	 */
	private function addPhone() {
		$element = 'phone';
		$phoneOpts = array(     'required'=>false,
                   			'label'=>$element,
					'filters' => array ( 'StringTrim','Digits'),
					'validators' => array (array ('validator' => 'StringLength','options' => array (10,10)))
		);
			
		$this->addElement('text',$element,$phoneOpts);
		$this->addDecoratorAndGroup( $element );
	}

	/**
	 *  Used to populate the state dropdown
	 */
	public function populateForm($aptArray){
		$stateArray = $this->getElement('state')->getMultiOptions();   // fetch all the options in the select
		$id = array_search( $aptArray['state'], $stateArray );  // see if the state selected is in the array
		$aptArray['state'] = $id;	   // if so populate the select with the value from the db
		$this->populate($aptArray);
	}

}  // end class
?>
