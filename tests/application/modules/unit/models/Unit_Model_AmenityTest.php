<?php
//  phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_AmenityTest.php
class Unit_Model_AmenityTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Unit_Model_Amenity();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    }

    public function testGetName()
    {
    	
        $this->object->setName('test');
        $this->assertEquals('test',$this->object->getName());
    }
    
    // tests saving non duplicate
    public function testSaveAmenity()
    {
    	
        $this->object->setName('test');
 	$id = $this->object->saveAmenity(); // save amenity and return the id
        $this->assertNotEquals(false,$id);
    }
    
    // tests saving duplicate
    public function testSaveAmenityDuplicate()
    {
    	
	$this->db->query('DELETE FROM amenity');
	
	$this->object->setName('test');
 	$id = $this->object->saveAmenity(); // save amenity and return the id
        $this->assertNotEquals(false,$id);
	
        $this->object->setName('test');
 	$id = $this->object->saveAmenity(); // save amenity and return the id
        $this->assertEquals(false,$id);
    }
}
?>