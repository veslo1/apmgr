<?php
/**
 * Parent Model<homie complete with some documentation>
 * @author Rachael Michelle Laney <wtcfg1@gmail.com>
 */
class ZFModel_ParentModel extends Zend_Db_Table_Abstract implements ZFObserver_ILogeable {

	/**
	 *@var id
	 */
	protected $id;

	/**
	 *@var datecreated
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
	 * Holds a message that shows the state of an operation
	 * @var string
	 */
	protected $messageState;

	/**
	 * Used for financial model so the same adapter is used on all those models for transaction purposes.
	 */
	protected $dbAdapter;

	/**
	 * Configuration file used by this class
	 * @var $properties
	 */
	protected $properties;

	/**
	 * Contains the sort order
	 * @var string
	 */
	protected $sort;

	/**
	 * The column that is going to be used for the sort
	 * @var string
	 */
	protected $column;

	/**
	 * Order a set in asc fashion
	 * @var const
	 */
	const ASC='asc';

	/**
	 * Order a set in desc fashion
	 * @var const
	 */
	const DESC='desc';

	/**
	 * Constructor of the models
	 * @param array $options
	 */
	public function __construct(array $options = null) {
		if (is_array($options) ) {
			if( isset($options['dbAdapter']) ) {
				$this->setDbAdapter( $options['dbAdapter'] );
				$this->_setupDatabaseAdapter();
				unset( $options['dbAdapter'] );
			}
			$this->setOptions($options);
		}
	}

	public function getDbAdapter() {
		return $this->dbAdapter;
	}

	public function setDbAdapter( $var ) {
		return $this->dbAdapter = $var;
	}

	/**
	 * The getDbTable method,required by zend
	 */
	public function getDbTable() {
		return $this->dbTable;
	}

	/**
	 * The setDbTable method,required by zend
	 */
	public function setDbTable($dbTable) {
		if ( is_string($dbTable) ) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
		$this->dbTable = $dbTable;
		return $this;
	}

	/**
	 * Overriden from Zend_Db_Table_Abstract - Initialize database adapter.
	 *
	 * @return void
	 */
	protected function _setupDatabaseAdapter() {
		$this->_db = $this->getDbAdapter();
		parent::_setupDatabaseAdapter();
	}

