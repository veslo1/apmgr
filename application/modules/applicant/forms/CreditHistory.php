<?php
/**
 * @author Rachael Nelson
 *
 */
class Applicant_Form_CreditHistory extends ZFForm_ParentForm {

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
	public function init(){
		$this->displayGroupArray = array();
		$this->setIsSkippable(false);
	}

	public function setForm() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		$this->addBank();
		$this->addCreditCards();
		$this->addNonWorkIncome();
		$this->addCreditProblems();

		if( $this->getIsSkippable() ) {
			$this->addSkipButton();
		}
		$this->addSubmitButton();
		$this->setLegend('applicantCreditHistory');
		$this->setFormTranslator();
		$this->setDisplayGroup();
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
	 *  Add bank
	 */
	private function addBank(){
		$this->addBankName();
		$this->addBankAddress();
	}


	/**
	 *  Add name
	 */
	private function addBankName() {
		$element = 'bankName';
		$addressOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text',$element,$addressOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Add address information
	 */
	private function addBankAddress() {
		$this->addAddress();  //  Add address
		$this->addCity();  // Add city
		$this->addState();   // Add State
		$this->addZip();  // Add zip
	}

	/**
	 *  Add Address
	 */
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
	 *  Add Credit Cards
	 */
	private function addCreditCards() {
		$element = 'creditCards';
		$addressOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('textarea',$element,$addressOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add Non-work income
	 */
	private function addNonWorkIncome() {
		$element = 'nonWorkIncome';
		$addressOpts = array(
                   			'required'=>false,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('textarea',$element,$addressOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add Credit Problems
	 */
	private function addCreditProblems() {
		$element = 'creditProblems';
		$addressOpts = array(
                   			'required'=>false,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('textarea',$element,$addressOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

}