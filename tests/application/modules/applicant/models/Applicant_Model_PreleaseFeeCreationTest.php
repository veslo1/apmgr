<?php
//  phpunit --config phpunit.xml --bootstrap application/bootstrap.php application/modules/applicant/models/Applicant_Model_PreleaseFeeCreationTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost
class Applicant_Model_PreleaseFeeCreationTest extends ControllerTestCase {
	/**
	 * @var Applicant_Model_PreleaseFeeCreation
	 */
	protected $object;

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->object = new Applicant_Model_PreleaseFeeCreation();
		$this->dataSetStackBuffer = array('users'=>1,'accountsAndLinks'=>1, 'accountTransactions'=>1 , 'depositsAndFees'=>1,'bills'=>1,'ApplicantPayment'=>1, 'preleaseFees'=>1);
		$this->loadDataSets();
	}

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::tearDown()
	 */
	public function tearDown()
	{
		$this->unLoadDataSets();
		parent::tearDown();
	}

	public function testSetApplicantId()
	{
		
		$this->object->setApplicantId(1);
		$this->assertEquals(1, $this->object->getApplicantId(),'Setter for applicantId failed');
	}

	public function testGetApplicantId()
	{
		
		$this->object->setApplicantId(1);
		$this->assertEquals(1, $this->object->getApplicantId(),'Getter for applicantId failed');
	}

	public function testSetFeeId()
	{
		
		$this->object->setFeeId(1);
		$this->assertEquals(1, $this->object->getFeeId(),'Setter failed for feeId');
	}

	public function testGetFeeId()
	{
		
		$this->object->setFeeId(1);
		$this->assertEquals(1, $this->object->getFeeId(),'Getter failed for feeId');
	}

	public function testSetDueDate()
	{
		
		$this->object->setDueDate('10/13/2010');
		$this->assertEquals('10/13/2010', $this->object->getDueDate(),'Setter failed for setDueDate');
	}

	public function testGetDueDate()
	{
		
		$this->object->setDueDate('10/13/2010');
		$this->assertEquals('10/13/2010', $this->object->getDueDate(),'Getter failed for setDueDate');
	}

	public function testSetFeeBillIdToApply()
	{
		
		$this->object->setFeeBillIdToApply(2);
		$this->assertEquals(2, $this->object->getFeeBillIdToApply(),'Setter failed for setFeeBillIdToApply');
	}

	public function testGetFeeBillIdToApply()
	{
		
		$this->object->setFeeBillIdToApply(2);
		$this->assertEquals(2, $this->object->getFeeBillIdToApply(),'Getter failed for setFeeBillIdToApply');
	}

        public function testCreatePreleaseFailCheckTransferAmount()
	{
		//	Please, verify that, the feeId i have is the 1, and will put the fee 16, please confirm
		
		$this->login('jvazquez','Test1234');
		$this->object->setApplicantId(9);
		$this->object->setFeeId(16);
		$this->object->setFeeBillIdToApply(10);
		$this->object->setDueDate('2010-10-13');
		$result = $this->object->createPreleaseFee();
		$this->assertFalse($result,'The createPreleaseFee operation failed');
	}
	
	public function testCreatePreleaseFailCheckBillApplication()
	{
		//	Please, verify that, the feeId i have is the 1, and will put the fee 16, please confirm
		
		$this->login('jvazquez','Test1234');
		$this->object->setApplicantId(9);
		$this->object->setFeeId(16);
		$this->object->setFeeBillIdToApply(11);
		$this->object->setDueDate('2010-10-13');
		$result = $this->object->createPreleaseFee();
		$this->assertFalse($result,'The createPreleaseFee operation failed');
	}

        public function testCreatePreleaseFeeNoApply()
	{
		//	Please, verify that, the feeId i have is the 1, and will put the fee 16, please confirm
		
		$this->login('jvazquez','Test1234');
		$this->object->setApplicantId(9);
		$this->object->setFeeId(16);
		$this->object->setDueDate('2010-10-13');
		$result = $this->object->createPreleaseFee();
		$this->assertTrue($result,'The createPreleaseFee operation failed');
	}

	public function testCreatePreleaseFee()
	{
		//	Please, verify that, the feeId i have is the 1, and will put the fee 16, please confirm
		
		$this->login('jvazquez','Test1234');
		$this->object->setApplicantId(9);
		$this->object->setFeeId(16);
		$this->object->setDueDate('2010-10-13');
		$this->object->setFeeBillIdToApply(9);
		$result = $this->object->createPreleaseFee();
		$this->assertTrue($result,'The createPreleaseFee operation failed');
	}
}
?>