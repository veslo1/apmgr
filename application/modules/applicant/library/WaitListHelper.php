<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Helper for the session in the wait list</p>
 */
class Applicant_Library_WaitListHelper extends Applicant_Library_Workflow implements Applicant_Library_Interface_WorkFlow {

	/**
	 * Name used for the session
	 * @var string
	 */
	protected $sessionNamespace;

	public function __construct() {
		$this->sessionNamespace = "waitlistApply";
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::initSession()
	 */
	public function initSession() {
		$this->initSessionHandler($this->sessionNamespace);
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::getSessionNameSpace()
	 */
	public function getSessionNamespace() {
		return $this->sessionNamespace;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::setSessionNameSpace()
	 */
	public function setSessionNameSpace($name) {
		$this->sessionNamespace = $name;
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::getSteps()
	 */
	public function getSteps() {
		return array('action'=>null,'controller'=>null,'module'=>null);
	}

	/* (non-PHPdoc)
	 * @see application/modules/applicant/library/Interface/Applicant_Library_Interface_WorkFlow::terminateSession()
	 */
	public function terminateSession() {
		$this->getSessionSteps()->unsetAll();
	}


	/**
	 * Answer a petition from a controller and determine the steps the user should follow
	 * @param Zend_Request $args
	 * @return array
	 */
	public function waitListCommand($args) {
		$buffer = $this->getSteps();
		if( $args['haveaccount']==1) {
			$buffer['action'] = 'applyuser';
			$buffer['controller'] = 'apply';
			$buffer['module'] = 'applicant';
		} elseif( $args['haveaccount']==0) {
			$buffer['action'] = 'index';
			$buffer['controller'] = 'join';
			$buffer['module'] = 'user';
		} else {
			throw new Exception('action has not been taken into account');
		}
		$this->setSessionSteps('modelId', $args['model']);
		$this->setSessionSteps('steps', $buffer);
		$this->setSessionSteps('end',array('action'=>'apply','controller'=>'waitlist','module'=>'applicant'));
		return $buffer;
	}
}