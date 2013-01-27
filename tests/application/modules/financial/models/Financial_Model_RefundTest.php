<?php
//  phpunit --config phpunit.xml --bootstrap application/bootstrap.php application/modules/financial/models/Financial_Model_RefundTest.php
//  mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost

/**
 *  Refund creation is pretty much tested through here.  Forfeit code should be exact same as refund so if it works here,
 *  forfeit code should also work
 */
class Financial_Model_RefundTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
	$this->loadData();
	$this->login('jvazquez', 'Test1234'); // sets the userId in the session
        $this->object = new Financial_Model_Refund();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown() {
//	$this->unLoadDataSets();
    	parent::tearDown();	
    }


    public function testGetBillId()
    {
    	
	$bill = 1;
        $this->object->setBillId( $bill );
        $this->assertEquals( $bill,$this->object->getBillId());
    }

    public function testGetFeeId()
    {
    	
	$fee = 4;
        $this->object->setFeeId( $fee );
        $this->assertEquals( $fee, $this->object->getFeeId());	
    }

    public function testGetRefundAmount()
    {
    	
	$amount = 10;
        $this->object->setAmount( $amount );
        $this->assertEquals( $amount,$this->object->getAmount());
    }
    
    public function testComment()
    {
    	
	$comment = 'blah';
        $this->object->setComment( $comment );
        $this->assertEquals( $comment, $this->object->getComment());	
    }


    /**
     *  Tests when fee is non refundable
     */
    public function testRefundNonRefundableFee()
    {
    	
        $this->object->setBillId( 6 );
	$this->object->setFeeId( 6 );  // non refundable fee
        $this->object->setAmount( 10 );

        $result = $this->object->refund();

        $this->assertEquals( false, $result );
    }

    /**
     *  Tests when refund amount is greater than the payments made
     */
    public function testRefundGreaterAmount()
    {
    	
        $this->object->setBillId( 7 );
	$this->object->setFeeId( 7 );
        $this->object->setAmount( 100 );  // refund amount > payment on this bill

        $result = $this->object->refund();

        $this->assertEquals( false, $result );
    }

    /**
     *  Tests refunding a fee that has already reached it's full refund amount
     */
    public function testAlreadyRefunded()
    {
    	
        $this->object->setBillId( 8 );
	$this->object->setFeeId( 8 );
        $this->object->setAmount( 10 );  // sum of refunds already = amount paid on bill so should return false

        $result = $this->object->refund();
        $this->assertEquals( false, $result );
    }

    /**
     *  Tests when a partial refund exists and the user pays more on top of it
     *  to make the total refunded amount > payments made
     */
    public function testRefundExistsGreaterAmount()
    {
    	
        $this->object->setBillId( 10 );
	$this->object->setFeeId( 10 );
        $this->object->setAmount( 30 );  // refund amount > payment on this bill
        $result = $this->object->refund();
        $this->assertEquals( false, $result );
   }

    /**
     *  Tests the pass scenario of a refund
     */
    
    public function testRefundPass()
    {
    	
        $this->object->setBillId( 9 );
	$this->object->setFeeId( 9 );
        $this->object->setAmount( 3 );

        $result = $this->object->refund();	
        $this->assertEquals( true, $result );	
    }
    

    /**
     *  Tests the pass scenario of a refund
     */
    
    public function testRefundPassAccountTransaction()
    {
    	
        $this->object->setBillId( 11 );
	$this->object->setFeeId( 11 );
        $this->object->setAmount( 3 );

        $result = $this->object->refund();	
	$this->assertEquals( true, $result );	
	
	if( $result ) {
	    $btObj = new Financial_Model_BillTransaction();
	    $billTransRow = array_shift($btObj->findByKey(array('search'=>array('billId'=>11))));
	    $this->assertNotNull( $billTransRow );

	    $atObj = new Financial_Model_AccountTransaction();
	    $acctTransRow = $atObj->findByKey(array('search'=>array('transactionId'=>$billTransRow->getTransactionId())));
	    $this->assertEquals( 2, count($acctTransRow) );

	    $sum = $this->object->getRefundSumByBillId();
	    $this->assertEquals( 1+3, $sum );
            $this->assertEquals( true, $result );
	}	
    }
    

    private function loadData(){
	$this->dataSetStackBuffer = array('users'=>1,
					  'accountsAndLinks'=>1,
					  'accountTransactions'=>1,
					  'depositsAndFees'=>1,
					  'bills'=>1,
					  'paymentDetails'=>1,
					  'payments'=>1,				
					  'refunds'=>1);	
	$this->loadDataSets();
    }
}
