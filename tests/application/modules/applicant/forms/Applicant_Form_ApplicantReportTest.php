<?php
class Applicant_Form_ApplicantReportTest extends ControllerTestCase
{
	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->object = new Applicant_Form_ApplicantReport;
	}

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::tearDown()
	 */
	public function tearDown()
	{
		parent::tearDown();
	}

	public function testInvalidDateFails()
	{
		$this->object->setForm();
		$args = array('dateTo'=>'foo','dateFrom'=>null);
		$this->object->populate($args);
		$result = $this->object->isValid($args);
		$this->assertFalse($result,'Form should indicate false');
	}

	public function testInvalidDateFormat()
	{
		$this->object->setForm();
		$args = array('dateTo'=>'11-','dateFrom'=>'zaboo');
		$this->object->populate($args);
		$result = $this->object->isValid($args);
		$this->assertFalse($result,'Form should indicate false');
	}

	public function testInvalidDateFormatSingle()
	{
		$this->object->setForm();
		$args = array('dateTo'=>'11-');
		$this->object->populate($args);
		$result = $this->object->isValid($args);
		$this->assertFalse($result,'Form should indicate false');
	}

	public function testPassDateSingle()
	{
		$this->object->setForm();
		$args = array('dateTo'=>'2010-01-01');
		$this->object->populate($args);
		$result = $this->object->isValid($args);
		$this->assertTrue($result,'Form should indicate false');
	}

	public function testDateFromEarlierDateToFails()
	{
		$this->object->setForm();
		$args = array('dateTo'=>'2009-01-01','dateFrom'=>'2010-01-01');
		$this->object->populate($args);
		$result = $this->object->isValid($args);
		$this->assertFalse($result,'Date to is earlier than Date From');
	}
	
	public function testDateFromDateToValidRangePass()
	{
		$this->object->setForm();
		$args = array('dateTo'=>'2010-01-01','dateFrom'=>'2009-01-01');
		$this->object->populate($args);
		$result = $this->object->isValid($args);
		$this->assertTrue($result,'Date to is earlier than Date From');
	}
}
?>
