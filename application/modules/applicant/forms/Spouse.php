<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Applicant_Form_Spouse extends ZFForm_ParentForm {

	protected $isSkippable;

	/**
	 *  Fetches/sets if form is skippable (true/false)
	 */
	public function getIsSkippable(){
		return $this->isSkippable;
	}

	/**
	 *
	 * @param boolean $var
	 */
	public function setIsSkippable( $var ){
		$this->isSkippable = $var;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init() {
		$this->displayGroupArray = array();
		$this->setIsSkippable(false);
	}

	public function setForm() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->addFullName();
		$this->addStreetAddress();
		$this->addDriversLicenseAndState();

		$this->addFormerLastName();
		$this->addBirthDate();
		$this->addSsn();
		$this->addHeight();
		$this->addWeight();
		$this->addSex();
		$this->addEyeColor();
		$this->addHairColor();
		$this->addUsCitizen();
		$this->addCityStateZip();
		$this->addCellPhone();
		$this->addWorkPhone();
		$this->addPosition();
		$this->addEmailAddress();
		$this->addDateBeganJob();
		$this->addIncome();
		$this->addSupervisorName();

		if( $this->getIsSkippable() ) {
			$this->addSkipButton();
		}
		$this->addSubmitButton();
		$this->setLegend('spouseForm');
		$this->setFormTranslator();
		$this->setDisplayGroup();

	}

	/**
	 *  Adds skip button
	 */
	private function addSkipButton() {
		$this->addElement('submit', 'skip', array( 'ignore'   => true, 'label' => 'skip' ));
		$this->getElement('skip')->setAttrib('class','submit');
		$this->getElement('skip')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('skip')->setDecorators(array('FieldsetForm'));

		$this->addToGroup('skip');
	}

	private function addFullName() {
		$element = 'fullName';
		$fullNameOpts = array(
                   			'required'=>true,
                   			'label'=>$element,
							'description'=>'fullNameDescription',
                   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('text' ,$element,$fullNameOpts);
		//	Now we use our own decorators
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Add street address
	 */
	private function addStreetAddress() {
		$element = 'streetAddress';
		$streetAddressOpts = array(
		                   			'required'=>true,
        		           			'label'=>'address',
                		   			'validators' =>  array( array('stringLength', false, array(1, 255) )	)
		);
		$this->addElement('textarea',$element,$streetAddressOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->getElement('streetAddress')->setAttrib('class','inputAccesible');
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * @todo This particular section has to have a special validator.
	 * If we have a drivers license, you have to choose a State, so we need the same
	 * kind of validator we used in calendar
	 */
	private function addDriversLicenseAndState() {
		$translator = Zend_Registry::get('Zend_Translate');

		/*$element = 'idIdentification';
		$idOpts = array(
			'label'=>'identificationType',
			'required'=>true
		);
		$this->addElement('select',$element,$idOpts);
		$this->getElement($element)->addMultiOption(null,$translator->_('chooseIdMethod'));
		$this->getElement($element)->addMultiOption(1,$translator->_('driversLicense'));
		$this->getElement($element)->addMultiOption(2,$translator->_('govLicense'));
		$this->applyDecorator($element);
		$this->addToGroup($element);
		*/

		$element = 'identification';
		$driversLicenseOpts = array(
				'required'=>true,
                'label'=>$element,
                'validators' =>  array( array('stringLength', false, array(3,11) )	)
		);


		$this->addElement('text',$element,$driversLicenseOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);

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

		//	Finally push the validation options for this. Please refer to the comments in the class for info
		$validation = new ZFForm_Driverlicensestate();
		$this->getElement('identification')->addValidator($validation);
	}

	/**
	 * Add the formerLastName
	 */
	private function addFormerLastName() {
		$element = 'formerLastName';
		$formerLastNameOpts = array(
							'label'=>$element,
							'description'=>'formerLastNameDescription',
							'required'=>false,
                   			'validators' =>  array( array('stringLength', false, array(4,255) )	)
		);
		$this->addElement('text',$element,$formerLastNameOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Add the Ssn
	 * @todo Find regex for SSN or just validate that it has 9 numbers
	 */
	private function addSsn() {
		$element = 'ssn';
		$ssnOpts = array(
			'label'=>$element,
			'required'=>true,
			'description'=>'ssnDescription',
			'validators' => array ('validator' => array( 'regex', false, array('pattern'=>'/^[0-9]{9}(\.\d{1,2})?$/',
											   'messages'=>array('regexNotMatch'=>'ssnregexnotmatch'))
		)));
		$this->addElement('text',$element,$ssnOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * @todo Needs validation for <strong>date</strong>
	 */
	private function addBirthDate() {
		$dateCheck = new ZFForm_Datevalidate();
		$element = 'dob';
		$birthdateOpts = array(
			'label'=>$element,
			'required'=>true,
			'readonly' => true # This is to avoid the form be writable
		);
		$this->addElement('text',$element,$birthdateOpts);
		$this->getElement($element)->addValidator($dateCheck);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addHeight() {
		$element = 'height';
		$heightOptions = array('label'=>$element,'required'=>false);
		$this->addElement('text',$element,$heightOptions);
		$this->getElement($element)->addValidator('float',true)
		->addFilter('Digits');
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addWeight() {
		$element = 'weight';
		$weightOptions = array('label'=>'weight','required'=>false);
		$this->addElement('text',$element,$weightOptions);
		$this->getElement($element)->addValidator('float',true)
		->addFilter('Digits');
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addSex() {
		$element = 'sex';
		$sexOpts = array('required'=>true,'label'=>$element);
		$this->addElement('select',$element,$sexOpts);
		$translator = Zend_Registry::get('Zend_Translate');
		$this->getElement($element)->addMultiOption(null, $translator->_('selectSexEmpty'));
		$sex = array('m','f');
		foreach($sex as $id=>$sexOption) {
			$this->getElement($element)->addMultiOption(++$id, ucfirst($sexOption));
		}
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addEyeColor() {
		$element = 'eyeColor';
		$weightOptions = array(
			'label'=>$element,
			'required'=>false,
			'validators' =>  array( array('stringLength', false, array(3,20) )	)
		);
		$this->addElement('text',$element,$weightOptions);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addHairColor() {
		$element = 'hairColor';
		$hairColorOptions = array(
			'label'=>$element,
			'required'=>false,
			'validators' =>  array( array('stringLength', false, array(3,50) )	)
		);
		$this->addElement('text',$element,$hairColorOptions);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addUsCitizen() {
		$translator = Zend_Registry::get('Zend_Translate');

		$element = 'usCitizen';
		$usCitizenOpts = array(
			'label'=>'areyouAUsCitizen',
			'required'=>true,
			'validators'=>array(
		array('validator'=> 'NotEmpty',array('integer','zero'))
		)
		);

		$this->addElement('select',$element,$usCitizenOpts);
		$this->getElement($element)->addMultiOption(null, $translator->_('usCitizenEmpty'));
		$answer = array('yes','no');
		foreach($answer as $id=>$answerType) {
			$this->getElement($element)->addMultiOption(++$id, ucfirst($answerType));
		}
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addCityStateZip() {
		$element = 'cityStateZip';
		$cityOpts = array('label'=>$element,'required'=>true);
		$this->addElement('textarea',$element,$cityOpts);
		$this->getElement('cityStateZip')->setAttribs(array('rows'=>10,'cols'=>25));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addCellPhone() {
		$element = 'cellPhone';
		$phoneOpts = array('label'=>$element,'required'=>false,'validators' =>  array( array('stringLength', false, array(10,10) ) ));
		$this->addElement('text',$element,$phoneOpts);
		$this->getElement($element)->addFilter('Digits');
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addWorkPhone() {
		$element = 'workPhone';
		$phoneOpts = array('label'=>$element,'required'=>false,'validators' =>  array( array('stringLength', false, array(10,10) ) ));
		$this->addElement('text',$element,$phoneOpts);
		$this->getElement($element)->addFilter('Digits');
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addPosition() {
		$element = 'position';
		$positionOpts = array('label'=>$element,'required'=>false,'validators' =>  array( array('stringLength', false, array(3,50) )	));
		$this->addElement('text',$element,$positionOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addEmailAddress() {
		$element = 'emailAddress';
		$smokeOpts = array('label'=>$element,'required'=>false,'validators' => array('EmailAddress') );
		$this->addElement('text',$element,$smokeOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addDateBeganJob() {
		$element = 'dateBeganJob';
		$dateCheck = new ZFForm_Datevalidate();
		$birthdateOpts = array(
			'label'=>$element,
			'required'=>false,
			'readonly' => true # This is to avoid the form be writable
		);
		$this->addElement('text',$element,$birthdateOpts);
		$this->getElement($element)->addValidator($dateCheck);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * @todo Add cash validation
	 */
	private function addIncome() {
		$element = 'income';
		$cashOpts = array('label'=>$element,'required'=>false );
		$this->addElement('text',$element,$cashOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addSuperVisorName() {
		$element = 'superVisorName';
		$supervisorOpts = array('label'=>$element,'required'=>false ,'validators' =>  array( array('stringLength', false, array(3,250) ) ));
		$this->addElement('text','superVisorName',$supervisorOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addSuperVisorPhone() {
		$element = 'superVisorPhone';
		$phoneOpts = array('label'=>$element,'required'=>false,'validators' =>  array( array('stringLength', false, array(3,50) )	));
		$this->addElement('text',$element,$phoneOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}
}