<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Applicant_Form_Address extends ZFForm_ParentForm
{
	/**
	 * Is this form skippable ?
	 * @var boolean
	 */
	protected $isSkippable;
	
	/**
	 *  Fetches/sets if form is skippable (true/false)
	 */
	public function getIsSkippable(){
		return $this->isSkippable;
	}

	public function setIsSkippable( $var ){
		$this->isSkippable = $var;
	}
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init()
	{
		$this->displayGroupArray = array();
		$this->setIsSkippable(false);
	}

	public function setForm() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->addApplicantAddress();
		$this->addRent();
		$this->addApartmentInformation();
		$this->addReasonForLeaving();

		if( $this->getIsSkippable() ) {
			$this->addSkipButton();
			$this->setLegend('previousApplicantAddress');
		} else {
			$this->setLegend('currentApplicantAddress');
		}
		//	Ticket 277 , add a back button
		//$this->addBackButton();
		$this->addSubmitButton();
		$this->setDisplayGroup();
		$this->setFormTranslator();
	}
	
	private function addBackButton()
	{
		$element = 'back';
		$this->addElement('submit', $element, array( 'ignore'   => true, 'label' => $element ));
		$this->getElement($element)->setAttrib('class','submit');
		$this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement($element)->setDecorators(array('FieldsetForm'));
		$this->addToGroup( $element );
	}
	
	/**
	 *  Adds skip button
	 */
	private function addSkipButton(){
		$this->addElement('submit', 'skip', array( 'ignore'   => true, 'label' => 'skip' ));
		$this->getElement('skip')->setAttrib('class','submit');
		$this->getElement('skip')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('skip')->setDecorators(array('FieldsetForm'));

		$this->addToGroup( 'skip' );
	}

	/**
	 * Add applicant address information
	 */
	private function addApplicantAddress() {
		$this->addAddress(); //  Add address
		$this->addCity();  // Add city
		$this->addState();     // Add State
		$this->addZip();  // Add zip
	}

	private function addAddress() {
		$element = 'address';
		$addressOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text',$element,$addressOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add city
	 */
	private function addCity(){
		$element = 'city';
		$cityOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
		//			'description'=>'currentCityDescription',
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text','city',$cityOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add state
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

		foreach($states as $id=>$stateAbbreviation) {
			$this->getElement($element)->addMultiOption(++$id, $stateAbbreviation);
		}
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add Zip code
	 */
	private function addZip(){
		$element = 'zip';
		$zipOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' => array ('validator' => array( 'regex', false, array('/^[0-9]{5}$/','messages'=>array('regexNotMatch'=>'zipregexnotmatch')))));

		$this->addElement('text',$element,$zipOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Add current rent
	 */
	private function addRent() {
		$element = 'rent';
		$rentOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' => array ('validator' => array( 'regex', false, array('pattern'=>'/^[0-9]{1,4}(\.\d{2,2})?$/',
											   'messages'=>array('regexNotMatch'=>'regexrentamount')))));

		$this->addElement('text',$element,$rentOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Add apartment information
	 */
	private function addApartmentInformation() {
		$this->addApartmentName();
		$this->addOwnerName();
		$this->addApartmentPhone();
		$this->addMoveInDate();
		$this->addMoveOutDate();
	}

	/**
	 *  Add apartment name
	 */
	private function addApartmentName(){
		$element = 'apartmentName';
		$rentOpts = array(
                   			'required'=>false,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )));

		$this->addElement('text',$element,$rentOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add owner name
	 */
	private function addOwnerName(){
		$element = 'ownerName';
		$rentOpts = array(
                   			'required'=>false,
                   			'label'=>$element,
                   			'validators' =>  array( array('alpha', false, array('allowWhiteSpace' => true) )));

		$this->addElement('text',$element,$rentOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add apartment phone
	 */
	private function addApartmentPhone() {
		$element = 'apartmentPhone';
		$phoneOpts = array(
							'required'=>false,
                   			'label'=>$element,
							'validators' => array (array ('validator' => 'StringLength','options' => array (10,10)))
		);
		$this->addElement('text',$element,$phoneOpts);
		$this->getElement($element)->addFilter('Digits');
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add move in date
	 */
	private function addMoveInDate() {
		$element = 'moveInDate';
		$dateCheck = new ZFForm_Datevalidate();
		$dateOpts = array(
			'label'=>$element,
			'required'=>true,
			'readonly' => true
		);
		$this->addElement('text',$element,$dateOpts);
		$this->getElement($element)->addValidator($dateCheck);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add move out date
	 */
	private function addMoveOutDate() {
		$element = 'moveOutDate';
		$dateCheck = new ZFForm_Datevalidate();
		$dateOpts = array(
			'label'=>$element,
			'required'=>false,
			'readonly' => true
		);
		$this->addElement('text',$element,$dateOpts);
		$this->getElement($element)->addValidator($dateCheck);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Reason for leaving current apartment
	 */
	private function addReasonForLeaving() {
		$element = 'reasonForLeaving';
		$reasonForLeavingOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('textarea',$element,$reasonForLeavingOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}
}