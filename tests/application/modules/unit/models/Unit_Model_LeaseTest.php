<?php
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost
class Unit_Model_LeaseTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();
		$this->loadData();
		$this->login('jvazquez', 'Test1234'); // sets the userId in the session
		$this->object = new Unit_Model_Lease();
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

	public function testGetLeaseStartDate()
	{
		
		$this->object->setLeaseStartDate('2010-05-01');
		$this->assertEquals('2010-05-01',$this->object->getLeaseStartDate());
	}

	public function testGetLeaseEndDate()
	{
		
		$this->object->setLeaseEndDate('2010-05-01');
		$this->assertEquals('2010-05-01',$this->object->getLeaseEndDate());
	}

	public function testGetLastDay()
	{
		
		$this->object->setLastDay('2010-05-01');
		$this->assertEquals('2010-05-01',$this->object->getLastDay());
	}

	public function testGetUnitId()
	{
		
		$this->object->setUnitId(1);
		$this->assertEquals(1,$this->object->getUnitId());
	}

	public function testGetApartmentId()
	{
		
		$this->object->setApartmentId(1);
		$this->assertEquals(1,$this->object->getApartmentId());
	}

	public function testGetModelRentScheduleId()
	{
		
		$this->object->setModelRentScheduleId(1);
		$this->assertEquals(1,$this->object->getModelRentScheduleId());
	}

	public function testGetModelRentScheduleItemId()
	{
		
		$this->object->setModelRentScheduleItemId(1);
		$this->assertEquals(1,$this->object->getModelRentScheduleItemId());
	}

	public function testGetUserId()
	{
		
		$this->object->setUserId(1);
		$this->assertEquals(1,$this->object->getUserId());
	}

	public function testGetIsCancelled()
	{
		
		$this->object->setIsCancelled(1);
		$this->assertEquals(1,$this->object->getIsCancelled());
	}

	public function testGetCancellationDate()
	{
		
		$this->object->setCancellationDate('2010-05-01');
		$this->assertEquals('2010-05-01',$this->object->getCancellationDate());
	}

	public function testFetchCurrentPendingLeases()
	{
		

		// in the data file 1 row should appear
		$this->object->setUnitId( 1 );
		$results = $this->object->fetchCurrentPendingLeases();
		$this->assertEquals( 3, count($results) );

		// tests expired lease - should not appear
		$this->object->setUnitId( 2 );
		$results = $this->object->fetchCurrentPendingLeases();
		$this->assertEquals( 1, count($results) );

		// tests cancelled lease - should not appear
		$this->object->setUnitId( 3 );
		$results = $this->object->fetchCurrentPendingLeases();
		$this->assertEquals( 1, count($results) );  // 2 leases for unit 3 - one cancelled and one in the future
	}

	public function testFetchLeaseHistory()
	{
		

		// in the data file 1 row should not appear
		$this->object->setUnitId( 1 );
		$results = $this->object->fetchLeaseHistory();
		$this->assertEquals( 0, count($results) );

		// tests expired lease - should appear
		$this->object->setUnitId( 2 );
		$results = $this->object->fetchLeaseHistory();
		$this->assertEquals( 1, count($results) );

		// tests cancelled lease - should appear
		$this->object->setUnitId( 3 );
		$results = $this->object->fetchLeaseHistory();
		$this->assertEquals( 1, count($results) );
	}


	// Uses lease id  for testing cancellation
	// test for saved transaction record
	// test for amount due of the bill sent to each side of the accountTransaction
	// if bill has discount,the amount on each side of the transaction is bill amount due + discount
	// also if discount another transaction is set to the discount tables

	public function testCancelLease()
	{
		

		$this->object->setId( 6 );
		$result = $this->object->cancelLease();

		$leaseInfo = $this->object->findById( 6 );

		// should return 2 records (bills 3 and 4.  1 isn't returned beacause it is past the due date.  2 isn't returned because it has been paid off)
		$at = new Financial_Model_AccountTransaction();
		$account1 = $at->findByKey( array( 'search'=>array( 'accountId'=>6 ) ) ); // the account link (leaseCancellationRentPortion) should have account 6 and 7 tied to it
		//var_dump( $account1 ); die;
		$this->assertEquals(2, count($account1));

		$account2 = $at->findByKey( array( 'search'=>array( 'accountId'=>7 ) ) ); // the account link (leaseCancellationRentPortion) should have account 6 and 7 tied to it
		$this->assertEquals(2, count($account2));

		// *THIS* - the above asserts print fine - the records are there...  the next two do not run correctly for some reason.  The data prints fine in accountTransaction test though...
		// lease cancellation debit account + any discount
		$at->setAccountId( 6 ); // should be (50 + 75) bill amounts refunded + (15) for discount
		$this->assertEquals(125+15, $at->getBalance(),'',.001 );

		// lease cancellation credit account + any discount
		$at->setAccountId( 7 ); // should be (50 + 75) bill amounts refunded + (15) for discount
		$this->assertEquals(125+15, $at->getBalance(),'',.001 );

		// lease cancellation discount debit account
		$at->setAccountId( 8 ); // should be (15) for discount
		$this->assertEquals(15, $at->getBalance(),'',.001 );

		// lease cancellation discount debit account
		$at->setAccountId( 9 ); // should be (15) for discount
		$this->assertEquals(15, $at->getBalance(),'',.001 );

		$this->assertEquals(1, $leaseInfo->getIsCancelled() );
		$this->assertEquals( date("y-m-d"), date( "y-m-d", strtotime($leaseInfo->getCancellationDate())) );
		$this->assertEquals( '2111-05-01 00:00:00', $leaseInfo->getLastDay() );
	}

	private function loadData(){
		$this->dataSetStackBuffer = array( 'users'=>1,
					       'accountsAndLinks'=>1,
					       'accountTransactions'=>1,
					       'depositsAndFees'=>1,
					       'apartmentsUnitsAndModels'=>1,
					       'bills'=>1,
					       'leases'=>1,
			
		);
		$this->loadDataSets();
	}

}
?>