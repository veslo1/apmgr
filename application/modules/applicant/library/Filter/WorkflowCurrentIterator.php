<?php
/**
 * Helper object to obtain the current in a set of work flow
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.applicant.library.helper
 */
class Applicant_Library_Filter_WorkflowCurrentIterator extends FilterIterator
{
	/**
	 * Constructor
	 * @param Iterator $iterator
	 */
	public function __construct(Iterator $iterator)
	{
		parent::__construct($iterator);
	}
	
	/* (non-PHPdoc)
	 * @see FilterIterator::accept()
	 */
	public function accept()
	{
		$buffer = $this->current();
		return $buffer['current'] == true;
	}
}