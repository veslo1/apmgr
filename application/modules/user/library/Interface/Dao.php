<?php
/**
 * Interface that deals with the model
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.library.interface
 */
interface User_Library_Interface_Dao extends ZFInterfaces_Dao
{	
	/**
	 * Fetches records
	 * @param array $params
	 */
	public function findByKey(array $params);
	
	/**
	 * Performs a logical delete in the persistance table
	 * @param int $id
	 * @param int $state Toggles between enabled and dissabled
	 * @return boolean
	 */
	public function disable($id,$state);
}