<?php
class Unit_Model_UnitModelTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();
		$this->loadData();
		$this->object = new Unit_Model_UnitModel();
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

	public function testGetName()
	{
		
		$this->object->setName('test');
		$this->assertEquals('test',$this->object->getName());
	}

	public function testGetSize()
	{
		
		$this->object->setSize(1000);
		$this->assertEquals(1000,$this->object->getSize());
	}

	public function testGetNumBeds()
	{
		
		$this->object->setNumBeds(2);
		$this->assertEquals(2,$this->object->getNumBeds());
	}

	public function testGetNumBaths()
	{
		
		$this->object->setNumBaths(2.5);
		$this->assertEquals(2.5,$this->object->getNumBaths());
	}

	public function testGetNumFloors()
	{
		
		$this->object->setNumFloors(1);
		$this->assertEquals(1,$this->object->getNumFloors());
	}

	public function testSaveUnitModel()
	{
		
		

		$this->object->setName('test2');
		$this->object->setSize(1);
		$this->object->setNumBeds(1);
		$this->object->setNumBaths(1);
		$this->object->setNumFloors(1);
		
		$amenities = array( '0'=>'3', '1'=>'4' );
		$id = $this->object->saveUnitModel( $amenities );

		$item = $this->object->findById( $id );

		$this->assertEquals( 'test2', $item->getName() );
		$this->assertEquals( 1, $item->getSize() );
		$this->assertEquals( 1, $item->getNumBeds() );
		$this->assertEquals( 1, $item->getNumBaths() );
		$this->assertEquals( 1, $item->getNumFloors() );
		//$this->assertEquals( 1, $item->getDepositId() );

		$uma = new Unit_Model_UnitModelAmenity();
		$amenityItem = $uma->findByKey( array('search'=>array( 'unitModelId'=>$id )) );
		//	$this->assertEquals( 2, count($amenityItem) );
	}

        private function loadData(){
	    $this->dataSetStackBuffer = array( 'unitModelAmenities'=>1,	);	
	    $this->loadDataSets();        
        }   
}
?>
