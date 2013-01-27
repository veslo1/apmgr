<?php
/**
 * Created on Mon Oct 12 15:36:44 ART 2009 by jvazquez
 * @appname datesite
 * @package models.roleActionsModules
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * This model represents the ACL access for the roles. It holds a reference to the modelControllers table
 */

class Role_Model_RolePermissions extends ZFModel_ParentModel
{
	/**
	 * @param int roleId The Role Id that We Hold
	 */
	protected $roleId;

	/**
	 * @param int sectionId The Section Id we are working with
	 */
	protected $permissionId;

	/**
	 * @param string messages An array that contains a MsgObject that has messages
	 */
	protected $messages;

	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Role_Model_DbTable_RolePermissions');
	}

	/**
	 * @return int The Role Id that We Are Working With
	 */
	public function getRoleId() {
		return $this->roleId;
	}

	/**
	 * @param int roleId The RoleId that we are setting
	 * @return Role_Model_RoleActionsModules
	 */
	public function setRoleId($roleId) {
		$this->roleId = (int) $roleId;
		return $this;
	}

	/**
	 * @return int The Section We Are Dealing with
	 */
	public function getPermissionId() {
		return $this->permissionId;
	}

	/**
	 * @param int permissionId The Section We Are Working With
	 */
	public function setPermissionId($permissionId) {
		$this->permissionId = (int)$permissionId;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFModel/ZFModel_ParentModel#save()
	 */
	public function save() {
		$data = array('roleId'=>$this->getRoleId(),'permissionId'=>$this->getPermissionId());
		$result = false;

		if (null === ($id = $this->getId())) {
			unset ($data['id']);
			$data['dateCreated'] = date('Y-m-d H:i:s');

			try {
				$result = (int) $this->getDbTable()->insert($data);
			} catch(Zend_Db_Exception $e) {
				$result = false;
			}

		}
		return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFModel/ZFModel_ParentModel#delete($id)
	 */
	public function delete(array $args=null) {
		$result = false;
		if( !isset($args['field']) ) {
			throw new Exception('Field is not set');
		}
		if( !isset($args['value']) ) {
			throw new Exception('The value is missing in the array');
		}
		$type = isset($args['casting'])?$args['casting']:'integer';

		$db = $this->getDbTable()->getAdapter();
		$where = $db->quoteInto($args['field']."=?",$args['value'],$type);
		$result = $this->getDbTable()->delete($where,'rolePermission');

		return $result;
	}

	/**
	 * Return the acl for all the roles in the system
	 * @return array
	 * @internal
	 * SELECT M.id AS `Module Id`, C.id AS `Controller Id`,A.id AS `Action Id`,R.id AS `Role Id`,M.name AS `Module Name`,C.name AS `Controller Name`,A.name AS `Action Name`,
	 * R.name AS `Role Name`,P.id AS `Permission Id`
	 * FROM
	 * permission P INNER JOIN rolePermission RP ON (P.id=RP.permissionId)
	 * INNER JOIN modules M ON (M.id=P.moduleId)
	 * INNER JOIN controllers C ON (C.id=P.controllerId)
	 * INNER JOIN actions A ON (A.id=P.actionId)
	 * INNER JOIN role R ON (R.id=RP.roleId)
	 * WHERE M.name='user' AND C.name='Login' AND A.name='Index' -- This is with query
	 * $select->where($db->quoteInto('M.name=?',$module,'string'));
	 * $select->where($db->quoteInto('C.name=?',$controller,'string'));
	 * $resultset = $db->query($select);
	 * if( count($resultset) == 0 ) {
	 * 	return $tuple;
	 * }
	 */
	public function fetchAllRoleAccess($column=null,$sort=null) {
		$access = array();
		$select = $this->yieldRoleAclQuery();
		if( isset($column) and isset($sort) ) {
			$select->order($column.' '.$sort);
		}
		$db = $this->getDbTable()->getAdapter();
		$resultSet = $db->query($select);
		if( count($resultSet) == 0 ) {
			return $access;
		}

		foreach($resultSet as $id=>$value) {
			$access[] = array('roleName'=>$value['roleName'],'moduleName'=>$value['moduleName'],'controllerName'=>$value['controllerName'],'actionName'=>$value['actionName'],'permissionId'=>$value['permissionId'],'alias'=>$value['alias']);
		}
		return $access;
	}

	/**
	 * Appended due to the new functionality of the ACL
	 * @link http://redmine.debserverp4.com.ar/issues/92
	 * @param string $module
	 * @param string $controller
	 * @param string $action
	 * @param string $role
	 * @return array
	 */
	public function fetchRoleAccessToAction($module,$controller,$action,$role)
	{
		$cache = Zend_Registry::get('cache');
		$cacheTag = $module.$controller.$action.$role;
		$cached = $cache->test($cacheTag);
		$access = array();

		if($cached==false)
		{
			$db = $this->getDbTable()->getAdapter();
			$select = $this->yieldRoleAclQuery();

			$select->where($db->quoteInto('M.name=?',$module,'string'))
				   ->where($db->quoteInto('C.name=?',$controller,'string'))
				   ->where($db->quoteInto('A.name=?',$action,'string'))
				   ->where($db->quoteInto('R.id=?',$role,'integer'));
			$resultSet = $db->query($select);
			if( count($resultSet) > 0 )
			{
				foreach($resultSet as $id=>$value)
				{
					$access[] = array('roleName'=>$value['roleName'],'moduleName'=>$value['moduleName'],'controllerName'=>$value['controllerName'],'actionName'=>$value['actionName'],'permissionId'=>$value['permissionId']);
				}
				$cache->save($access,$cacheTag);
			}
		}
		else
		{
			$access = $cache->load($cacheTag);
		}

		return $access;
	}

	/**
	 * Yield the main query of the relation between the modules, moduleControllers and controllers
	 * @return Zend_Db
	 */
	protected function yieldRoleAclQuery() {
		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from(
		array('P' => 'permission'),
		array('PermissionId'=>'P.id','alias'=>'P.alias')
		)
		->join(
		array('RP'=>'rolePermission'),
                'P.id = RP.permissionId'
                )
                ->join(
                array('M'=>'modules'),
                'M.id = P.moduleId',
                array('moduleId'=>'M.id','moduleName'=>'LOWER(M.name)')
                )
                ->join(
                array('C'=>'controllers'),
                'C.id = P.controllerId',
                array('controllerId'=>'C.id','controllerName'=>'LOWER(C.name)')
                )
                ->join(
                array('A'=>'actions'),
                'A.id = P.actionId',
                array('actionId'=>'A.id','actionName'=>'LOWER(A.name)')
                )
                ->join(
                array('R'=>'role'),
                'R.id = RP.roleId',
                array('roleId'=>'R.id','roleName'=>'LOWER(R.name)')
                );
                return $select;
	}
	/**
	 * @return string A String Showing an error
	 * TODO Move this method once is tested to the ParentModel
	 */
	public function getErrors() {
		return $this->messages;
	}

	/**
	 * Returns true on success
	 * @param int $roleId
	 * @param int $pageId
	 * @return boolean
	 */
	public function rolePermissionExists( $roleId, $pageId ) {
		$exists = true;
		$data = $this->findByKey( array(
                'returnClassObject'=>true,
                'search'    =>  array(
                        'roleId'=>$roleId,
                        'permissionId'=>$pageId
		)
		)
		);
		if( $data == null ) {
			$exists = false;
		}
		return $exists;
	}

	/**
	 * Prepare to save in the database.
	 * Clean all the permissions and then save them
	 * @param array $args
	 * @return boolean
	 */
	public function prepareSave($args=null) {
		$stackSave = array();
		$saved = false;

		$permissionId = $args['permission'];
		$roles = isset($args['roleId'])?$args['roleId']:null;
		//	Delete all the permissions that we have
		$result = $this->delete(array('field'=>'permissionId','value'=>$permissionId,'casting'=>'integer'));
		if( isset($roles) ) {
			foreach($roles as $id=>$content) {
				$this->setPermissionId($permissionId);
				$this->setRoleId($content);
				$stackSave[] = $this->save();
			}
            //  perform the cache wipe out for this records
            $this->cleanupAclCache($args);
		} else {
			$stackSave[] = true;
		}
		$saved = !in_array(false,$stackSave);
		return $saved;
	}

	/**
	 *  Fetches permissions for use on populating the update role permissions page
	 *  /role/update/updatepermission/permissionId/15
	 */
	public function fetchRoleByPermissionId() {
		$access = array();
		if( $this->getPermissionId() )  {
			$db = $this->getDbTable()->getAdapter();
			$select = $db->select()
			        ->from(array('rp'=>'rolePermission'),array('rp.roleId'))
			        ->where('rp.permissionId=?',$this->getPermissionId());

			$resultSet = $db->query($select);

			if( count($resultSet) ) {
				foreach($resultSet as $row) {
					$access[] = $row['roleId'];
				}
			}
		}
		return $access;
	}

    /**
      * Why this isn't cached ?.
      * Because , we are cleaning the ACL here, so if I cach this, then I don't have a way to "uncache" it
      * TODO Discuss with Rachael if she would like to implement a different timeout for this particular implementation so we can cache still
      */
    private function cleanupAclCache(array $args=null){
        $roles = $args['roleId'];
        $permissionId = $args['permission'];
        if( !empty($roles) and !empty($permissionId) ) {
            $module = new Modules_Model_Modules();
            $controller = new Modules_Model_Controllers();
            $action = new Modules_Model_Actions();
            $role = new Role_Model_Role();
            $permission = new Permission_Model_Permission();
            $permissionData = $permission->findById($permissionId);
            if( !empty($permissionData) ) {
                //  We retrieve the strings to create the name
                $moduleData = $module->findById($permissionData->getModuleId());
                $controllerData = $controller->findById($permissionData->getControllerId());
                $actionData = $action->findById($permissionData->getActionId());
                $suffixAcl = strtolower($moduleData->getName().$controllerData->getName().$actionData->getName());
                $cache = Zend_Registry::get('cache');
                foreach($roles as $key=>$roleId){
                    $roleData = $role->findById($roleId);
                    $roleName = $roleData->getName();
                    $cacheTag = $suffixAcl.$roleName;
                    $cached = $this->resourceIsCached($cacheTag);
                    if( true==$cached ){
                        $clean = true;
                        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array($cacheTag));
                    }
                }
            }
        }
    }
}
?>
