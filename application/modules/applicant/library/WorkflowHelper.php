<?php
/**
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 * @package modules.applicant.library
 * @internal Handles the workflow steps for an applicant applying to a unit
 */
class Applicant_Library_WorkflowHelper extends Applicant_Library_Workflow implements Applicant_Library_Interface_WorkFlow
{
	/**
	 * Name used for the session
	 * @var string
	 */
	protected $sessionNamespace;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->sessionNamespace = "applicantApply";
	}

	/* (non-PHPdoc)
	 * @see modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::getSessionNameSpace()
	 */
	public function getSessionNameSpace()
	{
		return $this->sessionNamespace;
	}

	/* (non-PHPdoc)
	 * @see modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::setSessionNameSpace()
	 */
	public function setSessionNameSpace($name)
	{
		$name = true===empty($name)?"applicantApply":$name;
		$this->sessionNamespace = $name;
	}

	/* (non-PHPdoc)
	 * @see modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::initSession()
	 */
	public function initSession()
	{
		$name = $this->sessionNamespace;
		if( !isset($name) )
		{
			throw new Applicant_Library_Exception("The identifier for the session has not been set");
		}
		$this->initSessionHandler($name);
		return $this;
	}

	/* (non-PHPdoc)
	 * @see modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::getSteps()
	 */
	public function getSteps()
	{
		$steps = array(
						'one'=>array(
									'page' => 'apply',
									'url' => 'applicant/apply/index',
									'complete' => null,
									'payload'  => null,
									'current'  => null,
									'action'   => null,
									'next'     => 'applicant/apply/aboutyou'
									),
						'two'=>array(
									'page'=>'aboutYou',
									'url' => 'applicant/apply/aboutyou',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/currentaddress',
									'prev' => 'applicant/apply/index'
									),
						'three'=>array(
									'page'=>'address',
									'url'=>'applicant/apply/currentaddress',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/previousaddress',
									'prev' => 'applicant/apply/aboutyou'
									),
						'four'=>array(
									'page'=>'previousApplicantAddress',
									'url'=>'applicant/apply/previousaddress',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/currentworkhistory',
									'prev' => 'applicant/apply/currentaddress'
									),
						'five'=>array(
									'page'=>'currentWorkHistory',
									'url'=>'applicant/apply/currentworkhistory',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/previousworkhistory',
									'prev' => 'applicant/apply/previousaddress'
									),
						'six'=>array(
									'page'=>'previousWorkHistory',
									'url'=>'applicant/apply/previousworkhistory',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/credithistory',
									'prev' => 'applicant/apply/currentworkhistory'
									),
						'seven'=>array(
									'page'=>'applicantCreditHistory',
									'url'=>'applicant/apply/credithistory',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/rentalcriminalhistory',
									'prev' => 'applicant/apply/previousworkhistory'
									),
						'eight'=>array(
									'page'=>'rentalCriminalHistory',
									'url'=>'applicant/apply/rentalcriminalhistory',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/spouse',
									'prev' => 'applicant/apply/credithistory'
									),
						'nine'=>array(
									'page'=>'spouse',
									'url'=>'applicant/apply/spouse',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/occupants',
									'prev' => 'applicant/apply/rentalcriminalhistory'
									),
					   'ten'=>array(
									'page'=>'otherOccupantsForm',
									'url'=>'applicant/apply/occupants',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/vehicles',
									'prev' => 'applicant/apply/spouse'
									),
					   'eleven'=>array(
									'page'=>'vehicles',
									'url'=>'applicant/apply/vehicles',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/whyyourented',
									'prev' => 'applicant/apply/occupants'
									),
						'twelve'=>array(
									'page'=>'whyYouRentedHere',
									'url'=>'applicant/apply/whyyourented',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/emergencycontact',
									'prev' => 'applicant/apply/vehicles'
									),
						'thirteen'=>array(
									'page'=>'applicantEmergencyContact',
									'url'=>'applicant/apply/emergencycontact',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/authorization',
									'prev' => 'applicant/apply/whyyourented'
									),
						'fourteen'=>array(
									'page'=>'authorizationLabel',
									'url'=>'applicant/apply/authorization',
									'complete'=> null,
									'payload'=>  null,
									'current'=>  null,
									'action' =>  'applicant/apply/removeinfo',
									'next'	 => 'applicant/apply/end',
									'prev'   => 'applicant/apply/applicantemergencycontact'
									)
									);

									return $steps;
	}

	/**
	 * Route the proper step after the user clicks on the form to determine if he has an account or not
	 * @internal Since this is the first step in the application, we set the session here
	 * @return string
	 */
	public function routeAuthenticateUser(array $request=null)
	{
		//	Fetch the "map"
		$buffer = $this->getSteps();
		$buffer['one']['payload'] = $request;
		$buffer['one']['action'] = 1==$request['haveaccount'] ? 'applicant/apply/applyuser':'user/join/index';
		// We set in the session the current step
		$buffer['one']['current'] = 1;
		//	We haven't finished this step yet
		$buffer['one']['complete'] = 0;
		//	Update the session with what we receive so it's kickstarted
		$this->setSessionSteps('steps',$buffer);
		return $buffer['one']['action'];
	}

	/**
	 * Complete a step and move the session to the new phase
	 * @param array $args
	 * @throws Applicant_Library_Exception
	 * @throws Zend_Db_Exception
	 */
	public function updateStep(array $args=null)
	{
		//	fetch information <strong>from session</strong>
		$buffer = $this->getSessionStepsKey('steps');
		if( !isset($buffer[$args['name']] ) )
		{
			throw new Applicant_Library_Exception('Step '.$args['name'].' does not exists on the workflow');
		}
		$name = $args['name'];
		//	Prepare the information to be saved
		$buffer[$name]['complete'] = $args['complete'];
		$buffer[$name]['current']  = $args['current'];
		$buffer[$name]['payload'] = serialize($args['payload']);
		//	Step over the 'steps' namespace
		$this->setSessionSteps('steps',$buffer);
		$data = array('page'=>$buffer[$name]['page'],'name'=>$name,'complete'=>$args['complete'],'payload'=>serialize($args['payload']),'current'=>$args['current'],'action'=>$buffer[$name]['action'],'next'=>$buffer[$name]['next'],'applicantId'=>$args['applicantId']);
		$aTransaction = new Applicant_Model_ApplicantTransaction($data);
		$result = $aTransaction->save();
		return $result;
	}

	/**
	 * Retrieve the next step in the workflow
	 * @param string $name
	 * @return string
	 */
	public function fetchNextStep($name)
	{
		$payload = $this->getSessionStepsKey('steps');
		return $payload[$name]['next'];
	}

	/**
	 * @return int
	 */
	public function getApplicantId()
	{
		return $this->getSessionStepsKey('applicantId');
	}


	/* (non-PHPdoc)
	 * @see modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::terminateSession()
	 */
	public function terminateSession()
	{
		$this->getSessionSteps()->unsetAll();
	}

	/**
	 * If the user clicks back , repopulate the form by pulling up the stored information in session.
	 * Optional , if we had an id, we return it, so we perform an update over the table we are currently
	 * working
	 * @param Zend_Form $form
	 * @param string $stepName The name of the session element you want to retrieve
	 * @return integer
	 */
	public function repopulateForm(Zend_Form &$form,$stepName)
	{
		$cache = $this->getSessionStepsKey('steps');
		$id = null;
		if( isset($cache[$stepName]) )
		{
			$populate = unserialize($cache[$stepName]['payload']);
			if ( is_array($populate) )
			{
				$form->populate($populate);
			}			
			if( !empty($populate['id']) ) {
			    $id = $populate['id'];
			}    
		}
		return $id;
	}
}