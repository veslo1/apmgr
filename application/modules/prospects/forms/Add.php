<?php
/**
 * Implementation of the Form for add prospects
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.prospects.forms
 */

class Prospects_Form_Add extends ZFForm_ParentForm
{
	/**
	 * 
	 * Provide a dao to fetch information about units
	 * @var ZFInterfaces_Dao
	 */
	private $dao;
	
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init()
	{
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setFormTranslator();
	}

	public function setForm()
	{
		$this->setLegend('prospects');
		$this->addFirstName();
		$this->addLastName();
		$this->addEmail();
		$this->addPhone();
		$this->addContactMode();
		$this->addHowDidYouHear();
		$this->addRentRangeFrom();
		$this->addRentRangeTo();
		$this->addModelType();
		$this->addPossibleMoveInDate();
		$this->addPets();
		$this->addOccupants();
		$this->addNotes();
		$this->addStatus();
		$this->addSubmitButton();
		$this->setDisplayGroup();
	}

	/**
	 * 
	 * Set the dao to fetch the information about units
	 * @param ZFInterfaces_Dao $dao
	 */
	public function setDao(ZFInterfaces_Dao $dao)
	{
		$this->dao = $dao;
	}
	
	/**
	 * 
	 * Retrieve the dao for unit model type
	 * @return ZFInterfaces_Dao
	 */
	public function getUnitTypeDao()
	{
		return $this->dao;
	}
	
	public function addFirstName()
	{
		$element = 'firstName';
		$fullNameValidator = array( array('stringLength', false, array(1, 50) ) );
		$fullNameOpts = array('required'=>true,'label'=>$element,'validators'=>$fullNameValidator);
		$this->addElement('text' ,$element,$fullNameOpts);
		$this->addDecoratorAndGroup( $element );
	}

	public function addLastName()
	{
		$element = 'lastName';
		$fullNameValidator = array( array('stringLength', false, array(1, 50) ) );
		$fullNameOpts = array('required'=>true,'label'=>$element,'validators'=>$fullNameValidator);
		$this->addElement( 'text', $element , $fullNameOpts );
		$this->addDecoratorAndGroup( $element );
	}


	public function addEmail()
	{
		$element = 'email';
		$this->addElement('text', $element, array(
                'label'      => $element,
                'required'   => false,
                'filters'    => array('StringTrim'),
                'validators' => array('EmailAddress')
		));
		$this->addDecoratorAndGroup($element);
	}

	public function addPhone()
	{
		$element = 'phone';
		$phoneOpts = array('label'=>$element,'required'=>true,'validators' =>  array( array('stringLength', false, array(3,50) )));
		$this->addElement('text',$element,$phoneOpts);
		$this->getElement($element)->addFilter('Digits');
		$this->addDecoratorAndGroup( $element );
	}
	
	public function addContactMode()
	{
		$element = 'contactMode';
		$contactOpts = array('label' => 'contactMode','required' => false);
		$this->addElement('select',$element,$contactOpts);
		foreach ($this->getContactMode() as $id=>$option)
		{
			$this->getElement($element)->addMultiOption($id, $option);
		}
		$this->addDecoratorAndGroup( $element );
	}

	public function addHowDidYouHear()
	{
		$element = 'howDidYouHear';
		$opts = array('label'=>'howDidYouHearAboutUs','required'=>false);
		$this->addElement('textarea',$element,$opts);
		$this->getElement($element)->setOptions(array('rows'=>9,'cols'=>25));
		$this->addDecoratorAndGroup( $element );
	}

	public function addRentRangeFrom()
	{
		$element = 'rentRangeFrom';
		$opts = array (
			'label' => $element,
			'required' => false,
			'filters' => array ( 'StringTrim'),
			'validators' => array ('validator' => array( 'regex', false, array('/^\d+(\.\d{1,2})?$/','messages'=>array('regexNotMatch'=>'regexrentamount')))));
		$this->addElement('text', $element, $opts);
		$this->addDecoratorAndGroup( $element );
	}

	public function addRentRangeTo()
	{
		$element = 'rentRangeTo';
		$opts = array (
			'label' => $element,
			'required' => false,
			'filters' => array ( 'StringTrim'),
			'validators' => array ('validator' => array( 'regex', false, array('/^\d+(\.\d{1,2})?$/','messages'=>array('regexNotMatch'=>'regexrentamount')))));
		$this->addElement('text', $element, $opts);
		$this->addDecoratorAndGroup( $element );
	}

	public function addModelType()
	{
		$element = 'modelType';
		$opts = array('label' => $element,'required'=>true);
		$this->addElement('multiselect',$element,$opts);
		$result = $this->dao->fetchAll();
		$list = $result->toArray();
		if(count($list)==0)
		{
			throw new Exception('The system is not properly set up');
			
		}
		else
		{
			foreach ($list as $id=>$option)
			{
				$this->getElement($element)->addMultiOption($option['id'], $option['name']);
			}
		}
		$this->addDecoratorAndGroup( $element );
	}

	public function addPossibleMoveInDate()
	{
		$element = 'possibleMoveInDate';
		$dateCheck = new ZFForm_Datevalidate();
		# readonly => true makes the element not writable
		$opts = array('label'=>$element,'required'=>true,'readonly' => true);
		$this->addElement('text',$element,$opts);
		$this->getElement($element)->addValidator($dateCheck);
		$this->addDecoratorAndGroup( $element );
	}

	public function addPets()
	{
		$element = 'pets';
		$opts = array('label'=>'havePets','required'=>true);
		$this->addElement('select',$element,$opts);
		foreach( array_reverse(self::$answer) as $id=>$opt)
		{
			$this->getElement($element)->addMultiOption($id, $opt);
		}
		$this->addDecoratorAndGroup( $element );
	}

	public function addOccupants()
	{
		$element = 'occupants';
		$opts = array('label'=>'numOtherOccupantsForm',
			      'required'=>true,
			      'filters' => array ( 'StringTrim'),
			      'validators' => array ('validator' => array( 'regex', false, array('/^[0-9]{1}$/','messages'=>array('regexNotMatch'=>'occregexnotmatch')))));
		$this->addElement('text',$element,$opts);
		$this->addDecoratorAndGroup($element);
	}
	
	public function addNotes()
	{
		$element = 'notes';
		$opts = array('label'=>$element,'required'=>false);
		$this->addElement('textarea',$element,$opts);
		$this->getElement($element)->setOptions(array('rows'=>9,'cols'=>25));
		$this->addDecoratorAndGroup( $element );
	}
	
	public function addStatus()
	{
		$element = 'status';
		$opts = array('label'=>$element , 'required'=>true);
		$this->addElement('select',$element,$opts);
		foreach( $this->getStatus() as $id=>$opt)
		{
			$this->getElement($element)->addMultiOption($id, $opt);
		}
		$this->addDecoratorAndGroup( $element );
	}
	
	/**
	 *
	 * Retrieve the set that is used for Contact Mode
	 * @return array
	 */
	public function getContactMode()
	{
		return array(0=>'walkin',1=>'phone',2=>'email');
	}
	
	public function getStatus()
	{
		return array(0=>'new',1=>'appointment',2=>'applied',3=>'notInterested');
	}
}