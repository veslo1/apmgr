<?php
/**
 *
 * @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
 */
class Prospects_Model_Prospects extends ZFModel_ParentModel
{
	/**
	 * @var string $firstName
	 */
	protected $firstName;

	/**
	 * @var string $lastName
	 */
	protected $lastName;

	/**
	 * @var string $email
	 */
	protected $email;

	/**
	 * @var string $phone
	 */
	protected $phone;
	
	/**
	 * @var int $contactMode
	 */
	protected $contactMode;

	/**
	 * @var int $howDidYouHear
	 */
	protected $howDidYouHear;

	/**
	 * @var double $rentRangeFrom
	 */
	protected $rentRangeFrom;

	/**
	 * @var double $rentRangeTo
	 */
	protected $rentRangeTo;

	/**
	 * @var date $possibleMoveInDate
	 */
	protected $possibleMoveInDate;

	/**
	 * @var int $pets
	 */
	protected $pets;

	/**
	 * @var int $occupants
	 */
	protected $occupants;

	/**
	 * @var string $notes
	 */
	protected $notes;

	/**
	 * @var int $status
	 */
	protected $status;

	public function __construct(array $options=null)
	{
		parent::__construct($options);
		$this->setDbTable('Prospects_Model_DbTable_Prospects');
	}

	/**
	 * Set firstName
	 * @param string $firstname
	 */
	public function setFirstName($firstName)
	{
		$this->firstName=$firstName;
		return $this;
	}

	/**
	 * Get firstName
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * Set lastName
	 * @param string $lastName
	 */
	public function setLastName($lastName)
	{
		$this->lastName=$lastName;
		return $this;
	}

	/**
	 * Get lastName
	 * @return string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * Set email
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email=$email;
		return $this;
	}

	/**
	 * Get email
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * 
	 * Set the phone number
	 * @param string $phone
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;
	}
	
	/**
	 * 
	 * Retrieve the phone number
	 * @return string
	 */
	public function getPhone()
	{
		return $this->phone;	
	}
	
	/**
	 * Set contactMode
	 * @param int $contactMode
	 */
	public function setContactMode($contactMode)
	{
		$this->contactMode=$contactMode;
		return $this;
	}

	/**
	 * Get contactMode
	 * @return int
	 */
	public function getContactMode()
	{
		return $this->contactMode;
	}

	/**
	 * Set howDidYouHear
	 * @param int $howDidYouHear
	 */
	public function setHowDidYouHear($howDidYouHear)
	{
		$this->howDidYouHear=$howDidYouHear;
		return $this;
	}

	/**
	 * Get howDidYouHear
	 * @return int
	 */
	public function getHowDidYouHear()
	{
		return $this->howDidYouHear;
	}

	/**
	 * Set rentRangeFrom
	 */
	public function setRentRangeFrom($rentRangeFrom)
	{
		$this->rentRangeFrom=$rentRangeFrom;
		return $this;
	}

	/**
	 * Get rentRangeFrom
	 * @return double
	 */
	public function getRentRangeFrom()
	{
		return $this->rentRangeFrom;
	}

	/**
	 * Set rentRangeTo
	 */
	public function setRentRangeTo($rentRangeTo)
	{
		$this->rentRangeTo=$rentRangeTo;
		return $this;
	}
	
	/**
	 * Get rentRangeTo
	 * @return double
	 */
	public function getRentRangeTo()
	{
		return $this->rentRangeTo;
	}

	/**
	 * Set possibleMoveInDate
	 */
	public function setPossibleMoveInDate($possibleMoveInDate)
	{
		$this->possibleMoveInDate=$possibleMoveInDate;
		return $this;
	}

	/**
	 * Get possibleMoveInDate
	 */
	public function getPossibleMoveInDate()
	{
		return $this->possibleMoveInDate;
	}

	/**
	 * Set pets
	 * @param int $pets
	 */
	public function setPets($pets)
	{
		$this->pets=$pets;
		return $this;
	}

	/**
	 * Get pets
	 * @return int
	 */
	public function getPets()
	{
		return $this->pets;
	}

	/**
	 * Set occupants
	 * @param int $occupants
	 */
	public function setOccupants($occupants)
	{
		$this->occupants=$occupants;
		return $this;
	}

	/**
	 * Get occupants
	 * @return occupants
	 */
	public function getOccupants()
	{
		return $this->occupants;
	}

	/**
	 * Set notes
	 * @param string $notes
	 */
	public function setNotes($notes)
	{
		$this->notes=$notes;
		return $this;
	}

	/**
	 * Get notes
	 * @return string
	 */
	public function getNotes()
	{
		return $this->notes;
	}

	/**
	 * Set status
	 * @param int $status
	 */
	public function setStatus($status)
	{
		$this->status=$status;
		return $this;
	}

	/**
	 * Get status
	 * @return int
	 */
	public function getStatus()
	{
		return $this->status;
	}
}
