<?php
/**
 * Handle the communication between the user that wants to log in and apply for a house
 *
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @author Rachael Michelle Laney <wtcfg1@gmail.com>
 */
class Applicant_ApplyController extends ZFController_Controller implements ZFObserver_ILogeable {
	/**
	 * The Apply Helper that is used in this controller
	 * @var Applicant_Library_Helper
	 */
	protected $appHelper;

	/* (non-PHPdoc)
	 * @see Controller/Zend_Controller_Action::postDispatch()
	 */
	public function preDispatch() {
		$action = $this->getRequest()->getActionName();
		//	We won't validate this actions
		$skip = array('index','message');
		$validate = !in_array($action,$skip);
		if( $validate==true )
		{
			$this->appHelper = new Applicant_Library_Helper_Apply( array('workFlowHelper'=>new Applicant_Library_WorkflowHelper()) );
			$this->appHelper->validateWorkflowStep();
			if( $this->appHelper->getIsError()!=null )
			{
				$this->_redirect('applicant/apply/message',array('exit'=>true));
			}
			$this->view->msg = null;
		}
	}

	/**
	 * The main action for applicant that is applying to a unit.
	 */
	public function indexAction() {
		$appHelper = new Applicant_Library_Helper_Apply();
		$appHelper->validateGetParams($this->getRequest()->getParams());

		if( $appHelper->getIsError()==NULL ) {
			$form = new Default_Form_Authenticated();
			if( $this->getRequest()->isPost() and $form->isValid( $this->getRequest()->getParams() ) ) {
				//	Start the session
				$awh = new Applicant_Library_WorkflowHelper();
				$awh->initSession();
				//	Save in the session the unit,model and apartment he was applying to
				$awh->setSessionSteps('model',$this->getRequest()->getParam('model'));
				$awh->setSessionSteps('unit',$this->getRequest()->getParam('unit'));
				$awh->setSessionSteps('apartment',$this->getRequest()->getParam('apartment'));
				//	With the post information determine what we should do, and session will be refreshed after this step
				$gotoUrl = $awh->routeAuthenticateUser($this->getRequest()->getParams());
				//	Fetch the steps
				$this->_redirector = $this->_helper->getHelper('Redirector');
				$this->_redirector->gotoUrl( $gotoUrl );
			}
			$this->view->form = $form;
		} else {
			$this->view->msg = $appHelper->getStackError();
		}
	}

	/**
	 * If we are applying a user, and we inform the application that we have an account,
	 * provide the information.
	 * If we are applying ourselfs in the app, then we know that information.
	 */
	public function applyuserAction() {
		$form = new User_Form_Join();
		$form->setLegend( 'applicantLogin' ); 
		if( $this->getRequest()->isPost() and $form->isValid( $this->getRequest()->getParams() ) ) {
			$appHelper = new Applicant_Library_Helper_Apply();
			//	Determine if this user is valid , clean the sesion if we had one.
			if( $appHelper->authenticateUser($this->getRequest()->getParams() ,$this->isLoggedin() ) == true ) {
				$user = new User_Model_User();
				$user = array_shift($user->findByKey(array( 'returnClassObject'=>true, 'search'=>array( 'username'=>$this->getRequest()->getParam('username'),'emailAddress'=>$this->getRequest()->getParam('emailAddress'),'password'=>sha1($this->getRequest()->getParam('password')) ))));
				//	Retrieve the current workflow
				$zfControl = new ZFWorkflow_WorkflowControl();
				$destUrl = $zfControl->passUser(array('userid'=>$user->getId()));
				if( empty($destUrl) ) {
					//TODO Handle this situation, it's a problem
					$this->view->msg = 'noApplicantSessionDetected';
					$this->view->type = 'error';
				}else{
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($destUrl);
				}
				//	just move to the next step
			} else {
				$this->view->msg = 'usernotfound';
				$this->view->type = 'error';
			}
		}
		$form->setForm();
		$this->view->form = $form;
	}

