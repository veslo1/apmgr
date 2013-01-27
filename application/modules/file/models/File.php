<?php
/**
 * Model definition for File
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @author Rachael Laney <wtcfg1@gmail.com>
 * @package application.file.models
 */
class File_Model_File extends ZFModel_ParentModel {

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('File_Model_DbTable_File');
	}
	
	/**
	 * @var NO $id
	 */
	protected $id;

	/**
	 * Set id
	 */
	public function setId($id) {
		$this->id=$id;
		return $this;
	}
	/**
	 * Get id
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * @var NO $path
	 */
	protected $path;

	/**
	 * Set path
	 */
	public function setPath($path) {
		$this->path=$path;
		return $this;
	}
	/**
	 * Get path
	 */
	public function getPath() {
		return $this->path;
	}
	/**
	 * @var NO $size
	 */
	protected $size;

	/**
	 * Set size
	 */
	public function setSize($size) {
		$this->size=$size;
		return $this;
	}
	/**
	 * Get size
	 */
	public function getSize() {
		return $this->size;
	}
	/**
	 * @var YES $description
	 */
	protected $description;

	/**
	 * Set description
	 */
	public function setDescription($description) {
		$this->description=$description;
		return $this;
	}
	/**
	 * Get description
	 */
	public function getDescription() {
		return $this->description;
	}
	/**
	 * @var NO $deleted
	 */
	protected $deleted;

	/**
	 * Set deleted
	 */
	public function setDeleted($deleted) {
		$this->deleted=$deleted;
		return $this;
	}
	/**
	 * Get deleted
	 */
	public function getDeleted() {
		return $this->deleted;
	}
	/**
	 * @var NO $dateCreated
	 */
	protected $dateCreated;

	/**
	 * Set dateCreated
	 */
	public function setDateCreated($dateCreated) {
		$this->dateCreated=$dateCreated;
		return $this;
	}
	/**
	 * Get dateCreated
	 */
	public function getDateCreated() {
		return $this->dateCreated;
	}
	/**
	 * @var YES $dateUpdated
	 */
	protected $dateUpdated;

	/**
	 * Set dateUpdated
	 */
	public function setDateUpdated($dateUpdated) {
		$this->dateUpdated=$dateUpdated;
		return $this;
	}
	/**
	 * Get dateUpdated
	 */
	public function getDateUpdated() {
		return $this->dateUpdated;
	}

	/**
	 * @var NO mimeType
	 */
	protected $mimeType;

	/**
	 * Set mimeType
	 */
	public function setMimeType($var) {
		$this->mimeType=$var;
		return $this;
	}
	/**
	 * Get mimeType
	 */
	public function getMimeType() {
		return $this->mimeType;
	}

	/**
	 * Set fileName
	 */
	public function setFileName($var) {
		$this->fileName=$var;
		return $this;
	}
	/**
	 * Get fileName
	 */
	public function getFileName() {
		return $this->fileName;
	}

	/**
	 *  Returns contents of the file
	 */
	/*public function getContents() {
	 return file_get_contents( $this->getPath().DIRECTORY_SEPARATOR.$this->getFileName() );
	 }
	 */
	/**
	 * Get fullPath
	 * */
	public function getFullPath() {
		return $this->getPath() . '/'.$this->getFileName();
	}

}
