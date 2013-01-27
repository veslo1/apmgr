<?php

// 	phpunit --configuration phpunit.xml
// phpunit --config phpunit.xml --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_LeaseDepositTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost


class Unit_Model_LeaseFeeTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();
		$this->loadData();
		$this->login('jvazquez', 'Test1234'); // sets the userId in the session
		$this->object = new Unit_Model_LeaseFee();
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

	public function testGetLeaseId()
	{
		
		$this->object->setLeaseId(1);
		$this->assertEquals(1,$this->object->getLeaseId());
	}

	public function testGetFeeId()
	{
		
		$this->object->setFeeId(1);
		$this->assertEquals(1,$this->object->getFeeId());
	}

	public function testGetAmount()
	{
		
		$this->object->setAmount(111.11);
		$this->assertEquals(111.11,$this->object->getAmount());
	}

	public function testGetBillId()
	{
		
		$this->object->setBillId(1);
		$this->assertEquals(1,$this->object->getBillId());
	}

	public function testGetDueDate()
	{
		
		$this->object->setDueDate('2010-05-01');
		$this->assertEquals('2010-05-01',$this->object->getDueDate());
	}

	/**
	 *   Tests that the lease deposit creation created ok with valid parameters
	 *   Requirements to run the test:  A valid lease and apartment exist
	 *
	 */
	public function testLeaseFeeCreation()
	{
		

		$this->object->setLeaseId( 1 );
		$this->object->setFeeId( 1 );
		$this->object->setDueDate( '2010-01-01' );
		$id = $this->object->createLeaseFee();

		$item = $this->object->findById( $id );

		$feeObj = new Financial_Model_Fee();
		$feeItem = $feeObj->findById(1);

		// deposit is tested in the Deposit class so won't retest all the accounting and bill tables here for the bill creation
		$this->assertEquals( 1, $item->getLeaseId());
		$this->assertEquals( 1, $item->getFeeId());
		$this->assertEquals( $feeItem->getAmount(), $item->getAmount() );
	}

	public function testGetLeaseFees()
	{
		$this->markTestSkipped("This is calling a non existent method");
		$this->object->setLeaseId( 1 );
		$results = $this->object->getLeaseFees();

		$this->assertEquals( 1, count($results));
		$this->assertEquals( trim('fee1'), trim($results[0]['name']));
		$this->assertEquals( 30, $results[0]['amount']);
		$this->assertEquals( 5, $results[0]['billId']);
	}

	private function loadData(){
		$this->dataSetStackBuffer = array( 'users'=>1,
					       'accountsAndLinks'=>1,
					       'depositsAndFees'=>1,
					       'apartmentsUnitsAndModels'=>1,
					       'bills'=>1,
					       'leases'=>1,
		);
		$this->loadDataSets();
	}

}