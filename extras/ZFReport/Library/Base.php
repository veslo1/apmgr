<?php
/**
 * Base class for reporting
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */

abstract class ZFReport_Library_Base extends Object_Instrospection implements ZFReport_Interfaces_IReport,ZFInterfaces_Messageable
{
	/**
	 * The from date in the query
	 * @var Zend_Date
	 */
	private $dateFrom;

	/**
	 * The date to in the report
	 * @var Zend_Date
	 */
	private $dateTo;

	/**
	 * Collection of columns that will be used by this report
	 * @var array
	 */
	private $columns;

	/**
	 * Establish a connection with the gateway that provides our dataset
	 * @var Zend_Db|File
	 */
	private $gatewayLink;

	/**
	 * Cache engine
	 * @var Zend_Cache_Manager
	 */
	protected $cache;

	/**
	 * What kind of frontend cache will be used
	 * @var string (Core)
	 */
	protected $frontEndCache;

	/**
	 * What kind of backend cache will be used (File|Apc|Sqlite|Xdebug)
	 * @var string
	 */
	protected $backendCache;

	/**
	 * Cache options for the frontend
	 * @var array
	 */
	protected $frontEndOptions;

	/**
	 * Cache options for the backend
	 * @var array
	 */
	protected $backendOptions;

	/**
	 * This is the attribute that is used in prepareCache
	 * @var string $seed
	 */
	protected $seed;

	/**
	 * The query that is executed
	 * @var Zend_Db_Statement|string
	 */
	protected $query;

	/**
	 * Identifier of the cache engine registered in cache
	 * @var string $cacheIdentifier
	 */
	protected $cacheIdentifier;

	/**
	 * Internal buffer used by the query method , used in export
	 * @var array
	 */
	protected $data;

	/**
	 * Enum
	 * @var array
	 */
	public static $mapper = array(self::DB,self::FILE);

	/**
	 * Message state for the state of this object
	 * @var string
	 */
	protected $msg;

	/**
	 * The page the user might set when the report is paginated
	 * @var int
	 */
	protected $page;

	/**
	 * Retrieve a signal from a external element telling us to discard/keep the cache
	 * @var boolean
	 */
	protected $signaled;

	/**
	 * Set the lifetime of the cache
	 * @param int $lifeTime
	 */
	public function setLifeTime($lifeTime=self::LIFETIME)
	{
		$this->lifeTime = $lifetime;
	}

	/**
	 * Retrieve the lifetime of the cache
	 */
	public function getLifeTime()
	{
		return $this->lifeTime;
	}

	/**
	 * Set the date from
	 * @param string $date
	 */
	public function setDateFrom($date)
	{
		$this->dateFrom = $date;
	}

	/**
	 * Retrieve the date from
	 * @return Zend_Date
	 */
	public function getDateFrom()
	{
		return $this->dateFrom;
	}

	/**
	 * Set the date to
	 * @param string $date
	 */
	public function setDateTo($date)
	{
		$this->dateTo = $date;
	}

	/**
	 * Retrieve the date to
	 * @return Zend_Date
	 */
	public function getDateTo()
	{
		return $this->dateTo;
	}

	/**
	 * Determine the data source that we will use
	 * @param string $mode
	 * @throws Exception
	 * @throws Zend_Db_Exception
	 * @throws File_Exception
	 */
	public function setGatewayLink($mode)
	{
		$valid = in_array($mode,self::$mapper);
		if( !$valid )
		{
			throw new Exception('Gateway not initialized');
		}
		switch ($mode)
		{
			case self::DB:
				$this->gatewayLink = Zend_Registry::get('db');
				break;
			case self::FILE:
				//TODO Implement an object that retrieves a file pointer
				throw new Exception('Not implemented yet');
				break;
			case self::URL:
				//TODO Implement an object that retrieves a connection
				throw new Exception("Not implemented yet");
				break;
		}
	}

	/**
	 * Retrieve the established connection with the mapper
	 * @return Ambigous <Zend_Db, File>
	 */
	public function getGatewayLink()
	{
		return $this->gatewayLink;
	}

	/**
	 * Set the columns that will be used in this report
	 * @param array $columns
	 */
	public function setColumns(array $columns)
	{
		$this->columns = $columns;
	}

	/**
	 * Get the columns that will be used in this report
	 * @return multitype:
	 */
	public function getColumns()
	{
		return $this->columns;
	}

	/**
	 * Retrieve the enum
	 * @return multitype:
	 */
	public function getMapper()
	{
		return self::$mapper;
	}

	/**
	 * Retrieve the valid order keys that may be used
	 * @return multitype:
	 */
	public function getOrdering()
	{
		return self::$ordering;
	}

	/**
	 * Init the type of cache that will be used.This identifies a cache with the Zend_Cache_Manager engine
	 * @link ZendFramework-1.10.3/documentation/manual/core/en/zend.cache.backends.html
	 * @throws Exception
	 */
	public function initCacheManager()
	{
		$cacheIdentifier = $this->getCacheIdentifier();
		if( empty($cacheIdentifier) )
		{
			throw new Exception('The cache identifier is not set');
		}
		$this->cache = new Zend_Cache_Manager;
		$cache = Zend_Cache::factory($this->frontEndCache,$this->backendCache,$this->frontEndOptions,$this->backendOptions,false);
		$this->cache->setCache($this->getCacheIdentifier(), $cache);
	}

