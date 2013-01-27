<?php
/**
 * Late Due Fee
 * @link http://gaymine.dyndns-free.com/projects/rnam/wiki/LateDueFees
 */

class Financial_Library_Reports_LateDueFee extends ZFReport_Library_Base
{

	/**
	 * Identifier of the backendCache with the Zend_Cache_Manager
	 * @var const
	 */
	const CACHEIDENTIFIER='lateDueFee';

	/**
	 * The default seed for cache
	 * @var const
	 */
	const DEFAULTSEED='lateDueFeeReport';

	/**
	 * Lifetime of the cache
	 * @var int
	 */
	protected  $lifeTime;

	/**
	 * Header of the report
	 * @var array
	 */
	public static $columnMap=array('unitNumber','feeAmountDue','feeDueDate','numDaysLate','tenantName','feeName');

	/**
	 * Sort helper
	 * @var ZFDb_SortHelper
	 */
	private $sortHelper;	

	/**
	 * Constructor
	 * @param array $options
	 */
	public function __construct(array $options=NULL)
	{
		$this->instrospect($options);
		$this->sortHelper = new ZFDb_SortHelper($options);
		$this->sortHelper->setValidColumn(self::$columnMap);
		// We tell this object, <strong>this are the columns we accept</strong>
		$this->setColumns(self::$columnMap);
		$this->setGatewayLink(self::DB);
		$this->setSeed(self::DEFAULTSEED);
		$this->setCacheIdentifier(self::CACHEIDENTIFIER);
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

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::runReport()
	 */
	public function runReport($useCache=false)
	{
		$result = null;
		if( true===$useCache )
		{
			$seed = $this->getSeed();
			$cacheEngine = $this->getCacheManager();
			$identifier = $this->getCacheIdentifier();
			if($identifier==null)
			{
				$identifier = self::CACHEIDENTIFIER;
			}
			//  Retrieve the cache engine we registered
			$engine = $cacheEngine->getCache($identifier);
			//	Prepare the seed, if we don't have it, then force it
			$cachedResult = $engine->test($seed);
			if($cachedResult==false)
			{
				$result = $this->query();
				//  We will not store empty results
				if( !empty($result) )
				{
					$engine->save($result,$seed);
				}
			}
			else
			{
				$result = $engine->load($seed);
			}
		}
		else
		{
			$result = $this->query();
		}
		//	We set up our attribute, used later in exporting
		$this->setData($result);
		return $result;
	}

	/**
	 * Perform the query itself
	 * @return array
	 * @throws Zend_Db_Exception
	 */
	private function query()
	{
		$result = null;						
				
		$query = $this->getGatewayLink()->select();
		$query->from(array('L'=>'lease'),array())
		->join(array('LF'=>'leaseFee'),'LF.leaseId=L.id',array())
		->join(array('F'=>'fee'),'LF.feeId=F.id',array('feeName'=>'name'))
		->join(array('B'=>'bill'),'LF.billId=B.id',array('feeAmountDue'=>'B.originalAmountDue','feeDueDate'=>"DATE_FORMAT(B.dueDate,'%m/%d/%Y')", 'numDaysLate'=>'DATEDIFF(NOW(),B.dueDate)'))		
		->join(array('U'=>'unit'),'L.unitId = U.id',array('unitNumber'=>'U.number'))
		->join(array('T'=>'tenant'),'L.id=T.leaseId',array())
		->join(array('US' => 'user'),'T.userId=US.id',array('tenantName'=>"CONCAT_WS(' ',US.firstName, US.lastName)"))
		->where('B.dueDate<NOW() AND B.isPaid=0');				
						
		//	Before running the query itself, you need to verify if you have a column and a sort
		$sort = $this->sortHelper->isSorting();
		if( true===$sort )
		{
			$query->order($this->sortHelper->prepareOrderQuery());
		}		
		
		//	For debug purposes
		$this->setQuery($query);
		$buffer = $this->getGatewayLink()->query($query);
		foreach($buffer as $id=>$key)
		{
			$result[] = $key;
		}
		return $result;
	}

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::cacheData()
	 */
	public function cacheData(array $information=null)
	{
		$cache = $this->cache->getCache(Financial_Library_Reports_LateDueFee::CACHEIDENTIFIER);
		$saved = $cache->save($information, $this->getSeed());
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

	/* (non-PHPdoc)
	 * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::exportReport()
	 */
	public function exportReport()
	{
		$report = $this->getData();
		//	We remove fields that we do not want
		foreach($report as $id=>$column)
		{
			unset($report[$id]['userId']);
			//unset($report[$id]['cancellationLastDay']);
		}
		$workbook = new Spreadsheet_Excel_Writer();
		//	Send the headers, this is important
		$workbook->send('report.xls');
		$worksheet = &$workbook->addWorksheet('Late Due Fee');
		$headers = self::$columnMap;

		$column = 0;
		$row = 0;
		$totalColumns = count($headers);
		//	We need the translator for the columns
		$translator = Zend_Registry::get('Zend_Translate');

		//	Write the header of the report
		for($column=0;$column<$totalColumns;$column++)
		{
			$worksheet->write($row, $column, $translator->translate($headers[$column]));
		}

		//	We start at row 1 now
		$row = 1;

		foreach($report as $id=>$content)
		{
			for($column=0;$column<$totalColumns;$column++)
			{
				$colValue = isset($content[self::$columnMap[$column]])?$content[self::$columnMap[$column]]:'N/A';
				$worksheet->write($row, $column, $colValue);
			}
			//	We reset the column back to 0
			$column = 0;
			//	And we move forward one row
			$row++;
		}

		$closed = $workbook->close();
		return $closed;
	}	
}
