<?php
/**
 * Created on August 14, 2010 by rnelson
 * @name apmgr
 * @package application.modules.financial.models
 * <p>
 * Stores the cash account info for fees
 * * </p>
 */
class Financial_Model_FinancialAccountSetting extends ZFModel_ParentModel {

	public function __construct(array $options=null) {
		parent::__construct($options);
		$this->setDbTable('Financial_Model_DbTable_FinancialAccountSetting');
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
	 * @var NO $settingName
	 */
	protected $settingName;

	/**
	 * Set settingName
	 */
	public function setSettingName($settingName) {
		$this->settingName=$settingName;
		return $this;
	}
	/**
	 * Get settingName
	 */
	public function getSettingName() {
		return $this->settingName;
	}
	/**
	 * @var NO $accountId
	 */
	protected $accountId;

	/**
	 * Set accountId
	 */
	public function setAccountId($accountId) {
		$this->accountId=$accountId;
		return $this;
	}
	/**
	 * Get accountId
	 */
	public function getAccountId() {
		return $this->accountId;
	}
	/**
	 * @var NO $description
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
	 *  Returns the account name of the assigned account
	 */
	public function getAccount(){
		$accountObj = new Financial_Model_Account();
		$accountItem = $accountObj->findById( $this->getAccountId() );
		return $accountItem;
	}

}
