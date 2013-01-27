<?php
/**
 * Created on Sat Sep 12 15:41:47 ART 2009 by jvazquez
 * @appname datesite
 * @package models.user_location
 * <p>
 * This class represents the user interrelation table between the user , the location, and the city
 * </p>
 */
class User_Model_UserLocation extends Zend_Db_Table_Abstract {
	/**
	 *@var id
	 */
	protected $id;

	/**
	 *@var userId
	 */
	protected $userId;

	/**
	 *@var cityId
	 */
	protected $cityId;

	/**
	 *@var dateCreated
	 */
	protected $dateCreated;

	/**
	 *@var dateUpdated
	 */
	protected $dateUpdated;

	/**
	 *@var dbTable
	 */
	protected $dbTable;

	/**
	 * Constructor of this object
	 */
	public function User_Model_UserLocation(array $options = null) {
		if (is_array($options) )
		$this->setOptions($options);
	}

	/**
	 * The getDbTable method,required by zend
	 */
	public function getDbTable() {
		if ( null === $this->dbTable )
		$this->setDbTable('User_Model_DbTable_UserLocation');
		return $this->dbTable;
	}

	/**
	 * The setDbTable method,required by zend
	 */
	public function setDbTable($dbTable) {
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
		$this->dbTable = $dbTable;
		return $this;
	}

	/**
	 * This method sets all the attributes that are received and instantiates our object arguments
	 */
	public function setOptions(array $options) {
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if ( in_array($method, $methods) )
			$this->$method($value);
		}
		return $this;
	}
	/**
	 * Returns id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Sets id
	 */
	public function setId($id) {
		$this->id=$id;
	}

	/**
	 * Returns userId
	 */
	public function getuserId() {
		return $this->userId;
	}

	/**
	 * Sets userId
	 */
	public function setuserId($userId) {
		$this->userId=$userId;
	}

	/**
	 * Returns cityId
	 */
	public function getcityId() {
		return $this->cityId;
	}

	/**
	 * Sets cityId
	 */
	public function setcityId($cityId) {
		$this->cityId=$cityId;
	}

	/**
	 * Returns dateCreated
	 */
	public function getdateCreated() {
		return $this->dateCreated;
	}

	/**
	 * Sets dateCreated
	 */
	public function setdateCreated($dateCreated) {
		$this->dateCreated=$dateCreated;
	}

	/**
	 * Returns dateUpdated
	 */
	public function getdateUpdated() {
		return $this->dateUpdated;
	}

	/**
	 * Sets dateUpdated
	 */
	public function setdateUpdated($dateUpdated) {
		$this->dateUpdated=$dateUpdated;
	}


	/**
	 *This method returns all the records for this model
	 */
	public function fetchAll() {
		$resultSet = $this->getDbTable()->fetchAll();
		$container = array();
		foreach ($resultSet as $row) {
			$data = array('id'=>$row->id,'userId'=>$row->userId,'cityId'=>$row->cityId,'dateCreated'=>$row->dateCreated,'dateUpdated'=>$row->dateUpdated,'ziplocationid'=>$row->zip_location_id);
			$entry = new User_Model_UserLocation($data);
			$container[] = $entry;
		}
		return $container;
	}

	/**
	 *Saves a record in this model
	 */
	public function save() {
		$result = false;
		//	Fetch the values for each key
		$data = array('userId' => $this->getuserId(),'cityId'=>$this->getcityId());
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
	 *Deletes a record in this model
	 *@return integer The number of deleted rows
	 */
	public function delete($id) {
		$result = false;
		if ( $id ) {
			$db = $this->getDbTable()->getAdapter();
			$where = $db->quoteInto("id=?",$id,integer);
			$result = $this->getDbTable()->delete($where,'user_location');
		}
		return $result;
	}

	/**
	 *Finds a record in this model
	 *@param id integer
	 */
	public function findById($id=null) {
		$user_location = null;
		if ( $id ) {
			$resultSet = $this->getDbTable()->find($id);
			if ( count($resultSet) == 0 ) {
				return $user_location;
			}
			$row = $resultSet->current();
			$data = array('id'=>$row->id,'userId'=>$row->userId,'cityId'=>$row->cityId,'dateCreated'=>$row->dateCreated,'dateUpdated'=>$row->dateUpdated,'ziplocationid'=>$row->zip_location_id);
			$user_location = new User_Model_UserLocation($data);
		}
		return $user_location;
	}

	/**
	 * Finds a record in this table by the specified key
	 * @return array
	 */
	public function findByKey($key = null, $value) {
		$container = array ();
		if ($key) {
			$resultSet = $this->getDbTable()->fetchAll($this->getDbTable()->select()->where("$key=?", $value));
			foreach ($resultSet as $row) {
				$data = array('id'=>$row->id,'userId'=>$row->userId,'cityId'=>$row->cityId,'dateCreated'=>$row->dateCreated,'dateUpdated'=>$row->dateUpdated,'ziplocationid'=>$row->zip_location_id);
				$user =  new User_Model_UserLocation($data);
				$container[] = $user;
			}
		}
		return $container;
	}
}
?>
