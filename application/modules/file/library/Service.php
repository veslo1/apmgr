<?php
/**
 * Implementation of the layer of services for File
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.file.library
 */
interface File_Library_Service extends ZFInterfaces_Messageable
{
	/**
	 *
	 * Retrieve a resource by the given id
	 * @param int $id
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
	 * Saves a unit
	 * @param array $unit
	 */
	public function save(array $unit);

	/**
	 * Updates a unit
	 * @param array $unit
	 */
	public function update(array $unit);

	/**
	 * Deletes a unit with the given id
	 * @param int $id
	 */
	public function delete($id);
}