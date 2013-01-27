<?php
//  phpunit --config phpunit.xml --bootstrap application/bootstrap.php application/modules/financial/models/Financial_Model_RefundTest.php
//  mysqldump -udev -pdev --opt --complete-insert --add-drop-table apmgr | mysql -udev -pdev -C apmgr_tests -h localhost

class Applicant_Model_ApplicantWorkflowStatusTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->dataSetStackBuffer = array('users'=>1,'applicantStatus'=>1);
		$this->loadDataSets();
		$this->object = new Applicant_Model_ApplicantWorkflowStatus();
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

	public function testGetApplicantId()
	{
		
		$id = 1;
		$this->object->setApplicantId( $id );
		$this->assertEquals( $id,$this->object->getApplicantId());
	}

	public function testGetApplicantStatusId()
	{
		
		$id = 1;
		$this->object->setApplicantStatusId( $id );
		$this->assertEquals( $id,$this->object->getApplicantStatusId());
	}

	public function testGetUserId()
	{
		
		$id = 1;
		$this->object->setUserId( $id );
		$this->assertEquals( $id,$this->object->getUserId());
	}

	public function testGetComment()
	{
		
		$id = 1;
		$this->object->setComment( $id );
		$this->assertEquals( $id,$this->object->getComment());
	}

	public function testGetCurrentStatus()
	{
		
		$id = 1;
		$this->object->setCurrentStatus( $id );
		$this->assertEquals( $id,$this->object->getCurrentStatus());
	}

	public function testGetCurrentApplicantStatus(){
		
		$id = 2;
		$this->object->setApplicantId(1);
		$result = $this->object->getCurrentApplicantStatus();
		$this->assertEquals( $id,$result['id'] );
	}

	public function testSaveStatus(){
		
		$args = array('applicantId'=>1,'applicantStatusId'=>1,'comment'=>'blah');
		$this->login('jvazquez','Test1234');
		$wfStatus = new Applicant_Model_ApplicantWorkflowStatus( $args );
		$result = $wfStatus->saveStatus();
		$this->assertNotEquals( false,$result );
	}

}
