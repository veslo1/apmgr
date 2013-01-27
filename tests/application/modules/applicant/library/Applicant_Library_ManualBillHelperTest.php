<?php
/**
 *  Manual Bill Helper tests
 *
 *  phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/application/library/Applicant_Library_ManualBillHelperTest.php
 */
class Applicant_Library_ManualBillHelperTest extends ControllerTestCase
{
	/**
	 * @var Applicant_Library_ManualBillHelper
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */	
	public function setUp()
	{
		parent::setUp();
		$this->dataSetStackBuffer = array('users'=>1,'accountsAndLinks'=>1,'depositsAndFees'=>1,'bills'=>1, 'ApplicantPayment'=>1,'setting'=>1);
		$this->loadDataSets();
		$this->login('jvazquez', 'Test1234'); // sets the userId in the session
		$this->object = new Applicant_Library_ManualBillHelper;
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
	 *  tests wrapper for payment helper's getPaidFees
	 */
	public function testPaidFees()
	{
		
		$result = $this->object->getPaidFees(12);		 
		$this->assertType('array', $result,'We did not retrieve an array as a result');
		$this->assertGreaterThanOrEqual(0, count($result),'We should have at least 1 element');
		$this->assertFalse( empty($result)==true ,'The array is empty');
	}
		
	/**
	 *  Test fetchManualBillsToPay	 
	 */	
	public function testFetchManualBillsToPay()
	{
		
		$applicantId = 10; 
		$fees = $this->object->fetchManualBillsToPay( $applicantId );		
		$this->assertEquals( 1, count($fees) );		
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
		$bills = array( 0=>array('billId'=>20, 'currentAmountDue'=>10, 'debitAccountId'=>1));
		$preleaseBills = array(0=>array( 'billId'=>23, 'currentAmountDue'=>10, 'debitAccountId'=>1));						
		$result = $this->object->payBills( $paymentInfo, $bills, $preleaseBills );		
		$this->assertTrue( $result );
	}	
}
?>
