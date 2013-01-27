<?php
/**
 * Created on Sun Sep 13 03:41:13 ART 2009 by jvazquez
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Model for the class Role. Handle business logic</p>
 */

class Role_Model_Role extends ZFModel_ParentModel {
	/**
	 * @param string name The name of this Role.
	 */
	protected $name;

	/**
	 * Is this role protected
	 * @var int protected
	 */
	protected $protected;

	/**
	 * @param array options Associative array that contains initialization values for this model.
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Role_Model_DbTable_Role');
	}

	/**
	 * @return string name Return the name of this role.
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string name Sets the name of this role
	 * @return Role_Model_Role
	 */
	public function setName($name) {
		$this->name = (string)$name;
		return $this;
	}

	/**
	 * Gets the protected value of this role.
	 * @return int
	 */
	public function getProtected() {
		return $this->protected;
	}

	/**
	 * Sets wheter this role is protected or not.
	 * @param int protected
	 * @return Role_Model_Role
	 */
	public function setProtected($protected) {
		$this->protected = ($protected>1||$protected<0)?1:$protected;
		return $this;
	}

	/**
	 * Delete a role in the system. Validate that the role is not protected.
	 * @param integer $id
	 * @return boolean
	 */
	public function delete($id) {
		$result = false;
		if ( is_numeric($id) and $id>0 ) {
			if( $this->isProtected($id) == false ) {
				$db = $this->getDbTable()->getAdapter();
				$where = $db->quoteInto("id=?",$id,'integer');
				$result = $this->getDbTable()->delete($where,'role');
			}
		}
		return $result;
	}

	/**
	 * Consider moving this method to an interface, we need to say is this resource protected ?
	 * @param int $id
	 * @return boolean
	 */
	public function isProtected($id) {
		$protected = true;

		if( is_numeric($id) and $id>0 ) {
			$role = $this->findById($id);
			$protected = $role->getProtected()? true:false;
		}
		return $protected;
	}
}
?>