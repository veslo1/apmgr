<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Applicant_Form_WorkHistory extends ZFForm_ParentForm {

	protected $isSkippable;

	/**
	 *  Fetches/sets if form is skippable (true/false)
	 */
	public function getIsSkippable(){
		return $this->isSkippable;
	}
	public function setIsSkippable($var){
		$this->isSkippable = $var;
	}
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init(){
		$this->setIsSkippable(false);
	}

	public function setForm() {
		// Set the method for the display form to POST
		$this->setMethod('post');

		$this->addEmployerName();
		$this->addEmployerAddress();
		$this->addEmployerPhone();
		$this->addMonthlyIncome();
		$this->addDateStarted();
		$this->addDateEnded();
		$this->addSupervisorName();
		$this->addSupervisorPhone();

		if( $this->getIsSkippable() ) {
			$this->addSkipButton();
			$this->setLegend('previousWorkHistory');
		} else {
			$this->setLegend('currentWorkHistory');
		}
		$this->addSubmitButton();
		$this->setDisplayGroup();
		$this->setFormTranslator();
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
	 *  Add Employer Name
	 */
	private function addEmployerName() {
		$element = 'employerName';

		$addressOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
		//					'description'=>'currentHomeAddressDescription',
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text',$element,$addressOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Add employer address information
	 */
	private function addEmployerAddress() {
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
	 *  Add employer phone
	 */
	private function addEmployerPhone() {
		$element = 'employerPhone';
		$phoneOpts = array(
					'required'=>false,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(10,10))));

		$this->addElement('text',$element,$phoneOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add employer phone
	 */
	private function addMonthlyIncome() {
		$element = 'monthlyIncome';
		$incomeOpts = array(     'required'=>true,
                   			'label'=>$element,
                   			'validators' => array(array( 'regex', false, array('pattern'=>'/^[0-9]{1,4}(\.\d{2,2})?$/',
											   'messages'=>array('regexNotMatch'=>'regexrentamount')))));

		$this->addElement('text',$element,$incomeOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add date started
	 */
	private function addDateStarted() {
		$element = 'dateStarted';
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
	 *  Add Date Ended
	 */
	private function addDateEnded() {
		$element = 'dateEnded';
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
	 *  Add Supervisor Name
	 */
	private function addSupervisorName() {
		$element = 'supervisorName';
		$addressOpts = array(
                   			'required'=>false,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text',$element,$addressOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 *  Add supervisor phone
	 */
	private function addSupervisorPhone() {
		$element = 'supervisorPhone';
		$phoneOpts = array(     'required'=>false,
                   			'label'=>$element,
                   			'validators' =>  array( array('stringLength', false, array(10,10))));

		$this->addElement('text','supervisorPhone',$phoneOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}
}