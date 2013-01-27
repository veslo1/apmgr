<?php
/**
 * Helper for paying bills manually for applicants
 */

class Unit_Library_ManualBillHelper implements ZFInterfaces_Messageable{				
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
		return "ManualBillHelper";
	}	
		
	/**
	 *  Returns the sum of the bills
	 */	
	public function getBillSum( $rentBills, $leaseFeeBills ){
		$sum = 0.00;		
		if( $rentBills ){		     	
		    foreach( $rentBills as $id=>$row ) {		        		        		    
		        $sum += $row['currentAmountDue'];
		    }	
		}
		
		if( $leaseFeeBills ){		     	
		    foreach( $leaseFeeBills as $id=>$row ) {		        		        		    
		        $sum += $row['currentAmountDue'];
		    }	
		}
		return $sum;
	}	
	
	/**
	 *  Method for controller to pay bills
	 */	
	public function payBills( $paymentInfo, $rentBills, $leaseFees ) {					
		$db = Zend_Registry::get('db');
		$db->beginTransaction();
		
		try{
		    $pmtCreationObj = new Financial_Model_PaymentCreation( array( 'db'=>$db ) );
		    $pmtCreationObj->setReuseDetailId(1);
		    $result=false;		
		
		    if( $rentBills ){				
		        
		        //   1.  Place the below block into a helper class or smtg
		        //   2.  Take into account the accountLink
		        
		        $result=false;			
		        $result = $this->createPayment( $pmtCreationObj, $rentBills, $paymentInfo );			
		    }		
		    
		    if( $leaseFees ){				
		        
		         //  1.  Place the below block into a helper class or smtg
		         //  2.  Take into account the accountLink
		         
		         $result=false;
		         $result = $this->createPayment( $pmtCreationObj, $leaseFees, $paymentInfo, true );
		    }		    
		    $db->commit();
		    return $result;
		}
		catch ( Exception $e) {
			//var_dump( $e );
			$db->rollback();			
			return false;
		}
	}	
	
	/**
	 *  Function to pay bills
	 */	
	private function createPayment($pmtCreationObj, $bills, $paymentInfo, $isLeaseFees=false ){		
		$pmtCreationObj->setPaymentType( $paymentInfo['paymentType'] );
                $pmtCreationObj->setTotalAmount( $paymentInfo['totalAmount'] );  
                $pmtCreationObj->setPayor( $paymentInfo['payor'] );  
		
		$accountLink = new Financial_Model_AccountLink();
		$debitAccountId=null;
		
		if( $isLeaseFees ){
			$debitAccountId = $this->getLeaseFeeDebitAccountId();
		}
		else{
			$debitAccountId = $this->getDebitAccountId();
		}
		
		$accountLink->setDebitAccountId( $debitAccountId );  // pull in setting		
		
		foreach( $bills as $bill ){				    
		    $accountLink->setCreditAccountId( $bill['debitAccountId'] );  // wipe off receivable                
                    $pmtCreationObj->setAccountLink($accountLink);
                    $pmtCreationObj->setAmountPaid( $bill['currentAmountDue'] );
                    $pmtCreationObj->setBillId( $bill['billId'] );                              				
		    		    		
                    if( !$pmtCreationObj->postPayment() ) {
	                $this->setMessageState( $pmtCreationObj->getMessageState() );			
	                throw new Exception();
                    }
                    else{
                        return true;  
		    }
		}    
	}	
	
	/**
	 *  Fetch lease fees to pay
	 *  Used in the page to manually pay lease fees bills
	 *  Displays lease fees that are due up to one month out from today's date
	 */	
	public function fetchLeaseFeesToPay( $leaseId ){
		$fee = new Financial_Model_Fee();
		$db = $fee->getDbTable()->getAdapter();
		
		$select = $db->select()
		->from( array('F'=>'fee'),array('feeName'=>'F.name', 'debitAccountId'=>'debitAccountId'))		
		->join( array('LF'=>'leaseFee'),'LF.feeId=F.id',array('leaseFeeBillId'=>'LF.id'))
		->join( array('L'=>'lease'),'LF.leaseId=L.id',array())
		->join( array('bill'=>'bill'),'LF.billId=bill.id',array('billId'=>'id', 'originalAmountDue'=>'originalAmountDue', 'dueDate'=>'dueDate'))
		->where('L.id=?',$leaseId,'int')
		->where('bill.isPaid=0')
		->where('bill.dueDate<=DATE_ADD(NOW(), INTERVAL 1 MONTH)')
		->order( 'bill.dueDate ASC' );					
					
		$resultSet = $db->query($select);						
		$container = null;		
		   		    
		foreach ($resultSet as $row) {
		    $billObj = new Financial_Model_Bill();
		    $billItem = $billObj->findById( $row['billId'] );		   
		    $row['currentAmountDue'] = $billItem->getCurrentAmountDue();
		    
		    if($row['currentAmountDue']>0){
		        $container[$row['billId']] = $row;
		    }	
		}				
		return $container;			
	}
	
	/**
	 *  Fetch lease rent schedule to pay
	 *  Used in the page to manually pay lease rent bills
	 *  Displays lease rent bills that are due up to one month out from today's date
	 */	
	public function fetchLeaseRentToPay( $leaseId ){
		$fee = new Financial_Model_Fee();
		$db = $fee->getDbTable()->getAdapter();
		
		$select = $db->select()
		->from( array('LS'=>'leaseSchedule'),array('leaseScheduleId'=>'id', 'month'=>'month' ))		
		->join( array('L'=>'lease'),'LS.leaseId=L.id',array())
		->join( array('bill'=>'bill'),'LS.billId=bill.id',array('billId'=>'id', 'originalAmountDue'=>'originalAmountDue', 'dueDate'=>'dueDate'))
		->where('L.id=?',$leaseId,'int')
		->where('bill.isPaid=0')
		->where('bill.dueDate<=DATE_ADD(NOW(), INTERVAL 1 MONTH)')
		->order( 'bill.dueDate ASC' );					
					
		$resultSet = $db->query($select);						
		$container = null;		
	
	        if( $resultSet ) {
		    // set debitAccountId
		    $alObj = new Financial_Model_AccountLink();
		    $alItem = array_shift($alObj->findByKey( array( 'search'=>array( 'name'=>'rentRevenue' ) ) ));		    		   
		    
		    if( empty( $alItem ) ){
			$this->setMessageState( 'noAccountLinkSet' );
			throw new Exception( 'Missing Account Link in rent payments' );
		    }
		    
		    $debitAccountId = $alItem->getDebitAccountId();  
		    if( empty( $debitAccountId ) ){
			$this->setMessageState( 'noAccountLinkSet' );
			throw new Exception( 'Missing Debit Id' );
		    }
		    		    
		    foreach ($resultSet as $row) {
		        $billObj = new Financial_Model_Bill();
		        $billItem = $billObj->findById( $row['billId'] );		   
		        $row['currentAmountDue'] = $billItem->getCurrentAmountDue();
			$row['debitAccountId'] = $debitAccountId;
		    
		        if($row['currentAmountDue']>0){
		            $container[$row['billId']] = $row;
		        }	
		    }
		}		
		return $container;			
	}
	
	/**
	 *    Return the cash account to post the payments to for applicant fees.  This is contained in the financialAccountSetting
	 *    table under the settingName = 'leaseRentCashAccount'
	 *    Modifying to public so it can be used in ManualBillHelper
	 */
	private function getDebitAccountId(){
		$fasObj = new Financial_Model_FinancialAccountSetting();
		$param = array( 'returnClassObject'=>true, 'search'=> array( 'settingName'=>'leaseRentCashAccount' ));
		$fasItem = $fasObj->findByKey( $param );
		
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
	 *    table under the settingName = 'leaseFeeCashAccount'
	 *    Modifying to public so it can be used in ManualBillHelper
	 */
	private function getLeaseFeeDebitAccountId(){
		$fasObj = new Financial_Model_FinancialAccountSetting();
		$param = array( 'returnClassObject'=>true, 'search'=> array( 'settingName'=>'leaseFeeCashAccount' ));
		$fasItem = $fasObj->findByKey( $param );
		
		if( empty($fasItem) ) {
			return false;
		} else {
			$item = array_shift( $fasItem );
			$accountId = $item->getAccountId();
			return ($accountId)?$accountId:false;
		}
	}
}