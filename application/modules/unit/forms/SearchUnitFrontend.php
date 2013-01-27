<?php
/**
 * Form used to search values in the front end
 *
 * @author jvazquez
 */
class Unit_Form_SearchUnitFrontend extends ZFForm_ParentForm {

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init() {
		$this->setTranslator();
		$this->setCache(Zend_Registry::get('cache'));
		$this->setCacheKey('unitSearchFormParams');
	}

	/**
	 * Initialization of the form
	 */
	public function setForm(){
		$this->setMethod('post');
		$this->setAction('/unit/search/index');

		//  Populate all the selects
		$this->fetchSelects();

		// Populate checkboxes
		$this->fetchChekboxes();
		$this->addSubmitButton('search');
	}

	/**
	 * Retrieve all the possible selects for this form
	 * @todo This also needs configurable default options for each select,
	 * which is the lowest level of a foreach, which is the highest level
	 * Add the "any option" option that will alter a bit how this selects are built
	 */
	protected function fetchSelects() {
		$translator = $this->getTranslator();
		$lowerthan = $translator->_('lowerthan');
		$equalto = $translator->_('equalto');
		$greaterthan = $translator->_('greaterthan');

		$size = $translator->_('size');
		$this->addElement('select', 'size',
		array(
                'label' => 'sizeHeight',
                'required' => false,
                'registerInArrayValidator'=>false
		)
		);
		$this->getElement('size')->addMultiOption('any','anyOption');
		for($i=175;$i<900;$i+=100) {
			$this->getElement('size')->addMultiOption("$i-l","$lowerthan $i $size");
			$this->getElement('size')->addMultiOption("$i-g","$greaterthan $i $size");
		}

		/**
		 * Adds the select of beds
		 */
		$beds = $translator->_('bedsLabel');
		$this->addElement('select', 'beds', array('label' => 'bedsLabel','required' => false,'registerInArrayValidator'=>false));
		$this->getElement('beds')->addMultiOption('any','anyOption');
		for($i=1;$i<5;$i++) {
			$this->getElement('beds')->addMultiOption("$i-e","$equalto $i $beds");
			$this->getElement('beds')->addMultiOption("$i-g","$greaterthan $i $beds");
		}

		/**
		 * Adds the select of baths
		 * @internal This isn't right, because this has float options, but will work it like this
		 */
		$baths = $translator->_('bath');
		$this->addElement('select','baths',array('label'=>'bathLabel','required'=>false,'registerInArrayValidator'=>false));
		$this->getElement('baths')->addMultiOption('any','anyOption');
		for($i=1;$i<5;$i++) {
			$this->getElement('baths')->addMultiOption("$i-e","$equalto $i $baths");
			$this->getElement('baths')->addMultiOption("$i-g","$greaterthan $i $baths");
		}

		/**
		 * And this is for the select of floors, which doesn't has the option than "lower than",
		 * because it doesn't makes sense
		 */
		$floors = $translator->_('floors');
		$this->addElement('select','floors',array('label'=>'floorLabel','required'=>false,'registerInArrayValidator'=>false));
		$this->getElement('floors')->addMultiOption('any','anyOption');
		for($i=1;$i<5;$i++) {
			$this->getElement('floors')->addMultiOption("$i-e","$equalto $i $floors");
			$this->getElement('floors')->addMultiOption("$i-g","$greaterthan $i $floors");
		}
	}

	/**
	 *  Popualte the box for amenities on the search form if amenities exist in the table
	 */
	protected function fetchChekboxes() {
		$amenityObj = new Unit_Model_Amenity();
		$amenities = $amenityObj->fetchAll();

		if( $amenities ){
			$this->addElement('multiselect','amenities',array('label'=>'amenities',
                    'required'=>false,
                    'registerInArrayValidator'=>false));
			foreach($amenities as $id=>$content) {
				$this->getElement('amenities')->addMultiOption($content->getId(),ucfirst($content->getName()));
			}
		}
	}
}
?>
