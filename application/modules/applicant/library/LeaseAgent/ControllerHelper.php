<?php
/**
 * Lease agent search helper deals with the posted values and validation
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_Library_LeaseAgent_ControllerHelper extends ZFModel_ParentModel implements ZFInterfaces_Messageable {
	/**
	 * State of this object
	 * @var string
	 */
	private $state;

	/**
	 * Default form that we consume
	 * @var const
	 */
	const FORMNAME='Applicant_Form_LeaseAgentFilter';
	
	/**
	 * Get parameter that determines if we should persist or not
	 * @var string
	 */
	private $restore;
	
	/**
	 * The name of the page that you consume
	 * @var string
	 */
	private $page;
	
	public function __construct(array $options=null){
		if($options!=null){
			parent::__construct($options);
		}
	}
	
	/**
	 * Retrieve back a restore get parameter.Used to signal that we want to wake up cache
	 * @param int $restore
	 * @return Applicant_Library_LeaseAgent_ControllerHelper
	 */
	public function setRestore($restore=null){
		if( isset($restore) and (1==$restore) ){
			$this->restore = $restore;
		}
		return $this;
	}
	
	/**
	 * Return the get parameter that is used to cache information
	 * @return string
	 */
	public function getRestore(){
		return $this->restore;
	}
	
	/**
	 * Validate the completedAppsValidation action
	 * @param array $request
	 * @return boolean
	 */
	public function completedAppsValidation($request) {
		$valid = false;
		//	This block validates the applicant portion of this method
		if( !isset($request['id']) ) {
			$this->setMessageState('applicantIdMissing');
		} else {
			$applicant = new Applicant_Model_Applicant();
			if( false==$applicant->exists(array('column'=>'id','table'=>'applicant'),$request['id']) ){
				$this->setMessageState('applicantIdNotValid');
			} else {
				$valid = true;
			}
		}

		//	And this portion validates the page that it's sent
		$validPage = true;
		if( isset($request['page']) ) {
			$lAgentMapper = new Applicant_Library_LeaseAgent_DataMapper();
			$buffer = $lAgentMapper->getApplicantMap();
			$validPages = array();
			foreach($buffer as $id=>$key){
				$validPages[] = $id;
			}
			$validPage = in_array($request['page'], $validPages);
			if($validPage==false) {
				$validPage = false;
				$this->setMessageState('invalidForm');
			}
		}
		return $valid==true && $validPage == true ;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::setMessageState()
	 */
	public function setMessageState($msg){
		$this->state = $msg;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::getMessageState()
	 */
	public function getMessageState(){
		return $this->state;
	}

	/**
	 * Prepare the form that we are going to consume
	 * @param string $actionName
	 * @return Applicant_Form_LeaseAgentFilter
	 */
	public function getForm($actionName){
		$form = new Applicant_Form_LeaseAgentFilter();
		switch($actionName){
			case 'view':
				$statuses = new Applicant_Model_ApplicantStatus();
				$status=$statuses->fetchAll(null,null,true);
				$status['type'] ='object';
				$form->setStatuses($status);
				break;
			case 'waitlist':default:
				break;
		}
		$form->setForm();
		return $form;
	}
	
	/**
	 * @param string $page
	 * @return Applicant_Library_LeaseAgent_ControllerHelper
	 */
	public function setPage($page=null){
		if($page!=null){
			$this->page = $page;
		}
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getPage(){
		return $this->page;
	}
	
	
}