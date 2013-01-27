<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Unit_Model_ModelRentScheduleTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
	$this->loadData();
        $this->object = new Unit_Model_ModelRentSchedule();
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

    public function testGetUnitModelId()
    {
    	
        $this->object->setUnitModelId(1);
        $this->assertEquals(1,$this->object->getUnitModelId());
    }

    public function testGetEffectiveDate()
    {
    	
        $this->object->setEffectiveDate('2010-05-01');
        $this->assertEquals('2010-05-01',$this->object->getEffectiveDate());
    }


    // test various possibilities
    public function testGetLatestScheduleNoDate()
    {
    	       
        $this->object->setUnitModelId( 1 );
        $result = $this->object->getLatestSchedule();
        $this->assertEquals(1,count($result));
    }

    // test various possibilities
    public function testGetLatestScheduleWithDate()
    {
    	       
        $this->object->setUnitModelId( 1 );
        $this->object->setEffectiveDate( '2005-01-01' );
        $result = $this->object->getLatestSchedule();
        $this->assertEquals(1,count($result));
    }


    public function testGetSchedule()
    {
    	        
        $this->object->setId( 1 );
        $result = $this->object->getSchedule();
        $this->assertEquals(1,count($result));
    }
    
    private function loadData(){
	    $this->dataSetStackBuffer = array( 'users'=>1,					       
					       'accountsAndLinks'=>1,
					       'depositsAndFees'=>1,
					       'apartmentsUnitsAndModels'=>1,
					       'unitModelAmenities'=>1,
					       'bills'=>1,
					       'leases'=>1,
					     );	
	    $this->loadDataSets();        
    } 
   
}