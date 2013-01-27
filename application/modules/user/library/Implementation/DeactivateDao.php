<?php
/**
 * Concrete implementation of the DeactivateDao
 * @author Jorge Omar Vazquez <jvazquez@vazney.com>
 * @package application.modules.users.library.implementation
 * TODO Refactor this mess
 */
class User_Library_Implementation_DeactivateDao implements User_Library_Interface_DeactivateDao , ZFInterfaces_Messageable
{
  /**
   * The persistance engine used in this application
   * @var Zend_Db_Adapter_Pdo_Mysql
   */
  private $db;

  /**
   * 
   * Contains a token
   * @var string
   */
  private $msg;

  /**
   *
   * Default constructor
   */
  public function __construct()
  {}

  /**
   * (non-PHPdoc)
   * @see library/ZFInterfaces/ZFInterfaces_Dao::save()
   */
  public function save(ZFModel_ParentModel $entity)
  {
    return $entity->save();
  }

  /**
   * (non-PHPdoc)
   * @see library/ZFInterfaces/ZFInterfaces_Dao::saveCollection()
   */
  public function saveCollection(array $args)
  {
    return false;
  }

  /**
   * (non-PHPdoc)
   * @see library/ZFInterfaces/ZFInterfaces_Dao::update()
   */
  public function update(ZFModel_ParentModel $entity)
  {
    return false;
  }

  /**
   * (non-PHPdoc)
   * @see library/ZFInterfaces/ZFInterfaces_Dao::delete()
   */
  public function delete(ZFModel_ParentModel $entity)
  {
    return false;
  }

  /**
   * (non-PHPdoc)
   * @see library/ZFInterfaces/ZFInterfaces_Dao::findById()
   */
  public function findById($id)
  {
    return false;
  }

  /**
   * (non-PHPdoc)
   * @see library/ZFInterfaces/ZFInterfaces_Dao::getDefinition()
   */
  public function getDefinition()
  {
    $table = $this->getTemplate()->info();
    return $table['cols'];
  }

  /**
   * (non-PHPdoc)
   * @see library/ZFInterfaces/ZFInterfaces_Dao::exists()
   */
  public function exists($dbFields, $value,$id=null)
  {
    $exists = false;
    if( null!==$value and isset($dbFields['table']) and isset($dbFields['column']) )
    {
      $record = array( 'table'=> $dbFields['table'], 'field'=>$dbFields['column']);
      if( $id )
      {
        $record['exclude'] = array( 'field'=>'id', 'value'=>$id );
      }
      $validator = new Zend_Validate_Db_RecordExists( $record );
      $exists = $validator->isValid($value);
    }
    return $exists;
  }

  /**
   * Retrieves the database adapter used to persist
   * @param array $options
   * @return Zend_Db_Table_Abstract
   */
  public function getPersistanceEngine(array $options=null)
  {
    // used to start a transaction and rollback if a current transaction is not passed in
    $this->db = Zend_Registry::get('db');
    $this->dbTransaction = isset( $options['transaction'] )?true:false;
    return $this->db;
  }

  /**
   * Retrieve the template
   * @return User_Model_DbTable_Deactivation
   */
  public function getTemplate()
  {
    return new User_Model_DbTable_Deactivation();
  }

  /**
   * 
   * Sets the message state
   * @param string $msg
   */
  public function setMessageState($msg)
  {
    $this->msg = $msg;
  }

  /**
   * 
   * Retrieve the message state
   */
  public function getMessageState()
  {
    return $this->msg;
  }
  
  public function fetchAll($where = null, $order = null, $count = null, $offset = null)
  {
  	return false;
  }
  
  /**
   * (non-PHPdoc)
   * @see ZFInterfaces/ZFInterfaces_Dao::setTemplate()
   */
  public function setTemplate(Zend_Db_Table_Abstract $template)
  {}
  
  /**
   * (non-PHPdoc)
   * @see ZFInterfaces/ZFInterfaces_Dao::getGateway()
   */
  public function getGateway()
  {}
}
