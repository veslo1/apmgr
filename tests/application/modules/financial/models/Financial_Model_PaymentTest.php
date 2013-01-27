<?php
class Financial_Model_PaymentTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Financial_Model_Payment();
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
    	
        $this->object->setBillId( 1 );
        $this->assertEquals( 1,$this->object->getBillId());
    }

    public function testGetAmtPaid()
    {
    	
        $this->object->setAmtPaid( 111 );
        $this->assertEquals( 111,$this->object->getAmtPaid());
    }

    public function testGetTransactionId()
    {
    	
        $this->object->setTransactionId( 1 );
        $this->assertEquals( 1,$this->object->getTransactionId());
    }

    public function testGetPaymentDetailId()
    {
    	
        $this->object->setPaymentDetailId( 1 );
        $this->assertEquals( 1,$this->object->getPaymentDetailId());
    }

    /**
     * TODO need dataset
     */
    public function testGetFeeAndAccount()
    {
    	
       return false;
    }

     /**
     * TODO need dataset
     */
    public function testGetAccountLink()
    {
    	
       return false;
    }

    /**
     *  Needs data set
     */
    public function testPostPayment()
    {
    	
        return false;
    }

     /**
     *  Needs data set
     */
    public function testGatherPayments(){
        return false;
    }

     /**
     *  Needs data set
     */
    public function testSavePayment(){
        return false;
    }

     /**
     *  Needs data set
     */
    public function testGetPaymentSumByBillId(){
        return false;
    }
}