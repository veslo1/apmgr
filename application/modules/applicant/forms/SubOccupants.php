<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_Form_SubOccupants extends Zend_Form_SubForm {
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init() {
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setTranslator($translator);
		$this->addFullName();
		$this->addDriversLicenseAndState();
		$this->addSsn();
		$this->addBirthDate();
		$this->addSex();
		$this->addRelationship();
		//		$this->addDisplayGroup(array('fullName','idIdentification','identification','state','ssn','dob','sex','relationship'),'aboutYou');
	}

	/**
	 * Add the full name of the applicant
	 */
	private function addFullName() {
		$fullNameOpts = array(
                   				'required'=>true,
                   				'label'=>'fullName',
								'allowEmpty'=>false,
								'belongsTo'=>'occupants',
                   				'validators' =>  array( array('stringLength', false, array(1, 250) )	)
		);
		$this->addElement('text' ,'name',$fullNameOpts);
		$this->getElement('name')->setAttrib('class','inputAccesible');
	}

	/**
	 * Add street address
	 */
	private function addRelationship() {
		$streetAddressOpts = array(
                   					'required' => true,
                   					'label' => 'relationship',
									'allowEmpty'=>false,
									'belongsTo'=>'occupants',
                   					'validators' =>  array( array('stringLength', false, array(1,12) ) )
		);
		$this->addElement('text','relationship',$streetAddressOpts);
		$this->getElement('relationship')->setAttrib('class','inputAccesible');
	}

	/**
	 * @todo This particular section has to have a special validator.
	 * If we have a drivers license, you have to choose a State, so we need the same
	 * kind of validator we used in calendar
	 */
	private function addDriversLicenseAndState() {
		$translator = Zend_Registry::get('Zend_Translate');
		$idOpts = array(
			'label'=>'identificationType',
			'required'=>true,
			'multiple'=>false,
			'allowEmpty'=>false,
			'belongsTo'=>'occupants'
			);
			$this->addElement('select','idIdentification',$idOpts);
			$this->getElement('idIdentification')->addMultiOption(null,$translator->_('chooseIdMethod'));
			$this->getElement('idIdentification')->addMultiOption(1,$translator->_('driversLicense'));
			$this->getElement('idIdentification')->addMultiOption(2,$translator->_('govLicense'));
			$this->getElement('idIdentification')->setAttrib('class','inputAccesible');

			$driversLicenseOpts = array(
				'required'=>true,
                'label'=>'identification',
                'validators' =>  array( array('stringLength', false, array(3,11) )	),
				'allowEmpty'=>false
			);

			$this->addElement('text','identification',$driversLicenseOpts);
			$this->getElement('identification')->setAttrib('class','inputAccesible');

			//	Not likely to change
			$states = array('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') ;
			$statesOpts = array('required'=>true,'label'=>'andState','allowEmpty'=>false,'belongsTo'=>'occupants');
			$selectOpts = array(
							'label' => 'state',
							'required' => true,
							'multiple'=>false
			);
			$this->addElement('select','state',$selectOpts);
			$this->getElement('state')->addMultiOption(null, $translator->_('selectStateEmptyOption'));
			foreach($states as $id=>$stateAbreviation) {
				$this->getElement('state')->addMultiOption(++$id, $stateAbreviation);
			}

			$this->getElement('state')->setAttrib('class','inputAccesible');

			//	Finally push the validation options for this. Please refer to the comments in the class for info
			$validation = new ZFForm_Driverlicensestate();
			$this->getElement('identification')->addValidator($validation);
	}

	/**
	 * Add the Ssn
	 * @todo Find regex for SSN or just validate that it has 9 numbers
	 */
	private function addSsn() {
		$ssnOpts = array(
			'label'=>'ssn',
			'required'=>true,
			'description'=>'ssnDescription',
			'validators' =>  array('int', array('stringLength', false, array(9)) ),
			'allowEmpty'=>false,
			'belongsTo'=>'occupants'
			);
			$this->addElement('text','ssn',$ssnOpts);
			$this->getElement('ssn')->setAttrib('class','inputAccesible');
	}

	/**
	 * @todo Needs validation for <strong>date</strong>
	 */
	private function addBirthDate() {
		$dateCheck = new ZFForm_Datevalidate();
		$birthdateOpts = array(
			'label'=>'dob',
			'required'=>true,
			'readonly' => true,
			'allowEmpty'=>false,
			'belongsTo'=>'occupants'
			);
			$this->addElement('text','dob',$birthdateOpts);
			$this->getElement('dob')->setAttrib('class','inputAccesible');
			$this->getElement('dob')->addValidator($dateCheck);
	}

	/**
	 * Add an enum displaying the sex options
	 */
	private function addSex() {
		$sexOpts = array('required'=>true,'label'=>'sex','multiple'=>false,'allowEmpty'=>false,'belongsTo'=>'occupants');
		$this->addElement('select','sex',$sexOpts);
		$translator = Zend_Registry::get('Zend_Translate');
		$this->getElement('sex')->addMultiOption(null, $translator->_('selectSexEmpty'));
		$sex = array('m','f');
		foreach($sex as $id=>$sexOption) {
			$this->getElement('sex')->addMultiOption(++$id, ucfirst($sexOption));
		}
		$this->getElement('sex')->setAttrib('class','inputAccesible');
	}
}