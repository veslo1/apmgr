<?php
/**
 * Created on Feb 5, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Stores the billType
 * * </p>
 */


class Financial_Model_Account extends ZFModel_ParentModel {

	/**
	 *@var name
	 */
	protected $name;

	/**
	 *@var number
	 */
	protected $number;
	 
	/**
	 *@var orientation
	 */
	protected $orientation;
	
	/**
	 *@var accountTypeId
	 */
	protected $accountTypeId;
	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Financial_Model_DbTable_Account');
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
	 * Number
	 */
	public function setNumber( $var ) {
		$this->number = $var;
	}

	public function getNumber() {
		return $this->number;
	}

	/**
	 * Orientation
	 */
	public function setOrientation( $var ) {
		$this->orientation = $var;
	}

	public function getOrientation() {
		return $this->orientation;
	}
	
	/**
	 * AccountTypeId
	 */
	public function setAccountTypeId( $var ) {
		$this->accountTypeId = $var;
	}

	public function getAccountTypeId() {
		return $this->accountTypeId;
	}
	
	/**
	 *  Return account id of those used so they cannot be deleted
	 *  accountLink, accountTransaction, financialAccountSetting
	 */
	public function getAttachedAccounts(){
	    $db = $this->getDbTable()->getAdapter();
	    
	    //  Well thank god the children weren't onboard to see it
	    $query = "SELECT a.id
	              FROM account AS a
		      JOIN accountLink AS al ON al.debitAccountId = a.id
		      UNION
		      SELECT a.id
	              FROM account AS a
		      JOIN accountLink AS al ON al.creditAccountId = a.id
		      UNION
		      SELECT a.id
	              FROM account AS a
		      JOIN accountTransaction AS at ON at.accountId = a.id
		      UNION
		      SELECT a.id
	              FROM account AS a
		      JOIN financialAccountSetting AS fas ON fas.accountId = a.id";
		      
            $resultSet = $db->query( $query );
			
	    $container = array();

	    foreach ($resultSet as $row){
		$container[$row['id']] = $row['id'];
	    }	    
	    return $container;	    
	}
	
	/**
	 *  Get accounts 
	 */
	public function getAccounts(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('a'=>'account'), array('id','name','number','orientation') )
		->join(array( 'at'=>'accountType' ), 'a.accountTypeid=at.id', array('accountTypeName'=>'at.name'))		
		->order('a.name ASC');		

		$resultSet = $db->query( $query );

		$container = array();
		
		foreach ($resultSet as $row){						      	
		      	$container[] = $row;
		}		
		return $container;		
	}
	
	/**
	 *  Get a single account 
	 */
	public function getAccount(){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('a'=>'account'), array('id','name','number','orientation') )
		->join(array( 'at'=>'accountType' ), 'a.accountTypeid=at.id', array('accountTypeName'=>'at.name'))		
		->where('a.id=?',$this->getId());		

		$results = $db->fetchAll( $query );
		$container = array();		
		if( isset( $results ) ){
			$container = array_shift($results);
			return $container;
		}
		else{
		    return null;
		}	
	}
	
	/**
	 *  Get accounts by account type name
	 */
	public function getAccountByTypeName( $name ){
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('a'=>'account'), array('id','name','number','orientation') )
		->join(array( 'at'=>'accountType' ), 'a.accountTypeid=at.id', array('accountTypeName'=>'at.name'))		
		->where('at.name=?',$name);		

		$resultSet = $db->query( $query );

		$container = array();
		
		foreach ($resultSet as $row){						      	
		      	$container[$row['id']] = $row;
		}		
		return $container;
	}	
}
?>
