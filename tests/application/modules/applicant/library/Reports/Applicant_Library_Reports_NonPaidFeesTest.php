<?php

class Applicant_Library_Reports_NonPaidFeesTest extends ControllerTestCase
{
    /* (non-PHPdoc)
     * @see Framework/PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
    	parent::setUp();
    	$this->dataSetStackBuffer = array('applicantReport'=>1);
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

    public function testRunReport()
    {
    	$args = array('dateFrom'=>'2010-01-01','dateTo'=>'2010-11-01');
		$report = new Applicant_Library_Reports_NonPaidFees($args);
		$report->init();
		$result = $report->runReport(false);
		$this->assertTrue( is_array($result) ,'General failure' );
    }
}
?>
