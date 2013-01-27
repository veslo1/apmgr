<?php
/**
 * Interface for services in the unit model.
 * Handles the logic of the controller
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.unit.library
 */
interface Unit_Library_Services extends ZFInterfaces_Messageable
{
	/**
	 * Fetches a record by the given id
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

	/**
	 * Fetches the images for the given unit
	 * @param int $id
	 * @return array
	 */
	public function viewUnitsGraphics($id);
	
	/**
	 * 
	 * Validates that the unit is valid.
	 * Corroborates the upload path.
	 * @throws Exception Path is not writable
	 * @param int $id
	 * @return boolean
	 */
	public function prepareAddPicture($id);
	
	
	/**
	 * Add's a picture to a unit
	 * @param array $args
	 * @param Unit_Library_PictureHelper $helper
	 * @return boolean
	 */
	public function addPicture(array $args , Unit_Library_PictureHelper $helper);
}