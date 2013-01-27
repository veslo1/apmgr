<?php
/**
 *  Model for the Prelease Fees in Applicant
 * 
 */
class Applicant_Model_Prelease extends ZFModel_ParentModel {

    public function __construct(array $options=null) { 
        parent::__construct($options);
        $this->setDbTable('Applicant_Model_DbTable_Prelease');
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
     * @var NO $applicantId
    */
    protected $applicantId;
    
    /**
     * Set applicantId
    */
    public function setApplicantId($applicantId) {
        $this->applicantId=$applicantId;
        return $this;
    }
    /**
     * Get applicantId
     */
    public function getApplicantId() {
        return $this->applicantId;
    }
    /**
     * @var NO $feeId
    */
    protected $feeId;
    
    /**
     * Set feeId
    */
    public function setFeeId($feeId) {
        $this->feeId=$feeId;
        return $this;
    }
    /**
     * Get feeId
     */
    public function getFeeId() {
        return $this->feeId;
    }
    /**
     * @var NO $billId
    */
    protected $billId;
    
    /**
     * Set billId
    */
    public function setBillId($billId) {
        $this->billId=$billId;
        return $this;
    }
    /**
     * Get billId
     */
    public function getBillId() {
        return $this->billId;
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
    
    /**
     *  Fetch prelease fees
     */
    public function fetchPreleaseFees(){
        $db = $this->getDbTable()->getAdapter();
	$query = $db->select()
	->from( array('prelease'=>'applicantPreleaseFeeBill'),array() )
	->join(array( 'f'=>'fee' ), 'prelease.feeId=f.id', array('feeName'=>'name'))
	->join(array( 'b'=>'bill' ), 'prelease.billId=b.id', array( 'billId'=>'id',
                                                                   'originalAmountDue'=>'originalAmountDue',
                                                                   'isPaid'=>'isPaid'))
        ->join(array( 'a'=>'applicant' ), 'prelease.applicantId=a.id', array())
	->where( 'a.id=?',$this->getApplicantId() );	

	$resultSet = $db->query( $query );

	$container = array();	
	foreach ($resultSet as $row){	    
	    $container[] = $row;
	}
	return $container; 
    }
    
    /**
	 *  Fetch Manual bills to pay
	 *  Used in the page to manually pay applicant bills
	 */
	public function fetchManualBillsToPay(){
		$db = $this->getDbTable()->getAdapter();
		
		$select = $db->select()
		->from( array('F'=>'fee'),array('feeName'=>'F.name', 'debitAccountId'=>'debitAccountId', 'creditAccountId'=>'creditAccountId'))
		->join( array('PL'=>'applicantPreleaseFeeBill'),'PL.feeId=F.id',array( 'preleaseId'=>'id' ))
		->join( array('bill'=>'bill'),'PL.billId=bill.id',array('billId'=>'id', 'originalAmountDue'=>'originalAmountDue'))
		->where('PL.applicantId=?',$this->getApplicantId(),'int')
		->where('bill.isPaid=0');		
		
		$resultSet = $db->query($select);						
		$container = null;		
		   		    
		foreach ($resultSet as $row) {
		    $billObj = new Financial_Model_Bill();
		    $billItem = $billObj->findById( $row['billId'] );		    
		    $row['currentAmountDue'] = $billItem->getCurrentAmountDue();
		    if($row['currentAmountDue']>0){
		        $container[$row['preleaseId']] = $row;
		    }	
		}		
		
		return $container;			
        }
        
        /**
         *  Used in lease wizard
         */
        public function fetchPreleaseFeeByUser( $users, $unitId ) {        	
		    $db = $this->getDbTable()->getAdapter();							
								
		    $select = $db->select()
		        ->from( array('F'=>'fee'),array('feeName'=>'F.name','feeId'=>'F.id'))
		        ->join( array('APL'=>'applicantPreleaseFeeBill'),'APL.feeId=F.id',array('preleaseId'=>'id','amount'=>'APL.amount', 'billId'=>'billId'))
		        ->join( array('AA'=>'applicantAppliance'),'AA.applicantId=APL.applicantId',array())
		        ->join( array('A'=>'applicant'),'AA.applicantId=A.id',array())
		        ->join( array('U'=>'user'),'A.userId=U.id',array('firstName'=>'U.firstName','lastName'=>'U.lastName'))		
		        ->where( 'AA.unitId=?', $unitId )
		        ->where( 'A.userId IN (?)', array_keys($users) )
		        ->order( 'F.name ASC' );		
						
		    $resultSet = $db->query($select);						
		    $container = null;		
		   		    
		    // key on prelease id so we can pull all the info out in the lease wizard		    
		    foreach ($resultSet as $row) {
		        $container[$row['preleaseId']]=$row;
		    }				
		    return $container;		
        }        
}
