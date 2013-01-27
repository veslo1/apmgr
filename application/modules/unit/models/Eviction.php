<?php
/**
 *
 * @author Complete with your name <andyouremail@debserverp4.com.ar>
 */
class Unit_Model_Eviction extends ZFModel_ParentModel {

    public function __construct(array $options=null) { 
        parent::__construct($options);
        $this->setDbTable('Unit_Model_DbTable_Eviction');
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
    * @var NO $tenantId
    */
    protected $tenantId;

    /**
     * Set tenantId
     */
    public function setTenantId($tenantId) {
        $this->tenantId=$tenantId;
        return $this;
    }
    /**
     * Get tenantId
     */
    public function getTenantId() {
        return $this->tenantId;
    }
   /**
    * @var YES $isEvicted
    */
    protected $isEvicted;

    /**
     * Set isEvicted
     */
    public function setIsEvicted($isEvicted) {
        $this->isEvicted=$isEvicted;
        return $this;
    }
    /**
     * Get isEvicted
     */
    public function getIsEvicted() {
        return $this->isEvicted;
    }
}
