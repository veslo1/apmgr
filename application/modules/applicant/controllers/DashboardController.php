<?php
/**
 * Display the dashboard page for the applicant that will display different options
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_DashboardController extends ZFController_Controller implements ZFObserver_ILogeable {
	/**
	 * The log that we keep with all the form info
	 * @var ZFObserver_Forensic
	 */
	protected $logger;

	/**
	 * Determine if the user hass fee's
	 */
	public function indexAction() {
	}

	/**
	 * View your applications
	 */
	public function applicationAction(){
		$records = array();
		//	Retrieve sort parameters
		$column = $this->getRequest()->getParam('column');
		$sort = $this->getRequest()->getParam('sort');
		$sortArgs = array('sort'=>$sort,'column'=>$column);

		//	For the current user , retrieve all his applications
		$dashboardHelper = new Applicant_Library_DashboardHelper();
		$records = $dashboardHelper->retrieveCompletedApplications(Zend_Auth::getInstance(),$sortArgs);

		$this->view->applications = $this->paginate($records);

		$this->view->msg = $dashboardHelper->getMessageState();
		//	Set up the view
		$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
	}

	/**
	 * View all the pending fee's that we have to pay.
	 * If there isn't any, we just show a message
	 * Determine if he has any due fees by
	 * 1 - Determine if the applicant exists
	 * 2 - If he doesn't , use the current user id and look him up in applicant
	 * 2 - He accepted the contract
	 * 3 - Then look him on applicantFeeBill, if we find then it's false,else he has to pay after passing all this conditions
	 */
	public function viewfeesdueAction() {
		$applicantId = $this->getRequest()->getParam('id');
		$column = $this->getRequest()->getParam('column');
		$sort = $this->getRequest()->getParam('sort');
		$applicant = new Applicant_Model_Applicant();
		$exists = $applicant->exists(array('table'=>'applicant','column'=>'id'),$applicantId);
		$this->view->paidEnabled = false;
		if($exists==true) {
			$paymentHelper = new Applicant_Library_PaymentHelper();
			$sortArgs = array('column'=>$column,'sort'=>$sort);
			$this->view->paidEnabled = true;
			$fees = $paymentHelper->getDueFees($applicantId, $sortArgs);
			$this->view->fees = $this->paginate($fees);
			$this->view->haveFees = $fees;
			$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
		} else {
			$this->view->msg = $this->getMessage("noDueFees");
		}
	}

	/**
	 *View the fee's that the user paid
	 */
	public function viewfeespaidAction() {
		$applicantId = $this->getRequest()->getParam('id');
		$column = $this->getRequest()->getParam('column');
		$sort = $this->getRequest()->getParam('sort');
		$applicant = new Applicant_Model_Applicant();
		$exists = $applicant->exists(array('table'=>'applicant','column'=>'id'),$applicantId);
		if( $exists==true ) {
			$paymentHelper = new Applicant_Library_PaymentHelper();
			$sortArgs = array('column'=>$column,'sort'=>$sort);
			$this->view->fees = $this->paginate($paymentHelper->getPaidFees($applicantId,$sortArgs));
			$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
		} else {
			$this->view->msg = $this->getMessage("noDueFees");
		}
	}

	/**
	 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
	 * @internal Display a form so the user can pay his fee's
	 */
	public function paymentAction() {
		$this->logger = new ZFObserver_Forensic();
		$this->logger->attach( new ZFObserver_Observers_Db() );
		$this->logger->attach( new ZFObserver_Observers_Text() );
		$this->logger->setStatus( ZFObserver_ILogeable :: DEBUG );
		$this->logger->notify($this,'Entering '.__FUNCTION__);
		$paymentHelper = new Applicant_Library_PaymentHelper();
		$args = $this->getRequest()->getParams();
		$applicantId = $this->getRequest()->getParam('id');
		$validInformation = $paymentHelper->validatePayAction($args);
		if ( true==$validInformation )
		{
			$applicantId = $this->getRequest()->getParam('id');
			$form = new Applicant_Form_Payment();
			$form->setForm();
			//	We populate the customer id and we retrieve his email from the database
			$form->getElement('x_cust_id')->setValue($applicantId);
			$applicant = new Applicant_Model_Applicant();
			$applicant = $applicant->findById($applicantId);
			$user = new User_Model_User();
			$user = $user->findById($applicant->getUserId());
			$form->getElement('x_email')->setValue($user->getEmailAddress());
			try {
				$payment = new Applicant_Model_Payment();
				$payment->save($form);
			} catch(Exception $e){
				//TODO MAil us with the error
				$this->logger->notify($this,"Exception caught while trying to pass a payment.".$e->getMessage());
			}
			$this->view->form = $form;
		}
		else
		{
			$this->setFlashMessage($paymentHelper->getMessageState());
			$this->logger->notify($this, "Payment does not seems enabled, calling the Flash Messenger and adding ".$paymentHelper->getMessageState());
			$this->logger->notify($this, "Application will redirect to applicant/dashboard/index");
			$this->_helper->redirector('index', 'dashboard', 'applicant');
//			$this->_redirect('applicant/dashboard/index');
		}
	}

	/**
	 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
	 * @internal After retrieving a post from the authorize.net reseller we have to perform a validation
	 * <ul>
	 * 	<li>Payment is enabled</li>
	 *  <li>The fee's are match the amount we receive</li>
	 * </ul>
	 * If any of this conditions is broken , we have to email the fee people and let them now
	 * that the system detected an incongruence.
	 * If the operation works okay , then we process the payment in the financial system.
	 * @internal Basically with this , we manage to encapsulate two if's, though the second line,
	 * the corroboration of fee, throw's exceptions, due to what the documentations
	 * mentions. The code could be try / catched, but still, the logic is pretty straight forward.
	 * Payment enabled, validate integrity, process bill, process payment.
	 * Under any error , notify the accounting people and let the user know that his payment was processed

	 */
	public function paymentconfirmationAction() {
		$this->logger = new ZFObserver_Forensic();
		$this->logger->attach( new ZFObserver_Observers_Db() );
		$this->logger->attach( new ZFObserver_Observers_Text() );
		$this->logger->setStatus( ZFObserver_ILogeable :: NOTICE );
		$this->logger->notify($this,'The paymentconfirmationAction is called');

		if( $this->getRequest()->isPost() ) {
			$paymentHelper = new Applicant_Library_PaymentHelper();
			$amount = $this->getRequest()->getParam('x_amount');
			$this->logger->notify($this,"Amount:{$amount}");
			$payorName = $this->getRequest()->getParam('x_first_name').' '.$this->getRequest()->getParam('x_last_name');
			$this->logger->notify($this,"Payor Name:{$payorName}");
			$activeFees = $paymentHelper->validateFeeIntegrity();
			//	Determine if payment is enabled
			$paymentEnabled = $paymentHelper->isPaymentEnabled();
			//	Corroborate fee integrity by retrieving the active fee's and acumulating them
			$currentFees = $paymentHelper->accumulateFeeSum($activeFees);
			$applicantId = $this->getRequest()->getParam('x_cust_id');
			$this->logger->notify($this,"The applicantId is set to {$applicantId}");
			$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
			$this->_flashMessenger->addMessage('paymentCreated');
			/**
			 * 	After performing that, we need to know that
			 * 1- Payment is enabled
			 * 2- We have an equal relation between what they are telling us they paid and what the system says, this are the total fee's sum
			 */
			if ( $paymentEnabled==true and (float)$currentFees==(float) $amount ) {
				$this->logger->notify($this,"Payment is enabled");
				try {
					$args = array('applicantId'=>$applicantId,'fees'=>$activeFees);
					$result = $paymentHelper->initBilling($args);
					if( count($result)>0 ) {
						$paymentArgs = $paymentHelper->getPayLoadBills();
						$paymentArgs['payorName'] = $payorName;
						$result = $paymentHelper->createPayment($paymentArgs);
						if($result!=false) {
							$this->logger->notify($this,"Payment created properly");
						} else {
							//	TODO notify accounting and provide the bills
							$this->logger->notify($this,"Unable to create the payment");
						}
					} else {
						//TODO We still now that we couldn't even push the bill so notify accounting but don't let the user panic
						$this->logger->notify($this,"Unable to create the initial billing");
					}
				} catch ( Exception $e ) {
					//TODO Still , notify the person in accounting, but don't make the user panic
					$this->logger->notify($this,"Exception detected:::{$e->getMessage()}");
				}
			} else {
				if( $currentFees!=$amount ) {
					$this->logger->notify($this,"There is a difference between the current system fee {$currentFees} and the amount paid by the user {$amount}");
				} else {
					$this->logger->notify($this,"Payment is disabled{$amount}");
				}
			}
			//	We redirect with a "yes, you paid" inside this block , don't alert the user that something was changed or he may panick
			$this->logger->notify($this,"Leaving to the index after processing a payment");
			$this->_redirect('applicant/dashboard/index');
		} else {
			$this->logger->notify($this,"Payment system received a hit that wasn't a post");
			$this->view->msg = $this->getMessage('paymentDissabled');
		}
	}

	/**
	 * Displays all the wait list applications this user has
	 */
	public function waitlistAction() {
		$id = $this->getRequest()->getParam('id');
		$column = $this->getRequest()->getParam('column');
		$sort = $this->getRequest()->getParam('sort');
		$sortArgs = array('sort'=>$sort,'column'=>$column);
		$waitList = new Applicant_Library_DashboardHelper();
		$this->view->sort = ( $sort=='ASC') ? 'DESC' : 'ASC';
		$this->view->waitlist = $this->paginate($waitList->retrieveWaitListData(Zend_Auth::getInstance(),$sortArgs));
	}

	public function __toString()
	{
		return "Dashboard";
	}
}
?>
