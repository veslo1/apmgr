<?php
//  phpunit --config phpunit.xml --bootstrap application/bootstrap.php application/modules/applicant/models/Applicant_Model_PreleaseTest.php
// mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost
class Applicant_Model_PreleaseTest extends ControllerTestCase {
	/**
	 * @var Applicant_Model_Prelease
	 */
	protected $object;

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->object = new Applicant_Model_Prelease();
		$this->dataSetStackBuffer = array('users'=>1,'accountsAndLinks'=>1, 'accountTransactions'=>1 , 'depositsAndFees'=>1,'bills'=>1, 'apartmentsUnitsAndModels'=>1,'preleaseFees'=>1);
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
	
	public function testSetFeeId()
	{
		
		$this->object->setFeeId(1);
		$this->assertEquals(1, $this->object->getFeeId(),'Setter failed for feeId');
	}
	
	public function testSetBillId()
	{
		
		$this->object->setBillId(2);
		$this->assertEquals(2, $this->object->getBillId(),'Setter failed for billId');
	}
	
	public function testAmount()
	{
		
		$this->object->setAmount(20);
		$this->assertEquals(20, $this->object->getAmount(),'Setter failed for amount');
	}
	
	public function testFetchPreleaseFees() {
		$this->object->setApplicantId(9);
		$result = $this->object->fetchPreleaseFees();
		$this->assertEquals(1, count($result),'testFetchPreleaseFees Failed');
	}
	
	public function testFetchManualBillsToPay() {		
		$this->object->setApplicantId(13);
		$result = $this->object->fetchManualBillsToPay();
		$this->assertEquals(1, count($result),'testFetchManualBillsToPay Failed');		
	}
	
	public function testFetchPreleaseFeeByUser() {				
		$users = array('11'=>'userone','12'=>'usertwo');
		$unitId = 1;
		$result = $this->object->fetchPreleaseFeeByUser($users,$unitId);
		$this->assertEquals(4, count($result),'testFetchPreleaseFeeByUser Failed');		
	}	
}
?>