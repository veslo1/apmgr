<?php
/**
 * Created on Dec 3, 2009 by rnelson
 * @name apmgr
 * @package application.modules.apartment.models
 * <p>
 * The model for apartment
 * </p>
 */


class Unit_Model_Apartment extends ZFModel_ParentModel {

	/**
	 *@var name
	 */
	protected $name;

	/**
	 *@var addressOne
	 */
	protected $addressOne;

	/**
	 *@var addressTwo
	 */
	protected $addressTwo;

	/**
	 *@var City
	 */
	protected $city;

	/**
	 *@var State
	 */
	protected $state;

	/**
	 *@var Zip
	 */
	protected $zip;

	/**
	 *@var Country
	 */
	protected $country;

	/**
	 *@var phone
	 */
	protected $phone;
	 
	/**
	 * Constructor of this object
	 */
	public function __construct(array $options = null) {
		parent::__construct( $options );
		$this->setDbTable('Unit_Model_DbTable_Apartment');
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
		$this->name=$name;
	}

	/**
	 * Address One get and set
	 */
	public function setAddressOne( $addressOne ) {
		$this->addressOne = $addressOne;
	}

	public function getAddressOne() {
		return $this->addressOne;
	}

	/**
	 * Address Two get and set
	 */
	public function setAddressTwo( $addressTwo ) {
		$this->addressTwo = $addressTwo;
	}

	public function getAddressTwo() {
		return $this->addressTwo;
	}

	/**
	 * Returns city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Sets city
	 */
	public function setCity($var) {
		$this->city=$var;
	}

	/**
	 * Returns state
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * Sets state
	 */
	public function setState($var) {
		$this->state=$var;
	}

	/**
	 * Returns city
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * Sets zip
	 */
	public function setZip($var) {
		$this->zip=$var;
	}

	/**
	 * Returns country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Sets country
	 */
	public function setCountry($var) {
		$this->country=$var;
	}

	/**
	 * Returns phone
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Sets phone
	 */
	public function setPhone($var) {
		$this->phone=$var;
	}

	/**
	 *  Save apartment
	 */
	public function saveApartment(){
		$apt = $this->findById(1);
		if( $apt )
		$this->setId( $apt->getId() );

		$id = $this->save();
		$this->setId( $id );
		return $this;
	}
}
?>
