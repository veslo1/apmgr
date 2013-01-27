<?php
/**
 * Created on Wed Oct 21 00:15:05 ARST 2009 by jvazquez
 * @package application.modules
 * @subpackage forensics.models
 * <p>
 * Model for the Log class.
 * </p>
 */

class Logs_Model_Logs extends Zend_Db_Table_Abstract {

	/**
	 *@var id
	 */
	protected $id;

	/**
	 *@var category
	 */
	protected $category;

	/**
	 *@var message
	 */
	protected $message;

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
	public function Logs_Model_Logs(array $options = null) {
		if (is_array($options) )
		$this->setOptions($options);
	}

	/**
	 * The getDbTable method,required by zend
	 */
	public function getDbTable() {
		if ( null === $this->dbTable )
		$this->setDbTable('Logs_Model_DbTable_Logs');
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
	 * Returns category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets category
	 */
	public function setCategory($category) {
		$this->category=$category;
	}

	/**
	 * Returns message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Sets message
	 */
	public function setMessage($message) {
		$this->message=$message;
	}

	/**
	 * Returns dateCreated
	 */
	public function getDateCreated() {
		return $this->dateCreated;
	}

	/**
	 * Sets dateCreated
	 */
	public function setDateCreated($dateCreated) {
		$this->dateCreated=$dateCreated;
	}

	/**
	 * This method returns all the records for this model
	 * @param string column The column that you wish to sort
	 * @param string sort Sort the columns ASC or DESC
	 * @return array
	 */
	public function fetchAll($column=null,$sort=null) {
		$container = array();

		if( $sort and $column ) {
			$resultSet = $this->getDbTable()->fetchAll($select = $this->getDbTable()->select()->order( $column . ' '. $sort ));
		} else {
			$resultSet = $this->getDbTable()->fetchAll();
		}

		foreach ($resultSet as $row) {
			$data = array('id'=>$row->id,'message'=>$row->message,'dateCreated'=>$row->dateCreated);
			$log = new Logs_Model_Logs($data);
			$container[] = $log;
		}

		return $container;
	}

	/**
	 *Saves a record in this model
	 */
	public function save() {
		$result = false;
		$data = array ('message'=>$this->getMessage());
		unset ($data['id']);
		$data['dateCreated'] = date('Y-m-d H:i:s');
		$result =(int) $this->getDbTable()->insert($data);

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
			$result = $this->getDbTable()->delete($where,'logs');
		}
		return $result;
	}

	/**
	 *Finds a record in this model
	 *@param id integer
	 */
	public function findById($id=null) {
		$logs = null;
		if ( $id ) {
			$resultSet = $this->getDbTable()->find($id);
			if ( count($resultSet) == 0 ) {
				return $logs;
			}
			$row = $resultSet->current();
			$data = array('id'=>$row->id,'message'=>$row->message,'dateCreated'=>$row->dateCreated);
			$entry = new Logs_Model_Logs($data);
		}
	}

	/**
	 *Finds a record by key in this model
	 *@param key string
	 *@param value string
	 */
	public function findByKey($id=null,$value) {
		$container = array();
		if ( !empty($key) and !empty($value) ) {
			$resultSet = $this->getDbTable()->fetchAll($this->getDbTable()->select()->where("$key=?",$value));
			foreach ($resultSet as $row) {
				$data = array('id'=>$row->id,'message'=>$row->message,'dateCreated'=>$row->dateCreated);
				$entry = new Logs_Model_Logs($data);
				$container[] = $entry;
			}
		}
		return $container;
	}

}
?>
