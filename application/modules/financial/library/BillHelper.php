<?php
/**
 *  Class created 9/10/10 to handle refund and forfeit creation
 */
class Financial_Library_BillHelper extends ZFModel_ParentModel {

	/**
	 *  Fetches the maximum refund amount
	 *  Payments made - refunds made = max refund amount
	 */
	public function fetchMaxAmount($billId){
	    $pmtObj = new Financial_Model_Payment();
	    $refundObj = new Financial_Model_Refund();
	    $forfeitObj = new Financial_Model_ForfeitedFee();
	    $transferObj = new Financial_Model_BillTransfer();	

	    $pmtObj->setBillId( $billId );
	    $refundObj->setBillId( $billId );
	    $forfeitObj->setBillId( $billId );
	    $transferObj->setFromBillId( $billId );

	    $pmtSum = $pmtObj->getPaymentSumByBillId();
	    $refundSum = $refundObj->getRefundSumByBillId();
	    $forfeitSum = $forfeitObj->getForfeitSumByBillId();
	    $transferSum = $transferObj->getTransferSumByFromBillId();

	    $amount = $pmtSum - $refundSum - $forfeitSum - $transferSum;
	    if( $amount<0 ){
	        return 0;
	    }
	    else{
		return $amount;
	    }
	}
	
	/**
	 *  Looks at the bill tables to verify the current user can view only his bills
	 */
	public function verifyBillId( $billId ) {
	    $db = $this->getDbTable()->getAdapter();
	    
	    if( !$leaseId ){
		$this->setMessageState('missingLeaseId');
		return false;
	    }		
		
	    $lease = new Unit_Model_Lease();
	    $db = $lease->getDbTable()->getAdapter();
	    
	    $billIdQuoted = $db->quote( $billId );	    
	    
	    $userId = User_Library_Helper_Utils::currentUserId();	
	    
	    //  Thank god that the children weren't onboard to see it
	    $query = "SELECT LF.billId
	              FROM leaseFee AS LF
		      JOIN lease AS L ON L.id = LF.leaseId
		      JOIN tenant AS T ON T.leaseId = L.id
		      WHERE T.userId = {$userId}
		      AND LF.billId = {$billIdQuoted}
		      UNION
		      SELECT LS.billId
	              FROM leaseSchedule AS LS
		      JOIN lease AS L ON L.id = LS.leaseId
		      JOIN tenant AS T ON T.leaseId = L.id
		      WHERE T.userId = {$userId}
		      AND LS.billId = {$billIdQuoted}";
		      
            $resultSet = $db->query( $query );
			
	    $container = array();

	    foreach ($resultSet as $row){
		$container[$row['id']] = $row['id'];
	    }	    
	    return $container;	   	
	 
	}
} // end class
