<?php
class Financial_Model_AccountTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Financial_Model_Account();
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

    public function testGetNumber()
    {
    	
        $this->object->setNumber('1234');
        $this->assertEquals('1234',$this->object->getNumber());
    }

    public function testGetOrientation()
    {
    	
        $this->object->setOrientation('debit');
        $this->assertEquals('debit',$this->object->getOrientation());
    }

}