<?php
/**
 * Test class for Unit_Library_Reports_IncomingTenantsTest
 * Generated by PHPUnit on 2010-10-29 at 23:31:16.
 */
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/library/reports/Unit_Reports_IncomingTenantsTest.php
class Unit_Library_Reports_IncomingTenantsTest extends ControllerTestCase {

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->dataSetStackBuffer = array('incomingTenantsReport'=>1);
		$this->login('jvazquez','Test1234');
		$this->loadDataSets();
	}

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::tearDown()
	 */
	public function tearDown()
	{
		$this->unLoadDataSets();
		parent::tearDown();
	}

	public function testInitDb()
	{
		$object = new Unit_Library_Reports_IncomingTenants;
		$object->setGatewayLink(Unit_Library_Reports_IncomingTenants::DB);
		$db = $object->getGatewayLink();
		$this->assertType('Zend_Db_Adapter_Pdo_Mysql', $db);
	}

	public function testConfigureCache()
	{
		$object = new Unit_Library_Reports_IncomingTenants(array('cacheIdentifier'=>'incomingTenants'));
		$object->setCacheFrontEnd('Core');
		//			$object->setCacheBackEnd('Apc');
		$object->setCacheBackEnd('File');
		$object->configureCacheFrontEnd();
		$object->configureCacheBackEnd();
		$object->initCacheManager();
		$this->assertType('Zend_Cache_Manager',$object->getCacheManager());
	}
	
	public function testRunReportWithCache()
	{
		$object = new Unit_Library_Reports_IncomingTenants(array('cacheIdentifier'=>'incomingTenants'));
		$object->setCacheFrontEnd('Core');
		$object->setCacheBackEnd('File');
		$object->configureCacheFrontEnd();
		$object->configureCacheBackEnd();
		$object->initCacheManager();
		$object->prepareCacheSeed();
		$result = $object->runReport(true);
		$this->assertTrue(count($result)>0,'The query failed to obtain results');
		//	Since we did not seed the object, the tags will match
		$this->assertEquals(Unit_Library_Reports_IncomingTenants::DEFAULTSEED,$object->getSeed());
	}


	public function testQueryWithSort()
	{
		$args = array(ZFInterfaces_Sortable::MODE=>ZFInterfaces_Sortable::ASCVIEW,
		ZFInterfaces_Sortable::COLUMN=>'tenantName');
		$object = new Unit_Library_Reports_IncomingTenants($args);
		$result = $object->runReport(false);
		$this->assertTrue(preg_match('/ORDER BY tenantName ASC/',$object->getQuery())==1,$object->getQuery());
	}

	public function testHandleQueryParamsMultiple()
	{
		$args = array(ZFInterfaces_Sortable::MODE=>ZFInterfaces_Sortable::ASCVIEW,
		ZFInterfaces_Sortable::COLUMN=>'tenantName','page'=>2,
        			'cacheIdentifier'=>Unit_Library_Reports_IncomingTenants::CACHEIDENTIFIER);
		$object = new Unit_Library_Reports_IncomingTenants($args);
		$object->prepareCacheSeed();
		$this->assertEquals('incomingTenantsReportpage2tenantNameASC',$object->getSeed());
	}

	public function testHandleQueryParamsPagination()
	{
		$args = array('page'=>2);
		$object = new Unit_Library_Reports_IncomingTenants($args);
		$object->prepareCacheSeed();
		$this->assertEquals('incomingTenantsReportpage2',$object->getSeed());
	}

	public function testHandleQueryParamsBadPagination()
	{
		$args = array('fakee'=>2);
		$object = new Unit_Library_Reports_IncomingTenants($args);
		$object->prepareCacheSeed();
		$this->assertEquals('incomingTenantsReport',$object->getSeed());
		unset($object);
		$args = array('page'=>"x3");
		$object = new Unit_Library_Reports_IncomingTenants($args);
		$object->prepareCacheSeed();
		$this->assertEquals('incomingTenantsReport',$object->getSeed());
	}
/*
	public function testExportReportCreatesFile()
	{
		ob_start();
		$args = array(ZFInterfaces_Sortable::MODE=>ZFInterfaces_Sortable::ASCVIEW,ZFInterfaces_Sortable::COLUMN=>'tenantName','cacheIdentifier'=>'rentRoll');
		$object = new Financial_Library_Reports_RentRoll($args);
		$this->assertEquals($args['cacheIdentifier'],$object->getCacheIdentifier());
		$object->setCacheFrontEnd('Core');
		$object->setCacheBackEnd('File');
		$object->configureCacheFrontEnd();
                $object->configureCacheBackEnd();
                $object->initCacheManager();
                $object->prepareCacheSeed($args);
	        $result = $object->runReport(true);
		$result = $object->exportReport();
		$this->assertTrue($result,'Export report failed to generate a report');
		ob_end_clean();
	}
*/
}
?>