<?php
/**
 * Implementation of the business logic for user module
 * @package application.modules.user.library.interface
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
interface User_Library_Interface_Bo
{
	/**
	 * Creates a user in the system
	 * @param array $user
	 * @return boolean|int
	 */
	public function save(array $user);
	
	/**
	 * Updates a record of a user
	 * @param array $user
	 * @return boolean|int
	 */
	public function update(array $user);
	
	/**
	 * Retrieves the form to create users
	 * @return User_Form_Create
	 */
	public function getCreateUserForm();
	
	/**
	 * Retrieves the form to update users
	 * @param array $args
	 * @return User_Form_Create
	 */
	public function getUpdateUserForm(array $args);
	
	/**
	 * Uses the DAO to hit the persistance engine
	 * @param User_Library_Interface_Dao $dao
	 */
	public function setDao(User_Library_Interface_Dao $dao);
	
	/**
	 * Retrieves the DAO
	 * @return User_Library_Interface_Dao
	 */
	public function getDao();
	
	/**
	 * Performs a delete operation
	 * @param array $data
	 * @return boolean
	 */
	public function delete(array $data);
	
	/**
	 * Retrieves all the information and formats it for displaying
	 * @param array $options
	 * @return array
	 */
	public function viewAllUserInformation(array $options=null);
	
	/**
	 * Validates that the given user is valid
	 * @param array $args
	 */
	public function isValid(array $args);
	
	/**
	 * Retrieves a Zend_Form that displays a set of options that allows the user
	 * to confirm if we delete a user or not
	 * @return Zend_Form
	 */
	public function getDeleteUserForm();
	
	/**
	 * The user will provide an email , and we will look it up in the database.
	 * If the user is found , we will deliver the email to the user
	 * @param string $email
	 * @return boolean
	 */
	public function recoverUserName($email);
}