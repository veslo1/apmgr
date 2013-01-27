<?php
/**
 * Test class for Applicant_Model_ApplicantWorkHistory.
 */
class Applicant_Model_ApplicantWorkHistoryTest extends ControllerTestCase {
    
    /* (non-PHPdoc)
     * @see tests/application/ControllerTestCase::setUp()
     */
    public function setUp() {
        parent::setUp();
        $this->object = new Unit_Model_Unit();
        $this->dataSetStackBuffer = array('users'=>1);
		$this->loadDataSets();
    }

    /* (non-PHPdoc)
     * @see tests/application/ControllerTestCase::tearDown()
     */
    public function tearDown()
    {
    	$this->unLoadDataSets();
        parent::tearDown();
    }

    /**
     *  Test for saving applicant work info
     */
    public function testApplicantWorkHistoryPass() {
    	


        // user id is created from session info so not testing here cause it will fail on the check
        $args = array(
                'applicantId'=>1,
                'employerName'=>'crappy employer',
                'address'=>'test',
                'city'=>'test',
                'state'=>'TX',
                'zip'=>'12345',
                'employerPhone'=>'1234567890',
                'monthlyIncome'=>123.12,
                'dateStarted'=>'2004-01-01',
                'dateEnded'=>'2005-01-01',
                'supervisorName'=>'scum boss',
                'supervisorPhone'=>'1234567890',
                'isCurrentEmployer'=>1
        );
        $api = new Applicant_Model_WorkHistory($args);
        $this->assertEquals($args['applicantId'],$api->getApplicantId(),'Applicant id failed');
        $this->assertEquals($args['employerName'],$api->getEmployerName(),'Employer Name failed');
        $this->assertEquals($args['address'],$api->getAddress(),'Address failed');
        $this->assertEquals($args['city'],$api->getCity(),'City failed');
        $this->assertEquals($args['state'],$api->getState(),'State failed');
        $this->assertEquals($args['zip'],$api->getZip(),'Zip failed');
        $this->assertEquals($args['employerPhone'],$api->getEmployerPhone(),'Employer Phone Failed');
        $this->assertEquals($args['monthlyIncome'],$api->getMonthlyIncome(),'Monthly Income failed');
        $this->assertEquals($args['dateStarted'],$api->getDateStarted(),'Date started failed');
        $this->assertEquals($args['dateEnded'],$api->getDateEnded(),'Date ended failed');
        $this->assertEquals($args['supervisorName'],$api->getSupervisorName(),'Supervisor Name failed');
        $this->assertEquals($args['supervisorPhone'],$api->getSupervisorPhone(),'Supervisor Phone Failed');
        $this->assertEquals($args['isCurrentEmployer'],$api->getIsCurrentEmployer(),'isCurrentEmployer Failed');
        $saved = $api->save();
        $this->assertTrue($saved!=false,'Fail while trying to save');
        $api = array_shift($api->fetchAll());
        $this->assertTrue(count($api)>0,'Count failed');
    }

    /**
     *  Test for saving applicant work info
     */
    public function testNoEndDate() {
    	

        // user id is created from session info so not testing here cause it will fail on the check
        $args = array(
                'applicantId'=>1,
                'employerName'=>'crappy employer',
                'address'=>'test',
                'city'=>'test',
                'state'=>'TX',
                'zip'=>'12345',
                'employerPhone'=>'1234567890',
                'monthlyIncome'=>123.12,
                'dateStarted'=>'2004-01-01',
                'supervisorName'=>'scum boss',
                'supervisorPhone'=>'1234567890',
                'isCurrentEmployer'=>1
        );
        $api = new Applicant_Model_WorkHistory($args);
        $saved = $api->save();
        $data = $api->findById($saved);
        $this->assertEquals($data->getDateEnded(),null,'Date ended failed');
    }
}
?>