<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Maintenance_Model_MaintenanceSettingsTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->loadData();
	$this->login('jvazquez', 'Test1234');
        $this->object = new Maintenance_Model_MaintenanceSettings();
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

    public function testGetRoleId()
    {
    	
        $this->object->setRoleId(1);
        $this->assertEquals(1,$this->object->getRoleId());
    }

    public function testGetDefaultAssignedTo()
    {
    	
        $this->object->setDefaultAssignedTo(2);
        $this->assertEquals(2,$this->object->getDefaultAssignedTo());
    }

    public function testGetSetting()
    {
    	
        $setting = $this->object->getSetting();
        $this->assertEquals(2,$setting->getDefaultAssignedTo());
    }

   private function loadData(){
	    $this->dataSetStackBuffer = array( 'users'=>1,					            					       					       
					       'apartmentsUnitsAndModels'=>1,
                                               'maintRequest'=>1
					      );	
	    $this->loadDataSets();        
    }
}
