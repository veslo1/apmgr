<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Unit_Model_TenantTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
	$this->loadData();
        $this->object = new Unit_Model_Tenant();
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

    public function testGetUserId()
    {
    	
        $this->object->setUserId(1);
        $this->assertEquals(1,$this->object->getUserId());
    }

    public function testGetLeaseId()
    {
    	
        $this->object->setLeaseId(1);
        $this->assertEquals(1,$this->object->getLeaseId());
    }

    // Need data set
    public function testGetTenants()
    {
    	       
        $this->object->setLeaseId( 10 );
        $results = $this->object->getTenants();
        $this->assertEquals(2,count($results));
        //var_dump($results);
        $this->assertEquals(10,$results[0]['userId']);
        $this->assertEquals(trim('bill'),trim($results[0]['firstName']));
        $this->assertEquals(trim('johnson'),trim($results[0]['lastName']));
    }

    private function loadData(){
	    $this->dataSetStackBuffer = array( 'users'=>1,					       
					       'accountsAndLinks'=>1,
					       'depositsAndFees'=>1,
					       'apartmentsUnitsAndModels'=>1,
					       'bills'=>1,
					       'leases'=>1,
					       'tenants'=>1,
					     );	
	    $this->loadDataSets();        
    }
}