<?php
// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_UnitTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Unit_Model_UnitTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();
		$this->loadData();
		$this->object = new Unit_Model_Unit();
	}

	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#tearDown()
	 */
	public function tearDown()
	{
		$this->unLoadDataSets();
		parent::tearDown();
	}

	public function testGetApartment()
	{
		
		$this->object->setApartment('test');
		$this->assertEquals('test',$this->object->getApartment());
	}

	public function testGetApartmentId()
	{
		
		$this->object->setApartmentId(1);
		$this->assertEquals(1,$this->object->getApartmentId());
	}

	public function testGetNumber()
	{
		
		$this->object->setNumber('123A');
		$this->assertEquals('123A',$this->object->getNumber());
	}

	public function testGetUnitModel()
	{
		
		$this->object->setUnitModel('test');
		$this->assertEquals('test',$this->object->getUnitModel());
	}

	public function testGetUnitModelId()
	{
		
		$this->object->setUnitModelId(1);
		$this->assertEquals(1,$this->object->getUnitModelId());
	}

	public function testGetIsAvailable()
	{
		
		$this->object->setIsAvailable(1);
		$this->assertEquals(1,$this->object->getIsAvailable());
	}

	public function testGetIsAvailableStringYes()
	{
		
		$this->object->setIsAvailable(1);
		$this->assertEquals('Yes',$this->object->getIsAvailableString());
	}

	public function testGetIsAvailableStringNo()
	{
		
		$this->object->setIsAvailable(0);
		$this->assertEquals('No',$this->object->getIsAvailableString());
	}

	public function testGetYearBuilt()
	{
		
		$this->object->setYearBuilt(2005);
		$this->assertEquals(2005,$this->object->getYearBuilt());
	}

	public function testGetYearRenovated()
	{
		
		$this->object->setYearRenovated(2006);
		$this->assertEquals(2006,$this->object->getYearRenovated());
	}

	// need dataset
	// test the possibilities
	public function testBulkSave()
	{
		
		$this->db->query('DELETE FROM unit');

		$this->object->setApartmentId(1);
		$this->object->setNumber(1);
		$this->object->setUnitModelId(1);
		$this->object->setIsAvailable(1);
		$this->object->setYearBuilt(2000);
		$this->object->setYearRenovated(2000);
                $this->object->setDateAvailable('2010-05-01');

		$result = $this->object->bulkSave(5);  // create 5 units		
		$this->assertEquals(true,$result);

		$rows = $this->object->fetchAll();

		$this->assertEquals(5,count($rows));
		$this->assertEquals(1,$rows[0]->getApartmentId());
		$this->assertEquals(1,$rows[0]->getNumber());
		$this->assertEquals(2,$rows[1]->getNumber());
		$this->assertEquals(1,$rows[0]->getUnitModelId());
		$this->assertEquals(1,$rows[0]->getIsAvailable());
		$this->assertEquals(2000,$rows[0]->getYearBuilt());
		$this->assertEquals(2000,$rows[0]->getYearRenovated());
	}

	public function testBulkSaveValidation()
	{
		
		$this->db->query('DELETE FROM unit');
		//$this->object->setApartmentId(1);
		$this->object->setNumber(1001);  // should exist from previous test
		$this->object->setUnitModelId(1);
		$this->object->setIsAvailable(1);
		$this->object->setYearBuilt(2000);
		$this->object->setYearRenovated(2000);
		$this->object->setDateAvailable('2010-05-01');
		$result = $this->object->bulkSave(1);  // create 1 unit

		//$this->object->setApartmentId(1);
		$this->object->setNumber(1001);  // should exist from previous test
		$this->object->setUnitModelId(1);
		$this->object->setIsAvailable(1);
		$this->object->setYearBuilt(2000);
		$this->object->setYearRenovated(2000);

		$result = $this->object->bulkSave(5);  // create 5 units
		$this->assertEquals(false,$result);
	}

	// need dataset
	// test the possibilities
	public function testSingleSave()
	{
		
		$this->db->query('TRUNCATE unit');

		$this->object->setApartmentId(1);
		$this->object->setNumber('ABC');
		$this->object->setUnitModelId(1);
		$this->object->setIsAvailable(1);
		$this->object->setYearBuilt(2000);
		$this->object->setYearRenovated(2000);
		$this->object->setDateAvailable('2010-05-01');

		$result = $this->object->singleSave();
		$this->assertEquals(true,$result);

		$rows = $this->object->fetchAll();

		$this->assertEquals(1,count($rows));
		$this->assertEquals(1,$rows[0]->getApartmentId());
		$this->assertEquals('ABC',$rows[0]->getNumber());
		$this->assertEquals(1,$rows[0]->getUnitModelId());
		$this->assertEquals(1,$rows[0]->getIsAvailable());
		$this->assertEquals(2000,$rows[0]->getYearBuilt());
		$this->assertEquals(2000,$rows[0]->getYearRenovated());
	}

	/**
	 *  Tests check number for single unit creation
	 */
	public function testCheckNumber()
	{
		
		$this->object->setApartmentId(1);
		$this->object->setNumber('ABC');
		$this->object->setUnitModelId(1);
		$this->object->setIsAvailable(1);
		$this->object->setYearBuilt(2000);
		$this->object->setYearRenovated(2000);

		$result = $this->object->checkNumber(); // abc - loaded from file
		$this->assertEquals(false,$result);
	}

	// TODO: test the alpha sort.  The sorting is still in flux so that can be tested once the alpha sort is better
	public function testGetApartmentUnits()
	{
		
		$this->object->setApartmentId(1);
		$result = $this->object->getApartmentUnits();
		//var_dump( $result );
		$this->assertGreaterThan(5,count($result));
		$this->markTestIncomplete(
                    'Unit number sorting:  This test has not been implemented yet.'
                    );
	}
	
	// tests saving without an apartment id - should return false
	public function testSaveNoApartment()
	{
		
		$this->db->query('TRUNCATE unit');
		$this->db->query('TRUNCATE apartment');
		
		$this->object->setNumber('ABC');
		$this->object->setUnitModelId(1);		
		$this->object->setYearBuilt(2000);
		$this->object->setYearRenovated(2000);

		$result = $this->object->singleSave();
		$this->assertEquals(false,$result);	
	}
	
	// tests saving without a date but with isAvailable set
	public function testSaveNoDateAvailable()
	{
		
		$this->db->query('TRUNCATE unit');		
		
		$this->object->setNumber('ABC');
		$this->object->setUnitModelId(1);
		$this->object->setIsAvailable(1);
		$this->object->setYearBuilt(2000);
		$this->object->setYearRenovated(2000);

		$result = $this->object->singleSave();
		$this->assertEquals(false,$result);	
	}

	// need dataset
	// find where this method is used.  Might need to refactor a tad
	public function testGetUnit()
	{
		
		$this->object->setId(1);
		$results=$this->object->getUnit();
		$this->assertEquals( 1,$results->getId() );
		$this->assertEquals( 1,$results->getUnitModel()->getId() );
		$this->assertEquals( 1,$results->getApartment()->getId() );
	}

	private function loadData(){
		$this->dataSetStackBuffer = array(
					       'apartmentsUnitsAndModels'=>1,					       
		);
		$this->loadDataSets();
	}
}
?>
