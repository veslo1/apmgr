<?php
/**
 * Extension to use flatXML datasets
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class DatabaseFlatXmlSeed extends PHPUnit_Extensions_Database_TestCase implements ZFObserver_ILogeable{

	/**
	 * This is the seed that acts as gateway to populate the database
	 * @var string
	 */
	protected $seed;

	/**
	 * Contain a List of the flat xml files that where called
	 * @var array
	 */
	public $seedMirror;

	/**
	 * Log the stuff
	 */
	protected $log;

	public function __construct()
	{
		$this->seedMirror = array();
	}

	/**
	 * Represents a path to a database seed
	 * @param string $seed
	 */
	public function setSeed($seed)
	{
		$this->seed = $seed;
	}

	/**
	 * Returns the seed of the database
	 * @return string
	 */
	public function getSeed() {
		return $this->seed;
	}


	/* (non-PHPdoc)
	 * @see PHPUnit/Extensions/Database/PHPUnit_Extensions_Database_TestCase::getConnection()
	 */
	protected function getConnection()
	{
		$properties = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini',APPLICATION_ENV);
		$pdo = new PDO($properties->appsettings->pdo->string, $properties->resources->db->params->username, $properties->resources->db->params->password);
		return $this->createDefaultDBConnection($pdo, $properties->resources->db->params->dbname);
	}


	/* (non-PHPdoc)
	 * @see PHPUnit/Extensions/Database/PHPUnit_Extensions_Database_TestCase::getDataSet()
	 */
	protected function getDataSet()
	{
		return $this->createFlatXMLDataSet($this->getSeed());
	}

	/* (non-PHPdoc)
	 * @see PHPUnit/Extensions/Database/PHPUnit_Extensions_Database_TestCase::getSetUpOperation()
	 */
	public function getSetUpOperation()
	{
		return $this->getOperations()->INSERT()->execute($this->getConnection(),$this->getDataSet());
	}

	// loads and executes the named data set
	public function loadDataSet($set)
	{
//		$this->logger = new ZFObserver_Forensic();
//		$this->logger->attach(new ZFObserver_Observers_Text());
//		$this->logger->setStatus(ZFObserver_ILogeable :: DEBUG);
//		$this->logger->notify($this, "System is loading {$set}");
//		$this->setSeed($set);
//		try
//		{
			$this->seedMirror[]=$set;
			$this->getSetUpOperation();
//		}
//		catch (Exception $e)
//		{
//			$this->logger->notify($this,"Exception caught in ".__FUNCTION__.$e->getMessage().", line ".__LINE__);
//		}
	}

	/* (non-PHPdoc)
	 * @see PHPUnit/Extensions/Database/PHPUnit_Extensions_Database_TestCase::getTearDownOperation()
	 */
	public function getTearDownOperation()
	{
		return $this->getOperations()->DELETE()->execute($this->getConnection(),$this->getDataSet());
	}

	/**
	 * Cleanup the application when we leave this object
	 */
	public function cleanUp()
	{
		$this->logger = new ZFObserver_Forensic();
		$this->logger->attach(new ZFObserver_Observers_Text());
		$this->logger->setStatus(ZFObserver_ILogeable :: DEBUG);
		if( !empty($this->seedMirror) )
		{
			try
			{
				foreach($this->seedMirror as $id=>$seed)
				{
					$this->logger->notify($this, "System setting {$seed}");
					$this->setSeed($seed);
					$this->getTearDownOperation();
				}
			}
			catch (Exception $e)
			{
				$this->logger->notify($this, "Exception caught while going down. ".$e->getMessage());
			}
		}
	}

	/**
	 * used in logging
	 * @return string
	 */
	public function __toString()
	{
		return "DatabaseFlagXmlSet";
	}
}
?>
