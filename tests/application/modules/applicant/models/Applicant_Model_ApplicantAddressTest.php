<?php
/**
 * Test class for Applicant_Model_ApplicantAddress.
 */
class Applicant_Model_ApplicantAddressTest extends ControllerTestCase {
	
	/* (non-PHPdoc)
	 * @see tests/application/ControllerTestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->dataSetStackBuffer = array('users'=>1);
		$this->loadDataSets();
	}

	public function tearDown()
	{
		$this->unLoadDataSets();
		parent::tearDown();
	}

	/**
	 *  Test for saving applicant addres info
	 */
	public function testApplicantAddressPass() {
		
		// user id is created from session info so not testing here cause it will fail on the check
		$args = array(
		 	'applicantId'=>1,
			'address'=>'test',
			'city'=>'test',
			'state'=>'TX',
			'rent'=>123.12,
			'apartmentName'=>'crappy apartment',
			'ownerName'=>'scum lord',
			'apartmentPhone'=>'123456789',
			'moveInDate'=>'2000-01-01',
			'moveOutDate'=>'2004-01-01',
			'reasonForLeaving'=>'dumb neighbors',
			'isCurrentResidence'=>1
		);
		$api = new Applicant_Model_Address($args);
		$saved=$api->save();
		$this->assertTrue($saved!=false,'Fail while trying to save');
		$api = array_shift($api->fetchAll());
		$this->assertEquals($args['applicantId'],$api->getApplicantId(),'User id failed');
		$this->assertEquals($args['address'],$api->getAddress(),'Address failed');
		$this->assertEquals($args['city'],$api->getCity(),'City failed');
		$this->assertEquals($args['state'],$api->getState(),'State failed');
		//		$this->assertEquals($args['zip'],$api->get,'Zip failed');
		$this->assertEquals($args['rent'],$api->getRent(),'Rent failed');
		$this->assertEquals($args['apartmentName'],$api->getApartmentName(),'Apartment Name failed');
		$this->assertEquals($args['ownerName'],$api->getOwnerName(),'Owner Name failed');
		$this->assertEquals($args['moveInDate'],$api->getMoveInDate(),'Move In Date failed');
		$this->assertEquals($args['moveOutDate'],$api->getMoveOutDate(),'Move Out Date failed');
		$this->assertEquals($args['reasonForLeaving'],$api->getReasonForLeaving(),'Reason For Leaving failed');
		$this->assertEquals($args['isCurrentResidence'],$api->getIsCurrentResidence(),'IsCurrentResidence failed');
	}
}
?>