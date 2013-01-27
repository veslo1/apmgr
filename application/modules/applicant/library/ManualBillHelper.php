<?php
/**
 * Helper for paying bills manually for applicants
 */

class Applicant_Library_ManualBillHelper implements ZFInterfaces_Messageable{

	/**
	 * Retrieve fee's for the current user
	 * @param int $applicantId
	 * @param array $sortArgs
	 * @return multitype:
	 * @throws Applicant_Library_Exception
	 */
	/*
	public function getDueFees($applicantId,array $sortArgs=null) {
		$helper = new Applicant_Library_PaymentHelper();
		return $helper->getDueFees($applicantId, $sortArgs);		
	}
	*/
	
	/**
	 * Retrieve paid fee's for given user
	 * @param int $applicantId The applicant id you are retrieving
	 * @param array $sortArgs
	 * @return multitype:
	 */
	public function getPaidFees($applicantId,array $sortArgs=null) {
		$helper = new Applicant_Library_PaymentHelper();
		return $helper->getPaidFees($applicantId, $sortArgs);			
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
		return "ManualBillHelper";
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
		   		    
		foreach ($resultSet as $row) {
		    $billObj = new Financial_Model_Bill();
		    $billItem = $billObj->findById( $row['billId'] );		    
		    $row['currentAmountDue'] = $billItem->getCurrentAmountDue();
		    if($row['currentAmountDue']>0){
		        $container[$row['applicantFeeBillId']] = $row;
		    }	
		}				
		return $container;			
	}
		
	/**
	 *  Returns the sum of the bills
	 */
	public function getBillSum( $bills, $preleaseBills ){
		$sum = 0.00;		
		if( $bills ){		     	
		    foreach( $bills as $id=>$row ) {		        		        		    
		        $sum += $row['currentAmountDue'];
		    }	
		}
		
		if( $preleaseBills ){		     	
		    foreach( $preleaseBills as $id=>$row ) {		        		        		    
		        $sum += $row['currentAmountDue'];
		    }	
		}
		return $sum;
	}
	
	/**
	 *  Method for controller to pay bills
	 */
	public function payBills( $paymentInfo, $bills, $preleaseBills ) {					
		$db = Zend_Registry::get('db');
		$db->beginTransaction();
		
		try{
		    $pmtCreationObj = new Financial_Model_PaymentCreation( array( 'db'=>$db ) );
		    $pmtCreationObj->setReuseDetailId(1);
		    $result=false;		
		
		    if( $bills ){				
		        /**
		         *  1.  Place the below block into a helper class or smtg
		         *  2.  Take into account the accountLink
		        */
		        $result=false;			
		        $result = $this->createPayment( $pmtCreationObj, $bills, $paymentInfo );			
		    }		
		    
		    if( $preleaseBills ){				
		        /**
		         *  1.  Place the below block into a helper class or smtg
		         *  2.  Take into account the accountLink
		         */
		         $result=false;
		         $result = $this->createPayment( $pmtCreationObj, $preleaseBills, $paymentInfo, true );
		    }		    
		    $db->commit();
		    return $result;
		}
		catch ( Exception $e) {		        
			$db->rollback();			
			return false;
		}
	}
	
	/**
	 *  Function to pay bills
	 */
	private function createPayment($pmtCreationObj, $bills, $paymentInfo, $isPrelease=false ){		
		$pmtCreationObj->setPaymentType( $paymentInfo['paymentType'] );
                $pmtCreationObj->setTotalAmount( $paymentInfo['totalAmount'] );  
                $pmtCreationObj->setPayor( $paymentInfo['payor'] );  
		
		$accountLink = new Financial_Model_AccountLink();
		$debitAccountId=null;
		
		if( $isPrelease ){
			$debitAccountId = Applicant_Library_PaymentHelper::getPreleaseDebitAccountId();
		}
		else{
			$debitAccountId = Applicant_Library_PaymentHelper::getDebitAccountId();
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
}