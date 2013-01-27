<?php
/**
 *
 * @author rnelson
 */
class Maintenance_Model_MaintenanceRequestAssignedStatus extends ZFModel_ParentModel {

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Maintenance_Model_DbTable_MaintenanceRequestAssignedStatus');
	}

	/**
	 * @var NO $maintenanceRequestId
	 */
	protected $maintenanceRequestId;

	/**
	 * Set maintenanceRequestId
	 */
	public function setMaintenanceRequestId($maintenanceRequestId) {
		$this->maintenanceRequestId=$maintenanceRequestId;
		return $this;
	}
	/**
	 * Get maintenanceRequestId
	 */
	public function getMaintenanceRequestId() {
		return $this->maintenanceRequestId;
	}
	/**
	 * @var NO $maintenanceStatusId
	 */
	protected $maintenanceStatusId;

	/**
	 * Set maintenanceStatusId
	 */
	public function setMaintenanceStatusId($maintenanceStatusId) {
		$this->maintenanceStatusId=$maintenanceStatusId;
		return $this;
	}
	/**
	 * Get maintenanceStatusId
	 */
	public function getMaintenanceStatusId() {
		return $this->maintenanceStatusId;
	}
	/**
	 * @var NO $userId
	 */
	protected $userId;

	/**
	 * Set userId
	 */
	public function setUserId($userId) {
		$this->userId=$userId;
		return $this;
	}
	/**
	 * Get userId
	 */
	public function getUserId() {
		return $this->userId;
	}
	 
	/**
	 * @var $assignedTo
	 */
	protected $assignedTo;

	/**
	 * Set assignedTo
	 */
	public function setAssignedTo($var) {
		$this->assignedTo=$var;
		return $this;
	}
	/**
	 * Get assignedTo
	 */
	public function getAssignedTo() {
		return $this->assignedTo;
	}

	/**
	 * Set currentStatus
	 */
	public function setCurrentStatus($var) {
		$this->currentStatus=$var;
		return $this;
	}
	/**
	 * Get userId
	 */
	public function getCurrentStatus() {
		return $this->currentStatus;
	}

	/**
	 *  Returns current status and assigned
	 */
	public function getCurrentRow(){
		$db = $this->getDbTable()->getAdapter();
		 
		$query = $db->select()
		->from( array( 'mra'=>'maintenanceRequestAssignedStatus' ) )
		->where('mra.maintenanceRequestId=?', $this->getMaintenanceRequestId())
		->where('mra.currentStatus=1');
		 
	 $row = $db->fetchRow( $query );
	 return $row;
	}

	/**
	 *  saves the assigned status record
	 */
	public function saveRecord(){
		$db = Zend_Registry::get('db'); // used for all in transaction
		$this->setDbAdapter( $db );

		$userId = User_Library_Helper_Utils::currentUserId();
		if($userId){
			$this->setUserId( $userId );
		}
		else{
			$this->setMessageState( 'missingUserId');
			return false;
		}

		if( !$this->getMaintenanceRequestId() ){
			$this->setMessageState( 'missingRequestId');
			return false;
		}
		else{
			try{
				$db->beginTransaction();
				$this->unsetCurrent();
				$this->setCurrentStatus(1);
				$id = $this->save();
				$db->commit();
				return $id;
			}
			catch ( Exception $e) {
				$db->rollBack();
				echo $e->getMessage();
				return false;
			}
		}
	}

	/**
	 *  Unsets current statuses
	 */
	private function unsetCurrent(){
		$db = $this->getDbTable()->getAdapter();
		$data = array('currentStatus'=>0);
		$where = "maintenanceRequestId=" . $this->getMaintenanceRequestId();
		$db->update('maintenanceRequestAssignedStatus', $data, $where );
	}
}
