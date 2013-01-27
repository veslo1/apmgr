<?php
/**
 * Created on April 23, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Model for fee
 * </p>
 */


class Financial_Model_Fee extends ZFModel_ParentModel {

	/**
	 *@var name
	 */
	protected $name;

	/**
	 *@var amount
	 */
	protected $amount;

	/**
	 *@var debitAccountId
	 */
	protected $debitAccountId;

	/**
	 *@var creditAccountId
	 */
	protected $creditAccountId;

	/**
	 * Boolean property
	 * @var int
	 */
	protected $enabled;

	/**
	 * Boolean property
	 * @var int
	 */
	protected $refundable;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Financial_Model_DbTable_Fee');
	}

	/**
	 * name
	 */
	public function setName( $var ) {
		$this->name = $var;
	}

	public function getName() {
		return $this->name;
	}

	/**
	 * amount
	 */
	public function setAmount( $var ) {
		$this->amount = $var;
	}

	public function getAmount() {
		return $this->amount;
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
	 * Return the enabled property
	 * @param int $enabled
	 */
	public function setEnabled($enabled) {
		$this->enabled = $enabled;
	}

	/**
	 * Get enabled property
	 * @return int
	 */
	public function getEnabled() {
		return $this->enabled;
	}

	/**
	 * Return the enabled property
	 * @param int $enabled
	 */
	public function setRefundable($var) {
		$this->refundable = $var;
	}

	/**
	 * Get enabled property
	 * @return int
	 */
	public function getRefundable() {
		return $this->refundable;
	}

	/**
	 *   Fetch fees and their account name.  Used on account link and viewfee
	 */
	public function getFeeAndAccount( $id=null ) {
		$db = $this->getDbTable()->getAdapter();
		$query = $db->select()
		->from( array('f'=>'fee'), array('amount'=>'f.amount', 'id'=>'f.id', 'name'=>'f.name', 'refundable'=>'f.refundable') )
		->join( array('a'=>'account'),'f.debitAccountId=a.id',array('debitName'=>'a.name' ))
		->join( array('a2'=>'account'),'f.creditAccountId=a2.id',array('creditName'=>'a2.name' ));
		
		if( $id ) {
			$query->where( 'f.id = ?', $id );
		}

		$resultSet = $db->query( $query );
			
		$container = null;
		foreach ($resultSet as $row){
		    $container[] = $row;
		}
		if( $container) {  // cries
			$container = array_shift( $container );
		}

		return $container;
	}
	
	/**
	 *  Return account link for fees
	 */
	public function getAccountLink(){
		$alModel = new Financial_Model_AccountLink();
		$alModel->setDebitAccountId( $this->getDebitAccountId() );
		$alModel->setCreditAccountId( $this->getCreditAccountId() );
		return $alModel;
	}
	
	/**
	 *  Return fee id of those used so they cannot be deleted
	 *  applicantFeeBill, applicantFeeSetting, applicantPreleaseFeeBill, forfeitedFee, leaseFee, refund
	 */
	public function getAttachedFees(){
	    $db = $this->getDbTable()->getAdapter();
	    
	    //  Well thank god the children weren't onboard to see it
	    $query = "SELECT f.id
	              FROM fee AS f
		      JOIN applicantFeeBill AS afb ON afb.feeId = f.id
		      UNION
		      SELECT f.id
	              FROM fee AS f
		      JOIN applicantFeeSetting AS afs ON afs.feeId = f.id
		      UNION
		      SELECT f.id
	              FROM fee AS f
		      JOIN applicantPreleaseFeeBill AS apfb ON apfb.feeId = f.id
		      UNION		      
		      SELECT f.id
	              FROM fee AS f
		      JOIN forfeitedFee AS ff ON ff.feeId = f.id
		      UNION
		      SELECT f.id
	              FROM fee AS f
		      JOIN leaseFee AS lf ON lf.feeId = f.id
		      UNION
		      SELECT f.id
	              FROM fee AS f
		      JOIN refund AS r ON r.feeId = f.id";
		      
            $resultSet = $db->query( $query );
			
	    $container = array();

	    foreach ($resultSet as $row){
		$container[$row['id']] = $row['id'];
	    }	    
	    return $container;	    
	}	
	
}
?>
