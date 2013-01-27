<?php

/**
 * Description of RoleFilterIterator
 *
 * @author jvazquez
 */
class ZFForm_SplFilter_RoleFilterIterator extends FilterIterator {

	public function  __construct($roles) {
		parent::__construct(new RecursiveArrayIterator($roles));
	}

	public function accept() {
		$roleContent = $this->getInnerIterator()->current();
	}
}
?>
