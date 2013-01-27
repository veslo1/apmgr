<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost
/**
 *
 * Enter description here ...
 * @author rnelson
 * @internal I fixed the method testGetStatusIdByName and the tearDown, this test was breaking the build
 */

class Maintenance_Model_MaintenanceStatusTest extends ControllerTestCase {

    protected $object;
    //protected $dSet;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Maintenance_Model_MaintenanceStatus();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    	$this->db->query("DELETE FROM maintenanceStatus WHERE `status`='test'");
    }

    public function testGetStatus()
    {
    	
        $this->object->setStatus('test');
        $this->assertEquals('test',$this->object->getStatus());
    }

    public function testGetStatusIdByName()
    {
    	
        $this->object->setStatus('test');
        $id = $this->object->save();
        $result = $this->object->getStatusIdByName('test');
        $this->assertEquals($id, $result,'Obtained '.$result);
    }
}
