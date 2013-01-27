<?php
/**
 * Concrete implementation of the Dao object for Prospects
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.prospects.library
 */
class Prospects_Library_Dao extends ZFDao_Dao
{
	/**
	 *
	 * Auto initialize the prospects gateway
	 */
	public function __construct()
	{
		$this->setTemplate(new Prospects_Model_DbTable_Prospects());
	}

	/**
	 *
	 * Perform a save operation
	 * @param array $args
	 */
	public function saveTransaction(array $args)
	{
		$saved = false;
		$db = $this->getGateway();

		try
		{
			$db->beginTransaction();
			$daoAnswer = $args['daoAnswer'];
			$prospect = $args['prospect'];
			$answer = $args['prospectAnswer'];
			$prospect->setDbAdapter($db);
			$answer->setDbAdapter($db);
			$prospectId = $prospect->save();
			if( count($args['payload']['modelType'])>0 )
			{
				foreach($args['payload']['modelType'] as $id=>$value)
				{
					$answer->setUnitModelId($value);
					$answer->setProspectId($prospectId);
					$answer->save();
				}
			}
			else
			{
				$answer->setUnitModelId($args['payload']['modelType']);
				$answer->setProspectId($prospectId);
				$answer->save();
			}
			$saved = $db->commit() != false;
		}
		catch (Exception $e)
		{
			$db->rollBack();
			$log = new ZFObserver_Forensic();
			$log->setStatus(ZFObserver_Forensic::ERR);
			$log->attach(new ZFObserver_Observers_Text());
			$log->notify(__CLASS__,"Exception caught while performing a transaction.".$e->getMessage());
		}
		return $saved;
	}
}
