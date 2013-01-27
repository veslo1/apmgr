<?php
class Unit_Model_UnitMetadataTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();
		$options = array('id'=>1,'unitId'=>1,'path'=>'/public/metadata/apartment1/units/1/foo.jpg','size'=>'10000','description'=>'This is a test description');
		//        $this->object = new Unit_Model_UnitMetadata($options);TODO This object doesn't exists
	}

	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#tearDown()
	 */
	public function tearDown()
	{
		parent::tearDown();
	}

	public function testSetUnitId()
	{
		$this->markTestSkipped("The object on this tests doesn't exists no more");
		
		$this->assertEquals(1, $this->object->getUnitId());
	}

	public function testGetUnitId()
	{
		$this->markTestSkipped("The object on this tests doesn't exists no more");
		$this->object->setUnitId(2);
		$this->assertEquals(2,$this->object->getUnitId());
	}

	public function testSetPath()
	{
		$this->markTestSkipped("The object on this tests doesn't exists no more");
		$this->assertEquals($this->object->getPath(),'/public/metadata/apartment1/units/1/foo.jpg');
	}

	public function testGetPath()
	{
		$this->markTestSkipped("The object on this tests doesn't exists no more");
		$this->object->setPath('/public/metadata/apartment1/units/1/foo2.jpg');
		$this->assertEquals($this->object->getPath(),'/public/metadata/apartment1/units/1/foo2.jpg');
	}

	public function testSetSize()
	{
		$this->markTestSkipped("The object on this tests doesn't exists no more");
		$this->assertEquals(10000,$this->object->getSize());
	}

	public function testGetSize()
	{
		$this->markTestSkipped("The object on this tests doesn't exists no more");
		$this->object->setSize(20000);
		$this->assertEquals(20000,$this->object->getSize());
	}

	public function testSetDescription()
	{
		$this->markTestSkipped("The object on this tests doesn't exists no more");
		$this->assertEquals('This is a test description',$this->object->getDescription());
	}

	public function testGetDescription()
	{
		$this->markTestSkipped("The object on this tests doesn't exists no more");
		$this->object->setDescription('This is a dummy description');
		$this->assertEquals('This is a dummy description',$this->object->getDescription());
	}

	public function testMoveFile()
	{
		$this->markTestSkipped("The object on this tests doesn't exists no more");
		$zfFile = new ZFFile_File(array('size'=>400,'name'=>'foo','type'=>'octet-stream'));
		//TODO add the code here
	}
}