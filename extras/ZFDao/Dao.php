<?php
/**
 * Abstract implementation of DAO
 */
abstract class ZFDao_Dao extends Object_Instrospection implements ZFInterfaces_Dao
{
	/**
	 * Retrieves tne model
	 * @var Zend_Db_Table_Abstract
	 */
	protected $template;

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::save()
	 */
	public function save(ZFModel_ParentModel $entity)
	{
		$db = $this->getTemplate();
		$entity->setDbTable($db);
		if ( $entity->getDateCreated() == null )
		{
			$entity->setDateCreated(date(ZFInterfaces_Dao::DATEFORMAT));
		}
		return $db->insert($entity->toArray());
	}

	/* (non-PHPdoc)
	 * @see library/Zend/Db/Table/Zend_Db_Table_Abstract::update()
	 */
	public function update(ZFModel_ParentModel $entity)
	{
		$db = $this->getTemplate();
		$entity->setDbTable($db);
		$entity->setDateUpdated(date(ZFInterfaces_Dao::DATEFORMAT));
		return $db->update($entity->toArray(), $this->getGateway()->quoteInto("id=?",$entity->getId(),'integer'));
	}

	/* (non-PHPdoc)
	 * @see library/Zend/Db/Table/Zend_Db_Table_Abstract::delete()
	 */
	public function delete(ZFModel_ParentModel $entity)
	{
		$gw = $this->getGateway();
		return $this->getTemplate()->delete($gw->quoteInto("id=?",$entity->getId(),'integer'));
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::saveCollection()
	 */
	public function saveCollection(array $args)
	{
		return false;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::findById()
	 */
	public function findById($id)
	{
		$result = null;
		$row = $this->getTemplate()->find($id);
		if( $row!== NULL )
		{
			$result = array_shift($row->toArray());
		}
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::exists()
	 */	
	public function exists($dbFields, $value,$id=null)
	{
		$exists = false;
		if( null!==$value and isset($dbFields['table']) and isset($dbFields['column']) ) {
			$record = array( 'table'=> $dbFields['table'], 'field'=>$dbFields['column']);
			if( $id ){
				$record['exclude'] = array( 'field'=>'id', 'value'=>$id );
			}
			$validator = new Zend_Validate_Db_RecordExists( $record );
			$exists = $validator->isValid( $value )?true:false;
		}
		return $exists;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::fetchAll()
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null)
	{
		return $this->getTemplate()->fetchAll($where, $order, $count, $offset);
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::getDefinition()
	 */
	public function getDefinition()
	{
		$column = $this->getTemplate()->info();
		return $column['cols'];
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::getGateway()
	 */
	public function getGateway()
	{
		return Zend_Registry::get('db');
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::getTemplate()
	 */
	public function getTemplate()
	{
		return $this->template;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::setTemplate()
	 */
	public function setTemplate(Zend_Db_Table_Abstract $template)
	{
		$this->template = $template;
	}
}