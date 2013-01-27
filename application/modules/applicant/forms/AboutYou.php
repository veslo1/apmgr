<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 *
 */
class Applicant_Form_AboutYou extends ZFForm_ParentForm {
	
	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init(){}

	public function setForm() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setFormTranslator();
		$this->addFullName();
		$this->addPhone();
		$this->addDriversLicenseAndState();
		$this->addFormerLastName();
		$this->addBirthDate();
		$this->addSsn();
		$this->addHeight();
		$this->addWeight();
		$this->addSex();
		$this->addEyeColor();
		$this->addHairColor();
		$this->addMaritalStatus();
		$this->addUsCitizen();
		$this->addDoYouSmoke();
		$this->addPets();
		$this->addPetDetails();
		$this->addSubmitButton();
		$this->setLegend('aboutYou');
		$this->setDisplayGroup();
	}

	private function addFullName() {
		$element = 'fullName';
		$fullNameValidator =   array( array('stringLength', false, array(1, 255) )	);
		$fullNameOpts = array('required'=>true,'label'=>$element,'description'=>'fullNameDescription','validators' =>$fullNameValidator);
		$this->addElement('text' ,$element,$fullNameOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

        private function addPhone() {
		$element = 'phone';
		$phoneOpts = array('label'=>$element,'required'=>true,'validators' =>  array( array('stringLength', false, array(10,10) ) ));							
		$this->addElement('text',$element,$phoneOpts);
		$this->getElement($element)->addFilter('Digits');
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * @todo This particular section has to have a special validator.
	 * If we have a drivers license, you have to choose a State, so we need the same
	 * kind of validator we used in calendar
	 */
	private function addDriversLicenseAndState() {
		$element = 'identification';
		$driverValidators = array( array('stringLength', false, array('min'=>3,'max'=>11) )	);
		$driversLicenseOpts = array('required'=>true,'label'=>$element,'validators' =>  $driverValidators,'description'=> 'driverLicenseGov');
		$this->addElement('text',$element,$driversLicenseOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);

		$element = 'state';
		$statesValidators = array( array('validator'=> 'NotEmpty',array('integer','zero') ) );
		$statesOpts = array('required'=>true,'label'=>$element,'validators'=> $statesValidators);
		$this->addElement('select',$element,$statesOpts);
		$this->getElement($element)->addMultiOption(null, 'selectStateEmptyOption');
		$states = ZFForm_ParentForm::$states;
		foreach($states as $id=>$stateAbreviation) {
			$this->getElement($element)->addMultiOption(++$id, $stateAbreviation);
		}
		$this->applyDecorator($element);
		$this->addToGroup($element);

		//	Finally push the validation options for this. Please refer to the comments in the class for info
		//		$validation = new ZFForm_Driverlicensestate();
		//		$this->getElement('identification')->addValidator($validation);
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
                   			'validators' =>  array( array('stringLength', false, array(1,255) )	)
		);
		$this->addElement('text',$element,$formerLastNameOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	/**
	 * Add the Ssn
	 * @todo Find regex for SSN or just validate that it has 9 numbers
	 */
	private function addSsn()
	{
		$element = 'ssn';		
		$ssnOpts = array('label'=>$element,
				 'required'=>true,
				 'description'=>'ssnDescription',
				 'validators' => array ('validator' => array( 'regex', false, array('pattern'=>'/^[0-9]{9}(\.\d{1,2})?$/',
											   'messages'=>array('regexNotMatch'=>'ssnregexnotmatch'))
		)));
		$this->addElement('text',$element,$ssnOpts);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addBirthDate() {
		$dateCheck = new ZFForm_Datevalidate();
		$element = 'dob';
		# readonly => true makes the element not writable
		$birthdateOpts = array('label'=>$element,'required'=>true,'readonly' => true);
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
		$this->getElement($element)->addMultiOption(null,'selectSexEmpty');
		$sex = ZFForm_ParentForm::$sex;
		foreach($sex as $id=>$sexOption) {
			$this->getElement($element)->addMultiOption(++$id, ucfirst($sexOption));
		}
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addEyeColor() {
		$element = 'eyeColor';
		$eyeColorValidator =  array( array('stringLength', false, array(3,20) )	);
		$weightOptions = array('label'=>$element,'required'=>true,'validators' =>  $eyeColorValidator);
		$this->addElement('text',$element,$weightOptions);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addHairColor() {
		$element = 'hairColor';
		$hairColorValidator =array( array('stringLength', false, array(3,50) )	);
		$hairColorOptions = array('label'=>$element,'required'=>true,'validators' =>  $hairColorValidator);
		$this->addElement('text',$element,$hairColorOptions);
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addMaritalStatus() {
		$element = 'maritalStatus';
		$maritalStatusOpts = array('label'=>$element,'required'=>true);
		$this->addElement('select',$element,$maritalStatusOpts);
		$this->getElement($element)->addMultiOption(null,'maritalStatusEmpty');
		$marital = ZFForm_ParentForm::$marital;
		foreach($marital as $id=>$civilStatus) {
			$this->getElement($element)->addMultiOption(++$id, ucfirst($civilStatus));
		}
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addUsCitizen() {
		$element = 'usCitizen';
		$citizenshipValidator = array(array('validator'=> 'NotEmpty',array('integer','zero')));
		$usCitizenOpts = array('label'=>'areyouAUsCitizen','required'=>true,'validators'=>$citizenshipValidator);
		$this->addElement('select',$element,$usCitizenOpts);
		$this->getElement($element)->addMultiOption(null,'usCitizenEmpty');
		$answer = ZFForm_ParentForm::$answer;
		foreach($answer as $id=>$answerType) {
			$this->getElement($element)->addMultiOption(++$id, ucfirst($answerType));
		}
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addDoYouSmoke() {
		$element = 'smoke';
		$smokeValidator = array(array('validator'=> 'NotEmpty',array('integer','zero')));
		$smokeOpts = array('label'=>'doYouSmoke','required'=>true,'validators'=>$smokeValidator);
		$this->addElement('select',$element,$smokeOpts);
		$this->getElement($element)->addMultiOption(null,'doYouSmokeEmpty');
		$answer = ZFForm_ParentForm::$answer;
		foreach($answer as $id=>$answerType) {
			$this->getElement($element)->addMultiOption(++$id, ucfirst($answerType));
		}
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addPets() {
		$petValidation = array(array('validator'=> 'NotEmpty',array('integer','zero')));
		$element = 'havePets';
		$petsOpts = array('label'=>$element,'required'=>true,'validators'=>$petValidation);
		$this->addElement('select',$element,$petsOpts);
		$this->getElement($element)->addMultiOption(null,'havePetsEmpty');
		$petValidator = new ZFForm_Petvalidator();
		$this->getElement($element)->addValidator($petValidator);
		$answer = ZFForm_ParentForm::$answer;
		foreach($answer as $id=>$answerType) {
			$this->getElement($element)->addMultiOption(++$id, ucfirst($answerType));
		}
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}

	private function addPetDetails(){
		$element='petDetails';
		$petDetailsOpts = array('label'=>$element,'required'=>false);
		$this->addElement('textarea',$element,$petDetailsOpts);
		$this->getElement($element)->setAttribs(array('rows'=>10,'cols'=>20));
		$this->applyDecorator($element);
		$this->addToGroup($element);
	}
}
