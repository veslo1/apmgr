<?php
/**
 * Contract for the Retrieval object
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.user.library.interface
 */
interface User_Library_Interface_RetrievalBo
{
	/**
	 * 
	 * Prepares and validates a record to be inserted into the persistance engine
	 * @param array $args
	 */
	public function insert(array $args);
	
	/**
	 * 
	 * Updates a record in the persistance engine
	 * @param array $args
	 */
	public function update(array $args);
	
	/**
	 * 
	 * Deletes a record by the given id
	 * @param int $id
	 */
	public function delete($id);
	
	/**
	 * 
	 * Retrieves a record with the given identifier
	 * @param int $id
	 */
	public function findById($id);

	/**
	 * 
	 * Sets the object that will communicate with the persistance engine
	 * @param User_Library_Interface_RetrieveDao $dao
	 */
	public function setDao(User_Library_Interface_RetrieveDao $dao);
	
	/**
	 * 
	 * Retrieves the object that will communicate with the persistance engine
	 * @return User_Library_Interface_RetrieveDao
	 */
	public function getDao();
	
		
	/**
	 * The user will provide a username and an email.
	 * If those records exists , we will generate an a temporary link that will be sent
	 * to the user.
	 * @param array $args
	 * @return boolean
	 */
	public function recoverPassword(array $args);
}