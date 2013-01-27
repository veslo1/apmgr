<?php
/**
 *  Created September 6,2010
 */
class Financial_PaymentController extends ZFController_Controller {

	/**
	 *  View payment detail
	 */
	public function viewpaymentdetailAction(){
		$id = $this->getRequest()->getParam('paymentDetailId');
		if ( !empty ($id) ) {
			$model = new Financial_Model_PaymentDetail();
			$pmtData = $model->findById($id);
			if ( $pmtData!==null ) {
				$this->view->pmtDetail = $pmtData;
			}
			else
			$this->view->msg = $this->getMessage('noRecordFound');  //TODO create a error message because the record does not exists
		}
		else
		$this->view->msg = $this->getMessage('noRecordFound');  //TODO create a error message because the id is missing
	}


} // end class