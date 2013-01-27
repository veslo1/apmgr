<?php
/**
 * Created on Sun Sep 13 19:06:15 ART 2009 by jvazquez
 * @appname datesite
 * @package models.country
 * <p>
 * Provide a clear definition of what this class does
 * </p>
 */
include 'DbTable/Country.php';
include_once 'ZFModel/ParentModel.php';

class Country_Model_Country extends ZFModel_ParentModel {
	/**
	 *@var name
	 */
	protected $name;

	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Country_Model_DbTable_Country');
	}
	 
	/**
	 * Returns name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets name
	 */
	public function setName($name) {
		$this->name = $name;
	}
}

?>

