<?php
/**
 * Test class for User_CreateController.
 * Generated by PHPUnit on 2010-12-26 at 07:09:42.
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package tests.application.modules.user.controllers
 */
class User_ViewControllerTest extends ControllerTestCase
{
	/* (non-PHPdoc)
	 * @see Framework/PHPUnit_Framework_TestCase::setUp()
	 */
	public function setUp()
	{
		parent::setUp();
		$this->dataSetStackBuffer = array('users'=>1);
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

	public function testIndexAction()
	{
		$this->login('jvazquez','Test1234');
		$this->dispatch('user/view/index/id/1');
//		print $this->getResponse()->getBody();
	}
}
?>
