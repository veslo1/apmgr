<?php
class Applicant_Library_LeaseAgent_ControllerHelperTest extends ControllerTestCase {

    /* (non-PHPdoc)
     * @see Framework/PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp() {
    	parent::setUp();
    	$this->dataSetStackBuffer = array('users'=>1,'applicantApply'=>0,'applicantStatus'=>1);
		$this->loadDataSets();
    }


    /* (non-PHPdoc)
     * @see Framework/PHPUnit_Framework_TestCase::tearDown()
     */
    public function tearDown() {
    	$this->unLoadDataSets();
    	parent::tearDown();
    }
    
    /**
     * Prototype for controller validation.
     * When we send this parameters to the controller , the library will let us pass
     */
    public function testCompletedAppsValidation(){
    	
    	$request = array('module'=>'applicant','controller'=>'view','action'=>'completedapps','id'=>1,'persist'=>1,'page'=>'about');
    	$leaseAgentHelper = new Applicant_Library_LeaseAgent_ControllerHelper();
    	$result = $leaseAgentHelper->completedAppsValidation($request);
    	$this->assertTrue($result,'completedAppsValidation returned false');
    }
    
    /**
     * When the controller does not provides the id we should fail with the given id
     */
    public function testCompletedAppsValidationDisplaysErrorForMissingId(){
    	
    	$request = array('module'=>'applicant','controller'=>'view','action'=>'completedapps','persist'=>1,'page'=>'about');
    	$leaseAgentHelper = new Applicant_Library_LeaseAgent_ControllerHelper();
    	$result = $leaseAgentHelper->completedAppsValidation($request);
    	$this->assertFalse($result,'completedAppsValidation returned true when it should have failed');
    	$this->assertEquals('applicantIdMissing', $leaseAgentHelper->getMessageState(),'Validation message should indicate that the applicantId is missing');
    }
    
    public function testCompletedAppsValidatesFakeApplicantId(){
    	
    	$request = array('module'=>'applicant','controller'=>'view','action'=>'completedapps','persist'=>1,'id'=>'88','page'=>'about');
    	$leaseAgentHelper = new Applicant_Library_LeaseAgent_ControllerHelper();
    	$result = $leaseAgentHelper->completedAppsValidation($request);
    	$this->assertFalse($result,'completedAppsValidation returned true when it should have failed');
    	$this->assertEquals('applicantIdNotValid', $leaseAgentHelper->getMessageState(),'Message state should be that the applicantId is missing');
    }
    
    public function testCompletedAppsValidatesFakePageName(){
    	
    	$request = array('module'=>'applicant','controller'=>'view','action'=>'completedapps','persist'=>1,'id'=>'1','page'=>'fugooFish');
    	$leaseAgentHelper = new Applicant_Library_LeaseAgent_ControllerHelper();
    	$result = $leaseAgentHelper->completedAppsValidation($request);
    	$this->assertFalse($result,'completedAppsValidation returned true when it should have failed');
    	$this->assertEquals('invalidForm', $leaseAgentHelper->getMessageState(),'Message state should state that the page requested does not exists');	
    }
}
?>
