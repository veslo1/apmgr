<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Unit_Model_CreateModelRentScheduleTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->loadData();
		$this->object = new Unit_Model_CreateModelRentSchedule();
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

	// Getters are private so not possible to test them

	/**
	 *  Test saving of model schedule and items
	 */
	public function testSaveRentSchedule()
	{
			
		$this->object->setEffectiveDate( '2010-01-01' );
		$this->object->setUnitModelId( 1 );
		$this->object->setRentAmount( array( '0'=>'200', '1'=>'500', '2'=>'800' ) );
		$this->object->setNumMonths( array( '0'=>'1', '1'=>'3', '2'=>'6' ) );
		$id = $this->object->saveRentSchedule();

		$rs = new Unit_Model_ModelRentSchedule();
		$rs->setId( $id );
		$result = $rs->getSchedule();

		$this->assertEquals(3,count($result));
		$this->assertEquals(1, $result[0]['unitModelId']);
		$this->assertEquals('2010-01-01 00:00:00', $result[0]['effectiveDate']);
		$this->assertEquals(200, $result[0]['rentAmount']);
		$this->assertEquals(1, $result[0]['numMonths']);
	}
	
	private function loadData(){
	    $this->dataSetStackBuffer = array( 'apartmentsUnitsAndModels'=>1 );	
	    $this->loadDataSets();        
        }

}
