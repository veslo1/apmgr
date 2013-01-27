<?php
/**
 * Test class for ZFInterfaces_Sortable.
 * Generated by PHPUnit on 2010-11-13 at 02:54:14.
 */
class ZFInterfaces_SortableTest extends ControllerTestCase
{
	/**
	 * @var ZFInterfaces_Sortable
	 */
	protected $object;

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->object = new ZFDb_SortHelper();
	}

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::tearDown()
	 */
	public function tearDown()
	{
		parent::tearDown();
	}

	public function testSetMode()
	{
		$this->object->setMode(ZFInterfaces_Sortable::ASCVIEW);
		$this->assertEquals($this->object->getMode(),ZFInterfaces_Sortable::ASCVIEW);
	}

	public function testGetMode()
	{
		$this->object->setMode(ZFInterfaces_Sortable::ASCVIEW);
		$this->assertEquals($this->object->getMode(),ZFInterfaces_Sortable::ASCVIEW);
	}

	public function testSetBy()
	{
		$this->object->setBy('fake');
    	$this->assertEquals($this->object->getBy(),'fake');
	}

	public function testGetBy()
	{
		$this->object->setBy('fake');
    	$this->assertEquals($this->object->getBy(),'fake');
	}

	public function testSetValidColumn()
	{
		$columns = array('aColumn','bColumn','cColumn');
		$this->object->setValidColumn($columns);
		$this->assertEquals($columns, $this->object->getValidColumns());
	}

	public function testGetValidColumns()
	{
		$columns = array('aColumn','bColumn','cColumn');
		$this->object->setValidColumn($columns);
		$this->assertEquals($columns, $this->object->getValidColumns());
	}

	public function testIsSorting()
	{
		$columns = array('aColumn','bColumn','cColumn');
		$this->object->setMode(ZFInterfaces_Sortable::ASCVIEW);
		$this->object->setBy('aColumn');
		$this->object->setValidColumn($columns);
		$this->assertTrue($this->object->isSorting());
	}

	public function testIsSortingReturnsFalseDueToInvalidMode()
	{
		$columns = array('aColumn','bColumn','cColumn');
		$this->object->setMode('xxxx');
		$this->object->setBy('aColumn');
		$this->object->setValidColumn($columns);
		$this->assertFalse($this->object->isSorting());
	}

	public function testIsSortingReturnsFalseDueToUnknownColumn()
	{
		$columns = array('aColumn','bColumn','cColumn');
		$this->object->setMode('xxxx');
		$this->object->setBy('dColumn');
		$this->object->setValidColumn($columns);
		$this->assertFalse($this->object->isSorting());
	}

	public function testPrepareOrderQuery()
	{
		$columns = array('aColumn','bColumn','cColumn');
		$this->object->setMode(ZFInterfaces_Sortable::ASCVIEW);
		$this->object->setBy('aColumn');
		$this->object->setValidColumn($columns);
		$sorting = $this->object->isSorting();
		$order = $this->object->prepareOrderQuery();
		$this->assertEquals('aColumn ASC',$order);
	}
}
?>
