<?php
/**
 * Abstract implementation of a service layer with the mininum requirements
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package library.ZFService
 */

abstract class ZFService_BusinessObject implements ZFInterfaces_Messageable
{
	/**
	 * 
	 * Communication layer attribute
	 * @var ZFDao_Dao $dao
	 */
	protected $dao;
	
	/**
	 * 
	 * Container for the message state
	 * @var array $msg
	 */
	protected $msg;
	
	/**
	 * 
	 * Set's the communication layer
	 * @param ZFDao_Dao $dao
	 */
	public function setDao($dao)
	{
		$this->dao = $dao;
	}
	
	/**
	 * 
	 * Get's the communication layer
	 * @return ZFDao_Dao
	 */
	public function getDao()
	{
		return $this->dao;
	}

	/**
	 * 
	 * Definition of the method save for the services layer implementation
	 * @param array $args
	 * @return boolean
	 */
	abstract function save(array $args);
	
	
	/**
	 * 
	 * Definition of the implementation that a service layer must implement
	 * @param array $args
	 * @return boolean
	 */
	abstract function validateSave(array $args);
	
	/**
	 * 
	 * Definition of the method save for the services layer implementation
	 * @param array $args
	 * @return boolean
	 */
	abstract function update(array $args);
	
	/**
	 * 
	 * Definition of the implementation that a service layer must implement
	 * @param array $args
	 * @return boolean
	 */
	abstract function validateUpdate(array $args);
	
	/**
	 * 
	 * Definition of the implementation that a service layer must implement
	 * @param int $id
	 * @return boolean
	 */
	abstract function delete($id);
	
	/**
	 * 
	 * Definition of the implementation that a service layer must implement
	 * @param int $id
	 * @return boolean
	 */
	abstract function validateDelete($id);
	
	/**
	 * 
	 * Retrieve a record by the given id
	 * @param int $id
	 * @return ZFModel_ParentModel
	 */
	abstract function findById($id);
	
	/**
	 * 
	 * Retrieve a set of records with the given criteria
	 * @param string $where
	 * @param string $order
	 * @param int $count
	 * @param int $offset
	 */
	abstract function fetchAll($where = null, $order = null, $count = null, $offset = null);
	
	/**
	 * 
	 * Set's the message state
	 * @param array $msg
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}
	
	/**
	 * 
	 * Retrieves the message state
	 * @return array
	 */
	public function getMessageState()
	{
		return $this->msg;
	}
}