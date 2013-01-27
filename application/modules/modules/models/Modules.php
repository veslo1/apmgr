<?php
/**
 * Created on Mon Oct 12 15:37:00 ART 2009 by jvazquez
 * @package models.Modules
 * <p>Model for the Modules table.Contains all the Modules `modules` that we have on the application.</p>
 */

class Modules_Model_Modules extends ZFModel_ParentModel {
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
		$this->setDbTable('Modules_Model_DbTable_Modules');
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
	 * @return boolean Returns false on error
	 */
	public function save() {
		$result = false;
		$data = array ('name'=>$this->getName(),'icon'=>$this->getIcon(),'display'=>$this->getDisplay());
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
}
?>