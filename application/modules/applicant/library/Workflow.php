<?php
/**
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 * General methods for workflows
 */
abstract class Applicant_Library_Workflow {
	/**
	 * Session object that holds the information
	 * @var Zend_Session
	 */
	protected $sessionSteps;

	/**
	 * Retrieve the user information
	 * @return Zend_Auth
	 */
	public function getCredentials() {
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		return $auth;
	}

	/**
	 * Set the specified session namespace
	 * @param string $namespace
	 */
	protected function initSessionHandler($namespace) {
		$this->sessionSteps = new Zend_Session_Namespace($namespace);
		if ( !isset($this->sessionSteps->initialized) ) {
			Zend_Session::regenerateId();
			$this->sessionSteps->initialized = true;
		}
	}

	/**
	 * @return Zend_Session_Namespace
	 */
	public function getSessionSteps() {
		return $this->sessionSteps;
	}

	/**
	 * Wipe out the session
	 * @param $namespace
	 */
	public function cleanSessionSteps($namespace) {
		$session = new Zend_Session_Namespace($namespace);
		$session->unsetAll();
	}

	/**
	 * Push a value inside the session
	 * @param string $name
	 * @param mixed $value
	 */
	public function setSessionSteps($name,$value) {
		$this->sessionSteps->$name = $value;
	}

	/**
	 * Return a value from the session
	 * @param Zend_Session_Namespace $name
	 */
	public function getSessionStepsKey($name) {
		return $this->sessionSteps->$name;
	}

	/**
	 * Determine wheter the session was active or not
	 * @param string $namespace
	 */
	public function isActive($namespace) {
		$this->sessionSteps = new Zend_Session_Namespace($namespace);
		return $this->sessionSteps->initialized;
	}
}
