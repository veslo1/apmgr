<?php
/**
 * Dao implementation for File object
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.file.library
 * 
 */

class File_Library_Impl_Dao extends ZFDao_Dao
{
	/**
	 * Constructor
	 */
	public function __construct()
	{}
	
	/**
	 * 
	 * Perform a transaction to save entities
	 * @param array $entities
	 */
	public function transactionSave(array $entities)
	{
		$saved = false;
		$db = $this->getGateway();
		try
		{
			$db->beginTransaction();
			$entities['file']->setDbAdapter($db);
			$fileId = $entities['file']->save();
			$entities['unitFile']->setDbAdapter($db);
			$entities['unitFile']->setFileId($fileId);
			$entities['unitFile']->save();
			$saved = $db->commit()!=false;
		}
		catch (Exception $e)
		{
			$log = new ZFObserver_Forensic();
			$log->setStatus(ZFObserver_Forensic::DEBUG);
			$log->attach(new ZFObserver_Observers_Text());
			$log->notify("DaoFile","Unable to perform a save operation.Caught exception: ".$e->getMessage());
			$db->rollBack();
		}
		return $saved;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see library/ZFDao/ZFDao_Dao::delete()
	 */
	public function delete(ZFModel_ParentModel $file)
	{
		$gw = $this->getGateway();
		$file->setDeleted(1);
		return $this->getTemplate()->update($file->toArray(),$gw->quoteInto("id=?",$file->getId(),'integer'));
	}
}