<?php
/**
 * Interface that deals with the model
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.library.interface
 */
interface User_Library_Interface_RetrieveDao
{
	/**
	 * Creates a record in the specified model
	 * @param ZFModel_ParentModel $user
	 * @return boolean
	 */
	public function save(ZFModel_ParentModel $user);
	
	/**
	 * Contains a list of ZFModel_ParentModel elements that will be saved
	 * @param array $args
	 * @return boolean
	 */
	public function saveCollection(array $args);
	
	/**
	 * Updates a record in the model
	 * @param ZFModel_ParentModel $user
	 */
	public function update(ZFModel_ParentModel $user);
	
	/**
	 * Retrieves a record by the given id
	 * @param int $id
	 * @return User_Model_Recover::User_Model_DbTable_Recover::Zend_Db_Adapter_Pdo_Mysql
	 */
	public function findById($id);

	/**
	 * Returns an array of records
	 * @return array
	 */
	public function fetchAll();
	
	/**
	 * Fetches records
	 * @param array $params
	 */
	public function findByKey(array $params);
	
	/**
	 * 
	 * Wipes out a record from the retrieve table
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id);
	
	/**
	 * Retrieves the definition of the entity we use to persist information
	 * @return array
	 */
	public function getDefinition();
	
	/**
	 * Retrieves the conrete table instance to act directly on it.
	 * @return User_Model_DbTable_Recover
	 */
	public function getTemplate();
}