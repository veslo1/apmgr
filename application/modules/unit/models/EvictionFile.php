<?php
/**
 *
 * @author Complete with your name <andyouremail@debserverp4.com.ar>
 */
class Unit_Model_EvictionFile extends ZFModel_ParentModel {
    
    const SRCPATH = '/usr/local/www/apmgr/public';

    public function __construct(array $options=null) { 
        parent::__construct($options);
        $this->setDbTable('Unit_Model_DbTable_EvictionFile');
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
     * @var NO $evictionId
     */
    protected $evictionId;

    /**
     * Set evictionId
     */
     public function setEvictionId($evictionId) {
         $this->evictionId=$evictionId;
         return $this;
     }
     /**
      * Get evictionId
      */
     public function getEvictionId() {
         return $this->evictionId;
     }
     /**
      * @var NO $fileId
      */
     protected $fileId;

     /** 
      * Set fileId
      */
     public function setFileId($fileId) {
         $this->fileId=$fileId;
         return $this;
     }
     /**
     * Get fileId
     */
    public function getFileId() {
        return $this->fileId;
    }
    
    /**
      * Retrieve a valid path for the image so it is diplayed properly
      * @return string
    */
    public function getSrc() {               
        return self::SRCPATH;
    }
}
