<?php
class Financial_Model_AccountLinkTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
	$this->loadData();
        $this->object = new Financial_Model_AccountLink();
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
    	
        $this->object->setName('test');
        $this->assertEquals('test',$this->object->getName());
    }

    public function testGetDebitAccountId()
    {
    	
        $this->object->setDebitAccountId('1');
        $this->assertEquals('1',$this->object->getDebitAccountId());
    }

    public function testGetCreditAccountId()
    {
    	
        $this->object->setCreditAccountId('2');
        $this->assertEquals('2',$this->object->getCreditAccountId());
    }

    /**
     *  Tests that the number of records returned is correct
     */
    public function testFetchAllAccountLinks()
    {
    	       
        $results = $this->object->fetchAllAccountLinks();

        // make sure row 1 is returned
        $row = ($results[0]['id']==1)?  $results[0]  :  $results[1] ;

        $this->assertEquals('5', count($results) );
        $this->assertEquals('1', $row['id'] );
        $this->assertEquals('testAccountLink1', $row['name'] );
        $this->assertEquals('account1', $row['debitName'] );
        $this->assertEquals('account2', $row['creditName'] );
    }    
    
    private function loadData(){
	$this->dataSetStackBuffer = array( 'accountsAndLinks'=>1 );	
	$this->loadDataSets();        
    }
}