	/**
	 * This method sets all the attributes that are received and instantiates our object arguments
	 */
	public function setOptions(array $options) {
		$methods = get_class_methods($this);

		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if ( in_array($method, $methods) ) {
				$this->$method($value);
			}
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
	 * Returns dateUpdated
	 */
	public function getDateUpdated() {
		return $this->dateUpdated;
	}

	/**
	 * Sets dateUpdated
	 */
	public function setDateUpdated($dateUpdated) {
		$this->dateUpdated=$dateUpdated;
	}

	/**
	 * Stole from Zend docs:
	 * http://framework.zend.com/manual/en/zend.validate.set.html#zend.validate.set.email_address
	 *
	 * Return validator messages array if errors validating.  Otherwise return true
	 *
	 * Probably should use $this->dbTable instead of passing in table to abstract more out but what are the odds a model might need multiple tables?
	 * @param array $dbFields
	 * @param mixed $value
	 * @param int $id
	 * @example exists(array('table'=>'foo','column'=>'bar'),22)
	 * id is optional and can be used when you are doing an update and need to exempt the check
	 * Fixing , when you send null it dies
	 */
	public function exists( $dbFields, $value, $id=null ) {
		$exists = false;
		if( null!==$value and isset($dbFields['table']) and isset($dbFields['column']) ) {
			$record = array( 'table'=> $dbFields['table'], 'field'=>$dbFields['column']);
			if( $id ){
				$record['exclude'] = array( 'field'=>'id', 'value'=>$id );
			}
			$validator = new Zend_Validate_Db_RecordExists( $record );
			$exists = $validator->isValid( $value )?true:false;
		}
		return $exists;
	}

	/*
	 ............................................________
	 ....................................,.-â€˜â€�...................``~.,
	 .............................,.-â€�...................................â€œ-.,
	 .........................,/...............................................â€�:,
	 .....................,?......................................................,
	 .................../...........................................................,}
	 ................./......................................................,:`^`..}
	 .............../...................................................,:â€�........./
	 ..............?.....__.........................................:`.........../
	 ............./__.(.....â€œ~-,_..............................,:`........../
	 .........../(_....â€�~,_........â€œ~,_....................,:`........_/
	 ..........{.._$;_......â€�=,_.......â€œ-,_.......,.-~-,},.~â€�;/....}
	 ...........((.....*~_.......â€�=-._......â€œ;,,./`..../â€�............../
	 ...,,,___.`~,......â€œ~.,....................`.....}............../
	 ............(....`=-,,.......`........................(......;_,,-â€�
	 ............/.`~,......`-...................................../
	 .............`~.*-,.....................................|,./.....,__
	 ,,_..........}.>-._...................................|..............`=~-,
	 .....`=~-,__......`,.................................
	 ...................`=~-,,.,...............................
	 ................................`:,,...........................`..............__
	 .....................................`=-,...................,%`>--==``
	 ........................................_..........._,-%.......`
	 ...................................,
	 */

	//  enjoy the ascii facepalm, suckas!!!

	/**
	 *  Returns the members in the class that are actually in the table as an array (excludes the extra zend crap that's tacked on)
	 *  @return array
	 */
	public function toArray() {
		$schema = $this->dbTable->info();

		$members = get_object_vars( $this );  // uh huh huh..member...

		// super gay but the array functions were fucking with me
		$vars = null;

		foreach( $schema['cols'] as $key=>$value ) {
			if( isset( $members[$value] ) ) {
				$vars[$value] = $members[$value];
			}
		}

		return $vars;
	}

	/*
	 * Fetches everything in the table
	 * @param string column Name of the column to order by
	 * @param string sort The SQL method to sort the code
	 * @param boolean toArray Convert the records to array
	 */
	public function fetchAll( $column=NULL, $sort='ASC',$toArray=false  ) {
		$order = NULL;
		if( isset($sort) and ($column) ) {
			$validColumn = $this->filterSort($column);
			$validOrder = $this->filterOrder($sort);
			if( true==$validColumn and true==$validOrder ) {
				$order = $column . ' '. $sort;
			}
		}
		$resultSet = $this->getDbTable()->fetchAll( $select = $this->getDbTable()->select()->order( $order ) );

		$container = array();
		if(false==$toArray) {
			$class = get_class( $this );
			foreach ( $resultSet as $row ) {
				$container[] = new $class ($row->toArray());
			}
		} else {
			foreach ( $resultSet as $row ) {
				$container[] = $row->toArray();
			}
		}
		return $container;
	}

	/**
	 *   Find a record by unique table id
	 */
	public function findById($id=null) {
		$container = null;

		if ( isset($id) ) {
			$resultSet = $this->getDbTable()->find($id);
			$row = $resultSet->current();
			if( $row ) {
				$class = get_class( $this );
				$container = new $class ($row->toArray());
			}
		}
		return $container;
	}

	/**
	 *  Find multiple records by unique table id
	 */
	public function findManyById($id=null) {
		$container = null;

		if ( isset($id) && is_array( $id ) ) {
			$resultSet = $this->getDbTable()->find($id);

			foreach( $resultSet as $row ) {
				$class = get_class( $this );
				$container[] = new $class ($row->toArray());
			}
		}

		return $container;
	}

	/**
	 * Finds record by one or more keys
	 *
	 * search is an array of column/value pairs.  Ex:  array( 'firstName'=>Bill', 'lastName'=>'Johnson' )
	 * like specifies to search on like instead of exact match
	 *
	 * Attempt at cleaning up the retarded length of parameters.
	 *
	 * @param $param array has these options:
	 *     columnToSort:         string.  The db column to sort by   TODO:
	 * Allow more than one sort column with corresponding direction
	 *                                    $param['columnToSort'] =>
	 *                                      array( 'name'=>'Bill' )
	 *     sortDirection:        string.  Sort by Asc or Desc
	 *                                    $param['sortDirection'] => 'ASC'
	 *
	 *     returnClassObject:    boolean  Returns the results as the class of the calling object (if possible)
	 * 									  $param['returnClassObject'] => true
	 *
	 *     search:               string   User passes in a query.  Useful for things that join on multiple tables.
	 *                                    Uses the columnToSort and the sortDirection clause passed in for sorting the query.
	 * 									  $param['search'] => ( query here )
	 *
	 *     like:                 boolean  If passed in, uses column LIKE %value%.  otherwise defaults to column = value
	 * 							          $param['like'] => true
	 * 	   notLike				 boolean Determine if we perform a ( NOT LIKE | LIKE | =|!=) type of query
	 * @example $moduleControllerId = $moduleController->findByKey  (array(
	 * 'columnToSort'=>false,
	 * 'sortDirection'=>false,
	 * 'returnClassObject'=>true,
	 * 'search'=>   array(
	 *                      "controllerId"=>$controllerId
	 *                   )
	 * ,'like'=>false)
	 * );
	 * TODO Refactor ?. I'm not sure actually, I do indeed notice really good things about this method
	 */

	public function findByKey( $param) {
		$container = null;

		$columnToSort = (isset($param['columnToSort']))? $param['columnToSort'] : null;
		$sortDirection = (isset($param['sortDirection']))? $param['sortDirection'] : null;

		$returnClassObject = (isset($param['returnClassObject']))? $param['returnClassObject'] : true;
		$search = (isset($param['search']))? $param['search'] : null;
		$like = (isset($param['like']))? $param['like'] : null;
		$order = (isset($param['order']))? $param['order'] : null;
		$notLike = (isset($param['notLike']))?$param['notLike'] : false;

		$db=$this->getDbTable();

		// set order
		if( $order==null && $sortDirection && $columnToSort ) {
			$order = $columnToSort . ' '. $sortDirection;
		}

		// set main select query
		$select = null;
		if( isset( $param['query'] ) ) {
			$select = $param['query'];
		} else {
			$select = $db->select();
		}

		// attach search criteria and weed out any empty values
		if( isset($search) && isset($select)) {
			//$search = array_filter( $search );

			foreach($search as $key=>$value) {
				//TODO Sanitize this block if possible
				if( $notLike == true ) {
					( $like )? $select->where( "$key NOT LIKE \"%{$value}%\"" ) : $select->where( "$key!=?",$value );
				} else {
					( $like )? $select->where( "$key LIKE \"%{$value}%\"" ) : $select->where( "$key=?",$value );
				}
			}
		}

		if( empty($select) ) {
			return false;  //  need error msg here
		}

		$select->order( $order );
		$resultSet = ( isset( $param['query'] ) ) ?  $db->getAdapter()->query($select) : $db->fetchAll( $select);

		if( isset( $resultSet ) ) {


			if( $returnClassObject ) {
				$class = get_class( $this );
				foreach ($resultSet as $row)
				$container[] = new $class ($row->toArray());
			}
			else {
				foreach ($resultSet as $row)
				$container[] = $row;
			}
		}
		return $container;
	}

	/**
	 * Saves record in the database
	 * @return boolean
	 */
	public function save() {
		$result = false;
		//TODO Why do you override your own method if you declare that it doesn't has arguments?

		$data = $this->toArray($this);

		$data['dateUpdated'] = date('Y-m-d H:i:s');

		if( isset($data['id'])) {
			$row = $this->getDbTable()->find( $data['id'] );

			if( $row) {
				$record = array_shift( $row->toArray() );
				$diff = array_diff( $data, $record );

				// if the save row is exactly the same, zend db update will return a 0 and not save. (issue 232)
				if( !empty($diff) ){
					$data['dateCreated'] = $record['dateCreated'];
					$db = $this->getDbTable()->getAdapter();
					$where = $db->quoteInto("id=?", $data['id'] );
					$updated = $this->getDbTable()->update($data, $where);

					if($updated) {
						//	This is <strong>kick ass</strong> dude, it helps me a lot with repopulating forms ;)
						$result = $data['id'];
					}
				}
				else{
					$result = $data['id'];
				}
			}
		} else {  // create record
			$data['dateCreated'] = date('Y-m-d H:i:s');			
			$result = $this->getDbTable()->insert($data);
		}
		return $result;
	}

	/* (non-PHPdoc)
	 * @see library/Zend/Db/Table/Zend_Db_Table_Abstract::delete()
	 */
	public function delete($id) {
		$result = false;
		if ( $id ) {
			$db = $this->getDbTable()->getAdapter();
			$where = $db->quoteInto("id=?",$id,'integer');
			$result = $this->getDbTable()->delete($where);
		}
		return $result;
	}

	/**
	 *
	 * @param string $message
	 * @return unknown_type
	 */
	public function setMessageState($message) {
		$this->messageState = $message;
	}

	/**
	 * Return the message
	 * @return string
	 */
	public function getMessageState() {
		return $this->messageState;
	}

	/**
	 * Set the properties of this class
	 * @param string $path
	 * @param string $env
	 */
	public function setProperties($path,$env) {
		$this->properties = new Zend_Config_Ini($path,$env);
	}

	/**
	 *
	 * @return Zend_Config
	 */
	public function getProperties() {
		return $this->properties;
	}


	/**
	 * Determine if the current user is an admin. We have the same method
	 * in the parent controller
	 * @todo This does not belongs to the model, model is agnostic of what they are doing, they should not be working with this
	 */
	public function isAdmin()
	{
		$isAdmin = false;
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		if( $auth->getIdentity() )
		{
			$userid = $auth->getIdentity()->id;
			$roleid = $auth->getIdentity()->roleId;
			$role = new Role_Model_Role();
			$roleData = $role->findById($roleId);
			if($roleData!==null)
			{
				$name = $roleData->getName();
				$isAdmin = $name =='admin'?true:false;
			}
		}
		return $isAdmin;
	}

	/**
	 * Filter the columns that we allow the user to sort
	 * @param string $column The column the user provides
	 * @param array $validColumns Optional parameter to define legit columns
	 * @return boolean
	 */
	public function filterSort($column,array $validColumns=null) {
		$valid = false;
		if( null==$validColumns ) {
			$pieces = $this->getDbTable()->info();
			$valid = in_array($column,$pieces['cols']);
		} else {
			$valid = in_array($column,$validColumns);
		}
		return $valid;
	}

	/**
	 * The order of the column
	 * @param string $order
	 * @return boolean
	 */
	public function filterOrder($order='ASC') {
		$valid = false;
		$order = strtoupper($order);
		$valid = in_array($order,array('ASC','DESC'));
		return $valid;
	}

	/**
	 * Set the sort mode for the column
	 * @param string $sort
	 * @return string
	 */
	public function setSort( $sort ){
		$this->sort = $sort;
		return $this;
	}

	/**
	 * Get the used sort mode
	 * @return string
	 */
	public function getSort(){
		return $this->sort;
	}

	/**
	 * Set the column that is going to be used
	 * @param string $column
	 * @return string
	 */
	public function setColumn($column){
		$this->column = $column;
		return $this;
	}

	/**
	 * Retrieve the column that is used for sorting
	 * @return string
	 */
	public function getColumn(){
		return $this->column;
	}

	/**
	 * Determine if the given cache object exists
	 * @param string $resource
	 */
	public function resourceIsCached($resource){
		$cache = Zend_Registry::get('cache');
		return $cache->test($resource);
	}

	/**
	 * Simple switch used in views
	 * @return string
	 */
	public function switchSort(){
		$sort = $this->getSort();
		if(!empty($sort)){
			$sort = $sort==self::ASC ? self::DESC:self::ASC;
		}else{
			$sort = self::ASC;
		}
		return $sort;
	}

	public function __toString() {
		return __CLASS__;
	}
}
?>