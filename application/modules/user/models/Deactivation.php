<?php
/**
 * Mapper for the deactivation entity
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.models
 */
class User_Model_Deactivation extends ZFModel_ParentModel
{
	/**
	 * Contains the id of the user that will be deleted
	 * @var int $userId
	 */
	protected $userId;
	
	/**
	 * The user that deletes the account
	 * @var int $author
	 */
	protected $author;
	
	/**
	 * Contains a text area that says why the user will be deleted
	 * @var string $description
	 */
	protected $description;
	
	/**
	 * 
	 * Default constructor
	 * @param array $options
	 */
	public function __construct(array $options=null)
	{
		parent::__construct($options);
		$this->setDbTable('User_Model_DbTable_Deactivation');
	}
	
	/**
	 * 
	 * Sets the userId
	 * @param int $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}
	
	/**
	 * 
	 * Return the userId
	 * @return int
	 */
	public function getUserId()
	{
		return $this->userId;
	}
	
	/**
	 * 
	 * Sets the author
	 * @param int $author
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
	}
	
	/**
	 * 
	 * Returns the author
	 * @return int
	 */
	public function getAuthor()
	{
		return $this->author;
	}
	
	/**
	 * 
	 * Sets the description
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}
	
	/**
	 * 
	 * Retrieve the description
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}
}