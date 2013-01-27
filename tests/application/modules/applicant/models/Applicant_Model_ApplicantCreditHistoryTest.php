<?php
/**
 * Test class for Applicant_Model_ApplicantCreditHistory.
 */
class Applicant_Model_ApplicantCreditHistoryTest extends ControllerTestCase {
	/**
	 * @var DatabaseFlatXmlSeed object
	 */
	protected $dSet;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	public function tearDown() {
		parent::tearDown();
	}

	/**
	 *  Test for saving credit history info
	 */
	public function testApplicantCreditHistoryPass() {
		
		$this->db->query('TRUNCATE applicantCreditHistory');
		$this->dSet->setSeed(APPLICATION_FAKESETS.'/users.xml');
		$this->dSet->getSetUpOperation();
		// user id is created from session info so not testing here cause it will fail on the check
		$args = array(
			'applicantId'=>1,
			'bankName'=>'first bank of fraud',
			'address'=>'test',
			'city'=>'test',
			'state'=>'TX',
			'zip'=>'12345',
			'creditCards'=>'visa, amex',
			'nonWorkIncome'=>'drug running',
			'creditProblems'=>'yep');
		$api = new Applicant_Model_CreditHistory($args);
		$saved=$api->save();
		$this->assertTrue($saved!=false,'Fail while trying to save');
		$api = array_shift($api->fetchAll());
		$this->assertEquals($args['applicantId'],$api->getApplicantId(),'User id failed');
		$this->assertEquals($args['bankName'],$api->getBankName(),'Bank Name failed');
		$this->assertEquals($args['address'],$api->getAddress(),'Address failed');
		$this->assertEquals($args['city'],$api->getCity(),'City failed');
		$this->assertEquals($args['state'],$api->getState(),'State failed');
		$this->assertEquals($args['zip'],$api->getZip(),'Zip failed');
		$this->assertEquals($args['creditCards'],$api->getCreditCards(),'Credit Cards Failed');
		$this->assertEquals($args['nonWorkIncome'],$api->getNonWorkIncome(),'Non-Work Income failed');
		$this->assertEquals($args['creditProblems'],$api->getCreditProblems(),'Credit problems failed');
	}
}
?>
