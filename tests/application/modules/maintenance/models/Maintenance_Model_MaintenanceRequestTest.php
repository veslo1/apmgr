<?php

// 	phpunit --configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Maintenance_Model_MaintenanceRequestTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp()
    {
        parent::setUp();
        $this->object = new Maintenance_Model_MaintenanceRequest();
        $this->loadData();
	$this->login('jvazquez', 'Test1234');
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown() {
        $this->unLoadDataSets();
        parent::tearDown();
    }

    public function testGetUnitId()
    {
    	
        $this->object->setUnitId(1);
        $this->assertEquals(1,$this->object->getUnitId());
    }

    public function testGetRequestorId()
    {
    	
        $this->object->setRequestorId(1);
        $this->assertEquals(1,$this->object->getRequestorId());
    }

    public function testGetTitle()
    {
    	
        $this->object->setTitle(1);
        $this->assertEquals(1,$this->object->getTitle());
    }

    public function testGetDescription()
    {
    	
        $this->object->setDescription(1);
        $this->assertEquals(1,$this->object->getDescription());
    }

    public function testGetPermissionToEnter()
    {
    	
        $this->object->setPermissionToEnter(1);
        $this->assertEquals(1,$this->object->getPermissionToEnter());
    }

    public function testGetMineOnly()
    {
    	
        $this->object->setMineOnly(1);
        $this->assertEquals(1,$this->object->getMineOnly());
    }

    /**
     *  Tests fetch request with isMine
     */
    public function testFetchRequestMine()
    {
    	
        $this->object->setId(1);
        $this->object->setRequestorId(1);
        $this->object->setUserId(1);
        $this->object->setMineOnly(1);
        $request = $this->object->fetchRequest();
        $this->assertEquals(true,isset($request));
    }

    /**
     *  Need to evaluate the query to see if it is correct.
     */
    public function testFetchAllRequests(){
        $requests = $this->object->fetchAllRequests();
        $this->assertEquals(2,count($requests));
    }


    public function testFetchAssignedRequests(){
        $this->object->setUserId(1);
        $requests = $this->object->fetchAssignedRequests();
        $this->assertEquals(2,count($requests));
    }

    public function testFetchMyRequests(){
        $this->object->setRequestorId(1);
        $result = $this->object->fetchMyRequests();
        $this->assertEquals(2,count($result));
    }

    public function testFetchRequestAndComment(){
        $this->object->setId(1);
        $result = $this->object->fetchRequestAndComment();
        $this->assertEquals(true,isset($result['request']));
        $this->assertEquals(true,isset($result['comment']));
    }

    public function testFetchRequest(){
        $this->object->setId(1);
        $result = $this->object->fetchRequest();
        $this->assertEquals(true,isset($result));
    }

    /*  The user id is set internally on the maintenance status object so it isn't possible to test this
        easily  because the object is instantiated inside the save function.  Moding function to allow pass in of userId
        so this can be tested */

    public function testSaveNewMaintenanceRequest(){
        $this->object->setTitle('test');
        $this->object->setDescription('testDesc');
        $this->object->setPermissionToEnter(1);
        $this->object->setRequestorId(1);
        $this->object->setUnitId(1);
        $this->object->setUserId(2);
        $id = $this->object->saveNewMaintenanceRequest();
        $this->assertEquals(1,count($this->object->findById($id)));
    }

     private function loadData(){
	    $this->dataSetStackBuffer = array( 'users'=>1,					            					       					       
					       'apartmentsUnitsAndModels'=>1,
                                               'maintRequest'=>1
					      );	
	    $this->loadDataSets();        
    }

}
