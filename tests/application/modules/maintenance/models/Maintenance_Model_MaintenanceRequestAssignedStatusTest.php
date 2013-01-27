<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/maintenance/models/Maintenance_Model_MaintenanceRequestAssignedStatusTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Maintenance_Model_MaintenanceRequestAssignedStatusTest extends ControllerTestCase {

        protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();		
                $this->loadData();
		$this->login('jvazquez', 'Test1234');
		$this->object = new Maintenance_Model_MaintenanceRequestAssignedStatus();
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
	public function testGetMaintenanceRequestId()
	{
		
		$this->object->setMaintenanceRequestId(1);
		$this->assertEquals(1,$this->object->getMaintenanceRequestId());
	}

	public function testGetMaintenanceStatusId()
	{
		
		$this->object->setMaintenanceStatusId(1);
		$this->assertEquals(1,$this->object->getMaintenanceStatusId());
	}

	public function testGetUserId()
	{
		
		$this->object->setUserId(1);
		$this->assertEquals(1,$this->object->getUserId());
	}

	public function testGetAssignedTo()
	{
		
		$this->object->setAssignedTo(1);
		$this->assertEquals(1,$this->object->getAssignedTo());
	}

	public function testGetCurrentStatus()
	{
		
		$this->object->setCurrentStatus(1);
		$this->assertEquals(1,$this->object->getCurrentStatus());
	}

	public function testGetCurrentRow(){		
		$this->object->setMaintenanceRequestId(1);
		$results = $this->object->getCurrentRow();
		$this->assertEquals(1,$results['id']);
	}

	/**
	 *  Creates two records.  The second record should set to current
	 */
	public function testSaveRecord()
	{
		
		
		$this->object->setUserId(1);
		$this->object->setMaintenanceRequestId(1);
		$this->object->setMaintenanceStatusId(3);
		$this->object->setAssignedTo(2);
		$id = $this->object->saveRecord();
		$this->assertGreaterThan(0,$id);  // tests save

		$this->object->setMaintenanceStatusId(1);
		$this->object->setAssignedTo(1);
		$id2= $this->object->saveRecord();
		$this->assertGreaterThan(0,$id);  // tests save  

		$results = $this->object->getCurrentRow();
		$this->assertEquals($id2,$results['id']); // tests that second is set to currentStatus
		$this->assertEquals(1,$results['currentStatus']); // tests that second is set to currentStatus
	}

        private function loadData(){
	    $this->dataSetStackBuffer = array( 'users'=>1,					            					       			'apartmentsUnitsAndModels'=>1,
                                               'maintRequest'=>1
					      );	
	    $this->loadDataSets();        
    }
}