	/**
	 * Retrieve the cache manager to access the cache functionality
	 * @return Zend_Cache_Manager
	 */
	public function getCacheManager()
	{
		return $this->cache;
	}

	/**
	 * Validate that the requested columns to sort are valid
	 * @param array $reportColumns
	 * @param string $userColumn
	 * @return boolean
	 */
	public function validateColumns(array $reportColumns,$userColumn)
	{
		$valid = false;
		if( in_array($userColumn,$reportColumns) )
		{
			$valid = true;
		}
		else
		{
			$this->setMessageState('invalidColumnSpecified');
		}
		return $valid;
	}

	/**
	 * The query that will be used in a report
	 * @param Zend_Db_Statement|string $query
	 */
	public function setQuery($query)
	{
		$this->query = $query;
	}

	/**
	 * Set the attribute cacheIdentifier. Cache identifier will create an entry in Zend_Cache_Manager
	 * @param string $identifier A valid identifier with no spaces
	 */
	public function setCacheIdentifier($identifier)
	{
		$this->cacheIdentifier = $identifier;
	}

	/**
	 * Retrieve the string that we use to configure our cache object inside Zend_Cache_Manager
	 * @return string
	 */
	public function getCacheIdentifier()
	{
		return $this->cacheIdentifier;
	}

	/**
	 * Retrieve the query that was used
	 * @return Ambigous <Zend_Db_Statement, string>
	 */
	public function getQuery()
	{
		return $this->query;
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::setSeed()
	 */
	public function setSeed($seed)
	{
		$this->seed = $seed;
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::getSeed()
	 */
	public function getSeed()
	{
		return $this->seed;
	}

	/* (non-PHPdoc)
	 * @see library/Object/Object_Instrospection::setMessageState()
	 */
	public function setMessageState($msg)
	{
		$this->msg = $msg;
	}

	/* (non-PHPdoc)
	 * @see library/Object/Object_Instrospection::getMessageState()
	 */
	public function getMessageState()
	{
		return $this->msg;
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::setPage()
	 */
	public function setPage($page)
	{
		$this->page = $page;
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::getPage()
	 */
	public function getPage()
	{
		return $this->page;
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::init()
	 */
	public function init()
	{
		$this->setCacheFrontEnd('Core');
		$this->setCacheBackEnd('File');
		//	Be very aware on how you implement this. Recall that each cache contains different params, some of them won't receive arguments, others will
		$this->configureCacheFrontEnd();
		$this->configureCacheBackEnd();
		$this->initCacheManager();
		$this->prepareCacheSeed();
	}


	/**
	 * Retrieve the cache manager and perform a clean up.This method is used when we are using form filters, such as
	 * dates , and after posting, we need to clean up the cache.
	 * @return boolean
	 * @throws Zend_Cache_Exception
	 */
	public function cleanCache()
	{
		//	,$this->getSeed() We don't send seed, since we want to clean *all* the cached elements for this cache
		$this->getCacheManager()->getCache($this->getCacheIdentifier())->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	/**
	 * Set the signal that may indicate that cache must be discarded/kept
	 * @param boolean $signal
	 */
	public function setSignaled($signal=false)
	{
		$this->signaled = $signal;
	}

	/**
	 * Retrieve the signal to clean cache
	 * @return boolean
	 */
	public function getSignaled()
	{
		return $this->signaled;
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::setCacheFrontEnd()
	 */
	public function setCacheFrontEnd($type)
	{
		$this->frontEndCache = $type;
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::setCacheBackEnd()
	 */
	public function setCacheBackEnd($type)
	{
		$this->backendCache = $type;
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::configureCacheFrontEnd()
	 */
	public function configureCacheFrontEnd()
	{
		$this->frontEndOptions = array('automatic_serialization' => true,'lifetime' => $this->getLifeTime() );
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::configureCacheBackEnd()
	 */
	public function configureCacheBackEnd()
	{
		//		$this->backendOptions = array(); For Apc
		//	For file
		$this->backendOptions = array('lifetime' => $this->getLifeTime(),'cache_dir'=> APPLICATION_PATH.'/../cache');
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::prepareCacheSeed()
	 */
	public function prepareCacheSeed()
	{
		//	First we deal with the basic parameters
		$seed = $this->getSeed();
		//	If we are paginating we extend the cache identifier to mySeedpage2
		$page = (int) $this->getPage();
		if( !empty($page) and is_numeric($page) and $page>0 )
		{
			$seed .=self::PAGINATING.$page;
		}

		//	And if we are soring we extend to mySeedpage2columnfooasc
		if( $this->sortHelper->isSorting() )
		{
			$seed .=str_replace(' ', '', $this->sortHelper->prepareOrderQuery());
		}
		$this->setSeed($seed);
	}

	/**
	 * Set the exported report information
	 * @param array $data
	 */
	public function setData($data=null)
	{
		$this->data = $data;
	}

	/**
	 * Retrieve the reports
	 * @return multitype:
	 */
	public function getData()
	{
		return $this->data;
	}
	
	/**
	 * Determine if the data element contains information.
	 * @return boolean
	 */
	public function hasRecords()
	{
		$checks = array();
		$checks[] = isset($this->data)?true:false;
		$checks[] = !empty($this->data)?true:false;
		$checks[] =  is_array($this->data) and count($data) > 0 ? true : false;
		return !in_array(false,$checks);
	}
}
