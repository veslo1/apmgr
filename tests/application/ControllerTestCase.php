<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase implements ZFObserver_ILogeable
{
	/**
	 * @link http://sebastian-bergmann.de/archives/797-Global-Variables-and-PHPUnit.html
	 */
//    protected $backupGlobals = FALSE;
    
	/**
	 * @var Zend Application Object
	 */
	protected $application;

	/**
	 * @var Zend_Db_Table object.
	 */
	protected $db;

	/**
	 * @var Zend_Cache
	 */
	protected $cache;

	/**
	 * @var Zend_Locale
	 */
	protected $locale;

	/**
	 * @param Object acl The Acl that Rules our application
	 */
	protected $acl;

	/**
	 * @var ZFObserver_Forensic $logger
	 */
	protected $logger;

	/**
	 * @var DatasetGenerator
	 */
	protected $dSet;

	/**
	 * @var Zend_View $view
	 */
	protected $view;

	/**
	 * Enter description here ...
	 * @var array
	 */
	protected $dataSetStackBuffer;

	/**
	 * This is the registry log
	 * @var Zend_Log log
	 */
	protected $log;

	/**
	 * The extension for the dataset
	 * @var const
	 */
	const DEXT=".xml";

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Test/PHPUnit/Zend_Test_PHPUnit_ControllerTestCase::setUp()
	 */
	public function setUp()
	{
		$this->logger = new ZFObserver_Forensic();
		$this->logger->attach(new ZFObserver_Observers_Text());
		$this->logger->setStatus(ZFObserver_ILogeable :: DEBUG);
		$this->bootstrap = array( $this,'appBootstrap');
		$this->dSet = new DatabaseFlatXmlSeed();
		$this->dataSetStackBuffer = array();
		parent::setup();
	}

	/**
	 * Set up your test to run this datasets
	 * @throws InvalidArgumentException
	 */
	public function loadDataSets()
	{
		try
		{
			foreach($this->dataSetStackBuffer as $filename=>$mode)
			{
				$seed = APPLICATION_FAKESETS.DIRECTORY_SEPARATOR.$filename.self::DEXT;
				$this->logger->notify("ControllerTestCase", "System is loading ".$seed." , in ".__FILE__." , line ".__LINE__);
				$this->dSet->setSeed($seed);
				$this->dSet->getSetUpOperation();
			}
		}
		catch (Exception $e)
		{
			$this->logger->notify($this, "Exception caught while loading dataset stack.".$e->getMessage());
		}
	}


	/**
	 * When your test finish , only delete the datasets that where flaged as 1
	 * The 0 flagged won't be called, because they will usually be deleted by
	 * the Fk' cascade system
	 * @link http://gaymine.dnsalias.com/projects/rnam/wiki/Common_agreement_for_Unit_testing_and_datasets
	 * @throws InvalidArgumentException
	 */
	public function unLoadDataSets()
	{
		$filteredDataSetStackBuffer = new DatasetArrayFilterIterator(new ArrayIterator($this->dataSetStackBuffer));
		foreach($filteredDataSetStackBuffer as $filename=>$mode)
		{
			$this->dSet->setSeed(APPLICATION_FAKESETS.DIRECTORY_SEPARATOR.$filename.self::DEXT);
			$this->dSet->getTearDownOperation();
		}
	}

	/**
	 * Set up the zend framework suite
	 */
	public function appBootstrap() {
		//  setup the base url.
		try{
			$this->application =  new Zend_Application(APPLICATION_ENV,APPLICATION_PATH.'/configs/application.ini');
			$bootstrapResource = $this->application->getBootstrap()->bootstrap('AppProperties');
			$bootstrapResource = $this->application->getBootstrap()->bootstrap('db');
			$this->db = $bootstrapResource->getResource('db');
			//	Clean the table during startup
			$this->db->query('CALL cleanTableForTesting()');
			$bootstrapResource = $this->application->getBootstrap()->bootstrap('Doctype');
			$this->view = $bootstrapResource->getResource('Doctype');
			$bootstrapResource = $this->application->getBootstrap()->bootstrap('ModelPlugin');
			$bootstrapResource = $this->application->getBootstrap()->bootstrap('ModularApplication');
			$bootstrapResource = $this->application->getBootstrap()->bootstrap('DockletCheck');
			//	Our Acl , use it with caution
			$bootstrapResource = $this->application->getBootstrap()->bootstrap('acl');
			$this->acl = $bootstrapResource->getResource('acl');
			$bootstrapResource = $this->application->getBootstrap()->bootstrap('CacheTableAbstract');
			//		$this->cache = $bootstrapResource->getResource('CacheTableAbstract');
			$this->cache = Zend_Registry::get('cache');
			$bootstrapResource = $this->application->getBootstrap()->bootstrap('Locale');
			$this->locale = Zend_Registry::get('Zend_Locale');
			//	If you see an error regarding "we can't load the Zend_Translate key in the registry , it just means that you don't have the cache folder
			$this->application->getBootstrap()->bootstrap('Layout');
			
		} catch(Exception $e) {
			$this->logger->notify("ControllerTestCase", "Expcetion caught with::".$e->getMessage());
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::tearDown()
	 * @internal If you see an error in your tests that says cleanTableForTesting not found, just import it from utils folder...
	 */
	public function tearDown() {
		Zend_Controller_Front::getInstance()->resetInstance();
		$this->resetRequest();
		$this->resetResponse();
		$this->request->setPost(array());
		$this->request->setQuery(array());
		$this->dSet->cleanUp();
		$this->db->query('CALL cleanTableForTesting()');
	}

	/**
	 * Log in into our application
	 * @param string $user
	 * @param string $password
	 */
	public function login($user=null,$password=null) {
		$frontController = Zend_Controller_Front::getInstance();
		$frontController->setBaseUrl('apmgr.com');
		$postArgs = array('username' => $user,'password' => $password);
		$this->request->setMethod('POST')->setPost($postArgs);
		$this->dispatch('user/login/index');
        $auth = Zend_Auth::getInstance();
        if( $auth->hasIdentity() == false )
        {
        	$this->logger->notify("ControllerTestCase", "The user couldn't be authenticated");
        	throw new Exception('The user could not log in');
        }
        else
        {
        	$this->logger->notify("ControllerTestCase","User ${user} with password ${password} is authenticated");
        }
		//        $auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$this->resetRequest()->resetResponse();
	}

	/**
	 * Perform a logout from the system.
	 * This is the current functionality of the system, so if you aren't
	 * authenticated, you will receive an error
	 */
	public function logout()
	{
		$frontController = Zend_Controller_Front::getInstance();
		$frontController->setBaseUrl('apmgr.com');
		$this->dispatch('user/login/logout');
		$this->resetRequest()
		->resetResponse();
	}
}