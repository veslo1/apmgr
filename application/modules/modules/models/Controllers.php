<?php
/**
 * Created on Dec 23, 2009
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 * <p>Model for the Controllers</p>
 */
class Modules_Model_Controllers extends ZFModel_ParentModel implements ZFObserver_ILogeable
{
	/**
	 * @param string name The name of this module
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $icon;

	/**
	 * @param boolean $display Determine if we display or not the icon
	 */
	protected $display;

	/**
	 * @param array options This options contains initilization values for this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Modules_Model_DbTable_Controllers');
	}

	/**
	 * @return string The name of this module
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return Modules_Model_Modules Setter for this model
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
	 * @return boolean Returns false on error
	 */
	public function save() {
		$result = false;
		$data = array ('name'=>$this->getName(),'display'=>$this->getDisplay());
		if (null === ($id = $this->getId())) {
			unset ($data['id']);
			$data['dateCreated'] = date('Y-m-d H:i:s');
			$result =(int) $this->getDbTable()->insert($data);
		} else {
			$data['dateUpdated'] = date('Y-m-d H:i:s');
			$result = $this->getDbTable()->update($data, array ('id = ?' => $this->getId() ),'integer');
		}
		return $result;
	}

	/**
	 * Retrieve the controllers for the given module, filtering by role
	 * @param string $module
	 * @param array $roles
	 * @return multitype:|Ambigous <multitype:, multitype:unknown >
	 *
	 * Modified for ticket 331 to not show icons if the user doesn't have access to the index action.
	 * we tried a join and also a subselect for this and found the subselect is actually faster....
	 * leaving join commented in case we have to revisit this
	 */
	public function fetchControllersForModule($module,$roles)
	{
		$controllers = array();
		if( !empty($module) )
		{
			$db = $this->getDbTable()->getAdapter();
			$select = $db->select()
				->from( array('P' => 'permission'), array('PermissionId'=>'P.id') )
				->join( array('M'=>'modules'), 'M.id = P.moduleId', array('moduleId'=>'M.id','moduleName'=>'LOWER(M.name)') )
				->join( array('C'=>'controllers'), 'C.id = P.controllerId', array('controllerId'=>'C.id','controllerName'=>'LOWER(C.name)','display'=>'C.display','icon'=>'C.icon') )
				->join( array('RP'=>'rolePermission'),'RP.permissionId=P.id',array())
				//->join( array('A'=>'actions'),"P.actionId=A.id AND A.name='Index'",array())
				->where($db->quoteInto('M.name=?',$module,'string'))
				->where($db->quoteInto('RP.roleId = ?',$roles,'int'))
				->where( 'C.display=1' )
				->where( "P.actionId = (SELECT id FROM actions WHERE name='Index')")
				->group('controllerId');				
			$resultset = $db->query($select);
			$log = new ZFObserver_Forensic();
			$log->setStatus(ZFObserver_ILogeable::DEBUG);
			$log->attach(new ZFObserver_Observers_Text());
			$log->notify($this, "Running ".$select->__toString());
			if( count($resultset) == 0 )
			{
				return $controllers;
			}
			foreach($resultset as $id=>$value)
			{			
				$controllers[]= array('moduleId'=>$value['moduleId'],'moduleName'=>$value['moduleName'],'controllerId'=>$value['controllerId'],'controllerName'=>$value['controllerName'],'display'=>$value['display'],'icon'=>$value['icon']);
			}
		}
		return $controllers;
	}
	
	/* (non-PHPdoc)
	 * @see library/ZFModel/ZFModel_ParentModel::__toString()
	 */
	public function __toString()
	{
		return "ControllersModel";
	}
}
?>