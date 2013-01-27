<?php
/**
 * @package application.modules
 * @subpackage logs.modesl
 * @author jvazquez
 *	<p>
 *	We extend the FilterIterator from the SPL and filter objects that start with dot or that finish with bz2
 * </p>
 */
class Logs_Model_FilesIterator extends FilterIterator {

	/**
	 * Instantiate an object of the type Directory Iterator pointing to the logs directory.
	 * @return array
	 */
	public function __construct() {
		parent::__construct(new DirectoryIterator(APPLICATION_LOGS));
	}

	/**
	 * Implementation of the FilterIterator Abstract Class.
	 * We only accept files that do not start with a dot, or do not end up with bz2
	 * @return boolean
	 */
	public function accept() {
		$filename = $this->getInnerIterator()->getBaseName();
		return preg_match('/^\./',$filename)==0 and preg_match('/bz2$/',$filename)==0;
	}

}
?>