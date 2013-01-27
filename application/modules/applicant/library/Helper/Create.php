<?php
/**
 * Helper object for create
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_Library_Helper_Create extends Object_Instrospection {

	/**
	 * An applicant id
	 * @var int
	 */
	protected $applicant;

	/**
	 * An user id that is on a waitlist
	 * @var int
	 */
	protected $user;

	/**
	 * Data mapper
	 * @var array
	 */
	static $dataMapper = array('applicant','userWaitlist');

	/**
	 * Parameter used to restore cache
	 * @var int
	 */
	protected $persist;

	/**
	 * Constructor of this helper
	 * @param array $options
	 */
	public function __construct(array $options=null){
		if($options!=null){
			$this->instrospect($options);
		}
	}

	/**
	 * Set the applicant id
	 * @param int $applicant
	 * @return Applicant_Library_Helper_Create
	 */
	public function setApplicant($applicant){
		$this->applicant = $applicant;
		return $this;
	}

	/**
	 * Get the applicant id
	 * @return number
	 */
	public function getApplicant(){
		return $this->applicant;
	}

	/**
	 * Set the id of the user we are working with
	 * @param int $userid
	 */
	public function setUser($userid){
		$this->user = $userid;
	}

	/**
	 * Retrieve the user id that we are working with
	 * @return number
	 */
	public function getUser(){
		return $this->user;
	}

	/**
	 * Set the persist attribute
	 * @param int $persist
	 */
	public function setPersist($persist){
		$this->persist = $persist;
	}

	/**
	 * Retrieve the persist element
	 * @return number
	 */
	public function getPersist(){
		return $this->persist;
	}

	/**
	 * Validate that an applicant is valid
	 * @return boolean
	 */
	public function applicantExists(){
		$applicant = new Applicant_Model_Applicant();
		$dbTable = array('table'=>self::$dataMapper[0],'column'=>'id');
		return $applicant->exists($dbTable, $this->getApplicant());
	}

	/**
	 * Validate that an applicant is valid
	 * @return boolean
	 */
	public function userExists(){
		$user = new User_Model_User();
		$dbTable = array('table'=>self::$dataMapper[1],'column'=>'userId');
		return $user->exists($dbTable, $this->getUser());
	}

	/**
	 * Set up the form prepared to email this user
	 * @return Applicant_Form_Email
	 */
	public function initFormApplicant(){
		$form = new Applicant_Form_Email();
		$form->isWaitlist = false;
		$form->setForm();
		$applicant = new Applicant_Model_Applicant();
		$applicant = $applicant->findById($this->getApplicant());
		$user = new User_Model_User();
		$user = $user->findById($applicant->getUserId());
		$formatedName = $user->getFirstName()." ".$user->getLastName()."<".$user->getEmailAddress().">";
		$form->getElement('to')->setAttrib('size', strlen($formatedName)+1)
		->setValue($formatedName);
		return $form;
	}

	/**
	 * Set up the form prepared to email this user
	 * @return Applicant_Form_Email
	 */
	public function initFormWaitlist(){
		$form = new Applicant_Form_Email();
		$form->isWaitlist = true;
		$form->setForm();
		$user = new User_Model_User();
		$user = $user->findById($this->getUser());
		$formatedName = $user->getFirstName()." ".$user->getLastName()."<".$user->getEmailAddress().">";
		$form->getElement('to')->setAttrib('size', strlen($formatedName)+1)
			 ->setValue($formatedName);
		$form->setLegend('userWaitlist');
		return $form;
	}

	/**
	 * Retrieve the content of an email that is being sent to an applicant
	 * @param array $args
	 * @return boolean
	 */
	public function dispatchEmailApplicant(array $args=null){
		$dispatched = false;
		if( !empty($args) ) {
			$user = new User_Model_User();
			$user = $user->findById(ZFUtil_Utils::currentUserId());
			if( !empty($user) ) {
				$args['from'] = $user->getEmailAddress();
				$args['nameFrom'] = $user->getFirstName().' '.$user->getLastName();
				$applicant = new Applicant_Model_Applicant();
				$applicant = $applicant->findById($this->getApplicant());
				$user = $user->findById($applicant->getUserId());
				$args['to'] = $user->getEmailAddress();
				$args['nameTo'] = $user->getFirstName().' '.$user->getLastName();
				$dispatched = $this->dispatchEmail($args);
				//TODO maybe we will log , so leaving room to log here, the model has been created
			}
		}
		return $dispatched;
	}

	/**
	 * Retrieve the content of an email that is being sent to an applicant
	 * @param array $args
	 * @return boolean
	 */
	public function dispatchEmailUser(array $args=null){
		$dispatched = false;
		if( !empty($args) ) {
			$user = new User_Model_User();
			$user = $user->findById(ZFUtil_Utils::currentUserId());
			if( !empty($user) ) {
				$args['from'] = $user->getEmailAddress();
				$args['nameFrom'] = $user->getFirstName().' '.$user->getLastName();
				$user = $user->findById($this->getUser());
				$args['to'] = $user->getEmailAddress();
				$args['nameTo'] = $user->getFirstName().' '.$user->getLastName();
				$dispatched = $this->dispatchEmail($args);
				//TODO maybe we will log , so leaving room to log here, the model has been created
			}
		}
		return $dispatched;
	}
	/**
	 * Dispatch an email
	 * @param array $args
	 * @return Zend_Mail
	 */
	private function dispatchEmail(array $args){
		$sent = false;
		try {
			$zendMail = new Zend_Mail();
			$zendMail->setBodyHtml($args['body'], 'UTF-8');
			$zendMail->setFrom($args['from'],$args['nameFrom']);
			$zendMail->addTo($args['to'],$args['nameTo']);
			$zendMail->send();
			$sent = true;
		} catch(Zend_Mail_Transport_Exception $e) {
			//Nothing , since we don't have sendmail
			$this->setMessageState('emailFail');
		}
		return $sent;
	}

	/**
	 * Clean up the arugments that we received when we are going to mail the user
	 * @param array $args
	 */
	public function cleanUpArgs(array $args) {
		unset($args['to'],$args['body'],$args['submit']);
	}
}