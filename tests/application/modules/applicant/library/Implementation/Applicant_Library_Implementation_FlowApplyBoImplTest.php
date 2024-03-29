<?php
/**
 * Test class for Applicant_Library_Implementation_FlowApplyBoImpl.
 * Generated by PHPUnit on 2010-12-23 at 19:03:33.
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package tests.application.modules.applicant.library.implementation
 */
class Applicant_Library_Implementation_FlowApplyBoImplTest extends ControllerTestCase
{
	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
	}

	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::tearDown()
	 */
	public function tearDown()
	{
		parent::tearDown();
	}
	
	public function testSetPayload()
	{
		$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$args = array('one'=>'two');
		$impl->setPayload($args);
		$this->assertEquals($args,$impl->getPayload(),'Payload does not match');
	}

	public function testValidateWorkflowStep()
	{
		$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$impl->setDao($dao);
		$this->assertTrue($impl->validateWorkflowStep(),'We should have True as a result');
		$impl->endFlow(array(null));
	}
	
	public function testValidateWorkflowStepDaoNotInitialized()
	{
		$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$impl->setDao($dao);
		$this->assertFalse($impl->validateWorkflowStep(),'We should have false as a result since we never initialized the master session');
	}

	public function testValidateWorkflowStepReturnsFalse()
	{
		$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$this->assertFalse($impl->validateWorkflowStep(),'We should have false as a result');
	}

	public function testMoveNext()
	{
		$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$impl->setDao($dao);
		$stub = array('identifier'=>'steps','data'=>array(0 =>array('page' => 'apply','url' => 'applicant/apply/index','complete' => true,'payload'  => array('unit'=>1,'apartment'=>1,'model'=>1),'current'=>true,'action'=>'','next'=> 'applicant/apply/aboutyou')));
		$saved = $impl->save($stub);
		$this->assertTrue($saved,'We should have a true response');
		$result = $impl->findByStepName('steps');
		$this->assertEquals($result[1]['current'],false);
		$this->assertEquals($stub['data'][0]['next'],$impl->moveNext(),'Move next did not match the expected next page');
		
		$impl->endFlow(array(null));
	}

	public function testMovePrevious()
	{
		$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$impl->setDao($dao);
		$stub = array('identifier'=>'steps','data'=>array(2=>array('page'=>'address',
									'url'=>'applicant/apply/currentaddress',
									'complete'=>null,
									'payload'=>null,
									'current'=>true,
									'action'=>null,
									'next'=>'applicant/apply/previousaddress',
									'prev' => 'applicant/apply/aboutyou')));
		$saved = $impl->save($stub);
		$this->assertTrue($saved,'We should have a true response');
		$result = $impl->findByStepName('steps');
		$this->assertEquals($impl->movePrevious(),$stub['data'][2]['prev'],'Move next did not match the expected previous page');
		$impl->endFlow(array(null));
	}
	
	/**
	 * @expectedException ErrorException
	 */
	public function testMovePreviousIllegalIndexThrowsErrorException()
	{
		$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$impl->setDao($dao);
		$stub = array(
						'identifier'=>'steps',
						'data'=>array(
									1=>array(
									'page'=>'aboutYou',
									'url' => 'applicant/apply/aboutyou',
									'complete'=>null,
									'payload'=>null,
									'current'=>null,
									'action'=>null,
									'next'=>'applicant/apply/currentaddress',
									'prev' => 'applicant/apply/index'
									)
						)
		);
		$saved = $impl->save($stub);
		$this->assertTrue($saved,'We should have a true response');
		$result = $impl->findByStepName('steps');
		$this->assertEquals($impl->movePrevious(),'applicant/apply/aboutyou','Move next did not match the expected previous page');
		$impl->endFlow(array(null));
	}
	
	public function testSave()
	{
		$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$impl->setDao($dao);
		$stub = array('identifier'=>'steps','data'=>array(0=>array('page' => 'apply','url' => 'applicant/apply/index',
									'complete' => true,
									'payload'  => array('unit'=>1,'apartment'=>1,'model'=>1),
									'current'  => true,
									'action'   => null,
									'next'     => 'applicant/apply/aboutyou')));
		$saved = $impl->save($stub);
		$this->assertTrue($saved,'We should have a true response');
		$result = $impl->findByStepName('steps');
		$this->assertEquals($result[0],$stub['data'][0],'We should have the same result');
		$impl->endFlow(array(null));
	}
	
	public function testSaveSimple()
	{
			$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$impl->setDao($dao);
		$stub = array('identifier'=>'unit','data'=>1);
		$saved = $impl->save($stub);
		$this->assertTrue($saved,'We should have a true response');
		$result = $impl->findByStepName('unit');
		$this->assertEquals(1,1,'We should have the same result');
		$impl->endFlow(array(null));
	}
	
	public function testHandleError()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
          'This test has not been implemented yet.'
          );
	}

	public function testFindByStepName()
	{
		$impl = new Applicant_Library_Implementation_FlowApplyBoImpl();
		$dao = new Applicant_Library_Implementation_FlowApplyDao();
		$dao->initPeristanceTemplate(array('sessionNamespace'=>'applicantApply'));
		$impl->setDao($dao);
		$stub = array('identifier'=>'steps','data'=>array('one'=>array('page' => 'apply','url' => 'applicant/apply/index',
									'complete' => true,
									'payload'  => array('unit'=>1,'apartment'=>1,'model'=>1),
									'current'  => true,
									'action'   => null,
									'next'     => 'applicant/apply/aboutyou')));
		$saved = $impl->save($stub);
		$this->assertTrue($saved,'We should have a true response');
		$result = $impl->findByStepName('steps');
	}
}
?>
