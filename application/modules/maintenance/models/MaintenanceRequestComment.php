<?php
/**
 * Created on Feb 24, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Simple model for the Maintenance request which stores the maintenance request
 * </p>
 */


class Maintenance_Model_MaintenanceRequestComment extends ZFModel_ParentModel {

	/**
	 *@var userId
	 */
	protected $userId;

	/**
	 *@var maintenanceRequestId
	 */
	protected $maintenanceRequestId;

	/**
	 *@var comment
	 */
	protected $comment;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setUserId( User_Library_Helper_Utils::currentUserId() );
		$this->setDbTable('Maintenance_Model_DbTable_MaintenanceRequestComment');
	}
	 
	/**
	 * userId
	 */
	public function setUserId( $var ) {
		$this->userId = $var;
	}

	public function getUserId() {
		return $this->userId;
	}

	/**
	 * maintenanceRequestId
	 */
	public function setMaintenanceRequestId( $var ) {
		$this->maintenanceRequestId = $var;
	}

	public function getMaintenanceRequestId() {
		return $this->maintenanceRequestId;
	}

	/**
	 * comment
	 */
	public function setComment( $var ) {
		$this->comment = $var;
	}

	public function getComment() {
		return $this->comment;
	}

	/**
	 *  Pull comments for maintenance requests
	 */
	public function fetchRequestComment(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array( 'mrc'=>'maintenanceRequestComment' ) )
		->join( array( 'mr'=>'maintenanceRequest'),'mrc.maintenanceRequestId=mr.id', array() )
		->join( array( 'user'=>'user'),'mrc.userId=user.id', array( 'firstName', 'lastName' ) )
		->where('mr.id=?', $this->getMaintenanceRequestId());
		 
		$resultSet = $db->query( $query );
	  
		if($resultSet) {
			$container = null;
			foreach ($resultSet as $row)
			$container[] = $row;
			return $container;
		}
		else
		return false;
	}
}
?>
