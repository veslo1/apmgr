<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Unit_Model_ModelRentScheduleItemTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp()
    {
        parent::setUp();
        $this->object = new Unit_Model_ModelRentScheduleItem();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    }

    public function testGetModelRentScheduleId()
    {
    	
        $this->object->setModelRentScheduleId(1);
        $this->assertEquals(1,$this->object->getModelRentScheduleId());
    }

    public function testGetRentAmount()
    {
    	
        $this->object->setRentAmount(123);
        $this->assertEquals(123,$this->object->getRentAmount());
    }

    public function testGetNumMonths()
    {
    	
        $this->object->setNumMonths(1);
        $this->assertEquals(1,$this->object->getNumMonths());
    }
}