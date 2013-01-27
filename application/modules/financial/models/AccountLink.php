<?php
/**
 * Created on Feb 6, 2010 by rnelson
 * @name apmgr
 * @package financial.models
 * <p>
 * Stores the billType
 * * </p>
 */


class Financial_Model_AccountLink extends ZFModel_ParentModel {

	/**
	 *@var name
	 */
	protected $name;

	/**
	 *@var debitAccountId
	 */
	protected $debitAccountId;

	/**
	 *@var creditAccountId
	 */
	protected $creditAccountId;


	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Financial_Model_DbTable_AccountLink');
	}

	/**
	 * Name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	/**
	 * debitAccountId
	 */
	public function setDebitAccountId( $var ) {
		$this->debitAccountId = $var;
	}

	public function getDebitAccountId() {
		return $this->debitAccountId;
	}

	/**
	 * creditAccountId
	 */
	public function setCreditAccountId( $var ) {
		$this->creditAccountId = $var;
	}

	public function getCreditAccountId() {
		return $this->creditAccountId;
	}

	/**
	 * Used on the viewallaccountlinks page
	 */
	public function fetchAllAccountLinks(){
		$container = array();
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('al'=>'accountLink'), array( 'id'=>'al.id', 'name'=>'al.name' ) )
		->join( array('a'=>'account'), 'al.debitAccountId=a.id', array('debitName'=>'a.name') )
		->join( array('a2'=>'account'), 'al.creditAccountId=a2.id', array('creditName'=>'a2.name') );

		$resultSet = $db->query( $query );
		//print "<pre>";var_dump($query->__toString());print"</pre>"; die;

		$container = null;
		foreach ($resultSet as $row)
		$container[] = $row;

		return $container;
	}
}
?>
