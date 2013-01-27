<?php
/**
 *  Created September 30,2010
 *  Covers refunds and forfeits
 */
class Financial_RefundforfeitController extends ZFController_Controller {

	/**
	 * refund
	 *
	 * needs a feeId and billId
	 */
	public function refundAction() {
                $billId = $this->getRequest()->getParam('billId'); 
		$feeId = $this->getRequest()->getParam('feeId');
		
		if( empty($billId) || empty($feeId) ) {
		  	$this->view->msg = $this->getMessage('missingBillFeeIds');			
		}
		else {
		    $maxAmount = Financial_Library_RefundHelper::fetchMaxAmount( $billId );	
			
		    $form = new Financial_Form_Refund();
		    $form->setLegend( 'refund' );		    
		    $form->setForm();
		    $form->populate( array('maxAmount'=>$maxAmount) );
		    $this->view->form = $form;
		
		    if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$refund = new Financial_Model_Refund($form->getValues());
			
			$refund->setBillId( $billId );
	                $refund->setFeeId( $feeId );
                        $refund->setAmount( $form->getValue('amount') );
			$refund->setComment( $form->getValue('comment') );   
									
			if ($refund->refund() ) {
				$this->setFlashMessage('refundCreatedSuccessfully');
				$this->_helper->redirector('viewbill', 'bill', 'financial', array('billId'=>$billId));
			} else {
				$this->view->msg = $this->getMessage($refund->getMessageState());
			}
		    }
		}
	}
	
	/**
	 * refund
	 *
	 * needs a feeId and billId
	 */
	public function forfeitAction() {
                $billId = $this->getRequest()->getParam('billId'); 
		$feeId = $this->getRequest()->getParam('feeId');
		
		if( empty($billId) || empty($feeId) ) {
		  	$this->view->msg = $this->getMessage('missingBillFeeIds');			
		}
		else {
		    $maxAmount = Financial_Library_RefundHelper::fetchMaxAmount( $billId );	
			
		    $form = new Financial_Form_Refund();
		    $form->setLegend( 'forfeit' );		    
		    $form->setForm();
		    $form->populate( array('maxAmount'=>$maxAmount) );
		    $this->view->form = $form;
		
		    if ( $this->getRequest()->isPost() and $form->isValid($this->getRequest()->getParams()) ) {
			$refund = new Financial_Model_ForfeitedFee($form->getValues());
			
			$refund->setBillId( $billId );
	                $refund->setFeeId( $feeId );
                        $refund->setAmount( $form->getValue('amount') );
			$refund->setComment( $form->getValue('comment') );   
									
			if ($refund->forfeit() ) {
				$this->setFlashMessage('forfeitCreatedSuccessfully');
				$this->_helper->redirector('viewbill', 'bill', 'financial', array('billId'=>$billId));
			} else {
				$this->view->msg = $this->getMessage($refund->getMessageState());
			}
		    }
		}
	}	
} // end class