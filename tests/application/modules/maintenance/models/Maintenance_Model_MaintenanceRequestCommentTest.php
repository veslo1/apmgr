<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Maintenance_Model_MaintenanceRequestCommentTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->loadData();
	$this->login('jvazquez', 'Test1234');
        $this->object = new Maintenance_Model_MaintenanceRequestComment();
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

    public function testGetUserId()
    {
    	
        $this->object->setUserId(1);
        $this->assertEquals(1,$this->object->getUserId());
    }

    public function testGetComment()
    {
    	
        $this->object->setComment('test');
        $this->assertEquals('test',$this->object->getComment());
    }

    public function testFetchRequestComment()
    {
    	
        $this->object->setMaintenanceRequestId(1);
        $results = $this->object->fetchRequestComment();
        $this->assertEquals(1, count($results));
    }

    private function loadData(){
	    $this->dataSetStackBuffer = array( 'users'=>1,					            					       					       
					       'apartmentsUnitsAndModels'=>1,
                                               'maintRequest'=>1
					      );	
	    $this->loadDataSets();        
    }
}
