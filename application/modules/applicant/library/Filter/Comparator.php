<?php
/**
 * We implement a filter iterator that allows us to compare case insenstively
 * the elements that we set
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

class Applicant_Library_Filter_Comparator extends FilterIterator{

	/**
	 * The element we compare
	 * @var string
	 */
	protected $target;

	/**
	 * Retrieve the elements and send them to the parent iterator
	 * @param Iterator $iterator
	 */
	public function __construct(Iterator $iterator){
		parent::__construct($iterator);
	}

	/**
	 * The element we compare
	 * @param mixed $target
	 */
	public function setTarget($target){
		$this->target = $target;
	}

	/**
	 * Retrieve the current target
	 * @return string
	 */
	public function getTarget(){
		return $this->target;
	}

	/* (non-PHPdoc)
	 * @see FilterIterator::accept()
	 */
	public function accept(){
		$target = strtoupper($this->getTarget());
		$parent = strtoupper($this->getInnerIterator()->current());
		return $target == $parent;
	}
}