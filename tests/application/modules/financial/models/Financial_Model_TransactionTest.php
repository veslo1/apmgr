<?php
class Financial_Model_PaymentTransactionTest extends ControllerTestCase {

	protected $object;
	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#setUp()
	 */
	public function setUp() {
		parent::setUp();
		$this->dataSetStackBuffer = array( 'users'=>1 );	
	        $this->loadDataSets();        
		$this->login('jvazquez','Test1234');
	}

	/**
	 * (non-PHPdoc)
	 * @see tests/application/ControllerTestCase#tearDown()
	 */
	public function tearDown() {
		$this->logout();
		parent::tearDown();
	}

	public function testGetUserId()
	{
		
		$this->object = new Financial_Model_Transaction();
		$this->object->setUserId( 1 );
		$this->assertEquals( 1, $this->object->getUserId());
	}

	public function testGetComment()
	{
		
		$this->object = new Financial_Model_Transaction();
		$this->object->setComment( 'test' );
		$this->assertEquals( 'test', $this->object->getComment());
	}

	public function testGetAction()
	{
		
		$this->object = new Financial_Model_Transaction();
		$this->object->setAction( 'action' );
		$this->assertEquals( 'action', $this->object->getAction());
	}
}
?>
