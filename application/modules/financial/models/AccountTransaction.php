<?php
/**
 * Created on Feb 6, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Stores the accountTransaction
 * * </p>
 */


class Financial_Model_AccountTransaction extends ZFModel_ParentModel {

	/**
	 *@var datePosted
	 */
	protected $datePosted;

	/**
	 *@var accountId
	 */
	protected $accountId;

	/**
	 *@var transactionId
	 */
	protected $transactionId;

	/**
	 *@var side
	 */
	protected $side;

	/**
	 *@var amount
	 */
	protected $amount;

	protected $accountLink; // not in db - used for saving  (obj)
	protected $transaction; // not in db - used for saving  (obj)
	
	protected $dateFrom; // not in db - used for fetching transactions in date range
	protected $dateTo; // not in db - used for fetching transactions in date range
		
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Financial_Model_DbTable_AccountTransaction');

		$this->transaction = new Financial_Model_Transaction();
	}

	/**
	 *  datePosted
	 */
	public function setDatePosted( $var ) {
		$this->datePosted = $var;
	}

	public function getDatePosted() {
		return $this->datePosted;
	}

	/**
	 *  accountId
	 */
	public function setAccountId( $var ) {
		$this->accountId = $var;
	}

	public function getAccountId() {
		return $this->accountId;
	}

	/**
	 *  transactionId
	 */
	public function setTransactionId( $var ) {
		$this->transactionId = $var;
	}

	public function getTransactionId() {
		return $this->transactionId;
	}

	/**
	 *  comment
	 */
	public function setComment( $var ) {
		$this->transaction->setComment( $var );
	}

	public function getComment() {
		return $this->transaction->getComment();
	}

	/**
	 *  side
	 */
	public function setSide( $var ) {
		$this->side = $var;
	}

	public function getSide() {
		return $this->side;
	}

	/**
	 *  amount
	 */
	public function setAmount( $var ) {
		$this->amount = $var;
	}

	public function getAmount() {
		return $this->amount;
	}

	/**
	 *  accountLink
	 */
	public function setAccountLink( $var ) {
		$this->accountLink = $var;
	}

	public function getAccountLink() {
		return $this->accountLink;
	}
	
	/**
	 *  dateFrom
	 */
	public function setDateFrom( $var ) {
		$this->dateFrom = $var;
	}

	public function getDateFrom() {
		return $this->dateFrom;
	}
	
	/**
	 *  dateTo
	 */
	public function setDateTo( $var ) {
		$this->dateTo = $var;
	}

	public function getDateTo() {
		return $this->dateTo;
	}	

	// This function must set two records - a debit and credit for balance
	public function saveAccountTransaction(){
		$debit = $this->accountLink->getDebitAccountId();
		$credit = $this->accountLink->getCreditAccountId();
		return $this->saveRecord( $debit, $credit );
	}

	/**
	 *  Saves the accounting transaction
	 */
	private function saveRecord( $debit, $credit ){
		if( !$this->getDatePosted() )
		$this->setDatePosted( date('Y-m-d H:i:s'));

		if( !isset( $this->transactionId ) )
		$this->setTransactionId( $this->transaction->save() );
			
		// save debit record
		$this->setAccountId( $debit );
		$this->setSide('debit');
		$this->save();

		// save credit record
		$this->setAccountId( $credit );
		$this->setSide('credit');
		$this->save();

		return true;
	}

	/**
	 *  Fetches account transactions for the selected account or transaction id
	 */
	public function getAccountTransactions(){
		$db=$this->getDbTable();

		$query = $db->select()
		->from( array('at'=>'accountTransaction') )
		->join(array( 'a'=>'account' ), 'at.accountId=a.id', array('accountName'=>'name'))
		->join(array( 't'=>'transaction' ), 'at.transactionId=t.id',array('comment'));

		if($this->getAccountId()) {
			$query->where( 'at.accountId=?', $this->getAccountId() );
		}
			
		if($this->getTransactionId()) {
			$query->where( 'at.transactionId=?', $this->getTransactionId() );
		}
			
		$query->where( 'at.datePosted<=NOW()' )
		->order( 'at.datePosted DESC' )
		->setIntegrityCheck(false);

		$resultSet = $db->getAdapter()->query( $query );

		$container = array();
		foreach ($resultSet as $row) {
			$container[] = $row;
		}

		return $container;
	}

	/**
	 *  Query for pulling the balance amount
	 */
	private function getAccountAmount(){
		$db=$this->getDbTable();
		$query = $db->select()
		->from( 'accountTransaction',array('result'=>new Zend_Db_Expr("IFNULL(SUM(amount),'0.00')" ),'side'=>'side'))		
		->where( 'accountId=?', $this->getAccountId() );
		
		$dateFrom = $this->getDateFrom();
		$dateTo = $this->getDateTo();
		if( $dateFrom && $dateTo ) {
			$query->where("DATE(datePosted) BETWEEN '$dateFrom' AND '$dateTo'");  // DATE captures all transactions for the passed day ignoring the time
		}
		else {
			$query->where( 'datePosted<=NOW()' );
		}
		
		$query->group('side');

		$resultSet = $db->getAdapter()->query( $query );		
		
		$buffer = array();
		foreach( $resultSet as $id=>$row ) {
			$buffer[$row['side']] = $row['result'];
		}
		if( empty($buffer) ) {
			$buffer['debit'] = '0.00';
			$buffer['credit'] = '0.00';
		}		
		return $buffer;
	}


	/**
	 *  Calculates the account balance.  Jorge found a kick ass way to shorten it to one query.
	 */
	public function getBalance() {
		$account = new Financial_Model_Account();
		$acctObj = $account->findById( $this->getAccountId() );

		$amounts = $this->getAccountAmount();		
		
		if( !isset($amounts['debit']) ) {
			$amounts['debit'] = 0.00;
		}
		if( !isset($amounts['credit']) ) {
			$amounts['credit'] = 0.00;
		}
		$balance=0.00;

		if( $acctObj->getOrientation()=='debit') {
			$balance = $amounts['debit'] - $amounts['credit'];
		}
		else {
			$balance = $amounts['credit'] - $amounts['debit'];
		}
		return $balance;
	}
		
	/**
	 *  Used in the reports to pull the balances of account types such as Revenue and Expense accounts  
	 */	
	public function getBalancesByAccountType( $name ){
		$acctObj = new Financial_Model_Account();
		$accounts = $acctObj->getAccountByTypeName($name);
		
		$container = array();
		if( $accounts ) {			
			foreach( $accounts as $id=>$account ) {
			    $this->setAccountId($id); 	
			    $balance = $this->getBalance();			    
			    $container[$account['name']] = $balance;
			}			
		}
		arsort( $container ); // sorts by descending balance
		return $container;
	}	
}
?>