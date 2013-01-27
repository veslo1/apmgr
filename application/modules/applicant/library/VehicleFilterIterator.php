<?php
/**
 * Filter iterator for Occupant post
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Library_VehicleFilterIterator extends FilterIterator {

	public function __construct(Iterator $it) {
		parent::__construct($it);
	}

	public function accept() {
		return stristr($this->key(),'vehicle')!==false;
	}
}