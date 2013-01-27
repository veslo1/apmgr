<?php
/**
 *
 * @author rnelson
 */
class Maintenance_Model_MaintenanceSettings extends ZFModel_ParentModel {

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Maintenance_Model_DbTable_MaintenanceSettings');
	}

	/**
	 * @var roleId
	 */
	protected $roleId;

	/**
	 * Set roleId
	 */
	public function setRoleId($var) {
		$this->roleId=$var;
		return $this;
	}

	/**
	 * Get roleId
	 */
	public function getRoleId() {
		return $this->roleId;
	}

	/**
	 * @var defaultAssignedTo
	 */
	protected $defaultAssignedTo;

	/**
	 * Set defaultAssignedTo
	 */
	public function setDefaultAssignedTo($var) {
		$this->defaultAssignedTo=$var;
		return $this;
	}

	/**
	 * Get defaultAssignedTo
	 */
	public function getDefaultAssignedTo() {
		return $this->defaultAssignedTo;
	}

	public function getSetting(){
		return $this->findById(1);
	}
	
	/**
	 *  Fetch setting 
	 */
	public function fetchSetting(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('ms'=>'maintenanceSettings'),array() )
		->joinLeft(array( 'r'=>'role' ), 'ms.roleId=r.id', array('name'=>'r.name'))
		->joinLeft(array( 'u'=>'user' ), 'ms.defaultAssignedTo=u.id', array('firstName'=>'u.firstName', 'lastName'=>'u.lastName'));						

		$resultSet = $db->query( $query );

		$container = array();		
		foreach ($resultSet as $row){			
		      	$container[] = $row;
		}
		if( $container ) {
		    return $container[0];  // for now this table stores one row
		}
		else{
			return $container;
		}
	}
}
