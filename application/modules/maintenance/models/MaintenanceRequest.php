<?php
/**
 * Created on Feb 24, 2010 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * Simple model for the Maintenance request which stores the maintenance request
 * </p>
 */

class Maintenance_Model_MaintenanceRequest extends ZFModel_ParentModel {
	/**
	 *@var unitId
	 */
	protected $unitId;

	/**
	 *@var requestorId
	 */
	protected $requestorId;

	/**
	 *@var title
	 */
	protected $title;

	/**
	 *@var description
	 */
	protected $description;

	/**
	 *@var permissionToEnter
	 */
	protected $permissionToEnter;
	 
	protected $mineOnly;  // used internally so only requestor requests are returned

	protected $userId;  // used internally for the assignedTo

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$userId = User_Library_Helper_Utils::currentUserId();
		$this->setRequestorId($userId);
		$this->setUserId($userId);
		$this->setDbTable('Maintenance_Model_DbTable_MaintenanceRequest');
	}
	 
	/**
	 * unitId
	 */
	public function setUnitId( $var ) {
		$this->unitId = $var;
	}

	public function getUnitId() {
		return $this->unitId;
	}

	/**
	 * requestorId
	 */
	public function setRequestorId( $var ) {
		$this->requestorId = $var;
	}

	public function getRequestorId() {
		return $this->requestorId;
	}

	 
	/**
	 * title
	 */
	public function setTitle( $var ) {
		$this->title = $var;
	}

	public function getTitle() {
		return $this->title;
	}

	/**
	 * description
	 */
	public function setDescription( $var ) {
		$this->description = $var;
	}

	public function getDescription() {
		return $this->description;
	}
	 
	/**
	 * permission to enter the unit
	 */
	public function setPermissionToEnter( $var ) {
		$this->permissionToEnter = $var;
	}

	public function getPermissionToEnter() {
		return $this->permissionToEnter;
	}

	/**
	 * mineOnly
	 */
	public function setMineOnly( $var ) {
		$this->mineOnly = $var;
	}

	public function getMineOnly() {
		return $this->mineOnly;
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
	 *  Grab all requests
	 */
	public function fetchAllRequests(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array( 'mr'=>'maintenanceRequest' ) )
		->join( array( 'unit'=>'unit'),'mr.unitId=unit.id', array( 'number'=>'number', 'apartmentId'=>'apartmentId' )  )
		->join( array( 'requestor'=>'user'),'mr.requestorId = requestor.id', array( 'requestorFirstName'=>'firstName', 'requestorLastName'=>'lastName' ) )
		->join( array( 'mras'=>'maintenanceRequestAssignedStatus'),'mr.id = mras.maintenanceRequestId', array() )
		->join( array( 'ms'=>'maintenanceStatus'),'ms.id = mras.maintenanceStatusId', array('status'=>'status') )
		->where('mras.currentStatus=1');
		 
		$resultSet = $db->query( $query );
			
		$container = null;
		foreach ($resultSet as $row)
		$container[] = $row;
		return $container;
	}
	 
	/**
	 *  Fetch requests assigned to the user
	 */
	public function fetchAssignedRequests() {
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array( 'mr'=>'maintenanceRequest' ) )
		->join( array( 'unit'=>'unit'),'mr.unitId=unit.id', array( 'number' )  )
		->join( array( 'requestor'=>'user'),'mr.requestorId = requestor.id', array( 'requestorFirstName'=>'firstName', 'requestorLastName'=>'lastName' ) )
		->join( array( 'mras'=>'maintenanceRequestAssignedStatus'),'mr.id = mras.maintenanceRequestId', array() )
		->join( array( 'ms'=>'maintenanceStatus'),'ms.id = mras.maintenanceStatusId', array('status'=>'status') )
		->where( 'mras.assignedTo=?', $this->getUserId() )
		->where('mras.currentStatus=1');
			
		$resultSet = $db->query( $query );
			
		$container = null;
		foreach ($resultSet as $row)
		$container[] = $row;

		return $container;
	}

	/**
	 *  Grab the user's requests.
	 */
	public function fetchMyRequests() {
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array( 'mr'=>'maintenanceRequest' ) )
		->join( array( 'unit'=>'unit'),'mr.unitId=unit.id', array( 'number' )  )
		->join( array( 'requestor'=>'user'),'mr.requestorId = requestor.id', array( 'requestorFirstName'=>'firstName', 'requestorLastName'=>'lastName' ) )
		->join( array( 'mras'=>'maintenanceRequestAssignedStatus'),'mr.id = mras.maintenanceRequestId', array() )
		->join( array( 'ms'=>'maintenanceStatus'),'ms.id = mras.maintenanceStatusId', array('status'=>'status') )
		->where( 'mr.requestorId=?', $this->getRequestorId() )
		->where('mras.currentStatus=1');
			
		$resultSet = $db->query( $query );
			
		$container = null;
		foreach ($resultSet as $row)
		$container[] = $row;

		return $container;
	}

	/**
	 *  Wrapper for viewing maintenance request details and their comments
	 */
	public function fetchRequestandComment(){
		$maintComment = new Maintenance_Model_MaintenanceRequestComment();
		$maintComment->setMaintenanceRequestId( $this->getId() );
		$request = $this->fetchRequest();
		$comment = $maintComment->fetchRequestComment();
		return array( 'request'=>$request, 'comment'=>$comment );
	}

	/**
	 *  Used for displaying the detail information on the request.
	 */
	public function fetchRequest(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array( 'mr'=>'maintenanceRequest' ) )
		->join( array( 'unit'=>'unit'),'mr.unitId=unit.id', array( 'number' )  )
		->join( array( 'requestor'=>'user'),'mr.requestorId = requestor.id', array( 'requestorFirstName'=>'firstName', 'requestorLastName'=>'lastName' ) )
		->join( array( 'mras'=>'maintenanceRequestAssignedStatus'),'mr.id = mras.maintenanceRequestId', array() )
		->join( array( 'ms'=>'maintenanceStatus'),'ms.id = mras.maintenanceStatusId', array('status'=>'status') )
		->joinLeft( array( 'assigned'=>'user'),'mras.assignedTo = assigned.id', array( 'assignedFirstName'=>'firstName', 'assignedLastName'=>'lastName' ) )
		->where('mr.id=?', $this->getId())
		->where('mras.currentStatus=1');
			
		if( $this->getMineOnly() )
		$query->where( 'mr.requestorId=?', $this->getRequestorId() );
	  
		$resultSet = $db->fetchRow( $query );
		if($resultSet)
		return $resultSet;
		else
		return false;
	}

	// set unitId
	// set requestorId
	// set description
	// set status to 'new'
	public function saveNewMaintenanceRequest(){
		$db = Zend_Registry::get('db'); // used for all in transaction
		try {
			$db->beginTransaction();
			$assignedStatusObj = new Maintenance_Model_MaintenanceRequestAssignedStatus();
			$assignedStatusObj->setDbAdapter( $db );
			$statusObj = new Maintenance_Model_MaintenanceStatus();
			$currSettingObj = new Maintenance_Model_MaintenanceSettings();
			$currSetting = $currSettingObj->getSetting();
			// pull out the new status by id
			// create a row in assigned status
			// create a row in maintenance request
			 
			$id = $this->save();
			 
			$statusId = $statusObj->getStatusIdByName('new');
			$assignedStatusObj->setMaintenanceStatusId( $statusId );
			$assignedStatusObj->setMaintenanceRequestId( $id );
			$assignedStatusObj->setCurrentStatus( 1 );
			if( $currSetting )
			$assignedStatusObj->setAssignedTo( $currSetting->getDefaultAssignedTo() );
			else {
				$this->setMessageState('missingMaintenanceSetting');
				throw new Exception();
			}
			 
			if($this->getUserId())
			$assignedStatusObj->setUserId( $this->getUserId() );
			 
			$assignedStatusObj->save();

			$db->commit();
			return $id;
		}
		catch ( Exception $e) {
			$db->rollBack();
			//echo $e->getMessage();
			return false;
		}
	}
}
?>
