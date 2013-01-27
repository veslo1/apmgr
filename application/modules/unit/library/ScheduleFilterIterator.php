<?php
/**
 * Filter iterator for Rent Schedule post
 */
class Unit_Library_ScheduleFilterIterator extends FilterIterator {

	public function __construct(Iterator $it) {
		parent::__construct($it);
	}

	public function accept() {
		return stristr($this->key(),'schedule')!==false;
	}
}