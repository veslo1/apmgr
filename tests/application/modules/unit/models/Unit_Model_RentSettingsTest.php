<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Unit_Model_RentSettingsTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Unit_Model_RentSettings();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    }

    public function testGetProrationEnabled()
    {
    	
        $this->object->setProrationEnabled(1);
        $this->assertEquals(1,$this->object->getProrationEnabled());
    }

    public function testGetProrationType()
    {
    	
        $this->object->setProrationType('thirtyday');
        $this->assertEquals('thirtyday',$this->object->getProrationType());
    }

    public function testGetProrationApplyMonth()
    {
    	
        $this->object->setProrationApplyMonth(1);
        $this->assertEquals(1,$this->object->getProrationApplyMonth());
    }

    public function testGetSecondMonthDue()
    {
    	
        $this->object->setSecondMonthDue(1);
        $this->assertEquals(1,$this->object->getSecondMonthDue());
    }
}