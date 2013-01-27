<?php
/**
 * @author Jorge Omar Vazquez
 * @author Rachael Nelson
 * TODO Add the name of the setting your paying with ZFForm_ParentForm::addLabel
 */
class Applicant_Form_Payment extends ZFForm_ParentForm {

	protected $displayGroupArray;

	/**
	 * The endpoint for authorize
	 * @var string $authorizeUrl
	 */
	protected $authorizeUrl;

	/**
	 * The log in credentials for authorize
	 * @var string $login
	 */
	protected $login;

	/**
	 * The total payment for the application fee
	 * @var float $amount
	 */
	protected $amount;

	/**
	 * The description that is sent into the pay form
	 * @var string $description
	 */
	protected $description;

	/**
	 * The invoice field
	 * @var date $invoice
	 */
	protected $invoice;

	/**
	 * A random number
	 * @var int $sequence
	 */
	protected $sequence;

	/**
	 * @var int $timestamp
	 */
	protected $timestamp;

	/**
	 * A hash that the form requires
	 * @var double hash
	 */
	protected $fphash;

	/**
	 * Transaction key from authorize
	 * @var string $transactionKey
	 */
	protected $transactionKey;

	/**
	 * Should the transaction return 0 or a valid result ?
	 * @var boolean $testMode
	 * @internal Refer to SIM guide, page numbered 77. Short version, we want this in false
	 */
	protected $testMode;

	/**
	 * @var string $showForm
	 * @internal The show form field indicates that the merchant would like to use the payment gateway hosted payment form to collect payment data.
	 */
	protected $showForm;

	/**
	 * Which kind of transaction should we use CC|ECHECK
	 * @var string $xMethod
	 * @internal For application fee payment , we always use CC. If not defined, authorize will fallback to CC
	 */
	protected $xMethod;

	/**
	 * @internal Receipt Method . This setting specifies the kind of link that is made back to the merchant’s website. Page numbered 37 of the SIM pdf
	 * @var string $receiptLinkMethod
	 */
	protected $receiptLinkMethod;

	/**
	 * The message that we will show to the user at authorize side
	 * @var string $receiptLinkText
	 */
	protected $receiptLinkText;

	/**
	 * Where should the user go back after clicking on the custom button we create for him.
	 * @internal This affects the integration and each application we install , will have a custom value
	 * @var string $receiptLinkUrl
	 */
	protected $receiptLinkUrl;

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init() {
		$this->displayGroupArray = array();
		$settings = new Settings_Model_Settings();
		//	Populate settings
		$this->authorizeUrl = array_shift($settings->findByKey(array('search'=>array('name'=>'authorize_url'))))->getValue();
		$this->login = array_shift($settings->findByKey(array('search'=>array('name'=>'x_login'))))->getValue();
		//	Fetch the amount that we are going to pay
		$appSetting = new Applicant_Model_FeeSetting();
		$fees = $appSetting->retrieveEnabledFees();
		$this->amount = $this->setAmount($fees);
		$this->addPaymentDescription();
		$this->initLabels($fees);
		$this->addTotalDescription();
		
		$this->description=array_shift($settings->findByKey(array('search'=>array('name'=>'x_description'))))->getValue();
		$this->invoice = date('YmdHis');
		$this->sequence = rand(1,1000);
		$this->timestamp = time();
		$this->transactionKey = array_shift($settings->findByKey(array('search'=>array('name'=>'transaction_key'))))->getValue();
		//@internal this is specific >=php 5.12
		$this->fphash = hash_hmac("md5", $this->login . "^" . $this->sequence . "^" . $this->timestamp . "^" . $this->amount . "^", $this->transactionKey);
		$this->testMode = 0;
		$this->showForm = array_shift($settings->findByKey(array('search'=>array('name'=>'x_show_form'))))->getValue();
		$this->xMethod = array_shift($settings->findByKey(array('search'=>array('name'=>'cc_payment'))))->getValue();
		$this->receiptLinkMethod = array_shift($settings->findByKey(array('search'=>array('name'=>'x_receipt_link_method'))))->getValue();
		$this->receiptLinkText = array_shift($settings->findByKey(array('search'=>array('name'=>'x_receipt_link_text'))))->getValue();
		$this->receiptLinkUrl = array_shift($settings->findByKey(array('search'=>array('name'=>'x_receipt_link_url'))))->getValue();
	}

