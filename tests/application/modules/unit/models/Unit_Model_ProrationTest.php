<?php

// 	phpunit -configuration phpunit.xml
// phpunit --no-configuration --bootstrap application/bootstrap.php application/modules/unit/models/Unit_Model_ProrationTest.php

class Unit_Model_ProrationTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();
		$this->object = new Unit_Model_Proration();
	}

	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#tearDown()
	 */
	public function tearDown()
	{
		parent::tearDown();
	}

	public function testGetMoveInDate()
	{
		
		$this->object->setBaseRentAmount( 500 );
		$this->object->setMoveInDate( date('2010-05-01') );

		$this->assertEquals( date('2010-05-01'), $this->object->getMoveInDate());
	}

	/**
	 *  Comparing floating point in phpunit error:  http://www.phpunit.de/ticket/390
	 */
	public function testCalculateRentProrationThirtyDay()
	{
		
		$this->object->setBaseRentAmount( 500 );
		$this->object->setMoveInDate( '2010-05-02' );
		$this->object->getRentSettings()->setProrationType('thirtyday');

		$prorated = $this->object->calculateRentProration();
		$this->assertEquals( 483.43, $prorated,'',0.001);
	}

	public function testCalculateRentProrationActual()
	{
		
		$this->object->setBaseRentAmount( 500 );
		$this->object->setMoveInDate( '2010-07-02' );
		$this->object->getRentSettings()->setProrationType('actual');

		$prorated = $this->object->calculateRentProration();
		$this->assertEquals( 483.90, $prorated);
	}

	public function testCalculateRentProrationYear()
	{
		
		$this->object->setBaseRentAmount( 500 );
		$this->object->setMoveInDate( '2010-09-02' );
		$this->object->getRentSettings()->setProrationType('year');

		$prorated = $this->object->calculateRentProration();
		$this->assertEquals( 476.76,$prorated,'',0.001);
	}

	public function testCalculateRentProrationLeapYear()
	{
		
		$this->object->setBaseRentAmount( 500 );
		$this->object->setMoveInDate( '2012-09-02' );
		$this->object->getRentSettings()->setProrationType('year');

		$prorated = $this->object->calculateRentProration();
		$this->assertEquals( 475.31, $prorated,'',0.001);
	}

	public function testGetAmountDue_ProrationDisabled()
	{
		
		$this->object->setBaseRentAmount( 500 );
		$this->object->setMoveInDate( '2010-05-02' );
		$this->object->getRentSettings()->setProrationType('thirtyday');
		$this->object->getRentSettings()->setProrationEnabled( 0 );

		$amountDue = $this->object->getAmountDue();
		$this->assertEquals( $this->object->getBaseRentAmount(), $amountDue);
		//return $this->assertEquals( 483.43, $prorated);
	}

	public function testGetAmountDue_RentDueDayEqual()
	{
		
		$this->object->setBaseRentAmount( 500 );
		$this->object->setMoveInDate( '2010-05-01' );
		$this->object->getRentSettings()->setProrationType('thirtyday');
		$this->object->getRentSettings()->setRentDueDay( 1 );
		$this->object->getRentSettings()->setProrationEnabled( 1 );

		$amountDue = $this->object->getAmountDue();
		$this->assertEquals( $this->object->getBaseRentAmount(), $amountDue);
	}

	public function testGetAmountDue_MonthSequenceThree()
	{
		
		$this->object->setBaseRentAmount( 500 );
		$this->object->setMoveInDate( '2010-05-02' );
		$this->object->getRentSettings()->setProrationType('thirtyday');
		$this->object->getRentSettings()->setRentDueDay( 1 );
		$this->object->getRentSettings()->setProrationEnabled( 1 );
		$this->object->setMonthSequence( 3 );
		$this->object->getRentSettings()->setProrationApplyMonth(2);


		$amountDue = $this->object->getAmountDue();
		$this->assertEquals( $this->object->getBaseRentAmount(), $amountDue);
	}

	/**
	 *  Tests if every condition is met that the prorated amount is returned
	 */
	public function testGetAmountDue_ProrationEnabled()
	{
		
		$this->object->setBaseRentAmount( 500 );
		$this->object->setMoveInDate( '2010-05-02' );
		$this->object->getRentSettings()->setProrationType('thirtyday');
		$this->object->getRentSettings()->setRentDueDay( 1 );
		$this->object->getRentSettings()->setProrationEnabled( 1 );
		$this->object->setMonthSequence( 2 );
		$this->object->getRentSettings()->setProrationApplyMonth(2);


		$amountDue = $this->object->getAmountDue();
		$this->assertEquals( 483.43,$amountDue,'',0.001);		
	}

}