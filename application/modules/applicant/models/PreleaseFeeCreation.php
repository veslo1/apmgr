<?php
/**
 * Created on October 8, 2010 by rnelson
 * @name apmgr
 * @package application.modules.applicant.models
 * <p>
 * Creates prelease fees
 * * </p>
 */


class Applicant_Model_PreleaseFeeCreation extends ZFModel_ParentModel {
	
	protected $applicantId;
	protected $feeId;
	protected $dueDate;
	protected $feeBillIdToApply;	
	protected $db;

	public function __construct(array $options=null) {
		parent::__construct($options);		
		$this->db = Zend_Registry::get('db'); 
		$this->setDbAdapter( $this->db );
	}
	 
	/**
	 *  ApplicantId
	 */
	public function setApplicantId( $var ){
		$this->applicantId = $var;
	}
	
	/**
	 *  get ApplicantId to create
	 */
	public function getApplicantId(){
		return $this->applicantId;
	} 
	 
	/**
	 *  FeeId to create
	 */
	public function setFeeId( $var ){
		$this->feeId = $var;
	}
	
	/**
	 *  get FeeId to create
	 */
	public function getFeeId(){
		return $this->feeId;
	}
		 
	/**
	 *  Due date
	 */
	public function setDueDate( $var ){
		$this->dueDate = $var;
	}
	
	/**
	 *  Due date
	 */
	public function getDueDate(){
		return $this->dueDate;
	}
	 
	/**
	 *  applicantFeeBillId to apply towards the prelease fee
	 */
	public function setFeeBillIdToApply( $var ){
		$this->feeBillIdToApply = $var;
	}
	
	/**
	 *  applicantFeeBillId to apply towards the prelease fee
	 */
	public function getFeeBillIdToApply(){
		return $this->feeBillIdToApply;
	}

	/**
	 *  create prelease fee
	 *	 
	 */
	public function createPreleaseFee(){
		$this->db->beginTransaction();		
		try{
			/* for creating prelease fee...
			   1.  create a bill - pass accountLink obj (from feeObj)
			   2.  save to prelease table
			   3.  *if* apply to fee is set...
			       (a)  create payment/detail record on the created billId with the transfer type - pass accountLinkObj
			       (b)  manually unset bill to unpaid since the current post payment assumes paid
			       (c)  add to bill transaction table
			       (d)  add row in transfer table
			       (e)  modify the refund creation function and tests to account for transfers			  									  
                         */		
			$billId = $this->makeBill();			
			$preleaseId = $this->savePrelease( $billId );			
			if( $this->getFeeBillIdToApply() ){			    
			    $result = $this->applyFee($billId);			    
			}
			$this->db->commit();
			return true;
		}
		catch ( Exception $e) {
			//var_dump( $e ); die;
			$this->db->rollBack();		
			return false;
		}
	}
	
	/**
	 *  Create the bill
	 */
	private function makeBill(){
		$feeObj = new Financial_Model_Fee();
		$feeItem = $feeObj->findById( $this->getFeeId() );				
		
		$billCreationObj = new Financial_Model_BillCreation(array( 'db'=> $this->db ));
		$billCreationObj->setDueDate( $this->getDueDate() );
		$billCreationObj->setBillAmountDue( $feeItem->getAmount() );
		$billCreationObj->setAccountLink( $feeItem->getAccountLink() );
		$billId = $billCreationObj->createBill();		
		
		if(!$billId){
		    $this->setMessageState( 'errorCreatingBill' );	
		    throw new Exception();
		}			
		return $billId;
	}
	
	/**
	 *  Save Prelease
	 */
	private function savePrelease($billId){
		$feeObj = new Financial_Model_Fee();
		$feeItem = $feeObj->findById( $this->getFeeId() );
		
		$preleaseObj = new Applicant_Model_Prelease(array( 'db'=> $this->db ));
		$preleaseObj->setApplicantId( $this->getApplicantId() );
		$preleaseObj->setBillId( $billId );
		$preleaseObj->setFeeId( $this->getFeeId() );
		$preleaseObj->setAmount( $feeItem->getAmount() );

		$id = $preleaseObj->save();
		
		if(!$id){
		    $this->setMessageState( 'errorSavingPreleaseFee' );		
		    throw new Exception();
		}		
		return ($id)?true:false;
	}
	
