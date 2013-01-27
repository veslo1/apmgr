<?php
/**
 * Test class for Applicant_Library_Implementation_FlowStepBo.
 * Generated by PHPUnit on 2010-12-24 at 03:25:22.
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package tests.application.modules.applicant.library.implementation
 */
class Applicant_Library_Implementation_FlowStepBoTest extends ControllerTestCase
{
	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->dataSetStackBuffer = array('users'=>1,'applicantApply'=>0,'accountsAndLinks'=>1,'depositsAndFees'=>1,'bills'=>1,'applicantStatus'=>1);
		$this->loadDataSets();
	}

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::tearDown()
	 */
	public function tearDown()
	{
		Zend_Session::namespaceUnset('applicantApply');
		$this->unLoadDataSets();
		parent::tearDown();
	}

	public function testapplyuserValidate()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('unit'=>1,'apartment'=>1,'model'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertTrue($result,'Result must be true');
	}

	public function testapplyuserValidateMissingAllArgs()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		//    	$bo->setPayload(array('unit'=>1,'apartment'=>1,'model'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertFalse($result,'Result must be false due to missing required args');
		$this->assertEquals($impl->getMessageState(),'missingArguments');
	}

	public function testValidateUnit()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('unit'=>1,'apartment'=>1,'model'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertTrue($result,'Result must be true');
	}

	public function testValidateMissingUnit()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('apartment'=>1,'model'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertFalse($result,'Result must be false');
		$this->assertEquals('unitIdMissing',$impl->getMessageState());
	}

	public function testValidateApartment()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('unit'=>1,'apartment'=>1,'model'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertTrue($result,'Result must be true');
	}


	public function testValidateApartmentFakeId()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('unit'=>1,'apartment'=>88,'model'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertFalse($result,'Result must be false');
		$bo->setPayload(array('unit'=>1,'model'=>1));
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertFalse($result,'Result must be false');
	}


	public function testValidateModel()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('unit'=>1,'apartment'=>1,'model'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertTrue($result,'Result must be true');
		$bo->setPayload(array('unit'=>1,'apartment'=>1));
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertFalse($result,'Result must be false');
		$bo->setPayload(array('unit'=>1,'apartment'=>1,'model'=>1999));
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertFalse($result,'Result must be false');
	}

	public function testGetIndexStepForm()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('unit'=>1,'apartment'=>1,'model'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$form = $impl->getIndexStepForm();
		$this->assertNotNull($form,'Form must not be null');
	}

	public function testGetIndexStepFormValidates()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('unit'=>1,'model'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertFalse($result,'Result must be false');
		$this->assertTrue($impl->getIsError(),'We should have an error');
		$form = $impl->getIndexStepForm();
		$this->assertNull($form,'Form should be null');
	}

	public function testIndexActionWithAccount()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('unit'=>1,'apartment'=>1,'model'=>1,'haveaccount'=>1));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertTrue($result,'Result must be true');
		$result = $impl->indexAction();
		$this->assertTrue($result,'We should have a true statement result');
		$buffer = $bo->findByStepName('steps');
		$this->assertEquals('applicant/apply/applyuser',$buffer[0]['action'],'Actions should match');
		$this->assertEquals(true,$buffer[0]['current'],'Actions should match');
		$this->assertEquals(false,$buffer[0]['complete'],'Actions should match');
		$bo->endFlow(array(null));
	}

	public function testIndexActionWithNoAccount()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$bo->setPayload(array('unit'=>1,'apartment'=>1,'model'=>1,'haveaccount'=>0));
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$result = $impl->indexValidate();
		$this->assertTrue($result,'Result must be true');
		$result = $impl->indexAction();
		$this->assertTrue($result,'We should have a true statement result');
		$buffer = $bo->findByStepName('steps');
		$this->assertEquals('user/join/index',$buffer[0]['action'],'Actions should match');
		$this->assertEquals(true,$buffer[0]['current'],'Actions should match');
		$this->assertEquals(false,$buffer[0]['complete'],'Actions should match');
		$bo->endFlow(array(null));
	}

	public function testapplyuserValidateWithNoSession()
	{
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$valid = $impl->applyuserValidate();
		$this->assertFalse($valid,'We should not have a valid state at this point');
		$this->assertEquals('noApplicantSessionDetected',$impl->getMessageState(),'The message state should indicate that we do not have a session started');
	}

	/**
	 * In this test , we will initiate the session , but we will inject into it that the current step is 4, the business object should
	 * fail and inform us that we are not valid
	 */
	public function testapplyuserValidateWithSessionButNotCurrentStep()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		//	Inject into the DAO the dummy package , simulating that the current step active is the 4
		$stub = $bo->findByStepName('steps');
		$stub[4]['current'] = true;
		$result = $bo->save(array('identifier'=>'steps','data'=>array(4=>$stub[4])));
		$this->assertTrue($result,'Failed to create the dummy package');
		$buffer = $bo->findByStepName('steps');
		$this->assertEquals(14,count($buffer),'We should have the same amount of elements');
		$this->assertEquals($buffer[4]['current'],true,'It should match since we just updated it');
		$result = $impl->applyuserValidate();
		$this->assertFalse($result,'Apply validate should fail at this point');
		$this->assertEquals('currentStepNotValid',$impl->getMessageState(),'The message should indicate that the given work flow step is not the current one');
		$bo->endFlow(array(null));
	}

	public function testGetApplyUserForm()
	{
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setIsError(false);
		$form = $impl->getApplyUserStepForm();
		$this->assertNotNull($form,'Form should not be null');
	}

	public function testValidFlowGetApplyUserForm()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		//	Inject into the DAO the dummy package , simulating that the current step active is the 4
		$stub = $bo->findByStepName('steps');
		$stub[0]['current'] = true;
		$result = $bo->save(array('identifier'=>'steps','data'=>array(0=>$stub[0])));
		$this->assertTrue($result,'Failed to create the dummy package');
		$buffer = $bo->findByStepName('steps');
		$this->assertEquals(14,count($buffer),'We should have the same amount of elements');
		$this->assertEquals($buffer[0]['current'],true,'It should match since we just updated it');
		$result = $impl->applyuserValidate();
		$this->assertTrue($result,'Apply validate should pass at this point:'.$impl->getMessageState());
		$form = $impl->getApplyUserStepForm();
		$this->assertNotNull($form,'The form is properly set and should not be null');
		$bo->endFlow(array(null));
	}

	public function testApplyUserActionWithFakeUser()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$bo->setPayload(array('username'=>'John','password'=>'Test1234','emailAddress'=>'foo@net.com'));
		$impl->applyuserAction();
		$this->assertEquals($impl->getMessageState(),'invalidCredentials','The message should indicate that the given user is not valid');
	}

	public function testApplyUserActionWithValidUser()
	{
		$bo = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$bo->setDao($dao);
		//	Inject into the DAO the dummy package , simulating that the current step active is the 4
		$stub = $bo->findByStepName('steps');
		$stub[0]['current'] = true;
		$result = $bo->save(array('identifier'=>'steps','data'=>array(0=>$stub[0])));
		$this->assertTrue($result,'Failed to create the dummy package');
		$buffer = $bo->findByStepName('steps');
		$this->assertEquals(14,count($buffer),'We should have the same amount of elements');
		$this->assertEquals($buffer[0]['current'],true,'It should match since we just updated it');
		
		$impl = new Applicant_Library_Implementation_FlowStepBo();
		$impl->setBo($bo);
		$bo->setPayload(array('username'=>'applicant','password'=>'Test1234','emailAddress'=>'applicant@debserverp4.com.ar'));
		$result = $impl->applyuserAction();
		$this->assertEquals('applicant/apply/aboutyou',$bo->moveNext());
		$this->assertEquals($result!=false,'Applicant account should be set');
		$bo->endFlow(array(null));
	}
}
?>
