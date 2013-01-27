<?php
//  phpunit --config phpunit.xml --bootstrap application/bootstrap.php application/modules/financial/library/Financial_Library_RefundHelperTest.php
//  mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost

/**
 *  Tests the refund helper that calculates the amount allowed to refund/forfeit
 *  
 */
class Financial_Library_RefundHelperTest extends ControllerTestCase {

    protected $object;
    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#setUp()
     */
    public function setUp() {
        parent::setUp();
	$this->loadData();
	//$this->login('jvazquez', 'Test1234'); // sets the userId in the session
        $this->object = new Financial_Library_RefundHelper();
    }

    /**
     * (non-PHPdoc)
     * @see tests/application/ControllerTestCase#tearDown()
     */
    public function tearDown() {
//	$this->unLoadDataSets();
    	parent::tearDown();	
    }
    
    public function testFetchMaxAmount()
    {
    	               
	$billId = 14;
        $result = $this->object->fetchMaxAmount( $billId );
        $this->assertEquals(50,$result);                
    }
    
    public function testFetchMaxAmountNegative()
    {
    	               
	$billId = 15;
        $result = $this->object->fetchMaxAmount( $billId );
        $this->assertEquals(0,$result);                
    } 
    
    private function loadData(){
	$this->dataSetStackBuffer = array('users'=>1,
					  'accountsAndLinks'=>1,
					  'accountTransactions'=>1,
					  'depositsAndFees'=>1,
					  'bills'=>1,
					  'billTransfers'=>1,
					  'paymentDetails'=>1,
					  'payments'=>1,				
					  'refunds'=>1);	
	$this->loadDataSets();
    }
}

