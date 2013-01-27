<?php
/**
 * Contains the validation of the business logic for each concrete step
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.applicant.library.implementation
 */
class Applicant_Library_Implementation_FlowStepBo implements Applicant_Library_Interface_StepBo
{
	/**
	 * Contains the business object that the controller delegates on us to handle
	 * @var Applicant_Library_Interface_FlowApplyBo
	 */
	private $bo;

	/**
	 * Contains a dao to command the wofk flow
	 * @var Applicant_Library_Interface_FlowApplyDao
	 */
	private $dao;

	/**
	 * Container for messages
	 * @var string
	 */
	private $msg;

	/**
	 * State of this object
	 * @var boolean
	 */
	private $isError;

	public function __construct()
	{
		$this->isError = false;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_StepBo::setBo()
	 */
	public function setBo(Applicant_Library_Interface_FlowApplyBo $bo)
	{
		$this->bo = $bo;
	}

	/**
	 * Retrieve the business object that we use
	 * @return Applicant_Library_Interface_FlowApplyBo
	 */
	public function getBo()
	{
		return $this->bo;
	}

	/**
	 * Set the dao
	 * @param Applicant_Library_Interface_FlowApplyDao $dao
	 */
	public function setDao(Applicant_Library_Interface_FlowApplyDao $dao)
	{
		$this->dao = $dao;
	}

	/**
	 * Retrieve the dao
	 * @return Applicant_Library_Interface_FlowApplyDao
	 */
	public function getDao()
	{
		return $this->dao;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_StepBo::indexValidate()
	 */
	public function indexValidate()
	{
		$valid = false;
		$request = $this->bo->getPayload();
		if( !empty($request) )
		{
			$stackValid = array();
			$stackValid[] = $this->validateUnit($request);
			$stackValid[] = $this->validateApartment($request);
			$stackValid[] = $this->validateModel($request);
			$valid = !in_array(false,$stackValid);
		}
		else
		{
			//TODO Translate
			$this->setMessageState('missingArguments');
		}
		$this->isError = $valid!=true;
		return $valid;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_StepBo::applyValidate()
	 */
	public function applyuserValidate()
	{
		$valid = false;
		$validWorkflow = $this->workflowSet();
		//	We need to determine if the work flow is started and also if the current step we are is the current
		if( $validWorkflow==true )
		{
			$validStep = $this->currentStepIsValid(1);
			if ( $validStep==true )
			{
				$valid = true;
				$this->isError = false;
			}
		}

		return $valid;
	}

	/**
	 * Validates if the given work flow is started with a static method.
	 * If so , then we toggle the support in our container.
	 * @internal Please , keep in mind the high cohesion this shares
	 * @return boolean
	 */
	public function workflowSet()
	{
		$valid = false;
		if( Applicant_Library_Implementation_FlowApplyDao::sessionSet('applicantApply')===true)
		{
			/**
			 * Since we depend on session , and session is used as two different things,
			 * as a persistance and also as an indicator that the elements are properly set,
			 * we fix up this scenario here. If you reach this block , then you are safe
			 * since session is tracking this user.
			 */
			$dao = $this->bo->getDao();
			if($dao===null)
			{
				$dao = new Applicant_Library_Implementation_FlowApplyDao();
				$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
				$this->bo->setDao($dao);
			}
			$valid = true;
		}
		else
		{
			$this->isError = true;
			$this->setMessageState('noApplicantSessionDetected');
		}
		return $valid;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_StepBo::currentStepIsValid()
	 */
	public function currentStepIsValid($currentStep)
	{
		$pivot = null;
		$valid = false;
		$currentDao = $this->bo->findByStepName('steps');
		$stepsIterator = new Applicant_Library_Filter_WorkflowCurrentIterator(new ArrayIterator($currentDao));
		//	This retrieves the only record that is considered current
		foreach($stepsIterator as $id=>$value)
		{
			$pivot = $value;
			$currentIndex = $id;
		}
		if($pivot == null )
		{
			throw new ErrorException("There is no current step");
		}

		if( $currentIndex == $currentStep )
		{
			$valid = $pivot['current']===true;
			if($valid==false)
			{
				//FIXME Create the translation
				$this->setMessageState('currentStepNotValid');
			}
		}
		else
		{
			//FIXME Create the translation
			$this->setMessageState('currentStepNotValid');
		}
		return $valid;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_StepBo::joinValidate()
	 */
	public function joinValidate()
	{}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_StepBo::getApplyStepForm()
	 */
	public function getApplyUserStepForm()
	{
		$form = null;
		if($this->isError==false)
		{
			$form = new User_Form_Join();
			$form->setForm();
		}
		return $form;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_StepBo::applyuserAction()
	 */
	public function applyuserAction()
	{
		$applied = false;
		$args = $this->bo->getPayload();
		$user = new User_Model_User();
		$searchArgs = array('returnClassObject'=>true, 'search'=>array('username'=>$args['username'],'emailAddress'=>$args['emailAddress'],'password'=>sha1($args['password']) ));
		$user = $user->findByKey($searchArgs);
		if($user!==null)
		{
			$user = array_shift($user);
			$applicant = new Applicant_Model_Applicant();
			$applicant->setUserId($user->getId());
			$applicantId = false;
			try
			{
				$applicantId = $applicant->save();
			}
			catch (Exception $e)
			{
				//TODO	Log and email us
			}
			if($applicantId!=false)
			{
				$saved = $this->bo->save(array('identifier'=>'applicantId','data'=>$applicantId));
				if($saved==false)
				{
					//TODO Create translation
					$this->setMessageState('unableToPersistApplicantIdInSession');
				}
				else
				{
					$auth = Zend_Auth::getInstance();
					$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
					if( $auth->getIdentity()!=null )
					{
						$auth->clearIdentity();
//						$role = new Zend_Session_Namespace('wulfStorageUserRole');
//						$role->unsetAll();
					}
					$loginHelper = new User_Library_Helper_Login();
					$success = $loginHelper->authenticateUser($args['username'],$args['password']);
					$applied = true;
				}
			}
			else
			{
				//TODO Create translation
				$this->setMessageState('unableToCreateApplicantAccount');
			}
		}
		else
		{
			$this->setMessageState('invalidCredentials');
		}
		return $applied;
	}

	public function joinAction()
	{}
	/**
	 * Validate that the unit parameter is set
	 * Validate that the unit is available for rent
	 * @param array $request
	 * @return boolean
	 */
	public function validateUnit($request)
	{
		$hasUnit = in_array('unit',array_keys($request));
		if( false==$hasUnit )
		{
			$this->setMessageState('unitIdMissing');
			return false;
		}
		else
		{
			$unit = new Unit_Model_Unit();
			$exists = $unit->exists(array('column'=>'id','table'=>'unit'), $request['unit']);
			if( false==$exists )
			{
				$this->setMessageState('unitIdNotValid');
				return false;
			}
			else
			{
				$unit = $unit->findById($request['unit']);
				if( $unit->getIsAvailable() == 0)
				{
					$this->setMessageState('unitIsNotForRent');
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Validate that the apartmentId is valid
	 * @param array $request
	 * @return boolean
	 */
	public function validateApartment($request)
	{
		$hasApartment = in_array('apartment',array_keys($request));
		if( false==$hasApartment )
		{
			$this->setMessageState('apartmentIdMissing');
			return false;
		}
		else
		{
			$apartment = new Unit_Model_Apartment();
			$exists = $apartment->exists(array('column'=>'id','table'=>'apartment'), $request['apartment']);
			if( false==$exists )
			{
				$this->setMessageState('apartmentIdNotValid');
				return false;
			}
		}
		return true;
	}

	/**
	 * Validate that the apartmentId is valid
	 * @param array $request
	 */
	public function validateModel($request)
	{
		$hasModel = in_array('model',array_keys($request));
		if( false==$hasModel )
		{
			$this->setMessageState('modelIdIsMissing');
			return false;
		}
		else
		{
			$unitModel = new Unit_Model_UnitModel();
			$exists = $unitModel->exists(array('table'=>'unitModel','column'=>'id'), $request['model']);
			if( false==$exists )
			{
				$this->setMessageState('modelIdNotValid');
				return false;
			}
		}
		return true;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_StepBo::getIndexStepForm()
	 */
	public function getIndexStepForm()
	{
		$form = null;
		if( $this->isError != true )
		{
			$form = new Default_Form_Authenticated();
		}
		return $form;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_StepBo::applyAction()
	 */
	public function indexAction()
	{
		$pass = false;
		$args = $this->bo->getPayload();
		$saved[]=$this->bo->save(array('identifier'=>'model','data'=>$args['model']));
		$saved[]=$this->bo->save(array('identifier'=>'unit','data'=>$args['unit']));
		$saved[]=$this->bo->save(array('identifier'=>'apartment','data'=>$args['apartment']));
		$buffer = $this->bo->findByStepName('steps');
		//	We toggle the current action as current
		$buffer[0]['current'] = true;
		//	We determine which would be the next step
		if($args['haveaccount']==1)
		{
			$buffer[0]['action'] = 'applicant/apply/applyuser';
		}
		else
		{
			$buffer[0]['action'] = 'user/join/index';
		}
		$saved[]=$this->bo->save(array('identifier'=>'steps','data'=>array(0=>$buffer[0])));
		$pass = !in_array(false,$saved);
		if($pass==false)
		{
			$this->setMessageState('unableToFinishIndex');
		}
		return $pass;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::setMessageState()
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::getMessageState()
	 */
	public function getMessageState()
	{
		return $this->msg;
	}

	/**
	 * Retrieve the state of this object
	 * @return boolean
	 */
	public function getIsError()
	{
		return $this->isError;
	}

	/**
	 * Used for testing
	 * @param boolean $state
	 */
	public function setIsError($state)
	{
		$this->isError = $state;
	}
}