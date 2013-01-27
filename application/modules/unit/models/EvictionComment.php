<?php
/**
 *
 * @author Complete with your name <andyouremail@debserverp4.com.ar>
 */
class Unit_Model_EvictionComment extends ZFModel_ParentModel {

    public function __construct(array $options=null) { 
        parent::__construct($options);
        $this->setDbTable('Unit_Model_DbTable_EvictionComment');
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
      * @var NO $userId
      */
     protected $userId;

     /** 
      * Set userId
      */
     public function setUserId($userId) {
         $this->userId=$userId;
         return $this;
     }
    /**
     * Get userId
     */
    public function getUserId() {
        return $this->userId;
    }
    /**
     * @var YES $comment
     */
     protected $comment;

     /**
      * Set comment
      */
     public function setComment($comment) {
         $this->comment=$comment;
         return $this;
     }
    /**
     * Get comment
     */
     public function getComment() {
         return $this->comment;
     }
}