	/**
	 *  Returns the applicant fee bill item
	 */ 
	private function getApplicantFee(){
		$afbObj = new Applicant_Model_FeeBill();
		$afbItem = $afbObj->findById( $this->getFeeBillIdToApply() );						
				
		if( !empty($afbItem) ){
		    if( !$afbItem->getId() || !$afbItem->getBillId() || !$afbItem->getAmount()){			
		        $this->setMessageState( 'missingApplicantFeeBill' );		
		        throw new Exception();		
		    }
		    else{
		        return $afbItem;
		    }
		}
		else{
			$this->setMessageState( 'missingApplicantFeeBill' );		
		        throw new Exception();	
		}
	}
	
	/**
	 *   Apply paid fee towards added fee
	 */
	private function applyFee($toBillId){
		
		$afbItem = $this->getApplicantFee();		
		$feeObj = new Financial_Model_Fee();					
		$feeApply = $feeObj->findById( $afbItem->getFeeId() );		
		
		//  4.  Add validation to the form or model so that the amount paid cannot > amount of the bill
                //  5.  Add validation to tell user the selected bill has already been applied to a fee and cannot be used											 
		if( $feeApply ){
		    $amount = $afbItem->getAmount();
		    $fromBillId = $afbItem->getBillId();
		    if( $this->checkTransferAmount( $toBillId, $amount )  && $this->checkBillApplication($fromBillId) ){ 	
		        // the billId to pay off, the fee to apply towards the bill (needed for the accountlink), and the amount paid in the applicantFeeBill	
		        $transactionId = $this->addPayment( $toBillId, $feeApply, $amount );
		        $this->addTransfer($fromBillId, $toBillId, $amount, $transactionId);
		    }    		    
		}
		else{
			$this->setMessageState('applyFeeNotExist');	// no exception because applying the fee is optional
			return false;
		}		
	}	
	
	/**
	 *   Apply payment - billId to apply towards, the fee object to apply, the amount to pay off
	 */
	private function addPayment($billId, $feeApply, $amount){
		$feeObj = new Financial_Model_Fee();
		$feeItem = $feeObj->findById( $this->getFeeId() );
		
		$accountLink = new Financial_Model_AccountLink();
		$accountLink->setDebitAccountId( $feeApply->getAccountLink()->getCreditAccountId() ); // wipes off the deposit/fee 
		$accountLink->setCreditAccountId( $feeItem->getAccountLink()->getDebitAccountId() );	// transfers to other account
		
		$pmtCreationObj = new Financial_Model_PaymentCreation(array('db'=> $this->db));
		$pmtCreationObj->setAccountLink($accountLink);
		$pmtCreationObj->setAmountPaid( $amount );
		$pmtCreationObj->setBillId( $billId );
		$pmtCreationObj->setPaymentType( 'transfer' );
		$pmtCreationObj->setTotalAmount( $amount );  
		$pmtCreationObj->setPayor( 'Applied from '.$feeApply->getName() );
		$pmtCreationObj->setPaid('0');
		
		if( !$pmtCreationObj->postPayment() ) {
			$this->setMessageState( $pmtCreationObj->getMessageState() );				
			throw new Exception();
		}
		else{
		    return $pmtCreationObj->getTransactionId();
		}		
	}
	
	/**
	 *  Add Transfer
	 */
	private function addTransfer($fromBillId, $toBillId, $amount, $transactionId){
		$transferObj = new Financial_Model_BillTransfer();		
		$transferObj->setFromBillId( $fromBillId );
		$transferObj->setToBillId( $toBillId );
		$transferObj->setAmount( $amount );
		$transferObj->setTransactionId( $transactionId );
		
		if( !$transferObj->save() ) {
			$this->setMessageState( $transferObj->getMessageState() );				
			throw new Exception();
		}
		else{
		    return true;
		}
	}
	
	/**
	 *  Check if amount to transfer > bill amount
	 */
	private function checkTransferAmount( $billId, $amount ){
		$billObj = new Financial_Model_Bill();
		$billItem = $billObj->findById( $billId );
		if( $amount > $billItem->getOriginalAmountDue() ){
		    $this->setMessageState( 'transferGreaterThanBillAmount' );				
		    throw new Exception();
		}
		else{
			return true;
		}
	}
	
	/**
	 *  Check if the bill to apply has already been applied elsewhere
	 */
	private function checkBillApplication( $fromBillId ){
		$billTransferObj = new Financial_Model_BillTransfer();		
		$transferItem = $billTransferObj->findByKey( array( 'search'=>array( 'fromBillId'=>$fromBillId ) ) );
		if( $transferItem ){
		    $this->setMessageState( 'transferAlreadyAppliedToBill' );				
		    throw new Exception();
		}
		else{
			return true;
		}		
	}
}
?>

