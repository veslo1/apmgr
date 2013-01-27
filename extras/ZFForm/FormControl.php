<?php
/**
 * Utilities to handle dynamic forms
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @todo Add partial form creation , such as duplicate <strong>only one</strong> element
 */

class ZFForm_FormControl implements ZFForm_Interface_Duplicable {

	/**
	 * Determine if we duplicate
	 * @var boolean
	 */
	protected $isAdd;

	/**
	 * Determine if we remove
	 * @var boolean
	 */
	protected $isRemove;

	/**
	 * The seed of the forms.
	 * @var int
	 */
	protected $seed;


	/* (non-PHPdoc)
	 * @see library/ZFForm/Interface/ZFForm_Interface_Duplicable::setAdd()
	 */
	public function setAdd($isAdd)
	{
		$this->isAdd = $isAdd;
	}

	/* (non-PHPdoc)
	 * @see library/ZFForm/Interface/ZFForm_Interface_Duplicable::getAdd()
	 */
	public function getAdd()
	{
		return $this->isAdd;
	}

	/* (non-PHPdoc)
	 * @see library/ZFForm/Interface/ZFForm_Interface_Duplicable::setRemove()
	 */
	public function setRemove($remove)
	{
		$this->isRemove = $remove;
	}

	/* (non-PHPdoc)
	 * @see library/ZFForm/Interface/ZFForm_Interface_Duplicable::getRemove()
	 */
	public function getRemove()
	{
		return $this->isRemove;
	}

	/**
	 * Prepare the dynamic form after a request to repopulate the form.
	 * Entry point for controlling it
	 * @param array $formName
	 * @param Zend_Controller_Action $request
	 * @return Zend_Form
	 * @throws Applicant_Library_Exception
	 */
	public function repopulateForm(array $formName=null,array $request=null) {
		$this->validateFormArgs($formName);
		//	This is what we will return after working the request
		$form = new $formName['name']();
		$form->setForm();
		if( isset($request) ) {
			//	Prepare the array elements that should have values
			$this->cleanRequestParameters($request);
			//	Determine which action we are going to perform
			$this->determineAction($request);

			if( true==$this->getAdd() ) {
				$seed = $this->initAdd($request);
				$form->getElement(self::HIDDEN_INPUT)->setValue($seed);
			}

			if( true==$this->getRemove() ) {
				$seed = $this->initRemove($request);
				$form->getElement(self::HIDDEN_INPUT)->setValue($seed);
			}

			if( false==$this->getRemove() and false==$this->getAdd() ) {
				//	Just maintain the current value of the hidden input
				$form->getElement(self::HIDDEN_INPUT)->setValue($request[self::HIDDEN_INPUT]);
			}
		}
		//	Here we repopulate the form with what the user sent us
		$this->formPopulation($form,$formName['formName'],$request,$formName['childForm']);
		return $form;
	}

	/**
	 * Validate subforms
	 * @return boolean
	 */
	public function validateForm(Zend_Form $form, array $args=null) {
		//	Maintain an array of failed elements
		$resultStack = array();
		$resultStack[] = $form->isValid($form->getValues(true));
		$subForms = $form->getSubForms();
		if( count($subForms)>0 ) {
			foreach($subForms as $id=>$formElement) {
				$resultStack[]=$formElement->isValid($formElement->getValues(false));
			}
		}
		return !in_array(false,$resultStack);
	}

	/**
	 * Validate that the array elements are set
	 * @param array $args
	 */
	private function validateFormArgs(&$args) {
		//	The class that we want to use must be set
		if( !isset($args['name']) ) {
			throw new Applicant_Library_Exception('Form name must be set');
		}
		//	The name of the form must be set in order to operate with this library. This will be the subform name also, since this is the dessired effect we want to create
		if(!isset($args['formName'])) {
			throw new Applicant_Library_Exception('The form name is not set');
		}

		if(!isset($args['childForm']) ) {
			throw new Applicant_Library_Exception('Child Form is not set');
		}
		//	control the label
		if(!isset($args['args']) ) {
			$args['args'] = null;
		}
	}

	/**
	 * Fetch the request and create as many forms as control says and push on each of the forms
	 * the requestArgs that are sent
	 * @param Zend_Form $form The form you are working with to repopulate
	 * @param string $formName The name of the form you are working with
	 * @param array $requestArgs The requests you are pushing into the form , and the child form
	 * @param string $childForm The child form you are attaching to the form
	 */
	public function formPopulation(&$form,$formName,$requestArgs,$childForm) {
		$seed = $form->getElement(self::HIDDEN_INPUT)->getValue();
		//	First we fill the <strong>parent</strong> form with the defined key 0, because we know that 0 is the parent form
		if( isset($requestArgs[$formName]) ) {
			$this->repopulateParentForm($form,$formName,$requestArgs);
			//	If we have more than cero as the value of the count of subforms, validate the request and create as many subforms required
			$this->repopulateChildForm($seed,$childForm,$form,$formName,$requestArgs);
		}
	}

