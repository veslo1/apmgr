<?php
/**
 *
 * @author rnelson
 */
class Maintenance_Model_MaintenanceStatus extends ZFModel_ParentModel {

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Maintenance_Model_DbTable_MaintenanceStatus');
	}

	/**
	 * @var NO $status
	 */
	protected $status;  // unique in the table

	/**
	 * Set status
	 */
	public function setStatus($status) {
		$this->status=$status;
		return $this;
	}
	/**
	 * Get status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 *  Fetches the status id by status name
	 */
	public function getStatusIdByName($status){
		$db = $this->getDbTable()->getAdapter();
	 $query = $db->select(array('id'=>'id'))
	 ->from('maintenanceStatus')
	 ->where( 'status=?', $status );
	 $result = $db->fetchOne( $query );
	  
	 if($result)
	 return $result;
	 else
	 return false;
	}
}
