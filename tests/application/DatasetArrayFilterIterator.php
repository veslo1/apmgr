<?php
/**
 * Filter for datasets
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class DatasetArrayFilterIterator extends FilterIterator {

	/**
	 * Contains an array of datasets
	 * @param string $sets
	 */
	public function __construct($sets)
	{
		parent::__construct(new RecursiveArrayIterator($sets));
	}

	/* (non-PHPdoc)
	 * @see FilterIterator::accept()
	 */
	public function accept()
	{
		return $this->getInnerIterator()->current()===1;
	}
}