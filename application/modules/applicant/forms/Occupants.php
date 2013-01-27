<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Other Occupants form</p>
 */
class Applicant_Form_Occupants extends ZFForm_ParentForm {

	protected $instructionText;

	public function setInstructionText( $var ){
		$this->instructionText = $var;
	}

	public function getInstructionText(){
		return $this->instructionText;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init
	 */
	public function init() {
		$this->setInstructionText('otherOccupantInstructions');
		$this->setFormTranslator();
	}

	public function setForm() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setAttrib('name','occupants');

		$this->addInstructions();
		$this->addFullName();
		$this->addRelationship();
		$this->addDriversLicenseAndState();
		$this->addBirthDate();
		$this->addSsn();
		$this->addSex();
		$this->addDisplayGroup(array('instructionText','name','identification','state','ssn','dob','sex','relationship'),'aboutYou',array('legend' => 'otherOccupantsForm'));
		$this->addElement('hidden','control',array('required' => true,'value'=>0));
		$this->addElement('submit','add',array('ignore'=>true,'label'=>'add'));
		$this->getElement('add')->setAttrib('class','submit');
		$this->getElement('add')->setDecorators( array( 'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		$this->addElement('submit','skip',array('ignore'=>true,'label'=>'skip'));
		$this->getElement('skip')->setAttrib('class','submit');
		$this->getElement('skip')->setDecorators( array( 'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);

		$this->addElement('submit','remove',array('ignore'=>true,'label'=>'remove'));
		$this->getElement('remove')->setAttrib('class','submit');
		$this->getElement('remove')->setDecorators( array( 'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		$this->addElement('submit', 'submit', array( 'ignore'   => true, 'label' => 'save' ));
		$this->getElement('submit')->setAttrib('class','submit');
		$this->getElement('submit')->setDecorators( array( 'ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
	}

	/**
	 *  Add instructions
	 */
	private function addInstructions(){
		if( $this->getInstructionText() ) {
			// Add custom label
			$element= new ZFForm_CustomLabel('instructionText');
			$element->setContent( $this->getInstructionText() );
			$element->setAttrib('class','instructions');
			$element->setDecorators(array('FieldsetForm'));
			$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
			$this->addElement($element);
		}
	}

	/**
	 * Add the full name of the applicant
	 */
	private function addFullName() {
		$fullNameOpts = array(
                   				'required'=>true,
								'allowEmpty'=>false,
                   				'label'=>'fullName',
								'belongsTo'=>'occupants',
                   				'validators' =>  array( array('stringLength', true, array(1, 250) )	)
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
									'belongsTo'=>'occupants',
                   					'validators' =>  array( array('stringLength', false, array(1,12) ) ),
									'allowEmpty'=>false
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
		$translator = $this->getTranslator();
		$driversLicenseOpts = array(
				'required' => true,
                'label'=>'identification',
                'validators' =>  array( array('stringLength', false, array(3,11) )	),
				'belongsTo'=>'occupants',
				'allowEmpty'=>false
		);

		$this->addElement('text','identification',$driversLicenseOpts);
		$this->getElement('identification')->setAttrib('class','inputAccesible');

		//	Not likely to change
		$states = array('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') ;
		$selectOpts = array('label' => 'state','required' => true,'isArray'=>false,'multiple'=>false,'belongsTo'=>'occupants','allowEmpty'=>false);
		$this->addElement('select','state',$selectOpts);

		$this->getElement('state')->addMultiOption(null, 'selectStateEmptyOption');
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
			'required' => true,
			'description'=>'ssnDescription',
			'validators' =>  array('int', array('stringLength', false, array(9)) ),
			'belongsTo'=>'occupants',
			'allowEmpty'=>false
		);
		$this->addElement('text','ssn',$ssnOpts);
		$this->getElement('ssn')->setAttrib('class','inputAccesible');
	}

	/**
	 * @todo In production , recall to supress errors from zend, even though this takes care of date validation, empty creates problems
	 */
	private function addBirthDate() {
		$birthdateOpts = array(
			'label'=>'dob',
			'required'=>true,
			'readonly' => true,
			'belongsTo'=>'occupants',
			'allowEmpty'=>false
		);
		$this->addElement('text','dob',$birthdateOpts);
		$this->getElement('dob')->setAttrib('class','inputAccesible')
		->addValidator('Date',false,array('format_type'=>'php','format'=>'Y-m-d'));
	}

	/**
	 * Add an enum displaying the sex options
	 */
	private function addSex() {
		$sexOpts = array(	'required' => true,
							'label'=>'sex',
							'multiple'=>false,
							'belongsTo'=>'occupants',
							'allowEmpty'=>false,
							'validators'=>
		array(
		array('validator'=> 'NotEmpty',array('integer','zero'))
		)
		);
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