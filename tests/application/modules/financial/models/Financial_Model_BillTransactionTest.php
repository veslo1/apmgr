<?php
class Financial_Model_BillTransactionTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Financial_Model_BillTransaction();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    }

    public function testGetBillId()
    {
    	
        $this->object->setBillId(1);
        $this->assertEquals( 1,$this->object->getBillId());
    }

    public function testGetTransactionId()
    {
    	
        $this->object->setTransactionId(1);
        $this->assertEquals( 1,$this->object->getTransactionId());
    }
}