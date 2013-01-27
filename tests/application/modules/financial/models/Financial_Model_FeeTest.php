<?php
class Financial_Model_FeeTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
	$this->loadData();
        $this->object = new Financial_Model_Fee();
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

    public function testGetName()
    {
    	
        $this->object->setName( 'test' );
        $this->assertEquals( 'test',$this->object->getName());
    }

    public function testGetAmount()
    {
    	
        $this->object->setAmount( 111 );
        $this->assertEquals( 111,$this->object->getAmount());
    }

    public function testGetDebitAccountId()
    {
    	
        $this->object->setDebitAccountId( 1 );
        $this->assertEquals( 1,$this->object->getDebitAccountId());
    }

    public function testGetCreditAccountId()
    {
    	
        $this->object->setCreditAccountId( 1 );
        $this->assertEquals( 1,$this->object->getCreditAccountId());
    }

    public function testSetEnabled()
    {
    	
    	$this->object->setEnabled(1);
        $this->assertEquals( 1,$this->object->getEnabled());
    }

    public function testSetRefundable()
    {
    	
    	$this->object->setRefundable(1);
        $this->assertEquals( 1,$this->object->getRefundable());
    }

    public function testGetFeeAndAccount()
    {
    	
        //$this->loadData();
        $results= $this->object->getFeeAndAccount();


         //  [0]=>
         //     array(5) {
         //       ["amount"]=>
         //       string(5) "50.00"
         //       ["id"]=>
         //       string(1) "2"
         //       ["name"]=>
         //       string(9) "deposit2 "
         //       ["debitName"]=>
         //       string(6) "account1 "
         //       ["creditName"]=>
         //       string(5) "account2 "
        $this->assertEquals( 30.00, $results[0]['amount']);
        $this->assertEquals( 'fee1', trim($results[0]['name']));
        $this->assertEquals( 'account1',trim($results[0]['debitName']));
        $this->assertEquals( 'account2',trim($results[0]['creditName']));
    }

    public function testGetAccountLink()
    {
    	
        //$this->loadData();

        $this->object->setCreditAccountId( 4 );
        $this->object->setDebitAccountId( 3 );

        $al = $this->object->getAccountLink();

        $this->assertEquals( 4, $al->getCreditAccountId(4) );
        $this->assertEquals( 3, $al->getDebitAccountId(3) );
    }

    private function loadData(){
	$this->dataSetStackBuffer = array( 'accountsAndLinks'=>1, 'depositsAndFees'=>1 );	
	$this->loadDataSets();        
    }
     
}
