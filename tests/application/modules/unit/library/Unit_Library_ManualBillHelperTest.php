<?php
/**
 *  Manual Bill Helper tests
 *
 *  phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/library/Unit_Library_ManualBillHelperTest.php
 */
class Unit_Library_ManualBillHelperTest extends ControllerTestCase
{
	/**
	 * @var Unit_Library_ManualBillHelper
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */	
	public function setUp()
	{
		parent::setUp();
		$this->dataSetStackBuffer = array( 'users'=>1,					            					       
					       'accountsAndLinks'=>1,
					       'accountTransactions'=>1,
					       'depositsAndFees'=>1,
					       'apartmentsUnitsAndModels'=>1,
					       'bills'=>1,
					       'leases'=>1,					      
					      );	
	        $this->loadDataSets();          				
		$this->login('jvazquez', 'Test1234'); // sets the userId in the session
		$this->object = new Unit_Library_ManualBillHelper;
	}
	
	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */	
	public function tearDown()
	{
		$this->unLoadDataSets();
		parent::tearDown();
		unset($this->object);
	}
	
	/**
	 *  Test getBillSum	 
	 */	
	public function testGetBillSum()
	{
		
		$billArray = array( 0=>array('billId'=>20,
					     'currentAmountDue'=>100),
				    1=>array('billId'=>20,
					     'currentAmountDue'=>10)); // should sum to 110 = 10 + 100
		$preleaseBillArray = array( 0=>array('billId'=>20,
					     'currentAmountDue'=>100),
				    1=>array('billId'=>20,
					     'currentAmountDue'=>10)); // should sum to 110 = 10 + 100
		$sum = $this->object->getBillSum($billArray, $preleaseBillArray);
		$this->assertEquals( 220, $sum );			
	}
	
	/**
	 *  Test payBills	 
	 */	
	public function testPayBills()
	{
		
		$paymentInfo = array( 'paymentType'=>'cash', 'totalAmount'=>20.00, 'payor'=>'me' );
		$rentBills = array( 0=>array('billId'=>24, 'currentAmountDue'=>10, 'debitAccountId'=>1));
		$leaseFeesBills = array(0=>array( 'billId'=>25, 'currentAmountDue'=>10, 'debitAccountId'=>1));						
		$result = $this->object->payBills( $paymentInfo, $rentBills, $leaseFeesBills );		
		$this->assertTrue( $result );
	}
	
	/**
	 *  Test fetchLeaseFeesToPay	 
	 */	
	public function testFetchLeaseFeesToPay()
	{
		
		$leaseId = 11; 
		$fees = $this->object->fetchLeaseFeesToPay( $leaseId );		
		$this->assertEquals( 1, count($fees) );		
	}
	
	/**
	 *  Test fetchLeaseRentToPay 
	 */	
	public function testFetchLeaseRentToPay()
	{
		
		$leaseId = 11; 
		$fees = $this->object->fetchLeaseRentToPay( $leaseId );		
		$this->assertEquals( 1, count($fees) );		
	}	
}
?>
