<?php
/**
 * Created on Dec 5, 2009 by rnelson
 * @name apmgr
 * @package application.modules.unit.models
 * <p>
 * The model for tenant
 * </p>
 */


class Unit_Model_Tenant extends ZFModel_ParentModel {

	/**
	 *@var userId
	 */
	protected $userId;
	 
	/**
	 *@var leaseId
	 */
	protected $leaseId;
	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_Tenant');
	}
	 
	/**
	 * User get and set
	 */
	public function setUserId( $id ) {
		$this->userId = $id;
	}

	public function getUserId() {
		return $this->userId;
	}

	/**
	 * LeaseId get and set
	 */
	public function setLeaseId( $id ) {
		$this->leaseId = $id;
	}

	public function getLeaseId() {
		return $this->leaseId;
	}

	/**
	 *  Fetch the tenants on the lease
	 *  Used on create eviction page and lease view
	 */
	public function getTenants(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('t'=>'tenant'), array('t.userId','t.id') )
		->join( array('u'=>'user'),'t.userId=u.id',array('u.firstName', 'u.lastName' ))
		->where('t.leaseId=?', $this->getLeaseId());

		$resultSet = $db->query( $query );

		if($resultSet){
			$container = null;
			foreach ($resultSet as $row)
			$container[] = $row;

			return $container;
		}
		else
		return false;
	}	

	/**
	 *  Pulls the unit for the logged in user.  This function is currently used on
	 *  create maintenance request for non admin users.
	 */
	public function getTenantUnitId(){		
		$this->setUserId(User_Library_Helper_Utils::currentUserId());		

		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('l'=>'lease'), array('unitId'=>'unitId') )
		->join( array('t'=>'tenant'),'t.leaseId=l.id',array())
		->where('t.userId=?',$this->getUserId())
		->where( 'l.leaseStartDate<=NOW()')
		->where( 'l.lastDay>=NOW()')
		->where( 'l.isCancelled=0')
		->order( 'l.leaseStartDate DESC' );		
		
		$unitId = $db->fetchOne( $query );		
		
		if(isset($unitId)){
			return $unitId;
		}
		else {
		    return false;
		} 
	}

}  // end class
?>
