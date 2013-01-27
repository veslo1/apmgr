<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Unit_Model_LeaseScheduleTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Unit_Model_LeaseSchedule();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    }

    public function testGetLeaseId()
    {
    	
        $this->object->setLeaseId(1);
        $this->assertEquals(1,$this->object->getLeaseId());
    }

    public function testGetBillId()
    {
    	
        $this->object->setBillId(1);
        $this->assertEquals(1,$this->object->getBillId());
    }

    public function testGetMonth()
    {
    	
        $this->object->setMonth('2010-05-01');
        $this->assertEquals('2010-05-01',$this->object->getMonth());
    }

    public function testGetDiscount()
    {
    	
        $this->object->setDiscount(10);
        $this->assertEquals(10,$this->object->getDiscount());
    }
}