	/**
	 * Set the amount for the settings.
	 * Set the labels of the elements that you create.
	 */
	private function setAmount(array $fees=null) {
		$total = 0;
		if( !empty($fees) ) {
			foreach($fees as $id=>$elements) {
				$total +=$elements['amount'];
			}
		}
		return $total;
	}

	/**
	 * Add a label detailing what you are going to pay
	 * @param array $fees
	 */
	private function initLabels(array $fees=null){
		if( !empty($fees) ){
			foreach( $fees as $id=>$element ) {
				$name = str_replace(' ','', $element['name']).$id;
				$label = new ZFForm_CustomLabel($name);
				$label->setContent($element['name']." $".$element['amount']);
				$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
				$this->addElement($label);
			}
		}
	}

	/**
	 * Add a description of what the user is paying
	 */
	private function addPaymentDescription(){
		$label = new ZFForm_CustomLabel('descriptionPayment');
		$label->setContent('paymentDetails');
		$this->addElement($label);
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
	}
	
	private function addTotalDescription(){
		$label = new ZFForm_CustomLabel('descriptionTotal');
		$label->setContent('Total '.$this->amount);
		$this->addElement($label);
		$this->addPrefixPath('ZFForm_CustomLabel', 'ZFForm', Zend_Form::ELEMENT);
	}
	
	/**
	 * Set the form and the elements that compones it
	 */
	public function setForm() {
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->setAction($this->authorizeUrl);
		$this->setFormTranslator();
		$this->addXLogin();
		$this->addXAmount();
		$this->addXDescription();
		$this->addXInvoiceNum();
		$this->addXFpSequence();
		$this->addXFpTimestamp();
		$this->addXFpHash();
		$this->addXTestRequest();
		$this->addXShowForm();
		$this->addXMethod();
		$this->addXReceiptLinkMethod();
		$this->addXReceiptLinkText();
		$this->addXReceiptLinkUrl();
		$this->addXCustId();
		$this->addXCustomerEmail();
		$this->addSubmitButton();
	}

	/**
	 *  Add the username for authorize.
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXLogin() {
		$elementName = 'x_login';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->login);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the amount of the transaction that is the sum of application fee, administrative fee and app deposit
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXAmount() {
		$elementName = 'x_amount';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->amount);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the description in the form
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXDescription() {
		$elementName = 'x_description';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->description);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the invoice
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXInvoiceNum() {
		$elementName = 'x_invoice_num';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->invoice);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the invoice
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXFpSequence() {
		$elementName = 'x_fp_sequence';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->sequence);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the timestamp
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXFpTimestamp() {
		$elementName = 'x_fp_timestamp';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->timestamp);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the timestamp
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXFpHash() {
		$elementName = 'x_fp_hash';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->fphash);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the Test Request setting
	 *  We set the element to readonly , because we do not want to do edit this
	 *  @internal This one is tricky, by default we set it to false, if it bothers during live integration, remove the call.
	 */
	private function addXTestRequest() {
		$elementName = 'x_test_request';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->testMode);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the timestamp
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXShowForm() {
		$elementName = 'x_show_form';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->showForm);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the kind of method we are going to process
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXMethod() {
		$elementName = 'x_method';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->xMethod);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the button that the user will click on authorize if we go back
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXReceiptLinkMethod() {
		$elementName = 'x_receipt_link_method';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->receiptLinkMethod);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the text on the receipt button that is defined at addXMethod
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXReceiptLinkText() {
		$elementName = 'x_receipt_link_text';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->receiptLinkText);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the url that we will use for the return url
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXReceiptLinkUrl() {
		$elementName = 'x_receipt_link_url';
		$addressOpts = array('required'=>true,'readonly' => true,'value'=>$this->receiptLinkUrl);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the hidden input for the user_id
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXCustId() {
		$elementName = 'x_cust_id';
		$addressOpts = array('required'=>true,'readonly' => true);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup( $elementName );
	}

	/**
	 *  Add the hidden input that will be completed with the user email
	 *  We set the element to readonly , because we do not want to do edit this
	 */
	private function addXCustomerEmail() {
		$elementName = 'x_email';
		$addressOpts = array('required'=>true,'readonly' => true);
		$this->addElement('hidden',$elementName,$addressOpts);
		$this->getElement($elementName)->removeDecorator('Htmltag');
		$this->getElement($elementName)->removeDecorator('Label');
		$this->addToGroup($elementName);
	}
}