<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @internal Authorize.net form elements start with x, so if it doesn't
 * don't scan it.
 */
class Applicant_Library_PaymentFilterIterator extends FilterIterator {
	/**
	 * @param Iterator $it
	 */
	public function __construct(Iterator $it) {
		parent::__construct($it);
	}

	/**
	 * (non-PHPdoc)
	 * @see FilterIterator::accept()
	 */
	public function accept() {
		$position = stripos($this->key(), 'x');
		return $position===0;
	}
}