	/**
	 * Validate the required request control keys.
	 * If the action is not sent , set it to null
	 * @param array $request
	 */
	private function cleanRequestParameters(array &$request=null) {
		//	Sanitize the option add, that is the submit that says add
		if( !isset($request[self::ACTION_ADD]) ) {
			$request[self::ACTION_ADD] = null;
		}
		//	And if somehow we don't have a hidden input to control how many subforms we have added, set it to 0
		if( !isset($request[self::HIDDEN_INPUT]) ) {
			$request[self::HIDDEN_INPUT] = 0;
		}

		if( !isset($request[self::ACTION_REMOVE]) ) {
			$request[self::ACTION_REMOVE] = null;
		}
	}

	/* (non-PHPdoc)
	 * @see library/ZFForm/Interface/ZFForm_Interface_Duplicable::setSeed()
	 */
	public function setSeed($seed) {
		$seedValidation = new Zend_Validate_Int();
		$result = $seedValidation->isValid($seed);
		$this->seed = true===$result? $seed:1;
	}

	/* (non-PHPdoc)
	 * @see library/ZFForm/Interface/ZFForm_Interface_Duplicable::getSeed()
	 */
	public function getSeed() {
		return $this->seed;
	}

	/* (non-PHPdoc)
	 * @see library/ZFForm/Interface/ZFForm_Interface_Duplicable::determineAction()
	 */
	public function determineAction(array $request)
	{
		$this->setAdd($request[self::ACTION_ADD]!==null?true:false);
		$this->setRemove($request[self::ACTION_REMOVE]!==null and $request[self::HIDDEN_INPUT]>0?true:false);
	}

	/* (non-PHPdoc)
	 * @see library/ZFForm/Interface/ZFForm_Interface_Duplicable::initAdd()
	 */
	public function initAdd(array $request) {
		$this->setSeed($request[self::HIDDEN_INPUT]);
		$seed = $this->getSeed();
		$seed++;
		return $seed;
	}

	/* (non-PHPdoc)
	 * @see library/ZFForm/Interface/ZFForm_Interface_Duplicable::initRemove()
	 */
	public function initRemove(array $request){
		//	If the user said remove , pop out one element
		$this->setSeed($request[self::HIDDEN_INPUT]);
		$seed = $this->getSeed();
		$seed--;
		return $seed;
	}

	/**
	 * Repopulate only the parent form
	 * @param Zend_Form $form
	 * @param string $formName
	 * @param array $requestArgs
	 */
	public function repopulateParentForm(&$form,$formName,$requestArgs){
		foreach($requestArgs[$formName] as $formElement=>$formValue) {
			//	This just simply means populate this element
			$element = $form->getElement($formElement);
			if( isset($formValue) and $element!=null ) {
				$form->getElement($formElement)->setValue($formValue);
			}
		}
	}

	/**
	 * Repopulate a child form after a request
	 * @param int $seed
	 * @param string $childForm
	 * @param Zend_Form $form
	 * @param string $formName
	 * @param array $request
	 * @internal If the user did not hit add, we still must recreate the
	 * subforms and populate because Zend_Forms loose track on how many elements they have.
	 * They are not intended to be used like this exactly
	 */
	public function repopulateChildForm($seed,$childForm,&$form,$formName,array $requestArgs){
		if( $seed>0 ) {
			for($i=1;$i<=$seed;$i++) {
				$subForm = $this->spawnChildForm($childForm, $formName, $i);
				//	Push the sub_form into the form
				$form->addSubForm($subForm,$formName.self::CHILD_FORM_SEPARATOR.$i,$i);
				//	We need to verify if the user send some arguments for this particular set of form elements
				$argKey = $formName."_".$i;
				if( isset($requestArgs[$argKey]) ) {
					foreach($requestArgs[$formName."_$i"] as $key=>$value) {
						$element = $subForm->getElement($key);
						if( $element!=null ) {
							$subForm->getElement($key)->setValue($value);
						}
					}
				}
			}
		}
	}

	/**
	 * Instantiate and prepare a childForm
	 * @param string $childForm
	 * @param string $formName
	 * @param int $index
	 * return Zend_Form
	 */
	public function spawnChildForm($childForm, $formName, $index) {
		$subForm = new $childForm();
		$subForm->setAttrib('name',$formName.self::CHILD_FORM_SEPARATOR.$index);
		return $subForm;
	}
}
