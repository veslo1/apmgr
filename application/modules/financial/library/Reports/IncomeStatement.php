<?php
/**
 * Income Statement
 * @link http://gaymine.dyndns-free.com/projects/rnam/wiki/PLStatement
 */

class Financial_Library_Reports_IncomeStatement extends ZFReport_Library_Base
{

  /**
   * Identifier of the backendCache with the Zend_Cache_Manager
   * @var const
   */
  const CACHEIDENTIFIER='incomeStatement';

  /**
   * The default seed for cache
   * @var const
   */
  const DEFAULTSEED='incomeStatementReport';

  /**
   * Lifetime of the cache
   * @var int
   */
  protected  $lifeTime;

  /**
   * Sort helper
   * @var ZFDb_SortHelper
   */
  private $sortHelper;

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
    //$this->sortHelper = new ZFDb_SortHelper($options);
    //$this->sortHelper->setValidColumn(self::$columnMap);
    // We tell this object, <strong>this are the columns we accept</strong>
    //$this->setColumns(self::$columnMap);
    $this->setGatewayLink(self::DB);
    $this->setSeed(self::DEFAULTSEED);
    $this->setCacheIdentifier(self::CACHEIDENTIFIER);
    $this->dateHelper = ZFDate_DateHelper::getInstance();
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
    
    $from = $this->getDateFrom();
    $to = $this->getDateTo(); 
    
    $at = new Financial_Model_AccountTransaction();
    if( true===$this->dateHelper->isValidDate($from) and true===$this->dateHelper->isValidDate($to) )
    {
      $at->setDateFrom( $from );
      $at->setDateTo( $to );
    }
    $result['dateFrom'] = $from;
    $result['dateTo'] = $to;    
    
    $revenue = $at->getBalancesByAccountType('revenue');
    $expense = $at->getBalancesByAccountType('expense');
    $result['revenue'] = $revenue;
    $result['sumRevenue'] = $this->sumAccountBalance($revenue);
    $result['expense'] = $expense;
    $result['sumExpense'] = $this->sumAccountBalance($expense);
    $result['balance'] =  $result['sumRevenue'] - $result['sumExpense'];
    return $result;
  }

  /* (non-PHPdoc)
   * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::cacheData()
   */
  public function cacheData(array $information=null)
  {
    $cache = $this->cache->getCache(Financial_Library_Reports_DueFee::CACHEIDENTIFIER);
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
    /*
    if( $this->sortHelper->isSorting() )
    {
      $seed .=str_replace(' ', '', $this->sortHelper->prepareOrderQuery());
    }
    */
    $this->setSeed($seed);
  }

  /* (non-PHPdoc)
   * @see library/ZFReport/Interfaces/ZFReport_Interfaces_IReport::exportReport()
   */
  public function exportReport()
  {
    //	We need the translator for the columns
    $translator = Zend_Registry::get('Zend_Translate');
    $report = $this->getData();
    $writerImpl = new Financial_Library_Reports_WriterImpl();
    $writerImpl->setWorkbook(new Spreadsheet_Excel_Writer());
    $writerImpl->setSheetName($translator->translate('incomeStatement'));
    //  We need to get the date if we used something
    if( 
        true===$this->dateHelper->isValidDate($this->getDateTo()) and
        true===$this->dateHelper->isValidDate($this->getDateFrom())
      )
    {
      $date = $this->getDateTo().' '.$this->getDateFrom();
    }
    else
    {
      $date = date('m-d-Y');
    }
    //  this is the bulk report per se
    $payload = array(
      0 => array( $date ),
      1 => $translator->translate('revenue'),
      2 => $report['revenue'],
      3 => array($translator->translate('totalRevenue')=>$report['sumRevenue']),
      4 => array($translator->translate('expense')),
      5 => $report['expense'],
      6 => array($translator->translate('totalExpense')=>$report['sumExpense']),
      7 => array($translator->translate('total')=>$report['balance'])
    );
    try
    {
      $closed = $writerImpl->write();
    }
    catch(Exception $e)
    {
      //TODO Log
      $closed = false;
    }
    return $closed;
  }

  /**
   * Wraps get balances by account type
   * @deprecated
   */
  public function getSection( $section ){
    $at = new Financial_Model_AccountTransaction();

    if( true===$this->dateHelper->isValidDate($this->getDateTo()) and true===$this->dateHelper->isValidDate($this->getDateFrom()) ){
      //echo 'here'; die;
      $at->setDateFrom( $this->getDateFrom() );
      $at->setDateTo( $this->getDateTo() );
    }
    return $at->getBalancesByAccountType( $section );
  }

  /**
   * Perform the sum operation for accounts
   * @param array $account
   * @return signed double
   */
  public function sumAccountBalance(array $account=array())
  {
    $result = 0;
    $result = array_sum($account);
    return $result;
  }
}
