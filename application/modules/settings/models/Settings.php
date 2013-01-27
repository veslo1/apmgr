<?php
/**
 * Settings model
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Settings_Model_Settings extends ZFModel_ParentModel {

	/**
	 * @var string $name
	 */
	protected $name;

	/**
	 * @var mixed $value
	 */
	protected $value;

	/**
	 * @var string
	 */
	protected $description;

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Settings_Model_DbTable_Settings');
	}

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

	/**
	 * Set value
	 */
	public function setValue($value) {
		$this->value=$value;
		return $this;
	}

	/**
	 * Get value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Set the description for the setting
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description =$description;
		return $this;
	}

	/**
	 * Get the description of the setting
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
}
