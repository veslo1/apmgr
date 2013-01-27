<?php
/**
 *  Class created 9/10/10 to handle refund and forfeit creation
 */
class Financial_Model_RefundCreation extends ZFModel_ParentModel {

	/**
	 * @var NO $fee
	 */
	private $fee;  //not stored in db.  holds fee object for processing
	 
	/**
	 * Set fee - used internally
	 */
	private function setFee($fee) {
		$this->fee=$fee;
		return $this;
	}

	/**
	 * Get fee - used internally
	 */
	private function getFee() {
		return $this->fee;
	}

	protected $object;  //not stored in db.  object for processing
	 
	/**
	 * Set object
	 */
	public function setObject($var) {
		$this->object=$var;
		return $this;
	}

	/**
	 * Get object
	 */
	public function getObject() {
		return $this->object;
	}

	protected $transactionId;
	/**
	 *  Transaction Id
	 */
	public function getTransactionId(){
		return $this->transactionId;
	}

	public function setTransactionId( $var ){
		$this->transactionId = $var;
	}

	/**
	 *  Financial account setting
	 */
	public function getSetting(){
		return $this->setting;
	}

	public function setSetting( $var ){
		$this->setting = $var;
	}

	/**
	 *  wrapper
	 */
	public function forfeit(){
		return $this->refundOrForfeit();
	}

	/**
	 *  wrapper
	 */
	public function refund(){
		return $this->refundOrForfeit();
	}

	/**
	 *  Refunds to the user.  The lease agent still needs to manually cut the check.  This
	 *  function assumes this process has taken place.
	 */
	private function refundOrForfeit(){
		$return = false;
		// verifies fee is valid
		if($this->verifyFee() && $this->checkAmount() && $this->hasAccountLink()){
			if($this->process())
			$return = true;
		}
		return $return;
	}
	 
	/**
	 *  Creates the refund in the tables
	 */
	private function process(){
		$db = Zend_Registry::get('db');
		$this->setDbAdapter( $db );
	 $db->beginTransaction();

	 try{
	 	 
	 	/* write to account transaction records
	 	 1.  account transaction
	 	 2.  bill transaction
	 	 3.  refund
	 	 */
	 	$ftc = new Financial_Model_FinancialTransactionCreation(array('db'=>$db));
	 	$ftc->setAccountLink( $this->fetchAccountLink() );
	 	$ftc->setAmount($this->getObject()->getAmount());
	 	$ftc->setBillId($this->getObject()->getBillId());
		$ftc->setComment($this->getObject()->getComment());

	 	$result = $ftc->createFinancialRecord();
	 	$this->getObject()->setTransactionId( $ftc->getTransactionId() );
	 	$id = $this->getObject()->save(); // process refund or forfeit

	 	if( $result===false ){
	 		throw new Exception( 'errorSavingFinancialRecords' );
	 	}

	 	if( empty($id) ){
	 		throw new Exception( 'errorSavingRefundOrFee' );
	 	}

	 	$db->commit();
	 	return $result;
	 }
	 catch ( Exception $e) {
	 	// rollback here kills the entire transaction. (if a transaction exists in the calling function)
	 	$db->rollBack();
	 	echo $e->getMessage();
	 	return false;
	 }
	}
	 
	/**
	 *  generate account link for the refund based on the fee and financial account setting
	 */
	private function fetchAccountLink(){
	 $fasObj = new Financial_Model_FinancialAccountSetting();
	 $cashAccount = array_shift($fasObj->findByKey( array('search'=>array('settingName'=>$this->getSetting()))));
	 $alObj = new Financial_Model_AccountLink();
	 $alObj->setDebitAccountId( $this->getFee()->getCreditAccountId() );
	 $alObj->setCreditAccountId( $cashAccount->getAccountId() );
	 return $alObj;
	}
	 
	/**
	 *  Pulls and stores the fee object locally into $this->fee
	 */
	private function fetchFee(){
		$feeObj = new Financial_Model_Fee();
		$fee = $feeObj->findById($this->getObject()->getFeeId());
		 
		if(!empty($fee)){
			$this->setFee( $fee );
			return true;
		}
		else
		return false;
	}
	 
	/**
	 *  Verifies if fee is refundable and has an amount
	 */
	private function verifyFee(){
		$return = null;
		if($this->fetchFee()){
			if( !$this->getFee()->getRefundable() ) {
				$this->setMessageState('feeNotRefundable');
				$return=false;
			}
			 
			if($this->getFee()->getAmount()<='0' )  {
				$this->setMessageState('feeAmountZero');
				$return=false;
			}
		}
		else{
			$this->setMessageState('feeNotFound');
		}
		return ($return===false)? $return: true;  //if not set to false, return true
	}
	 
	/**
	 *  Checks that the refund amount is ok and doesn't create any irregularities
	 */
	private function checkAmount(){
		$return = false;
		// if amount valid
		if( $this->getObject()->getAmount()>'0' ){
		        $refundHelper = new Financial_Library_RefundHelper();
			$maxAmount = $refundHelper->fetchMaxAmount($this->getObject()->getBillId());  // fetches payments made - refunds
			if( $maxAmount >= $this->getObject()->getAmount() ){
				// see if amount to refund > already made payments
				$return = true;
			}
			else{
				$this->setMessageState('maxRefundAmountLessThanRefundAmount');
			}
		}
		else{
			$this->setMessageState('invalidRefundAmount');
		}
		return $return;
	}
	 
	/**
	 *  Check if account link is set
	 */
	private function hasAccountLink(){
		$return = null;
	 $fasObj = new Financial_Model_FinancialAccountSetting();
	 $cashAccount = $fasObj->findByKey( array('search'=>array( 'settingName'=>$this->getSetting() ) ));

	 if(!$cashAccount){
	 	$this->setMessageState('missingCreditAccount');
	 	$return = false;
	 }

	 if( !$this->getFee()->getCreditAccountId() ) {
	 	$this->setMessageState('missingDebitAccount');
	 	$return = false;
	 }

	 return ($return===false)?false:true;
	}	 
} // end class
