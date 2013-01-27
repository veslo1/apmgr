<?php
/**
 * Definition of the Services for Prospects
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 * @package application.modules.prospects.library
 */

interface Prospects_Library_Service extends ZFInterfaces_Messageable
{
	/**
	 *
	 * Retrieve a prospect by the given id
	 * @param int $id
	 * @return ZFModel_ParentModel
	 */
	public function findById($id);

	/**
	 * Fetches a set of records
	 * @param string $where
	 * @param string $order
	 * @param int $count
	 * @param int $offset
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null);

	/**
	 * Saves a prospect
	 * @param array $prospect
	 */
	public function save(array $prospect);

	/**
	 * Updates a prospect
	 * @param array $prospect
	 */
	public function update(array $prospect);

	/**
	 * Deletes a prospect with the given id
	 * @param int $id
	 */
	public function delete($id);

	/**
	 *
	 * Provide instantiation of the forms
	 * @internal This is a prototype , some methods have huge options or a huge amount of forms
	 * @param $args
	 * @return Zend_Form
	 */
	public function getForm(array $args);

	/**
	 *
	 * Saves a collection with a transaction
	 * @param array $args
	 * @return boolean
	 */
	public function saveTransaction(array $args);
	
	/**
	 *
	 * Validate the save operation
	 * @param array $args
	 */
	public function prepareSave(array $args);
	
		
}