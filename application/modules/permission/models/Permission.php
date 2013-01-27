<?php
/**
 * Created on Sat Sep 12 15:34:50 ART 2009 by jvazquez
 * @revision Wed Jan 27 16:02:00 ART 2009 by jvazquez
 * @package application.modules.permission.models
 * <strike>
 * This class represents the Permission entity.
 * The CRUD operations are handlded by Zend Engine
 * </strike>
 * <p>
 * New definition of the permission table. It holds all the modular application configuration
 * </p>
 */

class Permission_Model_Permission extends ZFModel_ParentModel {
	/**
	 * @param int $moduleId
	 */
	protected $moduleId;

	/**
	 * @param int $controllerId
	 */
	protected $controllerId;

	/**
	 * @param int $actionId
	 */
	protected $actionId;

	/**
	 * @param string $alias A description for the url that we are creating based on the action name, controller name and module name
	 */
	protected $alias;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Permission_Model_DbTable_Permission');
	}

	/**
	 * @param int $moduleId
	 */
	public function setModuleId($moduleId) {
		$this->moduleId = $moduleId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getModuleId() {
		return $this->moduleId;
	}

	/**
	 * @param int $controllerId
	 */
	public function setControllerId($controllerId) {
		$this->controllerId = $controllerId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getControllerId() {
		return $this->controllerId;
	}

	/**
	 * @param int $actionId
	 */
	public function setActionId($actionId) {
		$this->actionId = $actionId;
	}

	/**
	 * @return int
	 */
	public function getActionId() {
		return $this->actionId;
	}

	/**
	 * @param string $alias
	 */
	public function setAlias($alias) {
		$this->alias = $alias;
	}

	/**
	 * @return string
	 */
	public function getAlias() {
		return $this->alias;
	}

	/**
	 * Return the relationship between roles and permissions
	 * @return array
	 */
	public function getRoleAndPermissions(array $args=null) {
		$results = array();

		//	The objects that we need
		$permission = new Permission_Model_Permission();
		$rolePermission = new Role_Model_RolePermissions();
		$role = new Role_Model_Role();

		if( isset($args['column']) and isset($args['sort']) ) {
			$column = $args['column'];
			$sort = $args['sort'];
			$permissions = $permission->fetchAll($column, $sort);
		} else {
			$permissions = $permission->fetchAll();
		}

		$rolePermissions = $rolePermission->fetchAll();
		// Yes, i know perm sounds funny :P
		foreach($permissions as $id=>$perm) {
			$results['pages'][$perm->getId()] = array('pageId'=>$perm->getId(),'pageName'=>$perm->getAlias());
		}

		//	Iterate the given permissions and inject them in the `pages` subArray
		foreach($rolePermissions as $id=>$rpObject) {
			if( in_array($rpObject->getPermissionId(),array_keys($results['pages'])) ) {
				$role = $role->findById($rpObject->getRoleId());
				$results['pages'][$rpObject->getPermissionId()]['roles'][] = array('roleId'=>$rpObject->getRoleId(),'roleName'=>$role->getName());
			} else {
				$results['pages'][$rpObject->getPermissionId()]['roles'][] = null;
			}
		}
		return $results;
	}

	/**
	 * Return a string representation of the view
	 * @param array $records
	 * @return string
	 * @deprecated
	 */
	public function htmlFy($records) {
		$output = '';
		foreach($records as $page ) {
			$output .="<ul class=\"ulSortable\">";
			$output .="<li>";
			$output .="<div id=\"".$page['pageId']."\">".$page['pageName']."</div>";
			if(isset($page['roles']) and count($page['roles'])>0) {
				$output.="<div id='control-".$page['pageId']."' class='destRoleBox'>";
				foreach( $page['roles'] as $id=>$content ) {
					$output.="<span style='display:inline;'>";
					$output.="<p class='movable' onclick=\"removePerm('".$content['roleId']."','".$page['pageId']."');\">".ucfirst($content['roleName'])."</p>";
					$output.="</span>";
				}
				$output.="</div>";
			} else {
				$output.="<div id=\"control-".$page['pageId']."\" class='destRoleBox'></div>";
			}
			$output.="</li>";
			$output.="</ul>";
		}
		return $output;
	}

	/**
	 *  Fetch controllers of a module
	 *  /role/view/viewcontrollers/moduleId/1
	 */
	public function fetchControllersByModuleId(){
		$access = array();
		if( $this->getModuleId() ) {
			$db = $this->getDbTable()->getAdapter();
			$select = $db->select()
			->from(array('p'=>'permission'),array('controllerId'))
			->join( array('c'=>'controllers'), 'c.id=p.controllerId', array('controllerName'=>'name') )
			->where('p.moduleId=?',$this->getModuleId())
			->group('p.controllerId')
			->order('controllerName ASC');

			$resultSet = $db->query($select);

			if( count($resultSet) ) {
				foreach($resultSet as $row) {
					$access[] = $row;
				}
			}
		}
		return $access;
	}

	/**
	 *  Fetch actions of a controller and module
	 *  Used on /role/view/viewactions/moduleId/1/controllerId/8
	 */
	public function fetchActionsByControllerModule(){
		$access = array();
		if( $this->getModuleId() && $this->getControllerId() ) {
			$db = $this->getDbTable()->getAdapter();
			$select = $db->select()
			->from(array('p'=>'permission'),array('id'))
			->join( array('c'=>'controllers'), 'c.id=p.controllerId', array() )
			->join( array('a'=>'actions'), 'a.id=p.actionId', array('actionId'=>'a.id','actionName'=>'name') )
			->where('p.moduleId=?',$this->getModuleId())
			->where('p.controllerId=?',$this->getControllerId())
			->order('actionName ASC');
			 
			$resultSet = $db->query($select);

			if( count($resultSet) ) {
				foreach($resultSet as $row) {
					$access[] = $row;
				}
			}
		}
		return $access;
	}
}
?>