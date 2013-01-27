<?php
/**
 * Implementation of the Dao interface for Retrieve
 * @internal Another of the issues you saw that i used the DAO multiple times, across the business logic
 * and the Dao , it's because , we have a really coupled DAO ( the thing that interacts with the database ) and the model
 * per se (that represents an object in a persistance engine , usually a database ), so that is why it becomes so mangled sometimes
 * Though , in this implementation I'm trying something different
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.library.implementation
 */
class User_Library_Implementation_RetrieveDao implements User_Library_Interface_RetrieveDao , ZFInterfaces_Messageable,ZFObserver_ILogeable
{
	/**
	 * The persistance engine used in this application
	 * @var Zend_Db_Adapter_Pdo_Mysql
	 */
	private $db;

	/**
	 * Indicates wheter we use transactions or not
	 * @var boolean
	 */
	private $dbTransaction;

	/**
	 * Sets the state of this object in a translatable token
	 * @var string
	 */
	private $msg;

	/**
	 * Log object
	 * @var ZFObserver_Forensic
	 */
	private $log;

	/**
	 * Constructor
	 */
	public function __construct()
	{}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::setMessageState()
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}

	/* (non-PHPdoc)
	 * @see library/ZFInterfaces/ZFInterfaces_Messageable::getMessageState()
	 */
	public function getMessageState()
	{
		return $this->msg;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::save()
	 */
	public function save(ZFModel_ParentModel $user)
	{
		$saved = false;
		$db = $this->getPersistanceEngine();
		try
		{
			$this->db->beginTransaction();
			$user->setDbAdapter($db);
			$saved = $user->save();
			$buffer = $this->db->commit();
			$saved = true;
		}
		catch (Exception $e)
		{
			$observer = new ZFObserver_Forensic();
			$observer->setStatus(ZFObserver_ILogeable::ERR);
			$observer->attach(new ZFObserver_Observers_Text());
			$observer->notify($this, "Error caught while saving with message ".$e->getMessage());
			$this->db->rollback();
			//	TODO Log & email us
		}
		return $saved;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::saveCollection()
	 */
	public function saveCollection(array $args)
	{
		$saved = false;
		$db = $this->getPersistanceEngine();
		try
		{
			$this->db->beginTransaction();
			foreach($args as $id=>$model)
			{
				$model->setDbAdapter($db);
				$model->save();
			}
			$saved = $this->db->commit();
		}
		catch (Exception $e)
		{
			$this->db->rollback();
			//	TODO Log & email us
		}
		return $saved;
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

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::findById()
	 */
	public function findById($id)
	{
		$table = new User_Model_DbTable_Recover();
		$list = $table->find($id);
		$recover = null;
		if($list->count()>0)
		{
			$opts = $list->toArray();
			$recover = new User_Model_Recover($opts[0]);
		}
		return $recover;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::findByKey()
	 */
	public function findByKey(array $param)
	{
		$user = new User_Model_Recover();
		return $user->findByKey($param);
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::update()
	 */
	public function update(ZFModel_ParentModel $user)
	{
		$saved = false;
		$this->log = new ZFObserver_Forensic();
		$this->log->attach(new ZFObserver_Observers_Text());
		$this->log->setStatus(ZFObserver_ILogeable::INFO);
		$this->log->notify($this, "Update method called in Recover Dao");
		$db = $this->getPersistanceEngine();
		try
		{
			$saved = $user->save();
		}
		catch (Exception $e)
		{
			$saved = false;
			$this->log->setStatus(ZFObserver_ILogeable::ERR);
			$this->log->notify($this, "Exception caught while trying to update a user , response was".$e->getMessage()." , line ".$e->getLine());
		}
		$this->log->setStatus(ZFObserver_ILogeable::INFO);
		$this->log->notify($this, "Exiting update user with return value $saved");
		return $saved;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::delete()
	 */
	public function delete($id)
	{
		$where = $this->getPersistanceEngine()->getAdapter()->quoteInto('id=?', $id,'integer');
		$deleted = $this->getTemplate()->delete($where);
		return $deleted; 
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::fetchAll()
	 */
	public function fetchAll()
	{
		$recover = new User_Model_DbTable_Recover();
		return $recover->fetchAll();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::getDefinition()
	 */
	public function getDefinition()
	{
		$tblDef = new User_Model_DbTable_Recover();
		$table = $tblDef->info();
		return $table['cols'];
	}

	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::getTemplate()
	 */
	public function getTemplate()
	{
		return new User_Model_DbTable_Recover();
	}

	/**
	 * Used for logging
	 * @return string
	 */
	public function __toString()
	{
		return "UserRecoverDao";
	}
}