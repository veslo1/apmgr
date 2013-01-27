<?php
/**
 * Test class for ZFReport_Library_DbHelper.
 * Generated by PHPUnit on 2010-11-03 at 20:02:48.
 */
class ZFReport_Library_DbHelperTest extends ControllerTestCase
{
    /**
     * @var ZFReport_Library_DbHelper
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
    	parent::setUp();
        $this->object = new ZFReport_Library_DbHelper;
        $this->dataSetStackBuffer = array('rentRoll'=>1);
    	$this->loadDataSets();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
    	$this->unLoadDataSets();
    	parent::tearDown();
    }

    public function testRetrieveFinancialReports() {
    	$module='financial';
    	$info = $this->object->getReport($module);
//    	$this->assertType('array', $info);
		$this->assertInternalType('array', $info);
    	$countInfo = count($info);
    	$this->assertGreaterThanOrEqual(0, $countInfo);
    	$this->assertTrue(array_key_exists('urlPath',array_shift($info)),'We did not find the urlPath');
    }

    public function testRetrieveRentRollData(){
    	$reportName = 'rentroll';
    	$info = $this->object->getReportData($reportName);
    	$this->assertTrue(count($info)>0,'Report data should be greater than 0');
    	$this->assertEquals($info['cacheIdentifier'],'rentRoll',array_keys($info));
    }
    
    public function testFetchAllRetrievesArray()
    {
    	$data = $this->object->fetchAll();
    	$this->assertGreaterThan(0, count($data),'Count should return greater than 0');
    }
}
?>