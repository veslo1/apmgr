<?php
/**
 * Created on Sun Sep  6 19:41:13 ART 2009 by jvazquez
 * @package application.modules.user.models
 * <p>
 * This class represents the connection between the model and the zend db table abstract class.
 * Crud operations are handled by zend, and validation has to be done on the controller, we just send the data to the database
 * and return the result of this operation.
 * </p>
 */

class User_Model_User extends ZFModel_ParentModel{

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
	
	/**
	 * The roelId this user has
	 * @var int
	 */
	protected $roleId;

	/**
	 * Is this user deleted
	 * @var int
	 */
	protected $deleted;
	
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null)
	{
		parent::__construct( $options );
		$this->setDbTable('User_Model_DbTable_User');
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

	/**
	 * Finds a record in this model with the given username for create account validation
	 * If the record doesn't exists, it will retun false
	 * @param string $username
	 * @return boolean
	 */
	public function userNameExists($username=null) {
		$exists = true;
		if ( isset($username) ) {
			$select = $this->getDbTable()->select();
			$select->where('username = ?', $username);
			$sth = $select->query();
			$resultSet = $sth->fetchAll();
			$exists = count($resultSet)==0 ? false:true;
		}
		return $exists;
	}

	/**
	 * We need to implement this method because we are working with the ACL, and we are implementing the interface
	 */
	public function getResourceId() {

	}

	/**
	 * Try to save the method
	 * @return boolean
	 */
	public function validateSave() {
		$saved = false;
		$exists = $this->userNameExists($this->getUsername());
		if($exists==true) {
			$this->setMessageState('usernameExists');
		} else {
			$this->setPassword(sha1($this->getPassword()));
			$saved = $this->save();
		}
		return $saved;
	}
	
	/**
	 * Sets the roleId
	 * @param int $roleId
	 */
	public function setRoleId($roleId)
	{
		$this->roleId = $roleId;
	}
	
	/**
	 * Retrieves the roleId
	 * @return number
	 */
	public function getRoleId()
	{
		return $this->roleId;
	}
	
	/**
	 * Sets the deleted property
	 * @param int $id
	 */
	public function setDeleted($id)
	{
		$this->deleted = $id;
	}
	
	/**
	 * Retrieves this boolean property
	 * @return number
	 */
	public function getDeleted()
	{
		return $this->deleted;
	}
}
?>