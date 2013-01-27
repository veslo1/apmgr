<?php
/**
 * Created on September 10, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Creates the chain for creating billTransaction, Transaction, and AccountTransaction records
 * * </p>
 */


class Financial_Model_FinancialTransactionCreation extends ZFModel_ParentModel {

	protected $transactionModel;
	protected $billTransactionModel;
	protected $accountTransactionModel;
	protected $transactionId;
	protected $accountLink; // used to set the account link for refunds

	protected $db;

	public function __construct(array $options=null) {
		parent::__construct($options);

		if(isset( $options['db'] ))
		    $this->db = $options['db'];
		else{
		    throw new Exception('missingDbAdapter');
		}    
		
		$this->transactionModel = new Financial_Model_Transaction( array( 'dbAdapter'=> $this->db ) );
		$this->billTransactionModel = new Financial_Model_BillTransaction( array( 'dbAdapter'=> $this->db) );
		$this->accountTransactionModel = new Financial_Model_AccountTransaction( array( 'dbAdapter'=> $this->db) );
	}
	 
	/**
	 *  Amount - required
	 */
	public function setAmount( $var ){
		$this->accountTransactionModel->setAmount( $var );
	}
	 
	/**
	 *  Get/set account link object - required
	 */
	public function setAccountLink( $var ){
		$this->accountTransactionModel->setAccountLink($var);
	}
	 
	/**
	 *  Bill Id - required
	 */
	public function setBillId( $var ){
		$this->billTransactionModel->setBillId( $var );
	}
	 
	/**
	 *  Transaction Id - optional
	 */
	public function getTransactionId(){
		return $this->transactionId;
	}

	public function setTransactionId( $var ){
		$this->transactionId = $var;
	}
	 
	/**
	 *  Comment - optional
	 */
	public function setComment( $var ){
		$this->transactionModel->setComment( $var );
	}
	 
	/**
	 *  Date Posted - optional
	 */
	public function setDatePosted( $var ){
		$this->accountTransactionModel->setDatePosted( $var );
	}

	/**
	 *  create financial records
	 *
	 *  Amount, AccountLink, and BillId are required.  TransactionId is optional.
	 */
	public function createFinancialRecord(){
		try{
			// 2.  Transaction.  If transactionId isn't set, make a new transactionId
			if( !isset( $this->transactionId ) )
			$this->transactionId = $this->transactionModel->save();
			 
			// 3.  Bill Transaction
			$this->billTransactionModel->setTransactionId( $this->getTransactionId() );
			$billTransResult=$this->billTransactionModel->save();
			 
			// 3.  Account Transaction
			$this->accountTransactionModel->setTransactionId($this->getTransactionId());
			$accountTransResult=$this->accountTransactionModel->saveAccountTransaction();
			 
			if( $billTransResult && $accountTransResult )
			return true;
			else
			throw new Exception( 'errorSavingFinancialTransactions' );
		}
		catch ( Exception $e) {
			// rollback here kills the entire transaction. (if a transaction exists in the calling function)
			//$this->db->rollBack();
			echo $e->getMessage();
			return false;
		}
	}
}
?>
