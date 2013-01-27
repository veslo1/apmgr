<?php
/**
 * Implementation of the Dao interface for user
 * @internal Another of the issues you saw that i used the DAO multiple times, across the business logic
 * and the Dao , it's because , we have a really coupled DAO ( the thing that interacts with the database ) and the model
 * per se (that represents an object in a persistance engine , usually a database ), so that is why it becomes so mangled sometimes
 * Though , in this implementation I'm trying something different
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.user.library.implementation
 */
class User_Library_Implementation_Dao implements User_Library_Interface_Dao , ZFInterfaces_Messageable,ZFObserver_ILogeable
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
		$table = new User_Model_DbTable_User();
		$list = $table->find($id);
		$user = null;
		if($list->count()>0)
		{
			$opts = $list->toArray();
			$user = new User_Model_User($opts[0]);
		}
		return $user;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::findByKey()
	 */
	public function findByKey(array $param)
	{
		$user = new User_Model_User();
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
		$this->log->notify($this, "Update method called in User Dao");
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
	 * @see library/ZFInterfaces/ZFInterfaces_Dao::delete()
	 */
	public function delete(ZFModel_ParentModel $entity)
	{
		//TODO Won't be implemented
		return true;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::disable()
	 */
	public function disable($id,$state)
	{
		$deleted = false;
		try
		{
			$user = new User_Model_User();
			$user = $user->findById($id);
			//	We must cycle between 1 and 0. We can enable / disable the field
			if($state==0)
			{
				$isDeleted = 0;
			}
			else
			{
				$isDeleted = 1;
			}
			$user->setDeleted($isDeleted);
			$deleted = $user->save();
		}
		catch (Exception $e)
		{
			$this->setMessageState(array('msg'=>'unableToDeleteUser','type'=>'error'));
			$deleted = false;
		}
		return $deleted;
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::fetchAll()
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null)
	{
		$user = new User_Model_DbTable_User();
		return $user->fetchAll($where,$order,$count,$offset);
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::getDefinition()
	 */
	public function getDefinition()
	{
		$tblDef = new User_Model_DbTable_User();
		$table = $tblDef->info();
		return $table['cols'];
	}

	/* (non-PHPdoc)
	 * @see application/modules/user/library/Interface/User_Library_Interface_Dao::getTemplate()
	 */
	public function getTemplate()
	{
		return new User_Model_DbTable_User();
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
	 * Used for logging
	 * @return string
	 */
	public function __toString()
	{
		return "UserDao";
	}
	
	/**
	 * 
	 * Sets the template entity that is being used
	 * @param Zend_Db_Table_Abstract $template
	 */
	public function setTemplate(Zend_Db_Table_Abstract $template){}
	
	/**
	 * Retrieve a Db object to interact with the database.
	 * Provides utilities such as quoteInto
	 * @return Zend_Db_Table_Abstract
	 */
	public function getGateway(){}
}