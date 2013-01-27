<?php
/**
 *
 * @author Complete with your name <andyouremail@debserverp4.com.ar>
 */
class Financial_Model_BillTransfer extends ZFModel_ParentModel {

    public function __construct(array $options=null) { 
        parent::__construct($options);        
        $this->setDbTable('Financial_Model_DbTable_BillTransfer');
    }
    /**
     * @var NO $id
    */
    protected $id;
    
    /**
     * Set id
    */
    public function setId($id) {
        $this->id=$id;
        return $this;
    }
    /**
     * Get id
     */
    public function getId() {
        return $this->id;
    }
    /**
     * @var NO $fromBillId
    */
    protected $fromBillId;
    
    /**
     * Set fromBillId
    */
    public function setFromBillId($fromBillId) {
        $this->fromBillId=$fromBillId;
        return $this;
    }
    /**
     * Get fromBillId
     */
    public function getFromBillId() {
        return $this->fromBillId;
    }
    /**
     * @var NO $toBillId
    */
    protected $toBillId;
    
    /**
     * Set toBillId
    */
    public function setToBillId($toBillId) {
        $this->toBillId=$toBillId;
        return $this;
    }
    /**
     * Get toBillId
     */
    public function getToBillId() {
        return $this->toBillId;
    }
    /**
     * @var NO $amount
    */
    protected $amount;
    
    /**
     * Set amount
    */
    public function setAmount($amount) {
        $this->amount=$amount;
        return $this;
    }
    /**
     * Get amount
     */
    public function getAmount() {
        return $this->amount;
    }
    /**
     * @var NO $dateCreated
    */
    protected $dateCreated;
    
    /**
     * Set dateCreated
    */
    public function setDateCreated($dateCreated) {
        $this->dateCreated=$dateCreated;
        return $this;
    }
    /**
     * Get dateCreated
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }
    /**
     * @var YES $dateUpdated
    */
    protected $dateUpdated;
    
    /**
     * Set dateUpdated
    */
    public function setDateUpdated($dateUpdated) {
        $this->dateUpdated=$dateUpdated;
        return $this;
    }
    /**
     * Get dateUpdated
     */
    public function getDateUpdated() {
        return $this->dateUpdated;
    }
    
    /*
    * @var $transactionId
    */
    protected $transactionId;
    
    /**
     * Set transactionId
    */
    public function setTransactionId($var) {
        $this->transactionId=$var;
        return $this;
    }
    
    /**
     * Get transactionId
     */
    public function getTransactionId() {
        return $this->transactionId;
    }
    
    /**
     *  Returns the summed forfeits for a specified bill.  Used for finding the max refund amount
     */
     public function getTransferSumByFromBillId(){
 	$db = $this->getDbTable()->getAdapter();
	$select = $db->select()
	->from( array('billTransfer') , array('transferSum'=> new Zend_Db_Expr('SUM(amount)')))
	->where( 'fromBillId=?',$this->getFromBillId() )
	->group('fromBillId');

	$row = $db->fetchRow($select);

	if( $row ){
            return $row['transferSum'];
        }    
	else{
	    return 0;
        }   
     }
     
     /**
      *  Fetches all transfers for a bill id (both incoming and outgoing) - used on bill view page
      */
     /*
     public function fetchAllTransferRecords(){
         $db = $this->getDbTable()->getAdapter();
	 $select = $db->select()
	           ->from( array('billTransfer') )
	           ->where( 'fromBillId=?',$this->getFromBillId() )
                   ->orWhere( 'toBillId=?',$this->getToBillId() );	           

	 $resultSet = $db->fetchAll($select);

	 $container = null;
	 foreach ($resultSet as $row){
	     $container[] = $row;
	 }
 	 return $container;                
     }
     */
}
