<?php
class Unit_Model_UnitAmenityTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();
		$this->loadData();
		$this->object = new Unit_Model_UnitModelAmenity();
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

	public function testGetUnitModelId()
	{
		
		$this->object->setUnitModelId(1);
		$this->assertEquals(1,$this->object->getUnitModelId());
	}

	public function testGetAmenityId()
	{
		
		$this->object->setAmenityId(1);
		$this->assertEquals(1,$this->object->getAmenityId());
	}

	public function testSaveAndGetAmenities()
	{
				

		$amenities = array( '0'=>'3', '1'=>'4' );
		$this->object->setUnitModelId( 1 );
		$this->object->saveAmenities( $amenities );
		$results = $this->object->getUnitModelAmenities();

		$this->assertEquals( true, array_key_exists( 3, $results ) );
		$this->assertEquals( true, array_key_exists( 4, $results ) );
	}
		
	private function loadData(){
	    $this->dataSetStackBuffer = array( 'users'=>1,					       
					       'accountsAndLinks'=>1,
					       'depositsAndFees'=>1,
					       'apartmentsUnitsAndModels'=>1,
					       'unitModelAmenities'=>1,
					     );	
	    $this->loadDataSets();        
        } 
}
?>