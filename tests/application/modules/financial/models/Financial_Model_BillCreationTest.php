<?php
/**
 *  This particular unit test may take a bit longer in case the model/controller is refactored a bit.
 */
class Financial_Model_BillCreationTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
     //   $this->dSet->loadDataSet(APPLICATION_FAKESETS.'/users.xml');
//	$this->dSet->loadDataSet(APPLICATION_FAKESETS.'/accountsAndLinks.xml');

        $this->loadData();
        $this->login('jvazquez', 'Test1234'); // sets the userId in the session
        $this->object = new Financial_Model_BillCreation();
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

    /**
     *  Create bill without discounts
     */
    public function testCreateBillNoDiscount()
    {
    	     

        $accountLinkObj = new Financial_Model_AccountLink();
        $accountLinkObj->setCreditAccountId(1);
        $accountLinkObj->setDebitAccountId(2);

        $this->object->setDueDate('2010-05-01');
        $this->object->setBillAmountDue(100);
        $this->object->setAccountLink( $accountLinkObj );
        $billId = $this->object->createBill();

        $billObj = new Financial_Model_Bill();
        $billItem = $billObj->findById( $billId );

        // Test billTransaction table
        $billTransObj = new Financial_Model_BillTransaction();
        $billTransItems = $billTransObj->findByKey( array('search'=>array('billId'=>$billId) ));

        // Test transaction table
        $transObj = new Financial_Model_Transaction();
        $transItems = $transObj->findById( $billTransItems[0]->getTransactionId() );
        $this->assertEquals( 1, count($transItems));

        // accountTransaction table
        $acctTransObj = new Financial_Model_AccountTransaction();
        $acctTransItems = $acctTransObj->findByKey( array('search'=>array('transactionId'=>$billTransItems[0]->getTransactionId() ) ));

        //var_dump( $acctTransItems[0] );
        $this->assertEquals( 2, count($acctTransItems));
        $this->assertEquals( 100, $acctTransItems[0]->getAmount());
        $this->assertEquals( '2010-05-01 00:00:00', $acctTransItems[0]->getDatePosted());
        $this->assertEquals( 'debit', $acctTransItems[0]->getSide());
        $this->assertEquals( 2, $acctTransItems[0]->getAccountId());

        // Test bill table
        $this->assertEquals( 100, $billItem->getOriginalAmountDue());
        $this->assertEquals( '2010-05-01', $billItem->getDueDate());
        $this->assertEquals( 1, count($billTransItems));
    }

    /**
     *  Create bill with discounts
     */

    public function testCreateBillDiscount()
    {
    	     

        $accountLinkObj = new Financial_Model_AccountLink();
        $accountLinkObj->setCreditAccountId(1);
        $accountLinkObj->setDebitAccountId(2);

        $discount = 15;

        $this->object->setDueDate('2010-05-01');
        $this->object->setBillAmountDue(100);
        $this->object->setAccountLink( $accountLinkObj );

        $accountLinkObj->setCreditAccountId(2);
        $accountLinkObj->setDebitAccountId(1);
        $this->object->setDiscountAccountLink( $accountLinkObj );
        $this->object->setDiscount( $discount );

        $billId = $this->object->createBill();

        $billObj = new Financial_Model_Bill();
        $billItem = $billObj->findById( $billId );

        // Test billTransaction table
        $billTransObj = new Financial_Model_BillTransaction();
        $billTransItems = $billTransObj->findByKey( array('search'=>array('billId'=>$billId) ));

        // Test transaction table
        $transObj = new Financial_Model_Transaction();
        $transItems = $transObj->findById( $billTransItems[0]->getTransactionId() );
        $this->assertEquals( 1, count($transItems));

        // accountTransaction table
        $acctTransObj = new Financial_Model_AccountTransaction();
        $acctTransItems = $acctTransObj->findByKey( array('search'=>array('transactionId'=>$billTransItems[0]->getTransactionId() ) ));

        //var_dump( $acctTransItems[0] );
        $this->assertEquals( 4, count($acctTransItems));
        $this->assertEquals( 100, $acctTransItems[0]->getAmount());
        $this->assertEquals( '2010-05-01 00:00:00', $acctTransItems[0]->getDatePosted());
        $this->assertEquals( 'debit', $acctTransItems[0]->getSide());
        $this->assertEquals( 1, $acctTransItems[0]->getAccountId());

        $this->assertEquals( $discount, $acctTransItems[3]->getAmount());
        $this->assertEquals( '2010-05-01 00:00:00', $acctTransItems[3]->getDatePosted());
        $this->assertEquals( 'credit', $acctTransItems[3]->getSide());
        $this->assertEquals( 2, $acctTransItems[3]->getAccountId());
    }


    /**
     * Test the datePosted and different accountTransaction amount vs bill amount due
     */

    public function testCreateBillDifferentAccountAmountAndDatePosted()
    {
    	    

        $accountLinkObj = new Financial_Model_AccountLink();
        $accountLinkObj->setCreditAccountId(1);
        $accountLinkObj->setDebitAccountId(2);

        $this->object->setDueDate('2010-05-01');
        $this->object->setBillAmountDue(100);
        $this->object->setAccountLink( $accountLinkObj );
        $this->object->setDatePosted('2010-05-10');
        $this->object->setAccountingAmount(50);
        $billId = $this->object->createBill();

        $billObj = new Financial_Model_Bill();
        $billItem = $billObj->findById( $billId );

        // Test billTransaction table
        $billTransObj = new Financial_Model_BillTransaction();
        $billTransItems = $billTransObj->findByKey( array('search'=>array('billId'=>$billId) ));

        // Test transaction table
        $transObj = new Financial_Model_Transaction();
        $transItems = $transObj->findById( $billTransItems[0]->getTransactionId() );
        $this->assertEquals( 1, count($transItems));

        // accountTransaction table
        $acctTransObj = new Financial_Model_AccountTransaction();
        $acctTransItems = $acctTransObj->findByKey( array('search'=>array('transactionId'=>$billTransItems[0]->getTransactionId() ) ));

        //var_dump( $acctTransItems[0] );
        $this->assertEquals( 2, count($acctTransItems));
        $this->assertEquals( 50, $acctTransItems[0]->getAmount());
        $this->assertEquals( '2010-05-10 00:00:00', $acctTransItems[0]->getDatePosted());
        $this->assertEquals( 'debit', $acctTransItems[0]->getSide());
        $this->assertEquals( 2, $acctTransItems[0]->getAccountId());

        // Test bill table
        $this->assertEquals( 100, $billItem->getOriginalAmountDue());
        $this->assertEquals( '2010-05-01', $billItem->getDueDate());
        $this->assertEquals( 1, count($billTransItems));
    }


    /**
     *  Test setting the transactionId - has to use existing transactionId
     */
    public function testCreateBillTransactionIdSet()
    {
    	
        // loads transactionId 65
      //  $this->dSet->loadDataSet(APPLICATION_FAKESETS.'/accountTransactions.xml');

        $accountLinkObj = new Financial_Model_AccountLink();
        $accountLinkObj->setCreditAccountId(1);
        $accountLinkObj->setDebitAccountId(2);

        $this->object->setDueDate('2010-05-01');
        $this->object->setBillAmountDue(100);
        $this->object->setAccountLink( $accountLinkObj );
        $this->object->setTransactionId(65);
        $billId = $this->object->createBill();

        $billObj = new Financial_Model_Bill();
        $billItem = $billObj->findById( $billId );

        // Test billTransaction table
        $billTransObj = new Financial_Model_BillTransaction();
        $billTransItems = $billTransObj->findByKey( array('search'=>array('billId'=>$billId) ));

        // Test transaction table
        $transObj = new Financial_Model_Transaction();
        $transItems = $transObj->findById( $billTransItems[0]->getTransactionId() );
        $this->assertEquals( 65, $transItems->getId() );
        $this->assertEquals( 65, $billTransItems[0]->getTransactionId() );
    }
    
    private function loadData(){
	$this->dataSetStackBuffer = array( 'users'=>1, 'accountsAndLinks'=>1, 'accountTransactions'=>1  );	
	$this->loadDataSets();        
    }
}
