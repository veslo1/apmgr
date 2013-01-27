<?php
class Permission_Model_PermissionTest extends ControllerTestCase {

	protected $object;
	//protected $dSet;
	/**
	* (non-PHPdoc)
	* @see tests/application/ControllerTestCase#setUp()
	*/
	public function setUp() {
		parent::setUp();
		$this->object = new Permission_Model_Permission();
		//	$this->dSet = new DatabaseFlatXmlSeed();
	}

	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#tearDown()
	 */
	public function tearDown()
	{
		parent::tearDown();
	}

	public function testFetchControllersByModuleId()
	{
		
		$this->object->setModuleId(2);  // calendar
		$result = $this->object->fetchControllersByModuleId();
		$this->assertEquals(5,count($result));
	}

	public function testFetchActionsByControllerModule()
	{
		
		$this->object->setModuleId(2);  // calendar
		$this->object->setControllerId(1);
		$result = $this->object->fetchActionsByControllerModule();
		$this->assertEquals(1,count($result));
	}
}
?>
