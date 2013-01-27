<?php
/**
 * Filter the desired time
 *
 * @author jvazquez
 */
class ZFDate_Filters_HourFilter extends FilterIterator {

	protected $target;

	/**
	 * Constructor
	 * @param array $timeArray
	 * @return
	 */
	public function  __construct($timeArray) {
		parent::__construct(new RecursiveArrayIterator($timeArray));
	}

	public function accept() {
		$time = $this->getInnerIterator()->current();
		$time = date_parse($time);
		return $time['hour'] == $this->target;
	}

	public function setTarget($target) {
		$this->target = $target;
	}
}
?>