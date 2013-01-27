<?php
/**
 * @package application.modules
 * @subpackage logs.modesl
 * @author jvazquez
 *	<p>
 *	This object is a representation of the logfiles in the directory logs.
 *	We extend the FilterIterator from the SPL and filter objects that start with dot or that finish with bz2
 * </p>
 */
class Logs_Model_Files {

	/**
	 * The name of the file that you are using
	 * @var string
	 */
	protected $name;

	/**
	 * All the files in the directory of logs.
	 * @var array
	 */
	protected $logs;

	/**
	 * Retrieve all the logfiles
	 * @return array
	 */
	public function fetchAll() {
		return new Logs_Model_FilesIterator();
	}

	/**
	 * Open the file indicated by filename and return the contents in a string.
	 * @param string $filename
	 * @return string
	 */
	public function fetchByFilename($filename) {

		$file = new  SplFileInfo($filename);
		if ( !$file->isReadable() )
		throw new Exception("The file is not readable");

		$filecontent = nl2br(file_get_contents($filename));
		return $filecontent;
	}
}