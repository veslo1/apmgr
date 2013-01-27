<?php
/**
 * Helper for the join controller
 * @author jvazquez
 */

class User_Library_Helper_Join extends Object_Instrospection {

	/**
	 * This is the default page that we visit in case we are not running a workflow
	 * TODO This may change, or even be configurable,tbd.
	 * @var const
	 */
	const DEFAULTPAGE = 'user/index/index';

	/**
	 * Data mapper
	 * @var array
	 */
	static $dataMapper = array('user');

	/**
	 *@var firstName
	 */
	protected $firstName;

	/**
	 *@var lastName
	 */
	protected $lastName;

	/**
	 *@var username
	 */
	protected $username;

	/**
	 *@var password
	 */
	protected $password;

	/**
	 *@var string emailAddress His email address
	 */
	protected $emailAddress;

	/**
	 * @var string phone His phone number
	 */
	protected $phone;

	/**
	 *@var string mobile Mobile phone number
	 */
	protected $mobile;

	/**
	 * @var string fax Fax number
	 */
	protected $fax;

	public function __construct(array $options=null){
		if(null!==$options){
			$this->instrospect($options);
		}
	}

	/**
	 * Create an user account.
	 * Create the role
	 * @internal If the operation fails for role, we will delete the user
	 * @return boolean
	 */
	public function createAccount() {
		$id = $this->createUser();
		return $id;
	}

	/**
	 * If the current user is not authenticated, then authenticate him
	 * @param boolean $authenticated
	 * @param int $id
	 * @return boolean
	 */
	public function authenticate($authenticated,$id){
		$clear = true;
		if($authenticated==false){
			$user = new User_Model_User();
			$exists = $user->exists(array('column'=>'id','table'=>self::$dataMapper[0]), $id);
			if(false==$exists){
				$this->setMessageState('unableToLogIn');
			} else {
				$login = new User_Library_Helper_Login();
				$clear = $login->authenticateUser($this->getUserName(), $this->getPassword());
			}
		}
		return $clear;
	}
	/**
	 * Create an user account
	 * @return boolean
	 */
	private function createUser()
	{
		$id = false;
		try {
			$args = array('username'=>$this->getUserName(),'firstName'=>$this->getFirstName(),'lastName'=>$this->getLastName(),'password'=>$this->getPassword(),'emailAddress'=>$this->getEmailAddress(),'roleId'=>8);
			$user = new User_Model_User($args);
			$id = $user->validateSave();
		} catch (Exception $e) {
			//TODO Notify us too
		}
		$this->setMessageState($user->getMessageState());
		return $id;
	}

	/**
	 * If we are not able to create a role for the user, then delete the account
	 * This action is only triggered when the role is false
	 * @param int $userId
	 * @param int|boolean $userRole
	 */
	private function cleanUp($userId,$userRole){
		if(false==$userRole){
			$user = new User_Model_User();
			$user->delete($userId);
		}
	}


	/**
	 * Returns firstName
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Sets firstName
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * Returns lastName
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Sets lastName
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * Returns username
	 */
	public function getUserName() {
		return $this->username;
	}

	/**
	 * Sets username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * Returns password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * Sets password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * Returns emailAddress
	 */
	public function getEmailAddress() {
		return $this->emailAddress;
	}

	/**
	 * Sets emailAddress
	 */
	public function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}

	/**
	 * Returns phone
	 * @return string
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Sets emailAddress
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
		//return $this;
	}

	/**
	 * Returns mobile
	 * @return string
	 */
	public function getMobile() {
		return $this->mobile;
	}

	/**
	 * Sets mobile phone number
	 */
	public function setMobile($mobile) {
		$this->mobile = $mobile;
		//return $this;
	}

	/**
	 * Returns fax
	 * @return string
	 */
	public function getFax() {
		return $this->fax;
	}

	/**
	 * Sets fax phone number
	 */
	public function setFax($fax) {
		$this->fax = $fax;
		//return $this;
	}
}