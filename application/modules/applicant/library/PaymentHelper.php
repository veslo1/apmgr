<?php
/**
 * Helper for Applicant Payments to decouple the model from the business logic
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_Library_PaymentHelper implements ZFObserver_ILogeable,ZFInterfaces_Messageable {

	/**
	 * The total amount of the transaction
	 * @var double
	 */
	private $totalAmount;

	/**
	 * Collection of results
	 * @var array $payloadBills
	 */
	private $payloadBills;

	/**
	 * Log every operation
	 * @var ZFObserver_Forensic
	 */
	protected $logger;

	/**
	 * Buffer used to store messages while operating with payments
	 * @var array
	 */
	private $messageBuffer;

	/**
	 * Hold state messages
	 * @var string
	 */
	private $msg;
	
	/**
	 * Set the billIdStack
	 * @param int $billId
	 * @return Applicant_Library_PaymentHelper
	 */
	public function setApplicantFeeBillStack($billId) {
		$this->applicantFeeBillStack[] = $billId;
		return $this;
	}

	/**
	 *
	 * Return the list of created bills
	 * @return array
	 */
	public function getApplicantFeeBillStack() {
		return $this->applicantFeeBillStack;
	}

	/**
	 * Store the total amount
	 * @param double $amount
	 * @return Applicant_Library_PaymentHelper
	 */
	public function setTotalAmount($amount) {
		$this->totalAmount = $this->totalAmount + $amount;
		return $this;
	}

	/**
	 *
	 * Return the total amount of the transaction
	 * @return double
	 */
	public function getTotalAmount() {
		return $this->totalAmount;
	}

	/**
	 * Push into the collection the relation between the (billId=>feeId,feeObject)
	 * @param array $args
	 * @return Applicant_Library_PaymentHelper
	 */
	public function setPayLoadBills(array $args) {
		$this->payloadBills[] = $args;
		return $this;
	}

	/**
	 *
	 * Return the association between the bill and the feeId, and the proper fee object
	 * @return array
	 */
	public function getPayLoadBills() {
		return $this->payloadBills;
	}

	/**
	 * Create the bills for the applicant payment
	 * @param array $args Collection of Fee's
	 * @throws Exception
	 */
	public function initBilling(array $args=null) {
		$this->messageBuffer[] = __FUNCTION__.' Starts';
		$billId = null;
		$applicantId = null;
		$feeId = null;
		//	The results from the operation
		$applicantFeeBillStack = array();
		//	Buffer for the payload
		$billPayload = array();

		if ( !isset($args['fees']) ) {
			$this->messageBuffer[] = __FUNCTION__." Missing the fee's. The system does not have any kind of fee to charge";
			throw new Exception("Missing the fee's used for this transaction");
		}
		//	Push into the payload the fee's

		if( !isset($args['applicantId']) ) {
			$this->messageBuffer[] = __FUNCTION__." Missing the applicantId , the system can't process a payment without an applicantId";
			throw new Exception("Missing the applicantId for this operation");
		}
		//	Prepare the statements for the createApplicantFeeBill call
		$applicantId = $args['applicantId'];
		$this->messageBuffer[]="We set the applicantId to #{$applicantId}";

		try {
			$db = Zend_Registry::get('db');
			$db->beginTransaction();
			$billCreation = new Financial_Model_BillCreation(array( 'db'=>$db ));

			foreach($args['fees'] as $id=>$fee) {
				$feeId = $fee->getId();
				$amount = $fee->getAmount();
				$this->messageBuffer[] = "Processing fee's with feeId:{$feeId},amount:{$amount}";

				//	On every iteration we have to buffer the amount of the bills for the payment
				$this->setTotalAmount($amount);
				//	We create the bill and we obtain the id
				$billId = $this->createBill($fee, $billCreation);
				$this->messageBuffer[] = "We created the bill #{$billId}";
				$applicantFeeBillStack[] = $billId;

				//	Persist into the big collection of paylodBills
				$this->setPayLoadBills(array('binding'=>array('billId'=>(int)$billId,'feeId'=>(int)$feeId),'fee'=>$fee) );
				//	And store the result into the list
				$this->setApplicantFeeBillStack($this->createApplicantFeeBill(array('feeId'=>(int)$feeId,'amount'=>(double)$amount,'billId'=>(int)$billId,'applicantId'=>(int)$applicantId)));
			}
			$this->messageBuffer[]= "Pushing transaction into the system and ready to create payments";
			$db->commit();
		} catch (Exception $e) {
			$this->messageBuffer[]="Exception caught with {$e->getMessage()}.System will roll back";
			$db->rollBack();
		}
		$this->fillLogBuffer();
		return $applicantFeeBillStack;
	}

	/**
	 *
	 * Persist the information into the Applicant_Model_FeeBill table
	 * @param array $args
	 * @return boolean
	 * @throws Zend_Db_Statement_Exception
	 */
	public function createApplicantFeeBill(array $args=null) {
		$result = false;
		$feeBill = new Applicant_Model_FeeBill($args);
		$result = $feeBill->save();
		return $result;
	}


	/**
	 * Create a bill in the system
	 * @param Financial_Model_Fee $fee
	 * @param Financial_Model_BillCreation $billCreation
	 * @return boolean
	 */
	public function createBill(Financial_Model_Fee $fee,Financial_Model_BillCreation $billCreation) {
		$billCreation->setAccountLink($fee->getAccountLink());
		$billCreation->setBillAmountDue($fee->getAmount());
		$billCreation->setDueDate(date('Y-m-d H:i:s'));
		$billId = $billCreation->createBill();
		return $billId;
	}

	/**
	 *    Return the cash account to post the payments to for applicant fees.  This is contained in the financialAccountSetting
	 *    table under the settingName = 'applicantFeeCashAccount'
	 *    Modifying to public so it can be used in ManualBillHelper
	 */
	public function getDebitAccountId(){
		$fasObj = new Financial_Model_FinancialAccountSetting();
		$param = array( 'returnClassObject'=>true, 'search'=> array( 'settingName'=>'applicantFeeCashAccount' ));
		$fasItem = $fasObj->findByKey( $param );

		$this->messageBuffer[]="Setting getDebitAccountId";
		if( empty($fasItem) ) {
			return false;
		} else {
			$item = array_shift( $fasItem );
			$accountId = $item->getAccountId();
			return ($accountId)?$accountId:false;
		}
	}
	
	/**
	 *    Return the cash account to post the payments to for applicant fees.  This is contained in the financialAccountSetting
	 *    table under the settingName = 'applicantPreleaseFeeCashAccount'
	 *    Modifying to public so it can be used in ManualBillHelper
	 */
	public function getPreleaseDebitAccountId(){
		$fasObj = new Financial_Model_FinancialAccountSetting();
		$param = array( 'returnClassObject'=>true, 'search'=> array( 'settingName'=>'applicantPreleaseFeeCashAccount' ));
		$fasItem = $fasObj->findByKey( $param );

		$this->messageBuffer[]="Setting getPreleaseDebitAccountId";
		if( empty($fasItem) ) {
			return false;
		} else {
			$item = array_shift( $fasItem );
			$accountId = $item->getAccountId();
			return ($accountId)?$accountId:false;
		}
	}

	/**
	 *
	 * Iterate over the payload and continue to link the fee's with the proper accounts
	 * @param array $feeList
	 * @return Financial_Model_AccountLink
	 */
	public function createPayment(array $args=null) {
		$this->messageBuffer[]=__FUNCTION__.' Starts';

		$billId = null;
		$feeId = null;
		$paymentResult = array();
		$payorName = $args['payorName'];
		$this->messageBuffer[]="The payor name we received is {$payorName}";
		unset($args['payorName']);

		if ( isset($args) ) {
			$accountLink = new Financial_Model_AccountLink();
			$paymentCreation = new Financial_Model_PaymentCreation();
			foreach($args as $id=>$type) {
				$this->messageBuffer[]="About to bind the payment and the fee";
				$paymentResult [] = $this->bindPayment($paymentCreation, $accountLink,$type['fee'],$type['binding']['billId'],$payorName);
			}
		} else {
			$this->messageBuffer[]= "We did not have an array the payment failed bad and there is no way to retrieve the information since this action was called with no information at all";
			$paymentResult[] = false;
		}
		$this->fillLogBuffer();
		return !in_array(false,$paymentResult);
	}

	/**
	 * Bind the payment object with the dependencies and generate the payment.Return the result of the operation
	 * @param Financial_Model_PaymentCreation $paymentCreation
	 * @param Financial_Model_AccountLink $accountLink
	 * @param Financial_Model_Fee $fee
	 * @param int $billId
	 * @param string $payorName
	 * @return boolean
	 */
	protected function bindPayment(Financial_Model_PaymentCreation $paymentCreation,Financial_Model_AccountLink $accountLink,Financial_Model_Fee $fee,$billId,$payorName) {
		$result = false;
		//TODO This will be changed for a setting
		$creditAccountId = $fee->getCreditAccountId();
		//$debitAccountId = $fee->getDebitAccountId();
		$this->messageBuffer[]="Fetching getDebitAccountId";
		$debitAccountId = $this->getDebitAccountId(); // pull from the financial account setting
		if( $debitAccountId<=0 ) {
			$this->messageBuffer[]="Failing because debugAccountId is greater than 0";
			return false;
		}

		$amount = $fee->getAmount();
		$totalAmount = $this->getTotalAmount();
		$type = 'creditcard';
		$this->messageBuffer[] = __FUNCTION__." starts";
		$this->messageBuffer[] = "About to bind the payment with this arguments";
		$this->messageBuffer[] = "Credit Account Id:{$creditAccountId}";
		$this->messageBuffer[] = "Debit Account Id:{$debitAccountId}";
		$this->messageBuffer[] = "Amount :$ {$amount}";
		$this->messageBuffer[] = "Payment Type :creditcard";
		$this->messageBuffer[] = "Total amount : $ {$totalAmount}";
		$accountLink->setDebitAccountId($creditAccountId);
		$accountLink->setCreditAccountId($debitAccountId);
		//	Create the payment
		$paymentCreation->setAccountLink($accountLink);
		$paymentCreation->setAmountPaid($amount);
		$paymentCreation->setTotalAmount($totalAmount);
		$paymentCreation->setPaymentType($type);
		$paymentCreation->setPayor($payorName);
		$paymentCreation->setReuseDetailId(true);
		$paymentCreation->setBillId($billId);
		$result = $paymentCreation->postPayment();
		$this->messageBuffer[] = "Binding a payment ended up with {$result}";
		return $result;
	}

	/**
	 * Perform a comparation between the x_amount field from authorize and the fee's in the system
	 * @return array
	 */
	public function validateFeeIntegrity() {
		$applicantFee = new Applicant_Model_FeeSetting();
		$fee = new Financial_Model_Fee();
		$appFees = $applicantFee->fetchAll(false,false,true);
		$listFee = array();
		$buffer = 0;
		if( count($appFees) >0 ) {
			foreach($appFees as $id=>$appFee) {
				$param = array( 'returnClassObject'=>true, 'search'=> array( 'id'=>$appFee['feeId'],'enabled'=>1 ));
				$listFee[]= array_shift( $fee->findByKey($param) );
			}
		}
		return $listFee;
	}

	/**
	 * Retrieve an array of Fee's and iterate over each other and return the total count
	 * @param array $fees
	 * @return number
	 */
	public function accumulateFeeSum(array $fees=null) {
		$buffer = 0;
		if( count($fees) > 0 ) {
			foreach( $fees as $id=>$object ) {
				$buffer += $object->getAmount();
			}
		}
		return $buffer;
	}

	/**
	 * Retrieve fee's for the current user
	 * @param int $applicantId
	 * @param array $sortArgs
	 * @return multitype:
	 * @throws Applicant_Library_Exception
	 */
	public function getDueFees($applicantId,array $sortArgs=null) {
		$dueFees = array();
		$order = null;
		//	Determine if they passed me the userid
		if( !isset($applicantId) ) {
			throw new Applicant_Library_Exception("Missing userId", __FUNCTION__);
		}
		$applicantPayment = new Applicant_Model_Payment();
		$check = $applicantPayment->exists(array('column'=>'applicantId','table'=>'applicantFeeBill'), $applicantId);
		if ( false==$check ) {
			//	Determine if payment is enabled
			$params = array('search'=>array('name'=>'paymentSystem'));
			$setting = new Settings_Model_Settings();
			$setting = array_shift( $setting->findByKey($params) );
			$settingEnabled = $setting->getValue();
			//	And go get links
			if ( 1==$settingEnabled ) {
				$dueFees = $this->getFees($sortArgs);
			}
		}
		return $dueFees;
	}


	/**
	 * Retrieve fee's that enabled
	 * @param array $sortArgs
	 * @throws Applicant_Library_Exception
	 * @return array
	 */
	public function getFees(array $sortArgs=null) {
		$order = null;
		if( isset($sortArgs['column']) and isset($sortArgs['sort']) ) {
			$order = $sortArgs['column'].' '.$sortArgs['sort'];
		}
		$dueFees = array();
		$applicantFees = new Applicant_Model_FeeBill();
		$db = $applicantFees->getDbTable()->getAdapter();
		$select = $db->select()
		->from(array('AFS' => 'applicantFeeSetting'),array(null))
		->join( array('F'=>'fee',array('name'=>'F.name','amount'=>'F.amount')),'F.id = AFS.feeId')
		->where('F.enabled=?',1,'int');
		if(null!==$order) {
			$select->order($order);
		}

		$rows = $db->query($select);
		if( count($rows)>0 ) {
			foreach($rows as $id=>$fee) {
				$dueFees[] = array('name'=>$fee['name'],'amount'=>$fee['amount']);
			}
		} else {
			//	We should have always 1 record at least
			throw new Applicant_Library_Exception("feeSystemCorrupted");
		}
		return $dueFees;
	}

	/**
	 * Retrieve paid fee's for given user
	 * @param int $applicantId The applicant id you are retrieving
	 * @param array $sortArgs
	 * @return multitype:
	 */
	public function getPaidFees($applicantId,array $sortArgs=null) {
		$paidFees = array();
		$order = null;

		if( isset($sortArgs['column']) and isset($sortArgs['sort']) ) {
			$order = $sortArgs['column'].' '.$sortArgs['sort'];
		}

		$fee = new Financial_Model_Fee();
		$db = $fee->getDbTable()->getAdapter();
		$select = $db->select()
		->from( array('F'=>'fee'),array('name'=>'F.name','amount'=>'F.amount'))
		->join( array('AFB'=>'applicantFeeBill'),'AFB.feeId=F.id',array('paidDate'=>'AFB.dateCreated', 'feeId'=>'F.id', 'feeBillId'=>'id', 'paidAmount'=>'amount'))
		->where('F.enabled=?',1,'int')
		->where('AFB.applicantId=?',$applicantId,'int');

		if(null!==$order) {
			$select->order($order);
		}
		$rows = $db->query($select);
		if( count($rows)>0 ) {
			foreach($rows as $id=>$fee) {
				$paidFees[] = array( 'feeBillId'=>$fee['feeBillId'],'feeId'=>$fee['feeId'],'name'=>$fee['name'],'amount'=>$fee['amount'] , 'paidDate'=>$fee['paidDate'], 'paidAmount'=>$fee['paidAmount'] );
			}
		} else {
			//	We should have always 1 record at least
			throw new Applicant_Library_Exception("feeSystemCorrupted");
		}
		return $paidFees;
	}

	/**
	 * Determine if the payment system is enabled
	 * @return boolean
	 */
	public function isPaymentEnabled() {
		$paymentEnabled = false;
		$setting = new Settings_Model_Settings();
		$setting = $setting->findByKey( array('returnClassObject'=>true,'search'=> array('name'=>'paymentSystem') ) );
		if( !empty($setting) ){
			$setting = array_shift($setting);
			$paymentEnabled=$setting->getValue();
		}
		$total = $this->getFeesTotal();
		return ($total>0 && $paymentEnabled!=false);
	}

	/**
	 * Return the sum of enabled applicant fee's
	 * @return int
	 */
	public function getFeesTotal() {
		$applicantFeeSetting = new Applicant_Model_FeeSetting();
		$result = $applicantFeeSetting->retrieveEnabledFees();
		$total = 0;
		foreach($result as $id=>$value) {
			$total +=(int)$value['amount'];
		}
		return $total;
	}

	/**
	 * Retrieve the buffered messages to use wherever is needed
	 * @return multitype:(string)
	 */
	public function getMessageBuffer() {
		return $this->messageBuffer;
	}

	/**
	 * Contains an stack of messages that the object collected and propagates them to the system
	 */
	public function fillLogBuffer()
	{
		$this->logger = new ZFObserver_Forensic();
		$this->logger->attach( new ZFObserver_Observers_Db() );
		$this->logger->attach( new ZFObserver_Observers_Text() );
		$this->logger->setStatus( ZFObserver_ILogeable :: INFO);
		if (!isset($this->messageBuffer)) {
			$this->logger->setStatus(ZFObserver_ILogeable::CRIT);
			$this->logger->notify($this, "The operations didn't add any element to the stack of messages");
		} else {
			foreach($this->messageBuffer as $id=>$msg) {
				$this->logger->notify($this, $msg);
			}
		}
	}
	
	/**
	 * Validate the request parameters that arrive in the controller
	 * @param array $request
	 * @return boolean
	 */
	public function validatePayAction(array $request=null){
		$valid = true;
		if( !isset($request['id']) ){
			$this->setMessageState('applicantIdMissing');
			$valid = false;
		}else{
			$paymentEnabled = $this->isPaymentEnabled();
			if(true==$paymentEnabled){
				$applicant = new Applicant_Model_Applicant();
				$validApplicant = $applicant->exists(array('table'=>'applicant','column'=>'id'),$request['id']);
				if( false==$validApplicant){
					$this->setMessageState('applicantIdNotValid');
					$valid = false;
				}
			} else {
				$this->setMessageState('paymentDissabled');
				$valid = false;
			}
		}
		return $valid;
	}
	
	/**
	 * Set the message state
	 * @param $msg
	 */
	public function setMessageState($msg){
		$this->msg = $msg;
		return $this;
	}
	
	public function getMessageState(){
		return $this->msg;
	}
	
	/**
	 * Implementation of the magic method
	 * @return string
	 */
	public function __toString()
	{
		return "PaymentHelper";
	}
	
	/**
	 *  Fetch Manual bills to pay
	 *  Used in the page to manually pay applicant bills
	 */
	public function fetchManualBillsToPay( $applicantId ){
		$fee = new Financial_Model_Fee();
		$db = $fee->getDbTable()->getAdapter();
		
		$select = $db->select()
		->from( array('F'=>'fee'),array('feeName'=>'F.name', 'debitAccountId'=>'debitAccountId', 'creditAccountId'=>'creditAccountId'))
		->join( array('AFB'=>'applicantFeeBill'),'AFB.feeId=F.id',array('applicantFeeBillId'=>'AFB.id'))
		->join( array('bill'=>'bill'),'AFB.billId=bill.id',array('billId'=>'id', 'originalAmountDue'=>'originalAmountDue'))
		->where('AFB.applicantId=?',$applicantId,'int')
		->where('bill.isPaid=0');		
		
		$resultSet = $db->query($select);						
		$container = null;		
		
		if( $resultSet ) {		   		    
		    foreach ($resultSet as $row) {			 
		        $billObj = new Financial_Model_Bill();
		        $billItem = $billObj->findById( $row['billId'] );		    
		        $row['currentAmountDue'] = $billItem->getCurrentAmountDue();			
		        if($row['currentAmountDue']>0){			    
		            $container[$row['applicantFeeBillId']] = $row;
		        }	
		    }		    	
		}		
		return $container;			
	}
	
	/**
	 *  Fetches bill sum for the payment form
	 *  Passes in an array of bill ids
	 */
	public function getBillSum( $bills ){
		$sum = 0.00;
		if( $bills ){
		    foreach( $bills as $id=>$billId ) {
		        $billObj = new Financial_Model_Bill();
		        $billItem = $billObj->findById( $billId );		    
		        $sum += $billItem->getCurrentAmountDue();
		    }	
		}
		return $sum;
	}
}