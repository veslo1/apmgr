<?php
/**
 *
 * @author Complete with your name <andyouremail@debserverp4.com.ar>
 */
class Applicant_Model_ApplicantStatus extends ZFModel_ParentModel {
	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Applicant_Model_DbTable_ApplicantStatus');
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
	 * @var NO $name
	 */
	protected $name;
	 
	/**
	 * Set name
	 */
	public function setName($name) {
		$this->name=$name;
		return $this;
	}
	/**
	 * Get name
	 */
	public function getName() {
		return $this->name;
	}
}
