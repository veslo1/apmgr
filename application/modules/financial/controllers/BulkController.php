<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @author Rachael Nelson (modified)
 * This page can only be viewed by business analists, please refer to the test in
 * @see /usr/local/www/apmgr/tests/application/modules/financial/controllers/Financial_BulkControllerTest.php
 */
class Financial_BulkController extends ZFController_Controller {

	public function indexAction() {
		$form = new Financial_Form_BulkRentPaymentUpload();
		$form->setForm();
		$this->view->form = $form;

		try {
			if( $this->getRequest()->isPost() and $form->isValid( $this->getRequest()->getParams() ) ) {
				$result = $form->csvfile->receive();
				if( !$result ) {
					$this->view->msg($this->getMessage('transferFail'));
				} else {
					$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
					$this->_flashMessenger->addMessage( 'csvFileUploaded' );
					$data = $form->csvfile->getFileInfo();
						
					$bulkPayment = new Financial_Model_BulkRentPayment();
					$bulkPayment->setUploadFile($data['csvfile']['tmp_name']);
						
					if( $bulkPayment->uploadRentPayments() ){
						$this->view->msg = $this->getMessage('paymentsUploaded');
					}
					else {
						if( $bulkPayment->getMessageState() )
						$this->view->msg = $this->getMessage($bulkPayment->getMessageState());
						$this->view->unprocessed = $bulkPayment->getUnprocessedArray();
						$this->view->errors = $bulkPayment->getErrors();
					}
				}
			}
		} catch(Zend_File_Transfer_Exception $e) {
			$this->view->msg = $this->getMessage('notWrittableError');
		}
	}
}