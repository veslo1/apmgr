<?php
class Applicant_Model_Payment extends ZFModel_ParentModel implements ZFObserver_ILogeable {
	/**
	 * The log that we keep with all the form info
	 * @var ZFObserver_Forensic
	 */
	protected $logger;

	public function __construct(array $options=null) {
		$this->logger = new ZFObserver_Forensic();
		$this->logger->attach(new ZFObserver_Observers_Text());
		$level = !isset($options['level']) ? ZFObserver_ILogeable :: DEBUG:$options['level'];
		$this->logger->setStatus($level);
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFModel/ZFModel_ParentModel::save()
	 * @param Zend_Form $form
	 * @return boolean
	 * @internal We evaluate each form element to confirm that each value is set.
	 * Missing form value means that application should halt here
	 */
	public function save(Zend_Form $form) {
		$paymentFilterIterator = new Applicant_Library_PaymentFilterIterator(new ArrayIterator($form->getElements()));
		foreach( $paymentFilterIterator as $id=>$formObject ) {
			$value = $formObject->getValue();
			if( !isset($value) ) {
				throw new Exception("{$formObject->getName()} does not have a default value");
			}
			$this->logger->notify($this, "{$formObject->getName()}::{$formObject->getValue()}");
		}
		return true;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFModel/ZFModel_ParentModel::__toString()
	 */
	public function __toString() {
		return "Payment_Model_Applicant_Fee";
	}
}