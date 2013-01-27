<?php
/**
 * Applicant report will display all the information regarding applicants in the system.
 * This implementation is similar to Lease Agent View , except that we won't filter by status.
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Applicant_Library_Reports_Applicant extends ZFReport_Library_Base
{
	/**
	 * Identifier of the backendCache with the Zend_Cache_Manager
	 * @var const
	 */
	const CACHEIDENTIFIER='appreport';

	/**
	 * The default seed for cache
	 * @var const
	 */
	const DEFAULTSEED='appReport';

	/**
	 * Lifetime of the cache
	 * @var int
	 */
	protected  $lifeTime;

	/**
	 * Header of the report
	 * @var array
	 */
	public static $columnMap=array('applicantName','unitName','unitNumber','dateApplied','paid','backgroundCheckStatus');

	/**
	 * Sort helper
	 * @var ZFDb_SortHelper
	 */
	protected $sortHelper;

	/**
	 * DateHelper object to validate dates if provided
	 * @var ZFDate_DateHelper::
	 */
	private $dateHelper;
	
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
		$this->dateHelper = ZFDate_DateHelper::getInstance();
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

			//	We may retrieve a signal to discard the cache.
			$signal = $this->getSignaled();
			if( $signal===true )
			{
				$cachedResult = false;
				$cleanCache = $this->cleanCache();
			}
			else
			{
				//	Prepare the seed, if we don't have it, then force it
				$cachedResult = $engine->test($seed);
			}
			if($cachedResult==false)
			{
				$signalState = false;
				$result = $this->query();
				//  We will not store empty results
				if( !empty($result) )
				{
					$signalState = $engine->save($result,$seed);
				}
				if($this->getSignaled())
				{
					$this->setSignaled($signalState);
				}
			}
			else
			{
				if( $this->getSignaled() == true )
				{
					//	We failed to handle a signal clean properly
					$this->setSignaled(false);
				}
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
		$query->from(array('US' => 'user'),array('applicantName'=>"CONCAT_WS(' ',US.lastName,US.firstName)"))
			->join(array('A'=>'applicant'),'US.id=A.userId',null)
			->join(array('BG'=>'applicantBackgroundCheck'),'A.id=BG.applicantId',array('backgroundCheckStatus'=>'BG.status'))
			->joinLeft(array('AFB'=>'applicantFeeBill'),'A.id=AFB.applicantId',array('paid'=>"IF(AFB.billId IS NOT NULL,'yes','no')"))
			->join(array('AWS'=>'applicantWorkflowStatus'),'A.id=AWS.applicantId AND AWS.currentStatus=1',array('current'=>'AWS.currentStatus'))
			->join(array('AS'=>'applicantStatus'),'AWS.applicantStatusId=AS.id',array('statusName'=>'AS.name'))
			->join(array('AA'=>'applicantAppliance'),'A.id=AA.applicantId',array('dateApplied'=>"DATE_FORMAT(`AA`.`dateCreated`,'%m/%d/%Y')"))
			->join(array('U'=>'unit'),'AA.unitId=U.id',array('unitNumber'=>'U.number'))
			->join(array('UM'=>'unitModel'),'U.unitModelId=UM.id',array('unitName'=>'UM.name'))
			->where('AWS.currentStatus=1 AND BG.currentStatus=1');
			
		$dateFrom = $this->getDateFrom();
		$dateTo = $this->getDateTo();
		if( true===$this->dateHelper->isValidDate($dateTo) and true===$this->dateHelper->isValidDate($dateFrom) )
		{
			$query->where("AA.dateCreated BETWEEN '$dateFrom' AND '$dateTo'");
		}
		else
		{
			$query->where("AA.dateCreated ".self::DEFAULTLIMIT);
		}
		//	Users may have multiple fee payments, creating a duplication of records
		$query->group('A.id');
		
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
		if(!isset($this->cache) )
		{
			throw new Exception('Cache is not configured to operate');
		}
		$cache = $this->cache->getCache(self::CACHEIDENTIFIER);
		$saved = $cache->save($information, $this->getSeed());
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
		$worksheet = &$workbook->addWorksheet('Rent Roll');
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