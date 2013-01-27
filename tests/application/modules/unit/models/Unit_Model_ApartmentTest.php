<?php
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost

class Unit_Model_ApartmentTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Unit_Model_Apartment();
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
    	
        $name = 'test';
        $this->object->setName($name);
        $this->assertSame($name,$this->object->getName());
    }

    public function testGetAddressOne()
    {
    	
        $addressOne = 'addressOne';
        $this->object->setAddressOne($addressOne);
        $this->assertEquals($addressOne,$this->object->getAddressOne());
    }

    public function testGetAddressTwo()
    {
    	
        $addressTwo = 'addressTwo';
        $this->object->setAddressTwo($addressTwo);
        $this->assertEquals($addressTwo,$this->object->getAddressTwo());
    }

    public function testGetCity()
    {
    	
        $city = 'city';
        $this->object->setCity($city);
        $this->assertEquals($city,$this->object->getCity());
    }

    public function testGetState()
    {
    	
        $state = 'state';
        $this->object->setState($state);
        $this->assertEquals($state,$this->object->getState());
    }

    public function testGetZip()
    {
    	
        $zip = 12345;
        $this->object->setZip($zip);
        $this->assertEquals($zip,$this->object->getZip());
    }

    public function testGetCountry()
    {
    	
        $country = 'usa';
        $this->object->setCountry($country);
        $this->assertEquals($country,$this->object->getCountry());
    }

    public function testGetPhone()
    {
    	
        $phone = '555-555-5555';
        $this->object->setPhone($phone);
        $this->assertEquals($phone,$this->object->getPhone());
    }

    public function testApartmentSaveNone()
    {
    	
        $this->db->query('TRUNCATE apartment');

        $this->object->setName('test');
        $this->object->setAddressOne('test');
        $this->object->setAddressTwo('test');
        $this->object->setCity('test');
        $this->object->setState('TX');
        $this->object->setZip('test');
        $this->object->setCountry('test');
        $this->object->setPhone('test');

        $apt = $this->object->saveApartment();
        $this->assertEquals(1,$apt->getId());
        $this->assertEquals('test',$apt->getAddressOne());
    }

    public function testApartmentSaveExisting()
    {
    	
        $this->object->setName('test2');
        $this->object->setAddressOne('test2');
        $this->object->setAddressTwo('test2');
        $this->object->setCity('test2');
        $this->object->setState('OK');
        $this->object->setZip(12345);
        $this->object->setCountry('USA');
        $this->object->setPhone('5555555555');

        $apt = $this->object->saveApartment();
        $this->assertEquals(2,$apt->getId());
        $this->assertEquals('test2',$apt->getAddressOne());
    }
}
?>
