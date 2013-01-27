<?php
/**
 * Interface that all the DAOS must implement when interacting with persistance engines
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package ZFInterfaces
 */
interface ZFInterfaces_Dao
{
	/**
	 * Contains he date format used in dates
	 * @var const
	 */
	const DATEFORMAT = 'Y-m-d H:i:s';
	
	/**
	 *
	 * Perform an insert operation
	 * @param ZFModel_ParentModel $entity
	 */
	public function save(ZFModel_ParentModel $entity);

	/**
	 * Contains a list of ZFModel_ParentModel elements that will be saved
	 * @param array $args
	 * @return boolean
	 */
	public function saveCollection(array $args);

	/**
	 *
	 * Performs an update operation
	 * @param ZFModel_ParentModel $entity
	 */
	public function update(ZFModel_ParentModel $entity);

	/**
	 *
	 * Performs a delete.
	 * @param ZFModel_ParentModel $entity
	 */
	public function delete(ZFModel_ParentModel $entity);

	/**
	 *
	 * Retrieves a record by the given id
	 * @param $id
	 * @return ZFModel_ParentModel
	 */
	public function findById($id);

	/**
	 * Returns an array of records
	 * @param string|array|Zend_Db_Table_Select $where  OPTIONAL An SQL WHERE clause or Zend_Db_Table_Select object.
	 * @param string|array                      $order  OPTIONAL An SQL ORDER clause.
	 * @param int                               $count  OPTIONAL An SQL LIMIT count.
	 * @param int                               $offset OPTIONAL An SQL LIMIT offset.
	 * @return Zend_Db_Table_Rowset_Abstract The row results per the Zend_Db_Adapter fetch mode.
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null);

	/**
	 *
	 * Retrieves the table schema of the table used to describe the entity
	 * @return array
	 */
	public function getDefinition();

	/**
	 * Retrieves the conrete table instance to act directly on it.
	 * @return Zend_Db_Table_Abstract
	 */
	public function getTemplate();

	/**
	 * 
	 * Sets the template entity that is being used
	 * @param Zend_Db_Table_Abstract $template
	 */
	public function setTemplate(Zend_Db_Table_Abstract $template);
	
	/**
	 * Retrieve a Db object to interact with the database.
	 * Provides utilities such as quoteInto
	 * @return Zend_Db_Table_Abstract
	 */
	public function getGateway();

	/**
	 *
	 * Implementation of exists , defined in parentModel. Determines if the given value exists in the 
	 * entity
	 * @return boolean
	 */
	public function exists($dbFields, $value, $id=null);
}