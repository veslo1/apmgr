<?php
class Financial_Model_AccountTransactionTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();       
	$this->loadData();
	$this->login('jvazquez', 'Test1234'); // sets the userId in the session
        $this->object = new Financial_Model_AccountTransaction();
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

    public function testGetDatePosted()
    {
    	
        $this->object->setDatePosted('2010-5-10');
        $this->assertEquals( '2010-5-10',$this->object->getDatePosted());
    }

    public function testGetAccountId()
    {
    	
        $this->object->setAccountId('1');
        $this->assertEquals('1',$this->object->getAccountId());
    }

    public function testGetTransactionId()
    {
    	
        $this->object->setTransactionId('2');
        $this->assertEquals('2',$this->object->getTransactionId());
    }

    public function testGetSide()
    {
    	
        $this->object->setSide('debit');
        $this->assertEquals('debit',$this->object->getSide());
    }

    public function testGetAmount()
    {
    	
        $this->object->setAmount('100.11');
        $this->assertEquals('100.11',$this->object->getAmount());
    }

    /**
     *  Used for saving an accountTransaction.
     *  Needs an accountLink to work
     */

    public function testSaveAccountTransaction()
    {
    		

        $al = new Financial_Model_AccountLink();
        $al->setCreditAccountId( 1 );
	$al->setDebitAccountId( 2 );

	$this->object->setAmount( 100 );
	$this->object->setComment( 'test' );
	$this->object->setDatePosted( '2010-05-10' );
	$this->object->setAccountLink( $al );
        $result = $this->object->saveAccountTransaction();

        $this->assertEquals(true,$result);
    }

    // Transaction 1 used for testing get accountTransaction

    public function testGetAccountTransactions()
    {
    	       

         // set the object
         $this->object->setTransactionId(1);

         //  call the function and test the results
         $results = $this->object->getAccountTransactions();
         $this->assertEquals('2', count($results) );

        // make sure row 1 is returned
        $row = ($results[0]['id']==1)? $results[0] : $results[1];

        $this->assertEquals('1', $row['id'] );
        $this->assertEquals(111.11, $row['amount'] );
        $this->assertEquals('2010-05-01 00:00:00', $row['datePosted'] );
        $this->assertEquals(1, $row['accountId'] );
        $this->assertEquals(1, $row['transactionId'] );
        $this->assertEquals('debit', $row['side'] );
        $this->assertEquals('account1', $row['accountName'] );
    }

     //  Multiple tests needed for this

    public function testGetAccountTransactionsWithAccount()
    {
    	
        
         // set the object
         $this->object->setTransactionId(1);
         $this->object->setAccountId(1);

         //  call the function and test the results
         $results = $this->object->getAccountTransactions();
         $this->assertEquals('1', count($results) );

          // make sure row 1 is returned
        $row = $results[0];

        $this->assertEquals('1', $row['id'] );
        $this->assertEquals(111.11, $row['amount'] );
        $this->assertEquals('2010-05-01 00:00:00', $row['datePosted'] );
        $this->assertEquals(1, $row['accountId'] );
        $this->assertEquals(1, $row['transactionId'] );
        $this->assertEquals('debit', $row['side'] );
        $this->assertEquals('account1', $row['accountName'] );
    }

    // TransactionId = 2 records are used for the debit and credit calculations

    public function testGetBalance()
    {
    	       

        $this->object->setAccountId(2);
        $this->object->setTransactionId(null);
        $result = $this->object->getBalance();

        // TODO:  *PUT HERE* - load flat files with known data and test against
         $this->assertEquals( 145.46, $result );
    }

    private function loadData(){
	$this->dataSetStackBuffer = array( 'users'=>1, 'accountsAndLinks'=>1, 'accountTransactions'=>1 );	
	$this->loadDataSets();        
    }

}
