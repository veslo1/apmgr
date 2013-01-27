<?php
/**
 * Created on Mon Oct 12 14:24:01 ART 2009 by jvazquez
 * @appname datesite
 * @package models.actions
 * <p>
 * Provide a clear definition of what this class does
 * </p>
 */

class Modules_Model_Actions extends ZFModel_ParentModel {

	/**
	 * @param string name The name of this Action
	 */
	protected $name;

	/**
	 * @param boolean $display Determine if we display or not the icon
	 */
	protected $display;

	/**
	 * @param array options Associative array that contains initialization values for this model.
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Modules_Model_DbTable_Actions');
	}

	/**
	 * @return string The Name Of This Action
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string name Setter for this class
	 * @return Actions_Model_Actions Returns a reference to itself.
	 */
	public function setName($name) {
		$this->name = (string) $name;
		return $this;
	}

	/**
	 * Return the icon of this module
	 * @return string
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * Sets the icon of this module
	 * @param unknown_type $icon
	 * @return Modules_Model_Modules
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
		return $this;
	}
	/**
	 * @return boolean Returns false on error
	 */
	public function save() {
		$result = false;
		$data = array ('name'=>$this->getName(),'display'=>$this->getDisplay(),'icon'=>$this->getIcon());
		if (null === ($id = $this->getId())) {
			unset ($data['id']);
			$data['dateCreated'] = date('Y-m-d H:i:s');
			$result =(int) $this->getDbTable()->insert($data);
		} else {
			$data['dateUpdated'] = date('Y-m-d H:i:s');
			$result = $this->getDbTable()->update($data, array ('id = ?' => $this->getId() ),integer);
		}
		return $result;
	}

	/**
	 *	Deletes a record in this model
	 * @return boolean
	 */
	public function delete($id) {
		$result = false;
		if ( $id ) {
			$db = $this->getDbTable()->getAdapter();
			$where = $db->quoteInto('id=?',$id,integer);
			$result = $this->getDbTable()->delete($id);
			$result = $this->getDbTable()->delete($where,'actions');
		}
		return $result;
	}

	/**
	 * @param boolean $display
	 */
	public function setDisplay($display) {
		$this->display = $display;
		return $this;
	}

	/**
	 * @return boolean The attribute of this object
	 */
	public function getDisplay() {
		return $this->display;
	}

	/**
	 *
	 * @param string $module
	 * @param string $controller
	 * @param string $action
	 * @return array
	 */
	public function fetchModuleController($module,$controller) {
		$tuple = array();

		if( !empty($module) and strlen($module)>0 and !empty($controller) and strlen($controller)>0 ) {
			$db = $this->getDbTable()->getAdapter();
			$select = $this->yieldModuleControllerQuery();
			$select->where($db->quoteInto('M.name=?',$module,'string'))
			->where($db->quoteInto('C.name=?',$controller,'string'));
			$resultset = $db->query($select);

			if( count($resultset) == 0 ) {
				return $tuple;
			}

			foreach ( $resultset as $row ) {
				$tuple[] = array(
								  'moduleId'=>$row['moduleId'],
								  'moduleName'=>$row['moduleName'],
								  'controllerId'=>$row['controllerId'],
								  'controllerName'=>$row['controllerName'],
								  'actionId'=>$row['actionId'],
				 				  'actionName'=>$row['actionName'],
								  'icon' => $row['icon'],
								  'display'=>$row['display']
				);
			}
		}

		return $tuple;
	}

	/**
	 * Yield the main query of the relation between the modules, moduleControllers and controllers
	 * @return Zend_Db
	 */
	protected function yieldModuleControllerQuery() {
		$db = $this->getDbTable()->getAdapter();
		$select = $db->select()
		->from(
		array('A' => 'actions'),
		array('actionId'=>'A.id','actionName'=>'LOWER(A.name)','display'=>'A.display','icon'=>'A.icon')
		)
		->join(
		array('P'=>'permission'),
				'A.id = P.actionId',
		array('permissionId'=>'P.id')
		)
		->join(
		array('C'=>'controllers'),
				'P.controllerId = C.id',
		array('controllerId'=>'C.id','controllerName'=>'LOWER(C.name)')
		)
		->join(
		array('M'=>'modules'),
				'P.moduleId = M.id',
		array('moduleId'=>'M.id','moduleName'=>'LOWER(M.name)')
		);
		return $select;
	}
}
?>