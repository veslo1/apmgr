<?php
class Financial_Model_PaymentDetailTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Financial_Model_PaymentDetail();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown()
    {
    	parent::tearDown();
    }

    public function testGetPayor()
    {
    	
        $this->object->setPayor( 'Bill Smith' );
        $this->assertEquals( 'Bill Smith', $this->object->getPayor());
    }

    public function testGetPaymentType()
    {
    	
        $this->object->setPaymentType( 'cash' );
        $this->assertEquals( 'cash',$this->object->getPaymentType());
    }

    public function testGetTotalAmount()
    {
    	
        $this->object->setTotalAmount( 100.13 );
        $this->assertEquals( 100.13,$this->object->getTotalAmount());
    }
}