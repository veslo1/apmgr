<?php
/**
 * @author Jorge Vazquez <jvazquez@debseverp4.com.ar>
 * Object to handle files.
 */

class ZFFile_File
{
	/**
	 * @var Path to the file where it's currently located
	 */
	private $path;

	/**
	 *
	 * @var double the size of the element
	 */
	private $size;

	/**
	 * The kind of file I will be working
	 * @var string
	 */
	private $type;

	/**
	 * Name of the file
	 * @var string
	 */
	private $name;

	/**
	 * Empty constructor for File
	 */
	public function __construct()
	{
	}

	/**
	 * Works in bytes
	 * @param double $size
	 */
	public function setSize($size) {
		$this->size = $size;
		return $this;
	}

	/**
	 * @return double
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 * Return the type of the file
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Set the type of the file
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Path of this file
	 * @param string $path
	 */
	public function setPath($path) {
		$this->path =$path;
	}

	/**
	 * Get the path of this file
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Name of the file
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
}