	/**
	 * the applicant's rental/criminal history
	 */
	public function rentalcriminalhistoryAction() {
		$form = new Applicant_Form_RentalCriminalHistory();
		$form->setForm();
		$id = $this->appHelper->getWorkFlowHelper()->repopulateForm($form,'eight');
		if ( $this->getRequest()->isPost() and $form->isValid( $this->getRequest()->getParams() )  ) {
			$formValues = $form->getValues();
			$formValues['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$formValues['id'] = $id;
			$applicantCriminalObj = new Applicant_Model_RentalCriminalHistory($formValues);
			$saved = $applicantCriminalObj->save();
			if( false!=$saved ) {
				$formValues['id'] = $saved;
				$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$formValues,'name'=>'eight','current'=>0,'complete'=>1));
				$this->_redirector = $this->_helper->getHelper('Redirector');
				$this->_redirector->gotoUrl($destUrl);
			}
			$this->view->msg = $this->getMessage('errorSaving');
		}
		$this->view->form = $form;
	}

	/**
	 * The user provides details about him/her when he's applying for a house
	 */
	public function aboutyouAction() {
		$form = new Applicant_Form_AboutYou();
		$form->setForm();
		$id = $this->appHelper->getWorkFlowHelper()->repopulateForm($form,'two');
		if ( $this->getRequest()->isPost() and $form->isValid( $this->getRequest()->getParams())  ) {
			$args = $this->getRequest()->getParams();
			$args['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$args['id'] = $id;
			$personalInfo = new Applicant_Model_PersonalInfo( $args );
			try {
				$saved = $personalInfo->save();
				if( $saved ) {
					$args['id'] = $saved;
					$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$args,'name'=>'two','current'=>0,'complete'=>1) );
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($destUrl);
				}
			} catch(Zend_Db_Exception $e) {
				$this->appHelper->logFails($this, $e,__FUNCTION__);
			}
			$this->view->msg = $this->getMessage('aboutyouWarning');
		}
		$this->view->form = $form;
	}

	/**
	 * The user provides details about his current house
	 */
	public function currentaddressAction() {
		$form = new Applicant_Form_Address();
		$form->setForm();
		$id = $this->appHelper->getWorkFlowHelper()->repopulateForm($form,'three');
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
			$formValues = $form->getValues();
			$formValues['isCurrentResidence']=1;
			$formValues['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$formValues['id'] = $id;
			$applicantAddressObj = new Applicant_Model_Address($formValues);
			try {
				$saved =$applicantAddressObj->save();
				if( $saved!=false ) {
					$formValues['id'] = $saved;
					//	Update the transaction and fetch the next step
					$destUrl =  $this->appHelper->commandWorkFlow(array ( 'payload'=>$formValues,'name'=>'three','current'=>0,'complete'=>1) );
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($destUrl);
				}
			} catch (Exception $e) {
				$this->appHelper->logFails($this, $e,__FUNCTION__);
			}
			$this->view->msg = $this->getMessage('errorSaving');
		}
		$this->view->form = $form;
	}

	/**
	 * The user adds information regarding his past residence
	 */
	public function previousaddressAction() {
		$id = null;
		$form = new Applicant_Form_Address();
		$form->setIsSkippable(true);
		$form->setForm();
		//	If we have information for this step , then populate the form
		$id = $this->appHelper->getWorkFlowHelper()->repopulateForm($form,'four');

		// If skipped clicked, goes to next page in the workflow
		if( $this->getRequest()->isPost() ) {
			if ( $this->getRequest()->getParam('skip')  ) {
				$destUrl = $this->appHelper->commandWorkFlow( array ( 'payload'=>null,'name'=>'four','current'=>0,'complete'=>1) );
				$this->_redirector = $this->_helper->getHelper('Redirector');
				$this->_redirector->gotoUrl($destUrl);
			} else if( $form->isValid($this->getRequest()->getParams() )  ) {
				//  Processes form
				$formValues = $form->getValues();
				$formValues['isCurrentResidence'] = 0;
				$formValues['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
				$formValues['id'] = $id;
				$applicantAddressObj = new Applicant_Model_Address($formValues);
				try {
					$saved = $applicantAddressObj->save();
					if( $saved!=false ) {
						$formValues['id'] = $saved;
						$destUrl =  $this->appHelper->commandWorkFlow(array ( 'payload'=>$formValues,'name'=>'four','current'=>0,'complete'=>1) );
						$this->_redirector = $this->_helper->getHelper('Redirector');
						$this->_redirector->gotoUrl($destUrl);
					}
				} catch (Exception $e) {
					$this->appHelper->logFails($this, $e,__FUNCTION__);
				}
				$this->view->msg = $this->getMessage('errorSaving');
			}
		}
		$this->view->form = $form;
	}

	/**
	 * The user adds information regarding his current work history
	 */
	public function currentworkhistoryAction() {
		$form = new Applicant_Form_WorkHistory();
		$form->setForm();
		$id=$this->appHelper->getWorkFlowHelper()->repopulateForm($form,'five');
		$this->view->form = $form;
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
			$formValues = $form->getValues();
			$formValues['isCurrentEmployer']=1;
			$formValues['dateEnded'] = $formValues['dateEnded']==''?null:$formValues['dateEnded'];
			$formValues['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$formValues['id'] = $id;
			$applicantWorkObj = new Applicant_Model_WorkHistory($formValues);
			try {
				$saved = $applicantWorkObj->save();
				if( $saved!=false) {
					$formValues['id'] = $saved;
					$destUrl = $this->appHelper->commandWorkFlow( array ( 'payload'=>$formValues,'name'=>'five','current'=>0,'complete'=>1) );
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($destUrl);
				}
			} catch (Exception $e) {
				$this->appHelper->logFails($this, $e, __FUNCTION__);
			}
			$this->view->msg = $this->getMessage('errorSaving');
		}
	}

	/**
	 * The user adds information regarding his past work history
	 */
	public function previousworkhistoryAction() {
		$form = new Applicant_Form_WorkHistory();
		$form->setIsSkippable(true);
		$form->setForm();
		$id = $this->appHelper->getWorkFlowHelper()->repopulateForm($form,'six');
		$this->view->form = $form;

		// If skipped clicked, goes to next page in the workflow
		if ( $this->getRequest()->isPost() and $this->getRequest()->getParam('skip')  ) {
			$destUrl = $this->appHelper->commandWorkFlow( array ( 'payload'=>null,'name'=>'six','current'=>0,'complete'=>1) );
			$this->_redirector = $this->_helper->getHelper('Redirector');
			$this->_redirector->gotoUrl($destUrl);
		} else if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
			//  Processes form
			$formValues = $form->getValues();
			$formValues['isCurrentEmployer']=0;
			$formValues['dateEnded'] = $formValues['dateEnded']==''?null:$formValues['dateEnded'];
			$formValues['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$formValues['id'] = $id;
			$applicantWorkObj = new Applicant_Model_WorkHistory($formValues);
			try {
				$saved =$applicantWorkObj->save();
				if ( false!=$saved ) {
					$formValues['id'] = $saved;
					$destUrl = $this->appHelper->commandWorkFlow( array ( 'payload'=>$formValues,'name'=>'six','current'=>0,'complete'=>1 ) );
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($destUrl);
				}
			} catch (Exception $e) {
				$this->appHelper->logFails($this, $e, __FUNCTION__);
			}
			$this->view->msg = $this->getMessage('errorSaving');
		}
	}

	/**
	 * applicant's credit history
	 */
	public function credithistoryAction() {
		$form = new Applicant_Form_CreditHistory();
		$form->setForm();
		$id = $this->appHelper->getWorkFlowHelper()->repopulateForm($form,'seven');
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
			$formValues = $form->getValues();
			$formValues['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$formValues['id'] = $id;
			$creditObj = new Applicant_Model_CreditHistory($formValues);
			try {
				$saved = $creditObj->save() ;
				if( false!=$saved ) {
					$formValues['id'] = $saved;
					$destUrl = $this->appHelper->commandWorkFlow(array('payload'=>$formValues,'name'=>'seven','current'=>0,'complete'=>1));
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($destUrl);
				}
			} catch (Exception $e) {
				$this->appHelper->logFails($this, $e, __FUNCTION__);
			}
			$this->view->msg = $this->getMessage('errorSaving');
		}
		$this->view->form = $form;
	}


	/**
	 * Applicant spouse information
	 */
	public function spouseAction() {
		$form = new Applicant_Form_Spouse();
		$form->setIsSkippable(true);
		$form->setForm();
		$id = $this->appHelper->getWorkFlowHelper()->repopulateForm($form,'nine');
		if ( $this->getRequest()->isPost() and $this->getRequest()->getParam('skip')  )
		{
			$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$this->getRequest()->getParams(),'name'=>'nine','current'=>0,'complete'=>1) );
			$this->_redirector = $this->_helper->getHelper('Redirector');
			$this->_redirector->gotoUrl($destUrl);
		}
		else if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) )
		{
			$formValues = $form->getValues();
			$formValues['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$formValues['id'] = $id;
			$applicantAddressObj = new Applicant_Model_Spouse($formValues);
			try
			{
				$saved = $applicantAddressObj->save();
				if( false!=$saved )
				{
					$formValues['id'] = $saved;
					$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$formValues,'name'=>'nine','current'=>0,'complete'=>1) );
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($destUrl);
				}
			}
			catch (Exception $e)
			{
				$this->appHelper->logFails($this, $e, __FUNCTION__);
			}
			$this->view->msg = $this->getMessage('errorSaving');
		}
		
		$this->view->form = $form;
	}

	/**
	 * Add information regarding the people that he is going to be living with.
	 * @internal First attempt to resolve the issue of dynamic forms in Zend Framework
	 * reusing their own objects
	 */
	public function occupantsAction() {
		$formControl = new ZFForm_FormControl();
		//	Fetch the steps for this step
		$steps = $this->appHelper->getWorkFlowHelper()->getSessionStepsKey('steps');
		$payload = unserialize($steps['ten']['payload']);
		//	if payload is not an array, just use the request
		if( !is_array($payload) ) {
			$payload = $this->getRequest()->getParams();
		}

		//	And populate the form again
		$form = $formControl->repopulateForm(array('name'=>'Applicant_Form_Occupants','formName'=>'occupants','childForm'=>'Applicant_Form_SubOccupants'),$payload);
		//	If he skips the page, just move on
		if( $this->getRequest()->getParam('skip') ) {
			$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$this->getRequest()->getParams(),'name'=>'ten','current'=>0,'complete'=>1,'applicantId'=>$applicantId) );
			$this->_redirector = $this->_helper->getHelper('Redirector');
			$this->_redirector->gotoUrl($destUrl);
		} elseif( $this->getRequest()->getParam('submit') and $formControl->validateForm($form,$payload,'occupants') ) {
			$iterator = new Applicant_Library_OcupantFilterIterator(new ArrayIterator($payload));
			$saved = array();
			try {
				foreach($iterator as $key=>$value) {
					$occupants = new Applicant_Model_Occupant($value);
					$occupants->setApplicantId( $this->appHelper->getWorkFlowHelper()->getApplicantId() );
					$saved[$key] = $occupants->save();
					//	Foreach form , save the id
					$payload[$key]['id'] = $value;
				}
				if( !in_array(false,$saved) ) {
					$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$payload,'name'=>'ten','current'=>0,'complete'=>1) );
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($destUrl);
				}
				$this->view->msg = $this->getMessage('errorSaving');
			} catch (Zend_Db_Exception $e) {
				$this->appHelper->logFails($this, $e, __FUNCTION__);
			}
			$this->view->msg = $this->getMessage('errorSaving');
		}
		$this->view->form = $form;
	}

	public function vehiclesAction() {
		//	if payload is not an array, just use the request
		$formControl = new ZFForm_FormControl();
		$steps = $this->appHelper->getWorkFlowHelper()->getSessionStepsKey('steps');
		$payload = unserialize($steps['eleven']['payload']);
		if( !is_array($payload) ) {
			$payload = $this->getRequest()->getParams();
			$form = $formControl->repopulateForm(array('name'=>'Applicant_Form_Vehicles','formName'=>'vehicles','childForm'=>'Applicant_Form_SubVehicles'),$payload);
		} else {
			$form = $formControl->repopulateForm(array('name'=>'Applicant_Form_Vehicles','formName'=>'vehicles','childForm'=>'Applicant_Form_SubVehicles'),$payload);
		}

		//	If he skips the page, just move on
		if( $this->getRequest()->getParam('skip') ) {
			$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$this->getRequest()->getParams(),'name'=>'eleven','current'=>0,'complete'=>1) );
			$this->_redirector = $this->_helper->getHelper('Redirector');
			$this->_redirector->gotoUrl($destUrl);
		} elseif( $this->getRequest()->getParam('submit') and $formControl->validateForm($form,$this->getRequest()->getParams()) ) {
			//	If he says that he is going to save , just try this
			$iterator = new Applicant_Library_VehicleFilterIterator(new ArrayIterator($this->getRequest()->getParams()));
			$saved = array();
			try {
				foreach($iterator as $key=>$value) {
					$vehicles = new Applicant_Model_Vehicles($value);
					$vehicles->setApplicantId($this->appHelper->getWorkFlowHelper()->getApplicantId());
					$saved[$key] = $vehicles->save();					
				}
				if( !in_array(false,$saved) ) {
					foreach($saved as $key=>$value) {
						$payload[$key]['id'] = $value;
					}
					$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$payload,'name'=>'eleven','current'=>0,'complete'=>1) );
					$this->_redirector = $this->_helper->getHelper('Redirector');
					$this->_redirector->gotoUrl($destUrl);
				}
				else{
				    $this->view->msg = $this->getMessage('errorSaving');
				}
			} catch (Zend_Db_Exception $e) {
				$this->view->msg = $this->getMessage('errorSaving');
			}
		}
		$this->view->form = $form;
	}

	/**
	 *  applicant emergency contact
	 */
	public function emergencycontactAction() {
		$form = new Applicant_Form_EmergencyContact();
		$form->setForm();
		$id=$this->appHelper->getWorkFlowHelper()->repopulateForm($form,'thirteen');
		if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams())  ) {
			$formValues = $form->getValues();
			$formValues['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$formValues['id'] = $id;

			$contactObj = new Applicant_Model_EmergencyContact($formValues);
			$id = $contactObj->save();

			if( false!=$id) {
				$formValues['id'] = $id;
				$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$formValues,'name'=>'thirteen','current'=>0,'complete'=>1) );
				$this->_redirector = $this->_helper->getHelper('Redirector');
				$this->_redirector->gotoUrl($destUrl);
			}
			$this->view->msg = $this->getMessage('errorSaving');
		}
		$this->view->form = $form;
	}

	/**
	 *
	 * Why are you renting in this property
	 */
	public function whyyourentedAction() {
		$form = new Applicant_Form_Survey();
		$form->setForm();
		$id = $this->appHelper->getWorkFlowHelper()->repopulateForm($form,'twelve');
		if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) ) {
			$args = $this->getRequest()->getParams();
			$args['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$args['id'] = $id;
			$answers = new Applicant_Model_Survey($args);
			$id = $answers->save();
			if( false!=$id ) {
				$destUrl =  $this->appHelper->commandWorkFlow(array('payload'=>$args,'name'=>'twelve','current'=>0,'complete'=>1) );
				$this->_redirector = $this->_helper->getHelper('Redirector');
				$this->_redirector->gotoUrl($destUrl);
			}
			$this->view->msg = $this->getMessage('errorSaving');
		}
		$this->view->form = $form;
	}

	/**
	 * Final step in the application , the user agrees on all and clicks.
	 */
	public function authorizationAction() {
		$form = new Applicant_Form_Authorization();
		$form->setForm();
		$id=$this->appHelper->getWorkFlowHelper()->repopulateForm($form,'fourteen');
		if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) ) {
			$args = $this->getRequest()->getParams();
			$args['unitId'] = $this->appHelper->getWorkFlowHelper()->getSessionStepsKey('unit');
			$args['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$args['id'] = $id;
			$destUrl = $this->appHelper->routeUserContract($args);
			if($destUrl!=''){
				$this->_redirector = $this->_helper->getHelper('Redirector');
				$this->_redirector->gotoUrl($destUrl);
			}
		}
		$this->view->form = $form;
	}

	/**
	 * Finish the workflow
	 */
	public function endAction() {
		//	Finalize the workflow and inform the user that he is applied and should promptly receive an email
		$this->appHelper->finalizeWorkflow();
	}

	/**
	 * The user decides that he won't accept the application rules ,
	 * so we proceed to delete his information
	 */
	public function removeinfoAction() {
		$form = new Applicant_Form_ConfirmDeleteInfo();
		$form->setForm();
		if( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams() ) )
		{
			$args = $this->getRequest()->getParams();
			$args['applicantId'] = $this->appHelper->getWorkFlowHelper()->getApplicantId();
			$destUrl = $this->appHelper->confirmPurge($args);
			$this->_redirector = $this->_helper->getHelper('Redirector');
			$this->_redirector->gotoUrl($destUrl);
		}
		$this->view->form = $form;
	}

	/**
	 * If we detect a user that is trying to do one of the steps of the work flow
	 * we will be redirected to this page and we will see this message.
	 */
	public function messageAction() {
		$this->view->msg = 'noApplicantSessionDetected';
	}

	/**
	 *@return string
	 */
	public function __toString()
	{
		return "ApplicantApply";
	}
}
?>