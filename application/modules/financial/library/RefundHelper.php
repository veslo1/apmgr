<?php
/**
 *  Class created 9/10/10 to handle refund and forfeit creation
 */
class Financial_Library_RefundHelper extends ZFModel_ParentModel {

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
	 
} // end class
